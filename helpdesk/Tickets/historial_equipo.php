<?php
    //Inicio la sesion 
	session_start();
	
	date_default_timezone_set('America/Mexico_City');

    include ("../conexion.php");
    include ("../funciones.php");

    $t=$_POST["ticket"];

    $ResT=mysqli_fetch_array(mysqli_query($conn, "SELECT NumSerie FROM tickets WHERE Consecutivo='".$t."' LIMIT 1"));

    $ResHistorial=mysqli_query($conn, "SELECT * FROM tickets WHERE NumSerie='".$ResT["NumSerie"]."' ORDER BY Fecha DESC");

    $cadena='<div style="width: 100%; display: flex; justify-content: center; flex-wrap: wrap;">
                <div style="width: 90%">
                <h3>Historial del equipo con numero de serie '.$ResT["NumSerie"].'</h3>
                <table id="table_tickets_historial" class="stripe row-border order-column nowrap" style="width: 100% !important">
                <thead>
                    <tr>
                        <th align="center" class="textotitulo2" bgcolor="#FF7F24">Num Ticket.</th>
                        <th align="center" class="textotitulo2" bgcolor="#FF7F24">Estatus</th>
                        <th align="center" class="textotitulo2" bgcolor="#FF7F24">Fecha</th>
                        <th align="center" class="textotitulo2" bgcolor="#FF7F24">Equipo</th>
                        <th align="center" class="textotitulo2" bgcolor="#FF7F24">Marca</th>
                        <th align="center" class="textotitulo2" bgcolor="#FF7F24">Modelo</th>
                        <th align="center" class="textotitulo2" bgcolor="#FF7F24">NumSerie</th>
                        <th align="center" class="textotitulo2" bgcolor="#FF7F24">Falla</th>
                        <th align="center" class="textotitulo2" bgcolor="#FF7F24">Solucion</th>
                        
                    </tr>
                </thead>
                <tbody>';
    while($RResH = mysqli_fetch_array($ResHistorial))
    {
        $ResEquipo=mysqli_fetch_array(mysqli_query($conn, "SELECT Equipo, Marca, Modelo FROM equipos WHERE Consecutivo='".$RResH["Equipo"]."' LIMIT 1"));
        $ResSolucion=mysqli_fetch_array(mysqli_query($conn, "SELECT Solucion FROM solucionticket WHERE Ticket ='".$RResH["Consecutivo"]."' ORDER BY Consecutivo DESC LIMIT 1"));
        $cadena.='  <tr>
                        <td align="center" bgcolor="#F0FFF0"><a href="#" onclick="detalle_ticket(\''.$RResH["Consecutivo"].'\')">'.$RResH["Consecutivo"].'</a></td>
                        <td align="center" bgcolor="#F0FFF0"><a href="#" onclick="detalle_ticket(\''.$RResH["Consecutivo"].'\')">'.$RResH["Status"].'</a></td>
                        <td align="center" bgcolor="#F0FFF0"><a href="#" onclick="detalle_ticket(\''.$RResH["Consecutivo"].'\')">'.$RResH["Fecha"].'</td>
                        <td align="center" bgcolor="#F0FFF0"><a href="#" onclick="detalle_ticket(\''.$RResH["Consecutivo"].'\')">'.(($ResEquipo["Equipo"] != NULL AND $ResEquipo["Equipo"] != '') ? $ResEquipo["Equipo"] : '---').'</a></td>
                        <td align="center" bgcolor="#F0FFF0"><a href="#" onclick="detalle_ticket(\''.$RResH["Consecutivo"].'\')">'.(($ResEquipo["Marca"] != NULL AND $ResEquipo["Marca"] != '') ? $ResEquipo["Marca"] : '---').'</a></td>
                        <td align="center" bgcolor="#F0FFF0"><a href="#" onclick="detalle_ticket(\''.$RResH["Consecutivo"].'\')">'.(($ResEquipo["Modelo"] != NULL AND $ResEquipo["Modelo"] != '') ? $ResEquipo["Modelo"] : '---').'</a></td>
                        <td align="center" bgcolor="#F0FFF0"><a href="#" onclick="detalle_ticket(\''.$RResH["Consecutivo"].'\')">'.$RResH["NumSerie"].'</a></td>
                        <td align="center" bgcolor="#F0FFF0"><a href="#" onclick="detalle_ticket(\''.$RResH["Consecutivo"].'\')">'.utf8_encode($RResH["Falla"]).'</a></td>
                        <td align="center" bgcolor="#F0FFF0"><a href="#" onclick="detalle_ticket(\''.$RResH["Consecutivo"].'\')">'.utf8_encode($ResSolucion["Solucion"]).'</a></td>
                    </tr>';
    }
    $cadena.='  </tbody>
            </table></div></div>';

    echo $cadena;

    ?>
    <script>
$(document).ready( function () {
    var table = $('#table_tickets_historial').DataTable({
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
    });
});
</script>