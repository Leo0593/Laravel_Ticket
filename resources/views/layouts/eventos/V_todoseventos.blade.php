<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('layouts.head')
    
    <body style="background-color:rgb(255, 255, 255) !important;">
        @include('layouts.header')

        <div class="main">
            <div class="main_banner_2" style="--banner-image: url('../../images/dashboard/eventos.jpg');">
                <h1><strong>Diseña la Experiencia Perfecta</strong></h1>
                <h2>Planifica la Mejor Ubicación para tu Público</h2>
                
                <button class="btn-1" data-bs-toggle="modal" data-bs-target="#addModal">
                    Agregar
                </button>

                <a href="{{ route('eventos.create') }}" class="btn-1">
                    Agregar
                </a>
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
                            <div class="card-body d-flex justify-content-around" style="max-height: 70px;">
                                <a href="#" class="btn btn-warning" style="color: white;" data-bs-toggle="modal" data-bs-target="#editModal" 
                                data-id="{{ $evento->id }}"
                                data-nombre="{{ $evento->nombre }}"
                                data-descripcion="{{ $evento->descripcion }}"
                                data-local_id="{{ $evento->local_id }}"
                                data-aforo_evento="{{ $evento->aforo_evento }}"
                                data-fecha_evento="{{ $evento->fecha_evento }}"
                                data-fecha_inicio="{{ $evento->fecha_inicio }}"
                                data-fecha_fin="{{ $evento->fecha_fin }}"
                                data-estado="{{ $evento->estado }}"
                                data-foto="{{ $evento->Foto }}">
                                <i class="fa-solid fa-pen"></i>
                                </a>   

                                <form action="{{ route('eventos.destroy', $evento->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 ml-4" 
                                        onclick="return confirm('¿Estás seguro de que deseas eliminar este local?')">
                                        <i class="fa-solid fa-trash"></i>
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

                            <!-- Usuario -->
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

                            <!-- Local -->
                            <div class="mb-4">
                                <label for="local_id" class="block text-sm font-medium text-gray-700">{{ __('Local') }}</label>
                                <select name="local_id" id="local_id" class="mt-1 block w-full text-sm text-gray-500 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:focus:ring-indigo-500 dark:focus:border-indigo-500" required>
                                   
                                </select>
                            </div>

                            <!-- Nombre -->
                            <div class="cont_input_1">
                                <label for="Nombre">Nombre</label>
                                <div class="input-container">
                                <i class="fa-duotone fa-solid fa-user"></i>
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

                            <!-- Fecha_inicio -->
                            <div class="cont_input_1">
                                <label for="fecha_inicio">fecha_inicio</label>
                                <div class="input-container">
                                    <i class="fa-regular fa-calendar"></i>
                                    <input class="input_1" style="--borderColor: {{ $color_add }}" type="date" id="fecha_inicio" name="fecha_inicio" required></input>
                                </div>
                            </div>

                            <!-- Fecha_fin -->
                            <div class="cont_input_1">
                                <label for="fecha_fin">fecha_fin</label>
                                <div class="input-container">
                                    <i class="fa-regular fa-calendar"></i>
                                    <input class="input_1" style="--borderColor: {{ $color_add }}" type="date" id="fecha_fin" name="fecha_fin" required></input>
                                </div>
                            </div>

                            <!-- Fecha_limite -->
                            <div class="cont_input_1">
                                <label for="fecha_evento">fecha_evento</label>
                                <div class="input-container">
                                    <i class="fa-regular fa-calendar"></i>
                                    <input class="input_1" style="--borderColor: {{ $color_add }}" type="date" id="fecha_evento" name="fecha_evento" required></input>
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

                            <!-- Estado -->
                            <select name="estado" id="estado" 
                                class="mt-1 block w-full text-sm text-gray-500 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                                required>
                                <option value="ACTIVO" {{ old('estado') == 'ACTIVO' ? 'selected' : '' }}>{{ __('Activo') }}</option>
                                <option value="CANCELADO" {{ old('estado') == 'CANCELADO' ? 'selected' : '' }}>{{ __('Cancelado') }}</option>
                                <option value="FINALIZADO" {{ old('estado') == 'FINALIZADO' ? 'selected' : '' }}>{{ __('Finalizado') }}</option>
                            </select>

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
                        form.submit(); // Enviar el formulario para agregar el nuevo local
                    } else {
                        console.error("Formulario no encontrado.");
                    }
                });
            });
        </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    </body>
</html>


<!--
                <div class="container mt-5">

                </div>

                <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color: #ffc107; align-items: center;">
                                <h5 class="modal-title" id="eventModalLabel"><strong>Crear Evento</strong></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('eventos.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                  
                                    <div class="cont_input_1">
                                        <label for="Nombre">Nombre</label>
                                        <input class="input_1" type="text" id="Nombre" name="Nombre" required>
                                    </div>

                                    <div class="cont_input_1">
                                        <label for="Descripcion">Descripción</label>
                                        <input class="input_1" type="text" id="Descripcion" name="Descripcion" required>
                                    </div>

                                    <div class="cont_input_1">
                                        <label for="Imagen">Imagen</label>
                                        <input class="input_1" type="file" id="Imagen" name="Imagen" required>
                                    </div>

                                    <div class="cont_input_1">
                                        <label for="Compra">Inicio Compra</label>
                                        <input class="input_1" type="date" id="Compra" name="Compra" required>
                                    </div>

                                    <div class="cont_input_1">
                                        <label for="Fin_Compra">Fin Compra</label>
                                        <input class="input_1" type="date" id="Fin_Compra" name="Fin_Compra" required>
                                    </div>

                                    <div class="cont_input_1">
                                        <label for="Fecha_evento">Fecha Evento</label>
                                        <input class="input_1" type="date" id="Fecha_evento" name="Fecha_evento" required>
                                    </div>

                                    <div class="cont_input_1">
                                        <label for="Aforo">Aforo</label>
                                        <input class="input_1" type="number" id="Aforo" name="Aforo" required>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                @foreach($eventos as $evento)
                    <div class="card" style="width: 18rem; box-shadow: 0 0 10px rgba(0, 0, 0, 0.4);">
                        <img class="card-img-top" 
                                src="{{ $evento->Imagen ? asset('storage/' . $evento->Imagen) : 'https://placehold.co/600x400' }}"  
                                alt="Imagen del evento">
                        <div class="card-body">
                            <h5 class="card-title"><strong>{{ $evento->Nombre }}</strong></h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><strong>Descripción: </strong>{{ $evento->descripcion }}</li>
                                <li class="list-group-item"><strong>Inicio Compra: </strong>{{ \Carbon\Carbon::parse($evento->inicio)->format('d/m/Y') }}</li>
                                <li class="list-group-item"><strong>Fin Compra: </strong>{{ \Carbon\Carbon::parse($evento->fecha_fin)->format('d/m/Y') }}</li>
                                <li class="list-group-item"><strong>Fecha Evento: </strong>{{ \Carbon\Carbon::parse($evento->fecha_evento)->format('d/m/Y') }}</li>
                                <li class="list-group-item"><strong>Aforo: </strong>{{ $evento->aforo_evento }}</li>
                            </ul>
                        </div>
                        <div class="card-body d-flex justify-content-around">
                            <a href="{{ route('eventos.edit', $evento->id) }}" class="btn btn-warning">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <form action="{{ route('eventos.destroy', $evento->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach-->