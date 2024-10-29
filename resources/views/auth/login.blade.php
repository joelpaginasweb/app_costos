@extends('layouts.landing')
@section('title', 'login')

@section('content')

<section class="section__login">

  <div class="login__contain">
    <h3>Iniciar Sesíon</h3>
  </div>

  <x-guest-layout>
    <x-auth-session-status class="" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="login">
      @csrf

      <!-- Email Address -->
      <div class="login__contain">
        <div class=" login__div">
          <x-input-label for="email" :value="__('Email:')" class="login__label" />
        </div>

        <x-text-input id="email" class="login__input" type="email" name="email" :value="old('email')" required autofocus
          autocomplete="username" />
        <x-input-error :messages="$errors->get('email')" class="" />
      </div>


      <!-- Password -->
      <div class="login__contain">
        <div class="login__div">
          <x-input-label for="password" :value="__('Password:')" class="login__label" /></xdiv>
        </div>
        <x-text-input id="password" class="login__input" type="password" name="password" required
          autocomplete="current-password" />

        <x-input-error :messages="$errors->get('password')" class="" />
      </div>


      <!-- Remember Me -->
      <div class="login__contain">
        <div class="login__div--long">
          <label for="remember_me" class="">
            <input id="remember_me" type="checkbox" class="" name="remember">
            <span class="login__label">{{ __('Remember me') }}</span>
          </label>
        </div>
      </div>

      <div class="login__contain contain">
        @if (Route::has('password.request'))
        <a class="login__label" href="{{ route('password.request') }}">
          {{ __('Forgot your password?') }}
        </a>
        @endif

        <div class="">
          <x-primary-button class="login__boton">
            {{ __('Log in') }}
          </x-primary-button>
        </div>
    </form>
  </x-guest-layout>

</section>

@endsection