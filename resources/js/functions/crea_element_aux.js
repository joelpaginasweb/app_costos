document.addEventListener('DOMContentLoaded', () => {
  // Constantes para el div contenedor de los inputs y el botón de agregar
  const btnCreaAux = document.querySelector('#boton_crea_aux');
  const conteinerAuxi = document.querySelector('#container_auxi');

  /**  * Método  clic al botón de agregar elementos  */
  btnCreaAux.addEventListener('click', e => {
      let div = document.createElement('div');
      div.innerHTML = `
      <div class="container contain_element">
        <span class="form__span" onclick="eliminar(this)">x</span>
        <label for="id_material" class="form__label">Id material</label>
        <input type="number" step="0" name="id_material[]" class="form__input" placeholder="id material">
        <label for="cantidad_mater" class="form__label">cantidad material</label>
        <input type="number" step="0.00001" name="cantidad_mater[]" class="form__input" placeholder="cantidad material">   
      </div>
      `;
      conteinerAuxi.appendChild(div);
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




