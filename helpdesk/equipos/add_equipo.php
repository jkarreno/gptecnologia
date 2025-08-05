<?php
    include("../conexion.php");

    $cadena='<form name="fadequipo" id="fadequipo">
            <div class="tabla">
                <div class="titprin">
                    Agregar Equipo
                </div>

                <div class="c20 c_derecha">
                    Nombre:
                </div>
                <div class="c80 ccenter">
                    <input type="text" name="equipo" id="equipo">
                </div>

                <div class="c20 c_derecha">
                    Descripción:
                </div>
                <div class="c80 ccenter">
                    <input type="text" name="descripcion" id="descripcion">
                </div>

                <div class="c100 ccenter">
                    <input type="hidden" name="hacer" id="hacer" value="addequipo">
                    <input type="submit" name="botadequipo" id="botadequipo" value="Agregar>>">
                    </div>
                </div>
            </form>';

    echo $cadena;

?>
<script>
$("#fadequipo").on("submit", function(e){
	e.preventDefault();
	var formData = new FormData(document.getElementById("fadequipo"));

	$.ajax({
		url: "equipos/equipos.php",
		type: "POST",
		dataType: "HTML",
		data: formData,
		cache: false,
		contentType: false,
		processData: false
	}).done(function(echo){
		$("#contenido").html(echo);
	});
});
</script>