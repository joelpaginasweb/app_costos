
const botonCrearMO = document.getElementById('boton_crear_mo');

if(botonCrearMO) {

  botonCrearMO.addEventListener('click', function() { 

    const containerMO = document.querySelector('#container_mo');

    var container = document.createElement('div');
    container.setAttribute('class', 'container');

    var spanFormSpan = document.createElement('span');
    spanFormSpan.setAttribute('class', 'form__span');
    spanFormSpan.setAttribute('onclick', 'eliminar(this)');
    spanFormSpan.innerText ='x';

    var labelSelect = document.createElement('label');
    labelSelect.setAttribute('for', 'select');
    labelSelect.setAttribute('class', 'form__label');
    labelSelect.innerText = 'Tipo';

    var selectMat = document.createElement('select');
    selectMat.setAttribute('name', 'tipo_mano_obra[]');

    var optionMat = document.createElement('option');
    optionMat.setAttribute('value', 'categoria');
    optionMat.innerText = 'categoria';

    var optionAux = document.createElement('option');
    optionAux.setAttribute('value', 'cuadrilla');
    optionAux.innerText = 'cuadrilla';
// ------------------------------------------------

    var labelMO = document.createElement('label');//
    labelMO.setAttribute('for', 'id_mano_obra');
    labelMO.setAttribute('class', 'form__label');
    labelMO.innerText = 'Id mano de obra';

    var inputMO = document.createElement('input');//
    inputMO.setAttribute('type', 'number');
    inputMO.setAttribute('step', '0');
    inputMO.setAttribute('name', 'id_mano_obra[]');
    inputMO.setAttribute('class', 'form__input');
    inputMO.setAttribute('placeholder', 'Id mano de obra');

    var labelCantidadMO = document.createElement('label');//
    labelCantidadMO.setAttribute('for', 'cant_mano_obra');
    labelCantidadMO.setAttribute('class', 'form__label');
    labelCantidadMO.innerText = 'cantidad M.O.';

    var inputCantidadMO = document.createElement('input');
    inputCantidadMO.setAttribute('type', 'number');
    inputCantidadMO.setAttribute('step', '0.00001');
    inputCantidadMO.setAttribute('name', 'cant_mano_obra[]');
    inputCantidadMO.setAttribute('class', 'form__input');
    inputCantidadMO.setAttribute('placeholder', 'cantidad MO');

    selectMat.appendChild(optionMat);
    selectMat.appendChild(optionAux);

    container.appendChild(spanFormSpan);
    container.appendChild(labelSelect);
    container.appendChild(selectMat);
    container.appendChild(labelMO);//
    container.appendChild(inputMO);//
    container.appendChild(labelCantidadMO);//
    container.appendChild(inputCantidadMO);//

    containerMO.appendChild(container);    
  
  });
}