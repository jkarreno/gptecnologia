<?php
    include("../conexion.php");

    $ResMarca=mysqli_query($conn, "SELECT * FROM marcas WHERE Consecutivo='".$_POST["marca"]."' LIMIT 1");
	$RResMarca=mysqli_fetch_array($ResMarca);

    $cadena='<form name="feditmarca" id="feditmarca">
            <div class="tabla">
                <div class="titprin">
                    Editar Marca
                </div>

                <div class="c20 c_derecha">
                    Nombre:
                </div>
                <div class="c80 ccenter">
                    <input type="text" name="marca" id="marca" value="'.$RResMarca["Nombre"].'">
                </div>

                <div class="c20 c_derecha">
                    Descripción:
                </div>
                <div class="c80 ccenter">
                    <input type="text" name="descripcion" id="descripcion" value="'.$RResMarca["Descripcion"].'">
                </div>

                <div class="c100 ccenter">
                    <input type="hidden" name="hacer" id="hacer" value="editmarca">
                    <input type="hidden" name="idmarca" id="idmarca" value="'.$RResMarca["Consecutivo"].'">
                    <input type="submit" name="boteditmarca" id="boteditmarca" value="editar>>">
                    </div>
                </div>
            </form>';

    echo $cadena;

?>
<script>
$("#feditmarca").on("submit", function(e){
	e.preventDefault();
	var formData = new FormData(document.getElementById("feditmarca"));

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