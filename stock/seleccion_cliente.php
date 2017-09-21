<?php
include_once 'class/session.php';
include_once 'class/conex.php';
include_once 'class/clientes.php';

$mensaje="";
$cli_id = 0;
$cli_apellido = "";
$cli_nombre = "";
$cli_razon_social = "";
$cli_cuit = "";
$cli_tipo_documento = "";
$cli_numero_documento = 0;
$suc_id = 0;
$esModificacion = (isset($_GET['esModificacion'])) ? $_GET['esModificacion'] : 'NO';
$fecha = (isset($_GET["fecha"])) ? $_GET["fecha"] : '';
$observaciones = (isset($_GET["observaciones"])) ? $_GET["observaciones"] : '';
$realizo = (isset($_GET["realizo"])) ? $_GET["realizo"] : '';
$chk_veh = (isset($_GET['chk_veh'])) ? (int) $_GET['chk_veh'] : 0;
$pmo_id = (isset($_GET['pmo_id'])) ? (int) $_GET['pmo_id'] : 0;

if ($esModificacion == "NO") {
    $esModificacion = (isset($_POST['esModificacion'])) ? $_POST['esModificacion'] : 'NO';
}
if ($_SERVER["REQUEST_METHOD"] == "GET"){
    $suc_id = (isset($_GET['suc_id'])) ? (int) $_GET['suc_id'] : 0;
}
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $cli_id = (isset($_POST['cli_id'])) ? (int) $_POST['cli_id'] : 0;
    $cli_apellido = (isset($_POST['apellido'])) ? $_POST['apellido'] : "";
    $cli_nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : "";
    $cli_razon_social = (isset($_POST['razon_social'])) ? $_POST['razon_social'] : "";
    $cli_cuit = (isset($_POST['cli_cuit'])) ? $_POST['cli_cuit'] : "";
    $cli_tipo_documento = (isset($_POST['tipo_documento'])) ? $_POST['tipo_documento'] : "";
    $cli_numero_documento = (isset($_POST['cli_numero_documento'])) ? (int) $_POST['cli_numero_documento'] : 0;
    $suc_id = (isset($_POST['suc_id'])) ? (int) $_POST['suc_id'] : 0;
    $fecha = (isset($_POST["fecha"])) ? $_POST["fecha"] : '';
    $observaciones = (isset($_POST["observaciones"])) ? $_POST["observaciones"] : '';
    $realizo = (isset($_POST["realizo"])) ? $_POST["realizo"] : '';
    $chk_veh = (isset($_POST["chk_veh"])) ? $_POST["chk_veh"] : 0;
    $pmo_id = (isset($_POST["pmo_id"])) ? $_POST["pmo_id"] : 0;
}
?>
<html>
<head>
<style>
    #oculto{visibility:hidden};
