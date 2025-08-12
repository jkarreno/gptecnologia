<?php
//Inicio la sesion 
session_start();

include ("../conexion.php");
include ("../funciones.php");

$cadena='<table border="1" bordercolor="#FFFFFF" cellpadding="5" cellspacing="0" width="98%">
            <tr>
                <td align="center" bgcolor="#ffffff">
                    <select name="cuenta" id="cuenta" onchange="tickets_cuenta(this.value, \'todos\')">
                        <option value="0">Selecciona una cuenta</option>';
$ResCuentas=mysqli_query($conn, "SELECT Consecutivo, Empresa FROM cuentas ORDER BY Empresa ASC");
while($RowCuentas=mysqli_fetch_array($ResCuentas)){
    $cadena.='<option value="'.$RowCuentas["Consecutivo"].'"'.($RowCuentas["Consecutivo"]==$_POST["cuenta"] ? ' selected' : '').'>'.$RowCuentas["Empresa"].'</option>';
}
$cadena.='        </select>
                </td>
            </tr>
        </table>';

if($_POST["cuenta"]>0)
{
    $cadena.='<div style="width: 100%; display: flex; justify-content: center; flex-wrap: wrap;">
                <div style="width: 90%">
                <table id="table_tickets_cuenta" class="stripe row-border order-column nowrap" style="width: 100% !important">
                <thead>
                    <tr>
                        <th align="center" class="textotitulo2" bgcolor="#FF7F24">Num Ticket.</th>
                        <th align="center" class="textotitulo2" bgcolor="#FF7F24">Fecha</th>
                        <th align="center" class="textotitulo2" bgcolor="#FF7F24">Sucursal</th>
                        <th align="center" class="textotitulo2" bgcolor="#FF7F24">Area</th>
                        <th align="center" class="textotitulo2" bgcolor="#FF7F24">Equipo</th>
                        <th align="center" class="textotitulo2" bgcolor="#FF7F24">Num Serie</th>
                        <th align="center" class="textotitulo2" bgcolor="#FF7F24">Falla</th>
                        <th align="center" class="textotitulo2" bgcolor="#FF7F24">Estatus</th>
                    </tr>
                </thead>
                <tbody>';
    $ResTickets=mysqli_query($conn, "SELECT * FROM tickets WHERE Cuenta='".$_POST["cuenta"]."' AND Status LIKE '".($_POST["estatus"]=='todos' ? '%' : $_POST["estatus"])."' ORDER BY Fecha DESC");
    $bgcolor="#F0FFF0";
    while($RResT = mysqli_fetch_array($ResTickets))
    {
        $ResSucursal=mysqli_fetch_array(mysqli_query($conn, "SELECT Nombre FROM sucursales WHERE Consecutivo='".$RResT["Sucursal"]."' AND Cuenta = '".$_POST["cuenta"]."' LIMIT 1"));
        $ResEquipo=mysqli_fetch_array(mysqli_query($conn, "SELECT Equipo FROM equipos WHERE Consecutivo='".$RResT["Equipo"]."' LIMIT 1"));
        $cadena.='  <tr>
                        <td align="center" bgcolor="'.$bgcolor.'">'.$RResT["Consecutivo"].'</td>
                        <td align="center" bgcolor="'.$bgcolor.'">'.$RResT["Fecha"].'</td>
                        <td align="center" bgcolor="'.$bgcolor.'">'.(($ResSucursal["Nombre"] != NULL AND $ResSucursal["Nombre"] != '') ? $ResSucursal["Nombre"] : '---').'</td>
                        <td align="center" bgcolor="'.$bgcolor.'">'.$RResT["Area"].'</td>
                        <td align="center" bgcolor="'.$bgcolor.'">'.(($ResEquipo["Equipo"] != NULL AND $ResEquipo["Equipo"] != '') ? $ResEquipo["Equipo"] : '---').'</td>
                        <td align="center" bgcolor="'.$bgcolor.'">'.$RResT["NumSerie"].'</td>
                        <td align="center" bgcolor="'.$bgcolor.'">'.utf8_encode($RResT["Falla"]).'</td>
                        <td align="center" bgcolor="'.$bgcolor.'">'.$RResT["Status"].'</td>
                    </tr>';
        if ($bgcolor=="#F0FFF0"){$bgcolor="#CCCCCC";}
		else if ($bgcolor=="#CCCCCC"){$bgcolor="#F0FFF0";}
    }
    $cadena.='  </tbody>
            </table></div></div>';
}

echo $cadena;

?>
<script>
$(document).ready( function () {
    var table = $('#table_tickets_cuenta').DataTable({
        scrollX: true,
        scrollY: 500,
        scrollCollapse: true,
        scroller:       true,
        deferRender:    true,
        paging: true,
        pageLength: 50,
        language: {
            decimal: '.',
            thousands: ',',
            url: 'https://cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json'
        },
        order: [[0, 'desc']],
        dom: 'Bfrtip',
        buttons: [
            <?php if($_POST["estatus"]!='todos'){?>
            {
                text: 'Todos',
                action: function ( e, dt, node, config ) {
                    tickets_cuenta('<?php echo $_POST["cuenta"]; ?>', 'todos');
                }
            },
            <?php } if($_POST["estatus"]!='Pendiente'){?>
            {
                text: 'Pendiente',
                action: function ( e, dt, node, config ) {
                    tickets_cuenta('<?php echo $_POST["cuenta"]; ?>', 'Pendiente');
                }
            },
            <?php } if($_POST["estatus"]!='Atendiendo'){?>
            {
                text: 'Atendiendo',
                action: function ( e, dt, node, config ) {
                    tickets_cuenta('<?php echo $_POST["cuenta"]; ?>', 'Atendiendo');
                }
            },
            <?php } if($_POST["estatus"]!='Finalizado'){?>
            {
                text: 'Finalizado',
                action: function ( e, dt, node, config ) {
                    tickets_cuenta('<?php echo $_POST["cuenta"]; ?>', 'Finalizado');
                }
            }
            <?php } ?>
        ]
    });
});
</script>