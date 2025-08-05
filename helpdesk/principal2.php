<?php 
//Inicio la sesion 
session_start(); 

//COMPRUEBA QUE EL USUARIO ESTA AUTENTIFICADO 
if ($_SESSION["autentificado"] != "SI") { 
    //si no existe, envio a la p�gina de autentificacion 
    header("Location: index.php"); 
    //ademas salgo de este script 
    exit(); 
} 

include ("conexion.php");
//include ("funciones.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="es-ES">
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<title>GPT - Mesa de Ayuda Help Desk</title>
<link href="estilos/estilos.css" rel="stylesheet" type="text/css">
<link href="estilos/menu.css" rel="stylesheet" type="text/css">

<script language="JavaScript" type="text/javascript" src="js/codigo.js"></script>

</head>
<body>
<header>
	<div class="menu_bar">
		<a href="#" class="bt-menu"><span class="fa fa-bars"></span><?php echo $_SESSION["nombre"];?> </a>
	</div>
	
	<nav>
		<div class="welcome">Bienvenido <?php echo $_SESSION["nombreuser"];?></div>
		
	</nav>
</header>


<section class="contenido" id="contenido">
	<?php 
	if(!$_POST["pass"])
	{?>
	<form name="fupdatepass" id="fupdatepass" method="POST" action="principal2.php">
	<div class="tabla">
		<div class="titprin">
			Por favor actualice su contrase&ntilde;a
		</div>

		<div class="c20 c_derecha">
			Seleccione Contrase&ntilde;a:
        </div>
        <div class="c80 ccenter">
			<input type="text" name="pass" id="pass" class="input">
		</div>
		<div class="c100 ccenter">
			<input type="submit" name="botcambiapass" id="botcambiapass" value="Modificar>>" class="boton">
        </div>
		
	</div>
	</form>
	<?php 
	}
	else
	{
		mysqli_query($conn, "UPDATE usuarios SET contrasena='".$_POST["pass"]."' 
											WHERE Consecutivo='".$_SESSION["consecutivo"]."'");
		
		echo '<div class="tabla">
				<div class="titprin">
					Por favor actualice su contrase&ntilde;a
				</div>

				<div class="c100 ccenter">
					<p class="textomensaje">Se actualizo su contrase&ntilde;a satisfactoriamente, es necesario volver a ingresar</p>
				</div>

				<div class="c100 ccenter"><p><a href="logout.php" class="button orange">Salir >></a></div>
				
			</div>';

	}
	?>
</section>
</body>
</html>