</style>
</head>
<title>.:Buscar Clientes:.</title>
<body>
 <link href="css/admin.css" rel="stylesheet" type="text/css" />
 <form action="seleccion_cliente.php" method="POST">
  <table>
    <tr>
    <td id="oculto">
        <input type="text" id="suc_id" name="suc_id" value="<?php print $suc_id;?>" />
        <input type="text" id="esModificacion" name="esModificacion" value="<?php print $esModificacion;?>" />
        <input type="text" id="fecha" name="fecha" value="<?php print $fecha;?>" />
        <input type="text" id="observaciones" name="observaciones" value="<?php print $observaciones;?>" />
        <input type="text" id="realizo" name="realizo" value="<?php print $realizo;?>" />
        <input type="text" id="chk_veh" name="chk_veh"  value="<?php print $chk_veh;?>" />
        <input type="text" id="pmo_id" name="pmo_id"  value="<?php print $pmo_id;?>" />
    </td>
    </tr>
    <tr>
        <td class="formTitle">CODIGO</td>
        <td><input type="text" name="cli_id" id="cli_id" class="campos" value="<?php print $cli_id;?>" /></td>
        <td class="formTitle">APELLIDO</td>
        <td><input type="text" name="apellido" id="apellido" class="campos" value="<?php print $cli_apellido;?>" /></td>
        <!--<td class="formFields">
            <?php
            //$cli = new clientes();
            //$html = $cli->getApellidoSelect($cli_apellido);
            //echo $html;
            ?>
        </td>-->
        <td class="formTitle">NOMBRE</td>
        <td><input type="text" name="nombre" id="nombre" class="campos" value="<?php print $cli_nombre;?>" /></td>
        <!--<td class="formFields">
            <?php
            //$cli = new clientes();
            //$html = $cli->getNombreSelect($cli_nombre);
            //echo $html;
            ?>
        </td>-->
    </tr>
    <tr>
        <td class="formTitle">RAZON SOCIAL</td>
        <td><input type="text" name="razon_social" id="razon_social" class="campos" value="<?php print $cli_razon_social;?>" /></td>
        <!--<td class="formFields">
            <?php
            //$cli = new clientes();
            //$html = $cli->getRSSelect($cli_razon_social);
            //echo $html;
            ?>
        </td>-->
        <td class="formTitle">CUIT</td>
        <td><input type="text" name="cli_cuit" id="cli_cuit" class="campos" value="<?php print $cli_cuit;?>" /></td>
    </tr>
    <tr>
        <td class="formTitle">TIPO DOC.</td>
        <td class="formFields">
            <?php
            $cli = new clientes();
            $html = $cli->getTipoDocSelect($cli_tipo_documento);
            echo $html;
            ?>
        </td>
        <td class="formTitle">NRO.DOC.</td>
        <td><input type="text" name="cli_numero_documento" id="cli_numero_documento" class="campos" value="<?php print $cli_numero_documento;?>" /></td>
        <td><input type="submit" id="busca_cliente" name="busca_cliente" class="boton" value="Buscar"  /></td>
    </tr>
  </table>
 </form>
 <table align="center" cellpadding="0" cellspacing="1" class="form">
    <tr>
        <td style="width: 70px;" class="rowGris">Código</td>
        <td style="width: 70px;" class="rowGris">Apellido</td>
        <td style="width: 70px;" class="rowGris">Nombre</td>
        <td style="width: 100px;" class="rowGris">Razón Social</td>
        <td style="width: 100px;" class="rowGris">Cuit</td>
        <td style="width: 100px;" class="rowGris">Tipo Doc.</td>
        <td style="width: 100px;" class="rowGris">Nro.Doc.</td>
        <td style="width: 70px;" class="rowGris">Elegir</td>
    </tr>
    <?php
    //if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $sql = "select c.cli_id
                , c.cli_apellido
                , c.cli_nombre
                , c.cli_razon_social
                , c.cli_cuit
                , c.cli_tipo_documento
                , c.cli_numero_documento
                from clientes c
                where c.cli_estado = 0
                ";
                if ($cli_id != 0){
                    $sql .= " and c.cli_id = ".$cli_id;
                }
                if ($cli_apellido != ""){
                    //$sql .= " and ('".$cli_apellido."'='TODOS' or IFNULL(c.cli_apellido,' ') = '".$cli_apellido."')";
                    $sql .= " and c.cli_apellido like '%" . $cli_apellido ."%'";
                }
                if ($cli_nombre != ""){
                    //$sql .= " and ('".$cli_nombre."'='TODOS' or IFNULL(c.cli_nombre,' ') = '".$cli_nombre."')";
                    $sql .= " and c.cli_nombre like '%" . $cli_nombre ."%'";
                }
                if ($cli_razon_social != ""){
                    //$sql .= " and ('".$cli_razon_social."'='TODOS' or IFNULL(c.cli_razon_social,' ') = '".$cli_razon_social."')";
                    $sql .= " and c.cli_razon_social like '%" . $cli_razon_social ."%'";
                }
                if ($cli_cuit != ""){
                    $sql .= " and c.cli_cuit like '%".$cli_cuit."%'";
                }
                if ($cli_tipo_documento != ""){
                    $sql .= " and ('".$cli_tipo_documento."'='TODOS' or IFNULL(c.cli_tipo_documento,' ') = '".$cli_tipo_documento."')";
                }
                if ($cli_numero_documento != 0){
                    $sql .= " and c.cli_numero_documento = ".$cli_numero_documento;
                }
        $link=Conectarse();
        $consulta= mysql_query($sql,$link);
        while($row= mysql_fetch_assoc($consulta)) {
            echo '<tr>';
            echo "<td style='width: 70px;' class=rowBlanco><a href='#' onclick='cerrarPU(".$row["cli_id"].",".$suc_id
                .");'>" . $row["cli_id"] . "</a></td>";
            echo "<td class=rowBlanco>" . $row["cli_apellido"] . "</td>";
            echo "<td style='width: 120px;' class=rowBlanco>" . $row["cli_nombre"] . "</td>";
            echo "<td style='width: 120px;' class=rowBlanco>" . $row["cli_razon_social"] . "</td>";
            echo "<td style='width: 70px;' class=rowBlanco>" . $row["cli_cuit"] . "</td>";
            echo "<td style='width: 70px;' class=rowBlanco>" . $row["cli_tipo_documento"] . "</td>";
            echo "<td style='width: 100px;' class=rowBlanco>" . $row["cli_numero_documento"] . "</td>";
            echo "<td style='width: 70px;' class=rowBlanco><a href='#' onclick='cerrarPU(".$row["cli_id"].",".$suc_id
                .");'>Elegir</a></td>";
            echo '</tr>';
            }
    //}
    ?>
 </table>
<script type="text/javascript">
function cerrarPU(cli_id, suc_id)
{
    //alert('cli_id:'+cli_id+'-suc_id:'+suc_id);
    var observaciones=document.getElementById('observaciones').value;
    var realizo=document.getElementById('realizo').value;
    var chk_veh=document.getElementById('chk_veh').value;
    var fecha=document.getElementById('fecha').value;
    var pmo_id=document.getElementById('pmo_id').value;
    if (cli_id=='' || cli_id==0){
        var cli_id=document.getElementById('clientes').value;
    }

<?php if ($esModificacion=="SI"){ ?>
	opener.location='modifica_orden_trabajo.php?cli_id_seleccion='+cli_id+ '&suc_id='+suc_id+ '&fecha='+fecha
            + '&observaciones='+observaciones+'&realizo='+realizo+'&chk_veh='+chk_veh+'&pmo_id='+pmo_id;
<?php } else { ?>
	opener.location='alta_orden_trabajo.php?cli_id_seleccion='+cli_id+ '&suc_id='+suc_id+ '&fecha='+fecha
            + '&observaciones='+observaciones+ '&realizo='+realizo+ '&chk_veh='+chk_veh+'&pmo_id='+pmo_id;
<?php } ?>
    window.close();
}
</script>
</body>
</html>