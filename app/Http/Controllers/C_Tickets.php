<?php

namespace App\Http\Controllers;

use App\Models\M_Tickets;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

use App\Models\User;
use App\Models\M_Asientos;
use App\Models\M_Plan;
use App\Models\M_Eventos;
use Illuminate\Support\Facades\Auth;

use Barryvdh\DomPDF\Facade\Pdf;

use App\Mail\TicketPDFMail;
use Illuminate\Support\Facades\Mail;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class C_Tickets extends Controller
{
    public function index(Request $request): View
    {
        // Obtener valores de los filtros de la solicitud
        $nombreEvento = $request->input('nombre_evento');
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');
        $estadoEvento = $request->input('estado');

        // Consulta base de eventos
        $eventos = M_Eventos::query();

        // Filtro por nombre de evento
        if ($nombreEvento) {
            $eventos->where('nombre', 'LIKE', "%{$nombreEvento}%");
        }

        // Filtro por estado del evento
        if ($estadoEvento) {
            $eventos->where('estado', $estadoEvento);
        }

        $eventos = $eventos->get();

        // Consulta base de tickets
        $tickets = M_Tickets::with('evento', 'plan')->whereHas('evento', function ($query) use ($fechaInicio, $fechaFin) {
            // Filtrar por rango de fechas si se proporciona
            if ($fechaInicio && $fechaFin) {
                $query->whereBetween('fecha_evento', [$fechaInicio, $fechaFin]);
            }
        })->get();

        $noTickets = $tickets->isEmpty();

        return view('layouts.tickets.V_todoslostickets', compact('eventos', 'tickets', 'noTickets'));
    }


    public function mostrarTicket($id, $codigo)
    {
        // Buscar el ticket por ID
        $ticket = M_Tickets::find($id);

        // Verificar si el ticket existe y el código QR coincide
        if ($ticket && $ticket->qr === $codigo) {
            return view('layouts.tickets.V_ticket', compact('ticket'));
        } else {
            return redirect()->route('error.page')->with('error', 'Ticket no válido o código incorrecto.');
        }
    }


    public function create(): View
    {
        $users = User::all();
        $asientos = M_Asientos::all();
        $planes = M_Plan::all();
        $eventos = M_Eventos::all();

        return view('layouts.tickets.V_agregarticket', compact('users', 'asientos', 'planes', 'eventos'));
    }

    public function store(Request $request)
    {
        try {
            \Log::info('Datos recibidos:', $request->all());

            $validated = $request->validate([
                'user_id' => 'required|integer|exists:users,id',
                'evento_id' => 'required|integer|exists:eventos,id',
                'asiento_id' => 'required|integer|exists:asientos,id',
                'plan_id' => 'required|integer|exists:plans,id',
                'qr' => 'nullable|string|max:255',
                'qr_valido' => 'nullable|boolean',
                'pagado' => 'nullable|boolean',
            ]);

            \Log::info('Datos validados:', $validated);

            $validated['pagado'] = $validated['pagado'] ?? 0;
            $validated['fecha_pago'] = now();

            // Crear un código QR único para este ticket
            $codigo = chr(rand(65, 90)) . rand(100000000, 999999999);
            $validated['qr'] = $codigo;
            $validated['qr_valido'] = $validated['qr_valido'] ?? 0;

            // Generar el QR en base64
            $qrCode = new QrCode($codigo);
            $writer = new PngWriter();
            $result = $writer->write($qrCode);
            $base64QrCode = base64_encode($result->getString());

            // Guardar el código QR en formato base64 en qr_log
            $validated['qr_log'] = 'data:image/png;base64,' . $base64QrCode;

            \Log::info('Creando ticket con datos:', $validated);

            // Crear el ticket
            $ticket = M_Tickets::create($validated);

            // Actualizar el estado del asiento a 'ocupado'
            \DB::table('asientos')
                ->where('id', $validated['asiento_id'])
                ->update(['estado' => 'Ocupado']);

            \Log::info('Ticket creado:', $ticket->toArray());

            return response()->json([
                'success' => true,
                'ticket' => $ticket,
            ]);

            // Notar que el siguiente código no se ejecutará
            \Log::info('Redirigiendo a:', [
                'url' => route('tickets.ticket.mostrar', ['id' => $ticket->id, 'codigo' => $ticket->qr])
            ]);

            return redirect()->route('ticket.mostrar', ['id' => $ticket->id, 'codigo' => $ticket->qr])
                ->with('success', 'Ticket creado y asiento actualizado con éxito.');
        } catch (\Exception $e) {
            \Log::error("Error al crear el ticket: " . $e->getMessage(), [
                'stack' => $e->getTraceAsString(),
                'data' => $request->all(),
            ]);
            return response()->json([
                'success' => false,
                'error' => 'Error al crear el ticket. Inténtelo de nuevo.',
            ], 500);
        }
    }

    public function getAsientosByEvento($eventoId)
    {
        $asientos = M_Asientos::where('Evento_id', $eventoId)
            ->where('Estado', 'Disponible')
            ->get();

        if ($asientos->isEmpty()) {
            return response()->json(['message' => 'No hay asientos disponibles'], 404);
        }

        return response()->json(['asientos' => $asientos]);
    }

    public function getPlanesByEvento($eventoId)
    {
        $planes = M_Plan::where('Evento_id', $eventoId)->get();

        return response()->json([
            'planes' => $planes,
            'message' => $planes->isEmpty() ? 'No hay planes disponibles' : 'Planes encontrados'
        ]);
    }

    public function userTickets(Request $request)
    {
        // Obtener el usuario autenticado
        $user = Auth::user();

        // Si no hay usuario autenticado, redirigir o lanzar un error
        if (!$user) {
            abort(403, 'No tienes permiso para acceder a esta página.');
        }

        // Filtrar solo los tickets del usuario autenticado
        $query = M_Tickets::where('user_id', $user->id)->with(['evento', 'plan', 'asiento']);

        // Filtrar por fecha de pago
        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            $query->whereBetween('fecha_pago', [$request->fecha_inicio, $request->fecha_fin]);
        } elseif ($request->filled('fecha_inicio')) {
            $query->whereDate('fecha_pago', '>=', $request->fecha_inicio);
        } elseif ($request->filled('fecha_fin')) {
            $query->whereDate('fecha_pago', '<=', $request->fecha_fin);
        }

        // Filtrar por fecha del evento
        if ($request->filled('evento_fecha_inicio') && $request->filled('evento_fecha_fin')) {
            $query->whereHas('evento', function ($q) use ($request) {
                $q->whereBetween('fecha_evento', [$request->evento_fecha_inicio, $request->evento_fecha_fin]);
            });
        } elseif ($request->filled('evento_fecha_inicio')) {
            $query->whereHas('evento', function ($q) use ($request) {
                $q->whereDate('fecha_evento', '>=', $request->evento_fecha_inicio);
            });
        } elseif ($request->filled('evento_fecha_fin')) {
            $query->whereHas('evento', function ($q) use ($request) {
                $q->whereDate('fecha_evento', '<=', $request->evento_fecha_fin);
            });
        }

        $tickets = $query->get();

        return view('layouts.tickets.user_tickets', compact('user', 'tickets'));
    }

    public function TicketsTotalUser(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        $query = M_Tickets::where('user_id', $userId)->with(['evento', 'plan', 'asiento']);

        // Filtrar por fecha de pago
        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            $query->whereBetween('fecha_pago', [$request->fecha_inicio, $request->fecha_fin]);
        } elseif ($request->filled('fecha_inicio')) {
            $query->whereDate('fecha_pago', '>=', $request->fecha_inicio);
        } elseif ($request->filled('fecha_fin')) {
            $query->whereDate('fecha_pago', '<=', $request->fecha_fin);
        }

        // Filtrar por fecha del evento
        if ($request->filled('evento_fecha_inicio') && $request->filled('evento_fecha_fin')) {
            $query->whereHas('evento', function ($q) use ($request) {
                $q->whereBetween('fecha_evento', [$request->evento_fecha_inicio, $request->evento_fecha_fin]);
            });
        } elseif ($request->filled('evento_fecha_inicio')) {
            $query->whereHas('evento', function ($q) use ($request) {
                $q->whereDate('fecha_evento', '>=', $request->evento_fecha_inicio);
            });
        } elseif ($request->filled('evento_fecha_fin')) {
            $query->whereHas('evento', function ($q) use ($request) {
                $q->whereDate('fecha_evento', '<=', $request->evento_fecha_fin);
            });
        }

        $tickets = $query->get();

        return view('layouts.tickets.V_Total_Ticket', compact('user', 'tickets'));
    }

    public function misTickets()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $tickets = M_Tickets::where('user_id', auth()->id())
            ->with(['evento', 'asiento', 'plan'])
            ->get();

        return view('dashboard', compact('tickets'));  // Usa compact para pasar la variable
    }

    public function downloadPDF($id)
    {
        // Obtener el ticket con su relación al usuario
        $ticket = M_Tickets::with(['evento', 'asiento', 'plan', 'user'])->findOrFail($id);

        // Generar el PDF
        $pdf = Pdf::loadView('layouts.tickets.ticketPDF', compact('ticket'));

        // Verificar si el ticket tiene un usuario asociado con un email válido
        if ($ticket->user && $ticket->user->email) {
            Mail::to($ticket->user->email)->send(new TicketPDFMail($ticket));
        }

        // Descargar el PDF en el dispositivo
        return $pdf->download('ticket_' . $ticket->id . '.pdf');
    }


    public function printTicket($id)
    {
        $ticket = M_Tickets::with(['evento', 'asiento', 'plan'])->findOrFail($id);

        return view('layouts.tickets.ticketPrint', compact('ticket'));
    }


    //CODIGOS OPCIONALES DE ENVIO POR CORREO Y DESCARGA SEPARADOS 
    public function sendTicket($id)
    {
        // Obtener el ticket con su relación al usuario
        $ticket = M_Tickets::with(['evento', 'asiento', 'plan', 'user'])->findOrFail($id);

        // Verificar si el ticket tiene un usuario asociado
        if (!$ticket->user || !$ticket->user->email) {
            return response()->json(['message' => 'No se encontró un correo electrónico válido para el usuario.'], 400);
        }

        // Obtener el correo del usuario asociado al ticket
        $recipientEmail = $ticket->user->email;

        // Generar el PDF
        $pdf = Pdf::loadView('layouts.tickets.ticketPDF', compact('ticket'));

        // Enviar el correo con el ticket en PDF
        Mail::to($recipientEmail)->send(new TicketPDFMail($ticket));

        // Retornar una respuesta
        return response()->json(['message' => 'Ticket enviado por correo.']);
    }

    //ticket fusion

    public function downloadPDF1234($id)
    {
        $ticket = M_Tickets::with(['evento', 'asiento', 'plan'])->findOrFail($id);

        $pdf = Pdf::loadView('layouts.tickets.ticketPDF', compact('ticket'));

        return $pdf->download('ticket_' . $ticket->id . '.pdf');
    }

    public function verificarQr(Request $request, $codigo)
    {
        $ticket = M_Tickets::where('qr', $codigo)->first();

        if ($ticket) {
            if ($ticket->qr_valido == 1) {
                // Cambia el estado a "no válido"
                $ticket->qr_valido = 0;
                $ticket->save();

                return response()->json(['success' => true, 'message' => 'Código QR verificado y marcado como no válido.']);
            } else {
                return response()->json(['success' => false, 'message' => 'Código QR ya utilizado.']);
            }
        }

        return response()->json(['success' => false, 'message' => 'Código QR no válido.']);
    }


}
