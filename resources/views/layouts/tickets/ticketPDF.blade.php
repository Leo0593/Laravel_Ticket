<!DOCTYPE html>
<body>
    @include('layouts.head')

    <div style="
            width: 55%; height: auto; 
            display: flex; flex-direction: column;
            background-color: white;
            box-shadow: 5px 5px 25px rgba(0, 0, 0, 0.5);
            overflow: hidden;
            ">

            <div style="padding: 40px">

            <div class="text-center" style="margin-bottom: 40px;">
                <img src="{{ asset('../../images/login/ticketLogo.png') }}" alt="logo"
                style="width: 100px; height: 100px;">
            </div>

            <div style="display: flex; flex-wrap: wrap; flex-direction: row; justify-content: center; width: 100%; height: auto; ">
                <div style="flex:1 1 40%; background-color:rgb(255, 0, 0);
                    background-image: 
                    url('{{ $ticket->evento->Foto ? asset('storage/' . $ticket->evento->Foto) : 'https://placehold.co/600x400' }}');
                    background-size: cover;
                    background-position: center;
                    background-repeat: no-repeat;">
                </div>
                <div style="flex:1 1 60%; padding-left: 30px; gap: 5px; display: flex; flex-direction: column; justify-content: center;">
                    <h5 class="titulo" style="font-size: 2.1rem; margin: 0px;">{{ $ticket->evento->nombre }}</h5>
                    <p style="margin: 0; color:rgb(108, 108, 108); font-size: 1.5rem;">{{ $ticket->evento->ArtistaGrupo }}</p>
                    <p style="margin: 0; color:rgb(108, 108, 108); font-size: 1.5rem;">
                        {{ \Carbon\Carbon::parse($ticket->evento->fecha_evento)->translatedFormat('M j, H:i') }}
                    </p>                
                </div>
            </div>

            <div style="width: 100%; border-bottom: 3px solid var(--color); margin: 15px 0;"></div>

            <div style="display: flex; justify-content: space-between; padding: 10px; margin-bottom: 10px;">
                <div>
                    <strong>Número de asiento: </strong>{{ $ticket->asiento->numero_asiento ?? 'No asignado' }}
                </div>
                <div>
                    <strong>Tipo de ticket: </strong>{{ $ticket->plan->tipo }} - {{ $ticket->plan->precio }} €
                </div>
            </div>

            <div class="text-center">
                {!! QrCode::size(200)->generate(url('/ticket/' . $ticket->id . '/' . $ticket->qr)) !!}
            </div>

            </div>

            <div style="margin-top: auto; margin-bottom: 10px" class="text-center">
                <p style="margin: 0;">Gracias por tu compra</p>

                <div style="width: 100%; border-bottom: 3px solid var(--color); margin: 15px 0;"></div>

                <button class="btn btn-danger" style="margin: 10px;">
                    <a href="{{ route('tickets.ticket.downloadPDF', $ticket->id) }}" style="text-decoration: none; color: white;">
                        <i class="fas fa-file-pdf"></i> Descargar PDF
                    </a>
                </button>

                <button class="btn btn-primary" style="margin: 10px;">
                    <a  style="text-decoration: none; color: white;">
                        <i class="fas fa-print"></i> Imprimir
                    </a>
                </button>
            </div>
        </div>
</body>