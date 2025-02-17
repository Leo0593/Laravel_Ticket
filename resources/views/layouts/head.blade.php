<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
 
    <title>TICKETS</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>

    <!-- jQuery (necesario para Bootstrap 4 y 5 con JavaScript) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap 5 CSS desde CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome desde CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Estilos propios -->
    <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
    <script src="{{ asset('/js/app.js') }}" defer></script>   

    <!-- AOS Library -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            AOS.init();
        });
    </script>

    <!-- Icono de la pestaña -->
    <link id="favicon" rel="icon" href="{{ asset('images/login/ticketLogo.png') }}" type="image/png">
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            function updateFavicon() {
                let darkMode = window.matchMedia("(prefers-color-scheme: dark)").matches;
                let favicon = document.getElementById("favicon");

                // Laravel asset() no funciona en JS, por lo que usamos rutas absolutas
                let lightIcon = "{{ asset('images/login/ticketLogo.png') }}";
                let darkIcon = "{{ asset('images/login/ticketslogo-wh.png') }}";

                favicon.href = darkMode ? darkIcon : lightIcon;
            }

            updateFavicon(); // Llamar al cargar la página
            window.matchMedia("(prefers-color-scheme: dark)").addEventListener("change", updateFavicon);
        });
    </script>
</head>
    
