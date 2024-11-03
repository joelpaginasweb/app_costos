@extends('layouts.aplication')
@section('title', 'Auxiliares')
@section('content')

<section class="section">
  <div>
    <h1> TARJETAS AUXILIARES DE COSTOS </h1>
    <h4>APLICACION EN CONSTRUCCION</h4>
    <br>
    <div>
      <!----------- web components-------- -->
      {{-- <h3>-test web componentes-</h3> --}}
      <hola-mundo name="prueba de " surname="web componente nativo"></hola-mundo>
      <!-- lit components -->
      {{-- <eit-box-info message="prueba de Lit web component"></eit-box-info> --}}
      <!----------- web components-------- -->
    </div>
  </div>
</section>

<section class="section__form" id="nuevo_material">
  <div class="form__titulo">
    <h4>CREAR NUEVO MATERIAL AUXILIAR </h4>
  </div>

  <form action="{{route('auxis.store')}}" method="POST" class="form">
    @csrf

    <div class=" contain">
      <div class="containerFlex ">
        <input type="text" name="grupo" class="form__input" placeholder="grupo">
        <textarea name="material_auxiliar" class=" form__textarea" placeholder="concepto material auxiliar"></textarea>
        <input type="text" name="unidad" class="form__input" placeholder="unidad">
        <input type="button" class="form__boton" id="boton_crea_aux" value="Agregar Material">
      </div>
    </div>

    <div class="container contain">
      <div id="container_auxi" class="containerFlex">
        <div class="container contain_element">
          <span class="form__span" onclick="eliminar(this)">x</span>
          <label for="id_material" class="form__label">Id material</label>
          <input type="number" step="0" name="id_material[]" class="form__input" placeholder="id material">
          <label for="cantidad_mater" class="form__label">cantidad material</label>
          <input type="number" step="0.00001" name="cantidad_mater[]" class="form__input"
            placeholder="cantidad material">
        </div>
      </div>

      {{-- ----------------------- --}}
      <!-- ------------------------ -->

      <div class="container ">
        <div class="container ">
          <label for="formBoton" class="form__label"> Crear Auxiliar </label>
          <button type="submit" id="formBoton" class="form__boton">Crear Auxiliar</button>
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
      <h5>LISTADO DE TARJETAS DE COSTOS AUXILIARES</h5>
    </div>
  </div>

  <div class="tablaBase__container">
    <table class="tablaBase tablaAux" id="tabla_base">
      <thead>
        <tr class="">
          <th>ED</th>
          <th>ID</th>
          <th>GRUPO</th>
          <th>CONCEPTO MATERIAL AUXILIAR</th>
          <th>UNID</th>
          <th>PRECIO UN</th>
          <th>FECHA</th>
          <th>ACCION</th>
        </tr>
      </thead>

      <tbody class="tablaBase__tbody">
        @foreach ($auxis as $auxi)
        <tr class="">
          <td>
          {{-- <input type="checkbox" name="" id=""> --}}
          {{-- <button class="edit-btn" data-id="{{$auxi->id}}">Editar</button> --}}
          <button class="edit-btn" >---</button>
          </td>
          <td>{{$auxi->id}}</td>
          <td>{{$auxi->grupo->grupo}}</td>
          <td id=""  class="">{{$auxi->material}}</td> 
          {{-- <td id="open" data-auxi="{{ $auxi}}"   class="pointer">{{$auxi->material}}</td>  --}}
          <td>{{$auxi->unidad->unidad}}</td>
          <td>{{number_format($auxi->precio_unitario, 2)}}</td>
          <td>{{$auxi->updated_at}}</td>
          <td>
            <div class="contain">
              <div class="contain">
                <a href="{{route('auxisCopy', $auxi->id)}}" class="tablaBase__boton">Cop</a>
              </div>
              <div class="contain">
                <a href="{{route('auxis.edit', $auxi->id)}}" class="tablaBase__boton">Ed</a>
              </div>
              <div class="contain">
                <form action="{{route('auxis.destroy', $auxi)}}" method="POST">
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

{{-- esta funcion no se compila desde resources/js/functions/ --}}
<script type="text/javascript" src="{{ asset('js/delete_elements.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>
<script>let dataTableC = new simpleDatatables.DataTable("#tabla_base");</script>

@endsection