document.addEventListener('DOMContentLoaded', () => {
  // Constantes para el div contenedor de los inputs y el botón de agregar
  const btnCreaCuad = document.querySelector('#btn_crea_cuad');
  const conteinerCuad = document.querySelector('#container_cuad');

  /**  * Método  clic al botón de agregar elementos  */
  btnCreaCuad.addEventListener('click', e => {
      let div = document.createElement('div');
      div.innerHTML = `
      <div class="container contain_element">
        <span class="form__span" onclick="eliminar(this)">x</span>
        <label for="id_categoria" class="form__label">Id categoria</label>
        <input type="number" step="0" name="id_categoria[]" class="form__input" placeholder="id categoria">
        <label for="cantidad_mo" class="form__label">cantidad </label>
        <input type="number" step="0.00001" name="cantidad_mo[]" class="form__input"
            placeholder="cantidad">   
      </div>
      `;
      conteinerCuad.appendChild(div);
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




