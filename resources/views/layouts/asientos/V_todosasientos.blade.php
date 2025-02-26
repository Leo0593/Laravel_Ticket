<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('layouts.head')

<body>
    @include('layouts.header')

    <div class="main">
        <div class="main_banner_2" data-aos="fade-down" data-aos-duration="1000"
            style="--banner-image: url('../../images/dashboard/asientos.png');">
            <h1><strong>Asientos para Cada Ocasión</strong></h1>
            <h2>Disfruta de la Comodidad en Tu Evento</h2>
        </div>

        <div class="main_contenedor">
            <div class="container-fluid main_contenedor">
                <!-- Sección de Filtros -->
                <div class="main_organizar mb-3" data-aos="zoom-in" data-aos-duration="1000">
                    <h4 style="margin-bottom: 10px;">Ordenar por:</h4>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="btn-group">
                            <!-- Campo de búsqueda -->
                            <div class="d-flex align-items-center mb-3">
                                <input type="text" class="form-control" id="searchInput"
                                    placeholder="Buscar evento por nombre" aria-label="Buscar evento"
                                    style="margin-right: 10px;">
                                <!-- Se elimina el botón de búsqueda ya que ahora filtra en tiempo real -->
                            </div>
                            <!-- Desplegable para seleccionar el estado -->
                            <div class="dropup" style="margin-left: 15px; margin-top: 5px;">
                                <button class="btn btn-outline-primary dropdown-toggle" type="button"
                                    id="estadoDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    Estado
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="estadoDropdown">
                                    <li>
                                        <label class="dropdown-item">
                                            <input type="radio" name="estado" value="" {{ !request('estado') ? 'checked' : '' }} onchange="filtrarEstado('todos')">
                                            Todos
                                        </label>
                                    </li>
                                    <li>
                                        <label class="dropdown-item">
                                            <input type="radio" name="estado" value="Disponible" {{ request('estado') == 'Disponible' ? 'checked' : '' }}
                                                onchange="filtrarEstado('Disponible')">
                                            Disponible
                                        </label>
                                    </li>
                                    <li>
                                        <label class="dropdown-item">
                                            <input type="radio" name="estado" value="Ocupado" {{ request('estado') == 'Ocupado' ? 'checked' : '' }}
                                                onchange="filtrarEstado('Ocupado')">
                                            Ocupado
                                        </label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                @if($noAsientos)
                    <div class="alert alert-warning text-center" role="alert">
                        <p class="mb-0">{{ __('No hay asientos disponibles') }}</p>
                    </div>
                @else
                    <div class="row w-100 d-flex flex-wrap" style="gap: 25px;">
                        @foreach($eventos as $evento)
                            <div class="d-flex flex-column" style="flex: 1 1 calc(50% - 25px);">
                                <div class="card shadow-sm">
                                    <div class="card-header bg-primary text-white text-center">
                                        <h5 class="mb-0">{{ $evento->nombre }} - {{ $evento->local->Nombre }}</h5>
                                    </div>
                                    <div class="card-body p-0 mb-0">
                                        @if($asientos->where('evento_id', $evento->id)->isEmpty())
                                            <p class="text-center text-muted">No hay asientos para este evento.</p>
                                        @else
                                            <div class="table-responsive">
                                                <table class="table table-striped table-hover m-0">
                                                    <thead class="table-dark">
                                                        <tr>
                                                            <th class="text-center">{{ __('Plan ID') }}</th>
                                                            <th class="text-center">{{ __('Tipo') }}</th>
                                                            <th class="text-center">{{ __('Número') }}</th>
                                                            <th class="text-center">{{ __('Estado') }}</th>
                                                            <th class="text-center">{{ __('Acciones') }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($asientos->where('evento_id', $evento->id) as $asiento)
                                                            <tr class="asiento-row" data-estado="{{ $asiento->estado }}">
                                                                <td class="text-center">
                                                                    {{ $asiento->plan_id }} - {{ optional($asiento->plan)->tipo }}
                                                                </td>
                                                                <td class="text-center">{{ $asiento->tipo }}</td>
                                                                <td class="text-center">{{ $asiento->numero_asiento }}</td>
                                                                <td class="text-center">
                                                                    <span
                                                                        class="badge {{ $asiento->estado == 'Disponible' ? 'bg-success' : 'bg-danger' }}">
                                                                        {{ $asiento->estado }}
                                                                    </span>
                                                                </td>
                                                                <td class="text-center">
                                                                    <a href="#" class="scale btn btn-sm btn-warning"
                                                                        style="color: white;" data-bs-toggle="modal"
                                                                        data-bs-target="#editModal" data-id="{{ $asiento->id }}"
                                                                        data-estado="{{ $asiento->estado }}">
                                                                        <i class="fa-solid fa-pen"></i>
                                                                    </a>
                                                                    <a href="#" class="btn btn-sm btn-danger scale"
                                                                        data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                                        data-id="{{ $asiento->id }}">
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
            document.querySelectorAll('.filter-btn').forEach(button => {
                button.addEventListener('click', function () {
                    let estadoSeleccionado = this.getAttribute('data-estado');

                    // Remover la clase "active" de todos los botones y agregar solo al seleccionado
                    document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');

                    filtrarEstado(estadoSeleccionado);
                });
            });

            function filtrarEstado(estadoSeleccionado) {
                let filas = document.querySelectorAll('.asiento-row');
                filas.forEach(fila => {
                    let estado = fila.getAttribute('data-estado');
                    fila.style.display = (estadoSeleccionado === "todos" || estado === estadoSeleccionado) ? "" : "none";
                });
            }

            // Búsqueda de eventos en tiempo real
            document.getElementById('searchInput').addEventListener('input', function () {
                let query = this.value.toLowerCase();
                let filas = document.querySelectorAll('.card');

                filas.forEach(fila => {
                    let eventoNombre = fila.querySelector('.card-header h5').textContent.toLowerCase();
                    fila.style.display = eventoNombre.includes(query) ? "" : "none"; // Mostrar si coincide
                });
            });
        </script>

        <!-- Modal Editar -->
        @php
            $color_edit = 'var(--Edit)';
        @endphp
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
                        <form id="editForm" action="{{ route('asientos.update', $asiento->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="cont_input_1">
                                <label for="local_select">Local</label>
                                <div class="input-container">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <select name="local_id" id="local_id" class="input_1"
                                        style="--borderColor: {{ $color_edit }}" required>
                                        <option value="" disabled selected>Selecciona un local</option>
                                        @foreach($locales as $local)
                                            <option value="{{ $local->id }}" data-aforo="{{ $local->Aforo }}">
                                                {{ $local->Nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="cont_input_1">
                                <label for="evento_select">Evento</label>
                                <div class="input-container">
                                    <i class="fas  fa-music"></i> <!-- fa-paper-plane -->
                                    <select name="evento_id" id="evento_id" class="input_1"
                                        style="--borderColor: {{ $color_edit }}" required>
                                        <option value="" disabled selected>Selecciona un local</option>
                                        @foreach($eventos as $evento)
                                            <option value="{{ $evento->id }}" data-aforo="{{ $evento->aforo }}">
                                                {{ $evento->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="cont_input_1">
                                <label for="plan_select">Plan</label>
                                <div class="input-container">
                                    <i class="fas fa-sticky-note"></i>
                                    <select name="plan_id" id="plan_id" class="input_1"
                                        style="--borderColor: {{ $color_edit }}" required>
                                        <option value="" disabled selected>Selecciona un plan</option>
                                        @foreach($planes as $plan)
                                            <option value="{{ $plan->id }}" data-evento_id="{{ $plan->evento_id }}">
                                                {{ $plan->tipo }} - {{ $plan->evento->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="cont_input_1">
                                <label for="numero_asiento">Número de asiento</label>
                                <div class="input-container">
                                    <i class="fas fa-sort-numeric-up-alt"></i>
                                    <input class="input_1" style="--borderColor: {{ $color_edit }}" type="number"
                                        name="numero_asiento" id="numero_asiento" required>
                                </div>
                            </div>

                            <div class="cont_input_1">
                                <label for="tipo">Tipo de asiento</label>
                                <div class="input-container">
                                    <i class="fas fa-chair"></i>
                                    <select name="tipo" id="tipo" class="input_1"
                                        style="--borderColor: {{ $color_edit }}" required>
                                        <option value="General" {{ $plan->tipo == 'General' ? 'selected' : '' }}>General
                                        </option>
                                        <option value="VIP" {{ $plan->tipo == 'VIP' ? 'selected' : '' }}>VIP</option>
                                    </select>
                                </div>
                            </div>

                            <div class="cont_input_1">
                                <label for="estado">Estado</label>
                                <div class="input-container">
                                    <i class="fas fa-flag"></i>
                                    <select name="estado" id="estado" class="input_1"
                                        style="--borderColor: {{ $color_edit }}" required>
                                        <option value="Disponible" {{ $asiento->estado == 'Disponible' ? 'selected' : '' }}>Disponible</option>
                                        <option value="Ocupado" {{ $asiento->estado == 'Ocupado' ? 'selected' : '' }}>
                                            Ocupado</option>
                                    </select>
                                </div>
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
                    document.getElementById('local_id').value = '';
                    document.getElementById('evento_id').value = '';
                    document.getElementById('plan_id').value = '';
                    document.getElementById('numero_asiento').value = '';
                    document.getElementById('tipo').value = '';
                    document.getElementById('estado').value = '';

                    // Extraer la información del botón
                    var id = button.getAttribute('data-id');
                    var local_id = button.getAttribute('data-local_id');
                    var evento_id = button.getAttribute('data-evento_id');
                    var plan_id = button.getAttribute('data-plan_id');
                    var numero_asiento = button.getAttribute('data-numero_asiento');
                    var tipo = button.getAttribute('data-tipo');
                    var estado = button.getAttribute('data-estado');


                    console.log(id, local_id, evento_id, plan_id, numero_asiento, tipo, estado);

                    // Llenar los campos del formulario en el modal
                    document.getElementById('local_id').value = local_id;
                    document.getElementById('evento_id').value = evento_id;
                    document.getElementById('plan_id').value = plan_id;
                    document.getElementById('numero_asiento').value = numero_asiento;
                    document.getElementById('tipo').value = tipo;
                    document.getElementById('estado').value = estado;

                    // Asignar la acción del formulario dinámicamente
                    var form = editModal.querySelector('form');
                    console.log(id, local_id, evento_id, plan_id, numero_asiento, tipo, estado);
                    form.action = `/asientos/${id}`; // Ajusta según tu ruta en Laravel*/
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
                        <form id="deleteForm" method="POST" action="{{ route('asientos.ocultar', ':id') }}">
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
                    var asientoId = link.getAttribute('data-id'); // Obtener el ID del local
                    var asientoNombre = link.getAttribute('data-nombre'); // Obtener el nombre del local

                    // Actualizar el texto dentro del modal
                    document.getElementById('deleteLocalName').textContent = asientoNombre;

                    // Actualizar la acción del formulario de eliminación
                    var formAction = document.getElementById('deleteForm').action;
                    document.getElementById('deleteForm').action = formAction.replace(':id', asientoId);
                });
            });
        </script>

        <!-- FILTRO: Script para manejar FILTROS -->



        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
        <script>
            AOS.init();
        </script>
</body>

</html>