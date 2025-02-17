<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('layouts.head')

    <body>
        @include('layouts.header')
        

        <div class="main">
            <div class="main_banner_2" 
            data-aos="fade-down" data-aos-duration="1000" data-aos-delay="250"
            style="--banner-image: url('../../images/dashboard/dash.jpg');">
                <h1><strong>DASHBOARD</strong></h1>
            </div>

            <div class="main_contenedor"
            data-aos="fade-up" data-aos-duration="1000"
            style="margin-top: 20px;">
                <div class="scale card" style="width: 18rem; box-shadow: 0 0 10px rgba(0, 0, 0, 0.4);">
                    <img class="card-img-top" src="../../images/dashboard/estadio-1.webp" alt="Card image cap" 
                    style="height: 180px; background-color: #f0f0f0; object-fit: cover; width: 100%;">                                
                    <div class="card-body">
                        <h5 class="card-title"><strong>LOCALIDADES</strong></h5>
                        <p class="card-text">
                            Aquí podrás gestionar las diferentes zonas de acceso al evento. Añadir o editar localidades, establecer precios y asignar características a cada zona. Asegúrate de ofrecer opciones para todo tipo de público.
                        </p>

                        <div style="display:flex; justify-content: center;">
                            <a  href="{{ route('locales.index') }}" class="btn btn-primary mt-4">
                                <i class="fa-solid fa-eye" style="margin-right: 5px"></i>
                                Ver más
                            </a>
                        </div>  
                    </div>
                </div>

                <div class="scale card" style="width: 18rem; box-shadow: 0 0 10px rgba(0, 0, 0, 0.4);">
                    <img class="card-img-top" src="../../images/dashboard/eventos.jpg" alt="Card image cap" 
                    style="height: 180px; background-color: #f0f0f0; object-fit: cover; width: 100%;">                                
                    <div class="card-body">
                        <h5 class="card-title"><strong>EVENTOS</strong></h5>
                        <p class="card-text">
                            Crea y organiza tus eventos aquí. Define fechas, horarios, lugares y los detalles importantes que harán que el evento sea inolvidable. Gestiona la información fácilmente.
                        </p>

                        <div style="display:flex; justify-content: center;">
                            <a  href="{{ route('eventos.index') }}" class="btn btn-primary mt-4">
                                <i class="fa-solid fa-eye" style="margin-right: 5px"></i>
                                Ver más
                            </a>
                        </div> 
                    </div>
                </div>

                <div class="scale card" style="width: 18rem; box-shadow: 0 0 10px rgba(0, 0, 0, 0.4);">
                    <img class="card-img-top" src="../../images/dashboard/asientos.png" alt="Card image cap" 
                    style="height: 180px; background-color: #f0f0f0; object-fit: cover; width: 100%;">                                
                    <div class="card-body">
                        <h5 class="card-title"><strong>ASIENTOS</strong></h5>
                        <p class="card-text">
                            Organiza y asigna los asientos para el evento. Puedes configurar la disposición del lugar, permitir la selección de asientos para los asistentes y controlar la disponibilidad.
                        </p>
                        <div style="display:flex; justify-content: center;">
                            <a  href="{{ route('asientos.index') }}" class="btn btn-primary mt-4">
                                <i class="fa-solid fa-eye" style="margin-right: 5px"></i>
                                Ver más
                            </a>
                        </div>  
                    </div>
                </div>

                <div class="scale card" style="width: 18rem; box-shadow: 0 0 10px rgba(0, 0, 0, 0.4);">
                    <img class="card-img-top" src="../../images/dashboard/plans.png" alt="Card image cap" 
                    style="height: 180px; background-color: #f0f0f0; object-fit: cover; width: 100%;">                                
                    <div class="card-body">
                        <h5 class="card-title"><strong>PLANS & COMBOS</strong></h5>
                        <p class="card-text">
                            Crea planes y combos exclusivos para tus eventos, ofreciendo diferentes opciones de entradas y servicios adicionales. Permite que tus clientes elijan el paquete que mejor se adapte a sus necesidades.
                        </p>

                        <div style="display:flex; justify-content: center;">
                            <a  href="{{ route('planes.index') }}" class="btn btn-primary mt-4">
                                <i class="fa-solid fa-eye" style="margin-right: 5px"></i>
                                Ver más
                            </a>
                        </div>  
                    </div>
                </div>
   
                <div class="scale card" style="width: 18rem; box-shadow: 0 0 10px rgba(0, 0, 0, 0.4);">
                    <img class="card-img-top" src="../../images/dashboard/tickets.jpg" alt="Card image cap" 
                    style="height: 180px; background-color: #f0f0f0; object-fit: cover; width: 100%;">                                
                    <div class="card-body">
                        <h5 class="card-title"><strong>TICKETS</strong></h5>
                        <p class="card-text">
                            Gestiona la venta de boletos de tus eventos. Establece precios, cantidades disponibles y controla el flujo de entradas de manera eficiente para asegurar una experiencia sin problemas para los asistentes.
                        </p>
                        <div style="display:flex; justify-content: center;">
                            <a  href="{{ route('tickets.index') }}" class="btn btn-primary mt-4">
                                <i class="fa-solid fa-eye" style="margin-right: 5px"></i>
                                Ver más
                            </a>
                        </div>  
                    </div>
                </div>

                <div class="scale card" style="width: 18rem; box-shadow: 0 0 10px rgba(0, 0, 0, 0.4);">
                    <img class="card-img-top" src="../../images/dashboard/tickets.jpg" alt="Card image cap" 
                    style="height: 180px; background-color: #f0f0f0; object-fit: cover; width: 100%;">                                
                    <div class="card-body">
                        <h5 class="card-title"><strong>USUARIOS</strong></h5>
                        <p class="card-text">
                            Gestiona la venta de boletos de tus eventos. Establece precios, cantidades disponibles y controla el flujo de entradas de manera eficiente para asegurar una experiencia sin problemas para los asistentes.
                        </p>
                        <div style="display:flex; justify-content: center;">
                            <a  href="{{ route('users.index') }}" class="btn btn-primary mt-4">
                                <i class="fa-solid fa-eye" style="margin-right: 5px"></i>
                                Ver más
                            </a>
                        </div>  
                    </div>
                </div>
            </div>
        </div>

        <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
        <script>
            AOS.init();
        </script>
    </body>
</html>