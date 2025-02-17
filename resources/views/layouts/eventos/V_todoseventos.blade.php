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
                    <div class="alert alert-primary" role="alert">
                        <p class="mb-0">{{ __('No hay eventos aun.') }}</p>
                    </div>
                @else
                    @foreach($eventos as $evento)
                        <div class="ver-evento">
                            <div class="ver-evento-info">
                                <p class="card-title">
                                    <i class="fas fa-microphone-alt"></i> 
                                    {{ $evento->ArtistaGrupo }}
                                </p>

                                <p class="card-title">
                                    <i class="fas fa-pencil-alt"></i> 
                                    {{ $evento->nombre }}
                                </p>

                                <p class="card-title">
                                    <i class="fas fa-map-marker-alt"></i>
                                    {{ $evento->local_id }} - {{ optional($evento->local)->Nombre }}
                                </p>

                                <p class="card-text">
                                    <span class="info-icon">
                                        <i class="fas fa-align-left"></i> 
                                        <span class="descripcion-corta">
                                            {{ Str::limit($evento->descripcion, 100, '...') }} <!-- Solo muestra 100 caracteres -->
                                        </span>
                                        <span class="descripcion-larga" style="display: none;">
                                            {{ $evento->descripcion }} <!-- Texto completo -->
                                        </span>
                                        <br>
                                        <button class="ver-mas-btn" onclick="toggleDescripcion(this)">Ver más</button>
                                    </span>
                                </p>
                            </div>

                            @php
                                $fecha = \Carbon\Carbon::parse($evento->fecha_evento);
                            @endphp

                            <div class="ver-evento-foto" 
                                style="background-image: url('{{ $evento->Foto ? asset('storage/' . $evento->Foto) : 'https://placehold.co/600x400' }}');">

                                <div class="ver-evento-foto-fecha">
                                    <div style="font-size: 12px; color: var(--Delete)">{{ $fecha->format('M') }}</div>
                                    <div style="font-size: 25px;">{{ $fecha->day }}</div> 
                                    <div style="font-size: 10px; color: gray;">{{ $fecha->locale('es')->dayName }}</div>
                                </div>       

                                <div class="ver-evento-foto-datos"
                                    style="background-color: 
                                            {{ $evento->estado == 'ACTIVO' ? 'var(--Add)' : 
                                                ($evento->estado == 'FINALIZADO' ? 'white' : 
                                                'var(--Delete)') }};
                                            color: {{ $evento->estado == 'FINALIZADO' ? 'black' : 'white' }};">
                                    {{ $evento->estado }}
                                </div>

                                <div class="ver-evento-foto-btns">
                                    <a href="#" class="btns" style="background-color: var(--color); text-decoration: none;">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="#" class="btns" style="background-color: var(--Edit); text-decoration: none;" 
                                    data-bs-toggle="modal" data-bs-target="#editModal"
                                        data-id="{{ $evento->id }}"
                                        data-user_id="{{ $evento->user_id }}"
                                        data-local_id="{{ $evento->local_id }}"
                                        data-nombre="{{ $evento->nombre }}"
                                        data-descripcion="{{ $evento->descripcion }}"
                                        data-artista="{{ $evento->ArtistaGrupo }}"
                                        data-fecha_inicio="{{ $evento->fecha_inicio }}"
                                        data-fecha_fin="{{ $evento->fecha_fin }}"
                                        data-fecha_evento="{{ $evento->fecha_evento }}"
                                        data-aforo_evento="{{ $evento->aforo_evento }}"
                                        data-estado="{{ $evento->estado }}"
                                        data-foto="{{ $evento->Foto }}">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <a href="#" class="btns" style="background-color: var(--Delete); text-decoration: none;" 
                                    data-bs-toggle="modal" data-bs-target="#deleteModal"
                                        data-id="{{ $evento->id }}" data-nombre="{{ $evento->nombre }}">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        <!-- Modal Editar -->
        @php
            $color_edit = 'var(--Edit)';
        @endphp
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: {{ $color_edit }}; align-items: center; color: white;">
                        <h5 class="modal-title"  id="exampleModalCenterTitle"><strong>Editar</strong></h5>
                        <i class="fa-solid fa-pen" style="margin-left: 10px"></i>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form id="editForm" action="{{ route('eventos.update', $evento->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

                            <!-- Artista o Grupo -->
                            <div class="cont_input_1">
                                <label for="ArtistaGrupo">Artista o Grupo</label>
                                <div class="input-container">
                                    <i class="fas fa-microphone-alt"></i>
                                    <input class="input_1" style="--borderColor: {{ $color_edit }}" type="text" id="ArtistaGrupo" name="ArtistaGrupo" maxlength="255">
                                </div>
                            </div>

                            <!-- Nombre -->
                            <div class="cont_input_1">
                                <label for="nombre">Nombre</label>
                                <div class="input-container">
                                    <i class="fas fa-sync-alt"></i> 
                                    <input class="input_1" style="--borderColor: {{ $color_edit }}" type="text" id="nombre" name="nombre" required>
                                </div>
                            </div>

                            <!-- Local -->
                            <div class="cont_input_1">
                                <label for="local_id">Local</label>
                                <div class="input-container">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <select name="local_id" id="local_id" class="input_1" style="--borderColor: {{ $color_edit }}" required>
                                        @foreach($locales as $local)
                                            <option value="{{ $local->id }}" data-aforo="{{ $local->Aforo }}">{{ $local->Nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Descripción -->
                            <div class="cont_input_1">
                                <label for="descripcion">Descripción</label>
                                <div class="textarea-container">
                                    <i class="fas fa-align-left"></i>
                                    <textarea class="input_1" style="--borderColor: {{ $color_edit }}" name="descripcion" id="descripcion"></textarea>
                                </div>
                            </div>

                            <!-- Fecha_inicio -->
                            <div class="cont_input_1">
                                <label for="fecha_inicio">Fecha de inicio</label>
                                <div class="input-container">
                                    <i class="fas fa-calendar-alt"></i>
                                    <input class="input_1" style="--borderColor: {{ $color_edit }}" type="datetime-local" name="fecha_inicio" id="fecha_inicio" required>
                                </div>
                            </div>

                            <!-- Fecha_fin -->
                            <div class="cont_input_1">
                                <label for="fecha_fin">Fecha de fin</label>
                                <div class="input-container">
                                    <i class="fas fa-calendar-check"></i>
                                    <input class="input_1" style="--borderColor: {{ $color_edit }}" type="datetime-local" name="fecha_fin" id="fecha_fin" required>
                                </div>
                            </div>

                            <!-- Fecha_evento -->
                            <div class="cont_input_1">
                                <label for="fecha_evento">Fecha límite</label>
                                <div class="input-container">
                                    <i class="fas fa-clock"></i>
                                    <input class="input_1" style="--borderColor: {{ $color_edit }}" type="datetime-local" name="fecha_evento" id="fecha_evento" required>
                                </div>
                            </div>

                            <!-- Aforo -->
                            <div class="cont_input_1">
                                <label for="aforo_evento">Aforo</label>
                                <div class="input-container">
                                    <i class="fas fa-users"></i>
                                    <input class="input_1" style="--borderColor: {{ $color_edit }}" type="number" name="aforo_evento" id="aforo_evento" required min="0">
                                </div>
                            </div>

                            <!-- Estado -->
                            <div class="cont_input_1">
                                <label for="estado">Estado</label>
                                <div class="input-container">
                                    <i class="fas fa-flag"></i>
                                    <select name="estado" id="estado" class="input_1" style="--borderColor: {{ $color_edit }}" required>
                                        <option value="ACTIVO">Activo</option>
                                        <option value="CANCELADO">Cancelado</option>
                                        <option value="FINALIZADO">Finalizado</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Foto -->
                            <div class="cont_input_1">
                                <label for="Foto">Foto del Evento</label>
                                <div class="input-container">
                                    <i class="fas fa-camera"></i>
                                    <input class="input_1" style="--borderColor: {{ $color_edit }}" type="file" id="Foto" name="Foto" accept="image/*">
                                </div>
                                <div id="existingPhotoContainer"></div> <!-- Contenedor para la foto previa -->
                            </div>

                            <div class="modal-footer" style="justify-content: center !important;">
                                <button type="submit" class="btn btn-warning" style="color: white;" id="saveButtonEdit">
                                    <i class="fas fa-save"></i>
                                    Actualizar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- EDITAR: Script para manejar el modal de edición -->
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                var editModal = document.getElementById('editModal');
                console.log('Modal Editar abierto');

                editModal.addEventListener('show.bs.modal', function (event) {
                    var button = event.relatedTarget; // Botón que activó el modal

                    // Limpiar los campos antes de llenarlos con los nuevos datos
                    document.getElementById('nombre').value = '';
                    document.getElementById('ArtistaGrupo').value = '';
                    document.getElementById('local_id').value = '';
                    document.getElementById('descripcion').value = '';
                    document.getElementById('fecha_inicio').value = '';
                    document.getElementById('fecha_fin').value = '';
                    document.getElementById('fecha_evento').value = '';
                    document.getElementById('aforo_evento').value = '';
                    document.getElementById('estado').value = '';
                    document.getElementById('Foto').value = '';
                    document.getElementById('existingPhotoContainer').innerHTML = '';

                    // Extraer la información del botón
                    var id = button.getAttribute('data-id');
                    var nombre = button.getAttribute('data-nombre');
                    var artista = button.getAttribute('data-artista');
                    var local_id = button.getAttribute('data-local_id');
                    var descripcion = button.getAttribute('data-descripcion');
                    var user_id = button.getAttribute('data-user_id');
                    var local_id = button.getAttribute('data-local_id');
                    var fecha_inicio = button.getAttribute('data-fecha_inicio');
                    var fecha_fin = button.getAttribute('data-fecha_fin');
                    var fecha_evento = button.getAttribute('data-fecha_evento');
                    var aforo_evento = button.getAttribute('data-aforo_evento');
                    var estado = button.getAttribute('data-estado');
                    var fotoevento = button.getAttribute('data-foto');

                    console.log(id, nombre, artista, descripcion, user_id, local_id, fecha_inicio, fecha_fin, fecha_evento, aforo_evento, estado, fotoevento);

                    // Llenar los campos del formulario en el modal
                    document.getElementById('nombre').value = nombre;
                    document.getElementById('ArtistaGrupo').value = artista;
                    document.getElementById('local_id').value = local_id;
                    document.getElementById('descripcion').value = descripcion;
                    document.getElementById('fecha_inicio').value = fecha_inicio;
                    document.getElementById('fecha_fin').value = fecha_fin;
                    document.getElementById('fecha_evento').value = fecha_evento;
                    document.getElementById('aforo_evento').value = aforo_evento;
                    document.getElementById('estado').value = estado;

                    // Manejo de imagen previa (solo si existe una imagen)
                    var fotoInput = document.getElementById('Foto');
                    var existingPhotoContainer = document.getElementById('existingPhotoContainer');
                    if (fotoevento && fotoevento !== "null") {
                        existingPhotoContainer.innerHTML = `<img src="/storage/${fotoevento}" alt="Imagen previa" width="100">`;
                    }
                    
                    // Asignar la acción del formulario dinámicamente
                    var form = editModal.querySelector('form');
                    console.log(id,nombre, artista, id, user_id, local_id, fecha_inicio, fecha_fin, fecha_evento, aforo_evento, estado, fotoevento);
                    form.action = `/eventos/${id}`; // Ajusta según tu ruta en Laravel*/
                    console.log(form.action);
                });

                // Guardar el formulario
                document.getElementById('saveButtonEdit').addEventListener('click', function () {
                    event.preventDefault(); // Prevenir el envío inmediato del formulario

                    var form = document.getElementById('editForm');
                    if (form) {
                        var formData = new FormData(form);
                        formData.forEach((value, key) => {
                            console.log(`${key}: ${value}`); // Muestra los datos que se van a enviar
                        });

                        form.submit(); // Enviar el formulario
                    } else {
                        console.error("Formulario no encontrado.");
                    }
                });
            });
        </script> 

        <!-- Modal Eliminar -->
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #dc3545; align-items: center; color: white;">
                        <h5 class="modal-title"  id="exampleModalCenterTitle"><strong>Eliminar</strong></h5>
                        <i class="fa-solid fa-trash" style="margin-left: 10px"></i>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        ¿Estás seguro de que deseas eliminar: <strong id="deleteLocalName"></strong>?
                    </div>

                    <div class="modal-footer" style="justify-content: center !important;">
                        <form id="deleteForm" method="POST" action="{{ route('eventos.destroy', ':id') }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- ELIMINAR: Script para manejar el modal de eliminación -->
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                var deleteModal = document.getElementById('deleteModal');

                deleteModal.addEventListener('show.bs.modal', function (event) {
                    var link = event.relatedTarget; // El enlace que activó el modal
                    var eventoId = link.getAttribute('data-id'); // Obtener el ID del local
                    var eventoNombre = link.getAttribute('data-nombre'); // Obtener el nombre del local

                    // Actualizar el texto dentro del modal
                    document.getElementById('deleteLocalName').textContent = eventoNombre;

                    // Actualizar la acción del formulario de eliminación
                    var formAction = document.getElementById('deleteForm').action;
                    document.getElementById('deleteForm').action = formAction.replace(':id', eventoId);
                });
            });
        </script>

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

        <!-- Bootstrap 5 JS (Necesario para los modales) -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <!--
                                        <span class="tooltip-content">
                                            info
                                </span> 
        
        <script>
            document.querySelectorAll('.info-icon').forEach(icon => {
                icon.addEventListener('mouseenter', function() {
                    const tooltip = this.querySelector('.tooltip-content');
                    tooltip.style.visibility = 'visible';
                    tooltip.style.opacity = '1';
                });

                icon.addEventListener('mouseleave', function() {
                    const tooltip = this.querySelector('.tooltip-content');
                    tooltip.style.visibility = 'visible';
                    tooltip.style.opacity = '1';
                    /*tooltip.style.visibility = 'hidden';
                    tooltip.style.opacity = '0';*/
                });
            });
        </script>-->

        <script>
            function toggleDescripcion(button) {
                let corta = button.previousElementSibling.previousElementSibling; // Descripción corta
                let larga = button.previousElementSibling; // Descripción larga

                if (larga.style.display === "none") {
                    corta.style.display = "none"; // Oculta la corta
                    larga.style.display = "inline"; // Muestra la larga
                    button.textContent = "Ver menos";
                } else {
                    corta.style.display = "inline"; // Muestra la corta
                    larga.style.display = "none"; // Oculta la larga
                    button.textContent = "Ver más";
                }
            }
        </script>
    </body>
</html>
