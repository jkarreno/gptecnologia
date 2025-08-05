<?php
    include("../conexion.php");

    $ResEquipo=mysqli_query($conn, "SELECT * FROM equipos WHERE Consecutivo='".$_POST["equipo"]."' LIMIT 1");
	$RResE=mysqli_fetch_array($ResEquipo);

    $cadena='<form name="feditequipo" id="feditequipo">
            <div class="tabla">
                <div class="titprin">
                    Editar Equipo
                </div>

                <div class="c20 c_derecha">
                    Nombre:
                </div>
                <div class="c80 ccenter">
                    <input type="text" name="equipo" id="equipo" value="'.$RResE["Equipo"].'">
                </div>

                <div class="c20 c_derecha">
                    Descripción:
                </div>
                <div class="c80 ccenter">
                    <input type="text" name="descripcion" id="descripcion" value="'.$RResE["Descripcion"].'">
                </div>

                <div class="c100 ccenter">
                    <input type="hidden" name="hacer" id="hacer" value="editequipo">
                    <input type="hidden" name="idequipo" id="idequipo" value="'.$RResE["Consecutivo"].'">
                    <input type="submit" name="boteditequipo" id="boteditequipo" value="Editar>>">
                    </div>
                </div>
            </form>';

    echo $cadena;

?>
<script>
$("#feditequipo").on("submit", function(e){
	e.preventDefault();
	var formData = new FormData(document.getElementById("feditequipo"));

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