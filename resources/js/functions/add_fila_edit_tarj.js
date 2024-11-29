document.addEventListener('DOMContentLoaded', () => {

  // Constantes para el div contenedor de los inputs y el botón de agregar
  const btnAddMat = document.querySelector('#boton_add_mat');
  const conteinerMat = document.querySelector('#tbody_mat');

  const btnAddMO = document.querySelector('#boton_add_mo');
  const conteinerMO = document.querySelector('#tbody_mo');

  const btnAddEq = document.querySelector('#boton_add_eq');
  const conteinerEq = document.querySelector('#tbody_eq');

  /**  * Método  clic  botón de agregar elemento mat  */
  btnAddMat.addEventListener('click', e => {
    let tr = document.createElement('tr');
    tr.innerHTML = `
      <tr>
        <td  class="form__span" onclick="eliminar(this)">X</td>
        <td>
            <div class="contain">
              <div class="contain">
                <select class="select_none" name="tipo_material[]">
                  <option value="material" @selected($conceptoIns['tipo']==='material' )>mat</option>
                  <option value="auxiliar" @selected($conceptoIns['tipo']==='auxiliar' )>aux</option>
                </select>
              </div>
              <input type="number" step="0" name="id_material[]"
              class="form__input  form__input--short select_auto pointer" value="{{$conceptoIns['id_insumo']}}">
          </div>         
        </td>
        <td>-</td>
        <td>-</td>
        <td>
          <input type="number" step="0.0001" name="cantidad_mater[]"
            class="form__input form__input--short pointer select_auto " value="{{$conceptoIns['cantidad']}}">          
        </td>
        <td>0.00</td>
        <td>0.00</td>
      </tr>
    `;
    conteinerMat.appendChild(tr);
  });

  /**  * Método  clic  botón de agregar elemento MO  */
  btnAddMO.addEventListener('click', e => {
    let tr = document.createElement('tr');
    tr.innerHTML = `
      <tr>
        <td  class="form__span" onclick="eliminar(this)">X</td>
        <td>
            <div class="contain">
              <div class="contain">
                <select class="select_none" name="tipo_mano_obra[]">
                  <option value="categoria" @selected($conceptoMO['tipo']==='categoria' )>cat</option>
                  <option value="cuadrilla" @selected($conceptoMO['tipo']==='cuadrilla' )>cuad</option>
                </select>
              </div>
              <input type="number" step="0" name="id_mano_obra[]"
                class="form__input  form__input--short select_auto pointer" value="{{$conceptoMO['id_MO']}}">
            </div>        
        </td>
        <td>-</td>
        <td>-</td>
        <td> 
            <input type="number" step="0.0001" name="cant_mano_obra[]"
                class="form__input form__input--short pointer select_auto " value="{{$conceptoMO['cantidad']}}">
        </td>
        <td>0.00</td>
        <td>0.00</td>
      </tr>
    `;
    conteinerMO.appendChild(tr);
  });

  /**  * Método  clic  botón de agregar elemento mat  */
  btnAddEq.addEventListener('click', e => {
    let tr = document.createElement('tr');
    tr.innerHTML = `
      <tr>
        <td  class="form__span" onclick="eliminar(this)">X</td>
        <td>
          <input type="number" step="0" name="id_equipo[]"
          class="form__input  form__input--short select_auto pointer " value="{{$conceptoEq->id_equipo}}">          
        </td>
        <td>-</td>
        <td>-</td>
        <td> 
          <input type="number" step="0.0001" name="cant_equipo[]"
          class="form__input form__input--short pointer select_auto " value="{{$conceptoEq->cantidad}}">
        </td>
        <td>0.00</td>
        <td>0.00</td>
      </tr>
    `;
    conteinerEq.appendChild(tr);
  });

});



// const spanBorrarInput = document.getElementById('borrar_input');
// if(spanBorrarInput) {

//   spanBorrarInput.addEventListener('click', function() {
//     const eliminar = (e) => {
//       const divPadre = e.parentNode;
//       while (divPadre.firstChild) {
//           divPadre.firstChild.remove();
//       }
//       divPadre.remove();
//     };

//   });
// }




