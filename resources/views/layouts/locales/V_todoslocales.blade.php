<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('layouts.head')
    
    <body>
        @include('layouts.header')

        <div class="main">
            <div class="main_banner_2" 
            data-aos="fade-down" data-aos-duration="1000" 
            style="--banner-image: url('../../images/dashboard/estadio-1.webp');">
                <h1><strong> Lugares para Tú Evento</strong></h1>
                <h2>Encuentra Tu Lugar Perfecto</h2>

                <button class="btn-1" data-bs-toggle="modal" data-bs-target="#addModal">
                    Agregar
                </button>
            </div>

            <div class="main_organizar" data-aos="zoom-in" data-aos-duration="1000">
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

                            <div class="dropup" style="margin-left: 15px;">
                                <button class="btn btn-outline-primary dropdown-toggle" type="button" id="asientosDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    Asientos                
                                </button>

                                <ul class="dropdown-menu" aria-labelledby="asientosDropdown">
                                    <!-- Opción "Todos" -->
                                    <li>
                                        <label class="dropdown-item">
                                            <input type="radio" name="asientos" value="" {{ !request('asientos') ? 'checked' : '' }} onchange="this.form.submit()">
                                            Todos
                                        </label>
                                    </li>
                                    <!-- Opción "Con asientos" -->
                                    <li>
                                        <label class="dropdown-item">
                                            <input type="radio" name="asientos" value="0" {{ request('asientos') == '0' ? 'checked' : '' }} onchange="this.form.submit()">
                                            Con asientos
                                        </label>
                                    </li>
                                    <!-- Opción "Sin asientos" -->
                                    <li>
                                        <label class="dropdown-item">
                                            <input type="radio" name="asientos" value="1" {{ request('asientos') == '1' ? 'checked' : '' }} onchange="this.form.submit()">
                                            Sin asientos
                                        </label>
                                    </li>
                                </ul>
                            </div>

                            <!--
                            <button type="submit" name="orderBy" value="asientos" class="btn btn-outline-primary {{ request('orderBy') == 'asientos' ? 'active' : '' }}">
                                Asientos ({{ request('showWithoutSeats', '0') == '1' ? 'Sin asientos' : 'Con asientos' }})
                            </button>
                            <input type="hidden" name="showWithoutSeats" value="{{ request('showWithoutSeats', '0') == '1' ? '0' : '1' }}">
                            -->
                        </div>
                    </div> 
                </form>
            </div>

            <div class="main_contenedor" data-aos="fade-up" data-aos-duration="1000">
                @if($noLocales)
                    <div class="alert alert-primary" role="alert">
                        <p class="mb-0">{{ __('No hay locales aun.') }}</p>
                    </div>
                @else
                    @foreach($locales as $local)
                        @if($local->visible)
                        <div class="ver-evento">
                            <div class="ver-evento-info">
                                <p class="card-title">
                                    <i class="fas fa-building"></i> 
                                    {{ $local->Nombre }}
                                </p>

                                <p class="card-title">
                                    <i class="fas fa-map-marker-alt"></i> 
                                    {{ $local->Direccion }}
                                </p>

                                <!--
                                <p class="card-title">
                                    <i class="fas fa-users"></i>
                                    {{ $local->Aforo }}
                                </p>

                                <p class="card-title">
                                    <i class="fas fa-phone-alt"></i>
                                    {{ $local->Telefono }}
                                </p> -->

                                @if($local->Tiene_Asientos)
                                    <p class="card-title text-success">
                                        <i class="fas fa-chair"></i>
                                        Tiene asientos
                                    </p>
                                @else
                                    <p class="card-title text-danger">
                                        <i class="fas fa-chair"></i>
                                        No tiene asientos
                                    </p>
                                @endif

                                <p class="card-text">
                                    <span class="info-icon">
                                        <i class="fas fa-align-left"></i> 
                                        <span class="descripcion-corta">
                                            {{ Str::limit($local->Descripcion, 100, '...') }} <!-- Solo muestra 100 caracteres -->
                                        </span>
                                        <br>
                                    </span>
                                </p>
                            </div>

                            <div class="ver-evento-foto" 
                                style="background-image: linear-gradient(to top, rgba(0, 0, 0, 0.9), rgba(0, 0, 0, 0.02) 70%), 
                                url('{{ $local->Foto ? asset('storage/' . $local->Foto) : 'https://placehold.co/600x400' }}');">
                            
                                <div class="ver-evento-foto-btns">
                                    <a href="#" class="btns" style="background-color: var(--color); text-decoration: none;"
                                        data-bs-toggle="modal" data-bs-target="#viewModal"
                                        data-nombre="{{ $local->Nombre }}"
                                        data-descripcion="{{ $local->Descripcion }}"
                                        data-direccion="{{ $local->Direccion }}"
                                        data-telefono="{{ $local->Telefono }}"
                                        data-aforo="{{ $local->Aforo }}"
                                        data-asiento="{{ $local->Tiene_Asientos }}"  
                                        data-foto="{{ $local->Foto }}"              
                                        >
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="#" class="btns" style="background-color: var(--Edit); text-decoration: none;" 
                                        data-bs-toggle="modal" data-bs-target="#editModal" 
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
                                    <a href="#" class="btns" style="background-color: var(--Delete); text-decoration: none;" 
                                        data-bs-toggle="modal" data-bs-target="#deleteModal" 
                                        data-id="{{ $local->id }}" data-nombre="{{ $local->Nombre }}">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endif
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
                                <label for="Direccion">Dirección</label>
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
                            <div class="cont_input_1" style="width: 100%; display: flex; align-items: center;">
                                <label for="Tiene_Asientos">Tiene Asientos</label>
                                <input  style="margin-left: 8px" type="checkbox" id="Tiene_Asientos" name="Tiene_Asientos" value="1">
                                <i class="fas fa-chair" style="margin-left: 8px; color: {{ $color_edit }}; font-size: 20px;"></i> 
                                
                                <!--
                                <div class="input-container-2" style="--borderColor: {{ $color_edit }}">
                                    <i class="fas fa-chair"></i> 
                                    <input class="input_1" type="checkbox" id="Tiene_Asientos" name="Tiene_Asientos" value="1">
                                </div>-->
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
                        <form id="deleteForm" method="POST" action="{{ route('locales.ocultar', ':id') }}">
                            @csrf
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

                    <div class="modal-body" style="color: black;">
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
                            <div class="cont_input_1" style="width: 100%; display: flex; align-items: center;">
                                <label for="Tiene_Asientos">Tiene Asientos</label>
                                <input  style="margin-left: 8px" type="checkbox" id="Tiene_Asientos" name="Tiene_Asientos" value="1">
                                <i class="fas fa-chair" style="margin-left: 8px; color: {{ $color_add }}; font-size: 20px;"></i> 
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

        <!-- Modal Ver -->
        <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" style="max-width: 80%;">
                <div class="modal-content" style="color: white;">
                    <div class="modal-header" style="background-color: {{ $color_add }}; align-items: center;">
                        <h5 class="modal-title" id="addModalLabel"><strong><i class="fa fa-info-circle" aria-hidden="true"></i>
                        Info</strong></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body" style="color: black; padding: 50px;">
                    <div style="width: 100%; overflow: hidden;">
                        <div id="modalFoto" 
                            style="float: right; margin-left: 15px; margin-bottom: 15px;
                            width: 55%; height: 350px; border-radius: 10px; overflow: hidden;
                            background-image: url('https://placehold.co/600x400'); 
                            background-size: cover;
                            background-position: center;
                            background-repeat: no-repeat;">
                            </div>

                        <h1 class="titulo" style="font-size: 3.5rem; margin-bottom: 25px;" id="modalNombre"></h1>
                        <ul style="font-size: 1.2rem; margin-bottom: 25px;">
                            <li><strong>Dirección:</strong> <span id="modalDireccion"></span></li>
                            <li><strong>Telefono:</strong> <span id="modalTelefono"></span></li>
                            <li><strong>Aforo:</strong> <span id="modalAforo"></span></li>   
                            <li><strong>Tiene Asientos:</strong> <span id="modalAsientos"></span></li>
                        </ul>

                        <p><span id="modalDescripcion"></span></p>
                        </div>
                    </div>                
                </div>
            </div>
        </div>

        <!-- Script Ver -->
        <script>
            // Función de sanitización básica
            function decodeHtml(html) {
                var txt = document.createElement("textarea");
                txt.innerHTML = html;
                return txt.value;
            }

            document.addEventListener("DOMContentLoaded", function () {
                let viewModal = document.getElementById("viewModal");

                viewModal.addEventListener("show.bs.modal", function (event) {
                    let button = event.relatedTarget; // Botón que activó el modal

                    // Obtener los valores del botón
                    let nombre = button.getAttribute("data-nombre");
                    let descripcion = button.getAttribute("data-descripcion");
                    let telefono = button.getAttribute("data-telefono");
                    let aforo = button.getAttribute("data-aforo");
                    let direccion = button.getAttribute("data-direccion");
                    let asiento = button.getAttribute("data-asiento");
                    let foto = button.getAttribute("data-foto");

                    console.log(nombre, descripcion, telefono, aforo, direccion, asiento);

                    // Asignar valores al modal
                    document.getElementById("modalNombre").textContent = nombre;

                    // Decodificar la descripción
                    let decodedDescripcion = decodeHtml(descripcion);
                    document.getElementById("modalDescripcion").innerHTML = decodedDescripcion || "Descripción no disponible";


                    document.getElementById("modalTelefono").textContent = telefono;
                    document.getElementById("modalAforo").textContent = aforo;
                    document.getElementById("modalDireccion").textContent = direccion;
                    document.getElementById("modalAsientos").textContent = asiento === "1" ? "Sí" : "No";
    
                    console.log(foto);
                    
                    let modalFoto = document.getElementById("modalFoto");
                    if (foto) {
                        // Si hay foto, establecer la imagen de fondo
                        modalFoto.style.backgroundImage = `url('/storage/${foto}')`; // Imagen dinámica
                    } else {
                        // Si no hay foto, poner una imagen de fondo predeterminada
                        modalFoto.style.backgroundImage = 'url(https://placehold.co/600x400)';
                    }
                });
            });
        </script>

        <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
        <script>
            AOS.init();
        </script>
    </body>
</html>