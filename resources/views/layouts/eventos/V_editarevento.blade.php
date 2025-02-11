<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Evento') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <!-- Mensaje de error para los campos -->
                    @if ($errors->any())
                        <div>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('eventos.update', $evento->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Usuario -->
                        <div>
                            <label for="user_id">{{ __('Usuario') }}</label>
                            <select id="user_id" name="user_id" class="form-control" required>
                                @foreach($users as $usuario)
                                    <option value="{{ $usuario->id }}" {{ $usuario->id == $evento->user_id ? 'selected' : '' }}>
                                        {{ $usuario->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Local -->
                        <div>
                            <label for="local_id">{{ __('Local') }}</label>
                            <select id="local_id" name="local_id" class="form-control" required>
                                @foreach($locales as $local)
                                    <option value="{{ $local->id }}" 
                                            data-aforo="{{ $local->Aforo }}"
                                            {{ $local->id == $evento->local_id ? 'selected' : '' }}>
                                        {{ $local->Nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('local_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Nombre -->
                        <div>
                            <label for="nombre">Nombre del Evento</label>
                            <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $evento->nombre) }}" required>
                        </div>

                        <!-- Descripción -->
                        <div>
                            <label for="descripcion">Descripción</label>
                            <textarea id="descripcion" name="descripcion" required>{{ old('descripcion', $evento->descripcion) }}</textarea>
                        </div>

                        <!-- Fecha Inicio -->
                        <div>
                            <label for="fecha_inicio">Fecha de Inicio de Venta</label>
                            <input type="datetime-local" id="fecha_inicio" name="fecha_inicio"
                                value="{{ old('fecha_inicio', $evento->fecha_inicio ? \Carbon\Carbon::parse($evento->fecha_inicio)->format('Y-m-d\TH:i') : '') }}"
                                required>
                        </div>

                        <!-- Fecha Fin  2--> 
                        <div>
                            <label for="fecha_fin">Fecha de Fin de Venta</label>
                            <input type="datetime-local" id="fecha_fin" name="fecha_fin"
                                value="{{ old('fecha_fin', $evento->fecha_fin ? \Carbon\Carbon::parse($evento->fecha_fin)->format('Y-m-d\TH:i') : '') }}"
                                required>
                        </div>

                        <!-- Fecha Evento -->
                        <div>
                            <label for="fecha_evento">Fecha del Evento</label>
                            <input type="datetime-local" id="fecha_evento" name="fecha_evento"
                                value="{{ old('fecha_evento', $evento->fecha_evento ? \Carbon\Carbon::parse($evento->fecha_evento)->format('Y-m-d\TH:i') : '') }}"
                                required>                      
                        </div>

                        <!-- Aforo -->
                        <div>
                            <label for="aforo_evento">Aforo del Evento</label>
                            <input type="number" id="aforo_evento" name="aforo_evento"
                                value="{{ old('aforo_evento', $evento->aforo_evento) }}" required>
                        </div>

                        <!-- Estado -->
                        <div>
                            <label for="estado">Estado del Evento</label>
                            <select id="estado" name="estado" class="form-control" required>
                                <option value="ACTIVO" {{ $evento->estado == 'ACTIVO' ? 'selected' : '' }}>Activo</option>
                                <option value="CANCELADO" {{ $evento->estado == 'CANCELADO' ? 'selected' : '' }}>Cancelado</option>
                                <option value="FINALIZADO" {{ $evento->estado == 'FINALIZADO' ? 'selected' : '' }}>Finalizado</option>
                            </select>
                            @error('estado')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                      
                        <!-- Foto -->
                        <div class="cont_input_1">
                                <label for="Foto">Foto del Local</label>
                                <div class="input-container">
                                    <i class="fas fa-camera"></i>
                                    <input class="input_1" style="--borderColor: {{ $color_add ?? '#000' }}" type="file" id="Foto" name="Foto" accept="image/*">
                                </div>
                            </div>

                        <div>
                            <button id="btn_agregar" type="submit">Actualizar Evento</button>
                        </div>
                       
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const localSelect = document.getElementById('local_id');
            const aforoInput = document.getElementById('aforo_evento');     
            const aforoAct = aforoInput.value;

            // Obtener la opción seleccionada del select
            const selectedOption = localSelect.options[localSelect.selectedIndex];

            // Obtener el valor de aforo de la opción seleccionada
            const aforo = selectedOption.getAttribute('data-aforo');

            // Establecer el valor máximo en el input de aforo
            aforoInput.setAttribute('max', aforo);

            

            // Función para actualizar el aforo en base al local seleccionado
            function updateAforo() {
                const selectedOption = localSelect.options[localSelect.selectedIndex];
                const aforo = selectedOption.getAttribute('data-aforo');
                
                if (aforo) {
                    aforoInput.setAttribute('max', aforo);  // Establecer el aforo máximo
                    aforoInput.value = Math.min(aforo, aforoInput.value || aforo);  // Asegurar que el aforo no sea mayor que el máximo
                }
            }

            // Llamar a la función inicial para establecer el aforo
            updateAforo();

            // Actualizar el aforo cuando se cambie la selección
            localSelect.addEventListener('change', function() {
                updateAforo();
            });
            
            //console.log('Local id seleccionado:', localSelect.value);
            //console.log('Local aforo seleccionado:', aforo);
            //console.log('Aforo evento inicial:', aforoInput.value);
            //console.log('Aforo máximo:', aforoInput.getAttribute('max'));  // El valor máximo del input
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fechaInicio = document.getElementById('fecha_inicio');
            const fechaFin = document.getElementById('fecha_fin');
            const fechaEvento = document.getElementById('fecha_evento');
            const btnAgregar = document.getElementById('btn_agregar');

            function mostrarError(inputElement, mensaje) {
                const errorElement = document.createElement('span');
                errorElement.classList.add('text-red-500', 'text-xs', 'mt-1');
                errorElement.textContent = mensaje;

                if (!inputElement.parentNode.querySelector('.text-red-500')) {
                    inputElement.parentNode.appendChild(errorElement);
                }
            }

            function limpiarErrores() {
                const errores = document.querySelectorAll('.text-red-500');
                errores.forEach(error => error.remove());
            }

            function validarFechas() {
                limpiarErrores();

                const inicio = new Date(fechaInicio.value);
                const fin = new Date(fechaFin.value);
                const evento = new Date(fechaEvento.value);
                let valido = true;

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

                if (valido) {
                    btnAgregar.style.display = 'block';
                } else {
                    btnAgregar.style.display = 'none';
                }

                return valido;
            }

            fechaInicio.addEventListener('change', validarFechas);
            fechaFin.addEventListener('change', validarFechas);
            fechaEvento.addEventListener('change', validarFechas);

            validarFechas();
        });
    </script>

</x-app-layout>
