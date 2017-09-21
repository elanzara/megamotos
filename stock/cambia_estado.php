<?php
include_once 'class/session.php';
include_once 'class/orden_trabajo_enc.php';
include_once 'class/conex.php';
$mensaje_resultado = 0;


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //ECHO "Entro en el proceso";
    $ote_id = (isset($_POST['ote_id'])) ? (int) $_POST['ote_id'] : 0;
    $estado = (isset($_POST['estado'])) ? (int) $_POST['estado'] : 0;
    
    //echo "ote_id: " . $ote_id . " Estado: " . $estado;
/*    $estado_dest = 0;
    switch ($estado) {
        case 0:
            $estado_dest = 2;
            break;
        case 2:
            $estado_dest = 3;
            break;
        case 3:
            $estado_dest = 4;
            break;
        case 4:
            break;
        }
*/    
    $sql = "update orden_trabajo_enc set estado = " .$estado . " where ote_id = " . $ote_id;
    $link=Conectarse();
    $result=mysql_query($sql,$link);
    if ($result>0){
        if ($estado == 1 ){
            include_once 'class/movimientos_stock.php';
            //Recupero detalle de orden de trabajo
            $sql="select d.mov_id
                from movimientos_stock d
                where d.estado=0 
                and d.ote_id = ".$ote_id;
            $consulta= mysql_query($sql, $link);
            if ($consulta){
                while ($row = mysql_fetch_assoc($consulta)) {
                    $stm = new movimientos_stock($row['mov_id']);
                    $resu_saldo = $stm->actualiza_saldo('B');
                }
            }
            $sql2 = "update movimientos_stock set estado =1 where ote_id = " . $ote_id;
            $result2=mysql_query($sql2,$link);
/*            if ($result2>0){
                return 1;
            } else {
                return 0;
            }*/
        }
        $mensaje = "Se actualizó correctamente el estado.";
    } else {
        $mensaje = "No se pudo actualizar el estado de la OT.";
    }

    $mensaje_resultado = 1;        
}

if ($mensaje_resultado == 0) {
    $ote_id = (isset($_GET['ote_id'])) ? (int) $_GET['ote_id'] : 0;
    $estado_nuevo = (isset($_GET['estado'])) ? (int) $_GET['estado'] : 0;
    $ote = new orden_trabajo_enc($ote_id);
    
    $estado = 0;
    $estado = $ote->get_estado();
    $estado_desc_ori = "";
    $estado_desc_dest = "";
    
    switch ($estado) {
        case 0:
            $estado_desc_ori = "Pendiente";
            break;
        case 1:
            $estado_desc_ori = "Cancelada";
            break;
        case 2:
            $estado_desc_ori = "En ejecución";
            break;
        case 3:
            $estado_desc_ori = "A Facturar";
            break;
        case 4:
            $estado_desc_ori = "Finalizado";
            break;
        }

    switch ($estado_nuevo) {
        case 0:
            $estado_desc_dest = "Pendiente";
            break;
        case 1:
            $estado_desc_dest = "Cancelada";
            break;
        case 2:
            $estado_desc_dest = "En ejecución";
            break;
        case 3:
            $estado_desc_dest = "A Facturar";
            break;
        case 4:
            $estado_desc_dest = "Finalizado";
            break;
        }

    
    if ($estado_desc_dest != ""){
        $mensaje = "Esta seguro de pasar del estado " . $estado_desc_ori . " a " . $estado_desc_dest . "?";
    } else {
        $mensaje = "No se puede realizar el cambio de estado, ya que se encuentra en el estado final";
        $mensaje_resultado = 2;
    }
}
?>
<html>
    <head>
        <title>Cambio de estado de OT</title>
    </head>
    <body>
        <table width="100%" style="height: 100%;" border="1" bgcolor="gray">
            <tr>
                <td align="center">
                    <form action="cambia_estado.php" method="post">
                        <input id="ote_id" name="ote_id" type="hidden" value="<?php echo $ote_id;?>" />
                        <input id="estado" name="estado" type="hidden" value="<?php echo $estado_nuevo;?>" />
                        <b><?php echo $mensaje;?></b>
                        <br />
                        <?php if ($mensaje_resultado == 0) {?>
                            <input type="submit" value="Si" /><input type="button" value="No" onclick="cerrarPU();"/> <!--window.close();-->
                        <?php } else {?>
                            <input type="button" value="Salir" onclick="cerrarPU();"/>
                        <?php }?>
                    </form>
                </td>
            </tr>
        </table>
<script type="text/javascript">
function cerrarPU()
{
	opener.location='abm_orden_trabajo.php';
	window.close();
}
</script>

    </body>
</html>
