<?php
    include ("../conexion.php");	
    
    $ResSucursal=mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM sucursales WHERE Consecutivo='".$_POST["sucursal"]."' LIMIT 1"));
	
	$ResCuenta=mysqli_query($conn, "SELECT Consecutivo, Empresa FROM cuentas WHERE Consecutivo='".$ResSucursal["Cuenta"]."' LIMIT 1");
    $RResCuenta=mysqli_fetch_array($ResCuenta);

    $cadena='<form name="feditsucursal" id="feditsucursal">
			<div class="tabla">
				<div class="titprin">
                Editar sucursal para '.$RResCuenta["Empresa"].'
				</div>
				
				<div class="c20 c_derecha">
					Nombre:
				</div>
				<div class="c80 ccenter">
					<input type="text" name="nombre" id="nombre" value="'.$ResSucursal["Nombre"].'">
                </div>

				<div class="c20 c_derecha">
					Dirección:
				</div>
				<div class="c80 ccenter">
					<input type="text" name="direccion" id="direccion" value="'.$ResSucursal["Direccion"].'">
                </div>
                
                <div class="c20 c_derecha">
					Telefono:
				</div>
				<div class="c80 ccenter">
					<input type="text" name="telefono" id="telefono" value="'.$ResSucursal["Telefono"].'">
                </div>

                <div class="c100 ccenter">
					<input type="hidden" name="hacer" id="hacer" value="editsucursal">
					<input type="hidden" name="cuenta" id="cuenta" value="'.$RResCuenta["Consecutivo"].'">
					<input type="hidden" name="sucursal" id="sucursal" value="'.$ResSucursal["Consecutivo"].'">
					<input type="submit" name="boteditsucursal" id="boteditucursal" value="Editar>>">
				</div>
			</div>
    </form>';

    echo $cadena;
?>
<script>
$("#feditsucursal").on("submit", function(e){
	e.preventDefault();
	var formData = new FormData(document.getElementById("feditsucursal"));

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