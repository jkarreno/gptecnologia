<?php
	include ("../conexion.php");

	$mensaje='';
	
	if(isset($_POST["hacer"]))
	{
		if($_POST["hacer"]=='addsucursal')
		{
			mysqli_query($conn, "INSERT INTO sucursales (Cuenta, Nombre, Direccion, Telefono)
												VALUES ('".$_POST["cuenta"]."', '".utf8_decode($_POST["nombre"])."', '".utf8_decode($_POST["direccion"])."', 
														'".$_POST["telefono"]."')");

			$mensaje='<div class="mesaje" id="mesaje">Se agrego la sucursal</div>';
		}
		if($_POST["hacer"]=='editsucursal')
		{
			mysqli_query($conn, "UPDATE sucursales SET Nombre='".utf8_decode($_POST["nombre"])."',
														Direccion='".utf8_decode($_POST["direccion"])."',
														Telefono='".$_POST["telefono"]."'
												WHERE Consecutivo='".$_POST["sucursal"]."'");

			$mensaje='<div class="mesaje" id="mesaje">Se modifico la sucursal</div>';
		}
		if($_POST["hacer"]=='borrasucursal')
		{
			mysqli_query($conn, "DELETE FROM sucursales WHERE Consecutivo='".$_POST["sucursal"]."'");

			$mensaje='<div class="mesaje" id="mesaje">Se elimino la sucursal</div>';
		}
	}

    $ResCuenta=mysqli_fetch_array(mysqli_query($conn, "SELECT Consecutivo, Empresa FROM cuentas WHERE Consecutivo='".$_POST["cuenta"]."' LIMIT 1"));
	
	$cadena.=$mensaje.'<table cellpadding="3" cellspacing="0" width="100%" style="border:1px solid #FFFFFF">
				<tr>
					<td colspan="5" bgcolor="#FFFFFF" align="right" class="texto">| <a href="#" onclick="add_sucursal(\''.$ResCuenta["Consecutivo"].'\')">Agregar Sucursal</a> |</td>
				</tr>
				<tr>
					<td colspan="5" bgcolor="#5263ab" align="center" class="texto3">Resumen de Sucursales de la Cuenta '.$ResCuenta["Empresa"].'</td>
				</tr>
				<tr>
					<td bgcolor="#FF7F24" align="center" class="texto3" style="border:1px solid #FFFFFF">&nbsp;</td>
					<td bgcolor="#FF7F24" align="center" class="texto3" style="border:1px solid #FFFFFF">Nombre</td>
					<td bgcolor="#FF7F24" align="center" class="texto3" style="border:1px solid #FFFFFF">&nbsp;</td>
					<td bgcolor="#FF7F24" align="center" class="texto3" style="border:1px solid #FFFFFF">&nbsp;</td>
				</tr>';
	$J=1; $bgcolor="#FFFFFF";
	$ResSucursales=mysqli_query($conn, "SELECT * FROM sucursales WHERE Cuenta='".$_POST["cuenta"]."' ORDER BY Nombre ASC");
	while($RResSucursales=mysqli_fetch_array($ResSucursales))
	{
		$cadena.='<tr bgcolor="'.$bgcolor.'" id="row_'.$J.'">
					<td onmouseover="row_'.$J.'.style.background=\'#e8a5f8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" style="border:1px solid #FFFFFF">'.$J.'</td>
					<td onmouseover="row_'.$J.'.style.background=\'#e8a5f8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="left" class="texto" style="border:1px solid #FFFFFF">'.$RResSucursales["Nombre"].'</td>
					<td onmouseover="row_'.$J.'.style.background=\'#e8a5f8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" style="border:1px solid #FFFFFF">
						<a href="#" onclick="edit_sucursal(\''.$RResSucursales["Consecutivo"].'\')"><i class="fas fa-edit"></i></a>
					</td>
					<td onmouseover="row_'.$J.'.style.background=\'#e8a5f8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" style="border:1px solid #FFFFFF">
						<a href="#" onclick="delete_sucursal(\''.$RResSucursales["Consecutivo"].'\')"><i class="fas fa-trash"></i></a>
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
function add_sucursal(cuenta)
{
    $.ajax({
				type: 'POST',
				url : 'cuentas/add_sucursal.php',
                data: 'cuenta=' + cuenta
	}).done (function ( info ){
		$('#contenido').html(info);
	});
}
function edit_sucursal(sucursal)
{
    $.ajax({
				type: 'POST',
				url : 'cuentas/edit_sucursal.php',
                data: 'sucursal=' + sucursal
	}).done (function ( info ){
		$('#contenido').html(info);
	});
}
function delete_sucursal(sucursal)
{
    $.ajax({
				type: 'POST',
				url : 'cuentas/delete_sucursal.php',
                data: 'sucursal=' + sucursal
	}).done (function ( info ){
		$('#contenido').html(info);
	});
}


setTimeout(function() { 
    $('#mesaje').fadeOut('fast'); 
}, 1000)
</script>