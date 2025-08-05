<?php
//Inicio la sesion 
session_start(); 

//COMPRUEBA QUE EL USUARIO ESTA AUTENTIFICADO 
if ($_SESSION["autentificado"] != "SI") { 
    //si no existe, envio a la p�gina de autentificacion 
    header("Location: ../index.php"); 
    //ademas salgo de este script 
    exit(); 
} 

require('fpdf/fpdf.php');

include ("../conexion.php");

function fecha($date)
{
	$fecha=explode("-", $date);
	
	switch ($fecha[1])
	{
		case '01': $mes='Enero'; break;
		case '02': $mes='Febrero'; break;
		case '03': $mes='Marzo'; break;
		case '04': $mes='Abril'; break;
		case '05': $mes='Mayo'; break;
		case '06': $mes='Junio'; break;
		case '07': $mes='Julio'; break;
		case '08': $mes='Agosto'; break;
		case '09': $mes='Septiembre'; break;
		case '10': $mes='Octubre'; break;
		case '11': $mes='Noviembre'; break;
		case '12': $mes='Diciembre'; break;
	}
	
	return $fecha[2].' de '.$mes.' de '.$fecha[0];
}

//crear el nuevo archivo pdf
$pdf=new FPDF();

//desabilitar el corte automatico de pagina
$pdf->SetAutoPageBreak(false);

//Agregamos la primer pagina
$pdf->AddPage();

//posicion inicial y por pagina
$y_axis_initial = 25;

$ResTicket=mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tickets WHERE Consecutivo='".$_GET["consecutivo"]."' LIMIT 1"));
$ResCuenta=mysqli_fetch_array(mysqli_query($conn, "SELECT Empresa FROM cuentas WHERE Consecutivo='".$ResTicket["Cuenta"]."' LIMIT 1"));

