window.addEventListener('scroll', function() {
    var header = document.getElementById('main-header');
    var contenedorPrincipal = document.querySelector('.contenedor-principal');
    
    // Calculamos la posición del primer div contenedor principal
    var contenedorPrincipalPosition = contenedorPrincipal.getBoundingClientRect().top;
    
    // Si la posición del contenedor principal es menor o igual a 0
    if (contenedorPrincipalPosition <= 0) {
      // Cambiamos el fondo del header a transparente
      header.style.background = 'transparent';
    } else {
      // Si no, restauramos el color de fondo del header
      header.style.background = '#333';
    }
  });
  