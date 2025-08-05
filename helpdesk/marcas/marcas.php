<?php
    include("../conexion.php");

    if(isset($_POST["hacer"]))
	{
		if($_POST["hacer"]=='addmarca')
		{
            mysqli_query($conn, "INSERT INTO marcas (Nombre, Descripcion) 
                                            VALUES ('".utf8_decode($_POST["marca"])."', '".utf8_decode($_POST["descripcion"])."')");

            $mensaje='<div class="mesaje" id="mesaje">Se agrego la marca</div>';
        }
        if($_POST["hacer"]=='editmarca')
        {
            mysqli_query($conn, "UPDATE marcas SET Nombre='".utf8_decode($_POST["marca"])."', 
													Descripcion='".utf8_decode($_POST["descripcion"])."' 
                                            WHERE Consecutivo='".$_POST["idmarca"]."'");
                                            
            $mensaje='<div class="mesaje" id="mesaje">Se modifico la marca</div>';
        }
        if($_POST["hacer"]=='borramarca')
        {
            mysqli_query($conn, "DELETE FROM marcas WHERE Consecutivo='".$_POST["marca"]."'");

            $mensaje='<div class="mesaje" id="mesaje">Se elimino la marca</div>';
        }
    }

    $ResMarcas=mysqli_query($conn, "SELECT * FROM marcas ORDER BY Nombre ASC");
	
	$cadena=$mensaje.'<table style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="0" align="center">
				<tr>
                    <td colspan="6" bgcolor="#FFFFFF" align="right" class="texto">| <a href="#" onclick="add_marca()">Agregar Marca</a> |</td>
				</tr>
				<tr>
					<th colspan="6" bgcolor="#5263ab" align="center" class="texto3" style="border:1px solid #FFFFFF">Marcas</th>
				</tr>
				<tr>
					<td class="texto3" align="center" bgcolor="#FF7F24" style="border:1px solid #FFFFFF">&nbsp;</td>
					<td class="texto3" align="center" bgcolor="#FF7F24" style="border:1px solid #FFFFFF">Marca</td>
					<td class="texto3" align="center" bgcolor="#FF7F24" style="border:1px solid #FFFFFF">Descripci&oacute;n</td>
					<td class="texto3" align="center" bgcolor="#FF7F24" style="border:1px solid #FFFFFF">&nbsp;</td>
					<td class="texto3" align="center" bgcolor="#FF7F24" style="border:1px solid #FFFFFF">&nbsp;</td>
				</tr>';
	$bgcolor="#FFFFFF"; $A=1;
	while($RResMarcas=mysqli_fetch_array($ResMarcas))
	{
		$cadena.='<tr bgcolor="'.$bgcolor.'" id="row_'.$J.'">
					<td onmouseover="row_'.$J.'.style.background=\'#e8a5f8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'"class="texto" align="center" style="border:1px solid #FFFFFF">'.$A.'</td>
					<td onmouseover="row_'.$J.'.style.background=\'#e8a5f8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" class="texto" valign="top" align="center" style="border:1px solid #FFFFFF">&nbsp;'.utf8_encode($RResMarcas["Nombre"]).'&nbsp;</td>
					<td onmouseover="row_'.$J.'.style.background=\'#e8a5f8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" class="texto" style="border:1px solid #FFFFFF">'.utf8_encode($RResMarcas["Descripcion"]).'</td>
					<td class="texto" align="center" onmouseover="row_'.$J.'.style.background=\'#e8a5f8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" style="border:1px solid #FFFFFF">
                        <a href="#" onclick="edit_marca(\''.$RResMarcas["Consecutivo"].'\')"><i class="fas fa-edit"></i></a>
                    </td>
                    <td class="texto" align="center" onmouseover="row_'.$J.'.style.background=\'#e8a5f8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" style="border:1px solid #FFFFFF">
                        <a href="#" onclick="delete_marca(\''.$RResMarcas["Consecutivo"].'\')"><i class="fas fa-trash"></i></a>
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
function add_marca()
{
    $.ajax({
				type: 'POST',
				url : 'marcas/add_marca.php'
	}).done (function ( info ){
		$('#contenido').html(info);
	});
}
function edit_marca(marca)
{
    $.ajax({
				type: 'POST',
				url : 'marcas/edit_marca.php',
                data: 'marca=' + marca
	}).done (function ( info ){
		$('#contenido').html(info);
	});
}
function delete_marca(marca)
{
    $.ajax({
				type: 'POST',
				url : 'marcas/delete_marca.php',
                data: 'marca=' + marca
	}).done (function ( info ){
		$('#contenido').html(info);
	});
}

setTimeout(function() { 
    $('#mesaje').fadeOut('fast'); 
}, 1000)
</script>