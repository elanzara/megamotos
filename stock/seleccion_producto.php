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
$pro_nueva = 2;
$tipo = "";
$suc_id = 0;
$suc_des = 0;
$pro_material = (isset($_POST['materiales'])) ? $_POST['materiales'] : '';
$esModificacion = (isset($_GET['esModificacion'])) ? $_GET['esModificacion'] : 'NO';
$pro_terminacion = (isset($_POST['pro_terminacion'])) ? $_POST['pro_terminacion'] : '';
$pro_clasificacion = (isset($_POST['pro_clasificacion'])) ? $_POST['pro_clasificacion'] : '';
$fecha = (isset($_GET["fecha"])) ? $_GET["fecha"] : '';
$cli_id = 0;
$remito = (isset($_GET["remito"])) ? $_GET["remito"] : '';
$observaciones = (isset($_GET["observaciones"])) ? $_GET["observaciones"] : '';
$realizo = (isset($_GET["realizo"])) ? $_GET["realizo"] : '';
$chk_veh = (isset($_GET['chk_veh'])) ? (int) $_GET['chk_veh'] : 0;
$pmo_id = (isset($_GET['pmo_id'])) ? (int) $_GET['pmo_id'] : 0;

$tipo =  (isset($_GET['tipo'])) ? $_GET['tipo'] : '';
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
    $pro_nueva = (isset($_POST['pro_nueva'])) ? (int) $_POST['pro_nueva'] : 2;
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
<title>.:Buscar Llantas:.</title>
<body>
<link href="css/admin.css" rel="stylesheet" type="text/css" />
<form action="seleccion_producto.php" method="post">
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
        <td class="formTitle">CODIGO</td>
        <td><input type="text" name="pro_id" id="pro_id" class="campos" value="<?php print $pro_id;?>" /></td>
    </tr>
    <tr>
        <td class="formTitle">RODADO</td>
        <td class="formFields">
            <!--<input type="text" id="rodado" name="rodado" value="<?php //print $rodado?>" onkeyup="this.value=this.value.toUpperCase()" />-->
            <?php
                $pro = new productos();
                $html = $pro->getRodadosSelect($pro_med_diametro, $tip_id);
                echo $html;
            ?>
        </td>        
        <td class="formTitle">ANCHO</td>
        <td class="formFields">
            <!--<input type="text" id="ancho" name="ancho" value="<?php //print $ancho?>" onkeyup="this.value=this.value.toUpperCase()" />-->
            <?php
                $pro = new productos();
                $html = $pro->getAnchoSelect($pro_med_ancho, $tip_id);
                echo $html;
            ?>
        </td>
        <td class="formTitle">DISTR.</td>
        <td class="formFields">
            <!--<input type="text" id="distribucion" name="distribucion" value="<?php //print $distribucion?>" onkeyup="this.value=this.value.toUpperCase()" />-->
            <?php
                $pro = new productos();
                $html = $pro->getDistribucionSelect($pro_distribucion, $tip_id);
                echo $html;
            ?>
        </td>
        <td class="formTitle">MATERIAL</td>
        <td>
            <select name='materiales' id='materiales' class='formFields' >
            <?php if ($pro_material=='ALUMINIO'){?>
                <option value='Todos'>TODOS</option>
                <option value='ALUMINIO' selected>ALUMINIO</option>
                <option value='CHAPA'>CHAPA</option>
            <?php } elseif ($pro_material=='CHAPA'){?>
                <option value='Todos'>TODOS</option>
                <option value='ALUMINIO'>ALUMINIO</option>
                <option value='CHAPA' selected>CHAPA</option>
            <?php } else {?>
                <option value='Todos' selected>TODOS</option>
                <option value='ALUMINIO'>ALUMINIO</option>
                <option value='CHAPA'>CHAPA</option>
            <?php }?>
            </select>
        </td>

          <tr>
            <td class="formTitle">TERMINACION</td>
            <td><input type="text" name="pro_terminacion" id="pro_terminacion" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $pro_terminacion;?>" /></td>
