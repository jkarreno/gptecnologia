<?php
    //Inicio la sesion 
    session_start();
    include ("../conexion.php");
    include ("../funciones.php");

    $ticket=$_POST["ticket"];

    $ResTicket=mysqlI_query($conn, "SELECT * FROM tickets WHERE Consecutivo='".$ticket."' LIMIT 1");
	$RResTicket=mysqli_fetch_array($ResTicket);
	
	$ResEquipo=mysqli_query($conn, "SELECT Equipo FROM equipos WHERE Consecutivo='".$RResTicket["Equipo"]."' LIMIT 1");
	$RResEquipo=mysqli_fetch_array($ResEquipo);
	
	$ResMarca=mysqli_query($conn, "SELECT Nombre FROM marcas WHERE Consecutivo='".$RResTicket["Marca"]."' LIMIT 1");
	$RResMarca=mysqli_fetch_array($ResMarca);
	
    $cadena='<form name="fasignatecnico" id="fasignatecnico">
                <table border="1" bordercolor="#FFFFFF" cellpadding="5" cellspacing="0" width="98%">
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
                        <td bgcolor="#F0FFF0" class="texto" align="center" valign="top">
                            <select name="tecnico" id="tecnico" class="input">';
	$ResTecnicos=mysqli_query($conn, "SELECT Consecutivo, Nombre FROM usuarios WHERE Perfil='Tecnico' ORDER BY Nombre ASC");
	while($RResTecnicos=mysqli_fetch_array($ResTecnicos))
	{
	  $cadena.='                <option value="'.$RResTecnicos["Consecutivo"].'">'.utf8_encode($RResTecnicos["Nombre"]).'</option>';
	}
    $cadena.='				</select>
                        </td>
						<td bgcolor="#F0FFF0" class="texto" align="center">
                            <input type="hidden" name="nticket" value="'.$RResTicket["Consecutivo"].'">
                            <input type="hidden" name="status" value="'.$RResTicket["Status"].'">
                            <input type="hidden" name="hacer" value="asignatecnico">
							<input type="submit" name="botasigticket" value="Asignar>>" class="boton">
						</td>
					</tr>';
    $cadena.='  </table>
            </form>';

    echo $cadena;
?>
<script>
$("#fasignatecnico").on("submit", function(e){
	e.preventDefault();
	var formData = new FormData(document.getElementById("fasignatecnico"));

	$.ajax({
		url: "Tickets/listatickets.php",
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