//nombre de la empresa
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(14);
$pdf->SetX(8);
$pdf->Cell(120,4,strtoupper('GRUPO PROMOTOR DE TECNOLOGIA Y SERVICIOS S. A. DE C. V.'),0,0,'L',1);
//imagen logotipo
$pdf->Image('../images/logo4gp.jpg',20,17,50);
//nombre de la cuenta
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(34);
$pdf->SetX(72);
$pdf->Cell(75,4,strtoupper($ResCuenta["Empresa"]),1,0,'C',1);
//numero de Ticket
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(14);
$pdf->SetX(150);
$pdf->Cell(48,4,'Numero de Ticket',1,0,'C',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(18);
$pdf->SetX(150);
$pdf->Cell(48,4,$ResTicket["ConsecutivoInterno"],1,0,'C',1);
//Referencia de Ticket
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(22);
$pdf->SetX(150);
$pdf->Cell(48,4,'Referencia',1,0,'C',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(26);
$pdf->SetX(150);
$pdf->Cell(48,4,$ResTicket["ConsecutivoCuenta"],1,0,'C',1);
//servicio
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(30);
$pdf->SetX(150);
$pdf->Cell(48,4,'Servicio',1,0,'C',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(34);
$pdf->SetX(150);
$pdf->Cell(48,4,strtoupper($ResTicket["Servicio"]),1,0,'C',1);
//fecha
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(38);
$pdf->SetX(150);
$pdf->Cell(48,4,'Fecha',1,0,'C',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(42);
$pdf->SetX(150);
$pdf->Cell(48,4,$ResTicket["Fecha"],1,0,'C',1);
//status
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(46);
$pdf->SetX(150);
$pdf->Cell(48,4,'Status',1,0,'C',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(50);
$pdf->SetX(150);
$pdf->Cell(48,4,strtoupper($ResTicket["Status"]),1,0,'C',1);

//datos del Ticket
//Usuario Responsable
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(58);
$pdf->SetX(8);
$pdf->Cell(30,4,'Usuario Responsable: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(58);
$pdf->SetX(38);
$pdf->Cell(160,4,$ResTicket["UsuarioResp"],1,0,'L',1);
//Direccion
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(62);
$pdf->SetX(8);
$pdf->Cell(30,4,utf8_decode('Dirección: '),1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(62);
$pdf->SetX(38);
$pdf->Cell(110,4,$ResTicket["Direccion"],1,0,'L',1);
//piso
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(62);
$pdf->SetX(138);
$pdf->Cell(10,4,'Piso: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(62);
$pdf->SetX(148);
$pdf->Cell(50,4,$ResTicket["Piso"],1,0,'L',1);
//telefono
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(66);
$pdf->SetX(8);
$pdf->Cell(30,4,'Telefono: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(66);
$pdf->SetX(38);
$pdf->Cell(30,4,$ResTicket["Telefono"],1,0,'L',1);
//extension
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(66);
$pdf->SetX(68);
$pdf->Cell(10,4,'Ext.: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(66);
$pdf->SetX(78);
$pdf->Cell(10,4,$ResTicket["Ext"],1,0,'L',1);
//Correo Electronico
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(66);
$pdf->SetX(88);
$pdf->Cell(30,4,utf8_decode('Correo Electrónico: '),1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(66);
$pdf->SetX(118);
$pdf->Cell(80,4,$ResTicket["Email"],1,0,'L',1);
//Area
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(74);
$pdf->SetX(8);
$pdf->Cell(30,4,'Area: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(74);
$pdf->SetX(38);
$pdf->Cell(100,4,$ResTicket["Area"],1,0,'L',1);
//Equipo
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(74);
$pdf->SetX(138);
$pdf->Cell(30,4,'Equipo: ',1,0,'L',1);
//
$ResEquipo=mysqli_fetch_array(mysqli_query($conn, "SELECT Equipo FROM equipos WHERE Consecutivo='".$ResTicket["Equipo"]."' LIMIT 1"));
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(74);
$pdf->SetX(168);
$pdf->Cell(30,4,$ResEquipo["Equipo"],1,0,'L',1);
//Marca
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(78);
$pdf->SetX(8);
$pdf->Cell(30,4,'Marca: ',1,0,'L',1);
//
$ResMarca=mysqli_fetch_array(mysqli_query($conn, "SELECT Nombre FROM marcas WHERE Consecutivo='".$ResTicket["Marca"]."' LIMIT 1"));
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(78);
$pdf->SetX(38);
$pdf->Cell(60,4,$ResMarca["Nombre"],1,0,'L',1);
//Modelo
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(78);
$pdf->SetX(98);
$pdf->Cell(30,4,'Modelo: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(78);
$pdf->SetX(128);
$pdf->Cell(70,4,$ResTicket["Modelo"],1,0,'L',1);
//Num. Serie
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(82);
$pdf->SetX(8);
$pdf->Cell(30,4,'Num. Serie: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(82);
$pdf->SetX(38);
$pdf->Cell(60,4,$ResTicket["NumSerie"],1,0,'L',1);
//Num. Inventario
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(82);
$pdf->SetX(98);
$pdf->Cell(30,4,'Num. Inventario: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(82);
$pdf->SetX(128);
$pdf->Cell(70,4,$ResTicket["NumInventario"],1,0,'L',1);
//observaciones
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(90);
$pdf->SetX(8);
$pdf->Cell(190,4,'Observaciones: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(94);
$pdf->SetX(8);
$pdf->MultiCell(190,4,$ResTicket["Observaciones"],1,'L',1);
//falla
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->Ln();
$pdf->SetX(8);
$pdf->Cell(190,4,'Falla Tecnica Reportada: ',1,0,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->Ln();
$pdf->SetX(8);
$pdf->MultiCell(190,4,$ResTicket["Falla"],1,'L',1);
//diagnostico
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->Ln();
$pdf->SetX(8);
$pdf->Cell(190,4,'Diagnostico Tecnico: ',1,0,'L',1);
//
if($ResTicket["Diagnostico"]==''){$ad=20;}else{$ad=4;}
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->Ln();
$pdf->SetX(8);
$pdf->MultiCell(190,$ad,utf8_decode($ResTicket["Diagnostico"]),1,'L',1);
//solucion
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->Ln(4);
$pdf->SetX(8);
$pdf->Cell(190,4,utf8_decode('Solución: '),1,0,'L',1);

$ResSolucionesTicket=mysqli_query($conn, "SELECT * FROM solucionticket WHERE Ticket='".$_GET["consecutivo"]."' ORDER BY Fecha ASC, Hora ASC");
if(mysqli_num_rows($ResSolucionesTicket)==0)
{
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',8);
	$pdf->SetTextColor(000,000,000);
	$pdf->Ln();
	$pdf->SetX(8);
	$pdf->MultiCell(190,20,'',1,'J',1);
}
else 
{
	while($RResST=mysqli_fetch_array($ResSolucionesTicket))
	{
		//fecha y hora
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','',8);
		$pdf->SetTextColor(000,000,000);
		$pdf->Ln();
		$pdf->SetX(8);
		$pdf->MultiCell(20,4,$RResST["Fecha"].' '.$RResST["Hora"],1,'C',1);
		//solucion
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','',8);
		$pdf->SetTextColor(000,000,000);
		$pdf->Ln(-8);
		$pdf->SetX(28);
		$pdf->MultiCell(170,4,$RResST["Solucion"],1,'J',1);
	}
}
//refacciones
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->Ln(8);
$pdf->SetX(8);
$pdf->Cell(190,4,'Refacciones Utilizadas: ',1,0,'L',1);
//Cantidad
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->Ln();
$pdf->SetX(8);
$pdf->Cell(20,4,'Cantidad',1,0,'C',1);
//refaccion
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetX(28);
$pdf->Cell(170,4,utf8_decode('Descripción'),1,0,'C',1);

$ResRefacciones=mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM refacticket WHERE Ticket='".$_GET["consecutivo"]."' LiMIT 1"));

//Refac 1
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->Ln();
$pdf->SetX(8);
$pdf->Cell(20,4,$ResRefacciones["Cantidad1"],1,0,'C',1);
//refaccion
$ResNombRefac=mysqli_fetch_array(mysqli_query($conn, "SELECT Nombre FROM refacciones WHERE Consecutivo='".$ResRefacciones["Refaccion1"]."' LIMIT 1"));
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetX(28);
$pdf->Cell(170,4,$ResNombRefac["Nombre"],1,0,'L',1);
//Refac 2
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->Ln();
$pdf->SetX(8);
$pdf->Cell(20,4,$ResRefacciones["Cantidad2"],1,0,'C',1);
//refaccion
$ResNombRefac2=mysqli_fetch_array(mysqli_query($conn, "SELECT Nombre FROM refacciones WHERE Consecutivo='".$ResRefacciones["Refaccion2"]."' LIMIT 1"));
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetX(28);
$pdf->Cell(170,4,$ResNombRefac2["Nombre"],1,0,'L',1);
//Refac 3
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->Ln();
$pdf->SetX(8);
$pdf->Cell(20,4,$ResRefacciones["Cantidad3"],1,0,'C',1);
//refaccion
$ResNombRefac3=mysqli_fetch_array(mysqli_query($conn, "SELECT Nombre FROM refacciones WHERE Consecutivo='".$ResRefacciones["Refaccion3"]."' LIMIT 1"));
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetX(28);
$pdf->Cell(170,4,$ResNombRefac3["Nombre"],1,0,'L',1);
//Descripcion Refacciones
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->Ln();
$pdf->SetX(8);
$pdf->Cell(190,4,$ResRefacciones["DescRefac"],1,0,'C',1);
//Observaciones Tecnicas
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->Ln(8);
$pdf->SetX(8);
$pdf->Cell(190,4,'Observaciones Tecnicas',1,0,'C',1);
//
if($ResTicket["ObsTecnicas"]==''){$ot=20;}else{$ot=4;}
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->Ln();
$pdf->SetX(8);
$pdf->MultiCell(190,$ot,$ResTicket["ObsTecnicas"],1,'J',1);
//Observaciones Tecnicas
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->Ln(4);
$pdf->SetX(8);
$pdf->Cell(190,4,'Satisfaccion del Usuario',1,0,'L',1);
//Excelente
if($ResTicket["Satisfaccion"]=='Excelente'){$pdf->SetFillColor(204,204,204);}else{$pdf->SetFillColor(255,255,255);}
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->Ln();
$pdf->SetX(8);
$pdf->Cell(38,4,"Excelente",1,0,'C',1);
//Bueno
if($ResTicket["Satisfaccion"]=='Bueno'){$pdf->SetFillColor(204,204,204);}else{$pdf->SetFillColor(255,255,255);}
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetX(46);
$pdf->Cell(38,4,"Bueno",1,0,'C',1);
//Normal
if($ResTicket["Satisfaccion"]=='Normal'){$pdf->SetFillColor(204,204,204);}else{$pdf->SetFillColor(255,255,255);}
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetX(84);
$pdf->Cell(38,4,"Normal",1,0,'C',1);
//Malo
if($ResTicket["Satisfaccion"]=='Malo'){$pdf->SetFillColor(204,204,204);}else{$pdf->SetFillColor(255,255,255);}
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetX(122);
$pdf->Cell(38,4,"Malo",1,0,'C',1);
//Pesimo
if($ResTicket["Satisfaccion"]=='Pesimo'){$pdf->SetFillColor(204,204,204);}else{$pdf->SetFillColor(255,255,255);}
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetX(160);
$pdf->Cell(38,4,"Pesimo",1,0,'C',1);
//Firma de Conformidad
//Usuario Responsalbe
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->Ln(8);
$pdf->SetX(28);
$pdf->Cell(60,4,'Usuario Responsable',1,0,'C',1);
//tecnico Responsable
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetX(100);
$pdf->Cell(60,4,'Tecnico Responsable',1,0,'C',1);
//firmA
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->Ln();
$pdf->SetX(28);
$pdf->Cell(60,30,'',1,0,'C',1);
//tecnico Responsable
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetX(100);
$pdf->Cell(60,30,'',1,0,'C',1);
//nombres
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->Ln();
$pdf->SetX(28);
$pdf->Cell(60,4,'Nombre y Firma',1,0,'C',1);
//tecnico Responsable
$ResTecnico=mysqli_fetch_array(mysqli_query($conn, "SELECT Nombre FROM usuarios WHERE Consecutivo='".$ResTicket["Tecnico"]."' LIMIT 1"));
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(000,000,000);
$pdf->SetX(100);
$pdf->Cell(60,4,$ResTecnico["Nombre"],1,0,'C',1);
//Envio Archivo
$pdf->Output();
?>
