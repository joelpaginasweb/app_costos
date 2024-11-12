@extends('layouts.aplication')
@section('title', 'Mano de obra')
@section('content')

<section class="section section--title">
 <h3>CATEGORIAS DE MANO DE OBRA</h3>  
</section>

<section class="section__form">
  <div class="form__titulo display_action pointer">
    <h5>CREAR NUEVA CATEGORIA DE MANO DE OBRA</h5>
  </div>
  <div class="form__content element_display">
    <form action="{{route('manodeobra.store')}}" method="POST" class="form">
      @csrf
      <div class="contenedorFlex">
        <input type="text" name="grupo" placeholder="grupo" class="form__input">
        <input type="text" name="categoria" placeholder="categoria" class="form__input">
        <input type="text" name="unidad" placeholder="unidad" class="form__input">
        <input type="number" name="salario_base" placeholder="salario base" class="form__input " step="0.01">
        <input type="number" name="factor_sr" placeholder="factor SR" class="form__input" step="0.01">
        <button type="submit" class="form__boton">Crear</button>
      </div>
    </form>


  </div>


</section>
<section>
  <div class="form__alert">
    @if (Session::get('success'))
    <div class="alert alert--success">
      <strong>{{Session::get('success')}} <br>
    </div>
    @endif
  </div>
  <div class="form__alert">
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
<section class="section__tablaBase section--down">
  <div class="tablaBase__contain">
    <div class="tablaBase__title">
      <h5>LISTADO DE CATEGORIAS DE MANO DE OBRA</h5>
    </div>
  </div>

  <div class="tablaBase__container">
    <table class="tablaBase tablaMO" id="tabla_base">
      <thead>

        <tr class="">
          <th>ID</th>
          <th>GRUPO</th>
          <th>CATEGORIA</th>
          <th>UNIDAD</th>
          <th>SALARIO BASE</th>
          <th>FAC SALARIO REAL</th>
          <th>SALARIO REAL</th>
          <th>ACCION</th>
        </tr>
      </thead>
      <tbody class="tablaBase__tbody">
        @foreach ($manodeobra as $manodeobra)
        <tr class="tabla__body">
          <td>{{$manodeobra->id}}</td>
          <td>{{$manodeobra->grupoData->grupo}}</td>
          <td>{{$manodeobra->categoria}}</td>
          <td>{{$manodeobra->unidad->unidad}}</td>
          <td>{{$manodeobra->salario_base}}</td>
          <td>{{$manodeobra->factor_sr}}</td>
          <td>
            {{number_format($manodeobra->salario_real, 2)}}
          </td>
          <td>
            <div class="contain">
              <div class="contain">
                <a href="{{route('manodeobra.edit', $manodeobra->id)}}" class="tablaBase__boton">Ed</a>
              </div>

              <div class="contain">
                <form action="{{route('manodeobra.destroy', $manodeobra)}}" method="POST">
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
<script>
  let tablaBase = document.querySelector("#tabla_base");
  let dataTable = new simpleDatatables.DataTable(tablaBase,{
    perPage:15,
    perPageSelect:[10,15,50]
  });
</script>

@endsection