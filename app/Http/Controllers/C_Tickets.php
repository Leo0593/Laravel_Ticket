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

use Illuminate\Support\Str;
use Laravel\Pail\ValueObjects\Origin\Console;

class C_Tickets extends Controller
{
    public function index(): View
    {
        $eventos = M_Eventos::all();
        $tickets = M_Tickets::with('evento', 'plan')->get();
        $noTickets = $tickets->isEmpty();

        return view('layouts.tickets.V_todoslostickets', compact('eventos', 'tickets', 'noTickets'));
    }

    public function create(): View
    {
        $users = User::all();
        $asientos = M_Asientos::all();
        $planes = M_Plan::all();
        $eventos = M_Eventos::all();

        return view('layouts.tickets.V_agregarticket', compact('users', 'asientos', 'planes', 'eventos'));
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'user_id' => 'required|integer',
                'asiento_id' => 'required|integer',
                'plan_id' => 'required|integer',
                'evento_id' => 'required|integer',
                'qr' => 'nullable|string|max:255',
                'qr_valido' => 'nullable|boolean', // Permitir que 'qr_valido' sea NULL o booleano
            ]);


            // Asegura que 'pagado' tenga un valor de 0 (no pagado) si no se proporciona
            $validated['pagado'] = $validated['pagado'] ?? 0; // Valor por defecto si no está presente

            // Si no se proporciona un valor para 'qr', asigna uno por defecto
            $validated['qr'] = $validated['qr'] ?? Str::uuid()->toString(); // Asigna un UUID único

            // Si no se proporciona un valor para 'qr_valido', asigna 0 por defecto
            $validated['qr_valido'] = $validated['qr_valido'] ?? 0;

            //dd($validated);
            $ticket = M_Tickets::create($validated);

            return redirect()->route('tickets.index')->with('success', 'Ticket creado exitosamente.');
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->withErrors(['error' => 'Hubo un problema al crear el ticket.']);
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

    public function userTickets($userId)
    {
        $user = User::findOrFail($userId);
        $tickets = M_Tickets::byUser($userId)->with(['evento', 'plan', 'asiento'])->get();
        
        return view('layouts.tickets.user_tickets', compact('user', 'tickets'));
    }


}
