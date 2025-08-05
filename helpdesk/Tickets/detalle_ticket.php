<?php
    //Inicio la sesion 
	session_start();
	
	date_default_timezone_set('America/Mexico_City');

    include ("../conexion.php");
    include ("../funciones.php");

    $t=$_POST["ticket"];

    $ResTicket=mysqli_query($conn, "SELECT * FROM tickets WHERE Consecutivo='".$t."' LIMIT 1");
	$RResTicket=mysqli_fetch_array($ResTicket);
	
	$ResCuenta=mysqli_query($conn, "SELECT Empresa FROM cuentas WHERE Consecutivo='".$RResTicket["Cuenta"]."' LIMIT 1");
	$RResCuenta=mysqli_fetch_array($ResCuenta);
	
	$ResSuc=mysqli_query($conn, "SELECT Nombre FROM sucursales WHERE Consecutivo='".$RResTicket["Sucursal"]."' LIMIT 1");
	$RResSuc=mysqli_fetch_array($ResSuc);
	
	$ResEquipo=mysqli_query($conn, "SELECT Equipo FROM equipos WHERE Consecutivo='".$RResTicket["Equipo"]."' LIMIT 1");
	$RResEquipo=mysqli_fetch_array($ResEquipo);
	
	$ResMarca=mysqli_query($conn, "SELECT Nombre FROM marcas WHERE Consecutivo='".$RResTicket["Marca"]."' LIMIT 1");
	$RResMarca=mysqli_fetch_array($ResMarca);
	
	$ResTecnico=mysqli_query($conn, "SELECT Nombre FROM usuarios WHERE Consecutivo='".$RResTicket["Tecnico"]."' LIMIT 1");
	$RResTecnico=mysqli_fetch_array($ResTecnico);
	
		
	$cadena='<form name="atendiendot" id="atendiendot">
				<div class="tabla">
					<div class="c100 c_derecha" style="background: #ffffff;">
						<a href="Tickets/ticket.php?consecutivo='.$RResTicket["Consecutivo"].'" target="_blank"><i class="fas fa-print" style="font-size: 25px"></i></a>
					</div>
					<div class="titprin">
						Detalles del Ticket Num. '.$RResTicket["ConsecutivoInterno"].'
					</div>

					<div class="c20 c_derecha">
						Tipo de Servicio:
                	</div>
                	<div class="c20 c_izquierda">
						'.$RResTicket["Servicio"].'
                	</div>
					<div class="c20 c_derecha">
						Referencia:
                	</div>
                	<div class="c20 c_izquierda">
					'.$RResTicket["ConsecutivoCuenta"].'
                	</div>
					<div class="c20 c_derecha">
						'.fecha($RResTicket["Fecha"]).'
					</div>
					
					<div class="c50 c_izquierda">
						'.utf8_encode($RResCuenta["Empresa"]).'
					</div>
					<div class="c20 c_derecha">
						Suc.:
					</div>
					<div class="c30 c_izquierda">
						'.utf8_encode($RResSuc["Nombre"]).'
					</div>

					<div class="c20 c_derecha">
						Tecnico Responsable:
					</div>
					<div class="c80 c_izquierda">
						';if($RResTicket["Tecnico"]==0){$cadena.='No Asignado';}else{$cadena.=utf8_encode($RResTecnico["Nombre"]);}$cadena.='
					</div>

					<div class="c20 c_derecha">
						Usuario responsable: 
					</div>
					<div class="c80 c_izquierda">
						'.utf8_encode($RResTicket["UsuarioResp"]).'
					</div>

					<div class="c20 c_derecha">
						Dirección: 
					</div>
					<div class="c80 c_izquierda">
						'.utf8_encode($RResTicket["Direccion"]).' Piso: '.utf8_encode($RResTicket["Piso"]).'
					</div>

					<div class="c20 c_derecha">
						Telefono:
					</div>
					<div class="c30 c_izquierda">
						'.utf8_encode($RResTicket["Telefono"]).' Ext.: '.utf8_encode($RResTicket["Ext"]).'
					</div>
					<div class="c20 c_derecha">
						Correo: 
					</div>
					<div class="c30 c_izquierda">
						'.utf8_encode($RResTicket["Email"]).'
					</div>

					<div class="c20 c_derecha">
						Area:
					</div>
					<div class="c30 c_izquierda">
						'.utf8_encode($RResTicket["Area"]).'
					</div>
					<div class="c20 c_derecha">
						Dependencia 
					</div>
					<div class="c30 c_izquierda">
						'.utf8_encode($RResTicket["Dependencia"]).'
					</div>

					<div class="c20 c_derecha">
						Equipo:
					</div>
					<div class="c30 c_izquierda">
						'.utf8_encode($RResEquipo["Equipo"]).'
					</div>
					<div class="c20 c_derecha">
						Marca:
					</div>
					<div class="c30 c_izquierda">
						'.utf8_encode($RResMarca["Nombre"]).'
					</div>
					
					<div class="c20 c_derecha">
						Modelo:
					</div>
					<div class="c30 c_izquierda">
						'.utf8_encode($RResTicket["Modelo"]).'
					</div>
					<div class="c20 c_derecha">
						Num. Serie:
					</div>
					<div class="c30 c_izquierda">
						'.utf8_encode($RResTicket["NumSerie"]).'
					</div>

					<div class="c20 c_derecha">
						Num. Inventario:
					</div>
					<div class="c80 c_izquierda">
						'.utf8_encode($RResTicket["NumInventario"]).'
					</div>

					<div class="c20 c_derecha">
						Observaciones:
					</div>
					<div class="c80 c_izquierda">
						'.utf8_encode($RResTicket["Observaciones"]).'
					</div>
					
					<div class="c20 c_derecha">
						Falla:
					</div>
					<div class="c80 c_izquierda">
						'.utf8_encode($RResTicket["Falla"]).'
					</div>

					<div class="c20 c_derecha">
						Diagnostico Tecnico:
					</div>
					<div class="c80 c_izquierda">';
					if (($_SESSION["perfil"]=='tecnico' AND $RResTicket["Status"]=='Atendiendo') OR $_SESSION["perfil"]=='admin')
					{
						$cadena.='<textarea name="diagnostico" id="diagnostico" class="input">'.$RResTicket["Diagnostico"].'</textarea>';
					}
					else 
					{
						$cadena.=$RResTicket["Diagnostico"];
					}
	$cadena.='		</div>
					
					<div class="c20 c_derecha">
						Diagnostico Tecnico:
					</div>
					<div class="c80 c_izquierda">';
					if (($_SESSION["perfil"]=='tecnico' AND $RResTicket["Status"]=='Atendiendo') OR $_SESSION["perfil"]=='admin')
					{
						$cadena.='<textarea name="diagnostico" id="diagnostico" class="input">'.$RResTicket["Diagnostico"].'</textarea>';
					}
					else 
					{
						$cadena.=$RResTicket["Diagnostico"];
					}
	$cadena.='		</div>
					
					<div class="c100 c_izquierda">
						Solución:
					</div>';
	$ResSol=mysqli_query($conn, "SELECT * FROM solucionticket WHERE Ticket='".$RResTicket["Consecutivo"]."' AND Solucion!='' ORDER BY Fecha ASC");
	while($RResSol=mysqli_fetch_array($ResSol))
	{
		$cadena.='	<div class="c20 c_derecha">
						'.fecha($RResSol["Fecha"]).' - '.$RResSol["Hora"].'
					</div>
					<div class="c80 c_izquierda">';
		if($_SESSION["perfil"])
		{
			$cadena.='<textarea name="solucion_'.$RResSol["Consecutivo"].'" id="solucion_'.$RResSol["Consecutivo"].'" class="input">'.utf8_encode($RResSol["Solucion"]).'</textarea>';
		}
		else
		{
			$cadena.=utf8_encode($RResSol["Solucion"]);
		}
		$cadena.='	</div>';
	}

	if (($_SESSION["perfil"]=='tecnico' AND $RResTicket["Status"]=='Atendiendo') OR $_SESSION["perfil"]=='admin')
	{
		$cadena.='	<div class="c20 c_derecha"></div>
					<div class="c80 c_izquierda">	
						<textarea name="solucion" id="solucion" class="input"></textarea>
					</div>

					<div class="c20 c_derecha">
						Fecha y Hora de Respuesta:
					</div>
					<div class="c20 c_izquierda">
						<select name="dia" id="dia" class="input">';
						for($i=1;$i<=31;$i++)
						{
							if($i<=9){$i='0'.$i;}
							$cadena.='<option value="'.$i.'"'; if($i==date("d")){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
						}
						$cadena.='</select>
					</div>
					<div class="c20 c_izquierda">
						<select name="mes" id="mes" class="input">
							<option value="01"'; if(date("m")=='01'){$cadena.=' selected';}$cadena.='>Enero</option>
							<option value="02"'; if(date("m")=='02'){$cadena.=' selected';}$cadena.='>Febrero</option>
							<option value="03"'; if(date("m")=='03'){$cadena.=' selected';}$cadena.='>Marzo</option>
							<option value="04"'; if(date("m")=='04'){$cadena.=' selected';}$cadena.='>Abril</option>
							<option value="05"'; if(date("m")=='05'){$cadena.=' selected';}$cadena.='>Mayo</option>
							<option value="06"'; if(date("m")=='06'){$cadena.=' selected';}$cadena.='>Junio</option>
							<option value="07"'; if(date("m")=='07'){$cadena.=' selected';}$cadena.='>Julio</option>
							<option value="08"'; if(date("m")=='08'){$cadena.=' selected';}$cadena.='>Agosto</option>
							<option value="09"'; if(date("m")=='09'){$cadena.=' selected';}$cadena.='>Septiembre</option>
							<option value="10"'; if(date("m")=='10'){$cadena.=' selected';}$cadena.='>Octubre</option>
							<option value="11"'; if(date("m")=='11'){$cadena.=' selected';}$cadena.='>Noviembre</option>
							<option value="12"'; if(date("m")=='12'){$cadena.=' selected';}$cadena.='>Diciembre</option>
						</select>
					</div>
					<div class="c20 c_izquierda">
						<select name="anno" id="anno" class="input">';
						for($j=2010; $j<=date("Y"); $j++)
						{
							$cadena.='<option value="'.$j.'"'; if(date("Y")==$j){$cadena.=' selected';}$cadena.='>'.$j.'</option>';
						}
						$cadena.='</select> 
					</div>
					<div class="c10 c_izquierda">
						<input type="text" name="hora" id="hora" class="input" value="'.date("H").'" style="text-align:right">
					</div>
					<div class="c10 c_izquierda">
						<input type="text" name="min" id="min" class="input" value="'.date("i").'">
					</div>';
	}

	$cadena.='		<div class="c100 c_izquierda">
						Refacciones Utilizadas:
					</div>';
					
	
	if(($_SESSION["perfil"]=='tecnico' AND $RResTicket["Status"]=='Atendiendo') OR $_SESSION["perfil"]=='admin')
	{
		$cadena.='	<div class="c20 c_izquierda">
						<select name="refaccion1" id="refaccion1" class="input">
							<option value="0">Sin Refacciones</option>';
		$ResRefaccion=mysqli_query($conn, "SELECT Consecutivo, Nombre FROM refacciones ORDER BY Nombre ASC");
		while ($RResRefaccion=mysqli_fetch_array($ResRefaccion))
		{
			$cadena.='		<option value="'.$RResRefaccion["Consecutivo"].'">'.utf8_encode($RResRefaccion["Nombre"]).'</option>';
		}
		$cadena.='		</select>
					</div>
					<div class="c10 c_derecha">
						<input type="number" name="cantidad1" id="cantidad1" class="input">
					</div>
					<div class="c20 c_izquierda">
						<select name="refaccion2" id="refaccion2" class="input">
							<option value="0">Sin Refacciones</option>';
		$ResRefaccion=mysqli_query($conn, "SELECT Consecutivo, Nombre FROM refacciones ORDER BY Nombre ASC");
		while ($RResRefaccion=mysqli_fetch_array($ResRefaccion))
		{
			$cadena.='		<option value="'.$RResRefaccion["Consecutivo"].'">'.utf8_encode($RResRefaccion["Nombre"]).'</option>';
		}
		$cadena.='		</select>
					</div>
					<div class="c10 c_derecha">
						<input type="number" name="cantidad2" id="cantidad2" class="input">
					</div>
					<div class="c20 c_izquierda">
						<select name="refaccion3" id="refaccion3" class="input">
							<option value="0">Sin Refacciones</option>';
		$ResRefaccion=mysqli_query($conn, "SELECT Consecutivo, Nombre FROM refacciones ORDER BY Nombre ASC");
		while ($RResRefaccion=mysqli_fetch_array($ResRefaccion))
		{
			$cadena.='		<option value="'.$RResRefaccion["Consecutivo"].'">'.utf8_encode($RResRefaccion["Nombre"]).'</option>';
		}
		$cadena.='		</select>
					</div>
					<div class="c10 c_derecha">
						<input type="number" name="cantidad3" id="cantidad3" class="input">
					</div>
					<div class="c10 c_derecha"></div>

					<div class="c20 c_derecha">
						Descripcion Refacciones Utilizadas:
					</div>
					<div class="c80 c_izquierda">
						<textarea name="descrefac" id="descrefac" cols="100" rows="3" class="input"></textarea>
					</div>';
	}
	else
	{
		$ResRefac=mysqli_query($conn, "SELECT * FROM refacticket WHERE Ticket='".$RResTicket["Consecutivo"]."' AND Refaccion1!='0' ORDER BY Consecutivo ASC");
		$RResRefac=mysqli_fetch_array($ResRefac);
		
		$RResRefac1=mysqli_fetch_array(mysqli_query($conn, "SELECT Nombre FROM refacciones WHERE Consecutivo='".$RResRefac["Refaccion1"]."' LIMIT 1"));
		$RResRefac2=mysqli_fetch_array(mysqli_query($conn, "SELECT Nombre FROM refacciones WHERE Consecutivo='".$RResRefac["Refaccion2"]."' LIMIT 1"));
		$RResRefac3=mysqli_fetch_array(mysqli_query($conn, "SELECT Nombre FROM refacciones WHERE Consecutivo='".$RResRefac["Refaccion3"]."' LIMIT 1"));
		
		$cadena.='	<div class="c20 c_izquierda">
						'.utf8_encode($RResRefac1["Nombre"]).'
					</div>
					<div class="c10 c_derecha">
						'.$RResRefac["Cantidad1"].'
					</div>
					<div class="c20 c_izquierda">
						'.utf8_encode($RResRefac2["Nombre"]).'
					</div>
					<div class="c10 c_derecha">
						'.$RResRefac["Cantidad2"].'
					</div>
					<div class="c20 c_izquierda">
						'.utf8_encode($RResRefac3["Nombre"]).'
					</div>
					<div class="c10 c_derecha">
						'.$RResRefac["Cantidad3"].'
					</div>
					<div class="c10 c_derecha"></div>

					<div class="c20 c_derecha">
						Descripcion Refacciones Utilizadas:
					</div>
					<div class="c80 c_izquierda">
						'.utf8_encode($RResRefac["DescRefac"]).'
					</div>';
	}				
	
	$cadena.='		<div class="c20 c_derecha">
						Observaciones Tecnicas:
					</div>
					<div class="c80 c_izquierda">';
					if(($_SESSION["perfil"]=='tecnico' AND $RResTicket["Status"]=='Atendiendo') OR $_SESSION["perfil"]=='admin')
					{
						$cadena.='<textarea name="observaciones" id="observaciones" class="input">'.utf8_encode($RResTicket["ObsTecnicas"]).'</textarea>';
					}
					else
					{
						$cadena.=utf8_encode($RResTicket["ObsTecnicas"]);
					}
	$cadena.='		</div>

					<div class="c100 c_izquierda">
						Satisfaccion del Usuario:
					</div>

					<div class="c20 ccenter">
						<input type="radio" name="satisfaccion" id="satisfaccion" value="Excelente"'; if($RResTicket["Satisfaccion"]=='Excelente'){$cadena.=' checked';}$cadena.='> Excelente 
					</div>
					<div class="c20 ccenter">
						<input type="radio" name="satisfaccion" id="satisfaccion" value="Bueno"'; if($RResTicket["Satisfaccion"]=='Bueno'){$cadena.=' checked';}$cadena.='> Bueno
					</div>
					<div class="c20 ccenter">
						<input type="radio" name="satisfaccion" id="satisfaccion" value="Normal"'; if($RResTicket["Satisfaccion"]=='Normal'){$cadena.=' checked';}$cadena.='> Normal 
					</div>
					<div class="c20 ccenter">
						<input type="radio" name="satisfaccion" id="satisfaccion" value="Malo"'; if($RResTicket["Satisfaccion"]=='Malo'){$cadena.=' checked';}$cadena.='> Malo 
					</div>
					<div class="c20 ccenter">
						<input type="radio" name="satisfaccion" id="satisfaccion" value="Pesimo"'; if($RResTicket["Satisfaccion"]=='Pesimo'){$cadena.=' checked';}$cadena.='> Pesimo 
					</div>';
	if(($_SESSION["perfil"]=='tecnico' AND $RResTicket["Status"]=='Atendiendo') OR $_SESSION["perfil"]=='admin')
	{
		$cadena.='	<div class="c50 ccenter">
						<select name="hacer" id="hacer">
							<option value="guardar">Guardar Ticket</option>
							<option value="finalizar">Finalizar Ticket</option>
						</select>
					</div>
					<div class="c50 ccenter">
						<input type="hidden" name="consecutivo" id="consecutivo" value="'.$RResTicket["Consecutivo"].'">
						<input type="submit" name="botsaveticket" id="botsaveticket" value="Enviar>>">
					</div>';
	}
	$cadena.='		</div>

				
				</div>
			</form>';

    echo $cadena;
    
?>
<script>
$("#atendiendot").on("submit", function(e){
	e.preventDefault();
	var formData = new FormData(document.getElementById("atendiendot"));

	$.ajax({
		url: "Tickets/status_ticket.php",
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