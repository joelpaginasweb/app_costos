
document.addEventListener('DOMContentLoaded', function() {
  // Escuchar los clics en los botones con la clase 'edit-btn'
  document.querySelectorAll('.edit-btn').forEach(function(button) {
      button.addEventListener('click', function() {
          var id = this.getAttribute('data-id'); // Obtener el ID del auxiliar a editar

          // Realizar la solicitud AJAX con fetch
          fetch('/auxis/' + id + '/edit')
              .then(response => {
                  if (!response.ok) {
                      throw new Error('Error al cargar la vista: ' + response.statusText);
                  }
                  return response.text(); // Obtener el contenido HTML como texto
              })
              .then(data => {
                  // Cargar el contenido recibido en el modal
                  document.getElementById('modal-body').innerHTML = data;
                  // Mostrar el modal
                  document.getElementById('editModal').style.display = 'block';
              })
              .catch(error => {
                  console.error('Error:', error);
              });
      });
  });

  // Cerrar el modal cuando se haga clic en la 'x'
  document.querySelector('.close').addEventListener('click', function() {
      document.getElementById('editModal').style.display = 'none';
  });
});



// $(document).on('click', '.edit-btn', function() {
//   var id = $(this).data('id'); 
  
//   $.ajax({
//       url: '/auxis/' + id + '/edit', 
//       type: 'GET',
//       success: function(data) {
        
//           $('#modal-body').html(data);
//           $('#editModal').css('display', 'block');
//       },
//       error: function(xhr) {
//           console.error('Error al cargar la vista:', xhr);
//       }
//   });
// });

// $(document).on('click', '.close', function() {
//   $('#editModal').css('display', 'none');
// });
