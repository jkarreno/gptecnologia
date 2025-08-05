<?php
	include ("../conexion.php");

	$mensaje='';
	
	if(isset($_POST["hacer"]))
	{
		if($_POST["hacer"]=='addcuenta')
		{
			mysqli_query($conn, "INSERT INTO cuentas (Empresa, Direccion, Contacto, Telefono, CorreoElectronico, ConsecutivoInterno, ConsecutivoCuenta)
											VALUES ('".utf8_decode($_POST["nombre"])."', '".utf8_decode($_POST["direccion"])."', '".utf8_decode($_POST["contacto"])."',
													'".$_POST["telefono"]."', '".$_POST["correoe"]."', '".$_POST["ticketinterno"]."', '".$_POST["ticketcuenta"]."')");
		
			$mensaje='<div class="mesaje" id="mesaje">Se agrego la cuenta</div>';
		}
		if($_POST["hacer"]=='editcuenta')
		{
			mysqli_query($conn, "UPDATE cuentas SET Empresa='".utf8_decode($_POST["nombre"])."',
													Direccion='".utf8_decode($_POST["direccion"])."',
													Contacto='".utf8_decode($_POST["contacto"])."',
													Telefono='".$_POST["telefono"]."',
													CorreoElectronico='".$_POST["correoe"]."',
													ConsecutivoInterno='".$_POST["ticketinterno"]."',
													ConsecutivoCuenta='".$_POST["ticketcuenta"]."'
											WHERE Consecutivo='".$_POST["idcuenta"]."'");

			$mensaje='<div class="mesaje" id="mesaje">Se modifico la cuenta</div>';
		}
	}

    $cadena=$mensaje.'<table cellpadding="3" cellspacing="0" width="100%" style="border:1px solid #FFFFFF">
							<tr>
								<td colspan="6" bgcolor="#FFFFFF" align="right" class="texto">| <a href="#" onclick="add_cuenta()">Agregar Cuenta</a> |</td>
							</tr>
							<tr>
								<td colspan="6" bgcolor="#5263ab" align="center" class="texto3">Resumen de Cuentas</td>
							</tr>
							<tr>
								<td bgcolor="#FF7F24" align="center" class="texto3" style="border:1px solid #FFFFFF">&nbsp;</td>
								<td bgcolor="#FF7F24" align="center" class="texto3" style="border:1px solid #FFFFFF">Nombre</td>
								<td bgcolor="#FF7F24" align="center" class="texto3" style="border:1px solid #FFFFFF">Responsable</td>
								<td bgcolor="#FF7F24" align="center" class="texto3" style="border:1px solid #FFFFFF">&nbsp;</td>
								<td bgcolor="#FF7F24" align="center" class="texto3" style="border:1px solid #FFFFFF">&nbsp;</td>
								<td bgcolor="#FF7F24" align="center" class="texto3" style="border:1px solid #FFFFFF">&nbsp;</td>
							</tr>';
	$J=1; $bgcolor="#FFFFFF";
	$ResCuentas=mysqli_query($conn, "SELECT * FROM cuentas ORDER BY Empresa ASC");
	while($RResCuentas=mysqli_fetch_array($ResCuentas))
	{
		$cadena.='<tr>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">'.$J.'</td>
								<td bgcolor="'.$bgcolor.'" align="left" class="texto" style="border:1px solid #FFFFFF">'.$RResCuentas["Empresa"].'</td>
								<td bgcolor="'.$bgcolor.'" align="left" class="texto" style="border:1px solid #FFFFFF">'.$RResCuentas["Contacto"].'</td>
								<td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">
                                    <a href="#" onclick="edit_cuenta(\''.$RResCuentas["Consecutivo"].'\')"><i class="fas fa-edit"></i></a> 
                                </td>
                                <td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">
                                    <a href="#" onclick="sucursales(\''.$RResCuentas["Consecutivo"].'\')"><i class="fas fa-store"></i></a> 
                                </td>
                                <td bgcolor="'.$bgcolor.'" align="center" class="texto" style="border:1px solid #FFFFFF">
                                    <a href="#"><i class="fas fa-trash"></i></a></td>
                                </td>
							</tr>';
		
		if($bgcolor=="#FFFFFF"){$bgcolor="#CCCCCC";}
		elseif($bgcolor=="#CCCCCC"){$bgcolor="#FFFFFF";}
		
		$J++;
	}
    $cadena.='</table>';
    
    echo $cadena;
?>
<script>
function add_cuenta()
{
    $.ajax({
				type: 'POST',
				url : 'cuentas/add_cuenta.php'
	}).done (function ( info ){
		$('#contenido').html(info);
	});
}
function edit_cuenta(cuenta)
{
    $.ajax({
				type: 'POST',
				url : 'cuentas/edit_cuenta.php',
				data: 'cuenta=' + cuenta
	}).done (function ( info ){
		$('#contenido').html(info);
	});
}
function sucursales(cuenta)
{
    $.ajax({
				type: 'POST',
				url : 'cuentas/sucursales.php',
				data: 'cuenta=' + cuenta
	}).done (function ( info ){
		$('#contenido').html(info);
	});
}


setTimeout(function() { 
    $('#mesaje').fadeOut('fast'); 
}, 1000)
</script>