<?php
//Inicio la sesion 
session_start();

include ("../conexion.php");

$ResEquipo=mysqli_query($conn, "SELECT * FROM equipos WHERE Consecutivo='".$_POST["equipo"]."' LIMIT 1");
$RResE=mysqli_fetch_array($ResEquipo);

$mensaje='<p align="center" class="textomensaje">Esta seguro de eliminar el equipo '.$RResE["Equipo"].'<br />
            <a href="#" onclick="delete_equipo_2(\'borraequipo\', \''.$RResE["Consecutivo"].'\')">SI</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onclick="equipos()">NO</a></p>';


$cadena='<div class="tabla">
				<div class="titprin">
					Eliminar Equipo
				</div>
				
				<div class="c100 ccenter">
					'.$mensaje.'
				</div>

				
            </div>';

echo $cadena;

?>
<script>
function delete_equipo_2(borra, equipo){

var hacer = borra;

$.ajax({
            type: 'POST',
            url : 'equipos/equipos.php',
            data: 'hacer=' + hacer + '&equipo=' + equipo
}).done (function ( info ){
    $('#contenido').html(info);
});
}
</script>