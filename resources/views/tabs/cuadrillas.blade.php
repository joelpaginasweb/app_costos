@extends('layouts.aplication')
@section('title', 'Cuadrillas')
@section('content')

<section class="section">
  <div>
    <h1> CUADRILLAS DE MANO DE OBRA </h1>
    <h4>APLICACION EN CONSTRUCCION</h4>
    <br>
  </div>
</section>

<section class="section__form" id="nuevo_material">
  <div class="form__titulo">
    <h4>CREAR NUEVA CUADRILLA DE MANO DE OBRA </h4>
  </div>

  <form action="{{route('cuadrillas.store')}}" method="POST" class="form">
    @csrf

    <div class=" contain">
      <div class="containerFlex ">
        <input type="text" name="grupo" class="form__input" placeholder="grupo">
        <textarea name="descripcion" class="form__textarea" placeholder="descripcion de cuadrilla"></textarea>
        <input type="text" name="unidad" class="form__input" placeholder="unidad">
        <input type="button" class="form__boton" id="btn_crea_cuad" value="Agregar Categoria">
      </div>
    </div>

    <div class="container contain">
      <div id="container_cuad" class="containerFlex">
        <div class="container contain_element">
          <span class="form__span" onclick="eliminar(this)">x</span>
          <label for="id_categoria" class="form__label">Id categoria</label>
          <input type="number" step="0" name="id_categoria[]" class="form__input" placeholder="id categoria">
          <label for="cantidad_mo" class="form__label">cantidad </label>
          <input type="number" step="0.00001" name="cantidad_mo[]" class="form__input"
            placeholder="cantidad">
        </div>

      </div>      
      <div class="container ">
        <div class="container ">
          <label for="formBoton" class="form__label"> Crear Cuadrilla</label>
          <button type="submit" id="formBoton" class="form__boton">Crear Cuadrilla</button>
        </div>
      </div>
    </div>
  </form>

  <div class=" section ">
    @if (Session::get('success'))
    <div class="alert alert--success ">
      <strong>{{Session::get('success')}} <br>
    </div>
    @endif
  </div>

  <div class=" section ">
    @if ($errors->any())
    <div class="alert alert-danger ">
      <strong>¡Error al crear cuadrilla de mano de obra!</strong>
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
      <h5>LISTADO DE CUADRILLAS DE MANO DE OBRA</h5>
    </div>
  </div>

  <div class="tablaBase__container">
    <table class="tablaBase tablaAux" id="tabla_base">
      <thead>
        <tr class="">
          <th>ED</th>
          <th>ID</th>
          <th>GRUPO</th>
          <th>DESCRIPCION</th>
          <th>UNIDAD</th>
          <th>TOTAL</th>
          <th>FECHA</th>
          <th>ACCION</th>
        </tr>
      </thead>

      <tbody class="tablaBase__tbody">
        @foreach ($cuadrillas as $cuadrilla)
        <tr class="">
          <td>
          <button>---</button>
          {{-- <button class="edit-btn" data-id="{{$cuadrilla->id}}">Editar</button> --}}
          </td>
          <td>{{$cuadrilla->id}}</td>
          <td>{{$cuadrilla->grupo}}</td>
          <td id=""  class="pointer">{{$cuadrilla->descripcion}}</td>            
          <td>{{$cuadrilla->unidad}}</td>
          <td>{{number_format($cuadrilla->total, 2)}}</td>
          <td>{{$cuadrilla->updated_at}}</td>
          <td>
            <div class="contain">
              <div class="contain">
                <a href="{{route('cuadrillasCopy', $cuadrilla->id)}}" class="tablaBase__boton">Cop</a>
              </div>
              <div class="contain">
                <a href="{{route('cuadrillas.edit', $cuadrilla->id)}}" class="tablaBase__boton">Ed</a>
              </div>
              <div class="contain">
                <form action="{{route('cuadrillas.destroy', $cuadrilla)}}" method="POST">
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

<!----------- ventana emergente  ---------------->

<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <div id="modal-body">
            <!-- Aquí se cargará el contenido de la vista -->
        </div>
    </div>
</div>

<!----------- fin ventana emergente  --------------->

{{-- esta funcion no se importa desde resources/js/functions/ --}}
<script type="text/javascript" src="{{ asset('js/delete_elements.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>
<script>let dataTableC = new simpleDatatables.DataTable("#tabla_base");</script>

@endsection