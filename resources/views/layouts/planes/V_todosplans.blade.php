<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('layouts.head')

<body>
    @include('layouts.header')

    <div class="main">
        <div class="main_banner_2" data-aos="fade-down" data-aos-duration="1000"
            style="--banner-image: url('../../images/dashboard/plans.png');">
            <h1><strong>Planes para Todos</strong></h1>
            <h2>Combos Generales o VIP, ¡Tú Decides!</h2>

            <button class="btn-1" data-bs-toggle="modal" data-bs-target="#addModal">
                Agregar
            </button>
        </div>

        <div class="main_contenedor">
            <div class="container-fluid main_contenedor">
                @if($noPlanes)
                    <div class="alert alert-warning text-center" role="alert">
                        <p class="mb-0">{{ __('No hay planes disponibles') }}</p>
                    </div>
                @else
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <input type="text" id="searchInput" placeholder="Buscar..." class="form-control"
                                onkeyup="filterResults()">
                        </div>
                        <div class="col-md-4">
                            <select id="tipoSelect" class="form-control" onchange="filterResults()">
                                <option value="">Todos los tipos</option>
                                <option value="General">General</option>
                                <option value="VIP">VIP</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select id="estadoSelect" class="form-control" onchange="filterResults()">
                                <option value="">Todos los estados</option>
                                <option value="ACTIVO">ACTIVO</option>
                                <option value="CANCELADO">CANCELADO</option>
                                <option value="FINALIZADO">FINALIZADO</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <input type="number" id="minPrice" placeholder="Precio mínimo" class="form-control"
                                onkeyup="filterResults()">
                        </div>
                        <div class="col-md-4">
                            <input type="number" id="maxPrice" placeholder="Precio máximo" class="form-control"
                                onkeyup="filterResults()">
                        </div>
                    </div>
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
                                                            <tr data-estado-evento="{{ $plan->estadoEvento }}">
                                                                <!-- Aquí se agrega el estado del evento -->
                                                                <td class="text-center">{{ $plan->tipo }}</td>
                                                                <td class="text-center">{{ $plan->precio }}</td>
                                                                <td class="text-center">{{ $plan->descripcion }}</td>
                                                                <td class="text-center">
                                                                    @if($plan->Foto)
                                                                        <img src="{{ asset('storage/' . $plan->Foto) }}" alt="Foto del plan"
                                                                            class="w-20 h-20 object-cover rounded-md">
                                                                    @else
                                                                        {{ __('No Disponible') }}
                                                                    @endif
                                                                </td>
                                                                <td class="text-center">
                                                                    <a href="#" class="btn btn-sm btn-warning scale"
                                                                        style="color: white; text-decoration: none;"
                                                                        data-bs-toggle="modal" data-bs-target="#editModal"
                                                                        data-id="{{ $plan->id }}"
                                                                        data-evento_id="{{ $plan->evento_id }}"
                                                                        data-tipo="{{ $plan->tipo }}" data-precio="{{ $plan->precio }}"
                                                                        data-descripcion="{{ $plan->descripcion }}"
                                                                        data-foto="{{ $plan->Foto }}">
                                                                        <i class="fa-solid fa-pen"></i>
                                                                    </a>

                                                                    <a href="#" class="btn btn-sm btn-danger scale"
                                                                        style="background-color: var(--Delete); text-decoration: none;"
                                                                        data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                                        data-id="{{ $plan->id }}" data-tipo="{{ $plan->tipo }}"
                                                                        data-precio="{{ $plan->precio }}"
                                                                        data-descripcion="{{ $plan->descripcion }}">
                                                                        <i class="fa-solid fa-trash"></i>
                                                                    </a>
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

        <script>
            function filterResults() {
                const query = document.getElementById('searchInput').value.toLowerCase();
                const tipo = document.getElementById('tipoSelect').value;
                const estado = document.getElementById('estadoSelect').value;
                const minPrice = parseFloat(document.getElementById('minPrice').value) || 0; // Obtener precio mínimo
                const maxPrice = parseFloat(document.getElementById('maxPrice').value) || Infinity; // Obtener precio máximo
                const cards = document.querySelectorAll('.card');

                cards.forEach(card => {
                    const nombreEvento = card.querySelector('.card-header h5').textContent.toLowerCase();
                    const planes = card.querySelectorAll('tbody tr');

                    let eventoVisible = false;

                    planes.forEach(plan => {
                        const planTipo = plan.querySelector('td:nth-child(1)').textContent;
                        const planPrecio = parseFloat(plan.querySelector('td:nth-child(2)').textContent);

                        // Obtener el estado del evento desde el atributo del plan
                        const estadoEvento = plan.getAttribute('data-estado-evento');

                        const tipoCoincide = tipo ? planTipo === tipo : true;
                        const estadoCoincide = estado ? estadoEvento === estado : true; // Cambiar a estadoEvento
                        const precioCoincide = (planPrecio >= minPrice && planPrecio <= maxPrice); // Filtrar por precio

                        if (nombreEvento.includes(query) && tipoCoincide && estadoCoincide && precioCoincide) {
                            plan.style.display = ""; // Mostrar si coincide
                            eventoVisible = true;
                        } else {
                            plan.style.display = "none"; // Ocultar si no coincide
                        }
                    });

                    card.style.display = eventoVisible ? "" : "none"; // Mostrar o ocultar la tarjeta del evento
                });
            }
        </script>

        @php
            $color_edit = 'var(--Edit)';
        @endphp
        <!-- Modal Editar -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header"
                        style="background-color: {{ $color_edit }}; align-items: center; color: white;">
                        <h5 class="modal-title" id="exampleModalCenterTitle"><strong>Editar</strong></h5>
                        <i class="fa-solid fa-pen" style="margin-left: 10px"></i>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form id="editForm" action="{{ route('planes.update', ':id') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Evento -->
                            <div class="cont_input_1">
                                <label for="evento_id">{{ __('Evento') }}</label>
                                <div class="input-container">
                                    <i class="fas fa-music"></i>
                                    <select name="evento_id" id="evento_id" class="input_1"
                                        style="--borderColor: {{ $color_edit }}" required>
                                        <option value="" disabled selected>Selecciona un evento</option>
                                        @foreach($eventos as $evento)
                                            <option value="{{ $evento->id }}">{{ $evento->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="cont_input_1">
                                <label for="tipo">{{ __('Tipo') }}</label>
                                <div class="input-container">
                                    <i class="fas fa-sticky-note"></i>
                                    <select name="tipo" id="tipo" class="input_1"
                                        style="--borderColor: {{ $color_edit }}" required>
                                        <option value="" disabled selected>Selecciona un tipo de plan</option>
                                        <option value="General">General</option>
                                        <option value="VIP">VIP</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Precio -->
                            <div class="cont_input_1">
                                <label for="precio">{{ __('Precio') }}</label>
                                <div class="input-container">
                                    <i class="fas fa-dollar-sign"></i>
                                    <input type="number" class="input_1" style="--borderColor: {{ $color_edit }}"
                                        name="precio" id="precio" required>
                                </div>
                            </div>

                            <!-- Descripción -->
                            <div class="cont_input_1">
                                <label for="descripcion">{{ __('Descripción') }}</label>
                                <div class="textarea-container">
                                    <i class="fas fa-align-left"></i>
                                    <textarea class="input_1" style="--borderColor: {{ $color_edit }}"
                                        name="descripcion" id="descripcion"></textarea>
                                </div>
                            </div>

                            <!-- Foto -->
                            <div class="cont_input_1">
                                <label for="Foto">{{ __('Foto del Plan') }}</label>
                                <div class="input-container">
                                    <i class="fas fa-camera"></i>
                                    <input type="file" class="input_1" style="--borderColor: {{ $color_edit }}"
                                        name="Foto" id="Foto" accept="image/*">
                                </div>
                                <div id="existingPhotoContainer"></div>
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
                    var button = event.relatedTarget; // Botón que activó el modal

                    // Limpiar los campos antes de llenarlos con los nuevos datos
                    document.getElementById('evento_id').value = '';
                    document.getElementById('tipo').value = '';
                    document.getElementById('precio').value = '';
                    document.getElementById('descripcion').value = '';
                    document.getElementById('Foto').value = '';
                    document.getElementById('existingPhotoContainer').innerHTML = '';

                    // Extraer la información del botón
                    var id = button.getAttribute('data-id');
                    var evento_id = button.getAttribute('data-evento_id');
                    var tipo = button.getAttribute('data-tipo');
                    var precio = button.getAttribute('data-precio');
                    var descripcion = button.getAttribute('data-descripcion');
                    var foto = button.getAttribute('data-foto');

                    // Llenar los campos del formulario en el modal
                    document.getElementById('evento_id').value = evento_id;
                    document.getElementById('tipo').value = tipo;
                    document.getElementById('precio').value = precio;
                    document.getElementById('descripcion').value = descripcion;

                    console.log(id, evento_id, tipo, precio, descripcion, foto);

                    // Manejo de imagen previa (solo si existe una imagen)
                    var fotoInput = document.getElementById('Foto');
                    var existingPhotoContainer = document.getElementById('existingPhotoContainer');
                    if (foto && foto !== "null") {
                        existingPhotoContainer.innerHTML = `<img src="/storage/${foto}" alt="Imagen previa" width="100">`;
                    }

                    // Asignar la acción del formulario dinámicamente
                    var form = editModal.querySelector('form');
                    form.action = `/planes/${id}`; // Ajusta según tu ruta en Laravel
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
                        <form id="addForm" action="{{ route('planes.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf

                            <!-- Evento -->
                            <div class="cont_input_1">
                                <label for="evento_id">{{ __('Evento') }}</label>
                                <div class="input-container">
                                    <i class="fas fa-music"></i>
                                    <select name="evento_id" id="evento_id" class="input_1"
                                        style="--borderColor: {{ $color_add }}" required>
                                        <option value="" disabled selected>Selecciona un evento</option>
                                        @foreach($eventos as $evento)
                                            <option value="{{ $evento->id }}">{{ $evento->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="cont_input_1">
                                <label for="tipo">{{ __('Tipo') }}</label>
                                <div class="input-container">
                                    <i class="fas fa-sticky-note"></i>
                                    <select name="tipo" id="tipo" class="input_1"
                                        style="--borderColor: {{ $color_add }}" required>
                                        <option value="" disabled selected>Selecciona un tipo de plan</option>
                                        <option value="General">General</option>
                                        <option value="VIP">VIP</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Precio -->
                            <div class="cont_input_1">
                                <label for="precio">{{ __('Precio') }}</label>
                                <div class="input-container">
                                    <i class="fas fa-dollar-sign"></i>
                                    <input type="number" class="input_1" style="--borderColor: {{ $color_add }}"
                                        name="precio" id="precio" required>
                                </div>
                            </div>

                            <!-- Descripción -->
                            <div class="cont_input_1">
                                <label for="descripcion">{{ __('Descripción') }}</label>
                                <div class="textarea-container">
                                    <i class="fas fa-align-left"></i>
                                    <textarea class="input_1" style="--borderColor: {{ $color_add }}" name="descripcion"
                                        id="descripcion"></textarea>
                                </div>
                            </div>

                            <!-- Foto -->
                            <div class="cont_input_1">
                                <label for="Foto">{{ __('Foto del Plan') }}</label>
                                <div class="input-container">
                                    <i class="fas fa-camera"></i>
                                    <input type="file" class="input_1" style="--borderColor: {{ $color_add }}"
                                        name="Foto" id="Foto" accept="image/*">
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
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #dc3545; align-items: center; color: white;">
                        <h5 class="modal-title" id="exampleModalCenterTitle"><strong>Eliminar</strong></h5>
                        <i class="fa-solid fa-trash" style="margin-left: 10px"></i>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        ¿Estás seguro de que deseas eliminar: <strong id="deleteLocalName"></strong>?
                    </div>

                    <div class="modal-footer" style="justify-content: center !important;">
                        <form id="deleteForm" method="POST" action="{{ route('planes.ocultar', ':id') }}">
                            @csrf
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
                    var planId = link.getAttribute('data-id'); // Obtener el ID del local
                    var planNombre = link.getAttribute('data-tipo'); // Obtener el nombre del local
                    var planPrecio = link.getAttribute('data-precio'); // Obtener el precio del local
                    var planDescripcion = link.getAttribute('data-descripcion'); // Obtener la descripción del local

                    // Actualizar el texto dentro del modal
                    document.getElementById('deleteLocalName').textContent = planId + ' - ' + planNombre + ' - ' + planPrecio + ' - ' + planDescripcion;

                    // Actualizar la acción del formulario de eliminación
                    var formAction = document.getElementById('deleteForm').action;
                    document.getElementById('deleteForm').action = formAction.replace(':id', planId);
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