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
            <div style="display: flex; gap: 10px;">
                <!--
                <a href="{{ url('/dashboard') }}" >
                    <button class="btn-1">
                        <i class="fa-solid fa-tachometer-alt"></i>
                            Dashboard
                    </button>
                </a>
                
                <div class="relative inline-block text-left">
                    <button class="btn-1" style="display: flex; gap: 5px; padding: 5px 10px; justify-content: center; align-items: center;">
                        <div>{{ Auth::user()->name }}</div>
                        <div style="border: 1px solid white; border-radius: 50%; width: 35px; height: 35px;
                            background-image: url('{{ Auth::user()->Foto ? asset('storage/' . Auth::user()->Foto) : 'https://placehold.co/600x400' }}');
                            background-size: cover; background-position: center; background-repeat: no-repeat;">
                        </div>
                    </button>

                    <div class="dropdown-content absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 focus:outline-none hidden">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">Profile</a>
                        <a href="{{ url('/dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700"><i class="fa-solid fa-tachometer-alt"></i> Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">Log Out</button>
                        </form>
                    </div>
                </div> -->

                <div class="dropup" style="margin-left: 15px;">
                    <button style="display: flex; gap: 5px; padding: 5px 15px; justify-content: center; align-items: center;" class="btn-1 dropdown-toggle" type="button" id="estadoDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <div>{{ Auth::user()->name }}</div>
                        <div style="border: 1px solid white; border-radius: 50%; width: 35px; height: 35px; margin-left: 5px;
                            background-image: url('{{ Auth::user()->Foto ? asset('storage/' . Auth::user()->Foto) : 'https://placehold.co/600x400' }}');
                            background-size: cover; background-position: center; background-repeat: no-repeat;">
                        </div>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="estadoDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ url('/dashboard') }}">
                                <i class="fa-solid fa-tachometer-alt"></i> Dashboard
                            </a>
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="dropdown-item">
                                @csrf
                                <button class="nocolor" type="submit" style="background-color: transparent; border: none; color: black;">
                                    <i class="fa-solid fa-sign-out-alt"></i> Cerrar sesión
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        @endguest
    </div>
</div>