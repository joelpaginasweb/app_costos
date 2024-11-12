@extends('layouts.aplication')
@section('title', 'Dashboard')
@section('content')

<section class="section section--title">
  <div>
    <h2> DASHBOARD</h2>
    <br>
    <h3>APLICACION EN CONSTRUCCION</h3>
  </div>  
</section>

<section class="section">
  <div>
    <!----------- web components-------- -->
    <h3>-test web componentes-</h3>
    <hola-mundo name="prueba de " surname="web componente nativo"></hola-mundo>
    <!-- lit components -->
    <eit-box-info message="prueba de Lit web component"></eit-box-info>
    <!----------- web components-------- -->
  </div>
</section>

{{-- <section class="section__tablaBase section--down">
  <div class="tablaBase__contain">
    <div class="tablaBase__title">
      <h5>LISTADO DE PRESUPUESTOS</h5>
    </div>
  </div>
  <div class="tablaBase__container">
    <table class="tablaBase tablaDashboard">
      <thead>
        <tr class="tablaBase__head ">
          <th>ID PRESUP</th>
          <th>NOMBRE</th>
          <th>CLIENTE</th>
          <th>UBICACION</th>
          <th>ESTATUS</th>
          <th>COSTO DIR</th>
          <th>COSTO IND</th>
          <th>COSTO TOTAL</th>
          <th>FECHA</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($dashboard as $dashbo)
        <tr onclick="abrir()" class="tablaBase__tbody">
          <td>{{$dashbo->id}}</td>
          <td>{{$dashbo->obra}}</td>
          <td>{{$dashbo->cliente}}</td>
          <td>{{$dashbo->direccion}}</td>
          <td>{{$dashbo->estatus}}</td>
          <td>{{$dashbo->costo_directo}}</td>
          <td>{{$dashbo->costo_indirecto}}</td>
          <td>{{$dashbo->costo_total}}</td>
          <td>{{$dashbo->updated_at}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

</section> --}}

@endsection