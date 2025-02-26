<!DOCTYPE html>
<html lang="es">

<head>
    @include('layouts.head')
    <script src="https://unpkg.com/html5-qrcode"></script>
</head>

<body>
    <div class="container-degradado">
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

                <div
                    style="display: flex; flex-wrap: wrap; flex-direction: row; justify-content: center; width: 100%; height: auto;">
                    <div style="flex:1 1 40%; background-color:rgb(255, 0, 0);
                        background-image: 
                        url('{{ $ticket->evento->Foto ? asset('storage/' . $ticket->evento->Foto) : 'https://placehold.co/600x400' }}');
                        background-size: cover;
                        background-position: center;
                        background-repeat: no-repeat;">
                    </div>
                    <div
                        style="flex:1 1 60%; padding-left: 30px; gap: 5px; display: flex; flex-direction: column; justify-content: center;">
                        <h5 class="titulo" style="font-size: 2.1rem; margin: 0px;">{{ $ticket->evento->nombre }}</h5>
                        <p style="margin: 0; color:rgb(108, 108, 108); font-size: 1.5rem;">
                            {{ $ticket->evento->ArtistaGrupo }}
                        </p>
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
                    <!-- Mostrar el código QR en formato base64 -->
                    <img src="{{ $ticket->qr_log }}" alt="Código QR" style="width: 200px; height: 200px;">
                </div>

                <!-- Contenedor para el escáner de QR -->
                <div id="qr-reader" style="width: 300px; margin: auto; display: none;"></div>

                <!-- Botón para iniciar verificación -->


            </div>

            <div style="margin-top: auto; margin-bottom: 10px" class="text-center">
                <p style="margin: 0;">Gracias por tu compra</p>

                <div style="width: 100%; border-bottom: 3px solid var(--color); margin: 15px 0;"></div>

                <button class="btn btn-danger" style="margin: 10px;">
                    <a href="{{ route('tickets.ticket.downloadPDF', $ticket->id) }}"
                        style="text-decoration: none; color: white;">
                        <i class="fas fa-file-pdf"></i> Descargar PDF
                    </a>
                </button>

                <button class="btn btn-primary" style="margin: 10px;">
                    <a href="{{ route('tickets.ticket.print', $ticket->id) }}" target="_blank"
                        style="text-decoration: none; color: white;">
                        <i class="fas fa-print"></i> Imprimir
                    </a>
                </button>

                <button id="start-scan" class="btn btn-success" style="margin: 10px;">
                    Iniciar Verificación
                </button>
            </div>


        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            function onScanSuccess(decodedText, decodedResult) {
                // Aquí puedes validar el código QR escaneado con el código QR del ticket.
                const expectedQRCode = "{{ $ticket->qr }}"; // Asegúrate de que esta variable tenga el código QR esperado.

                if (decodedText === expectedQRCode) {
                    // Realiza una solicitud AJAX para verificar el código QR
                    fetch(`/verificar-qr/${decodedText}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}', // Asegúrate de incluir el token CSRF
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert(data.message); // Notificación de éxito
                            } else {
                                alert(data.message); // Notificación de error
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Ocurrió un error al verificar el código QR.');
                        });
                } else {
                    alert("Código QR no válido. Intenta nuevamente.");
                }
            }

            function onScanFailure(error) {
                console.warn(`Error al escanear: ${error}`);
            }

            let html5QrCode = new Html5Qrcode("qr-reader");

            document.getElementById("start-scan").addEventListener("click", function () {
                document.getElementById("qr-reader").style.display = "block"; // Mostrar el escáner
                html5QrCode.start(
                    { facingMode: "environment" },
                    {
                        fps: 10,
                        qrbox: { width: 250, height: 250 }
                    },
                    onScanSuccess,
                    onScanFailure
                );
            });
        });
    </script>
</body>

</html>