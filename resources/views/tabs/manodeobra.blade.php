@extends('layouts.aplication')
@section('title', 'Mano de obra')
@section('content')

{{-- <ead>
  <link rel="stylesheet" href="{{ asset ('css/manodeo.css') }}">
</head>h --}}

<section class="section section--up">
  <div>
    <h1>CATEGORIAS DE MANO DE OBRA</h1>
    <h4>APLICACION EN CONSTRUCCION</h4>
  </div>
</section>

<section class="section__form">
  <div class="form__titulo">
    <h4>CREAR NUEVA CATEGORIA DE MANO DE OBRA</h4>
  </div>
  <form action="{{route('manodeobra.store')}}" method="POST" class="form">
    @csrf
    <div class="contenedorFlex">
      <input type="text" name="grupo" placeholder="grupo" class="form__input">
      <input type="text" name="categoria" placeholder="categoria" class="form__input">
      <input type="text" name="unidad" placeholder="unidad" class="form__input">
      <input type="number" name="salario_base"  placeholder="salario base" class="form__input" step="0.01">
      <input type="number" name="factor_sr" placeholder="factor SR" class="form__input" step="0.01">
      <button type="submit" class="form__boton">Crear</button>
    </div>
  </form>
  
  <div class="section">
    @if (Session::get('success'))
    <div class="alert alert--success">
      <strong>{{Session::get('success')}} <br>
    </div>
    @endif
  </div>

  <div class="section">
    @if ($errors->any())
    <div class="alert alert--danger">
      <strong>¡Error al crear categoria de Mano de Obra!</strong>
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
    <div class="nombre">
      <h5>LISTADO DE CATEGORIAS DE MANO DE OBRA</h5>
    </div>
  </div>

  <div class="containerTabla">
    <table class="tabla">
      <tbody>
        <tr id="titabtar" class="tabla__titulos">
          <td>ID</td>
          <td>GRUPO</td>
          <td>CATEGORIA</td>
          <td>UNIDAD</td>
          <td>SALARIO BASE</td>
          <td>FAC SALARIO REAL</td>
          <td>SALARIO REAL</td>
          <td>ACCION</td>
        </tr>
        @foreach ($manodeobra as $manodeobra)
        <tr class="tabla__body">
          <td>{{$manodeobra->id}}</td>
          <td>{{$manodeobra->grupo}}</td>
          <td>{{$manodeobra->categoria}}</td>
          <td>{{$manodeobra->unidad}}</td>
          <td>{{$manodeobra->salario_base}}</td>
          <td>{{$manodeobra->factor_sr}}</td>
          <td>
               {{-- {{$manodeobra->salario_real}} --}}
              {{number_format($manodeobra->salario_real, 2)}}        
          </td>
          <td>
            <div class="contain">
              <div class="contain">
                <a href="{{route('manodeobra.edit', $manodeobra->id)}}" class="tabla__boton">Ed</a>
              </div>

              <div class="contain">
                <form action="{{route('manodeobra.destroy', $manodeobra)}}" method="POST">
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