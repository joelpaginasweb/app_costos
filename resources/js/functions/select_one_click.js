

const inputs = document.querySelectorAll('[id="select_auto"]');
inputs.forEach(input => {
  input.addEventListener('click', function() {
    this.select();
  });
});










/*--------------------------*/

// const inputs = document.getElementById('select_auto');
// inputs.forEach(input => {
//   input.addEventListener('click', function() {
//     this.select();
//   });
// });

/*--------------------------------*/

// document.getElementById("select_auto").addEventListener("dblclick", function() {
//   this.disabled = false; // Habilitar el input al hacer doble clic
// });

// document.getElementById("input_excel").addEventListener("keypress", function(event) {
//   if (event.key === "Enter") {

//     // event.preventDefault();
//     //  Evitar el comportamiento predeterminado del Enter
//     // Aquí puedes enviar el dato ingresado al servidor


//     // this.disabled = true; 
//     // Deshabilitar el input después de enviar el dato
//   }
// });


/*-----------funcion original------------------*/
// document.getElementById("input_excel").addEventListener("dblclick", function() {
//   this.disabled = false; // Habilitar el input al hacer doble clic
// });

// document.getElementById("input_excel").addEventListener("keypress", function(event) {
//   if (event.key === "Enter") {

//     event.preventDefault();
//     /* Evitar el comportamiento predeterminado del Enter
//     Aquí puedes enviar el dato ingresado al servidor*/


//     this.disabled = true; 
//    /* Deshabilitar el input después de enviar el dato*/
//   }
// });