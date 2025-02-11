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
                                <label for="Foto">{{ __('Foto del Evento:') }}</label>
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
