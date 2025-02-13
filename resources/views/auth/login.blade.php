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
                width: 60%; height: 100%;
                padding: 40px;
                ">
                    <h1 
                        style="font-size: 2rem; font-weight: 500;">
                        Accede
                    </h1>

                    <p> 
                        ¿No tienes cuenta? <a style="text-decoration: none; font-weight: 700; margin-left: 5px" href="{{ route('register') }}"> Regístrate</a>
                    </p>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email Address -->
                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div class="mt-4">
                            <x-input-label for="password" :value="__('Password')" />

                            <x-text-input id="password" class="block mt-1 w-full"
                                            type="password"
                                            name="password"
                                            required autocomplete="current-password" />

                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Remember Me -->
                        <div class="block mt-4">
                            <label for="remember_me" class="inline-flex items-center">
                                <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            @if (Route::has('password.request'))
                                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                                    {{ __('Forgot your password?') }}
                                </a>
                            @endif

                            <x-primary-button class="ms-3">
                                {{ __('Log in') }}
                            </x-primary-button>
                        </div>
                    </form>`
                </div>
            </div>
        </div>
    </body>
</html>