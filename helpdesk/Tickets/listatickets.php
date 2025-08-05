<?php
    //Inicio la sesion 
	session_start();

    include ("../conexion.php");
	include ("../funciones.php");
	include ("../phpmailer/class.phpmailer.php");
	include ("../phpmailer/class.smtp.php");
	
	if(isset($_POST["hacer"]))
	{
		if($_POST["hacer"]=='asignatecnico')
		{
			mysqli_query($conn, "UPDATE tickets SET Tecnico='".$_POST["tecnico"]."', 
													Status='Atendiendo'
											WHERE Consecutivo='".$_POST["nticket"]."'");
							
			$ResTecnico=mysqli_fetch_array(mysqli_query($conn, "SELECT CorreoE FROM usuarios WHERE Consecutivo='".$_POST["tecnico"]."' LIMIT 1"));

			$mesage='<p>Tienes un nuevo ticket asignado, consulta: <a href="http://gptecnologia.com.mx/helpdesk/">http://gptecnologia.com.mx/helpdesk/</a></p>';

			$hostname= 'mail.gptecnologia.com.mx';
			$username = 'helpdesk@gptecnologia.com.mx';
			$pass = 'Helpdesk2020#';
			$mail_2 = new PHPMailer();
			$mail_2->IsSMTP();
			$mail_2->SMTPAuth = false;
			$mail_2->SMTPAutoTLS = false; 
			//$mail_2->SMTPSecure = "SSL";
			$mail_2->Port = 25;
			//$mail_2->SMTPSecure = ''; 
			$mail_2->Host = $hostname;
			$mail_2->Username = $username;
			$mail_2->Password = $pass;
			$mail_2->From = 'helpdesk@gptecnologia.com.mx';
			$mail_2->FromName = 'Help Desk';
			$mail_2->Subject = 'Nuevo tickey asignado';
			$mail_2->AltBody = '';
			$mail_2->MsgHTML($mesage);
			$mail_2->AddAddress($ResTecnico["CorreoE"]);
			$mail_2->IsHTML(true);
			$mail_2->CharSet = 'UTF-8';
			$succes_2 = $mail_2->Send();

			$mensaje='<div class="mesaje" id="mesaje">Se asigno tecnico al ticket</div>';
		}
	}

    if($_SESSION["cuenta"]==0){$cuenta='%';}else{$cuenta=$_SESSION["cuenta"];}
	if($_SESSION["sucursal"]==0){$suc='%';}else{$suc=$_SESSION["sucursal"];}
	if($_SESSION["perfil"]=='tecnico'){$tec=$_SESSION["consecutivo"];}else{$tec='%';}
	
	$ResTickets=mysqli_query($conn, "SELECT * FROM tickets WHERE Status='".$_POST["status"]."' AND Cuenta LIKE '".$cuenta."' AND Sucursal LIKE '".$suc."' AND Tecnico LIKE '".$tec."' ORDER BY Fecha ASC");
	
	$cadena.=$mensaje.'<table border="1" bordercolor="#FFFFFF" cellpadding="5" cellspacing="0" width="98%">
							<tr>
								<td align="center" class="textotitulo2" bgcolor="#FF7F24">Num.</td>
								<td align="center" class="textotitulo2" bgcolor="#FF7F24">Fecha</td>
								<td align="center" class="textotitulo2" bgcolor="#FF7F24">Cuenta</td>
								<td align="center" class="textotitulo2" bgcolor="#FF7F24">Sucursal</td>
								<td align="center" class="textotitulo2" bgcolor="#FF7F24">Area</td>
								<td align="center" class="textotitulo2" bgcolor="#FF7F24">Respuesta</td>
								<td align="center" class="textotitulo2" bgcolor="#FF7F24">Solución</td>
								<td align="center" class="textotitulo2" bgcolor="#FF7F24"></td>';
	$cadena.='	</tr>';
	if($_POST["status"]=='Pendiente'){$clase="textoRojo";}
	else if($_POST["status"]=='Atendiendo'){$clase='textoAmarillo';}
	else if($_POST["status"]=='Finalizado'){$clase='textoVerde';}
	$bgcolor="#F0FFF0";
	while ($RResTickets=mysqli_fetch_array($ResTickets))
	{
		$ResCuenta=mysqli_query($conn, "SELECT Empresa FROM cuentas WHERE Consecutivo='".$RResTickets["Cuenta"]."' LIMIT 1");
		$RResCuenta=mysqli_fetch_array($ResCuenta);
		
		$ResSuc=mysqli_query($conn, "SELECT Nombre FROM sucursales WHERE Consecutivo='".$RResTickets["Sucursal"]."' LIMIT 1");
		$RResSuc=mysqli_fetch_array($ResSuc);

		//Buscar fecha de atención
		$ResAten=mysqli_fetch_array(mysqli_query($conn, "SELECT Fecha FROM solucionticket WHERE Ticket='".$RResTickets["Consecutivo"]."' ORDER BY Fecha ASC LIMIT 1"));
		$dias_aten=dias_pasados($RResTickets["Fecha"],$ResAten["Fecha"]);

		//buscar fecha de resolución
		$ResRes=mysqli_fetch_array(mysqli_query($conn, "SELECT Fecha FROM solucionticket WHERE Ticket='".$RResTickets["Consecutivo"]."' ORDER BY Fecha DESC LIMIT 1"));
		$dias_res=dias_pasados($RResTickets["Fecha"], $ResRes["Fecha"]);
		
		$cadena.='<tr>
								<td align="center" class="'.$clase.'" bgcolor="'.$bgcolor.'"><a href="#" onclick="detalle_ticket(\''.$RResTickets["Consecutivo"].'\')">'.$RResTickets["ConsecutivoInterno"].'</a></td>
								<td align="center" class="'.$clase.'" bgcolor="'.$bgcolor.'"><a href="#" onclick="detalle_ticket(\''.$RResTickets["Consecutivo"].'\')">'.fecha($RResTickets["Fecha"]).'</a></td>
								<td align="left" class="'.$clase.'" bgcolor="'.$bgcolor.'"><a href="#" onclick="detalle_ticket(\''.$RResTickets["Consecutivo"].'\')">'.utf8_encode($RResCuenta["Empresa"]).'</a></td>
								<td align="left" class="'.$clase.'" bgcolor="'.$bgcolor.'"><a href="#" onclick="detalle_ticket(\''.$RResTickets["Consecutivo"].'\')">'.utf8_encode($RResSuc["Nombre"]).'</a></td>
								<td align="left" class="'.$clase.'" bgcolor="'.$bgcolor.'"><a href="#" onclick="detalle_ticket(\''.$RResTickets["Consecutivo"].'\')">'.utf8_encode($RResTickets["Area"]).'</a></td>
								<td align="center" class="'.$clase.'" bgcolor="'.$bgcolor.'"><a href="#" onclick="detalle_ticket(\''.$RResTickets["Consecutivo"].'\')">'.$dias_aten.' dias</a></td>
								<td align="center" class="'.$clase.'" bgcolor="'.$bgcolor.'"><a href="#" onclick="detalle_ticket(\''.$RResTickets["Consecutivo"].'\')">'.$dias_res.' dias</a></td>
								<td align="center" class="'.$clase.'" bgcolor="'.$bgcolor.'">';
		if($_SESSION["perfil"]=='admin'){$cadena.='&nbsp;<a href="#" onclick="asigna_tecnico(\''.$RResTickets["Consecutivo"].'\')"><i class="fas fa-user-cog"></i></a>';}
		$cadena.='</td></tr>';
		if ($bgcolor=="#F0FFF0"){$bgcolor="#CCCCCC";}
		else if ($bgcolor=="#CCCCCC"){$bgcolor="#F0FFF0";}
	}
    $cadena.='</table>';
    
    echo $cadena;


function dias_pasados($fecha_inicial, $fecha_final)
{
    if($fecha_final==NULL OR $fecha_final=='0000-00-00'){$fecha_final=date("Y-m-d");}

	$dias = (strtotime($fecha_inicial)-strtotime($fecha_final))/86400;
	$dias = abs($dias); $dias = floor($dias);
	return $dias;
}
?>
<script>
function detalle_ticket(ticket){
	$.ajax({
				type: 'POST',
				url : 'Tickets/detalle_ticket.php',
                data: 'ticket=' + ticket
	}).done (function ( info ){
		$('#contenido').html(info);
	});
}
function asigna_tecnico(ticket){
	$.ajax({
				type: 'POST',
				url : 'Tickets/asigna_tecnico.php',
                data: 'ticket=' + ticket
	}).done (function ( info ){
		$('#contenido').html(info);
	});

}

setTimeout(function() { 
    $('#mesaje').fadeOut('fast'); 
}, 1000)
</script>