<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Planes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold" style="font-size: 1.8rem; margin-bottom: 30px">{{ __('Agregar un nuevo plan') }}</h3>
                        
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                    <form method="POST" action="{{ route('planes.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Evento -->
                        <div class="mt-4">
                            <label for="evento_id" class="block text-sm font-medium text-gray-700">{{ __('Evento') }}</label>
                            <select type="text" id="evento_id" name="evento_id" value="{{ old('evento_id') }}" 
                            class="mt-1 block w-full text-sm text-gray-500 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                            required>
                                @foreach($eventos as $evento)
                                    <option value="{{ $evento->id }}">{{ $evento->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Tipo -->
                        <label for="tipo" class="block text-sm font-medium text-gray-700">{{ __('Tipo de plan') }}</label>
                        <select id="tipo" name="tipo" class="mt-1 block w-full text-sm text-gray-500 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:focus:ring-indigo-500 dark:focus:border-indigo-500">
                            <option value="General" {{ old('tipo') == 'General' ? 'selected' : '' }}>General</option>
                            <option value="VIP" {{ old('tipo') == 'VIP' ? 'selected' : '' }}>VIP</option>
                        </select>
                        
                        <!-- Precio -->
                        <div class="mt-4">
                            <label for="precio" class="block text-sm font-medium text-gray-700">{{ __('Precio') }}</label>
                            <input type="text" id="precio" name="precio" value="{{ old('precio') }}" class="mt-1 block w-full text-sm text-gray-500 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:focus:ring-indigo-500 dark:focus:border-indigo-500">
                        </div>

                        <!-- Descripción -->
                        <div class="mt-4">
                            <label for="descripcion" class="block text-sm font-medium text-gray-700">{{ __('Descripción') }}</label>
                            <textarea id="descripcion" name="descripcion" rows="3" class="mt-1 block w-full text-sm text-gray-500 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:focus:ring-indigo-500 dark:focus:border-indigo-500">{{ old('descripcion') }}</textarea>
                        </div>

                        <!-- Foto -->
                        <div>
                            <label  style="margin-right: 10px"
                            for="Foto">{{ __('Foto del Plan:') }}</label>
                            <input type="file" id="Foto" name="Foto">
                        </div>

                        <div class="mt-6">
                            <button type="submit">
                                {{ __('Agregar') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Asiento by Evento 
    <script>
        function cargarPlanes(eventoId) {
            const tipoSelect = document.getElementById('tipo');  // Obtener el selector de asientos
            tipoSelect.innerHTML = '';  // Limpiar las opciones previas

            console.log('Id del Evento para planes: ', eventoId);  // Verificar en consola

            fetch(`/planes/${eventoId}`)
                .then(response => response.json())
                .then(data => {
                    console.log('planes obtenidos:', data.planes);

                    if (data.planes.length === 0) {
                        const option = document.createElement('option');
                        option.textContent = 'No hay planes disponibles';
                        option.disabled = true;
                        tipoSelect.appendChild(option);
                        return;
                    }

                    // Agregar opciones de planes al select
                    data.planes.forEach(plan => {
                        const option = document.createElement('option');
                        option.value = plan.id; 
                        option.textContent = `${plan.tipo} - ${plan.precio}€`; // Mostrar tipo y precio
                        tipoSelect.appendChild(option);
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
    </script>-->

</x-app-layout>
