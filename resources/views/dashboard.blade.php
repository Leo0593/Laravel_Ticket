<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('layouts.head')
    
    <body>
        @include('layouts.header')

        <div class="main">
            <div class="main_banner_2" style="--banner-image: url('../../images/dashboard/dashboard.jpg'); 
            height: 500px;">
                <h1><strong>DASHBOARD</strong></h1>
            </div>

            <div class="main_contenedor">
                <div class="card" style="width: 18rem; box-shadow: 0 0 10px rgba(0, 0, 0, 0.4);">
                    <img class="card-img-top" src="../../images/dashboard/estadio-1.webp" alt="Card image cap" 
                    style="height: 180px; background-color: #f0f0f0; object-fit: cover; width: 100%;">                                
                    <div class="card-body">
                        <h5 class="card-title"><strong>LOCALIDADES</strong></h5>
                        <p class="card-text">
                            Some quick example text to build on the card title and make up the bulk of the card's content.
                        </p>

                        <div style="display:flex; justify-content: center;">
                            <a  href="{{ route('locales.index') }}" class="btn btn-primary mt-4">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                        </div>  
                    </div>
                </div>

                <div class="card" style="width: 18rem; box-shadow: 0 0 10px rgba(0, 0, 0, 0.4);">
                    <img class="card-img-top" src="../../images/dashboard/eventos.jpg" alt="Card image cap" 
                    style="height: 180px; background-color: #f0f0f0; object-fit: cover; width: 100%;">                                
                    <div class="card-body">
                        <h5 class="card-title"><strong>EVENTOS</strong></h5>
                        <p class="card-text">
                            Some quick example text to build on the card title and make up the bulk of the card's content.
                        </p>

                        <div style="display:flex; justify-content: center;">
                            <a  href="{{ route('eventos.index') }}" class="btn btn-primary mt-4">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                        </div> 
                    </div>
                </div>

                <div class="card" style="width: 18rem; box-shadow: 0 0 10px rgba(0, 0, 0, 0.4);">
                    <img class="card-img-top" src="../../images/dashboard/asientos.png" alt="Card image cap" 
                    style="height: 180px; background-color: #f0f0f0; object-fit: cover; width: 100%;">                                
                    <div class="card-body">
                        <h5 class="card-title"><strong>ASIENTOS</strong></h5>
                        <p class="card-text">
                            Some quick example text to build on the card title and make up the bulk of the card's content.
                        </p>
                        <div style="display:flex; justify-content: center;">
                            <a  href="{{ route('asientos.index') }}" class="btn btn-primary mt-4">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                        </div>  
                    </div>
                </div>

                <div class="card" style="width: 18rem; box-shadow: 0 0 10px rgba(0, 0, 0, 0.4);">
                    <img class="card-img-top" src="../../images/dashboard/plans.png" alt="Card image cap" 
                    style="height: 180px; background-color: #f0f0f0; object-fit: cover; width: 100%;">                                
                    <div class="card-body">
                        <h5 class="card-title"><strong>PLANS & COMBOS</strong></h5>
                        <p class="card-text">
                            Some quick example text to build on the card title and make up the bulk of the card's content.
                        </p>

                        <div style="display:flex; justify-content: center;">
                            <a  href="{{ route('planes.index') }}" class="btn btn-primary mt-4">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                        </div>  
                    </div>
                </div>
   
                <div class="card" style="width: 18rem; box-shadow: 0 0 10px rgba(0, 0, 0, 0.4);">
                    <img class="card-img-top" src="../../images/dashboard/tickets.jpg" alt="Card image cap" 
                    style="height: 180px; background-color: #f0f0f0; object-fit: cover; width: 100%;">                                
                    <div class="card-body">
                        <h5 class="card-title"><strong>TICKETS</strong></h5>
                        <p class="card-text">
                            Some quick example text to build on the card title and make up the bulk of the card's content.
                        </p>
                        <div style="display:flex; justify-content: center;">
                            <a  href="{{ route('tickets.index') }}" class="btn btn-primary mt-4">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                        </div>  
                    </div>
                </div>

            </div>
        </div>
    </body>
</html>