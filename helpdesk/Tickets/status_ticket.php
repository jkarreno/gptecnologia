<?php
	//Inicio la sesion 
	session_start();

	include ("../conexion.php");
	
	if(isset($_POST["hacer"]))
	{
		$hora=$_POST["hora"].':'.$_POST["min"];
		$fecha=$_POST["anno"].'-'.$_POST["mes"].'-'.$_POST["dia"];

		if($_POST["hacer"]=='guardar')
		{
			//actualiza el tiket
			mysqli_query($conn, "UPDATE tickets SET Diagnostico='".$_POST["diagnostico"]."', ObsTecnicas='".utf8_decode($_POST["observaciones"])."', Satisfaccion='".$_POST["satisfaccion"]."' WHERE Consecutivo='".$_POST["consecutivo"]."'");
			//actualiza solución (solo administrador)
			$ResSol=mysqli_query($conn, "SELECT * FROM solucionticket WHERE Ticket='".$_POST["consecutivo"]."' ORDER BY Consecutivo ASC");
			while($RResSol=mysqli_fetch_array($ResSol))
			{
				mysqli_query($conn, "UPDATE solucionticket SET Solucion='".utf8_decode($_POST["solucion_".$RResSol["Consecutivo"]])."' WHERE Consecutivo='".$RResSol["Consecutivo"]."'");
			}
			//inserta solución nueva 
			if($_POST["solucion"]!='')
			{
				mysqli_query($conn, "INSERT INTO solucionticket (Ticket, Fecha, Hora, Solucion) VALUES ('".$_POST["consecutivo"]."', '".$fecha."', '".$hora."', '".utf8_decode($_POST["solucion"])."')");
			}
			//inserta refacciones
			$Ref=mysqli_query($conn, "SELECT Consecutivo FROM refacticket WHERE Ticket='".$_POST["consecutivo"]."' ORDER BY Consecutivo ASC LIMIT 1");
			$Nref=mysqli_num_rows($Ref);

			if($Nref==0)
			{
				mysqli_query($conn, "INSERT INTO refacticket (Ticket, Refaccion1, Cantidad1, Refaccion2, Cantidad2, Refaccion3, Cantidad3, DescRefac) 
												VALUES ('".$_POST["consecutivo"]."', '".$_POST["refaccion1"]."', '".$_POST["cantidad1"]."', 
														'".$_POST["refaccion2"]."', '".$_POST["cantidad2"]."', '".$_POST["refaccion3"]."', 
														'".$_POST["cantidad3"]."', '".utf8_decode($_POST["descrefac"])."')");
			}
			else{
				$RRef=mysqli_fetch_array($Ref);

				mysqli_query($conn, "UPDATE refacticket SET Refaccion1='".$_POST["refaccion1"]."',
															Cantidad1='".$_POST["cantidad1"]."',
															Refaccion2='".$_POST["refaccion2"]."',
															Cantidad2='".$_POST["cantidad2"]."',
															Refaccion3='".$_POST["refaccion3"]."',
															Cantidad3='".$_POST["cantidad3"]."',
															DescRefac='".utf8_decode($_POST["descrefac"])."'
													WHERE Consecutivo='".$RRef["Consecutivo"]."'");
			}
			

			$mensaje='<div class="mesaje" id="mesaje">Se guardo ticket</div>';
		}
		if($_POST["hacer"]=='finalizar')
		{
			//actualiza el ticket
			mysqli_query($conn, "UPDATE tickets SET Diagnostico='".$_POST["diagnostico"]."', ObsTecnicas='".utf8_decode($_POST["observaciones"])."', Satisfaccion='".$_POST["satisfaccion"]."', Status='Finalizado' WHERE Consecutivo='".$_POST["consecutivo"]."'"); 
			//actualiza solución (solo administrador)
			$ResSol=mysqli_query($conn, "SELECT * FROM solucionticket WHERE Ticket='".$_POST["consecutivo"]."' ORDER BY Consecutivo ASC");
			while($RResSol=mysqli_fetch_array($ResSol))
			{
				mysqli_query($conn, "UPDATE solucionticket SET Solucion='".utf8_decode($_POST["solucion_".$RResSol["Consecutivo"]])."' WHERE Consecutivo='".$RResSol["Consecutivo"]."'");
			}
			//inserta solución nueva 
			if($_POST["solucion"]!='')
			{
				mysqli_query($conn, "INSERT INTO solucionticket (Ticket, Fecha, Hora, Solucion) VALUES ('".$_POST["consecutivo"]."', '".$fecha."', '".$hora."', '".utf8_decode($_POST["solucion"])."')"); 
			}
			//inserta refacciones
			$Ref=mysqli_query($conn, "SELECT Consecutivo FROM refacticket WHERE Ticket='".$_POST["consecutivo"]."' ORDER BY Consecutivo ASC LIMIT 1");
			$Nref=mysqli_num_rows($Ref);

			if($Nref==0)
			{
				mysqli_query($conn, "INSERT INTO refacticket (Ticket, Refaccion1, Cantidad1, Refaccion2, Cantidad2, Refaccion3, Cantidad3, DescRefac) 
												VALUES ('".$_POST["consecutivo"]."', '".$_POST["refaccion1"]."', '".$_POST["cantidad1"]."', 
														'".$_POST["refaccion2"]."', '".$_POST["cantidad2"]."', '".$_POST["refaccion3"]."', 
														'".$_POST["cantidad3"]."', '".utf8_decode($_POST["descrefac"])."')");
			}
			else{
				$RRef=mysqli_fetch_array($Ref);

				mysqli_query($conn, "UPDATE refacticket SET Refaccion1='".$_POST["refaccion1"]."',
															Cantidad1='".$_POST["cantidad1"]."',
															Refaccion2='".$_POST["refaccion2"]."',
															Cantidad2='".$_POST["cantidad2"]."',
															Refaccion3='".$_POST["refaccion3"]."',
															Cantidad3='".$_POST["cantidad3"]."',
															DescRefac='".utf8_decode($_POST["descrefac"])."'
													WHERE Consecutivo='".$RRef["Consecutivo"]."'");
			}
		}
	}

    $cadena=$mensaje.'<table border="1" bordercolor="#cecee2" cellpadding="5" cellspacing="0" width="90%" align="center">
						<tr height="21">
							<th colspan="3" align="center" bgcolor="#5263ab" class="texto3"><strong>Status Tickets</strong></th>
						</tr>
						<tr>';
	if($_SESSION["cuenta"]==0 AND $_SESSION["perfil"]=='admin')
	{
		$ResTicketsP=mysqli_query($conn, "SELECT Consecutivo FROM tickets WHERE Status='Pendiente'");
		$ResTicketsA=mysqli_query($conn, "SELECT Consecutivo FROM tickets WHERE Status='Atendiendo'");
		$ResTicketsF=mysqli_query($conn, "SELECT Consecutivo FROM tickets WHERE Status='Finalizado'");
	}
	elseif($_SESSION["cuenta"]==0 AND $_SESSION["perfil"]=='tecnico')
	{
		$ResTicketsP=mysqli_query($conn, "SELECT Consecutivo FROM tickets WHERE Status='Pendiente' AND Tecnico='".$_SESSION["consecutivo"]."'");
		$ResTicketsA=mysqli_query($conn, "SELECT Consecutivo FROM tickets WHERE Status='Atendiendo' AND Tecnico='".$_SESSION["consecutivo"]."'");
		$ResTicketsF=mysqli_query($conn, "SELECT Consecutivo FROM tickets WHERE Status='Finalizado' AND Tecnico='".$_SESSION["consecutivo"]."'");
	}
	else
	{
		$ResTicketsP=mysqli_query($conn, "SELECT Consecutivo FROM tickets WHERE Status='Pendiente' AND Cuenta='".$_SESSION["cuenta"]."'");
		$ResTicketsA=mysqli_query($conn, "SELECT Consecutivo FROM tickets WHERE Status='Atendiendo' AND Cuenta='".$_SESSION["cuenta"]."'");
		$ResTicketsF=mysqli_query($conn, "SELECT Consecutivo FROM tickets WHERE Status='Finalizado' AND Cuenta='".$_SESSION["cuenta"]."'");
	}
	
	$cadena.='<td class="texto" bgcolor="#a19aaa"><a href="#" onclick="listatickets(\'Pendiente\')"><i class="fas fa-circle" style="color: #c20005"></i><strong> '.mysqli_num_rows($ResTicketsP).' Tickets Pendientes</strong></a></td>
	          <td class="texto" bgcolor="#a19aaa"><a href="#" onclick="listatickets(\'Atendiendo\')"><i class="fas fa-circle" style="color: #e4ec16"></i><strong> '.mysqli_num_rows($ResTicketsA).' Tickets Atendiendo</strong></a></td>
	          <td class="texto" bgcolor="#a19aaa"><a href="#" onclick="listatickets(\'Finalizado\')"><i class="fas fa-circle" style="color: #26b719"></i><strong> '.mysqli_num_rows($ResTicketsF).' Tickets Finalizados</strong></a></td>
						</td>
						</tr>
						</table>
						
						<div id="ticks">
						
                        </div>';
                        
    echo $cadena;

?>
<script>
function listatickets(status){
	$.ajax({
				type: 'POST',
				url : 'Tickets/listatickets.php',
                data: 'status=' + status
	}).done (function ( info ){
		$('#contenido').html(info);
	});
}

setTimeout(function() { 
    $('#mesaje').fadeOut('fast'); 
}, 1000)
</script>