<?php
    include("../conexion.php");

    if(isset($_POST["hacer"]))
	{
		if($_POST["hacer"]=='addequipo')
		{
            mysqli_query($conn, "INSERT INTO equipos (Equipo, Descripcion) 
                                            VALUES ('".utf8_decode($_POST["equipo"])."', '".utf8_decode($_POST["descripcion"])."')");

            $mensaje='<div class="mesaje" id="mesaje">Se agrego el equipo</div>';
        }
        if($_POST["hacer"]=='editequipo')
        {
            mysqli_query($conn, "UPDATE equipos SET Equipo='".utf8_decode($_POST["equipo"])."', 
													Descripcion='".utf8_decode($_POST["descripcion"])."' 
                                            WHERE Consecutivo='".$_POST["idequipo"]."'");
                                            
            $mensaje='<div class="mesaje" id="mesaje">Se modifico el equipo</div>';
        }
        if($_POST["hacer"]=='borraequipo')
        {
            mysqli_query($conn, "DELETE FROM equipos WHERE Consecutivo='".$_POST["equipo"]."'");

            $mensaje='<div class="mesaje" id="mesaje">Se elimino el equipo</div>';
        }
    }

    $ResEquipos=mysqli_query($conn, "SELECT * FROM equipos ORDER BY Equipo ASC");
	
	$cadena=$mensaje.'<table style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
				<tr>
                    <td colspan="6" bgcolor="#FFFFFF" align="right" class="texto">| <a href="#" onclick="add_equipo()">Agregar Equipo</a> |</td>
				</tr>
				<tr>
					<th colspan="6" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Equipos</th>
				</tr>
				<tr>
					<td class="texto3" align="center" bgcolor="#FF7F24" style="border:1px solid #FFFFFF">&nbsp;</td>
					<td class="texto3" align="center" bgcolor="#FF7F24" style="border:1px solid #FFFFFF">Equipo</td>
					<td class="texto3" align="center" bgcolor="#FF7F24" style="border:1px solid #FFFFFF">Descripci&oacute;n</td>
					<td class="texto3" align="center" bgcolor="#FF7F24" style="border:1px solid #FFFFFF">&nbsp;</td>
					<td class="texto3" align="center" bgcolor="#FF7F24" style="border:1px solid #FFFFFF">&nbsp;</td>
				</tr>';
	$bgcolor="#FFFFFF"; $A=1;
	while($RResEquipos=mysqli_fetch_array($ResEquipos))
	{
		$cadena.='<tr bgcolor="'.$bgcolor.'" id="row_'.$J.'">
					<td onmouseover="row_'.$J.'.style.background=\'#e8a5f8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'"class="texto" align="center" style="border:1px solid #FFFFFF">'.$A.'</td>
					<td onmouseover="row_'.$J.'.style.background=\'#e8a5f8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" class="texto" valign="top" align="center" style="border:1px solid #FFFFFF">&nbsp;'.utf8_encode($RResEquipos["Equipo"]).'&nbsp;</td>
					<td onmouseover="row_'.$J.'.style.background=\'#e8a5f8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" class="texto" style="border:1px solid #FFFFFF">'.utf8_encode($RResEquipos["Descripcion"]).'</td>
					<td class="texto" align="center" onmouseover="row_'.$J.'.style.background=\'#e8a5f8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" style="border:1px solid #FFFFFF">
                        <a href="#" onclick="edit_equipo(\''.$RResEquipos["Consecutivo"].'\')"><i class="fas fa-edit"></i></a>
                    </td>
                    <td class="texto" align="center" onmouseover="row_'.$J.'.style.background=\'#e8a5f8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" style="border:1px solid #FFFFFF">
                        <a href="#" onclick="delete_equipo(\''.$RResEquipos["Consecutivo"].'\')"><i class="fas fa-trash"></i></a>
					</td>
                </tr>';
                
		if ($bgcolor=='#FFFFFF'){$bgcolor='#CCCCCC';}
		else if($bgcolor=='#CCCCCC'){$bgcolor='#FFFFFF';}
		$A++;
	}
    $cadena.='</table>';
    
    echo $cadena;
?>
<script>
function add_equipo()
{
    $.ajax({
				type: 'POST',
				url : 'equipos/add_equipo.php'
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