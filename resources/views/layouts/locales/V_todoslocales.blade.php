<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('layouts.head')
    
    <body>
        @include('layouts.header')

        <div class="main">
            <div class="main_banner_2" style="--banner-image: url('../../images/dashboard/estadio-1.webp');">
                <h1><strong> Lugares para Tú Evento</strong></h1>
                <h2>Encuentra Tu Lugar Perfecto</h2>

                <!-- -->
                <button class="btn-1" data-bs-toggle="modal" data-bs-target="#addModal">
                    Agregar
                </button>
            </div>

            <div class="main_organizar">
                <form method="GET" action="">
                    <h4>Ordenar por:</h4>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="btn-group">
                            <button type="submit" name="orderBy" value="nombre" class="btn btn-outline-primary {{ request('orderBy') == 'nombre' ? 'active' : '' }}">
                                Nombre
                            </button>
                            <button type="submit" name="orderBy" value="aforo" class="btn btn-outline-primary {{ request('orderBy') == 'aforo' ? 'active' : '' }}">
                                Aforo
                            </button>
                            <button type="submit" name="orderBy" value="ubicacion" class="btn btn-outline-primary {{ request('orderBy') == 'ubicacion' ? 'active' : '' }}">
                                Ubicación
                            </button>
                            <button type="submit" name="orderBy" value="asientos" class="btn btn-outline-primary {{ request('orderBy') == 'asientos' ? 'active' : '' }}">
                                Asientos
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="main_contenedor">
                @if($noLocales)
                    <p>{{ __('No hay locales') }}</p>
                @else
                    @foreach($locales as $local)
                        <div class="card" style="width: 18rem;box-shadow: 0 0 10px rgba(2, 77, 223, 0.4);"> <!-- rgba(0, 0, 0, 0.4) -->
                            <img class="card-img-top" 
                                src="{{ $local->Foto ? asset('storage/' . $local->Foto) : 'https://placehold.co/600x400' }}"  
                                alt="Foto del local">

                            <div class="card-body">
                                <h5 class="card-title">{{ $local->Nombre }}</h5>
                                <p class="card-text">{{ $local->Descripcion }}</p>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><strong>UBICACIÓN: </strong>{{ $local->Direccion }}</li>
                                <li class="list-group-item"><strong>TELÉFONO: </strong>{{ $local->Telefono }}</li>
                                <li class="list-group-item"><strong>AFORO: </strong>{{ $local->Aforo }}</li>
                                <li class="list-group-item"><strong>ASIENTOS: </strong>{{ $local->Tiene_Asientos ? 'Tiene Asientos' : 'No tiene Asientos' }}</li>
                            </ul>
                            <div class="card-body d-flex justify-content-around" style="max-height: 70px;">
                                <!--
                                <a href="#" class="btn btn-primary">
                                    <i class="fa-solid fa-eye"></i>
                                </a>-->
                                <a href="#" class="btn btn-warning" style="color: white;" data-bs-toggle="modal" data-bs-target="#editModal" 
                                    data-id="{{ $local->id }}"
                                    data-nombre="{{ $local->Nombre }}"
                                    data-descripcion="{{ $local->Descripcion }}"
                                    data-direccion="{{ $local->Direccion }}"
                                    data-telefono="{{ $local->Telefono }}"
                                    data-aforo="{{ $local->Aforo }}"
                                    data-tiene_asientos="{{ $local->Tiene_Asientos }}"
                                    data-foto="{{ $local->Foto }}">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                <a href="#" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $local->id }}"data-nombre="{{ $local->Nombre }}">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
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
                        <form id="editForm" action="{{ route('locales.update', $local->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Nombre -->
                            <div class="cont_input_1">
                                <label for="Nombre">Nombre</label>
                                <div class="input-container">
                                    <i class="fas fa-building"></i> 
                                    <input class="input_1" style="--borderColor: {{ $color_edit }}" type="text" id="Nombre" name="Nombre" value="" required>
                                </div>
                            </div>

                            <!-- Descripcion -->
                            <div class="cont_input_1">
                                <label for="Descripcion">Descripcion</label>
                                <div class="textarea-container">
                                    <i class="fas fa-pencil-alt"></i> 
                                    <textarea class="input_1" style="--borderColor: {{ $color_edit }}" id="Descripcion" name="Descripcion" required></textarea>
                                </div>
                            </div>

                            <!-- Direccion -->
                            <div class="cont_input_1">
                                <label for="Nombre">Dirección</label>
                                <div class="input-container">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <input class="input_1" style="--borderColor: {{ $color_edit }}" type="text" id="Direccion" name="Direccion" value="" required>
                                </div>
                            </div>

                            <!-- Telefono -->
                            <div class="cont_input_1">
                                <label for="Telefono">Teléfono</label>
                                 <div class="input-container">
                                    <i class="fas fa-phone"></i> 
                                    <input class="input_1" style="--borderColor: {{ $color_edit }}" type="number" id="Telefono" name="Telefono" value="" required>
                                </div>
                            </div>

                            <!-- Aforo -->
                            <div class="cont_input_1">
                                    <label for="Aforo">Aforo</label>
                                    <div class="input-container">
                                        <i class="fas fa-users"></i> 
                                        <input class="input_1" style="--borderColor: {{ $color_edit }}" type="number" id="Aforo" name="Aforo" value="" required>
                                    </div>
                            </div>

                            <!-- Campo oculto para manejar el caso desmarcado -->
                            <input type="hidden" name="Tiene_Asientos" value="0">

                            <!-- Tiene Asientos -->
                            <div class="cont_input_1" style="width: 100px;">
                                <label for="Tiene_Asientos">Tiene Asientos</label>
                                <div class="input-container-2" style="--borderColor: {{ $color_edit }}">
                                    <i class="fas fa-chair"></i> 
                                    <input class="input_1" type="checkbox" id="Tiene_Asientos" name="Tiene_Asientos" value="1">
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
                        <form id="deleteForm" method="POST" action="{{ route('locales.destroy', ':id') }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
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
                        <form id="addForm" action="{{ route('locales.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Nombre -->
                            <div class="cont_input_1">
                                <label for="Nombre">Nombre</label>
                                <div class="input-container">
                                    <i class="fas fa-building"></i> 
                                    <input class="input_1" style="--borderColor: {{ $color_add }}" type="text" id="Nombre" name="Nombre" required>
                                </div>
                            </div>

                            <!-- Descripción -->
                            <div class="cont_input_1">
                                <label for="Descripcion">Descripción</label>
                                <div class="textarea-container">
                                    <i class="fas fa-pencil-alt"></i> 
                                    <textarea class="input_1" style="--borderColor: {{ $color_add }}" id="Descripcion" name="Descripcion" required></textarea>
                                </div>
                            </div>

                            <!-- Dirección -->
                            <div class="cont_input_1">
                                <label for="Direccion">Dirección</label>
                                <div class="input-container">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <input class="input_1" style="--borderColor: {{ $color_add }}" type="text" id="Direccion" name="Direccion" required>
                                </div>
                            </div>

                            <!-- Teléfono -->
                            <div class="cont_input_1">
                                <label for="Telefono">Teléfono</label>
                                <div class="input-container">
                                    <i class="fas fa-phone"></i> 
                                    <input class="input_1" style="--borderColor: {{ $color_add }}" type="number" id="Telefono" name="Telefono" required>
                                </div>
                            </div>

                            <!-- Aforo -->
                            <div class="cont_input_1">
                                <label for="Aforo">Aforo</label>
                                <div class="input-container">
                                    <i class="fas fa-users"></i> 
                                    <input class="input_1" style="--borderColor: {{ $color_add }}" type="number" id="Aforo" name="Aforo" required>
                                </div>
                            </div>

                            <!-- Tiene Asientos -->
                            <div class="cont_input_1" style="width: 100px;">
                                <label for="Tiene_Asientos">Tiene Asientos</label>
                                <div class="input-container-2" style="--borderColor: {{ $color_add }}">
                                    <i class="fas fa-chair"></i> 
                                    <input class="input_1" type="checkbox" id="Tiene_Asientos" name="Tiene_Asientos" value="1">
                                </div>
                            </div>

                            <!-- Foto -->
                            <div class="cont_input_1">
                                <label for="Foto">Foto del Local</label>
                                <div class="input-container">
                                    <i class="fas fa-camera"></i>
                                    <input class="input_1" style="--borderColor: {{ $color_add }}" type="file" id="Foto" name="Foto" accept="image/*">
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer" style="justify-content: center !important;">
                        <button type="button" class="btn btn-primary" style="color: white;" id="saveAddButton">
                            <i class="fas fa-save"></i> 
                            Guardar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap 5 JS (Necesario para los modales) -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <!-- EDITAR: Script para manejar el modal de edición -->
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                var editModal = document.getElementById('editModal');

                editModal.addEventListener('show.bs.modal', function (event) {
                    var button = event.relatedTarget; // Botón que activó el modal

                    // Limpiar los campos antes de llenarlos con los nuevos datos
                    document.getElementById('Nombre').value = '';
                    document.getElementById('Descripcion').value = '';
                    document.getElementById('Direccion').value = '';
                    document.getElementById('Telefono').value = '';
                    document.getElementById('Aforo').value = '';
                    document.getElementById('Tiene_Asientos').checked = false;
                    document.getElementById('Foto').value = '';
                    document.getElementById('existingPhotoContainer').innerHTML = '';

                    // Extraer la información del botón
                    var id = button.getAttribute('data-id');
                    var nombre = button.getAttribute('data-nombre');
                    var descripcion = button.getAttribute('data-descripcion');
                    var direccion = button.getAttribute('data-direccion');
                    var telefono = button.getAttribute('data-telefono');
                    var aforo = button.getAttribute('data-aforo');
                    var tieneAsientos = button.getAttribute('data-tiene_asientos') == "1";
                    var foto = button.getAttribute('data-foto');

                    // Llenar los campos del formulario en el modal
                    document.getElementById('Nombre').value = nombre;
                    document.getElementById('Descripcion').value = descripcion;
                    document.getElementById('Direccion').value = direccion;
                    document.getElementById('Telefono').value = telefono;
                    document.getElementById('Aforo').value = aforo;
                    document.getElementById('Tiene_Asientos').checked = tieneAsientos;

                    console.log(id, nombre, descripcion, direccion, telefono, aforo, tieneAsientos, foto);
                    
                    // Manejo de imagen previa (solo si existe una imagen)
                    var fotoInput = document.getElementById('Foto');
                    var existingPhotoContainer = document.getElementById('existingPhotoContainer');
                    if (foto && foto !== "null") {
                        existingPhotoContainer.innerHTML = `<img src="/storage/${foto}" alt="Imagen previa" width="100">`;
                    }

                    // Asignar la acción del formulario dinámicamente
                    var form = editModal.querySelector('form');
                    console.log(id, nombre, descripcion, direccion, telefono, aforo, tieneAsientos, foto);
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

        <!-- ELIMINAR: Script para manejar el modal de eliminación -->
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

        <!-- AGREGAR: Script para manejar el modal de agregar -->
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                document.getElementById('saveAddButton').addEventListener('click', function () {
                    var form = document.getElementById('addForm');
                    if (form) {
                        form.submit(); // Enviar el formulario para agregar el nuevo local
                    } else {
                        console.error("Formulario no encontrado.");
                    }
                });
            });
        </script>
    </body>
</html>