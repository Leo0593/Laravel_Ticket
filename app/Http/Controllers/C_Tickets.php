<?php

namespace App\Http\Controllers;

use App\Models\M_Tickets;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

use App\Models\User;
use App\Models\M_Asientos;
use App\Models\M_Plan;

class C_Tickets extends Controller
{
    public function index(): View
    {
        $tickets = M_Tickets::all();
        $noTickets = $tickets->isEmpty();

        return view('layouts.tickets.V_todoslostickets', compact('tickets', 'noTickets'));
    }

    public function create(): View
    {
        $users = User::all();
        $asientos = M_Asientos::all();
        $planes = M_Plan::all();

        return view('layouts.tickets.V_agregarticket', compact('users', 'asientos', 'planes'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => 'required|integer',
            'asiento_id' => 'required|integer',
            'plan_id' => 'required|integer',
            'pagado' => 'required|boolean',
            'fecha_pago' => 'required|date',
            'qr' => 'required|string|max:255',
            'qr_valido' => 'required|boolean',
        ]);

        try {
            M_Tickets::create($validated);

            return redirect()->route('tickets.index')->with('success', 'Ticket creado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Hubo un problema al crear el ticket.']);
        }
    }
}
