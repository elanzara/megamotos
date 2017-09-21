<?php 
include_once 'class/session.php';
include_once 'class/conex.php';
include_once 'class/movimientos_stock.php';
include_once 'class/fechas.php';

//Filtro:
session_start();
if (isset($_GET["limpiar"])){
    if ($_GET["limpiar"]=="S"){
        include_once 'class/fechas.php';
        $fechaNormal = new fechas();
        $_SESSION["search_fecha"]=date('d/m/Y', mktime(0, 0, 0, date('m'),date('d')-2,date('Y')));
        $_SESSION["search_hasta"]=date('d/m/Y', mktime(0, 0, 0, date('m'),date('d'),date('Y')));

        $_SESSION["search_sucursal"]="";
        $_SESSION["search_tipo_producto"]="";
        $_SESSION["search_producto"]="";
//        $_SESSION["search_fecha"]="";
//        $_SESSION["search_hasta"]="";
        $_SESSION["search_cod_mvto"]="";
        $_SESSION["search_cod_prod"]="";
    }
}

if ($_SERVER["REQUEST_METHOD"]=="GET") {
    $search_sucursal = $_SESSION["search_sucursal"];
    $search_tipo_producto = $_SESSION["search_tipo_producto"];
    $search_producto = $_SESSION["search_producto"];
    $search_fecha = $_SESSION["search_fecha"];
    $search_hasta = $_SESSION["search_hasta"];
    $search_cod_mvto = $_SESSION["search_cod_mvto"];
    $search_cod_prod = $_SESSION["search_cod_prod"];
}
if (isset($_POST["sucursales"])){
    $search_sucursal = $_POST["sucursales"];
    $_SESSION["search_sucursal"] = $search_sucursal;
}
if (isset($_POST["tipo_productos"])){
    $search_tipo_producto = $_POST["tipo_productos"];
    $_SESSION["search_tipo_producto"] = $search_tipo_producto;
}
if (isset($_POST["productos"])){
    $search_producto = $_POST["productos"];
    $_SESSION["search_producto"] = $search_producto;
}
if (isset($_POST["fecha"])){
    $search_fecha = $_POST["fecha"];
    $_SESSION["search_fecha"] = $search_fecha;
}
if (isset($_POST["hasta"])){
    $search_hasta = $_POST["hasta"];
    $_SESSION["search_hasta"] = $search_hasta;
}
if (isset($_POST["cod_mvto"])){
    $search_cod_mvto = $_POST["cod_mvto"];
    $_SESSION["search_cod_mvto"] = $search_cod_mvto;
}
if (isset($_POST["cod_prod"])){
    $search_cod_prod = $_POST["cod_prod"];
    $_SESSION["search_cod_prod"] = $search_cod_prod;
}

