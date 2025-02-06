<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('layouts.head')
    
    <body style="background-color:rgb(255, 255, 255) !important;">
        @include('layouts.header')

        <div class="main">
            <h1 class="mt-4">ASIENTOS DEL EVENTO</h1>
            
            <div class="main_contenedor">
                <div class="container mt-5">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#seatModal">
                        Crear Asientos
                    </button>
                </div>

                <div class="modal fade" id="seatModal" tabindex="-1" aria-labelledby="seatModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color: #ffc107; align-items: center;">
                                <h5 class="modal-title" id="seatModalLabel"><strong>Crear Asientos</strong></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('asientos.store', $evento->id) }}" method="POST">
                                    @csrf
                                    
                                    <div class="cont_input_1">
                                        <label for="Fila">Número de Filas</label>
                                        <input class="input_1" type="number" id="Fila" name="Fila" required>
                                    </div>

                                    <div class="cont_input_1">
                                        <label for="Columna">Número de Columnas</label>
                                        <input class="input_1" type="number" id="Columna" name="Columna" required>
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
                
                <div class="mt-5">
                    <h3>Mapa de Asientos</h3>
                    <div class="seat-map">
                        @foreach($asientos as $asiento)
                            <button class="seat {{ $asiento->disponible ? 'seat-available' : 'seat-taken' }}">
                                {{ $asiento->numero }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
