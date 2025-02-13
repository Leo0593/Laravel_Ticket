<div class="wrapped">
    <!-- Logo y nombre de la aplicación -->
    <div class="wrapped_logo">
        <img src="{{ asset('../../images/login/ticketslogo-wh.png') }}" alt="logo">
        <a style="color: white; text-decoration: none;" href="{{ url('/') }}"> TICKETS </a>
    </div>

    <!-- Botón de acceso -->
    <div class="wrapped_sesion">
        @guest
            <!-- Si el usuario no está autenticado (loggeado) -->
            <a href="{{ route('login') }}">
                <button class="btn-1">
                    <i class="fa-solid fa-user"></i>
                    Accede
                </button>
            </a>
        @else
            <!-- Si el usuario ya está autenticado -->
            <a href="{{ url('/dashboard') }}" >
                <button class="btn-1">
                    <i class="fa-solid fa-tachometer-alt"></i>
                        Dashboard
                </button>
            </a>
        @endguest
    </div>
</div>