<?php
	//Inicio la sesion 
	session_start();

    include ("../conexion.php");

    $ResNTicket=mysqli_query($conn, "SELECT ConsecutivoInterno, ConsecutivoCuenta FROM cuentas WHERE Consecutivo='".$_SESSION["cuenta"]."' LIMIT 1");
	$RResNTicket=mysqli_fetch_array($ResNTicket);
	
	if($_POST["sucursal"]!=0)
	{
		$ResSuc=mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM sucursales WHERE Consecutivo='".$_POST["sucursal"]."' LIMIT 1"));
	}
	
	$cadena='<form name="fadticket" id="fadticket">
				<input type="hidden" name="tickinterno" id="tickinterno" value="'.$RResNTicket["ConsecutivoInterno"].'">
				<table border="0" cellpadding="5" align="center">
					<tr>
						<th colspan="6" align="center" class="textotitable">Ticket de Reporte</th>
					</tr>
					<tr>
						<td colspan="2" class="texto" align="left">Sucursal: </td>
						<td colspan="4" class="texto" align="left">
						<select name="sucursal" id="sucursal" class="input" onchange="nuevo_ticket(this.value)"><option>Seleccione</option>';
	$ResSucursal=mysqli_query($conn, "SELECT Consecutivo, Nombre FROM sucursales WHERE Cuenta='".$_SESSION["cuenta"]."' ORDER BY Consecutivo ASC");
	while ($RResSucursal=mysqli_fetch_array($ResSucursal))
	{
		$cadena.='<option value="'.$RResSucursal["Consecutivo"].'"'; if($_POST["sucursal"]==$RResSucursal["Consecutivo"]){$cadena.=' selected';}$cadena.='>'.$RResSucursal["Nombre"].'</option>';
	}
	$cadena.='				</select></td>
					</tr>
					<tr>
						<td colspan="2" class="texto" align="left">Referencia: </td>
						<td colspan="4" class="texto" align="left"><input type="text" name="tickcuenta" id="tickcuenta" class="input"></td>
					</tr>
					<tr>
						<td colspan="2" class="texto" align="left">Usuario Responsable:</td>
						<td colspan="4" class="texto" align="left"><input type="text" name="nusuario" id="nusuario" size="80" class="input"></td>
					</tr>
					<tr>
						<td colspan="2" class="texto" align="left">Direccion:</td>
						<td colspan="4" class="texto" algin="left"><input type="text" name="direccion" id="direccion" size="80" class="input" value="'.$ResSuc["Direccion"].'"></td>
					</tr>
					<tr>
						<td colspan="2" class="texto" align="left">Piso:</td>
						<td colspan="4" class="texto" align="left"><input type="text" name="piso" id="piso" size="5" class="input"></td>
					</tr>
					<tr>
						<td class="texto" align="left">Telefono:</td>
						<td colspan="2" class="texto" align="left"><input type="text" name="telefono" id="telefono" size="10" class="input" value="'.$ResSuc["Telefono"].'"></td>
						<td class="texto" align="left">Extension: </td>
						<td colspan="2" class="texto align="left"><input type="text" name="ext" id="ext" size="3" class="input"></td>
					</tr>
					<tr>
						<td colspan="2" class="texto" align="left">E-mail: </td>
						<td colspan="4" class="texto" align="left"><input type="text" name="email" id="email" class="input" size="40"></td>
					</tr>
					<tr>
						<td colspan="2" class="texto" align="left">Area o Departamento:</td>
						<td colspan="4" class="texto" align="left"><input type="text" name="area" id="area" size="30" class="input"></td>
					</tr> 
					<tr>
						<td class="texto" align="left">Equipo:</td>
						<td colspan="2" class="texto" align="left"><select name="equipo" id="equipo" class="input"><option>Seleccione</option>';
	$ResEquipo=mysqli_query($conn, "SELECT Consecutivo, Equipo FROM equipos ORDER BY Equipo ASC");
	while($RResEquipo=mysqli_fetch_array($ResEquipo))
	{
		$cadena.='<option value="'.$RResEquipo["Consecutivo"].'">'.utf8_encode($RResEquipo["Equipo"]).'</option>';
	}
		$cadena.=' 			</select></td>
						<td class="texto" align="left">Marca:</td>
						<td colspan="2" class="texto" align="left"><select name="marca" id="marca" class="input"><option>Seleccione</potion>';
		$ResMarca=mysqli_query($conn, "SELECT Consecutivo, Nombre FROM marcas ORDER BY Nombre ASC");
		while($RResMarca=mysqli_fetch_array($ResMarca))
		{
			$cadena.='<option value="'.$RResMarca["Consecutivo"].'">'.utf8_encode($RResMarca["Nombre"]).'</option>';
		}
		$cadena.=' 	 		</select></td>
					</tr>
					<tr>
						<td class="texto" align="left">Modelo:</td>
						<td class="texto" align="left"><input type="text" name="modelo" id="modelo" class="input" size="50"></td>
						<td class="texto" align="left">No. de Serie:</td>
						<td class="texto" align="left">
							<input type="text" list="numseries" id="nserie" name="nserie" class="input" size="50" />
							<datalist id="numseries" class="input">';
		$ResNumSerie = mysqli_query($conn, "SELECT NumSerie FROM `tickets` WHERE Cuenta = '".$_SESSION["cuenta"]."' GROUP BY NumSerie ORDER BY NumSerie ASC;");
		while($RResNS = mysqli_fetch_array($ResNumSerie))
		{
			$cadena.='			<option value="'.$RResNS["NumSerie"].'"></option>';
		}
		$cadena.='			</datalist>
						</td>
						<td class="texto" align="left">No. de Inventario:</td>
						<td class="texto" align="left"><input type="text" name="ninventario" id="ninventario" class="input" size="50"></td>
					</tr>
					<tr>
						<td colspan="2" class="texto" align="left">Detalle Tecnico:</td>
						<td colspan="4" class="texto" align="left"><textarea name="dettecnico" id="dettecnico" class="input" cols="50" rows="5"></textarea></td>
					</tr>
					<tr>
						<td colspan="2" class="texto" align="left">Observaciones:</td>
						<td colspan="4" class="texto" align="left"><textarea name="observaciones" id="observaciones" class="input" cols="50" rows="5"></textarea></td>
					</tr>
					<tr>
						<td colspan="2" class="texto" align="left">Detalles de la Falla:</td>
						<td colspan="4" class="texto" align="left"><textarea name="detfalla" id="detfalla" class="input" cols="50" rows="5"></textarea></td>
					</tr>
					<tr>
						<td colspan="2" class="texto" align="left">Tipo de Servicio:</td>
						<td colspan="4" class="texto" align="left">
							<input type="radio" name="tservicio" value="correctivo" checked>&nbsp;Correctivo&nbsp; 
							<input type="radio" name="tservicio" value="preventivo">&nbsp;Preventivo
						</td>
					</tr>
					<tr>
						<td colspan="6" class="texto" align="center">
							<input type="reset" name="botreset" value="Limpiar Campos" class="boton">&nbsp;
							<input type="submit" name="botsendrepor" value="Enviar Reporte" class="boton">
						</td>
					</tr>
				</table>
			</form>';
                    
    echo $cadena;

?>
<script>
$("#fadticket").on("submit", function(e){
	e.preventDefault();
	var formData = new FormData(document.getElementById("fadticket"));

	$.ajax({
		url: "Tickets/nuevo_ticket_2.php",
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