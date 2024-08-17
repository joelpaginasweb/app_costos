<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!----------------Enlaces css y js----------->
  @vite(['resources/css/app.css'])
  @vite(['resources/js/app.js'])


  <!----------------datatables--------------------->
  {{-- <link href="https://unpkg.com/vanilla-datatables@latest/dist/vanilla-dataTables.min.css" rel="stylesheet" type="text/css"> --}}

{{-- <script src="https://unpkg.com/vanilla-datatables@latest/dist/vanilla-dataTables.min.js" type="text/javascript"></script> --}}


  {{-- <link href="https://cdn.datatables.net/2.1.3/css/dataTables.dataTables.min.css" rel="stylesheet" type="text/css"> --}}

  {{-- <script src="https://cdn.datatables.net/2.1.3/js/dataTables.min.js" type="text/javascript"></script> --}}

  <!--------------titulo documento------------>
  <title>App Costos - @yield('title')</title>
</head>
<body>
  <header>
    <div class="caja">
      <div id="divlogo" class="logoContain">
        <a href=" {{route('welcome')}} " class="logo">
          <img src="{{asset ('img/lgo-bco-3.png') }}" alt="appcostos" class="logo__img">
        </a>
      </div>
      @include(' layouts.partials.nav_aplication')
      <!----------------- login by breeze------------->
      <div class="userContain">
        <x-dropdown align="right" width="48">
          <x-slot name="trigger">
            <span class="user">
              {{ Auth::user()->name }}
            </span>
          </x-slot>
          <x-slot name="content">
            <div class="user__div">
              <x-dropdown-link :href="route('profile.edit')" class="user__menu">
                {{ __('Perfil') }}
              </x-dropdown-link>

              <!-- Authentication -->
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-dropdown-link :href="route('logout')"
                  onclick="event.preventDefault(); this.closest('form').submit();" class="user__menu">
                  {{ __('Cerrar Sesíon') }}
                </x-dropdown-link>
              </form>
            </div>
          </x-slot>
        </x-dropdown>
      </div>
    </div>
  </header>

  <main class="mainAplication">
    @yield('content')

  </main>

  <footer>
    @include(' layouts.partials.footer_app')
  </footer>

  @yield('scripts')


</body>

</html>