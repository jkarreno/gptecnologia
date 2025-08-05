<?php
	include ("../conexion.php");	
	
	$ResCuenta=mysqli_query($conn, "SELECT * FROM cuentas WHERE Consecutivo='".$_POST["cuenta"]."' LIMIT 1");
    $RResCuenta=mysqli_fetch_array($ResCuenta);
    
    $cadena='<form name="fadsucursal" id="fadsucursal">
			<div class="tabla">
				<div class="titprin">
                Agregar sucursal para '.$RResCuenta["Empresa"].'
				</div>
				
				<div class="c20 c_derecha">
					Nombre:
				</div>
				<div class="c80 ccenter">
					<input type="text" name="nombre" id="nombre">
                </div>

				<div class="c20 c_derecha">
					Dirección:
				</div>
				<div class="c80 ccenter">
					<input type="text" name="direccion" id="direccion">
                </div>
                
                <div class="c20 c_derecha">
					Telefono:
				</div>
				<div class="c80 ccenter">
					<input type="text" name="telefono" id="telefono">
                </div>

                <div class="c100 ccenter">
					<input type="hidden" name="hacer" id="hacer" value="addsucursal">
					<input type="hidden" name="cuenta" id="cuenta" value="'.$RResCuenta["Consecutivo"].'">
					<input type="submit" name="botadsucursal" id="botadsucursal" value="Agregar>>">
				</div>
			</div>
    </form>';

    echo $cadena;
?>
<script>
$("#fadsucursal").on("submit", function(e){
	e.preventDefault();
	var formData = new FormData(document.getElementById("fadsucursal"));

	$.ajax({
		url: "cuentas/sucursales.php",
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