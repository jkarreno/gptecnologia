<?php

include ("../conexion.php");
	
    $cadena='<form name="fadusuario" id="fadusuario">
            <div class="tabla">
                <div class="titprin">
                    Agregar Usuario
                </div>

                <div class="c20 c_derecha">
                    Nombre:
                </div>
                <div class="c80 ccenter">
                    <input type="text" name="nombreu" id="nombreu">
                </div>

                <div class="c20 c_derecha">
                    Correo Electronico:
                </div>
                <div class="c80 ccenter">
                    <input type="text" name="correoe" id="correoe">
                </div>

                <div class="c20 c_derecha">
                    Cuenta:
                </div>
                <div class="c80 ccenter">
                    <select name="cuenta" id="cuenta" class="input"><option value="0">-Interno--</option>';
                    $ResCuentas=mysqli_query($conn, "SELECT Consecutivo, Empresa FROM cuentas ORDER BY Empresa ASC");
                    while($RResCuentas=mysqli_fetch_array($ResCuentas))
                    {
                        $cadena.='<option value="'.$RResCuentas["Consecutivo"].'">'.$RResCuentas["Empresa"].'</option>';
                    }
                    $cadena.='</select>
                </div>

                <div class="c20 c_derecha">
                    Username
                </div>
                <div class="c80 ccenter">
                    <input type="text" name="user" id="user">
                </div>

                <div class="c20 c_derecha">
                    Perfil:
                </div>
                <div class="c80 ccenter">
                    <select name="perfil" id="perfil" class="input"><option>Seleccione</option>';
                    $ResPerfil=mysqli_query($conn, "SELECT Nombre FROM parametros WHERE PerteneceA='Perfiles' ORDER BY Nombre ASC");
                    while($RResPerfil=mysqli_fetch_array($ResPerfil))
                    {
                        $cadena.='<option value="'.$RResPerfil["Nombre"].'">'.$RResPerfil["Nombre"].'</option>';
                    }
                    $cadena.='</select>
                </div>

                <div class="c100 ccenter">
                    <input type="hidden" name="hacer" id="hacer" value="addusuario">
                    <input type="submit" name="botadusuario" id="botadusuario" value="Agregar>>">
                    </div>
                </div>
            </form>';

    echo $cadena;
?>
<script>
$("#fadusuario").on("submit", function(e){
	e.preventDefault();
	var formData = new FormData(document.getElementById("fadusuario"));

	$.ajax({
		url: "usuarios/usuarios.php",
		type: "POST",
		dataType: "HTML",
		data: formData,
		cache: false,
		contentType: false,
		processData: false
	}).done(function(echo){
		$("#contenido").html(echo);
	});
});
</script>