<?php
    include("../conexion.php");

    if(isset($_POST["hacer"]))
	{
        if($_POST["hacer"]=='addrefaccion')
		{
            mysqli_query($conn, "INSERT INTO refacciones (Nombre, Descripcion) 
                                                    VALUES ('".utf8_decode($_POST["refaccion"])."', '".utf8_decode($_POST["descripcion"])."')");

            $mensaje='<div class="mesaje" id="mesaje">Se agrego la refacción</div>';
        }
    }

    $ResRefac=mysqli_query($conn, "SELECT * FROM refacciones ORDER BY Nombre ASC");
	
	$cadena=$mensaje.'<table style="border:1px solid #FFFFFF" cellpadding="0" cellspacing="0" align="center">
					<tr height="21">
						<td colspan="3" align="right" class="texto" bgcolor="#FFFFFF">| <a href="#" onclick="add_refaccion()">Agregar Refaccion</a> |</td>
					</tr>
					<tr height="21">
						<th colspan="3" bgcolor="#5263ab" style="border:1px solid #FFFFFF" align="center" class="texto3"><strong>Refacciones</strong></th>
					</tr>
					<tr>
						<td class="texto" align="center" bgcolor="#FF7F24" style="border:1px solid #FFFFFF">&nbsp;Num.&nbsp;</td>
						<td class="texto" align="center" bgcolor="#FF7F24" style="border:1px solid #FFFFFF">&nbsp;Tipo de Refaccion&nbsp;</td>
						<td class="texto" align="center" bgcolor="#FF7F24" style="border:1px solid #FFFFFF">&nbsp;Descripci&oacute;n&nbsp;</td>
					</tr>';
	$bgcolor="#FFFFFF"; $J=1;
	while($RResRefac=mysqli_fetch_array($ResRefac))
	{
		$cadena.='<tr>
								<td bgcolor="'.$bgcolor.'" class="texto" valign="top" align="center" style="border:1px solid #FFFFFF">&nbsp;'.$J.'&nbsp;</td>
								<td bgcolor="'.$bgcolor.'" class="texto" valign="top" align="center" style="border:1px solid #FFFFFF">&nbsp;'.utf8_encode($RResRefac["Nombre"]).'&nbsp;</td>
								<td bgcolor="'.$bgcolor.'" class="texto" style="border:1px solid #FFFFFF">'.utf8_encode($RResRefac["Descripcion"]).'</td>
							</tr>';
		$J++;
		if ($bgcolor=='#FFFFFF'){$bgcolor='#CCCCCC';}
		else if($bgcolor=='#CCCCCC'){$bgcolor='#FFFFFF';}
	}
    $cadena.='</table>';
        
    echo $cadena;

?>
<script>
function add_refaccion()
{
    $.ajax({
				type: 'POST',
				url : 'refacciones/add_refaccion.php'
	}).done (function ( info ){
		$('#contenido').html(info);
	});
}
function edit_equipo(equipo)
{
    $.ajax({
				type: 'POST',
				url : 'equipos/edit_equipo.php',
                data: 'equipo=' + equipo
	}).done (function ( info ){
		$('#contenido').html(info);
	});
}
function delete_equipo(equipo)
{
    $.ajax({
				type: 'POST',
				url : 'equipos/delete_equipo.php',
                data: 'equipo=' + equipo
	}).done (function ( info ){
		$('#contenido').html(info);
	});
}

setTimeout(function() { 
    $('#mesaje').fadeOut('fast'); 
}, 1000)
</script>