//echo's:'.$search_sucursal.'t:'.$search_tipo_producto.'p:'.$search_producto;
if (isset($_GET['br'])) {
        //Instancio el objeto
        $mov_id = $_GET['br'];
        $mov=new movimientos_stock($mov_id);
        $mov->set_mov_estado(1);
        $resultado=$mov->baja_mov();
        if ($resultado>0){
                $mensaje="El movimiento stock fue dado de baja correctamente";
        } else {
                $mensaje="El movimiento stock no pudo ser dada de baja";
        }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>MEGAMOTOS - Admin</title>
<link rel="icon" href="images/favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="../imagenes/tu-logo-mitad2.jpg"></link>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>
<body>
<div id="page"> 
 <!--Start HEADER -->
 <?php require_once("header.php") ?>
 <!-- End HEADER -->
  <!--Start CENTRAL -->
 <div id="central">
  <h1>Monitor de Movimientos de Stock </h1>
  <!--Start Tabla  -->
   <table class="form">
    <tr>
    <td>
    <?php
//echo'f:'.$_SESSION["search_fecha"].'-h:'.$_SESSION["search_hasta"];
//echo'tp:'.$_SESSION["search_tipo_producto"].'-p:'.$_SESSION["search_producto"].'-cm:'.$_SESSION["search_cod_mvto"].'-cp:'.$_SESSION["search_cod_prod"];
    //Instancio el objeto
    $link=Conectarse();
    $mov = new movimientos_stock();
    $stock = $mov->getmovimientos_stockSQL($_SESSION["search_sucursal"],$_SESSION["search_tipo_producto"],$_SESSION["search_producto"]
            ,$_SESSION["search_fecha"],$_SESSION["search_hasta"],$_SESSION["search_cod_mvto"],$_SESSION["search_cod_prod"]);
    //Paginacion: 
    //Limito la busqueda
    $TAMANO_PAGINA = 10;
    $_pagi_sql = $stock;
    //cantidad de resultados por página (opcional, por defecto 20)
    $_pagi_cuantos = 10;
    //cantidad de páginas amostrar en la barra de navegación (default = todas)
    $_pagi_nav_num_enlaces = 10;
    //$_pagi_nav_estilo = "navegador";
    //Incluimos el script de paginación. Éste ya ejecuta la consulta automáticamente
    include("class/paginator.inc.php");
    echo "<h3>Listado de movimientos de stock ".$_pagi_info."</h3>";
    //Incluimos la barra de navegación
    echo"<p>".$_pagi_navegacion."</p><br>";
    ?>
    <form action='abm_movimientos_stock.php' method='POST' enctype='multipart/form-data'>
    <table align="center"  border="0">
      <tr>
            <td>Sucursal:</td>
            <td>
                <?php
                include_once 'class/sucursales.php';
                $suc = new sucursales();
                $html = $suc->getsucursalesnuloCombo($search_sucursal);
                echo $html;
                ?>
            </td>
            <td>Tipo Producto:</td>
            <td>
                <?php
                    include_once 'class/tipo_productos.php';
                    $tip = new tipo_productos();
                    $res = $tip->getTipnuloCombo($search_tipo_producto);
                    print $res;
                ?>
            </td>
            <td>Desde:</td>
            <td><input type="text" id="fecha" name="fecha" value="<?php echo $_SESSION["search_fecha"];?>" /></td>
            <td>Hasta:</td>
            <td><input type="text" id="hasta" name="hasta" value="<?php echo $_SESSION["search_hasta"];?>" /></td>
        </tr>
        <tr>
            <td>Producto:</td>
            <td>
                <?php
                 if ($search_tipo_producto!="" and $search_tipo_producto!="0"
                 and $search_tipo_producto!="Elige" and $search_tipo_producto!="Selecciona Opción...") {
                    include_once 'class/productos.php';
                    $pro = new productos();
                    $res = $pro->getproductosCombo($search_producto, $search_tipo_producto);
                    print $res;
                 } else {
                    print '<select disabled="disabled" name="productos" id="productos">';
                    print '<option value="0">Selecciona opci&oacute;n...</option>';
                    print '</select>';
                 }
         ?>
            </td>
            <td>Cod.Prod.:</td>
            <td><input type="text" id="cod_prod" name="cod_prod" value="<?php echo $_SESSION["search_cod_prod"];?>" /></td>
            <td>Cod.Mvto.:</td>
            <td><input type="text" id="cod_mvto" name="cod_mvto" value="<?php echo $_SESSION["search_cod_mvto"];?>" /></td>
            <td colspan="1" align="right"><input type="submit" value="Buscar" />&nbsp;</td>
      </tr>
    </table>
    </form>
    <?php
    print '<table class="form">'
          .'<tr class="rowGris">'
          .'<td class="formTitle" width="40px"><b>CODIGO</b></td>'
          .'<td class="formTitle" width="70px"><b>FECHA</b></td>'
          .'<td class="formTitle" width="120px"><b>SUCURSAL</b></td>'
          .'<td class="formTitle" width="70px"><b>T.MVTO</b></td>'
          .'<td class="formTitle" width="70px"><b>REMITO</b></td>'
          .'<td class="formTitle" width="130px"><b>T.PROD.</b></td>'
          .'<td class="formTitle" width="40px"><b>COD.PRD.</b></td>'
          .'<td class="formTitle"><b>PRODUCTO</b></td>'
          .'<td class="formTitle" width="70px"><b>CANTIDAD</b></td>'
          .'<td class="formTitle" width="100px"><b>SUC.ORIG/DEST.</b></td>'
          .'<td class="formTitle" width="170px"><b>OBSERVACIONES</b></td>'
          .'<td class="formTitle" width="80px"></td>'
          .'</tr>';

    $fechaNormal = new fechas();
    while ($row=mysql_fetch_Array($_pagi_result)) 
    {
     print '<tr class="rowBlanco">'
          .'<td class="formFields">'.$row['encabezado_id'] .'</td>'
          .'<td>'.$fechaNormal->cambiaf_a_normal($row['fecha']).'</td>'
          //.'<td>'.$row['fecha'].'</td>'
          .'<td class="formFields">'.$row['suc_descripcion'] .'</td>'
          .'<td class="formFields">'.$row['tipo_mvto'] .'</td>'
          .'<td class="formFields">'.$row['remito'] .'</td>'
          .'<td class="formFields">'.$row['tip_descripcion'] .'</td>'
          .'<td class="formFields">'.$row['pro_id'] .'</td>'
          //.'<td class="formFields"><a href="" onclick=\'javascript:popup();\'>'.$row['pro_descripcion'] .'</a></td>'
          //.'<td class="formFields"><a href="" onclick="alert(\'Entro por Edu\');">Edu</a></td>'
          .'<td class="formFields"><a href="" onclick="popup('.$row['pro_id'].');">'.$row['pro_descripcion'] .'</a></td>'
          .'<td class="formFields">'.$row['cantidad'] .'</td>'
          .'<td class="formFields">'.$row['suc_destino'] .'</td>'
          .'<td class="formFields">'.$row['observaciones'] .'</td>'
          .'<td class="formFields"><img src="images/print.jpg" width="16" height="16" alt="Imprimir" align="absmiddle" />
              <a href="imprimir_remito.php?mov_id='.$row['mov_id'].'" target="_blank"> Imprimir</a></td>';
     //if ($row['ote_id']==''){
     //   print '<td class="formField"><img src="images/delete.png" alt="Borrar" align="absmiddle" />
     //           <a href="abm_movimientos_stock.php?br='.$row['mov_id'].'">Borrar</a></td>';
     //}else{
     //   print '<td class="formField"></td>';
     //}
    }
    print '</tr></table>';
    ?>
    </td>
    </tr>
    <tr>
    <td class="mensaje">
         <?php
          		if (isset($mensaje)) {
          			echo $mensaje;
          		}
         ?>
    </td>
  </tr>
 </table>
<!--End Tabla -->
 </div>
<!--End CENTRAL -->
  <br clear="all" />
</div>
<script type="text/javascript" src="select_dependientes_tip.js"></script>
<script type="text/javascript">
function popup(pro_id){
//    alert("Entro: " + pro_id);
    window.open('VerProducto.php?pro_id='+pro_id,'Ver datos del producto','scrollbars=No,status=yes,width=600,height=500,left=200,top=150 1');
}
function cerrarPU()
{
	opener.location='abm_orden_trabajo.php';
	window.close();
}

</script>
</body>
</html>