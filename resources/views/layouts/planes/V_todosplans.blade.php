<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('layouts.head')
    
    <body>
        @include('layouts.header')

        <div class="main">
            <div class="main_banner_2" style="--banner-image: url('../../images/dashboard/plans.png');">
                <h1><strong>Planes</strong> para Todos</h1>
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
                        <div class="row">
                            @foreach($eventos as $evento)
                                <div class="col-lg-6 col-md-12 mb-4""> <!-- 2 eventos por fila en pantallas grandes -->
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
                                                                <tr>
                                                                    <td class="text-center">{{ $plan->tipo }}</td>
                                                                    <td class="text-center">{{ $plan->precio }}</td>
                                                                    <td class="text-center">{{ $plan->descripcion }}</td>
                                                                    <td class="text-center">
                                                                        @if($plan->Foto)
                                                                            <img src="{{ asset('storage/' . $plan->Foto) }}" alt="Foto del plan" class="w-20 h-20 object-cover rounded-md">
                                                                        @else
                                                                            {{ __('No Disponible') }}
                                                                        @endif
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <a href="{{ route('planes.edit', $plan->id) }}" class="btn btn-sm btn-warning" style="color: white;">
                                                                            <i class="fa-solid fa-pen"></i>
                                                                        </a>

                                                                        <form action="{{ route('planes.destroy', $plan->id) }}" method="POST" class="d-inline-block">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este plan?')">
                                                                                <i class="fa-solid fa-trash"></i>
                                                                            </button>
                                                                        </form>
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
        </div>
    </body>
</html>