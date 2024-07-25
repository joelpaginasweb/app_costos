@extends('layouts.aplication')
@section('title', 'Materiales')

@section('content')

{{-- <head>
  <link rel="stylesheet" href="{{ asset ('css/materiales.css') }}">
</head> --}}

<section class="section section--up">
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

<section class="sectionTabla">
  <div class="tabla__nombre">
    <div id="pressg">
      <h5>LISTADO DE MATERIALES E INSUMOS</h5>
    </div>
  </div>

  <div class="containerTabla">
    <table class="tabla">
      <tbody>
        <tr class="tabla__titulos">
          <td>ID</td>
          <td>GRUPO</td>
          <td>MATERIAL</td>
          <td>UNID</td>
          <td>PRECIO UNIT.</td>
          <td>PROVEEDOR</td>
          <td>FECHA</td>
          <td>ACCION</td>
        </tr>
        @foreach ($materiales as $materiale)
        <tr class="tabla__body">
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
                <a href="{{route('materiales.edit', $materiale->id)}}" class="tabla__boton">Ed</a>
              </div>

              <div class="contain">
                <form action="{{route('materiales.destroy', $materiale)}}" method="POST" >
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="tabla__boton">X</button>
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
@endsection