@extends('layouts.aplication')
@section('title', 'Perfil')

@section('content')

<br><br><br><br>

<section class=" perfil__page ">
  <section class="perfil__section ">
    <h3>
      {{ __('Perfil de Usuario') }}
    </h3>
  </section>
    <br>
  <section class="perfil__section ">
    <h4 class="perfil__h4">
      Informacion del Perfil de Usuario
    </h4>
    <span class="perfil__span">
      Actualiza tus datos de usuario y correo electronico.
    </span>
    <div class="">
      @include('profile.partials.update-profile-information-form')
    </div>
  </section>
  <br>
  <section class="perfil__section ">
    <h4 class="perfil__h4">
      Actualiza el Password
    </h4>
    <span class="perfil__span">
      Proteje tu cuenta usando un password seguro de mas de 8 carecteres aleatorios.
    </span>
    <div class="">
      @include('profile.partials.update-password-form')
    </div>
  </section>
  <br>
  <section class="perfil__section">
    <h4 class="perfil__h4">
      Eliminar cuenta
    </h4>
    <span class="perfil__span">
      Al eliminar tu cuenta, toda la informacion y datos asociados seran permanentmente borrados. Antes de eliminarla
      respalda la informacion que deses conservar.
    </span>
    <br>
    <div class="">
      @include('profile.partials.delete-user-form')
    </div>
    
  </section>
</section>
<br><br>

@endsection