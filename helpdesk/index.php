<?php 

//Inicio la sesion 

session_start(); 



//COMPRUEBA QUE EL USUARIO ESTA AUTENTIFICADO 

if ($_SESSION["autentificado"] == "SI") { 

    //si no existe, envio a la pï¿½gina de autentificacion 

    header("Location: principal.php"); 

    //ademas salgo de este script 

    exit(); 

} 



include ("conexion.php");



require ('xajax/xajax.inc.php');



$xajax = new xajax(); 



$xajax->registerFunction("sucursales");



$xajax->processRequests();

?>

<html>

	<head>

		<title>Help Desk v2</title>

		<link rel="stylesheet" href="estilos/estilos_index.css">

		<link rel="stylesheet" href="font_awesome/css/font-awesome.min.css">

		<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

		<link rel="stylesheet" href="estilos/styles.css">

		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maxmum-scale=1.0, minimum-scale=1.0">

		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />

	</head>

	<body>

	<video autoplay muted loop playsinline controlslist="nodownload" src="video/Design - 48420.mp4" type="video/mp4" autoplay="autoplay" loop="loop" id="video_background" preload="auto" volume="50"/>
	</video/>

		<div class="centrado_index fondo" id="centrado_index_fondo">

			

			<form name="flogin" id="flogin" method="POST" action="validausuario.php">

			<div class="img_log">

				<img src="images/logotrans.png" border="0">

			</div>
			

			<div class="user_log">

				<i class="fa fa-user"></i>&nbsp;&nbsp;<input type="text" name="usuario" id="usuario" placeholder="Usuario">

			</div>

			<div class="user_pass">

				<i class="fa fa-key"></i>&nbsp;&nbsp;<input type="password" name="pass" id="pass" placeholder="Contraseña">

			</div>

			<div class="boton_ingresar">

				<input type="submit" name="botingresar" id="botingresar" value="Ingresar" class="boton">

			</div>

			</form>

		</div>

		<div class="power">

			<img src="images/gc.png" border="0" width="100">

		</div>

	</body>

</html>

<?php 

function sucursales($empresa)

{

	$cadena='<form name="flogin" id="flogin" method="POST" action="validausuario.php">

			<div class="tit_login">

				BIENVENIDO

			</div>

			<div class="user_log">

				<i class="fa fa-user"></i>&nbsp;&nbsp;<input type="text" name="user" id="user" placeholder="Usuario" value="'.$empresa["user"].'">

			</div>

			<div class="user_pass">

				<i class="fa fa-key"></i>&nbsp;&nbsp;<input type="password" name="pass" id="pass" placeholder="Contraseña" value="'.$empresa["pass"].'">

			</div>

			<div class="user_empresa">

				<i class="fa fa-building"></i>&nbsp;&nbsp;<select name="empresa" id="empresa" onChange="xajax_sucursales(xajax.getFormValues(\'flogin\'))">

         			<option>Empresa</option>';

    $ResEmpresas=mysql_query("SELECT Id, Nombre FROM empresas ORDER BY Nombre ASC");

    while($RResEmpresas=mysql_fetch_array($ResEmpresas))

    {

        $cadena.='	<option value="'.$RResEmpresas["Id"].'"';if($empresa["empresa"]==$RResEmpresas["Id"]){$cadena.=' selected';}$cadena.='>'.utf8_decode($RResEmpresas["Nombre"]).'</option>';

    }

   $cadena.='	</select>

			</div>

			<div class="user_sucursal">

				<i class="fa fa-file-text-o" aria-hidden="true"></i>&nbsp;&nbsp;<select name="sucursal" id="sucursal">

					<option value="">Comprobante</option>';

	$ResSucursales=mysql_query("SELECT Id, Nombre FROM sucursales WHERE Empresa='".$empresa["empresa"]."' ORDER BY Nombre ASC");

	while($RResSucursales=mysql_fetch_array($ResSucursales))

	{

		$cadena.='<option value="'.$RResSucursales["Id"].'">'.$RResSucursales["Nombre"].'</option>';

	}

	$cadena.='</select>	

			</div>

			<div class="boton_ingresar">

				<input type="submit" name="botingresar" id="botingresar" value="Ingresar" class="boton">

			</div>

			</form>';

	

	$respuesta = new xajaxResponse(); 

	$respuesta->addAssign("centrado_index_fondo","innerHTML",$cadena);

	return $respuesta;

}

?>