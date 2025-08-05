<?php
function nuevo_ticket($sucursal=NULL)
{
	include ("conexion.php");
	
	$ResNTicket=mysql_query("SELECT ConsecutivoInterno, ConsecutivoCuenta FROM cuentas WHERE Consecutivo='".$_SESSION["cuenta"]."' LIMIT 1");
	$RResNTicket=mysql_fetch_array($ResNTicket);
	
	if($sucursal!=NULL)
	{
		$ResSuc=mysql_fetch_array(mysql_query("SELECT * FROM sucursales WHERE Consecutivo='".$sucursal."' LIMIT 1"));
	}
	
	$cadena='<form name="fadticket" id="fadticket">
				<input type="hidden" name="tickinterno" id="tickinterno" value="'.$RResNTicket["ConsecutivoInterno"].'">
				<table border="0" cellpadding="5" align="center">
					<tr>
						<th colspan="6" align="center" class="textotitable">Ticket de Reporte</th>
					</tr>
					<tr>
						<td colspan="2" class="texto" align="left">Sucursal: </td>
						<td colspan="4" class="texto" align="left"><select name="sucursal" id="sucursal" class="input" onchange="xajax_nuevo_ticket(this.value)"><option>Seleccione</option>';
	$ResSucursal=mysql_query("SELECT Consecutivo, Nombre FROM sucursales WHERE Cuenta='".$_SESSION["cuenta"]."' ORDER BY Consecutivo ASC");
	while ($RResSucursal=mysql_fetch_array($ResSucursal))
	{
		$cadena.='<option value="'.$RResSucursal["Consecutivo"].'"'; if($sucursal==$RResSucursal["Consecutivo"]){$cadena.=' selected';}$cadena.='>'.$RResSucursal["Nombre"].'</option>';
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
	 $ResEquipo=mysql_query("SELECT Consecutivo, Equipo FROM equipos ORDER BY Equipo ASC");
	 while($RResEquipo=mysql_fetch_array($ResEquipo))
	 {
	 	$cadena.='<option value="'.$RResEquipo["Consecutivo"].'">'.utf8_encode($RResEquipo["Equipo"]).'</option>';
	 }
		$cadena.=' 			</select></td>
						<td class="texto" align="left">Marca:</td>
						<td colspan="2" class="texto" align="left"><select name="marca" id="marca" class="input"><option>Seleccione</potion>';
		$ResMarca=mysql_query("SELECT Consecutivo, Nombre FROM marcas ORDER BY Nombre ASC");
		while($RResMarca=mysql_fetch_array($ResMarca))
		{
			$cadena.='<option value="'.$RResMarca["Consecutivo"].'">'.utf8_encode($RResMarca["Nombre"]).'</option>';
		}
		$cadena.=' 	 		</select></td>
					</tr>
					<tr>
						<td class="texto" align="left">Modelo:</td>
						<td class="texto" align="left"><input type="text" name="modelo" id="modelo" class="input" size="50" onKeyUp="modelos.style.visibility=\'visible\'; xajax_modelos_ticket(document.getElementById(\'sucursal\').value, document.getElementById(\'equipo\').value, document.getElementById(\'marca\').value, this.value);">
							<div id="modelos" style="position: absolute; width: 350px; z-index:5; background-color:#CCCCCC; text-align: left; visibility:hidden; top: 270px; height:200px;"></div></td>
						<td class="texto" align="left">No. de Serie:</td>
						<td class="texto" align="left"><input type="text" name="nserie" id="nserie" class="input" size="50"></td>
						<td class="texto" align="left">No. de Inventario:</td>
						<td class="texto" align="left"><input type="text" name="ninventario" id="ninventario" class="input" size="50"></td>
					</tr>
					<tr>
						<td colspan="2" class="texto" align="left">Detalle Tecnico:</td>
						<td colspan="4" class="texto" align="left"><textarea name="dettecnico" id="dettecnico" class="input" cols="50" rows="5"></textarea></td>
					</tr>
							</th>
						</tr>
						<tr>
							<th colspan="2" class="texto" bgcolor="#a19aaa" align="left">
								<p><strong>Observaciones:</strong><br />
								<textarea name="observaciones" id="observaciones" class="input" cols="50" rows="5"></textarea>
							</th>
							<th colspan="2" class="texto" bgcolor="#a19aaa" align="left">
								<p><strong>Detalles de la Falla:</strong><br />
								<textarea name="detfalla" id="detfalla" class="input" cols="50" rows="5"></textarea>
							</th>
						</tr>
						<tr>
							<th colspan="2" class="texto" bgcolor="#a19aaa" align="left">
								<p><strong>Tipo de Servicio:</strong><br />
								<input type="radio" name="tservicio" value="correctivo" checked>&nbsp;Correctivo&nbsp; 
								<input type="radio" name="tservicio" value="preventivo">&nbsp;Preventivo
							</th>
							<th colspan="2" class="texto" bgcolor="#a19aaa" align="center">
								<p><input type="reset" name="botreset" value="Limpiar Campos" class="boton">&nbsp;
								<input type="button" name="botsendrepor" value="Enviar Reporte" class="boton" onclick="xajax_nuevo_ticket_2(xajax.getFormValues(\'fadticket\'))"></p>
							</th>
						</tr>
					 </table></form>';
	
	 $respuesta = new xajaxResponse(); 
   $respuesta->addAssign("contenido","innerHTML",$cadena);
   return $respuesta;
}
function nuevo_ticket_2($ticket)
{
	include ("conexion.php");
	
	$cadena='<table border="1" bordercolor="#cecee2" cellpadding="5" cellspacing="0" width="90%" align="center">
						<tr height="21">
							<th colspan="4" align="center" bgcolor="#5263ab" class="texto3"><strong>Ticket de Reporte</strong></th>
						</tr>
						<tr>
							<td class="texto" bgcolor="#a19aaa">';
	if(mysql_query("INSERT INTO tickets (ConsecutivoInterno, ConsecutivoCuenta, Cuenta, UsuarioResp, Direccion, Piso, Telefono, Ext, Email, Sucursal, Dependencia, Area, Equipo, Marca, Modelo, NumSerie, NumInventario, Observaciones, DetTecnicos, Falla, Servicio, Fecha)
															 VALUES ('".$ticket["tickinterno"]."', '".$ticket["tickcuenta"]."', '".$_SESSION["cuenta"]."', '".utf8_decode($ticket["nusuario"])."', '".utf8_decode($ticket["direccion"])."', '".utf8_decode($ticket["piso"])."', '".utf8_decode($ticket["telefono"])."', 
															 				 '".utf8_decode($ticket["ext"])."', '".utf8_decode($ticket["email"])."', '".$ticket["sucursal"]."', '".utf8_decode($ticket["dependencia"])."', '".utf8_decode($ticket["area"])."', 
															 				 '".$ticket["equipo"]."', '".$ticket["marca"]."', '".utf8_decode($ticket["modelo"])."', '".utf8_decode($ticket["nserie"])."', '".utf8_decode($ticket["ninventario"])."', 
															 				 '".utf8_decode($ticket["observaciones"])."', '".utf8_decode($ticket["dettecnico"])."', '".utf8_decode($ticket["detfalla"])."', '".$ticket["tservicio"]."', '".date("Y-m-d")."')") AND
		mysql_query("UPDATE cuentas SET ConsecutivoInterno=ConsecutivoInterno + 1, ConsecutivoCuenta=ConsecutivoCuenta + 1 WHERE Consecutivo='".$_SESSION["cuenta"]."'"))
	{
		$ResTicket=mysql_query("SELECT Consecutivo FROM tickets ORDER BY Consecutivo DESC LIMIT 1");
		$RResTicket=mysql_fetch_array($ResTicket);
		
		//envia mail al usuario
		$cuerpo='Su ticket ha sido recibido con el numero '.$RResTicket["Consecutivo"].'-'.$ticket["tickinterno"].', en breve obtendra respuesta nuestra.';
		$headers= "From: GPT Tecnologia <administracion@gpt.com>\r\n"; 
		mail($ticket["email"],"Ticket Recibido",$cuerpo, $headers);
		
		$cadena.='<p>Se ha generado el ticket numero '.$RResTicket["Consecutivo"].'-'.$ticket["tickinterno"];
	}
	else 
	{
		$cadena.=mysql_error();
	}
	
	$cadena.='</td></tr></table>';
	
	 $respuesta = new xajaxResponse(); 
   $respuesta->addAssign("contenido","innerHTML",$cadena);
   return $respuesta;
}
function status_tickets()
{
	include ("conexion.php");
	
	$cadena='<table border="1" bordercolor="#cecee2" cellpadding="5" cellspacing="0" width="90%" align="center">
						<tr height="21">
							<th colspan="3" align="center" bgcolor="#5263ab" class="texto3"><strong>Status Tickets</strong></th>
						</tr>
						<tr>';
	if($_SESSION["cuenta"]==0)
	{
		$ResTicketsP=mysql_query("SELECT Consecutivo FROM tickets WHERE Status='Pendiente'");
		$ResTicketsA=mysql_query("SELECT Consecutivo FROM tickets WHERE Status='Atendiendo'");
		$ResTicketsF=mysql_query("SELECT Consecutivo FROM tickets WHERE Status='Finalizado'");
	}
	elseif ($_SESSION["perfil"]=='tecnico')
	{
		$ResTicketsP=mysql_query("SELECT Consecutivo FROM tickets WHERE Status='Pendiente' AND Tecnico='".$_SESSION["consecutivo"]."'");
		$ResTicketsA=mysql_query("SELECT Consecutivo FROM tickets WHERE Status='Atendiendo' AND Tecnico='".$_SESSION["consecutivo"]."'");
		$ResTicketsF=mysql_query("SELECT Consecutivo FROM tickets WHERE Status='Finalizado' AND Tecnico='".$_SESSION["consecutivo"]."'");
	}
	else
	{
		$ResTicketsP=mysql_query("SELECT Consecutivo FROM tickets WHERE Status='Pendiente' AND Cuenta='".$_SESSION["cuenta"]."'");
		$ResTicketsA=mysql_query("SELECT Consecutivo FROM tickets WHERE Status='Atendiendo' AND Cuenta='".$_SESSION["cuenta"]."'");
		$ResTicketsF=mysql_query("SELECT Consecutivo FROM tickets WHERE Status='Finalizado' AND Cuenta='".$_SESSION["cuenta"]."'");
	}
	
	$cadena.='<td class="texto" bgcolor="#a19aaa"><a href="#" onclick="xajax_lista_ticket(\'Pendiente\')"><img src="images/bolitaroja.gif" border="0"><strong> '.mysql_num_rows($ResTicketsP).' Tickets Pendientes</strong></a></td>
	          <td class="texto" bgcolor="#a19aaa"><a href="#" onclick="xajax_lista_ticket(\'Atendiendo\')"><img src="images/bolitamarilla.gif" border="0"><strong> '.mysql_num_rows($ResTicketsA).' Tickets Atendiendo</strong></a></td>
	          <td class="texto" bgcolor="#a19aaa"><a href="#" onclick="xajax_lista_ticket(\'Finalizado\')"><img src="images/bolitaverde.gif" border="0"><strong> '.mysql_num_rows($ResTicketsF).' Tickets Finalizados</strong></a></td>
						</td>
						</tr>
						<tr>
							<th colspan="3" class="texto" bgcolor="#FFFFFF">
							<div id="ticks">
							</div>
							</th>
						</tr>
						</table>';
	
	 $respuesta = new xajaxResponse(); 
   $respuesta->addAssign("contenido","innerHTML",$cadena);
   return $respuesta;
}
function lista_ticket($ticket)
{
	include ("conexion.php");
	
	if($_SESSION["cuenta"]==0){$cuenta='%';}else{$cuenta=$_SESSION["cuenta"];}
	if($_SESSION["sucursal"]==0){$suc='%';}else{$suc=$_SESSION["sucursal"];}
	if($_SESSION["perfil"]=='tecnico'){$tec=$_SESSION["consecutivo"];}else{$tec='%';}
	
	$ResTickets=mysql_query("SELECT * FROM tickets WHERE Status='".$ticket."' AND Cuenta LIKE '".$cuenta."' AND Sucursal LIKE '".$suc."' AND Tecnico LIKE '".$tec."' ORDER BY Fecha ASC");
	
	$cadena.='<table border="1" bordercolor="#FFFFFF" cellpadding="5" cellspacing="0" width="98%">
							<tr>
								<td align="center" class="textotitulo2" bgcolor="#FF7F24">Num.</td>
								<td align="center" class="textotitulo2" bgcolor="#FF7F24">Fecha</td>
								<td align="center" class="textotitulo2" bgcolor="#FF7F24">Cuenta</td>
								<td align="center" class="textotitulo2" bgcolor="#FF7F24">Sucursal</td>
								<td align="center" class="textotitulo2" bgcolor="#FF7F24">Area</td>
								<td align="center" class="textotitulo2" bgcolor="#FF7F24"></td>';
	$cadena.='	</tr>';
	if($ticket=='Pendiente'){$clase="textoRojo";}
	else if($ticket=='Atendiendo'){$clase='textoAmarillo';}
	else if($ticket=='Finalizado'){$clase='textoVerde';}
	$bgcolor="#F0FFF0";
	while ($RResTickets=mysql_fetch_array($ResTickets))
	{
		$ResCuenta=mysql_query("SELECT Empresa FROM cuentas WHERE Consecutivo='".$RResTickets["Cuenta"]."' LIMIT 1");
		$RResCuenta=mysql_fetch_array($ResCuenta);
		
		$ResSuc=mysql_query("SELECT Nombre FROM sucursales WHERE Consecutivo='".$RResTickets["Sucursal"]."' LIMIT 1");
		$RResSuc=mysql_fetch_array($ResSuc);
		
		$cadena.='<tr>
								<td align="center" class="'.$clase.'" bgcolor="'.$bgcolor.'"><a href="#" onclick="xajax_detalle_ticket(\''.$RResTickets["Consecutivo"].'\')">'.$RResTickets["ConsecutivoInterno"].'</a></td>
								<td align="center" class="'.$clase.'" bgcolor="'.$bgcolor.'"><a href="#" onclick="xajax_detalle_ticket(\''.$RResTickets["Consecutivo"].'\')">'.fecha($RResTickets["Fecha"]).'</a></td>
								<td align="left" class="'.$clase.'" bgcolor="'.$bgcolor.'"><a href="#" onclick="xajax_detalle_ticket(\''.$RResTickets["Consecutivo"].'\')">'.utf8_encode($RResCuenta["Empresa"]).'</a></td>
								<td align="left" class="'.$clase.'" bgcolor="'.$bgcolor.'"><a href="#" onclick="xajax_detalle_ticket(\''.$RResTickets["Consecutivo"].'\')">'.utf8_encode($RResSuc["Nombre"]).'</a></td>
								<td align="left" class="'.$clase.'" bgcolor="'.$bgcolor.'"><a href="#" onclick="xajax_detalle_ticket(\''.$RResTickets["Consecutivo"].'\')">'.utf8_encode($RResTickets["Area"]).'</a></td>
								<td align="center" class="'.$clase.'" bgcolor="'.$bgcolor.'">';
		if($_SESSION["perfil"]=='admin' or $_SESSION["perfil"]=='admincuenta'){$cadena.='&nbsp;<a href="#" onclick="xajax_asigna_tecnico(\''.$RResTickets["Consecutivo"].'\')"><img src="images/user.gif" alt="Asignar Usuario" border="0"></a>';}
		$cadena.='</td></tr>';
		if ($bgcolor=="#F0FFF0"){$bgcolor="#CCCCCC";}
		else if ($bgcolor=="#CCCCCC"){$bgcolor="#F0FFF0";}
	}
	$cadena.='</table>';
	
	 $respuesta = new xajaxResponse(); 
   $respuesta->addAssign("ticks","innerHTML",$cadena);
   return $respuesta;
}
function asigna_tecnico($ticket)
{
	include ("conexion.php");
	
	$ResTicket=mysql_query("SELECT * FROM tickets WHERE Consecutivo='".$ticket."' LIMIT 1");
	$RResTicket=mysql_fetch_array($ResTicket);
	
	$ResEquipo=mysql_query("SELECT Equipo FROM equipos WHERE Consecutivo='".$RResTicket["Equipo"]."' LIMIT 1");
	$RResEquipo=mysql_fetch_array($ResEquipo);
	
	$ResMarca=mysql_query("SELECT Nombre FROM marcas WHERE Consecutivo='".$RResTicket["Marca"]."' LIMIT 1");
	$RResMarca=mysql_fetch_array($ResMarca);
	
	$cadena='<form name="asignatecnico" id="asignatecnico"><table border="1" bordercolor="#FFFFFF" cellpadding="5" cellspacing="0" width="98%">
						<tr>
							<th colspan="7" bgcolor="#FF7F24" class="textotitulo2" align="center">Asignar Tecnico</th>
						</tr>
						<tr>
							<td bgcolor="#FF7F24" class="textotitulo2" align="center">Num. Ticket</td>
							<td bgcolor="#FF7F24" class="textotitulo2" align="center">Equipo</td>
							<td bgcolor="#FF7F24" class="textotitulo2" align="center">Marca</td>
							<td bgcolor="#FF7F24" class="textotitulo2" align="center">Modelo</td>
							<td bgcolor="#FF7F24" class="textotitulo2" align="center">Falla</td>
							<td bgcolor="#FF7F24" class="textotitulo2" align="center">Tecnico</td>
							<td bgcolor="#FF7F24" class="textotitulo2" align="center">&nbsp;</td>
						</tr>
						<tr>
							<td bgcolor="#F0FFF0" class="texto" align="center" valign="top">'.$RResTicket["Consecutivo"].'</td>
							<td bgcolor="#F0FFF0" class="texto" align="center" valign="top">'.utf8_encode($RResEquipo["Equipo"]).'</td>
							<td bgcolor="#F0FFF0" class="texto" align="center" valign="top">'.utf8_encode($RResMarca["Nombre"]).'</td>
							<td bgcolor="#F0FFF0" class="texto" align="center" valign="top">'.utf8_encode($RResTicket["Modelo"]).'</td>
							<td bgcolor="#F0FFF0" class="texto" align="left" valign="top">'.utf8_encode($RResTicket["Falla"]).'</td>
							<td bgcolor="#F0FFF0" class="texto" align="center" valign="top"><select name="tecnico" id="tecnico" class="input">';
	$ResTecnicos=mysql_query("SELECT Consecutivo, Nombre FROM usuarios WHERE Perfil='Tecnico' ORDER BY Nombre ASC");
	while($RResTecnicos=mysql_fetch_array($ResTecnicos))
	{
	  $cadena.='<option value="'.$RResTecnicos["Consecutivo"].'">'.utf8_encode($RResTecnicos["Nombre"]).'</option>';
	}
	$cadena.='				</select></td>
							<td bgcolor="#F0FFF0" class="texto" align="center">
								<input type="hidden" name="nticket" value="'.$ticket.'">
								<input type="button" name="botasigticket" value="Asignar>>" class="boton" onclick="xajax_asigna_tecnico_2(xajax.getFormValues(\'asignatecnico\'))">
							</td>
						</tr>';
	$cadena.='</table></form>';
	
	 $respuesta = new xajaxResponse(); 
   $respuesta->addAssign("ticks","innerHTML",$cadena);
   return $respuesta;
	
}
function asigna_tecnico_2($ticketatecnico)
{
	include ("conexion.php");
	
	if(mysql_query("UPDATE tickets SET Tecnico='".$ticketatecnico["tecnico"]."', Status='Atendiendo' WHERE Consecutivo='".$ticketatecnico["nticket"]."'"))
	{
		$cadena='<p class="textomensaje">Se ah asignado tecnico</p>';
		//manda correo a tecnico
		//direccion del remitente 
		$headers= "From: GPT Tecnologia <administracion@gpt.com>\r\n"; 
		$cuerpo='Hay un servicio pendiente, ingresa a tu cuenta para atendelo';
		$ResCorreoTecnico=mysql_fetch_array(mysql_query("SELECT CorreoE FROM usuarios WHERE Consecutivo='".$ticketatecnico["tecnico"]."' LIMIT 1"));
		
		mail($ResCorreoTecnico["CorreoE"],"Servicio Pendiente...",$cuerpo, $headers);
	}
	else 
	{
		$cadena='<p class="textomensja">Ocurrio un problema, no se pudo asignar tecnico</p>';	
	}

	 $respuesta = new xajaxResponse(); 
   $respuesta->addAssign("ticks","innerHTML",$cadena);
   return $respuesta;
}
function detalle_ticket($t)
{
	include ("conexion.php");
	
	$ResTicket=mysql_query("SELECT * FROM tickets WHERE Consecutivo='".$t."' LIMIT 1");
	$RResTicket=mysql_fetch_array($ResTicket);
	
	$ResCuenta=mysql_query("SELECT Empresa FROM cuentas WHERE Consecutivo='".$RResTicket["Cuenta"]."' LIMIT 1");
	$RResCuenta=mysql_fetch_array($ResCuenta);
	
	$ResSuc=mysql_query("SELECT Nombre FROM sucursales WHERE Consecutivo='".$RResTicket["Sucursal"]."' LIMIT 1");
	$RResSuc=mysql_fetch_array($ResSuc);
	
	$ResEquipo=mysql_query("SELECT Equipo FROM equipos WHERE Consecutivo='".$RResTicket["Equipo"]."' LIMIT 1");
	$RResEquipo=mysql_fetch_array($ResEquipo);
	
	$ResMarca=mysql_query("SELECT Nombre FROM marcas WHERE Consecutivo='".$RResTicket["Marca"]."' LIMIT 1");
	$RResMarca=mysql_fetch_array($ResMarca);
	
	$ResTecnico=mysql_query("SELECT Nombre FROM usuarios WHERE Consecutivo='".$RResTicket["Tecnico"]."' LIMIT 1");
	$RResTecnico=mysql_fetch_array($ResTecnico);
	
		
	$cadena='<form name="atendiendot" id="atendiendot">
					 <table border="1" bordercolor="#5263ab" cellpadding="3" cellspacing="0" align="center">
						<tr>
							<th colspan="5" align="center" bgcolor="#5263ab" class="texto3">
								Detalles del Ticket Num. '.$RResTicket["ConsecutivoInterno"].'
							</th>
						</tr>
						<tr>
							<th colspan="2" align="left"" class="texto" bgcolor="#a19aaa"><span class="textorojo">Tipo de Servicio:</span> '.$RResTicket["Servicio"].'</th>
							<td colspan="2" align="left" class="texto" bgcolor="#a19aaa"><span class="textorojo">Referencia: </span>'.$RResTicket["ConsecutivoCuenta"].'</td>
							<th align="right" class="texto" bgcolor="#a19aaa"><strong>'.fecha($RResTicket["Fecha"]).'</strong></th>
						</tr>
						<tr>
							<th colspan="3" align="left" class="texto" bgcolor="#a19aaa">'.utf8_encode($RResCuenta["Empresa"]).'</th>
							<th colspan="2" align="left" class="texto" bgcolor="#a19aaa"><span class="textorojo">Suc.:</span> '.utf8_encode($RResSuc["Nombre"]).'</th>
						</tr>
						<tr>
							<td colspan="2" align="left" class="texto" bgcolor="#a19aaa"><span class="textorojo">Tecnico Responsable: </span></td>
							<td colspan="3" align="left" class="texto" bgcolor="#a19aaa">';if($RResTicket["Tecnico"]==0){$cadena.='No Asignado';}else{$cadena.=utf8_encode($RResTecnico["Nombre"]);}$cadena.='</td>
						</tr>
						<tr>
							<th colspan="5" align="left" class="texto" bgcolor="#a19aaa">
								<p><span class="textorojo">Usuario Responsable:</span>'.utf8_encode($RResTicket["UsuarioResp"]).'
								<br /><span class="textorojo">Direccion:</span> '.utf8_encode($RResTicket["Direccion"]).' <span class="textorojo">Piso:</span> '.utf8_encode($RResTicket["Piso"]).'
								<br /><span class="textorojo">Telefono:</span> '.utf8_encode($RResTicket["Telefono"]).' <span class="textorojo">Ext.:</span> '.utf8_encode($RResTicket["Ext"]).'
								<br /><span class="textorojo">E-mail:</span> '.utf8_encode($RResTicket["Email"]).'</p>
							</th>
						</tr>
						<tr>
							<th colspan="2" align="left" class="texto" bgcolor="#a19aaa"><span class="textorojo">Area:</span> '.utf8_encode($RResTicket["Area"]).'</th>
							<th colspan="3" align="left" class="texto" bgcolor="#a19aaa"><span class="textorojo">Dependencia:</span> '.utf8_encode($RResTicket["Dependencia"]).'</th>
						</tr>
						<tr>
							<td align="left" class="texto" bgcolor="#a19aaa"><span class="textorojo">Equipo:</span> '.utf8_encode($RResEquipo["Equipo"]).'</td>
							<td align="left" class="texto" bgcolor="#a19aaa"><span class="textorojo">Marca:</span> '.utf8_encode($RResMarca["Nombre"]).'</td>
							<td align="left" class="texto" bgcolor="#a19aaa"><span class="textorojo">Modelo:</span> '.utf8_encode($RResTicket["Modelo"]).'</td>
							<td align="left" class="texto" bgcolor="#a19aaa"><span class="textorojo">Num. Serie:</span> '.utf8_encode($RResTicket["NumSerie"]).'</td>
							<td align="left" class="texto" bgcolor="#a19aaa"><span class="textorojo">Num. Inventario:</span> '.utf8_encode($RResTicket["NumInventario"]).'</td>
						</tr>
						<tr>
							<th colspan="5" align="left" class="texto" bgcolor="#a19aaa""><span class="textorojo">Observaciones:</span> <br />'.utf8_encode($RResTicket["Observaciones"]).'</th>
						</tr>
						<tr>
							<th colspan="5" align="left" class="texto" bgcolor="#a19aaa"><span class="textorojo">Falla:</span> <br />'.utf8_encode($RResTicket["Falla"]).'</th>
						</tr>
						<tr>
							 <td colspan="5" align="left" class="texto" bgcolor="#a19aaa"><span class="textorojo">Diagnostico Tecnico: </span>';
	if (($_SESSION["perfil"]=='tecnico' AND $RResTicket["Status"]=='Atendiendo') OR $_SESSION["perfil"]=='admin')
	{
		$cadena.='<p class="texto4"><textarea name="diagnostico" id="diagnostico" cols="100" rows="5" class="input">'.$RResTicket["Diagnostico"].'</textarea>';
	}
	else 
	{
		$cadena.='<p class="texto4">'.$RResTicket["Diagnostico"].'</p>';
	}
	$cadena.='</td>	
							</tr>
						<tr>
							<th colspan="5" align="left" class="texto" bgcolor="#a19aaa"><span class="textorojo">Solucion:</span> ';
	$ResSol=mysql_query("SELECT * FROM solucionticket WHERE Ticket='".$RResTicket["Consecutivo"]."' AND Solucion!='' ORDER BY Fecha ASC");
	while($RResSol=mysql_fetch_array($ResSol))
	{
		$cadena.='<p class="texto4">'.fecha($RResSol["Fecha"]).' - '.$RResSol["Hora"].'<br />'.utf8_encode($RResSol["Solucion"]).'</p>';
	}
	if (($_SESSION["perfil"]=='tecnico' AND $RResTicket["Status"]=='Atendiendo') OR $_SESSION["perfil"]=='admin')
	{
		$cadena.='<p><textarea name="solucion" id="solucion" cols="100" rows="5" class="input"></textarea>
							<p><span class="textorojo">Fecha y Hora de Respuesta:</span> <select name="dia" id="dia" class="input">';
		for($i=1;$i<=31;$i++)
		{
			if($i<=9){$i='0'.$i;}
			$cadena.='<option value="'.$i.'"'; if($i==date("d")){$cadena.=' selected';}$cadena.='>'.$i.'</option>';
		}
		$cadena.='</select><select name="mes" id="mes" class="input">
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
							</select><select name="anno" id="anno" class="input">';
		for($j=2010; $j<=date("Y"); $j++)
		{
			$cadena.='<option value="'.$j.'"'; if(date("Y")==$j){$cadena.=' selected';}$cadena.='>'.$j.'</option>';
		}
		$cadena.='</select> <input type="text" name="hora" id="hora" class="input" size="3" value="'.date("H").'" style="text-align:right">:<input type="text" name="min" id="min" class="input" size="3" value="'.date("i").'">';
	}
	$cadena.='	</th>
						</tr>
						<tr>
							<th colspan="5" align="left" class="texto" bgcolor="#a19aaa"><span class="textorojo">Refacciones Utilizadas:</span>  
							<table border="0" cellpadding="5" cellspacing="0" width="100%" align="left">';
	$ResRefac=mysql_query("SELECT * FROM refacticket WHERE Ticket='".$RResTicket["Consecutivo"]."' AND Refaccion1!='0' ORDER BY Consecutivo ASC");
	$RResRefac=mysql_fetch_array($ResRefac);
	
		$ResRefac1=mysql_query("SELECT Nombre FROM refacciones WHERE Consecutivo='".$RResRefac["Refaccion1"]."' LIMIT 1");
		$RResRefac1=mysql_fetch_array($ResRefac1);
		
		$RResRefac2=mysql_fetch_array(mysql_query("SELECT Nombre FROM refacciones WHERE Consecutivo='".$RResRefac["Refaccion2"]."' LIMIT 1"));
		$RResRefac3=mysql_fetch_array(mysql_query("SELECT Nombre FROM refacciones WHERE Consecutivo='".$RResRefac["Refaccion3"]."' LIMIT 1"));
		
		$cadena.='<tr class="texto4">
								<td align="left" valign="top">'.$RResRefac["Cantidad1"].'</td>
								<td align="left" valign="top">'.utf8_encode($RResRefac1["Nombre"]).'</td>
							</tr>';
		if($RResRefac["Cantidad2"]!=0)
		{
			$cadena.='<tr class="texto4">
								<td align="left" valign="top">'.$RResRefac["Cantidad2"].'</td>
								<td align="left" valign="top">'.utf8_encode($RResRefac2["Nombre"]).'</td>
							</tr>';
		}
		if($RResRefac["Cantidad3"]!=0)
		{
			$cadena.='<tr class="texto4">
								<td align="left" valign="top">'.$RResRefac["Cantidad3"].'</td>
								<td align="left" valign="top">'.utf8_encode($RResRefac3["Nombre"]).'</td>
							</tr>';
		}
		$cadena.='<tr>
								<td colspan="2" aling="left" valign="top">'.utf8_encode($RResRefac["DescRefac"]).'</td>
							</tr>';
	
	$cadena.='</table><p>&nbsp;';
	if(($_SESSION["perfil"]=='tecnico' AND $RResTicket["Status"]=='Atendiendo') OR $_SESSION["perfil"]=='admin')
	{
		$cadena.='<p><span class="textorojo">Refacciones:</span><br /><select name="refaccion1" id="refaccion1" class="input"><option value="0">Sin Refacciones</option>';
		$ResRefaccion=mysql_query("SELECT Consecutivo, Nombre FROM refacciones ORDER BY Nombre ASC");
		while ($RResRefaccion=mysql_fetch_array($ResRefaccion))
		{
			$cadena.='<option value="'.$RResRefaccion["Consecutivo"].'">'.utf8_encode($RResRefaccion["Nombre"]).'</option>';
		}
		$cadena.='</select> <span class="textorojo">Cantidad utilizada:</span> <input type="text" name="cantidad1" id="cantidad1" size="5" class="input"><br />
		<br /><select name="refaccion2" id="refaccion2" class="input"><option value="0">Sin Refacciones</option>';
		$ResRefaccion=mysql_query("SELECT Consecutivo, Nombre FROM refacciones ORDER BY Nombre ASC");
		while ($RResRefaccion=mysql_fetch_array($ResRefaccion))
		{
			$cadena.='<option value="'.$RResRefaccion["Consecutivo"].'">'.utf8_encode($RResRefaccion["Nombre"]).'</option>';
		}
		$cadena.='</select> <span class="textorojo">Cantidad utilizada:</span> <input type="text" name="cantidad2" id="cantidad2" size="5" class="input"><br />
		<br /><select name="refaccion3" id="refaccion3" class="input"><option value="0">Sin Refacciones</option>';
		$ResRefaccion=mysql_query("SELECT Consecutivo, Nombre FROM refacciones ORDER BY Nombre ASC");
		while ($RResRefaccion=mysql_fetch_array($ResRefaccion))
		{
			$cadena.='<option value="'.$RResRefaccion["Consecutivo"].'">'.utf8_encode($RResRefaccion["Nombre"]).'</option>';
		}
		$cadena.='</select> <span class="textorojo">Cantidad utilizada:</span> <input type="text" name="cantidad3" id="cantidad3" size="5" class="input"><br />&nbsp;<br />
							<span class="textorojo">Descripcion Refacciones Utilizadas:</span> <br /><textarea name="descrefac" id="descrefac" cols="100" rows="3" class="input"></textarea></p>';
	}
	$cadena.='	</th>
						</tr>
						<tr>
							<th colspan="5" align="left" class="texto" bgcolor="#a19aaa"><span class="textorojo">Observaciones Tecnicas:</span> ';
	if(($_SESSION["perfil"]=='tecnico' AND $RResTicket["Status"]=='Atendiendo') OR $_SESSION["perfil"]=='admin')
	{
		$cadena.='<p><textarea name="observaciones" id="observaciones" cols="100" rows="5" class="input">'.utf8_encode($RResTicket["ObsTecnicas"]).'</textarea>';
	}
	$cadena.='	</th>
						</tr>
						<tr>
							<th colspan="5" align="left" class="texto" bgcolor="#a19aaa"><span class="textorojo">Satisfaccion del Usuario: </span>
							<p align="center" class="texto">
								<input type="radio" name="satisfaccion" id="satisfaccion" value="Excelente"'; if($RResTicket["Satisfaccion"]=='Excelente'){$cadena.=' checked';}$cadena.='> Excelente 
								<input type="radio" name="satisfaccion" id="satisfaccion" value="Bueno"'; if($RResTicket["Satisfaccion"]=='Bueno'){$cadena.=' checked';}$cadena.='> Bueno 
								<input type="radio" name="satisfaccion" id="satisfaccion" value="Normal"'; if($RResTicket["Satisfaccion"]=='Normal'){$cadena.=' checked';}$cadena.='> Normal 
								<input type="radio" name="satisfaccion" id="satisfaccion" value="Malo"'; if($RResTicket["Satisfaccion"]=='Malo'){$cadena.=' checked';}$cadena.='> Malo 
								<input type="radio" name="satisfaccion" id="satisfaccion" value="Pesimo"'; if($RResTicket["Satisfaccion"]=='Pesimo'){$cadena.=' checked';}$cadena.='> Pesimo 
							</p>
							</th>
						</tr>';
	$cadena.='<tr>
								<th colspan="5" align="center" class="texto" bgcolor="#a19aaa">
								<a href="Tickets/ticket.php?consecutivo='.$RResTicket["Consecutivo"].'" target="_blank"><img src="images/imprimir.png" border="0" alt="imprimir Ticket"></a>	';
	if(($_SESSION["perfil"]=='tecnico' AND $RResTicket["Status"]=='Atendiendo') OR $_SESSION["perfil"]=='admin')
	{
		$cadena.='	<input type="hidden" name="consecutivo" id="consecutivo" value="'.$RResTicket["Consecutivo"].'">
								<input type="button" name="botsaveticket" id="botsaveticket" value="Guardar>>" class="boton" onclick="xajax_save_ticket(xajax.getFormValues(\'atendiendot\'), \'1\')">&nbsp;
								<input type="button" name="botcloseticket" id="botcloseticket" Value="Finalizar Ticket>>" class="boton" onclick="xajax_save_ticket(xajax.getFormValues(\'atendiendot\'), \'2\')">';
	}
	$cadena.='</th>
						</tr>
						</table>
					 </form>';
	
	 $respuesta = new xajaxResponse(); 
   $respuesta->addAssign("ticks","innerHTML",$cadena);
   return $respuesta;
}
function save_ticket ($ticket, $accion)
{
	include("conexion.php");
	
	$hora=$ticket["hora"].':'.$ticket["min"];
	$fecha=$ticket["anno"].'-'.$ticket["mes"].'-'.$ticket["dia"];
	
	switch ($accion)
	{
		case 1:
			if (mysql_query("UPDATE tickets SET Diagnostico='".$ticket["diagnostico"]."', ObsTecnicas='".utf8_decode($ticket["observaciones"])."', Satisfaccion='".$ticket["satisfaccion"]."' WHERE Consecutivo='".$ticket["consecutivo"]."'") and 
					mysql_query("INSERT INTO solucionticket (Ticket, Fecha, Hora, Solucion) VALUES ('".$ticket["consecutivo"]."', '".$fecha."', '".$hora."', '".utf8_decode($ticket["solucion"])."')") and 
					mysql_query("INSERT INTO refacticket (Ticket, Refaccion1, Cantidad1, Refaccion2, Cantidad2, Refaccion3, Cantidad3, DescRefac) 
																				VALUES ('".$ticket["consecutivo"]."', '".$ticket["refaccion1"]."', '".$ticket["cantidad1"]."', 
																								'".$ticket["refaccion2"]."', '".$ticket["cantidad2"]."', '".$ticket["refaccion3"]."', 
																								'".$ticket["cantidad3"]."','".utf8_decode($ticket["descrefac"])."')"))
					{
						$mensaje='Se ha guardado el ticket correctamente';
						//envia mail al usuario
						$mail=mysql_fetch_array(mysql_query("SELECT Email FROM tickets WHERE Consecutivo='".$ticket["consecutivo"]."'"));
						$cuerpo='Su ticket esta siendo atendido, en breve tendra una respuesta satisfactoria.';
						$headers= "From: GPT Tecnologia <administracion@gpt.com>\r\n"; 
						mail($mail["Email"],"Ticket Atendiendo",$cuerpo, $headers);
					}
			else 
			{
				$mensaje='Ocurrio un error, no se guardo el ticket, intente nuevamente';
			}
			break;
		case 2:
			if(mysql_query("UPDATE tickets SET Diagnostico='".$ticket["diagnostico"]."', ObsTecnicas='".utf8_decode($ticket["observaciones"])."', Satisfaccion='".$ticket["satisfaccion"]."', Status='Finalizado' WHERE Consecutivo='".$ticket["consecutivo"]."'") and 
					mysql_query("INSERT INTO solucionticket (Ticket, Fecha, Hora, Solucion) VALUES ('".$ticket["consecutivo"]."', '".$fecha."', '".$hora."', '".utf8_decode($ticket["solucion"])."')") and 
					mysql_query("INSERT INTO refacticket (Ticket, Refaccion1, Cantidad1, Refaccion2, Cantidad2, Refaccion3, Cantidad3, DescRefac) 
																				VALUES ('".$ticket["consecutivo"]."', '".$ticket["refaccion1"]."', '".$ticket["cantidad1"]."', 
																								'".$ticket["refaccion2"]."', '".$ticket["cantidad2"]."', '".$ticket["refaccion3"]."', 
																								'".$ticket["cantidad3"]."','".utf8_decode($ticket["descrefac"])."')"))
					{
						$mensaje='Se ha guardado y finalizado el ticket correctamente';
						//envia mail al usuario
						$mail=mysql_fetch_array(mysql_query("SELECT Email FROM tickets WHERE Consecutivo='".$ticket["consecutivo"]."'"));
						$cuerpo='Su ticket fue respondido satisfactoriamente.';
						$headers= "From: GPT Tecnologia <administracion@gpt.com>\r\n"; 
						mail($mail["Email"],"Ticket Resuelto",$cuerpo, $headers);
					}
			else 
			{
				$mensaje='Ocurrio un error, no se guardo el ticket, intente nuevamente';
			}
			break;
	}
	
	$cadena='<p class="textomensaje">'.$mensaje.'</p>';
	
	 $respuesta = new xajaxResponse(); 
   $respuesta->addAssign("ticks","innerHTML",$cadena);
   return $respuesta;
	
}
function modelos_ticket($sucursal, $equipo, $marca, $modelo)
{
	include ("conexion.php");
	
	$cadena='<table border="0" cellpaddig="3" cellspacing="0" width="100%">
						<tr>
							<td align="right" bgcolor="#5263ab" class="texto">| <a href="#" onclick="modelos.style.visibility=\'hidden\';">Cerrar</a> |</td>
						</tr>';
	$ResInven=mysql_query("SELECT Modelo, NumSerie, NumInventario, Descripcion FROM inventarios WHERE Cuenta='".$_SESSION["cuenta"]."' AND Sucursal='".$sucursal."' AND Equipo='".$equipo."' AND Marca='".$marca."' AND Modelo LIKE '".$modelo."%' ORDER BY Modelo ASC");
	while($RResInv=mysql_fetch_array($ResInven))
	{
		$cadena.='<tr>
								<td align="left"><a href="#" onClick="document.fadticket.modelo.value=\''.$RResInv["Modelo"].'\'; document.fadticket.nserie.value=\''.$RResInv["NumSerie"].'\'; document.fadticket.ninventario.value=\''.$RResInv["NumInventario"].'\'; document.fadticket.dettecnico.value=\''.utf8_encode($RResInv["Descripcion"]).'\'; modelos.style.visibility=\'hidden\';">'.$RResInv["Modelo"].'</a></td>
							</tr>';
	}
	
	$cadena.='</table>';
	
	//$cadena=$sucursal;
		
	 $respuesta = new xajaxResponse(); 
   $respuesta->addAssign("modelos","innerHTML",$cadena);
   return $respuesta;
}
?>