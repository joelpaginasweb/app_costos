@extends('layouts.aplication')
@section('title', 'Materiales')
@section('content')

<section class="section">
  <div>
    <h1>MATERIALES E INSUMOS</h1>
    <h4>APLICACION EN CONSTRUCCION</h4>
  </div>
</section>

<section class="section__form"> <!-- estilo de form en estilobase.css -->
  <div class="form__titulo">
    <h4>CREAR NUEVO MATERIAL </h4>
  </div>

  <form action="{{route('materiales.store')}}" method="POST" class="form">
    @csrf
    <div class="contenedorFlex">
      <input type="text" name="grupo" class="form__input" placeholder="grupo">
      <textarea name="material" class=" form__textarea" placeholder="descripcion del nuevo material"></textarea>
      <input type="text" name="unidad" class="form__input" placeholder="unidad">
      <input type="number" step="0.01" name="precio_unitario" class="form__input" placeholder="precio unitario">
      <input type="text" name="proveedor" class="form__input" placeholder="proveedor">
      <button type="submit" class="form__boton">Crear</button>
    </div>
  </form>

  <div class="section">
    @if (Session::get('success'))
    <div class="alert alert--success ">
      <strong>{{Session::get('success')}} <br>
    </div>
    @endif
  </div>

  <div class=" section ">
    @if ($errors->any())
    <div class="alert alert-danger ">
      <strong>¡Error al crear material!</strong>
      <p>Los siguientes datos son necesarios: </p>
      <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif
  </div>

</section>

<section class="section__tablaBase section--down">
  <div class="tablaBase__contain">
      <div class="tablaBase__title">
      <h5>LISTADO DE MATERIALES E INSUMOS</h5>
    </div>
  </div>

  <div class="tablaBase__container">
    <table class="tablaBase tablaMateriales" id="tabla_base">
       <thead>
        <tr class="tabla__titulos">
          <th>ID</th>
          <th>GRUPO</th>
          <th>MATERIAL</th>
          <th>UNID</th>
          <th>PRECIO UNIT.</th>
          <th>PROVEEDOR</th>
          <th>FECHA</th>
          <th>ACCION</th>
        </tr>
      </thead>

      <tbody class="tablaBase__tbody">
        @foreach ($materiales as $materiale)
        <tr class="">
          <td>{{$materiale->id}}</td>
          <td>{{$materiale->grupo}}</td>
          <td>{{$materiale->material}}</td>
          <td>{{$materiale->unidad}}</td>
          <td>{{$materiale->precio_unitario}}</td>
          <td>{{$materiale->proveedor}}</td>
          <td>{{$materiale->created_at}}</td>
          <td>
            <div class="contain">
              <div class="contain">
                <a href="{{route('materiales.edit', $materiale->id)}}" class="tablaBase__boton">Ed</a>
              </div>

              <div class="contain">
                <form action="{{route('materiales.destroy', $materiale)}}" method="POST" >
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="tablaBase__boton">X</button>
                </form>
              </div>
            </div>
          </td>
        </tr>
        @endforeach

      </tbody>
    </table>
  </div>
</section>


<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>
<script>let dataTableC = new simpleDatatables.DataTable("#tabla_base");</script>

@endsection