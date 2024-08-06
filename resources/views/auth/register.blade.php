@extends('layouts.landing')
@section('title', 'login')

@section('content')


<section class="section__login">

  <div class="login__contain">


    <h3>Regístro de Usuario</h3>
  </div>

  <x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
      @csrf

      <!-- Name -->
      <div class="login__contain">
        <div class=" register__div">
          <x-input-label for="name" :value="__('Name:')" class="login__label" />
        </div>
        <x-text-input id="name" class="login__input" type="text" name="name" :value="old('name')" required autofocus
          autocomplete="name" />
        <x-input-error :messages="$errors->get('name')" class="" />
      </div>

      <!-- Email Address -->
      <div class="login__contain">
        <div class=" register__div">
          <x-input-label for="email" :value="__('Email:')" class="login__label" />
        </div>
        <x-text-input id="email" class="login__input" type="email" name="email" :value="old('email')" required
          autocomplete="username" />
        <x-input-error :messages="$errors->get('email')" class="" />
      </div>

      <!-- Password -->
      <div class="login__contain">
        <div class=" register__div">
          <x-input-label for="password" :value="__('Password:')" class="login__label" />
        </div>

        <x-text-input id="password" class="login__input" type="password" name="password" required
          autocomplete="new-password" />

        <x-input-error :messages="$errors->get('password')" class="" />
      </div>

      <!-- Confirm Password -->
      <div class="login__contain">
        <div class=" register__div">
          <x-input-label for="password_confirmation" :value="__('Confirm Password:')" class="login__label" />
        </div>

        <x-text-input id="password_confirmation" class="login__input" type="password" name="password_confirmation"
          required autocomplete="new-password" />

        <x-input-error :messages="$errors->get('password_confirmation')" class="" />
      </div>

      <div class="login__contain contain">
        <a class="login__label" href="{{ route('login') }}">
          {{ __('Already registered?') }}
        </a>

        <x-primary-button class="login__boton">
          {{ __('Register') }}
        </x-primary-button>
      </div>
    </form>
  </x-guest-layout>

</section>

@endsection