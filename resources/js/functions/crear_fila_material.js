
const botonCrearMat = document.getElementById('boton_crear_mat');

if(botonCrearMat) {

  botonCrearMat.addEventListener('click', function() { 

    const containerMater = document.querySelector('#container_mater');

    var container = document.createElement('div');
    container.setAttribute('class', 'container');

    var labelSelect = document.createElement('label');
    labelSelect.setAttribute('for', 'select');
    labelSelect.setAttribute('class', 'form__label');
    labelSelect.innerText = 'Tipo';

    var selectMat = document.createElement('select');
    selectMat.setAttribute('name', 'tipo_material[]');

    var optionMat = document.createElement('option');
    optionMat.setAttribute('value', 'material');
    optionMat.innerText = 'material';

    var optionAux = document.createElement('option');
    optionAux.setAttribute('value', 'auxiliar');
    optionAux.innerText = 'auxiliar';

    var labelMaterial = document.createElement('label');
    labelMaterial.setAttribute('for', 'id_material');
    labelMaterial.setAttribute('class', 'form__label');
    labelMaterial.innerText = 'Id material';

    var inputMaterial = document.createElement('input');
    inputMaterial.setAttribute('type', 'number');
    inputMaterial.setAttribute('step', '0');
    inputMaterial.setAttribute('name', 'id_material[]');
    inputMaterial.setAttribute('class', 'form__input');
    inputMaterial.setAttribute('placeholder', 'id material');

    var labelCantidad = document.createElement('label');
    labelCantidad.setAttribute('for', 'cantidad_mater');
    labelCantidad.setAttribute('class', 'form__label');
    labelCantidad.innerText = 'cantidad material';

    var inputCantidad = document.createElement('input');
    inputCantidad.setAttribute('type', 'number');
    inputCantidad.setAttribute('step', '0.00001');
    inputCantidad.setAttribute('name', 'cantidad_mater[]');
    inputCantidad.setAttribute('class', 'form__input');
    inputCantidad.setAttribute('placeholder', 'cantidad material');

    selectMat.appendChild(optionMat);
    selectMat.appendChild(optionAux);

    container.appendChild(labelSelect);
    container.appendChild(selectMat);
    container.appendChild(labelMaterial);
    container.appendChild(inputMaterial);
    container.appendChild(labelCantidad);
    container.appendChild(inputCantidad);

    containerMater.appendChild(container);
  });
}