<!--          </tr>
          <tr>-->
            <td class="formTitle">CLASIFICACION</td>
            <td>
                <select name='pro_clasificacion' id='pro_clasificacion' class='formFields'  onChange='cargaContenido(this.id)'>
                    <?php if ($pro_clasificacion == ''){?>
                        <option value='' selected>Todos</option>
                    <?php } else {?>
                        <option value=''>Todos</option>    
                    <?php }?>
                    
                    <?php if ($pro_clasificacion == 'A'){?>
                        <option value='A' selected>Auto</option>
                    <?php } else {?>
                        <option value='A'>Auto</option>    
                    <?php }?>
                    <?php if ($pro_clasificacion == 'C'){?>
                        <option value='C' selected>Camioneta</option>
                    <?php } else {?>
                        <option value='C'>Camioneta</option>    
                    <?php }?>
                    <?php if ($pro_clasificacion == 'R'){?>
                        <option value='R' selected>Replica</option>
                    <?php } else {?>
                        <option value='R'>Replica</option>    
                    <?php }?>
                    
                </select>
            </td>
<!--          </tr>-->
	<td class="formTitle">ESTADO</td>
        <td class="formFields">
			<select id="pro_nueva" name="pro_nueva" >
				<option value="2" selected>Todos</option>
				<option value="1">Nuevo</option>
				<option value="0">Usado</option>
			</select>
        </td>
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
        <td style="width: 70px;" class="rowGris">Rodado</td>
        <td style="width: 70px;" class="rowGris">Ancho</td>
        <td style="width: 100px;" class="rowGris">Distribución</td>
        <td style="width: 100px;" class="rowGris">Material</td>
        <td style="width: 100px;" class="rowGris">Terminacion</td>
        <td style="width: 100px;" class="rowGris">Clasif.</td>
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
                    , p.pro_material
                    , p.pro_terminacion
                    , p.pro_clasificacion
                    , CASE p.pro_nueva
                            WHEN 0 THEN 'Usado'
                            WHEN 1 THEN 'Nuevo'
                            ELSE 'Usado'
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
                    if ($pro_med_diametro != ""){
                                    $sql .= " and p.pro_med_diametro = " . $pro_med_diametro;
                            }
                    if ($pro_med_ancho != ""){
                                    $sql .= " and p.pro_med_ancho = " . $pro_med_ancho;
                            }
                    if ($pro_distribucion != ""){
                                    $sql .= " and p.pro_distribucion = " . $pro_distribucion;
                            }
                    if ($pro_nueva != 2){
                                    $sql .= " and p.pro_nueva = " . $pro_nueva;
                            }
                    if ($pro_material != '' and $pro_material != 'Todos'){
                                    $sql .= " and p.pro_material = '" . $pro_material ."'";
                            }
                    if ($pro_terminacion != '' and $pro_terminacion != 'Todos'){
                                    $sql .= " and p.pro_terminacion like '%" . $pro_terminacion ."%'";
                            }
                    if ($pro_id != 0){
                                    $sql .= " and p.pro_id = " . $pro_id;
                            }
                    if ($pro_clasificacion != '' and $pro_clasificacion != 'Todos'){
                                    $sql .= " and p.pro_clasificacion = '" . $pro_clasificacion ."'";
                            }
    $link=Conectarse();
    $consulta= mysql_query($sql,$link);
    while($row= mysql_fetch_assoc($consulta)) {

        $pro_cant = new productos();
        $cantidad = $pro_cant->getCantidadProducto($row["pro_id"], $suc_id,$fecha);
        if ($tipo == "I") {
            echo '<tr>';
            echo "<td style='width: 70px;' class=rowBlanco><a href='#' onclick='cerrarPU(". $row["pro_id"] . "," . $tip_id .",\"".$tipo."\"". "," . $suc_id. "," . $suc_des. ",\"" . $remito."\");'>" . $row["pro_id"] . "</a></td>";
            echo "<td class=rowBlanco>" . $row["pro_descripcion"] . "</td>";
            echo "<td style='width: 120px;' class=rowBlanco>" . $row["mar_descripcion"] . "</td>";
            echo "<td style='width: 120px;' class=rowBlanco>" . $row["mod_descripcion"] . "</td>";
            echo "<td style='width: 70px;' class=rowBlanco>" . $row["pro_med_diametro"] . "</td>";
            echo "<td style='width: 70px;' class=rowBlanco>" . $row["pro_med_ancho"] . "</td>";
            echo "<td style='width: 100px;' class=rowBlanco>" . $row["pro_distribucion"] . "</td>";
            echo "<td style='width: 100px;' class=rowBlanco>" . $row["pro_material"] . "</td>";
            echo "<td style='width: 120px;' class=rowBlanco>" . $row["pro_terminacion"] . "</td>";
            echo "<td style='width: 120px;' class=rowBlanco>" . $row["pro_clasificacion"] . "</td>";
            echo "<td style='width: 120px;' class=rowBlanco>" . $row["nueva"] . "</td>";
            echo "<td style='width: 70px;' class=rowBlanco><a href='#' onclick='cerrarPU(". $row["pro_id"] . "," . $tip_id .",\"".$tipo."\"". "," . $suc_id. "," . $suc_des. ",\"" . $remito."\");'>Elegir</a></td>";
            echo '</tr>';
        } else {
            if ($cantidad>0){
                echo '<tr>';
                echo "<td style='width: 70px;' class=rowBlanco><a href='#' onclick='cerrarPU(". $row["pro_id"] . "," . $tip_id .",\"".$tipo."\"". "," . $suc_id. "," . $suc_des. ",\"" . $remito."\");'>" . $row["pro_id"] . "</a></td>";
                echo "<td class=rowBlanco>" . $row["pro_descripcion"] . "</td>";
                echo "<td style='width: 120px;' class=rowBlanco>" . $row["mar_descripcion"] . "</td>";
                echo "<td style='width: 120px;' class=rowBlanco>" . $row["mod_descripcion"] . "</td>";
                echo "<td style='width: 70px;' class=rowBlanco>" . $row["pro_med_diametro"] . "</td>";
                echo "<td style='width: 70px;' class=rowBlanco>" . $row["pro_med_ancho"] . "</td>";
                echo "<td style='width: 70px;' class=rowBlanco>" . $row["pro_distribucion"] . "</td>";
                echo "<td style='width: 70px;' class=rowBlanco>" . $row["pro_material"] . "</td>";
                echo "<td style='width: 120px;' class=rowBlanco>" . $row["pro_terminacion"] . "</td>";
                echo "<td style='width: 120px;' class=rowBlanco>" . $row["pro_clasificacion"] . "</td>";
                echo "<td style='width: 120px;' class=rowBlanco>" . $row["nueva"] . "</td>";
                echo "<td style='width: 70px;' class=rowBlanco><a href='#' onclick='cerrarPU(". $row["pro_id"] . "," . $tip_id .",\"".$tipo."\"". "," . $suc_id. "," . $suc_des. ",\"" . $remito."\");'>Elegir</a></td>";
                echo '</tr>';
            }
        }
    }
//}
?>
</table>
<script type="text/javascript" src="select_dependientes_xTipId.js"></script>
<script type="text/javascript">
function cerrarPU(pro_id, tip_id, tipo, suc_id, suc_des_id, remito)
{
    var observaciones=document.getElementById('observaciones').value; 
    var realizo=document.getElementById('realizo').value;
    var chk_veh=document.getElementById('chk_veh').value;
    var fecha=document.getElementById('fecha').value;
    var cli_id=document.getElementById('cli_id').value;
    var pmo_id=document.getElementById('pmo_id').value;
    var veh_id=document.getElementById('veh_id').value;

<?php if ($esModificacion=="SI"){ ?>
	opener.location='modifica_orden_trabajo.php?pro_id_seleccion=' + pro_id + '&tip_id=' + tip_id+ '&fecha='+fecha
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