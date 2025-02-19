<div class="container">
    <h1>Tickets de {{ $user->name }} {{ $user->last_name }}</h1>

    <!-- Formulario de filtro -->
    <form method="GET" action="{{ route('tickets.usuarios.tickets', $user->id) }}" class="mb-4">
        <div class="row">
            <div class="col-md-3">
                <label for="fecha_inicio">Fecha de inicio de pago:</label>
                <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" 
                    value="{{ request('fecha_inicio') }}">
            </div>
            <div class="col-md-3">
                <label for="fecha_fin">Fecha de fin de pago:</label>
                <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" 
                    value="{{ request('fecha_fin') }}">
            </div>
            <div class="col-md-3">
                <label for="evento_fecha_inicio">Fecha de inicio del evento:</label>
                <input type="date" name="evento_fecha_inicio" id="evento_fecha_inicio" class="form-control" 
                    value="{{ request('evento_fecha_inicio') }}">
            </div>
            <div class="col-md-3">
                <label for="evento_fecha_fin">Fecha de fin del evento:</label>
                <input type="date" name="evento_fecha_fin" id="evento_fecha_fin" class="form-control" 
                    value="{{ request('evento_fecha_fin') }}">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2">Filtrar</button>
                <a href="{{ route('tickets.usuarios.tickets', $user->id) }}" class="btn btn-secondary">Eliminar Filtros</a>
            </div>
        </div>
    </form>

    @if($tickets->isEmpty())
        <p>No hay tickets para este usuario.</p>
    @else
        <div class="row">
            @foreach($tickets as $ticket)
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Evento: {{ $ticket->evento->nombre }}</h5>
                            <p><strong>Fecha del Evento:</strong> {{ \Carbon\Carbon::parse($ticket->evento->fecha_evento)->format('d/m/y') }}</p>
                            <p><strong>Asiento:</strong> {{ $ticket->asiento->id }}</p>
                            <p><strong>Plan:</strong> {{ $ticket->plan->tipo }}</p>
                            <p><strong>Pagado:</strong> {{ $ticket->pagado ? 'Sí' : 'No' }}</p>
                            <p><strong>Fecha de pago:</strong> {{ \Carbon\Carbon::parse($ticket->fecha_pago)->format('d/m/y') }}</p>
                            <p><strong>QR Válido:</strong> {{ $ticket->qr_valido ? 'Sí' : 'No' }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>