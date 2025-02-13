<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('layouts.head')
    
    <body>
        <div class="container-degradado">
            <div style="
            width: 55%; height: 70%; 
            display: flex; flex-direction: row;
            background-color: white;
            box-shadow: 5px 5px 25px rgba(0, 0, 0, 0.5);
            overflow: hidden;
            ">
                <div style="
                width: 40%; height: 100%;
                background-image: url('../../images/login/login.jpg');
                background-size: cover;
                background-position: bottom center; 
                padding: 40px;
                ">
                    <h1 style="font-family: 'Poppins', sans-serif; font-size: 1.rem; font-weight: 700; color: var(--color); margin-bottom: 30px;">
                        ¡Tu próxima gran experiencia te espera!
                    </h1>

                    <p>
                        Descubre eventos increíbles, sigue a tus artistas favoritos y consigue entradas de forma segura.  
                        ¡Vive cada momento al máximo!                
                    </p>
                    <div style="
                        width: 100px;
                        height: 10px;
                        background-color: var(--color); 
                        margin-top: 10px; 
                        border-radius: 3px; 
                    "></div>
                </div>
                <div style="
                    display: flex; flex-direction: column;
                    width: 60%;
                    height: 100%;
                    padding: 40px;
                    ">
                    <h1 
                        style="font-size: 2rem; font-weight: 500;">
                        Accede
                    </h1>

                    <p> 
                        ¿No tienes cuenta? <a style="text-decoration: none; font-weight: 700; margin-left: 5px" href="{{ route('register') }}"> Regístrate</a>
                    </p>

                    @php
                        $color = 'var(--color)';
                    @endphp

                    <form style="
                        display: flex;
                        flex-direction: column;
                        flex: 1;
                        justify-content: flex-start;
                        " method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="cont_input_1">
                            <label for="email">E-mail</label>
                            <div class="input-container">
                                <i class="fas fa-envelope"></i> 
                                <input class="input_1" style="--borderColor: {{ $color }}" type="email" id="email" name="email" value="" required>
                            </div>

                            <!-- Mostrar errores para el campo email -->
                            @if($errors->has('email'))
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            @endif
                        </div>

                        <div class="cont_input_1">
                            <label for="password">Contraseña</label>
                            <div class="input-container">
                                <i class="fas fa-lock"></i> 
                                <input class="input_1" style="--borderColor: {{ $color }}" type="password" id="password" name="password" value="" required>
                            </div>

                            <!-- Mostrar errores para el campo password -->
                            @if($errors->has('password'))
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            @endif
                        </div>

                        <div class="remember-me">
                            <label for="remember_me" class="checkbox-label">
                                <input id="remember_me" type="checkbox" class="checkbox-input">
                                <span class="checkbox-custom"></span>
                                <span class="text">Remember me</span>
                            </label>
                        </div>

                        <button type="submit" class="btn-2 mt-4" style="background-color: var(--color); color: white; width: auto; text-align: center;">
                            Log in
                        </button>

                        @if (Route::has('password.request'))
                            <a style="margin-top: auto; text-align: center;"
                            class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                                {{ __('¿Olvidaste tú contraseña?') }}
                            </a>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>