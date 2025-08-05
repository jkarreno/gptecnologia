<?php
//Inicio la sesion 
session_start();

    include ("../conexion.php");
	
	$mensaje='';
	
	if(isset($_POST["hacer"]))
	{
		if($_POST["hacer"]=='addusuario')
		{
			mysqli_query($conn, "INSERT INTO usuarios (Nombre, username, contrasena, Perfil, Cuenta, Sucursal, CorreoE) 
												VALUES ('".utf8_decode($_POST["nombreu"])."', '".$_POST["user"]."', 
																		'12345678', '".$_POST["perfil"]."', '".$_POST["cuenta"]."', 
																		'".$_POST["sucursal"]."', '".utf8_encode($_POST["correoe"])."')");

			$mensaje='<div class="mesaje" id="mesaje">Se agrego el usuario</div>';
		}
		if($_POST["hacer"]=='editusuario')
		{
			mysqli_query($conn, "UPDATE usuarios SET Nombre='".utf8_decode($_POST["nombreu"])."',
													CorreoE='".utf8_decode($_POST["correoe"])."',
													username='".$_POST["user"]."',
													Perfil='".$_POST["perfil"]."', 
													Cuenta='".$_POST["cuenta"]."',
													Sucursal='".$_POST["sucursal"]."'
											WHERE Consecutivo='".$_POST["iduser"]."'");

			$mensaje='<div class="mesaje" id="mesaje">Se modifico el usuario</div>';
		}
		if($_POST["hacer"]=='borrausuario')
		{
			mysqli_query($conn, "DELETE FROM usuarios WHERE Consecutivo='".$_POST["usuario"]."' LIMIT 1");

			$mensaje='<div class="mesaje" id="mesaje">Se elimino el usuario</div>';
		}
		if($_POST["hacer"]=='reset')
		{
			mysqli_query($conn, "UPDATE usuarios SET contrasena='12345678' WHERE Consecutivo='".$_POST["usuario"]."'");

			$mensaje='<div class="mesaje" id="mesaje">Se reseteo el password del usuario</div>';
		}
	}
    
    $ResUsuarios=mysqli_query($conn, "SELECT Consecutivo, Nombre, username, Perfil, Cuenta FROM usuarios ORDER BY Nombre ASC");
	
	$cadena=$mensaje.'<table style="border:1px solid #FFFFFF" cellpadding="0" cellspacing="0" align="center">
						<tr height="21">
							<td colspan="8" align="right">| <a href="#" onclick="add_usuario()">Agregar Usuario</a> |</th>
						</tr>
						<tr height="21">
							<td colspan="8" align="center" class="titprin" bgcolor="#5263ab" style="border:1px solid #FFFFFF"><strong>Lista de Usuarios</strong></th>
						</tr>
						<tr>
							<td class="texto3" align="center" bgcolor="#FF7F24" style="border:1px solid #FFFFFF">Nombre</td>
							<td class="texto3" align="center" bgcolor="#FF7F24" style="border:1px solid #FFFFFF">Username</td>
							<td class="texto3" align="center" bgcolor="#FF7F24" style="border:1px solid #FFFFFF">Cuentas</td>
							<td class="texto3" align="center" bgcolor="#FF7F24" style="border:1px solid #FFFFFF">Perfil</td>
							<td class="texto3" align="center" bgcolor="#FF7F24" style="border:1px solid #FFFFFF">&nbsp;</td>
							<td class="texto3" align="center" bgcolor="#FF7F24" style="border:1px solid #FFFFFF">&nbsp;</td>
							<td class="texto3" align="center" bgcolor="#FF7F24" style="border:1px solid #FFFFFF">&nbsp;</td>
						</tr>';
	$bgcolor="#FFFFFF"; $A=1;
	while($RResUsuarios=mysqli_fetch_array($ResUsuarios))
	{
		$cadena.='<tr bgcolor="'.$bgcolor.'" id="row_'.$A.'">
								<td onmouseover="row_'.$A.'.style.background=\'#e8a5f8\'" onmouseout="row_'.$A.'.style.background=\''.$bgcolor.'\'" class="texto" align="left">'.utf8_encode($RResUsuarios["Nombre"]).'</td>
								<td onmouseover="row_'.$A.'.style.background=\'#e8a5f8\'" onmouseout="row_'.$A.'.style.background=\''.$bgcolor.'\'" class="texto" align="left">'.$RResUsuarios["username"].'</td>
								<td onmouseover="row_'.$A.'.style.background=\'#e8a5f8\'" onmouseout="row_'.$A.'.style.background=\''.$bgcolor.'\'" class="texto" align="left">';
		$ResCuenta=mysqli_query($conn, "SELECT Empresa FROM cuentas WHERE Consecutivo='".$RResUsuarios["Cuenta"]."' LIMIT 1");
		$RResCuenta=mysqli_fetch_array($ResCuenta);
		$cadena.=utf8_encode($RResCuenta["Empresa"]).'</td>
								<td onmouseover="row_'.$A.'.style.background=\'#e8a5f8\'" onmouseout="row_'.$A.'.style.background=\''.$bgcolor.'\'" class="texto" align="left">'.$RResUsuarios["Perfil"].'</td>
								<td onmouseover="row_'.$A.'.style.background=\'#e8a5f8\'" onmouseout="row_'.$A.'.style.background=\''.$bgcolor.'\'" class="texto" align="center">
                                    <a href="#" onclick="edit_usuario(\''.$RResUsuarios["Consecutivo"].'\')"><i class="fas fa-user-edit"></i></a>
                                </td>
                                <td onmouseover="row_'.$A.'.style.background=\'#e8a5f8\'" onmouseout="row_'.$A.'.style.background=\''.$bgcolor.'\'" class="texto" align="center">
                                    <a href="#" onclick="resetear_password_user(\'reset\', \''.$RResUsuarios["Consecutivo"].'\')"><i class="fas fa-retweet"></i></a>
                                </td>
                                <td onmouseover="row_'.$A.'.style.background=\'#e8a5f8\'" onmouseout="row_'.$A.'.style.background=\''.$bgcolor.'\'" class="texto" align="center">
                                    <a href="#" onclick="delete_usuario(\''.$RResUsuarios["Consecutivo"].'\')"><i class="fas fa-user-times"></i></a>
                                </td>
							</tr>';
		
		if($bgcolor=='#FFFFFF'){$bgcolor='#CCCCCC';}
        else if($bgcolor=='#CCCCCC'){$bgcolor='#FFFFFF';}
        
        $A++;
	}
    $cadena.='</table>';
    
    echo $cadena;
?>
<script>
function add_usuario()
{
    $.ajax({
				type: 'POST',
				url : 'usuarios/add_usuarios.php'
	}).done (function ( info ){
		$('#contenido').html(info);
	});
}
function edit_usuario(usuario)
{
    $.ajax({
				type: 'POST',
				url : 'usuarios/edit_usuario.php',
                data: 'usuario='+ usuario
	}).done (function ( info ){
		$('#contenido').html(info);
	});
}
function delete_usuario(usuario)
{
    $.ajax({
				type: 'POST',
				url : 'usuarios/delete_usuario.php',
                data: 'usuario='+ usuario
	}).done (function ( info ){
		$('#contenido').html(info);
	});
}
function resetear_password_user(hacer, usuario)
{
	$.ajax({
				type: 'POST',
				url : 'usuarios/usuarios.php',
                data: 'usuario='+ usuario + '&hacer=' + hacer
	}).done (function ( info ){
		$('#contenido').html(info);
	});
}

setTimeout(function() { 
    $('#mesaje').fadeOut('fast'); 
}, 1000)
</script>