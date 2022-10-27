
$( "#olho" ).mousedown(function() {
    $("#senha").attr("type", "text");
  });
  
  $( "#olho" ).mouseup(function() {
    $("#senha").attr("type", "password");
  });

  var senha = $('#senha');
var olho= $("#olho");

olho.mousedown(function() {
  senha.attr("type", "text");
});

olho.mouseup(function() {
  senha.attr("type", "password");
});
// para evitar o problema de arrastar a imagem e a senha continuar expostas.
$( "#olho" ).mouseout(function() { 
  $("#senha").attr("type", "password");
});





