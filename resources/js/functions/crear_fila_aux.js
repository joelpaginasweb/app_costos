

const botonCrearAux = document.getElementById('boton_crear_aux');

if(botonCrearAux) {

  botonCrearAux.addEventListener('click', function() {             

    const containerAux = document.querySelector('#container_aux');

    var container = document.createElement('div');
    // container.setAttribute('id', 'contain_element');
    container.setAttribute('class', 'container contain_element');


    var span = document.createElement('span');
    span.setAttribute('class', 'form__span span_del');
    span.setAttribute('onclick', 'eliminar(this)');

    // span.setAttribute('id', 'span_del');
    span.innerText = 'x';

    var labelMaterialAux = document.createElement('label');
    labelMaterialAux.setAttribute('for', 'id_material');
    labelMaterialAux.setAttribute('class', 'form__label');
    labelMaterialAux.innerText = 'Id material';

    var inputMaterialAux = document.createElement('input');
    inputMaterialAux.setAttribute('type', 'number');
    inputMaterialAux.setAttribute('step', '0');
    inputMaterialAux.setAttribute('name', 'id_material[]');
    inputMaterialAux.setAttribute('class', 'form__input');
    inputMaterialAux.setAttribute('placeholder', 'id material');

    var labelCantidadAux = document.createElement('label');
    labelCantidadAux.setAttribute('for', 'cantidad_mater');
    labelCantidadAux.setAttribute('class', 'form__label');
    labelCantidadAux.innerText = 'cantidad material';

    var inputCantidadAux = document.createElement('input');
    inputCantidadAux.setAttribute('type', 'number');
    inputCantidadAux.setAttribute('step', '0.0001');
    inputCantidadAux.setAttribute('name', 'cantidad_mater[]');
    inputCantidadAux.setAttribute('class', 'form__input');
    inputCantidadAux.setAttribute('placeholder', 'cantidad material'); 
    
    container.appendChild(span);
    container.appendChild(labelMaterialAux);
    container.appendChild(inputMaterialAux);
    container.appendChild(labelCantidadAux);
    container.appendChild(inputCantidadAux);
    
    containerAux.appendChild(container);
  });
}

