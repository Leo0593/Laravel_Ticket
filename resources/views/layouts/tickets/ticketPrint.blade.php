<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imprimir Ticket</title>
    <style>
        @media print {
            @page {
                size: 80mm auto; /* Ancho fijo, altura ajustable */
                margin: 0;
            }

            body {
                font-family: Arial, sans-serif;
                width: 80mm;
                height: auto;
                margin: 0;
                padding: 0;
            }

            #ticket {
                width: 80mm;
                height: auto;
                padding: 5mm;
                page-break-inside: avoid; /* Evita cortes de contenido */
            }

            .no-print {
                display: none; /* Oculta botones al imprimir */
            }

            img {
                max-width: 100%;
                height: auto;
            }
        }
    </style>
</head>
<body>
    <div id="ticket">
        <div class="text-center" style="margin-bottom: 10px;">
            <img src="{{ asset('../../images/login/ticketLogo.png') }}" alt="logo" style="width: 100px; height: 100px;">
        </div>

        <h3 style="text-align: center;">{{ $ticket->evento->nombre }}</h3>
        <p style="text-align: center;">{{ $ticket->evento->ArtistaGrupo }}</p>
        <p style="text-align: center;">
            {{ \Carbon\Carbon::parse($ticket->evento->fecha_evento)->translatedFormat('M j, H:i') }}
        </p>

        <hr>

        <p><strong>Número de asiento:</strong> {{ $ticket->asiento->numero_asiento ?? 'No asignado' }}</p>
        <p><strong>Tipo de ticket:</strong> {{ $ticket->plan->tipo }} - {{ $ticket->plan->precio }} €</p>

        <div style="text-align: center;">
            {!! QrCode::size(150)->generate(url('/ticket/' . $ticket->id . '/' . $ticket->qr)) !!}
        </div>

        <hr>

        <p style="text-align: center;">¡Gracias por tu compra!</p>

        <div class="no-print" style="text-align: center; margin-top: 20px;">
            <button onclick="window.print();" style="padding: 10px; background: blue; color: white; border: none; cursor: pointer;">
                Imprimir Ticket
            </button>
        </div>
    </div>
</body>
</html>
