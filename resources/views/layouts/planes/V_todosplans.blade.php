<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('layouts.head')
    
    <body>
        @include('layouts.header')

        <div class="main">
            <div class="main_banner_2" 
            data-aos="fade-down" data-aos-duration="1000" 
            style="--banner-image: url('../../images/dashboard/plans.png');">
                <h1><strong>Planes para Todos</strong></h1>
                <h2>Combos Generales o VIP, ¡Tú Decides!</h2>
                
                <button class="btn-1" data-bs-toggle="modal" data-bs-target="#addModal">
                    Agregar
                </button> 

                <a href="{{ route('planes.create') }}" class="btn-1">
                    agregar
                </a>
            </div>

            <div class="main_contenedor">
                <div class="container-fluid main_contenedor">
                    @if($noPlanes)
                        <div class="alert alert-warning text-center" role="alert">
                            <p class="mb-0">{{ __('No hay planes disponibles') }}</p>
                        </div>
                    @else
                        <div class="row">
                            @foreach($eventos as $evento)
                                <div class="col-lg-6 col-md-12 mb-4"> <!-- 2 eventos por fila en pantallas grandes -->
                                    <div class="card shadow-sm">
                                        <div class="card-header bg-primary text-white text-center">
                                            <h5 class="mb-0">{{ $evento->nombre }}</h5>
                                        </div>
                                        <div class="card-body p-0">
                                            @if($planes->where('evento_id', $evento->id)->isEmpty())
                                                <p class="text-center text-muted">No hay planes para este evento.</p>
                                            @else
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-hover m-0">
                                                        <thead class="table-dark">
                                                            <tr>
                                                                <th class="text-center">{{ __('Tipo') }}</th>
                                                                <th class="text-center">{{ __('Precio') }}</th>
                                                                <th class="text-center">{{ __('Descripción') }}</th>
                                                                <th class="text-center">{{ __('Foto') }}</th>
                                                                <th class="text-center">{{ __('Acciones') }}</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($planes->where('evento_id', $evento->id) as $plan)
                                                                <tr>
                                                                    <td class="text-center">{{ $plan->tipo }}</td>
                                                                    <td class="text-center">{{ $plan->precio }}</td>
                                                                    <td class="text-center">{{ $plan->descripcion }}</td>
                                                                    <td class="text-center">
                                                                        @if($plan->Foto)
                                                                            <img src="{{ asset('storage/' . $plan->Foto) }}" alt="Foto del plan" class="w-20 h-20 object-cover rounded-md">
                                                                        @else
                                                                            {{ __('No Disponible') }}
                                                                        @endif
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <!-- Botón de Editar -->
                                                                        <a href="#" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal"
                                                                           data-id="{{ $plan->id }}"
                                                                           data-evento_id="{{ $plan->evento_id }}"
                                                                           data-tipo="{{ $plan->tipo }}"
                                                                           data-precio="{{ $plan->precio }}"
                                                                           data-descripcion="{{ $plan->descripcion }}"
                                                                           data-foto="{{ $plan->Foto }}">
                                                                            <i class="fa-solid fa-pen"></i>
                                                                        </a>

                                                                        <!-- Botón de Eliminar -->
                                                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                                                data-id="{{ $plan->id }}"
                                                                                data-nombre="{{ $plan->nombre }}">
                                                                            <i class="fa-solid fa-trash"></i>
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Modal Editar -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #ffcc00; align-items: center; color: white;">
                        <h5 class="modal-title" id="exampleModalCenterTitle"><strong>Editar</strong></h5>
                        <i class="fa-solid fa-pen" style="margin-left: 10px"></i>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form id="editForm" action="{{ route('planes.update', ':id') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Evento -->
                            <div class="mt-4">
                                <label for="evento_id" class="block text-sm font-medium text-gray-700">{{ __('Evento') }}</label>
                                <select id="evento_id" name="evento_id" class="mt-1 block w-full text-sm text-gray-500 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:focus:ring-indigo-500 dark:focus:border-indigo-500" required>
                                    @foreach($eventos as $evento)
                                        <option value="{{ $evento->id }}">{{ $evento->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        
                            <!-- Tipo -->
                            <div class="mt-4">
                                <label for="tipo" class="block text-sm font-medium text-gray-700">{{ __('Tipo de plan') }}</label>
                                <select id="tipo" name="tipo" class="mt-1 block w-full text-sm text-gray-500 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:focus:ring-indigo-500 dark:focus:border-indigo-500">
                                    <option value="General">General</option>
                                    <option value="VIP">VIP</option>
                                </select>
                            </div>

                            <!-- Precio -->
                            <div class="mt-4">
                                <label for="precio" class="block text-sm font-medium text-gray-700">{{ __('Precio') }}</label>
                                <input type="text" id="precio" name="precio" class="mt-1 block w-full text-sm text-gray-500 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:focus:ring-indigo-500 dark:focus:border-indigo-500">
                            </div>

                            <!-- Descripción -->
                            <div class="mt-4">
                                <label for="descripcion" class="block text-sm font-medium text-gray-700">{{ __('Descripción') }}</label>
                                <textarea id="descripcion" name="descripcion" rows="3" class="mt-1 block w-full text-sm text-gray-500 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:focus:ring-indigo-500 dark:focus:border-indigo-500"></textarea>
                            </div>

                            <!-- Foto -->
                            <div>
                                <label for="Foto" class="block text-sm font-medium text-gray-700">{{ __('Foto del Plan:') }}</label>
                                <input type="file" id="Foto" name="Foto">
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer" style="justify-content: center !important;">
                        <button type="button" class="btn btn-warning" id="saveButton">Actualizar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Agregar -->
        @php
            $color_add = 'var(--color)';
        @endphp
        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="color: white;">
                    <div class="modal-header" style="background-color: {{ $color_add }}; align-items: center;">
                        <h5 class="modal-title" id="addModalLabel"><strong>Agregar</strong></h5>
                        <i class="fa-solid fa-plus-circle" style="margin-left: 10px"></i>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form id="addForm" action="{{ route('planes.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Nombre -->
                            <div class="cont_input_1">
                                <label for="nombre">{{ __('Nombre') }}</label>
                                <div class="input-container">
                                    <i class="fas fa-gift"></i>
                                    <input class="input_1" style="--borderColor: {{ $color_add }}" type="text" id="nombre" name="nombre" required>
                                </div>
                            </div>

                            <!-- Artista o Grupo -->
                            <div class="cont_input_1">
                                <label for="ArtistaGrupo">{{ __('Artista o Grupo') }}</label>
                                <div class="input-container">
                                    <i class="fas fa-microphone-alt"></i>
                                    <input class="input_1" style="--borderColor: {{ $color_add }}" type="text" id="ArtistaGrupo" name="ArtistaGrupo" maxlength="255">
                                </div>
                            </div>

                            <!-- Descripción -->
                            <div class="cont_input_1">
                                <label for="descripcion">{{ __('Descripción') }}</label>
                                <div class="textarea-container">
                                    <i class="fas fa-align-left"></i>
                                    <textarea class="input_1" style="--borderColor: {{ $color_add }}" name="descripcion" id="descripcion"></textarea>
                                </div>
                            </div>

                            <!-- Fecha_inicio -->
                            <div class="cont_input_1">
                                <label for="fecha_inicio">{{ __('Fecha de inicio') }}</label>
                                <div class="input-container">
                                    <i class="fas fa-calendar-alt"></i>
                                    <input class="input_1" style="--borderColor: {{ $color_add }}" type="datetime-local" name="fecha_inicio" id="fecha_inicio" required>
                                </div>
                            </div>

                            <!-- Fecha_fin -->
                            <div class="cont_input_1">
                                <label for="fecha_fin">{{ __('Fecha de fin') }}</label>
                                <div class="input-container">
                                    <i class="fas fa-calendar-check"></i>
                                    <input class="input_1" style="--borderColor: {{ $color_add }}" type="datetime-local" name="fecha_fin" id="fecha_fin" required>
                                </div>
                            </div>

                            <!-- Fecha_evento -->
                            <div class="cont_input_1">
                                <label for="fecha_evento">{{ __('Fecha límite') }}</label>
                                <div class="input-container">
                                    <i class="fas fa-clock"></i>
                                    <input class="input_1" style="--borderColor: {{ $color_add }}" type="datetime-local" name="fecha_evento" id="fecha_evento" required>
                                </div>
                            </div>

                            <!-- Aforo -->
                            <div class="cont_input_1">
                                <label for="aforo_evento">{{ __('Aforo') }}</label>
                                <div class="input-container">
                                    <i class="fas fa-users"></i>
                                    <input class="input_1" style="--borderColor: {{ $color_add }}" type="number" name="aforo_evento" id="aforo_evento" required>
                                </div>
                            </div>

                            <!-- Estado -->
                            <div class="cont_input_1" style="display:none;">
                                <label for="estado">{{ __('Estado') }}</label>
                                <div class="input-container">
                                    <i class="fas fa-flag"></i>
                                    <select name="estado" id="estado" class="input_1" style="--borderColor: {{ $color_add }}" required>
                                        <option value="ACTIVO" {{ old('estado', 'ACTIVO') == 'ACTIVO' ? 'selected' : '' }}>{{ __('Activo') }}</option>
                                        <option value="CANCELADO" {{ old('estado') == 'CANCELADO' ? 'selected' : '' }}>{{ __('Cancelado') }}</option>
                                        <option value="FINALIZADO" {{ old('estado') == 'FINALIZADO' ? 'selected' : '' }}>{{ __('Finalizado') }}</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Foto -->
                            <div class="cont_input_1">
                                <label for="Foto">Foto del Evento</label>
                                <div class="input-container">
                                    <i class="fas fa-camera"></i>
                                    <input class="input_1" style="--borderColor: {{ $color_add }}" type="file" id="Foto" name="Foto" accept="image/*">
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer" style="justify-content: center !important;">
                        <button type="submit" class="btn btn-primary" style="color: white;" id="saveAddButton">
                            <i class="fas fa-save"></i> 
                            Guardar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- AGREGAR: Script para manejar el modal de agregar -->
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                document.getElementById('saveAddButton').addEventListener('click', function () {
                    var form = document.getElementById('addForm');
                    if (form) {
                        form.submit(); // Enviar el formulario para agregar el nuevo evento
                    } else {
                        console.error("Formulario no encontrado.");
                    }
                });
            });
        </script>

        <!-- Modal Eliminar -->
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #dc3545; color: white;">
                        <h5 class="modal-title" id="exampleModalCenterTitle"><strong>Eliminar</strong></h5>
                        <i class="fa-solid fa-trash" style="margin-left: 10px"></i>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        ¿Estás seguro de que deseas eliminar este plan?
                    </div>

                    <div class="modal-footer" style="justify-content: center !important;">
                        <form id="deleteForm" method="POST" action="{{ route('planes.destroy', ':id') }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap 5 JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Script para el Modal Editar -->
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                var editModal = document.getElementById('editModal');
                editModal.addEventListener('show.bs.modal', function (event) {
                    var button = event.relatedTarget;
                    var form = document.getElementById('editForm');

                    // Extraer la información del botón
                    var id = button.getAttribute('data-id');
                    var evento_id = button.getAttribute('data-evento_id');
                    var tipo = button.getAttribute('data-tipo');
                    var precio = button.getAttribute('data-precio');
                    var descripcion = button.getAttribute('data-descripcion');

                    // Llenar los campos del formulario en el modal
                    document.getElementById('plan_id').value = id;
                    document.getElementById('evento_id').value = evento_id;
                    document.getElementById('tipo').value = tipo;
                    document.getElementById('precio').value = precio;
                    document.getElementById('descripcion').value = descripcion;

                    form.action = `/planes/${id}`;

                    console.log(evento_id, nombre, descripcion, direccion, telefono, aforo, tieneAsientos, foto);
                    
                    // Manejo de imagen previa (solo si existe una imagen)
                    var fotoInput = document.getElementById('Foto');
                    var existingPhotoContainer = document.getElementById('existingPhotoContainer');
                    if (foto && foto !== "null") {
                        existingPhotoContainer.innerHTML = `<img src="/storage/${foto}" alt="Imagen previa" width="100">`;
                    }

                    // Asignar la acción del formulario dinámicamente
                    var form = editModal.querySelector('form');
                    console.log(evento_id, tipo, precio, descripcion, Foto);
                    form.action = `/locales/${id}`; // Ajusta según tu ruta en Laravel
                });

                // Guardar el formulario
                document.getElementById('saveButton').addEventListener('click', function () {
                    var form = document.getElementById('editForm');
                    if (form) {
                        form.submit(); // Envía el formulario cuando el usuario hace clic en "Guardar"
                    } else {
                        console.error("Formulario no encontrado.");
                    }
                });
            });
        </script>

        <!-- Script para el Modal Eliminar -->
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                var deleteModal = document.getElementById('deleteModal');
                deleteModal.addEventListener('show.bs.modal', function (event) {
                    var button = event.relatedTarget;
                    var planId = button.getAttribute('data-id');
                    var formAction = document.getElementById('deleteForm').action;
                    document.getElementById('deleteForm').action = formAction.replace(':id', planId);
                });
            });
        </script>

        <!-- AOS JS -->
        <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
        <script>
            AOS.init();
        </script>
    </body>
</html>
