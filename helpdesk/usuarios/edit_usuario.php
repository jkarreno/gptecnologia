<?php

include ("../conexion.php");

    $ResUser=mysqli_query($conn, "SELECT * FROM usuarios WHERE Consecutivo='".$_POST["usuario"]."'");
    $RResUser=mysqli_fetch_array($ResUser);
	
    $cadena='<form name="feditusuario" id="feditusuario">
            <div class="tabla">
                <div class="titprin">
                    Editar Usuario
                </div>

                <div class="c20 c_derecha">
                    Nombre:
                </div>
                <div class="c80 ccenter">
                    <input type="text" name="nombreu" id="nombreu" value="'.$RResUser["Nombre"].'">
                </div>

                <div class="c20 c_derecha">
                    Correo Electronico:
                </div>
                <div class="c80 ccenter">
                    <input type="text" name="correoe" id="correoe" value="'.$RResUser["CorreoE"].'">
                </div>

                <div class="c20 c_derecha">
                    Cuenta:
                </div>
                <div class="c80 ccenter">
                    <select name="cuenta" id="cuenta" class="input"><option value="0">-Interno--</option>';
                    $ResCuentas=mysqli_query($conn, "SELECT Consecutivo, Empresa FROM cuentas ORDER BY Empresa ASC");
                    while($RResCuentas=mysqli_fetch_array($ResCuentas))
                    {
                        $cadena.='<option value="'.$RResCuentas["Consecutivo"].'"';if($RResCuentas["Consecutivo"]==$RResUser["Cuenta"]){$cadena.=' selected';}$cadena.='>'.$RResCuentas["Empresa"].'</option>';
                    }
                    $cadena.='</select>
                </div>

                <div class="c20 c_derecha">
                    Username
                </div>
                <div class="c80 ccenter">
                    <input type="text" name="user" id="user" value="'.$RResUser["username"].'">
                </div>

                <div class="c20 c_derecha">
                    Perfil:
                </div>
                <div class="c80 ccenter">
                    <select name="perfil" id="perfil" class="input"><option>Seleccione</option>';
                    $ResPerfil=mysqli_query($conn, "SELECT Nombre FROM parametros WHERE PerteneceA='Perfiles' ORDER BY Nombre ASC");
                    while($RResPerfil=mysqli_fetch_array($ResPerfil))
                    {
                        $cadena.='<option value="'.$RResPerfil["Nombre"].'"';if($RResPerfil["Nombre"]==$RResUser["Perfil"]){$cadena.=' selected';}$cadena.='>'.$RResPerfil["Nombre"].'</option>';
                    }
                    $cadena.='</select>
                </div>

                <div class="c100 ccenter">
                    <input type="hidden" name="hacer" id="hacer" value="editusuario">
                    <input type="hidden" name="iduser" id="iduser" value="'.$RResUser["Consecutivo"].'">
                    <input type="submit" name="boteditusuario" id="boteditusuario" value="Editar>>">
                    </div>
                </div>
            </form>';

    echo $cadena;
?>
<script>
$("#feditusuario").on("submit", function(e){
	e.preventDefault();
	var formData = new FormData(document.getElementById("feditusuario"));

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