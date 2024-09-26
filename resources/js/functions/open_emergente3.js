document.addEventListener('DOMContentLoaded', function() {
  // Selecciona el botón que abre la ventana emergente
  const openButton = document.getElementById('open_emergente');
  // Selecciona el contenedor donde se mostrará la ventana emergente
  const emergenteContainer = document.createElement('div');
  document.body.appendChild(emergenteContainer);

  // Escucha el evento de clic en el botón de apertura
  openButton.addEventListener('click', function(event) {
      event.preventDefault();

      // Realiza una solicitud para obtener el contenido de la sección emergente
      fetch('/ruta/al/contenido/emergente') // Actualiza esta ruta según tu configuración
          .then(response => response.json())
          .then(data => {
              // Inserta el contenido en el contenedor emergente
              emergenteContainer.innerHTML = data.htmlContent;

              // Muestra la ventana emergente
              emergenteContainer.style.display = 'block';

              // Maneja el cierre de la ventana emergente
              const closeButton = document.getElementById('close');
              closeButton.addEventListener('click', function() {
                  emergenteContainer.style.display = 'none';
              });
          })
          .catch(error => {
              console.error('Error al cargar el contenido:', error);
          });
  });
});
