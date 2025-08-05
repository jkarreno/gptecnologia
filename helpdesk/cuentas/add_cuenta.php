<?php
    include ("../conexion.php");	
    
    $cadena='<form name="fadcuenta" id="fadcuenta">
			<div class="tabla">
				<div class="titprin">
                Nueva Cuenta
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
					Contacto:
				</div>
				<div class="c80 ccenter">
					<input type="text" name="contacto" id="contacto">
                </div>
                
                <div class="c20 c_derecha">
					Email:
				</div>
				<div class="c80 ccenter">
					<input type="text" name="correoe" id="correoe">
                </div>

                <div class="c20 c_derecha">
					Telefono:
				</div>
				<div class="c80 ccenter">
					<input type="text" name="telefono" id="telefono">
                </div>

                <div class="c20 c_derecha">
                    Num. Ticket Interno:
				</div>
				<div class="c80 ccenter">
					<input type="text" name="ticketinterno" id="ticketinterno" value="1">
                </div>

                <div class="c20 c_derecha">
                    Num. Ticket Cuenta:
				</div>
				<div class="c80 ccenter">
					<input type="text" name="ticketcuenta" id="ticketcuenta" value="1">
                </div>

                <div class="c100 ccenter">
                    <input type="hidden" name="hacer" id="hacer" value="addcuenta">
					<input type="submit" name="botadcuenta" id="botadcuenta" value="Agregar>>">
				</div>
			</div>
    </form>';

    echo $cadena;
?>
<script>
$("#fadcuenta").on("submit", function(e){
	e.preventDefault();
	var formData = new FormData(document.getElementById("fadcuenta"));

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