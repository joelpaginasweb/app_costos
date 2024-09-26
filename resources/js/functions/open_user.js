
document.querySelector('.user__user').addEventListener('click', function(event) {
  event.preventDefault(); // Evita que el enlace navegue
  const lista = document.querySelector('.user__lista');
  
  // Cambia la propiedad display
  if (lista.style.display === 'block') {
    lista.style.display = 'none';
  } else {
    lista.style.display = 'block';
  }
});