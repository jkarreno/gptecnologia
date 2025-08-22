<?php 
date_default_timezone_set('America/Mexico_City');

//Inicio la sesion 
session_start();
//COMPRUEBA QUE EL USUARIO ESTA AUTENTIFICADO 
if ($_SESSION["autentificado"] != "SI") { 
    //si no existe, envio a la p?gina de autentificacion 
    header("Location: index.php"); 
    //ademas salgo de este script 
    exit(); 
} 

include ("conexion.php");

?>
<html>
<head>
	<meta charset="UTF-8" />
	<title>Help Desk v2</title>
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	<link rel="stylesheet" href="estilos/estilos.css">
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	
	<script src="https://kit.fontawesome.com/a5e678cc82.js" crossorigin="anonymous"></script>

	<link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css">
	<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
	<script src="https://cdn.datatables.net/fixedcolumns/4.2.2/js/dataTables.fixedColumns.min.js"></script>
	<script src="https://cdn.datatables.net/scroller/2.1.1/css/scroller.dataTables.min.css"></script>
	<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
	<script src="https://cdn.jsdelivr.net/gh/ashl1/datatables-rowsgroup@1.0.0/dataTables.rowsGroup.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/datatables-rowsgroup@1.0.0/dataTables.rowsGroup.js"></script>
	
	<script src="js/codigo.js"></script>
</head>
<body onload="">
	<header>
			<div class="menu_bar">
				<a href="#" class="bt-menu"><span class="fa fa-bars"></span><?php echo $_SESSION["nombre"];?> </a>
			</div>
			
			<nav>
				<div class="welcome">Bienvenido <?php echo $_SESSION["nombreuser"];?></div>
				<ul>
					<li><a href="principal.php"><i class="fa fa-home"></i>Inicio</a></li>
					<li class="submenu">
						<a href="#"><i class="fa fa-ticket"></i>Tickets<span class="caret fa fa-caret-down"></span></a>
						<ul class="children">
							<li><a href="#" onclick="nuevo_ticket('0')"><span class="fa fa-ticket"></span>Nuevo Ticket</a></li>
							<li><a href="#" onclick="status_ticket()"><span class="fa fa-bolt"></span>Status Ticket</a></li>
						</ul>
					<li>
					<li class="submenu">
						<a href="#"><i class="fa fa-file-text-o"></i>Reportes<span class="caret fa fa-caret-down"></span></a>
						<ul class="children">
							<li><a href="#" onclick="tickets_cuenta('0', 'todos')"><span class="fa fa-file-text"></span>Tickets Por Cuenta</a></li>
						</ul>
					</li>
					<li><a href="#"><i class="fa fa-desktop" aria-hidden="true"></i>Inventario</a></li>
					<?php if ($_SESSION["perfil"]=='admin'){?>
					<li class="submenu">
						<a href="#"><i class="fa fa-lock"></i>Administración<span class="caret fa fa-caret-down"></span></a>
						<ul class="children">
							<li><a href="#" onclick="cuentas()"><span class="fa fa-building"></span>Resumen de cuentas</a></li>
							<li><a href="#" onclick="equipos()"><span class="fa fa-laptop"></span>Equipos</a></li>
							<li><a href="#" onclick="marcas()"><span class="fa fa-empire"></span>Marcas</a></li>
							<li><a href="#" onclick="usuarios()"><span class="fa fa-users"></span>Usuarios</a></li>
							<li><a href="#" onclick="refacciones()"><span class="fa fa-cogs"></span>Refacciones</a></li>
						</ul>
					</li>
					<?php }?>
					<li><a href="logout.php"><i class="fa fa-close"></i>Salir</a></li>
				</ul>
			</nav>
		</header>
		
		<section class="contenido" id="contenido">
			
		</section>
		
</body>
</html>
<script>
function refacciones(){
	$.ajax({
				type: 'POST',
				url : 'refacciones/refacciones.php',
				data: 'x=x'
	}).done (function ( info ){
		$('#contenido').html(info);
	});
}
function usuarios(){
	$.ajax({
				type: 'POST',
				url : 'usuarios/usuarios.php',
				data: 'x=x'
	}).done (function ( info ){
		$('#contenido').html(info);
	});
}
function nuevo_ticket(sucursal){
	$.ajax({
				type: 'POST',
				url : 'Tickets/nuevo_ticket.php',
				data: 'sucursal=' + sucursal
	}).done (function ( info ){
		$('#contenido').html(info);
	});
}
function cuentas(){
	$.ajax({
				type: 'POST',
				url : 'cuentas/resumencuentas.php'
	}).done (function ( info ){
		$('#contenido').html(info);
	});
}
function marcas(){
	$.ajax({
				type: 'POST',
				url : 'marcas/marcas.php'
	}).done (function ( info ){
		$('#contenido').html(info);
	});
}
function equipos(){
	$.ajax({
				type: 'POST',
				url : 'equipos/equipos.php'
	}).done (function ( info ){
		$('#contenido').html(info);
	});
}

function status_ticket(){
	$.ajax({
				type: 'POST',
				url : 'Tickets/status_ticket.php'
	}).done (function ( info ){
		$('#contenido').html(info);
	});
}

function tickets_cuenta(cuenta, estatus){
	$.ajax({
				type: 'POST',
				url : 'Reportes/tickets_cuenta.php', 
				data: 'cuenta=' + cuenta + '&estatus=' + estatus
	}).done (function ( info ){
		$('#contenido').html(info);
	});
}

function detalle_ticket(ticket){
	$.ajax({
				type: 'POST',
				url : 'Tickets/detalle_ticket.php',
                data: 'ticket=' + ticket
	}).done (function ( info ){
		$('#contenido').html(info);
	});
}

function historial_equipo(ticket){
	$.ajax({
				type: 'POST',
				url : 'Tickets/historial_equipo.php',
				data: 'ticket=' + ticket
	}).done (function ( info ){
		$('#contenido').html(info);
	});
}
</script>