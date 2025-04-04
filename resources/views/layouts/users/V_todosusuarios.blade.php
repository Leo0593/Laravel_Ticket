<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('layouts.head')

<body>
    @include('layouts.header')

    <div class="main">
        <div class="main_banner_2" data-aos="fade-down" data-aos-duration="1000"
            style="--banner-image: url('../../images/dashboard/users.jpg');">
            <h1><strong>Gestión de Usuarios</strong></h1>
            <h2>Administra cuentas, roles y accesos de tus usuarios</h2>

            <button class="btn-1" data-bs-toggle="modal" data-bs-target="#addModal">
                Agregar
            </button>

            <!--
            <a href="{{ route('tickets.usuarios.tickets') }}" class="btn btn-info scale">
                <i class="fa-solid fa-ticket"></i>
            </a> -->

        </div>

        <div class="main_contenedor">
            @if($noUser)
                <p>{{ __('No hay usuarios') }}</p>
            @else
                @foreach($users as $user)
                @if($user->visible)
                    <div class="card scale" style="width: 18rem;box-shadow: 8px 10px 10px var(--colorShadow);">
                        <img class="card-img-top"
                            src="{{ $user->Foto ? asset('storage/' . $user->Foto) : 'https://placehold.co/600x400' }}"
                            alt="Foto del local">

                        <div class="card-body">
                            <h4 class="card-title m-0"><i class="fa fa-user-circle" aria-hidden="true"></i> {{ $user->name }}
                                {{ $user->last_name }}</h5>
                        </div>

                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong><i class="fa fa-bookmark" aria-hidden="true"></i></strong>
                                {{ $user->role }}</li>
                            <li class="list-group-item"><strong><i class="fa fa-phone" aria-hidden="true"></i></strong>
                                {{ $user->phone }}</li>
                            <li class="list-group-item"><strong><i class="fa fa-envelope" aria-hidden="true"></i></strong>
                                {{ $user->email }}</li>
                        </ul>

                        <div class="card-body d-flex justify-content-around" style="max-height: 70px; min-height: 70px;">
                            <a href="#" class="btn btn-warning scale" style="color: white;" data-bs-toggle="modal"
                                data-bs-target="#editModal" data-nombre="{{ $user->name }}"
                                data-apellido="{{ $user->last_name }}" data-rol="{{ $user->role }}"
                                data-telefono="{{ $user->phone }}" data-correo="{{ $user->email }}"
                                data-foto="{{ $user->Foto }}" data-id="{{ $user->id }}" data-estado="{{ $user->estado }}">
                                <i class="fa-solid fa-pen"></i>
                            </a>

                            <a href="#" class="btn btn-danger scale" 
                                data-bs-toggle="modal" data-bs-target="#deleteModal"
                                data-id="{{ $user->id }}" data-nombre="{{ $user->name }}">
                                    <i class="fa-solid fa-trash"></i>
                                </a>

                            <a href="{{ route('tickets.usuariostotales.tickets', $user->id) }}" class="btn btn-info scale">
                                <i class="fa-solid fa-ticket" style="color: white;"></i> 
                            </a>

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
            <div class="modal-content" style="color: white;">
                <div class="modal-header" style="background-color: {{ $color_edit }}; align-items: center;">
                    <h5 class="modal-title" id="addModalLabel"><strong>Agregar</strong></h5>
                    <i class="fa-solid fa-plus-circle" style="margin-left: 10px"></i>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body" style="color: black;">
                    <form id="editForm" action="{{ route('users.update', ':id') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="cont_input_1">
                            <label for="name">{{ __('Nombre') }}</label>
                            <div class="input-container">
                                <i class="fas fa-user"></i>
                                <input type="text" class="input_1" style="--borderColor: {{ $color_edit }}" name="name"
                                    id="name" required>
                            </div>
                        </div>

                        <div class="cont_input_1">
                            <label for="last_name">{{ __('Apellido') }}</label>
                            <div class="input-container">
                                <i class="fa fa-user-plus" aria-hidden="true"></i>
                                <input type="text" class="input_1" style="--borderColor: {{ $color_edit }}"
                                    name="last_name" id="last_name" required>
                            </div>
                        </div>

                        <div class="cont_input_1">
                            <label for="role">{{ __('Rol') }}</label>
                            <div class="input-container">
                                <i class="fa fa-bookmark" aria-hidden="true"></i>
                                <select class="input_1" style="--borderColor: {{ $color_edit }}" name="role" id="role"
                                    required>
                                    <option value="" disabled selected>Selecciona un rol</option>
                                    <option value="USER">Usuario</option>
                                    <option value="GESTOR">Gestor</option>
                                    <option value="ADMIN">Administrador</option>
                                </select>
                            </div>
                        </div>

                        <div class="cont_input_1">
                            <label for="phone">{{ __('Teléfono') }}</label>
                            <div class="input-container">
                                <i class="fa fa-phone" aria-hidden="true"></i>
                                <input type="number" class="input_1" style="--borderColor: {{ $color_edit }}"
                                    name="phone" id="phone" required>
                            </div>
                        </div>

                        <!--
                            <div class="cont_input_1">
                                <label for="email">{{ __('Correo') }}</label>
                                <div class="input-container">
                                <i class="fa fa-envelope" aria-hidden="true"></i>
                                    <input type="text" class="input_1" style="--borderColor: {{ $color_edit }}" name="email" id="email" required>
                                </div>
                            </div>-->

                        <div class="cont_input_1">
                            <label for="estado">{{ __('Estado') }}</label>
                            <div class="input-container">
                                <i class="fa fa-toggle-on" aria-hidden="true"></i>
                                <select class="input_1" style="--borderColor: {{ $color_edit }}" name="estado"
                                    id="estado" required>
                                    <option value="0" {{ old('estado', $user->estado) == 0 ? 'selected' : '' }}>Inactivo
                                    </option>
                                    <option value="1" {{ old('estado', $user->estado) == 1 ? 'selected' : '' }}>Activo
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="cont_input_1">
                            <label for="Foto">{{ __('Foto') }}</label>
                            <div class="input-container">
                                <i class="fas fa-camera"></i>
                                <input type="file" class="input_1" style="--borderColor: {{ $color_edit }}" name="Foto"
                                    id="Foto">
                            </div>
                            <div id="existingPhotoContainer"></div>
                        </div>
                    </form>

                    <div class="modal-footer" style="justify-content: center !important;">
                        <button type="submit" class="scale btn btn-warning " style="color: white;" id="saveButton">
                            <i class="fas fa-save"></i>
                            Guardar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- EDITAR: Script para manejar el modal de edición -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var editModal = document.getElementById('editModal');

            editModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget; // Botón que activó el modal

                // Limpiar los campos antes de llenarlos con los nuevos datos
                document.getElementById('name').value = '';
                document.getElementById('last_name').value = '';
                document.getElementById('role').value = '';
                document.getElementById('phone').value = '';
                document.getElementById('email').value = '';
                document.getElementById('estado').value = '';
                document.getElementById('Foto').value = '';
                document.getElementById('existingPhotoContainer').innerHTML = '';

                // Extraer la información del botón
                var nombre = button.getAttribute('data-nombre');
                var apellido = button.getAttribute('data-apellido');
                var rol = button.getAttribute('data-rol');
                var telefono = button.getAttribute('data-telefono');
                var correo = button.getAttribute('data-correo');
                var foto = button.getAttribute('data-foto');
                var id = button.getAttribute('data-id');
                var estado = button.getAttribute('data-estado');

                // Llenar los campos del formulario en el modal
                document.getElementById('name').value = nombre;
                document.getElementById('last_name').value = apellido;
                document.getElementById('role').value = rol;
                document.getElementById('phone').value = telefono;
                document.getElementById('email').value = correo;
                document.getElementById('estado').value = estado;

                console.log(id, nombre, apellido, rol, telefono, correo, estado, foto);

                // Manejo de imagen previa (solo si existe una imagen)
                var fotoInput = document.getElementById('Foto');
                var existingPhotoContainer = document.getElementById('existingPhotoContainer');
                if (foto && foto !== "null") {
                    existingPhotoContainer.innerHTML = `<img src="/storage/${foto}" alt="Imagen previa" width="100">`;
                }

                // Asignar la acción del formulario dinámicamente
                var form = editModal.querySelector('form');
                form.action = `/users/${id}`; // Ajusta según tu ruta en Laravel
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
                    <form id="addForm" action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="cont_input_1">
                            <label for="name">{{ __('Nombre') }}</label>
                            <div class="input-container">
                                <i class="fas fa-user"></i>
                                <input type="text" class="input_1" style="--borderColor: {{ $color_add }}" name="name"
                                    id="name" required>
                            </div>
                        </div>

                        <div class="cont_input_1">
                            <label for="last_name">{{ __('Apellido') }}</label>
                            <div class="input-container">
                                <i class="fa fa-user-plus" aria-hidden="true"></i>
                                <input type="text" class="input_1" style="--borderColor: {{ $color_add }}"
                                    name="last_name" id="last_name" required>
                            </div>
                        </div>

                        <div class="cont_input_1">
                            <label for="role">{{ __('Rol') }}</label>
                            <div class="input-container">
                                <i class="fa fa-bookmark" aria-hidden="true"></i>
                                <select class="input_1" style="--borderColor: {{ $color_add }}" name="role" id="role"
                                    required>
                                    <option value="" disabled selected>Selecciona un rol</option>
                                    <option value="USER">Usuario</option>
                                    <option value="GESTOR">Gestor</option>
                                    <option value="ADMIN">Administrador</option>
                                </select>
                            </div>
                        </div>

                        <div class="cont_input_1">
                            <label for="phone">{{ __('Teléfono') }}</label>
                            <div class="input-container">
                                <i class="fa fa-phone" aria-hidden="true"></i>
                                <input type="number" class="input_1" style="--borderColor: {{ $color_add }}"
                                    name="phone" id="phone" required>
                            </div>
                        </div>

                        <div class="cont_input_1">
                            <label for="email">{{ __('Correo') }}</label>
                            <div class="input-container">
                                <i class="fa fa-envelope" aria-hidden="true"></i>
                                <input type="text" class="input_1" style="--borderColor: {{ $color_add }}" name="email"
                                    id="email" required>
                            </div>
                        </div>

                        <div class="cont_input_1">
                            <label for="password">{{ __('Contraseña') }}</label>
                            <div class="input-container">
                                <i class="fas fa-lock"></i>
                                <input type="text" class="input_1" style="--borderColor: {{ $color_add }}"
                                    name="password" id="password" required>
                            </div>
                        </div>

                        <div class="cont_input_1">
                            <label for="Foto">{{ __('Foto') }}</label>
                            <div class="input-container">
                                <i class="fas fa-camera"></i>
                                <input type="file" class="input_1" style="--borderColor: {{ $color_add }}" name="Foto"
                                    id="Foto" required>
                            </div>
                        </div>


                    </form>

                    <div class="modal-footer" style="justify-content: center !important;">
                        <button type="submit" class="scale btn btn-primary " style="color: white;" id="saveAddButton">
                            <i class="fas fa-plus"></i>
                            Guardar
                        </button>
                    </div>
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
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #dc3545; align-items: center; color: white;">
                    <h5 class="modal-title" id="deleteModalLabel"><strong>Eliminar</strong></h5>
                    <i class="fa-solid fa-trash" style="margin-left: 10px"></i>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    ¿Estás seguro de que deseas eliminar: <strong id="deleteLocalName"></strong>?
                </div>

                <div class="modal-footer" style="justify-content: center !important;">
                    <form id="deleteForm" method="POST" action="{{ route('users.ocultar', ':id') }}">
                        @csrf
                        <button type="submit" class="btn btn-danger">Eliminar</button>
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
                var userId = link.getAttribute('data-id'); // Obtener el ID del local
                var userName = link.getAttribute('data-nombre'); // Obtener el nombre del local

                console.log(userId, userName);

                // Actualizar el texto dentro del modal
                document.getElementById('deleteLocalName').textContent = userName;

                // Actualizar la acción del formulario de eliminación
                var formAction = document.getElementById('deleteForm').action;
                document.getElementById('deleteForm').action = formAction.replace(':id', userId);
            });
        });
    </script>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>