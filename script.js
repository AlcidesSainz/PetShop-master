// Inicializar el dropdown
$(document).ready(function() {
  $('.dropdown-toggle').dropdown();
});
$(document).ready(function() {
    // Cerrar el menú desplegable al hacer clic en un elemento del menú
    $('.dropdown-item').click(function() {
        $('.dropdown-toggle').dropdown('toggle');
    });
});



