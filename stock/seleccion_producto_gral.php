<?php
include_once 'class/session.php';
include_once 'class/conex.php';
include_once 'class/marcas.php';
include_once 'class/modelos.php';
include_once 'class/productos.php';

$mensaje="";
$mar_id = 0;
$mod_id = 0;
$tip_id = 0;
$pro_med_diametro = "";
$pro_med_ancho = "";
$pro_distribucion = "";
$pro_nueva = 1;
$suc_id = 0;
$suc_des = 0;
$esModificacion = (isset($_GET['esModificacion'])) ? $_GET['esModificacion'] : 'NO';
$fecha = (isset($_GET["fecha"])) ? $_GET["fecha"] : '';
$cli_id = 0;
$remito = (isset($_GET["remito"])) ? $_GET["remito"] : '';
$tipo =  (isset($_GET['tipo'])) ? $_GET['tipo'] : '';
$observaciones = (isset($_GET["observaciones"])) ? $_GET["observaciones"] : '';
$realizo = (isset($_GET["realizo"])) ? $_GET["realizo"] : '';
$chk_veh = (isset($_GET['chk_veh'])) ? (int) $_GET['chk_veh'] : 0;
$pmo_id = (isset($_GET['pmo_id'])) ? (int) $_GET['pmo_id'] : 0;

if ($tipo == "") {
    $tipo =  (isset($_POST['tipo'])) ? $_POST['tipo'] : '';
}
if ($esModificacion == "NO") {
    $esModificacion = (isset($_POST['esModificacion'])) ? $_POST['esModificacion'] : 'NO';
}
if ($_SERVER["REQUEST_METHOD"] == "GET"){
    $tip_id = (isset($_GET['tip_id'])) ? (int) $_GET['tip_id'] : 0;
    $suc_id = (isset($_GET['suc_id'])) ? (int) $_GET['suc_id'] : 0;
    $suc_des = (isset($_GET['suc_des_id'])) ? (int) $_GET['suc_des_id'] : 0;
    $cli_id = (isset($_GET["cli_id"])) ? (int) $_GET["cli_id"] : 0;
    $veh_id = (isset($_GET["veh_id"])) ? (int) $_GET["veh_id"] : 0;
}
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $tip_id = (isset($_POST['tip_id'])) ? (int) $_POST['tip_id'] : 0;
    $mar_id = (isset($_POST['marcas'])) ? (int) $_POST['marcas'] : 0;
    $mod_id = (isset($_POST['modelos'])) ? (int) $_POST['modelos'] : 0;
    $pro_id = (isset($_POST['pro_id'])) ? (int) $_POST['pro_id'] : 0;
    /*Rodado*/$pro_med_diametro = (isset($_POST['rodados'])) ? (int) $_POST['rodados'] : 0;
    $pro_med_ancho = (isset($_POST['anchos'])) ? (int) $_POST['anchos'] : 0;
    $pro_distribucion = (isset($_POST['distribucion'])) ? (int) $_POST['distribucion'] : 0;
    $suc_id = (isset($_POST['suc_id'])) ? (int) $_POST['suc_id'] : 0;
    $suc_des = (isset($_POST['suc_des_id'])) ? (int) $_POST['suc_des_id'] : 0;
    $pro_nueva = (isset($_POST['pro_nueva'])) ? (int) $_POST['pro_nueva'] : 1;
    $tipo =  (isset($_POST['tipo'])) ? $_POST['tipo'] : '';
    $fecha = (isset($_POST["fecha"])) ? $_POST["fecha"] : '';
    $remito = (isset($_POST["remito"])) ? $_POST["remito"] : '';
    $observaciones = (isset($_POST["observaciones"])) ? $_POST["observaciones"] : '';
    $realizo = (isset($_POST["realizo"])) ? $_POST["realizo"] : '';
    $chk_veh = (isset($_POST["chk_veh"])) ? $_POST["chk_veh"] : 0;
    $cli_id = (isset($_POST['cli_id'])) ? (int) $_POST['cli_id'] : 0;
    $veh_id = (isset($_POST['veh_id'])) ? (int) $_POST['veh_id'] : 0;
    $pmo_id = (isset($_POST["pmo_id"])) ? $_POST["pmo_id"] : 0;
}
?>
<html>
<head>
<!--<style>
    #oculto{visibility:hidden};
