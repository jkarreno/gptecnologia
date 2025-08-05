<?php
//Inicio la sesion 
session_start();

include ("../conexion.php");

$Resusuario=mysqli_query($conn, "SELECT * FROM usuarios WHERE Consecutivo='".$_POST["usuario"]."' LIMIT 1");
$RResU=mysqli_fetch_array($Resusuario);

$mensaje='<p align="center" class="textomensaje">Esta seguro de eliminar el usuario '.$RResU["Nombre"].'<br />
            <a href="#" onclick="delete_usuario_2(\'borrausuario\', \''.$RResU["Consecutivo"].'\')">SI</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onclick="usuarios()">NO</a></p>';


$cadena='<div class="tabla">
				<div class="titprin">
					Eliminar usuario
				</div>
				
				<div class="c100 ccenter">
					'.$mensaje.'
				</div>

				
            </div>';

echo $cadena;

?>
<script>
function delete_usuario_2(borra, usuario){

    var hacer = borra;
    var usuario = usuario;

    $.ajax({
                type: 'POST',
                url : 'usuarios/usuarios.php',
                data: 'hacer=' + hacer + '&usuario=' + usuario
    }).done (function ( info ){
        $('#contenido').html(info);
    });
}

</script>