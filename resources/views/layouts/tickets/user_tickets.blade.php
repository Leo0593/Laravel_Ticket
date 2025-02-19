
    <div class="container">
        <h1>Tickets de {{ $user->name }} {{ $user->last_name }}</h1>

        @if($tickets->isEmpty())
            <p>No hay tickets para este usuario.</p>
        @else
            <div class="row">
                @foreach($tickets as $ticket)
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Evento: {{ $ticket->evento->nombre }}</h5>
                                <p><strong>Asiento:</strong> {{ $ticket->asiento->id }}</p>
                                <p><strong>Plan:</strong> {{ $ticket->plan->tipo }}</p>
                                <p><strong>Pagado:</strong> {{ $ticket->pagado ? 'Sí' : 'No' }}</p>
                                <p><strong>Fecha de pago:</strong> {{ $ticket->fecha_pago }}</p>
                                <p><strong>QR Válido:</strong> {{ $ticket->qr_valido ? 'Sí' : 'No' }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