</style>-->
</head>
<title>.:Buscar Productos en general:.</title>
<body>
<link href="css/admin.css" rel="stylesheet" type="text/css" />
<form action="seleccion_producto_gral.php" method="post">
 <table>
    <tr>
    <td id="oculto">
        <input type="text" id="tip_id" name="tip_id" value="<?php print $tip_id;?>" />
        <input type="text" id="suc_id" name="suc_id" value="<?php print $suc_id;?>" />
        <input type="text" id="suc_des_id" name="suc_des_id" value="<?php print $suc_des;?>" />
        <input type="text" id="esModificacion" name="esModificacion" value="<?php print $esModificacion;?>" />
        <input type="text" id="tipo" name="tipo" value="<?php print $tipo;?>" />
        <input type="text" id="fecha" name="fecha" value="<?php print $fecha;?>" />
        <input type="text" id="cli_id" name="cli_id" value="<?php print $cli_id;?>" />
        <input type="text" id="veh_id" name="veh_id" value="<?php print $veh_id;?>" />
        <input type="text" id="remito" name="remito" value="<?php print $remito;?>" />
        <input type="text" id="observaciones" name="observaciones" value="<?php print $observaciones;?>" />
        <input type="text" id="realizo" name="realizo" value="<?php print $realizo;?>" />
        <input type="text" id="chk_veh" name="chk_veh"  value="<?php print $chk_veh;?>" />
        <input type="text" id="pmo_id" name="pmo_id"  value="<?php print $pmo_id;?>" />
    </td>
    </tr>
    <tr>
        <td class="formTitle">MARCA</td>
        <td class="formFields">
            <?php
                $mar = new marcas();
                //$res = $mar->getmarcasxTipIdCombo($tip_id, $mar_id);
                $res = $mar->getmarcasxTipIdComboNuloyMarId($tip_id, $mar_id);
                //$res = $mar->getmarcasxTipIdComboNuloyMarId($tip_id, $mar_id);
                print $res;
            ?>
        </td>
        <td class="formTitle">MODELO</td>
        <td class="formFields">
              <?php
               if (isset($mod_id) and $mod_id!="" and $mod_id!=0) {
                    $mod = new modelos();
                    $res = $mod->get_modelosComboxTipId($tip_id, $mod_id);
                    print $res;
               } else {
                    print '<select disabled="disabled" name="modelos" id="modelos">';
                    print '<option value="0">Selecciona opci&oacute;n...</option>';
                    print '</select>';
               }
              ?>
        </td>
	<td class="formTitle">ESTADO</td>
        <td class="formFields">
			<select id="pro_nueva" name="pro_nueva" disabled="true">
				<option value="2">Todos</option>
				<option value="1" selected>Nuevo</option>
				<option value="0">Usado</option>
			</select>
        </td>
        <td class="formTitle">CODIGO</td>
        <td><input type="text" name="pro_id" id="pro_id" class="campos" value="<?php print $pro_id;?>" /></td>
        <td>
            <input type="submit" id="busca_producto" name="busca_producto" class="boton" value="Buscar"  />
        </td>
    </tr>
