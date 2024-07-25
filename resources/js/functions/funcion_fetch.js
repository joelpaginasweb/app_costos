

//funcion generica como ejemplo

fetch('https://api.example.com/data')
  .then(response => response.json())
  .then(data => console.log(data))
  .catch(error => console.error('Error:', error));

  // fetch('https://api.example.com/data')
// Esta línea inicia una solicitud HTTP GET a la URL especificada.
// fetch devuelve una Promesa que se resuelve con un objeto Response.

// .then(response => response.json())
// Este es el primer .then(). Se ejecuta cuando la promesa de fetch se resuelve.
// response.json() toma el cuerpo de la respuesta y lo interpreta como JSON.
// Esta función también devuelve una Promesa.

// .then(data => console.log(data))
// Este es el segundo .then(). Se ejecuta cuando la promesa de response.json() se resuelve.
// data contiene el objeto JSON parseado.
// En este caso, simplemente se imprime data en la consola.

// .catch(error => console.error('Error:', error))
// .catch() captura cualquier error que ocurra en cualquier parte de la cadena de promesas.
// Si hay un error (por ejemplo, falla la conexión o el JSON es inválido), se ejecuta esta función.
// Imprime el error en la consola.
