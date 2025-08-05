<?php
    include("../conexion.php");

    $cadena='<form name="fadrefaccion" id="fadrefaccion">
            <div class="tabla">
                <div class="titprin">
                    Agregar Refacción
                </div>

                <div class="c20 c_derecha">
                    Tipo:
                </div>
                <div class="c80 ccenter">
                    <input type="text" name="refaccion" id="refaccion">
                </div>

                <div class="c20 c_derecha">
                    Descripción:
                </div>
                <div class="c80 ccenter">
                    <input type="text" name="descripcion" id="descripcion">
                </div>

                <div class="c100 ccenter">
                    <input type="hidden" name="hacer" id="hacer" value="addrefaccion">
                    <input type="submit" name="botadrefaccion" id="botadrefaccion" value="Agregar>>">
                    </div>
                </div>
            </form>';

    echo $cadena;

?>
<script>
$("#fadrefaccion").on("submit", function(e){
	e.preventDefault();
	var formData = new FormData(document.getElementById("fadrefaccion"));

	$.ajax({
		url: "refacciones/refacciones.php",
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