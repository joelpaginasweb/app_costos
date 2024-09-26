@extends('layouts.landing')
@section('title', 'Precios Unitarios')

@section('content')

<div id=oculto>
</div>

<div class="grid-container">

  <nav class="left">
    <p>Definicion</p>
    <h1>Presupuesto Precio unitario</h1>
    <p>Se considerará como precio unitario el importe de la remuneración o pago total que debe cubrirse al contratista
      por unidad de concepto terminado y ejecutado conforme al proyecto, especificaciones de construcción y normas de
      calidad.
    </p>
    <p>Se considerará como precio unitario el importe de la remuneración o pago total que debe cubrirse al contratista
      por unidad de concepto terminado y ejecutado conforme al proyecto, especificaciones de construcción y normas de
      calidad.
    </p>
  </nav>
  <main class="middle">
    <h2>APLICACION WEB PARA PRESUPUESTOS PU</h2>
    <p>En la ingeniería de software se denomina aplicación web o software web a aquella herramienta que los usuarios
      pueden utilizar accediendo a un servidor web a través de internet o de una intranet mediante un navegador. En
      otras palabras, es un programa que se codifica en un lenguaje interpretable por los navegadores web en la que se
      confía la ejecución al navegador.
    </p>
    <div>
      <h3>LA APLICACION WEB ESTA EN CONSTRUCCION</h3>
    </div>
    <br>
    <br>
    <div>
      <h3> APLICACION EN CONSTRUCCION</h3>
    </div>
    <br>
    {{-- ----------actualizaciones---------- --}}
    <div>
      <h4> EDICIONES </h4>
      <ul>
        <li>26 sep- Se agrego funcion open_user</li>
        <li>29 ago -Se agrego editar y borrar conceptos en editar auxiliares, formato tarjeta costos en editar auxiliares</li>
        
      </ul>
    </div>
    <br>
    <div>
      <h4>PRUEBA WEB COMPONENTS</h4>
      <hola-mundo name="nuevo" surname="web component"></hola-mundo>
      <eit-box-info></eit-box-info>
    </div>
  </main>

  <aside class="right">
    <h2>Bases de Datos</h2>
    <p>Se encarga de almacenar datos, también de conectarlos entre sí en una unidad lógica. En términos generales, es un
      conjunto de datos estructurados que pertenecen a un mismo contexto y, en cuanto a su función, se utiliza para
      administrar de forma electrónica grandes cantidades de información.
    </p>
  </aside>
  
</div>

@endsection