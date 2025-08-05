<?php
//Inicio la sesion 
session_start();

include ("../conexion.php");

$ResSucursal=mysqli_query($conn, "SELECT * FROM sucursales WHERE Consecutivo='".$_POST["sucursal"]."' LIMIT 1");
$RResS=mysqli_fetch_array($ResSucursal);

$mensaje='<p align="center" class="textomensaje">Esta seguro de eliminar la sucursal '.$RResS["Nombre"].'<br />
            <a href="#" onclick="delete_sucursal_2(\'borrasucursal\', \''.$RResS["Consecutivo"].'\', \''.$RResS["Cuenta"].'\')">SI</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onclick="sucursales(\''.$RResS["Cuenta"].'\')">NO</a></p>';


$cadena='<div class="tabla">
				<div class="titprin">
					Eliminar Sucursal
				</div>
				
				<div class="c100 ccenter">
					'.$mensaje.'
				</div>

				
            </div>';

echo $cadena;

?>
<script>
function delete_sucursal_2(borra, sucursal, cuenta){

var hacer = borra;

$.ajax({
            type: 'POST',
            url : 'cuentas/sucursales.php',
            data: 'hacer=' + hacer + '&sucursal=' + sucursal + '&cuenta=' + cuenta
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

</script>