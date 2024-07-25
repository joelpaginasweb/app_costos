@extends('layouts.aplication')
@section('title', 'Presupuesto')
@section('content')


<section class="section section--up">
  <div>
    <h1>PRESUPUESTO</h1>   
    <h4>APLICACION EN CONSTRUCCION</h4>
  </div>  
</section>


<section class="section__form">
  <div class="form__titulo">
    <h4>REGISTRAR NUEVO PRESUPUESTO</h4>
  </div>
  <form action="{{route('presus.store')}}" method="POST" class="form">
    @csrf

    <div class="contenedorFlex">
      <input type="text" name="obra" placeholder="Titulo" class="form__input">
      <input type="text" name="cliente" placeholder="cliente" class="form__input">
      <input type="text" name="direccion" placeholder="direccion" class="form__input">
      <input type="text" name="colonia" placeholder="colonia" class="form__input">
      <input type="text" name="municipio" placeholder="municipio" class="form__input">
      <input type="text" name="estado" placeholder="estado " class="form__input">
    </div>
    <div class="contenedorFlex">
      <div class="container">
        <label for="porcent_indirecto" class="form__label">indirectos</label>
        <input type="number" step="0" name="porcent_indirecto" class="form__input" placeholder="indirectos">
      </div>
      <div class="container">
        <label for="porcent_financiam" class="form__label">financiamiento</label>
        <input type="number" step="0" name="porcent_financiam" class="form__input" placeholder="financiamiento">
      </div>
      <div class="container">
        <label for="porcent_utilidad" class="form__label">utilidad</label>
        <input type="number" step="0" name="porcent_utilidad" class="form__input" placeholder="utilidad">
      </div>
      <div class="container">
        <label for="porcent_costos_add" class="form__label">costos adicionales</label>
        <input type="number" step="0" name="porcent_costos_add" class="form__input" placeholder="costos adicionales">
      </div>
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

  <div class="section">
    @if ($errors->any())
    <div class="alert alert-danger mt-3">
      <strong>¡Error al crear presupuesto!</strong>
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
      <h5>LISTADO DE PRESUPUESTOS</h5>
    </div>
  </div>

  <div class="containerTabla">
    <table class="tablaTarjetas">
      <tbody>
        <tr class="tablaTarjetas__head">
          <td>ID PRESUP</td>
          <td>TITULO</td>
          <td>CLIENTE</td>
          <td>DIRECCION</td>
          <td>CIUDAD</td>
          <td>ESTATUS</td>
          <td>COSTO DIR</td>
          <td>COSTO IND</td>
          <td>COSTO TOTAL</td>
          <td>FECHA EDICION</td>
          <td>EDICION</td>
        </tr>
        @foreach ($presus as $presu)
        <tr onclick="abrir()" class="tablaTarjetas__body">
          <td>{{$presu->id}}</td>
          <td>{{$presu->obra}}</td>
          <td>{{$presu->cliente}}</td>
          <td>{{$presu->direccion}}</td>
          <td>{{$presu->municipio}}</td>
          <td>{{$presu->estatus}}</td>
          <td>
            {{-- {{$presu->costo_directo}} --}}
               {{number_format($presu->costo_directo, 2)}}
          </td>
          <td>
            {{-- {{$presu->costo_indirecto}} --}}
               {{number_format($presu->costo_indirecto, 2)}}        
          </td>
          <td>
            {{-- {{$presu->costo_total}} --}}
               {{number_format($presu->costo_total, 2)}}        
          </td>
          <td>{{$presu->updated_at}}</td>
          <td>
            <div class="contain">
              <div class="contain">
                <a href="{{route('presus.edit', $presu->id)}}" class="tabla__boton">Ed</a>
              </div>
              {{-------metodo destroy---------}}
              {{-- <div class="contain">
                <form action="{{route('presus.destroy', $presu)}}" method="POST">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="tabla__boton">X</button>
                </form>
              </div> --}}

            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

</section>

@endsection