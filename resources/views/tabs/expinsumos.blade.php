@extends('layouts.aplication')
@section('title', 'exploinsumos')
@section('content')

<section class="section">
  <div>
    <h1>EXPLOSION DE INSUMOS</h1>
    <h4>APLICACION EN CONSTRUCCION</h4>
  </div>

</section>


<section class="section__form "> 
    <div class="form__titulo">
      <h4>SELECCIONAR PRESUPUESTO</h4>
    </div>
    <div class="contain">
      <form method="GET" action="{{route('expinsumos.index') }}" class="form">
        {{-- @csrf --}}
        <div class="modal__contain contain">
          <div class="contain">
            <label for="presup" class="modal__label">Id de Presupuesto:</label>
            <input type="number" id="presup" name="presup" class="modal__input" value="{{ request()->input('id_presu') }}" required>
          </div>
          <div class="contain">
            <button type="submit" class="modal__boton">Generar</button>
          </div>
        </div>
      </form>
    </div>

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
      <h5>EXPLOSION DE INSUMOS</h5>
    </div>
    <div class="tablaBase__title">
      <h5>PRESUPUESTO X</h5>
    </div>
  </div>


  <div class="tablaBase__container">
    <table class="tablaBase tablaMateriales" id="tabla_base">
       <thead>
        <tr class="tabla__titulos">
          <th>ID</th>
          <th>TIPO</th>
          <th>INSUMO</th>
          <th>UNID</th>
          <th>CANTIDAD</th>
          <th>PRECIO UNIT.</th>
          <th>MONTO</th>
          <th>FECHA</th>
          {{-- <th>ACCION</th> --}}
        </tr>
      </thead>

      <tbody class="tablaBase__tbody">
        @forelse ($insumos as $insumo)
        <tr class="">
          <td>{{$insumo->id}}</td>
          <td>{{$insumo->tipo}}</td>
          <td>{{$insumo->insumo}}</td>
          <td>{{$insumo->unidad}}</td>
          <td>{{number_format($insumo->cantidad, 2)}}</td>
          <td>{{number_format($insumo->precio_unitario, 2)}}</td>
          <td>{{number_format($insumo->monto, 2)}}</td>
          <td>{{$insumo->updated_at}}</td>
        </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center">No hay registros disponibles</td>
            </tr>
        @endforelse
              {{-- <tbody class="tablaBase__tbody">
        @foreach ($expinsumos as $expinsumo)
        <tr class="">
          <td>{{$expinsumo->id}}</td>
          <td>{{$expinsumo->tipo}}</td>
          <td>{{$expinsumo->insumo}}</td>
          <td>{{$expinsumo->unidad}}</td>
          <td>{{number_format($expinsumo->cantidad, 2)}}</td>
          <td>{{number_format($expinsumo->precio_unitario, 2)}}</td>
          <td>{{number_format($expinsumo->monto, 2)}}</td>
          <td>{{$expinsumo->updated_at}}</td>
        </tr>
        @endforeach --}}

      </tbody>
    </table>
  </div>
</section>


<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>
<script>let dataTableC = new simpleDatatables.DataTable("#tabla_base");</script>

@endsection