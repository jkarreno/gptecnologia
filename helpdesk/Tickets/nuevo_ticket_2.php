<?php
	//Inicio la sesion 
	session_start();

    include ("../conexion.php");

    $cadena='<table border="1" bordercolor="#cecee2" cellpadding="5" cellspacing="0" width="90%" align="center">
						<tr height="21">
							<th colspan="4" align="center" bgcolor="#5263ab" class="texto3"><strong>Ticket de Reporte</strong></th>
						</tr>
						<tr>
							<td class="texto" bgcolor="#a19aaa">';
	if(mysqli_query($conn, "INSERT INTO tickets (ConsecutivoInterno, ConsecutivoCuenta, Cuenta, UsuarioResp, Direccion, Piso, Telefono, Ext, Email, Sucursal, Dependencia, Area, Equipo, Marca, Modelo, NumSerie, NumInventario, Observaciones, DetTecnicos, Falla, Servicio, Fecha)
                                        VALUES ('".$_POST["tickinterno"]."', '".$_POST["tickcuenta"]."', '".$_SESSION["cuenta"]."', '".utf8_decode($_POST["nusuario"])."', '".utf8_decode($_POST["direccion"])."', '".utf8_decode($_POST["piso"])."', '".utf8_decode($_POST["telefono"])."', 
                                        		'".utf8_decode($_POST["ext"])."', '".utf8_decode($_POST["email"])."', '".$_POST["sucursal"]."', '".utf8_decode($_POST["dependencia"])."', '".utf8_decode($_POST["area"])."', 
                                        		'".$_POST["equipo"]."', '".$_POST["marca"]."', '".utf8_decode($_POST["modelo"])."', '".utf8_decode($_POST["nserie"])."', '".utf8_decode($_POST["ninventario"])."', 
                                        		'".utf8_decode($_POST["observaciones"])."', '".utf8_decode($_POST["dettecnico"])."', '".utf8_decode($_POST["detfalla"])."', '".$_POST["tservicio"]."', '".date("Y-m-d")."')") AND
		mysqli_query($conn, "UPDATE cuentas SET ConsecutivoInterno=ConsecutivoInterno + 1, ConsecutivoCuenta=ConsecutivoCuenta + 1 WHERE Consecutivo='".$_SESSION["cuenta"]."'"))
	{
		$ResTicket=mysqli_query($conn, "SELECT Consecutivo FROM tickets ORDER BY Consecutivo DESC LIMIT 1");
		$RResTicket=mysqli_fetch_array($ResTicket);
		
		//envia mail al usuario
		//$cuerpo='Su ticket ha sido recibido con el numero '.$RResTicket["Consecutivo"].'-'.$ticket["tickinterno"].', en breve obtendra respuesta nuestra.';
		//$headers= "From: GPT Tecnologia <administracion@gpt.com>\r\n"; 
		//mail($ticket["email"],"Ticket Recibido",$cuerpo, $headers);
		
		$cadena.='<p>Se ha generado el ticket numero '.$RResTicket["Consecutivo"].'-'.$ticket["tickinterno"];
	}
	else 
	{
		$cadena.=mysqli_error();
	}
	
	$cadena.='</td></tr></table>';

    echo $cadena;
?>