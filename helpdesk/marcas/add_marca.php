<?php
    include("../conexion.php");

    $cadena='<form name="fadmarca" id="fadmarca">
            <div class="tabla">
                <div class="titprin">
                    Agregar Marca
                </div>

                <div class="c20 c_derecha">
                    Nombre:
                </div>
                <div class="c80 ccenter">
                    <input type="text" name="marca" id="marca">
                </div>

                <div class="c20 c_derecha">
                    Descripción:
                </div>
                <div class="c80 ccenter">
                    <input type="text" name="descripcion" id="descripcion">
                </div>

                <div class="c100 ccenter">
                    <input type="hidden" name="hacer" id="hacer" value="addmarca">
                    <input type="submit" name="botadmarca" id="botadmarca" value="Agregar>>">
                    </div>
                </div>
            </form>';

    echo $cadena;

?>
<script>
$("#fadmarca").on("submit", function(e){
	e.preventDefault();
	var formData = new FormData(document.getElementById("fadmarca"));

	$.ajax({
		url: "marcas/marcas.php",
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