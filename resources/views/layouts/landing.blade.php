<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--<script src="https://cdn.tailwindcss.com"></script>-->
    <link rel="stylesheet" href="{{ asset ('css/estilobase.css') }}">  <!----Enlaces css provisionales---->  
    <link rel="stylesheet" href="{{ asset ('css/footer.css') }}">
    <link rel="stylesheet" href="{{ asset ('css/inicio_grid.css') }}">
    <title>App Costos @yield('title')</title>              
</head>
    <!----- Esto es un comentario ------>

<body>
    <header>
        <div class="caja">
            <div id="divlogo" class="logoContain"> 
                <a href=" {{route('landing')}} " class="logo">
                    <img src="{{asset ('img/lgo-bco-3.png') }}" alt="appcostos" class="logo__img">
                </a>             
            </div>  

            @include(' layouts.partials.nav_landing')     

            <div id="divnombre" class="userContain">              
                <a class="user" href="{{route('dashbos.index')}}">
                   Ingresar Usuario
                </a>    
            </div>
        </div>      
    </header>

    <main>
        @yield('content')      
    </main>

    <footer> 
        @include(' layouts.partials.footer')   
    </footer>
    
</body>
</html>