<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Eventos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold" style="font-size: 1.8rem; margin-bottom: 30px">{{ __('Agregar un nuevo plan') }}</h3>
                        
                    <!-- ERROR -->
                    <form method="POST" action="{{ route('eventos.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Usuario -->
                        <div class="mb-4">
                            <label for="user_id" class="block text-sm font-medium text-gray-700">{{ __('Usuario') }}</label>
                            <select name="user_id" id="user_id" 
                            class="mt-1 block w-full text-sm text-gray-500 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                            required>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Local -->
                        <div class="mb-4">
                            <label for="local_id" class="block text-sm font-medium text-gray-700">{{ __('Local') }}</label>
                            <select name="local_id" id="local_id" 
                                class="mt-1 block w-full text-sm text-gray-500 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                                required>
                                @foreach($locales as $local)
                                    <option value="{{ $local->id }}" 
                                            data-aforo="{{ $local->Aforo }}">
                                        {{ $local->Nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Nombre -->
                        <div class="mb-4">
                            <label for="nombre" class="block text-sm font-medium text-gray-700">{{ __('Nombre') }}</label>
                            <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" 
                                class="mt-1 block w-full text-sm text-gray-500 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                                required>
                        </div>

                        <!-- Descripcion -->
                        <div class="mb-4">
                            <label for="descripcion" class="block text-sm font-medium text-gray-700">{{ __('Descripción') }}</label>
                            <textarea name="descripcion" id="descripcion" 
                                class="mt-1 block w-full text-sm text-gray-500 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                                ></textarea>
                        </div>

                        <!-- Fecha_inicio -->
                        <div class="mb-4">
                            <label for="fecha_inicio" class="block text-sm font-medium text-gray-700">{{ __('Fecha de inicio') }}</label>
                            <input type="date" name="fecha_inicio" id="fecha_inicio"
                                class="mt-1 block w-full text-sm text-gray-500 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                                required>
                        </div>

                        <!-- Fecha_fin -->
                        <div class="mb-4">
                            <label for="fecha_fin" class="block text-sm font-medium text-gray-700">{{ __('Fecha de fin') }}</label>
                            <input type="date" name="fecha_fin" id="fecha_fin" 
                                class="mt-1 block w-full text-sm text-gray-500 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                                required>
                        </div>

                        <!-- Fecha_limite -->
                        <div class="mb-4">
                            <label for="fecha_evento" class="block text-sm font-medium text-gray-700">{{ __('Fecha límite') }}</label>
                            <input type="date" name="fecha_evento" id="fecha_evento" 
                                class="mt-1 block w-full text-sm text-gray-500 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                                required>
                        </div>

                        <!-- Hora del Evento -->
                        <div class="mb-4">
                            <label for="hora_evento" class="block text-sm font-medium text-gray-700">{{ __('Hora del Evento') }}</label>
                            <input type="time" name="hora_evento" id="hora_evento" value="{{ old('hora_evento') }}"
                                class="mt-1 block w-full text-sm text-gray-500 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:focus:ring-indigo-500 dark:focus:border-indigo-500">
                        </div>


                        <!-- Aforo -->
                        <div class="mb-4">
                            <label for="aforo_evento" class="block text-sm font-medium text-gray-700">{{ __('Aforo') }}</label>
                            <input type="number" name="aforo_evento" id="aforo_evento" 
                                class="mt-1 block w-full text-sm text-gray-500 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                                required value="{{ old('aforo_evento', 0) }}" max="0">
                        </div>

                        <!-- Estado -->
                        <select name="estado" id="estado" 
                            class="mt-1 block w-full text-sm text-gray-500 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                            required>
                            <option value="ACTIVO" {{ old('estado') == 'ACTIVO' ? 'selected' : '' }}>{{ __('Activo') }}</option>
                            <option value="CANCELADO" {{ old('estado') == 'CANCELADO' ? 'selected' : '' }}>{{ __('Cancelado') }}</option>
                            <option value="FINALIZADO" {{ old('estado') == 'FINALIZADO' ? 'selected' : '' }}>{{ __('Finalizado') }}</option>
                        </select>

                        <br>
                        
                        <!-- Foto -->
                        <div>
                            <label  style="margin-right: 10px"
                                for="Foto">{{ __('Foto del Evento:') }}</label>
                            <input type="file" id="Foto" name="Foto">
                        </div>

                        <div class="mt-6">
                            <button type="submit" id="btn_agregar">
                                {{ __('Agregar') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Script para actualizar el aforo máximo y el valor inicial -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Obtener el select del local
            const localSelect = document.getElementById('local_id');
            const aforoInput = document.getElementById('aforo_evento');
            
            // Función para actualizar el aforo en base al local seleccionado
            function updateAforo() {
                const selectedOption = localSelect.options[localSelect.selectedIndex];
                const aforo = selectedOption.getAttribute('data-aforo');
                aforoInput.setAttribute('max', aforo);  // Establecer el aforo máximo
                aforoInput.value = aforo;  // Establecer el valor inicial del aforo

                // Verificar si el valor actual de aforo_evento es mayor que el aforo máximo
                if (parseInt(aforoInput.value) > parseInt(aforo)) {
                    aforoInput.value = aforo;  // Restablecer el valor a la cantidad máxima
                }
            }
            
            // Ejecutar la función cuando cambie la selección
            localSelect.addEventListener('change', updateAforo);

            // Validar el valor de aforo_evento cada vez que el usuario cambie el valor
            aforoInput.addEventListener('input', function() {
                const aforoMax = aforoInput.getAttribute('max');
                if (parseInt(aforoInput.value) > parseInt(aforoMax)) {
                    aforoInput.value = aforoMax;  // Limitar el valor a no exceder el aforo máximo
                }
            });

            // Llamar a la función al cargar la página para inicializar el valor
            updateAforo();
        });
    </script>


    <!-- Script para validar las fechas -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            
            // Obtener los elementos de fecha
            const fechaInicio = document.getElementById('fecha_inicio');
            const fechaFin = document.getElementById('fecha_fin');
            const fechaEvento = document.getElementById('fecha_evento');
            const btnAgregar = document.getElementById('btn_agregar');  // Asegúrate de que tu botón tenga este id

            function mostrarError(inputElement, mensaje) {
                // Crear el elemento de error
                const errorElement = document.createElement('span');
                errorElement.classList.add('text-red-500', 'text-xs', 'mt-1');
                errorElement.textContent = mensaje;

                // Verificar si ya existe un error para evitar duplicados
                if (!inputElement.parentNode.querySelector('.text-red-500')) {
                    inputElement.parentNode.appendChild(errorElement);
                }
            }

            function limpiarErrores() {
                // Eliminar todos los mensajes de error
                const errores = document.querySelectorAll('.text-red-500');
                errores.forEach(error => error.remove());
            }

            function validarFechas() {
                limpiarErrores();  // Limpiar los errores previos

                const inicio = new Date(fechaInicio.value);
                const fin = new Date(fechaFin.value);
                const evento = new Date(fechaEvento.value);
                let valido = true;

                // Validar fechas
                if (inicio > fin) {
                    mostrarError(fechaInicio, "La fecha de inicio no puede ser después de la fecha de fin.");
                    valido = false;
                }
                if (fin < inicio) {
                    mostrarError(fechaFin, "La fecha de fin no puede ser antes de la fecha de inicio.");
                    valido = false;
                }
                if (evento < inicio) {
                    mostrarError(fechaEvento, "La fecha del evento no puede ser antes de la fecha de inicio.");
                    valido = false;
                }
                if (evento < fin) {
                    mostrarError(fechaEvento, "La fecha del evento no puede ser antes de la fecha de fin.");
                    valido = false;
                }

                // Mostrar u ocultar el botón dependiendo de si las fechas son válidas
                if (valido) {
                    btnAgregar.style.display = 'block';  // Muestra el botón
                } else {
                    btnAgregar.style.display = 'none';   // Oculta el botón
                }

                return valido;
            }

            // Llamar a la función de validación cuando las fechas cambien
            fechaInicio.addEventListener('change', validarFechas);
            fechaFin.addEventListener('change', validarFechas);
            fechaEvento.addEventListener('change', validarFechas);

            // Ejecutar la validación al cargar la página
            validarFechas();
        });
    </script>

</x-app-layout>