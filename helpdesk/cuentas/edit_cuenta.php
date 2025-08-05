<?php
    include ("../conexion.php");

    $ResCuenta=mysqli_query($conn, "SELECT * FROM cuentas WHERE Consecutivo='".$_POST["cuenta"]."' LIMIT 1");
    $RResCuenta=mysqli_fetch_array($ResCuenta);

    $cadena='<form name="feditcuenta" id="feditcuenta">
			<div class="tabla">
				<div class="titprin">
                Editar Cuenta
				</div>
				
				<div class="c20 c_derecha">
					Nombre:
				</div>
				<div class="c80 ccenter">
					<input type="text" name="nombre" id="nombre" value="'.$RResCuenta["Empresa"].'">
                </div>

				<div class="c20 c_derecha">
					Dirección:
				</div>
				<div class="c80 ccenter">
					<input type="text" name="direccion" id="direccion" value="'.$RResCuenta["Direccion"].'">
                </div>
                
                <div class="c20 c_derecha">
					Contacto:
				</div>
				<div class="c80 ccenter">
					<input type="text" name="contacto" id="contacto" value="'.$RResCuenta["Contacto"].'">
                </div>
                
                <div class="c20 c_derecha">
					Email:
				</div>
				<div class="c80 ccenter">
					<input type="text" name="correoe" id="correoe" value="'.$RResCuenta["CorreoElectronico"].'">
                </div>

                <div class="c20 c_derecha">
					Telefono:
				</div>
				<div class="c80 ccenter">
					<input type="text" name="telefono" id="telefono" value="'.$RResCuenta["Telefono"].'">
                </div>

                <div class="c20 c_derecha">
                    Num. Ticket Interno:
				</div>
				<div class="c80 ccenter">
					<input type="text" name="ticketinterno" id="ticketinterno" value="'.$RResCuenta["ConsecutivoInterno"].'">
                </div>

                <div class="c20 c_derecha">
                    Num. Ticket Cuenta:
				</div>
				<div class="c80 ccenter">
					<input type="text" name="ticketcuenta" id="ticketcuenta" value="'.$RResCuenta["ConsecutivoCuenta"].'">
                </div>

                <div class="c100 ccenter">
                    <input type="hidden" name="hacer" id="hacer" value="editcuenta">
                    <input type="hidden" name="idcuenta" id="idcuetna" value="'.$RResCuenta["Consecutivo"].'">
					<input type="submit" name="boteditcuenta" id="boteditcuenta" value="Editar>>">
				</div>
			</div>
    </form>';

    echo $cadena;
?>
<script>
$("#feditcuenta").on("submit", function(e){
	e.preventDefault();
	var formData = new FormData(document.getElementById("feditcuenta"));

	$.ajax({
		url: "cuentas/resumencuentas.php",
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