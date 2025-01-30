<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tickets') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold" style="font-size: 1.8rem; margin-bottom: 30px">{{ __('Agregar un nuevo ticket') }}</h3>
                    
                    <form method="POST" action="{{ route('tickets.store') }}">
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

                        <!-- Evento -->
                        <div class="mb-4">
                            <label for="evento_id" class="block text-sm font-medium text-gray-700">{{ __('Evento') }}</label>
                            <select name="evento_id" id="evento_id" 
                            class="mt-1 block w-full text-sm text-gray-500 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                            required>
                                @foreach($eventos as $evento)
                                    <option value="{{ $evento->id }}">{{ $evento->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Asiento -->
                        <div class="mb-4">
                            <label for="asiento_id" class="block text-sm font-medium text-gray-700">{{ __('Asiento') }}</label>
                            <select name="asiento_id" id="asiento_id" 
                            class="mt-1 block w-full text-sm text-gray-500 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                            required>
                                <!--
                                @foreach($asientos as $asiento)
                                    <option value="{{ $asiento->id }}">{{ $asiento->numero_asiento }}</option>
                                @endforeach
                                    -->
                            </select>
                        </div>
<!--
                        <div class="mb-4">
                            <label for="asiento_id" class="block text-sm font-medium text-gray-700">{{ __('Asiento') }}</label>
                            <select name="asiento_id" id="asiento_id" 
                            class="mt-1 block w-full text-sm text-gray-500 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                            required>
                                @foreach($asientos as $asiento)
                                    <option value="{{ $asiento->id }}">{{ $asiento->numero_asiento }}</option>
                                @endforeach
                            </select>
                        </div> -->

                        <!-- Plan -->
                        <div class="mb-4">
                            <label for="plan_id" class="block text-sm font-medium text-gray-700">{{ __('Plan') }}</label>
                            <select name="plan_id" id="plan_id" 
                            class="mt-1 block w-full text-sm text-gray-500 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                            required>
                                <!--
                                @foreach($planes as $plan)
                                    <option value="{{ $plan->id }}">{{ $plan->tipo }}</option>
                                @endforeach
-->
                            </select>
                        </div>

                        <!-- Estado de pago -->
                        <div class="mb-4">
                            <label for="pagado" class="block text-sm font-medium text-gray-700">{{ __('Estado de pago') }}</label>
                            <select name="pagado" id="pagado" 
                            class="mt-1 block w-full text-sm text-gray-500 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                            required>
                                <option value="1">{{ __('Pagado') }}</option>
                                <option value="0">{{ __('No Pagado') }}</option>
                            </select>
                        </div>

                        <!-- Fecha de pago -->
                        <div class="mb-4">
                            <label for="fecha_pago" class="block text-sm font-medium text-gray-700">{{ __('Fecha de pago') }}</label>
                            <input type="date" name="fecha_pago" id="fecha_pago" 
                            class="mt-1 block w-full text-sm text-gray-500 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                            required>
                        </div>

                        <!-- QR -->
                        <div class="mb-4">
                            <label for="qr" class="block text-sm font-medium text-gray-700">{{ __('Código QR') }}</label>
                            <input type="text" name="qr" id="qr" 
                            class="mt-1 block w-full text-sm text-gray-500 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                            required>
                        </div>

                        <!-- QR válido -->
                        <div class="mb-4">
                            <label for="qr_valido" class="block text-sm font-medium text-gray-700">{{ __('QR Válido') }}</label>
                            <select name="qr_valido" id="qr_valido" 
                            class="mt-1 block w-full text-sm text-gray-500 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                            required>
                                <option value="1">{{ __('Válido') }}</option>
                                <option value="0">{{ __('No Válido') }}</option>
                            </select>
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">
                                {{ __('Agregar') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Asiento by Evento -->
    <script>
        function cargarAsientos(eventoId) {
            const asientoSelect = document.getElementById('asiento_id');  // Obtener el selector de asientos
            asientoSelect.innerHTML = '';  // Limpiar las opciones previas

            //console.log('Id del Evento: ', eventoId);  // Verificar en consola

            // Hacer la solicitud para obtener los asientos para el evento seleccionado
            fetch(`/asientos/${eventoId}`)
                .then(response => response.json())
                .then(data => {
                    //console.log('Asientos obtenidos:', data.asientos);

                    // Verificar si hay asientos disponibles
                    if (data.asientos.length === 0) {
                        const option = document.createElement('option');
                        option.textContent = 'No hay asientos disponibles';
                        option.disabled = true;
                        asientoSelect.appendChild(option);
                        return;
                    }

                    // Recorrer los asientos y agregarlos como opciones en el select
                    data.asientos.forEach(asiento => {
                        const option = document.createElement('option');
                        option.value = asiento.id;  // Valor del asiento
                        option.textContent = `Asiento ${asiento.numero_asiento}`; // Texto visible en la opción
                        asientoSelect.appendChild(option); // Agregar al select
                    });
                })
                .catch(error => {
                    console.error('Error al cargar los asientos:', error);
                });
        }

        document.getElementById('evento_id').addEventListener('change', function() {       
            const eventoId = this.value;  // Obtener el valor del evento seleccionado
            //console.log('Id del Evento: ', eventoId);  // Verificar en consola

            cargarAsientos(eventoId);
        });

        document.addEventListener('DOMContentLoaded', function() {
            const eventoId = document.getElementById('evento_id').value;
            //console.log('Evento al cargar la página: ', eventoId);  // Verificar el evento seleccionado al inicio
            cargarAsientos(eventoId);  // Llamar a la función para cargar los asientos
        });
    </script>

    <!-- Asiento by Evento -->
    <script>
        function cargarPlanes(eventoId) {
            const planSelect = document.getElementById('plan_id');  // Obtener el selector de asientos
            planSelect.innerHTML = '';  // Limpiar las opciones previas

            console.log('Id del Evento para planes: ', eventoId);  // Verificar en consola

            fetch(`/planes/${eventoId}`)
                .then(response => response.json())
                .then(data => {
                    console.log('planes obtenidos:', data.planes);

                    if (data.planes.length === 0) {
                        const option = document.createElement('option');
                        option.textContent = 'No hay planes disponibles';
                        option.disabled = true;
                        planSelect.appendChild(option);
                        return;
                    }

                    // Agregar opciones de planes al select
                    data.planes.forEach(plan => {
                        const option = document.createElement('option');
                        option.value = plan.id; 
                        option.textContent = `${plan.tipo} - ${plan.precio}€`; // Mostrar tipo y precio
                        planSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error al cargar los planes:', error);
                });
        } 

        document.getElementById('evento_id').addEventListener('change', function() {       
            const eventoId = this.value;  // Obtener el valor del evento seleccionado
            console.log('Id del Evento: ', eventoId);  // Verificar en consola

            cargarPlanes(eventoId);
        });

        document.addEventListener('DOMContentLoaded', function() {
            const eventoId = document.getElementById('evento_id').value;
            console.log('Evento al cargar la página plan: ', eventoId);  // Verificar el evento seleccionado al inicio
            cargarPlanes(eventoId);  // Llamar a la función para cargar los asientos
        });
    </script>

</x-app-layout>
