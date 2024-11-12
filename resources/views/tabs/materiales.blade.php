@extends('layouts.aplication')
@section('title', 'Materiales')
@section('content')

<section class="section section--title">
    <h3>MATERIALES E INSUMOS</h3>
</section>

<section class="section__form">
  <div class="form__titulo display_action pointer">
    <h5>CREAR NUEVO MATERIAL </h5>
  </div>
  <div class="form__content element_display">
    <form action="{{route('materiales.store')}}" method="POST" class="form">
      @csrf
      <div class="contenedorFlex">
        <input type="text" name="grupo" class="form__input" placeholder="grupo">
        <textarea name="material" class=" form__textarea"
          placeholder="ingresar descripcion del nuevo material"></textarea>
        <input type="text" name="unidad" class="form__input" placeholder="unidad">
        <input type="number" step="0.01" name="precio_unitario" class="form__input" placeholder="precio unitario">
        <input type="text" name="proveedor" class="form__input" placeholder="proveedor">
        <button type="submit" class="form__boton">Crear</button>
      </div>
    </form>

  </div>
</section>

<section>
  <div class="form__alert">
    @if (Session::get('success'))
    <div class="alert alert--success ">
      <strong>{{Session::get('success')}} <br>
    </div>
    @endif
  </div>
  <div class="form__alert">
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
        @foreach ($materiales as $material)
        <tr class="">
          <td>{{$material->id}}</td>
          <td>{{$material->grupo->grupo}}</td>
          <td>{{$material->material}}</td>
          <td>{{$material->unidad->unidad}}</td>
          <td>{{$material->precio_unitario}}</td>
          <td>{{$material->proveedor->proveedor}}</td>
          <td>{{$material->updated_at}}</td>
          <td>
            <div class="contain">
              <div class="contain">
                <a href="{{route('materiales.edit', $material->id)}}" class="tablaBase__boton">Ed</a>
              </div>

              <div class="contain">
                <form action="{{route('materiales.destroy', $material)}}" method="POST">
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
  let dataTable = new simpleDatatables.DataTable(tablaBase, {
    perPage: 15,
    perPageSelect: [10, 15, 50]
  });
</script>

@endsection