</table>
</form>
   <table align="center" cellpadding="0" cellspacing="1" class="form">
      <tr>
        <td style="width: 70px;" class="rowGris">Código</td>
        <td class="rowGris">Descripción</td>
        <td style="width: 120px;" class="rowGris">Marca</td>
        <td style="width: 120px;" class="rowGris">Modelo</td>
        <td style="width: 120px;" class="rowGris">Estado</td>
        <td style="width: 70px;" class="rowGris">Elegir</td>
      </tr>
        <?php
        //if ($_SERVER["REQUEST_METHOD"] == "POST"){
            $sql = "select p.pro_id
                    , p.pro_descripcion
                    , m.mar_descripcion
                    , mo.mod_descripcion
                    , p.pro_med_diametro
                    , p.pro_med_ancho
                    , p.pro_distribucion
                    , CASE p.pro_nueva
                            WHEN 0 THEN 'Usado'
                            WHEN 1 THEN 'Nuevo'
                            ELSE 'Nuevo'
                            END as nueva
                    from productos p
                    left join marcas m on m.mar_id = p.mar_id
                    left join modelos mo on mo.mod_id = p.mod_id
                    where p.tip_id = ". $tip_id ."
                    and p.pro_estado = 0
                    ";
                    if ($mar_id != 0){
                                    $sql .= " and p.mar_id = " . $mar_id;
                            }
                    if ($mod_id != 0){
                                    $sql .= " and p.mod_id = " . $mod_id;
                            }
                    if ($pro_nueva != 2){
                                    $sql .= " and p.pro_nueva = " . $pro_nueva;
                            }
                    if ($pro_id != 0){
                                    $sql .= " and p.pro_id = " . $pro_id;
                            }
                 $sql .=" order by p.pro_descripcion";

        /*$sql .= " and m.mar_id = p.mar_id
                                            and mo.mod_id = p.mod_id
                    and p.pro_estado = 0
                                            ";*/
    $link=Conectarse();
    $consulta= mysql_query($sql,$link);
    while($row= mysql_fetch_assoc($consulta)) {
//echo'p:'.$row["pro_id"];
        if ($tip_id == 6){
            $cantidad = 1;
        } else {
            $pro_cant = new productos();
            $cantidad = $pro_cant->getCantidadProducto($row["pro_id"], $suc_id,$fecha);
        }
        if ($tipo == "E" or $tipo == "T"){
            if ($cantidad>0){
                echo '<tr>';
                echo "<td style='width: 70px;' class=rowBlanco><a href='#' onclick='cerrarPU(". $row["pro_id"] . "," . $tip_id .",\"".$tipo."\"". "," . $suc_id. "," . $suc_des .  ",\"" . $remito . "\");'>" . $row["pro_id"] . "</a></td>";
                echo "<td class=rowBlanco>" . $row["pro_descripcion"] . "</td>";
                echo "<td style='width: 120px;' class=rowBlanco>" . $row["mar_descripcion"] . "</td>";
                echo "<td style='width: 120px;' class=rowBlanco>" . $row["mod_descripcion"] . "</td>";
                echo "<td style='width: 120px;' class=rowBlanco>" . $row["nueva"] . "</td>";
                echo "<td style='width: 70px;' class=rowBlanco><a href='#' onclick='cerrarPU(". $row["pro_id"] . "," . $tip_id .",\"".$tipo."\"". "," . $suc_id. "," . $suc_des .  ",\"" . $remito . "\");'>Elegir</a></td>";//". "," . $suc_id. "," . $suc_des_id."
                echo '</tr>';
            }
        } else {
            echo '<tr>';
            echo "<td style='width: 70px;' class=rowBlanco><a href='#' onclick='cerrarPU(". $row["pro_id"] . "," . $tip_id .",\"".$tipo."\"". "," . $suc_id. "," . $suc_des .  ",\"" . $remito . "\");'>" . $row["pro_id"] . "</a></td>";
            echo "<td class=rowBlanco>" . $row["pro_descripcion"] . "</td>";
            echo "<td style='width: 120px;' class=rowBlanco>" . $row["mar_descripcion"] . "</td>";
            echo "<td style='width: 120px;' class=rowBlanco>" . $row["mod_descripcion"] . "</td>";
            echo "<td style='width: 120px;' class=rowBlanco>" . $row["nueva"] . "</td>";
            echo "<td style='width: 70px;' class=rowBlanco><a href='#' onclick='cerrarPU(". $row["pro_id"] . "," . $tip_id .",\"".$tipo."\"". "," . $suc_id. "," . $suc_des .  ",\"" . $remito . "\");'>Elegir</a></td>";//". "," . $suc_id. "," . $suc_des_id."
            echo '</tr>';
        }
    }
//}
?>
   </table>
<script type="text/javascript" src="select_dependientes_xTipId.js"></script>
<script type="text/javascript">
function cerrarPU(pro_id, tip_id, tipo, suc_id, suc_des_id, remito)//, suc_id=0, suc_des_id=0)
{
    var observaciones=document.getElementById('observaciones').value;
    var realizo=document.getElementById('realizo').value;
    var chk_veh=document.getElementById('chk_veh').value;
    var fecha=document.getElementById('fecha').value;
    var cli_id=document.getElementById('cli_id').value;
    var pmo_id=document.getElementById('pmo_id').value;
    var veh_id=document.getElementById('veh_id').value;

<?php if ($esModificacion=="SI"){ ?>
	opener.location='modifica_orden_trabajo.php?pro_id_seleccion=' + pro_id+ '&tip_id=' + tip_id+ '&fecha='+fecha
           + '&suc_id=' + suc_id+ '&cli_id='+cli_id+'&veh_id='+veh_id+ '&remito=' + remito+'&observaciones='+observaciones
           +'&realizo='+realizo+'&chk_veh='+chk_veh+'&pmo_id='+pmo_id;
<?php } else if ((trim($tipo) == "I" || trim($tipo) == "E" || trim($tipo) == "T")){ ?>
        opener.location='alta_movimientos_stock.php?pro_id_seleccion=' + pro_id + '&tip_id=' + tip_id + '&tipo=' + tipo 
           + '&suc_des_id=' + suc_des_id + '&suc_id=' + suc_id + '&remito=' + remito+ '&fecha='+fecha;
<?php } else { ?>    
	opener.location='alta_orden_trabajo.php?pro_id_seleccion=' + pro_id + '&tip_id=' + tip_id+ '&fecha='+fecha
           + '&suc_id=' + suc_id+ '&cli_id='+cli_id+'&veh_id='+veh_id+ '&remito=' + remito+'&observaciones='+observaciones
           +'&realizo='+realizo+'&chk_veh='+chk_veh+'&pmo_id='+pmo_id;
<?php } ?>
	window.close();
}
</script>
</body>
</html>