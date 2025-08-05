<?php
//Inicio la sesion 
session_start();

include ("../conexion.php");

$ResMarcas=mysqli_query($conn, "SELECT * FROM marcas WHERE Consecutivo='".$_POST["marca"]."' LIMIT 1");
$RResM=mysqli_fetch_array($ResMarcas);

$mensaje='<p align="center" class="textomensaje">Esta seguro de eliminar la marca '.$RResM["Nombre"].'<br />
            <a href="#" onclick="delete_marca_2(\'borramarca\', \''.$RResM["Consecutivo"].'\')">SI</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onclick="marcas()">NO</a></p>';


$cadena='<div class="tabla">
				<div class="titprin">
					Eliminar Marca
				</div>
				
				<div class="c100 ccenter">
					'.$mensaje.'
				</div>

				
            </div>';

echo $cadena;

?>
<script>
function delete_marca_2(borra, marca){

var hacer = borra;

$.ajax({
            type: 'POST',
            url : 'marcas/marcas.php',
            data: 'hacer=' + hacer + '&marca=' + marca
}).done (function ( info ){
    $('#contenido').html(info);
});
}
</script>