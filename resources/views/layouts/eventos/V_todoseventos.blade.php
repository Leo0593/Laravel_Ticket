<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('layouts.head')
    
    <body>
        @include('layouts.header')

        <div class="main">
            <div class="main_banner_2" style="--banner-image: url('../../images/dashboard/eventos.jpg');">
                <h1><strong>Diseña la Experiencia Perfecta</strong></h1>
                <h2>Planifica la Mejor Ubicación para tu Público</h2>
                
                <button class="btn-1" data-bs-toggle="modal" data-bs-target="#addModal">
                    Agregar
                </button>
            </div>

            <div class="main_contenedor">
                @if($noEventos)
                    <p>{{ __('No hay eventos') }}</p>
                @else
                    @foreach($eventos as $evento)
                        <div class="card" style="width: 18rem;box-shadow: 0 0 10px rgba(0, 0, 0, 0.4);">
                            <img class="card-img-top" 
                                src="{{ $evento->Foto ? asset('storage/' . $evento->Foto) : 'https://placehold.co/600x400' }}"  
                                alt="Foto del evento">

                            <div class="card-body">
                                <h5 class="card-title">{{ $evento->nombre }}</h5>
                                <p class="card-text">{{ $evento->descripcion }}</p>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><strong>UBICACIÓN: </strong>{{ $evento->local_id }} - {{ optional($evento->local)->Nombre }}</li>
                                <li class="list-group-item"><strong>AFORO: </strong>{{ $evento->aforo_evento }}</li>
                                <li class="list-group-item"><strong>FECHA: </strong>{{ $evento->fecha_evento }}</li>
                                <li class="list-group-item"><strong>FECHA VENTA: </strong>{{ $evento->fecha_inicio }}</li>
                                <li class="list-group-item"><strong>FECHA FIN VENTA: </strong>{{ $evento->fecha_fin }}</li>
                                <li class="list-group-item"><strong>ESTADO: </strong>{{ $evento->estado }}</li>
                            </ul>
                            <!-- Botón de edición dentro del cuerpo de la tarjeta -->
                            <div class="card-body d-flex justify-content-around" style="max-height: 70px;">
                                <!-- BOTÓN DE EDITAR CON MODAL -->
                                <button type="button" class="btn btn-warning btn-edit"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editModal"
                                    data-id="{{ $evento->id }}"
                                    data-user_id="{{ $evento->user_id }}"
                                    data-local_id="{{ $evento->local_id }}"
                                    data-nombre="{{ $evento->nombre }}"
                                    data-descripcion="{{ $evento->descripcion }}"
                                    data-fecha_inicio="{{ $evento->fecha_inicio }}"
                                    data-fecha_fin="{{ $evento->fecha_fin }}"
                                    data-fecha_evento="{{ $evento->fecha_evento }}"
                                    data-aforo_evento="{{ $evento->aforo_evento }}"
                                    data-estado="{{ $evento->estado }}"
                                    data-hora_evento="{{ $evento->hora_evento }}"
                                    data-foto="{{ $evento->foto }}">
                                    <i class="fas fa-edit"></i> Editar
                                </button>

                                <!-- BOTÓN DE ELIMINAR -->
                                <form action="{{ route('eventos.destroy', $evento->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#deleteModal"
                                            data-id="1" 
                                            data-nombre="Ejemplo Local">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                @endif
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
                        <form id="addForm" action="{{ route('eventos.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Usuario (oculto) -->
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

                            <!-- Usuario 
                            <div class="cont_input_1">
                                <label for="user_id">Usuario</label>
                                <div class="input-container">
                                    <i class="fas fa-user"></i> 
                                    <select style="--borderColor: {{ $color_add }}" name="user_id" id="user_id" class="input_1" required>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>-->

                            <!-- Local -->
                            <div class="cont_input_1">
                                <label for="local_id">{{ __('Local') }}</label>
                                <div class="input-container">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <select name="local_id" id="local_id" class="input_1" style="--borderColor: {{ $color_add }}" required>
                                        @foreach($locales as $local)
                                            <option value="{{ $local->id }}" data-aforo="{{ $local->Aforo }}">{{ $local->Nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Nombre -->
                            <div class="cont_input_1">
                                <label for="nombre">{{ __('Nombre') }}</label>
                                <div class="input-container">
                                    <i class="fas fa-pencil-alt"></i>
                                    <input class="input_1" style="--borderColor: {{ $color_add }}" type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                                </div>
                            </div>

                            <!-- Artista o Grupo -->
                            <div class="cont_input_1">
                                <label for="ArtistaGrupo">{{ __('Artista o Grupo') }}</label>
                                <div class="input-container">
                                    <i class="fas fa-microphone-alt"></i>
                                    <input class="input_1" style="--borderColor: {{ $color_add }}" type="text" id="ArtistaGrupo" name="ArtistaGrupo" value="{{ old('ArtistaGrupo') }}" maxlength="255">
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
                                    <input class="input_1" style="--borderColor: {{ $color_add }}" type="number" name="aforo_evento" id="aforo_evento" required value="{{ old('aforo_evento', 0) }}" max="0">
                                </div>
                            </div>

                            <!-- Estado -->
                            <div class="cont_input_1">
                                <label for="estado">{{ __('Estado') }}</label>
                                <div class="input-container">
                                    <i class="fas fa-flag"></i>
                                    <select name="estado" id="estado" class="input_1" style="--borderColor: {{ $color_add }}" required>
                                        <option value="ACTIVO" {{ old('estado') == 'ACTIVO' ? 'selected' : '' }}>{{ __('Activo') }}</option>
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

        <!-- Modal Editar -->
        @php
            $color_edit = 'var(--Edit)';
        @endphp

        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #ffcc00; align-items: center; color: white;">
                        <h5 class="modal-title" id="exampleModalCenterTitle"><strong>Editar</strong></h5>
                        <i class="fa-solid fa-pen" style="margin-left: 10px"></i>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form id="editForm"  action="{{ route('eventos.update', $local->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Usuario -->
                            <div class="cont_input_1">
                                <label for="user_id">Usuario</label>
                                <div class="input-container">
                                    <i class="fas fa-user"></i> 
                                    <select style="--borderColor: {{ $color_add }}" name="user_id" id="user_id" class="input_1" required>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Local -->
                            <div class="cont_input_1">
                                <label for="local_id">{{ __('Local') }}</label>
                                <div class="input-container">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <select name="local_id" id="local_id" class="input_1" style="--borderColor: {{ $color_add }}" required>
                                        @foreach($locales as $local)
                                            <option value="{{ $local->id }}" data-aforo="{{ $local->Aforo }}">{{ $local->Nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Nombre -->
                            <div class="cont_input_1">
                                <label for="nombre">{{ __('Nombre') }}</label>
                                <div class="input-container">
                                    <i class="fas fa-pencil-alt"></i>
                                    <input class="input_1" style="--borderColor: {{ $color_add }}" type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                                </div>
                            </div>

                            <!-- Artista o Grupo -->
                            <div class="cont_input_1">
                                <label for="ArtistaGrupo">{{ __('Artista o Grupo') }}</label>
                                <div class="input-container">
                                    <i class="fas fa-microphone-alt"></i>
                                    <input class="input_1" style="--borderColor: {{ $color_add }}" type="text" id="ArtistaGrupo" name="ArtistaGrupo" value="{{ old('ArtistaGrupo') }}" maxlength="255">
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

                            <!-- Si necesitas el campo hora_evento, agrégalo al formulario -->
                            <div class="cont_input_1">
                                <label for="hora_evento">{{ __('Hora del evento') }}</label>
                                <div class="input-container">
                                    <i class="fas fa-clock"></i>
                                    <input class="input_1" style="--borderColor: {{ $color_add }}" type="time" name="hora_evento" id="hora_evento">
                                </div>
                            </div>

                            <!-- Aforo -->
                            <div class="cont_input_1">
                                <label for="aforo_evento">{{ __('Aforo') }}</label>
                                <div class="input-container">
                                    <i class="fas fa-users"></i>
                                    <input class="input_1" style="--borderColor: {{ $color_add }}" type="number" name="aforo_evento" id="aforo_evento" required value="{{ old('aforo_evento', 0) }}">
                                </div>
                            </div>

                            <!-- Estado -->
                            <div class="cont_input_1">
                                <label for="estado">{{ __('Estado') }}</label>
                                <div class="input-container">
                                    <i class="fas fa-flag"></i>
                                    <select name="estado" id="estado" class="input_1" style="--borderColor: {{ $color_add }}" required>
                                        <option value="ACTIVO" {{ old('estado') == 'ACTIVO' ? 'selected' : '' }}>{{ __('Activo') }}</option>
                                        <option value="CANCELADO" {{ old('estado') == 'CANCELADO' ? 'selected' : '' }}>{{ __('Cancelado') }}</option>
                                        <option value="FINALIZADO" {{ old('estado') == 'FINALIZADO' ? 'selected' : '' }}>{{ __('Finalizado') }}</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Foto -->
                            <div class="cont_input_1">
                                <label for="Foto">Foto del Local</label>
                                <div class="input-container">
                                    <i class="fas fa-camera"></i>
                                    <input class="input_1" style="--borderColor: {{ $color_edit }}" type="file" id="Foto" name="Foto" accept="image/*">
                                </div>
                                <div id="existingPhotoContainer"></div> <!-- Contenedor para la foto previa -->
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer" style="justify-content: center !important;">
                        <button type="button" class="btn btn-warning" style="color: white;" id="saveButton">
                            <i class="fas fa-save"></i>
                            Actualizar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- EDITAR: Script para manejar el modal de edición -->
        <script>
             document.addEventListener("DOMContentLoaded", function () {
                var editModal = document.getElementById('editModal');

                editModal.addEventListener('show.bs.modal', function (event) {
                    var button = event.relatedTarget;
                    
                    // Limpiar los campos antes de llenarlos con los nuevos datos
                    document.getElementById('user_id').value = ''; // campo para el ID de usuario
                    document.getElementById('local_id').value = ''; // campo para el ID del local
                    document.getElementById('nombre').value = ''; // campo para el nombre del evento
                    document.getElementById('descripcion').value = ''; // campo para la descripción
                    document.getElementById('fecha_inicio').value = ''; // campo para la fecha de inicio
                    document.getElementById('fecha_fin').value = ''; // campo para la fecha de fin
                    document.getElementById('fecha_evento').value = ''; // campo para la fecha del evento
                    document.getElementById('aforo_evento').value = ''; // campo para el aforo
                    document.getElementById('estado').value = ''; // campo para el estado
                    document.getElementById('hora_evento').value = ''; // campo para la hora del evento
                    document.getElementById('Foto').value = ''; // campo para la foto
                    document.getElementById('existingPhotoContainer').innerHTML = ''; // campo para mostrar la foto existente
                    
                    // Extraer la información del botón
                    var id = button.getAttribute('data-id');
                    var userId = button.getAttribute('data-user_id');
                    var localId = button.getAttribute('data-local_id');
                    var nombre = button.getAttribute('data-nombre');
                    var descripcion = button.getAttribute('data-descripcion');
                    var fechaInicio = button.getAttribute('data-fecha_inicio');
                    var fechaFin = button.getAttribute('data-fecha_fin');
                    var fechaEvento = button.getAttribute('data-fecha_evento');
                    var aforoEvento = button.getAttribute('data-aforo_evento');
                    var estado = button.getAttribute('data-estado');
                    var horaEvento = button.getAttribute('data-hora_evento');
                    var foto = button.getAttribute('data-foto');

                    // Llenar los campos del formulario en el modal con los datos correspondientes
                    document.getElementById('user_id').value = userId || '';
                    document.getElementById('local_id').value = localId || '';
                    document.getElementById('nombre').value = nombre || '';
                    document.getElementById('descripcion').value = descripcion || '';
                    document.getElementById('fecha_inicio').value = fechaInicio || '';
                    document.getElementById('fecha_fin').value = fechaFin || '';
                    document.getElementById('fecha_evento').value = fechaEvento || '';
                    document.getElementById('aforo_evento').value = aforoEvento || '';
                    document.getElementById('estado').value = estado || '';
                    document.getElementById('hora_evento').value = horaEvento || '';
                    
                    // Mostrar la foto si existe
                    var existingPhotoContainer = document.getElementById('existingPhotoContainer');
                    existingPhotoContainer.innerHTML = foto ? `<img src="/storage/${foto}" alt="Imagen previa" width="100">` : '';

                    // Asignar la acción del formulario dinámicamente
                    var form = document.getElementById('editForm');
                    form.action = `/eventos/${id}`;
                });
                // Guardar el formulario
                document.getElementById('saveButton').addEventListener('click', function () {
                    document.getElementById('editForm').submit();
                });
            });
        </script> 

        <!-- Modal Eliminar -->
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <!-- Encabezado del modal -->
                    <div class="modal-header" style="background-color: #dc3545; color: white;">
                        <h5 class="modal-title" id="exampleModalCenterTitle">
                            <strong>Eliminar</strong> <i class="fa-solid fa-trash" style="margin-left: 10px;"></i>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="color: white;"></button>
                    </div>

                    <!-- Cuerpo del modal -->
                    <div class="modal-body text-center">
                        ¿Estás seguro de que deseas eliminar: <strong id="deleteLocalName"></strong>?
                    </div>

                    <!-- Pie del modal -->
                    <div class="modal-footer" style="justify-content: center;">
                        <form id="deleteForm" method="POST" action="{{ route('locales.destroy', ':id') }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger px-4">Eliminar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Script para manejar el modal de eliminación -->
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                var deleteModal = document.getElementById('deleteModal');

                deleteModal.addEventListener('show.bs.modal', function (event) {
                    var link = event.relatedTarget; // El enlace que activó el modal
                    var localId = link.getAttribute('data-id'); // Obtener el ID del local
                    var localName = link.getAttribute('data-nombre'); // Obtener el nombre del local

                    // Actualizar el texto dentro del modal
                    document.getElementById('deleteLocalName').textContent = localName;

                    // Actualizar la acción del formulario de eliminación
                    var formAction = document.getElementById('deleteForm').action;
                    document.getElementById('deleteForm').action = formAction.replace(':id', localId);
                });
            });
        </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </body>
</html>
