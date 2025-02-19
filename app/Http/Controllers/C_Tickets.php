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

use Illuminate\Support\Str;

class C_Tickets extends Controller
{
    public function index(): View
    {
        $eventos = M_Eventos::all();
        $tickets = M_Tickets::with('evento', 'plan')->get();
        $noTickets = $tickets->isEmpty();

        return view('layouts.tickets.V_todoslostickets', compact('eventos', 'tickets', 'noTickets'));
    }

    public function mostrarTicket($id, $codigo)
    {
        // Buscar el ticket por ID
        $ticket = M_Tickets::find($id);

        // Verificar si el ticket existe y el código QR coincide
        if ($ticket && $ticket->qr === $codigo) {
            return view('V_tickets', compact('ticket'));
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

            \Log::info('Redirigiendo a:', [
                'url' => route('ticket.mostrar', ['id' => $ticket->id, 'codigo' => $ticket->qr])
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


}
