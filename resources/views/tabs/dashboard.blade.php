@extends('layouts.aplication')

@section('title', 'Dashboard')

@section('content')

<head>
  <link rel="stylesheet" href="{{ asset ('css/dashboard.css') }}">
</head>

<section class="section">
  <div>
    <h1> DASHBOARD</h1>
    <br>
    <br> 
    <h4>APLICACION EN CONSTRUCCION</h4>

  </div>
</section>

<section class="sectionTabla">
  <div class="tabla__nombre">
    <div class="nombre">
      <h5>LISTADO DE PRESUPUESTOS</h5>
    </div>
  </div>

  <div class="containerTabla">
    <table class="tablaTarjetas">
      <tbody>
        <tr  class="tablaTarjetas__head">
          <td>ID PRESUP</td>
          <td>NOMBRE</td>
          <td>CLIENTE</td>
          <td>UBICACION</td>
          <td>ESTATUS</td>
          <td>COSTO DIR</td>
          <td>COSTO IND</td>
          <td>COSTO TOTAL</td>
          <td>FECHA</td>
        </tr>
        @foreach ($dashbos as $dashbo)
        <tr onclick="abrir()" class="tablaTarjetas__body">
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

</section>

@endsection