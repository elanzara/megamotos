<?php
include_once 'class/session.php';
include_once 'class/conex.php';
include_once 'class/productos.php';
include_once 'class/tipo_productos.php';
$mensaje="";
$efectivo=0;
$cuotas3=0;
$cuotas6=0;
$cuotas12=0;
$tasa3=0;
$tasa6=0;
$tasa12=0;

/*if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["cerrar"])){
    header();
    }*/
if ($_SERVER["REQUEST_METHOD"] == "GET"){
    $pro_id = (isset($_GET['pro_id'])) ? (int) $_GET['pro_id'] : 0;
    $tip_id = (isset($_GET['tip_id'])) ? (int) $_GET['tip_id'] : 0;
    $suc_id = (isset($_GET['suc_id'])) ? (int) $_GET['suc_id'] : 0;
    $fecha = (isset($_GET["fecha"])) ? $_GET["fecha"] : '';
    $cli_id = (isset($_GET['cli_id'])) ? (int) $_GET['cli_id'] : 0;
    $esModificacion = (isset($_GET['esModificacion'])) ? $_GET['esModificacion'] : "";
    $observaciones = (isset($_GET['observaciones'])) ? $_GET['observaciones'] : '';
    $realizo = (isset($_GET['realizo'])) ? $_GET['realizo'] : '';
    $cantidad = (isset($_GET['cantidad'])) ? (int) $_GET['cantidad'] : 0;
    $descuento = (isset($_GET['descuento'])) ? (double) $_GET['descuento'] : 0;
    $pro_observaciones = (isset($_GET['pro_observaciones'])) ? $_GET['pro_observaciones'] : '';
    $chk_veh = (isset($_GET['chk_veh'])) ? (int) $_GET['chk_veh'] : 0;
    $pmo_id = (isset($_GET['pmo_id'])) ? (int) $_GET['pmo_id'] : 0;
    $veh_id = (isset($_GET['veh_id'])) ? (int) $_GET['veh_id'] : 0;
    $pro = new productos($pro_id);
    $tp = new tipo_productos($pro->get_tip_id());
    $efectivo = $pro->get_pro_precio_costo();
    $tasa3 = $tp->get_tip_3cuotas();
    $tasa6 = $tp->get_tip_6cuotas();
    $tasa12 = $tp->get_tip_12cuotas();
    $cuotas3 = ($efectivo*$tasa3/100)+$efectivo;
    $cuotas6 = ($efectivo*$tasa6/100)+$efectivo;
    $cuotas12 = ($efectivo*$tasa12/100)+$efectivo;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<style>
    #oculto{visibility:hidden};
</style>
<script type="text/javascript" language="JavaScript">
function ele(precio)
{
    var pro_id= document.getElementById('pro_id').value;
    var tip_id=document.getElementById('tip_id').value;
    var suc_id=document.getElementById('suc_id').value; 
    var veh_id = document.getElementById('veh_id').value;
    var observaciones=document.getElementById('observaciones').value; 
    var realizo=document.getElementById('realizo').value; 
    var fecha=document.getElementById('fecha').value;
    var cli_id=document.getElementById('cli_id').value;
    var pmo_id=document.getElementById('pmo_id').value;
    var chk_veh=document.getElementById('chk_veh').value;
    var cantidad=document.getElementById('cantidad').value;
    var descuento=document.getElementById('descuento').value;
    var pro_observaciones = document.getElementById('observaciones_det').value;
    var modif=document.getElementById('modif').value;;

    if (modif=='S') {
        opener.location='modifica_orden_trabajo.php?precio='+precio+'&pro_id_seleccion='+pro_id+'&tip_id='+tip_id
            +'&veh_id='+veh_id+ '&fecha='+fecha+'&suc_id='+suc_id+ '&cli_id='+cli_id+'&observaciones='+observaciones
            +'&realizo='+realizo+'&chk_veh='+chk_veh+'&pmo_id='+pmo_id+'&cantidad='+cantidad+'&descuento='+descuento
            +'&pro_observaciones='+pro_observaciones;
    } else {
        opener.location='alta_orden_trabajo.php?precio='+precio+'&pro_id_seleccion='+pro_id+'&tip_id='+tip_id
            +'&veh_id='+veh_id+ '&fecha='+fecha+'&suc_id='+suc_id+ '&cli_id='+cli_id+'&observaciones='+observaciones
            +'&realizo='+realizo+'&chk_veh='+chk_veh+'&pmo_id='+pmo_id+'&cantidad='+cantidad+'&descuento='+descuento
            +'&pro_observaciones='+pro_observaciones;
    }
    window.close();                
}

function mensaje2(){
    alert ("Mensaje");
}

</script>
</head> 
<body>
<table border="1" bgcolor="#A4A4A4">
    <tr><!-- id="oculto">-->
      <td bgcolor="#585858">EFECTIVO: </td>
      <td><input type="text" onclick='ele(<?php print $efectivo;?>);' value="<?php print number_format($efectivo,2);?>" /></td>
    </tr>
    <tr><!-- id="oculto">-->
      <td bgcolor="#585858">3 CUOTAS: </td>
      <td><input type="text" onclick='ele(<?php print $cuotas3;?>);' value="<?php print number_format($cuotas3,2);?>" /></td>
    </tr>
    <tr>
      <td bgcolor="#585858">6 CUOTAS: </td>
      <td><input type="text" onclick='ele(<?php print $cuotas6;?>);' value="<?php print number_format($cuotas6,2);?>" /></td>
    </tr>
    <tr>
      <td bgcolor="#585858">12 CUOTAS: </td>
      <td><input type="text" onclick='ele(<?php print $cuotas12;?>);' value="<?php print number_format($cuotas12,2);?>" /></td>
    </tr>
    <tr id="oculto">
      <td id="oculto">
        <input type="text" id="pro_id" name="pro_id" value="<?php print $pro_id;?>" />
        <input type="text" id="tip_id" name="tip_id" value="<?php print $tip_id;?>" />
        <input type="text" id="suc_id" name="suc_id" value="<?php print $suc_id;?>" />
        <input type="text" id="fecha" name="fecha" value="<?php print $fecha;?>" />
        <input type="text" id="cli_id" name="cli_id" value="<?php print $cli_id;?>" />
        <input type="text" id="veh_id" name="veh_id" value="<?php print $veh_id;?>" />
        <input type="text" id="observaciones" name="observaciones" value="<?php print $observaciones;?>" />
        <input type="text" id="realizo" name="realizo" value="<?php print $realizo;?>" />
        <input type="text" id="chk_veh" name="chk_veh" value="<?php print $chk_veh;?>" />
        <input type="text" id="pmo_id" name="pmo_id" value="<?php print $pmo_id;?>" />
        <input type="text" id="cantidad" name="cantidad" value="<?php print $cantidad;?>" />
        <input type="text" id="descuento" name="descuento" value="<?php print $descuento;?>" />
        <input type="text" id="observaciones_det" name="observaciones_det" value="<?php print $pro_observaciones;?>" />
        <input type="text" id="modif" name="modif" value="<?php print $esModificacion;?>" />
      </td>
    </tr>
</table>
<script type="text/javascript" language="JavaScript">
function mensaje(){
    alert ("Mensaje");
}
</script>
</body>
</html>