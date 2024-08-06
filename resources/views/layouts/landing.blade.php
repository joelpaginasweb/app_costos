<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!----------------Enlaces css y js----------->
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <!--------------titulo documento------------>
  <title>App Costos @yield('title')</title>
</head>

<body class="bodyLanding">
  <header>
    <div class="caja">
      <div id="divlogo" class="logoContain">
          <a href=" {{route('welcome')}} " class="logo">
          <img src="{{asset ('img/lgo-bco-3.png') }}" alt="appcostos" class="logo__img">
        </a>
      </div>

      <!----------------- login de breeze------------->
      @include(' layouts.partials.nav_landing')
      <div class="userContain">
        @if (Route::has('login'))
        <nav class="">
          @auth
          <a href="{{ url('/dashboard') }}" class="user">
            Dashboard
          </a>
          @else
          <a href="{{ route('login') }}" class="user">
            Log in
          </a>
          @if (Route::has('register'))
          <a href="{{ route('register') }}" class="user">
            Register
          </a>
          @endif
          @endauth
        </nav>
      </div>
      @endif
      <!----- ------------------------->
    </div>    
  </header>


  <main class="mainLanding">
    @yield('content')
  </main>


  <footer>
    @include(' layouts.partials.footer_landing')
  </footer>


</body>

</html>