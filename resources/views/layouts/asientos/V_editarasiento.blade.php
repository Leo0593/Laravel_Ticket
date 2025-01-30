<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Asiento') }}
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

                    <form action="{{ route('asientos.update', $asiento->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Local -->
                        <div>
                            <label for="local_id">{{ __('Local') }}</label>
                            <select id="local_id" name="local_id" class="form-control" required>
                                @foreach($locales as $local)
                                    <option value="{{ $local->id }}" 
                                            data-aforo="{{ $local->Aforo }}"
                                            {{ $local->id == $asiento->local_id ? 'selected' : '' }}>
                                        {{ $local->Nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('local_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Evento -->
                        <div>
                            <label for="evento_id">{{ __('Evento') }}</label>
                            <select id="evento_id" name="evento_id" class="form-control" required>
                                @foreach($eventos as $evento)
                                    <option value="{{ $evento->id }}" {{ $evento->id == $asiento->evento_id ? 'selected' : '' }}>
                                        {{ $evento->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('evento_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Plan -->
                        <div>
                            <label for="plan_id">{{ __('Plan') }}</label>
                            <select id="plan_id" name="plan_id" class="form-control" required>
                                @foreach($planes as $plan)
                                    <option value="{{ $plan->id }}" {{ $plan->id == $asiento->plan_id ? 'selected' : '' }}>
                                        {{ $plan->tipo }}
                                    </option>
                                @endforeach
                            </select>
                            @error('plan_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tipo -->
                        <div>
                            <label for="tipo">{{ __('Tipo de Plan') }}</label>
                            <select id="tipo" name="tipo" class="form-control" required>
                                <option value="General" {{ $plan->tipo == 'General' ? 'selected' : '' }}>General</option>
                                <option value="VIP" {{ $plan->tipo == 'VIP' ? 'selected' : '' }}>VIP</option>
                            </select>
                            @error('tipo')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Número de Asiento -->
                        <div>
                            <label for="numero_asiento">{{ __('Número de Asiento') }}</label>
                            <input type="text" id="numero_asiento" name="numero_asiento" value="{{ old('numero_asiento', $asiento->numero_asiento) }}" required>
                        </div>

                        <!-- Estado -->
                        <div>
                            <label for="estado">{{ __('Estado') }}</label>
                            <select id="estado" name="estado" class="form-control" required>
                                <option value="Disponible" {{ $asiento->estado == 'Disponible' ? 'selected' : '' }}>Disponible</option>
                                <option value="Ocupado" {{ $asiento->estado == 'Ocupado' ? 'selected' : '' }}>Ocupado</option>
                            </select>
                            @error('estado')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>                        

                        <div>
                            <button id="btn_agregar" type="submit">Actualizar</button>
                        </div>
                       
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--
    <script>
        // Evento para actualizar los planes cuando el evento cambie
        document.getElementById('evento_id').addEventListener('change', function() {
            const eventoId = this.value;

            // Realizar una petición fetch para obtener los planes para este evento_id
            fetch(`/obtener/planes/${eventoId}`)
                .then(response => response.json())
                .then(data => {
                    const planSelect = document.getElementById('plan_id');
                    planSelect.innerHTML = ''; // Limpiar las opciones anteriores

                    // Añadir las nuevas opciones de planes
                    data.forEach(plan => {
                        const option = document.createElement('option');
                        option.value = plan.id;
                        option.textContent = plan.tipo;
                        planSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error:', error));
        });
    </script>
-->
</x-app-layout>
