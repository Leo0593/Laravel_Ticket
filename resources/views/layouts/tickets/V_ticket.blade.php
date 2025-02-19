<!-- resources/views/ticket/show.blade.php -->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Ticket</title>
</head>
<body>

    <h1>Detalles del Ticket</h1>

    <p><strong>ID del Ticket:</strong> {{ $ticket->id }}</p>
    
    <p>evento_id: {{ $ticket->evento_id}}</p>
    @if($ticket->evento)
        <p><strong>Evento:</strong> {{ $ticket->evento->nombre }}</p>
    @else
        <p><strong>Evento:</strong> No disponible</p>
    @endif

    <p>asiento_id: {{ $ticket->asiento_id}}</p>
    <p><strong>Asiento:</strong> {{ $ticket->asiento ?? 'No asignado' }}</p>

    <p><strong>Usuario:</strong> {{ $ticket->usuario->name }}</p>
    @if($ticket->plan)
        <p><strong>Plan:</strong> {{ $ticket->plan->plan_id }}</p>
    @else
        <p><strong>Plan:</strong> No disponible</p>
    @endif

    <p>plan_id: {{ $ticket->plan_id}}</p>
    <p><strong>Precio:</strong> {{ $ticket->precio ?? 'No especificado' }} €</p>
    <p><strong>Fecha de Compra:</strong> {{ $ticket->created_at->format('d/m/Y H:i') }}</p>

    <!-- Generar y mostrar el código QR -->
    <div>
        <h2>Código QR</h2>
        {!! QrCode::size(200)->generate(url('/ticket/' . $ticket->id . '/' . $ticket->qr)) !!}
    </div>

</body>
</html>
