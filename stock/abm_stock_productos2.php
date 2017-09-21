<?php 
include_once 'class/session.php';
include_once 'class/conex.php';
include_once 'class/productos.php';

//Filtro:
session_start();
if ($_SERVER["REQUEST_METHOD"]=="GET") {
    $search_sucursal = $_SESSION["search_sucursal"];
    $search_tipo_producto = $_SESSION["search_tipo_producto"];
    $search_producto = $_SESSION["search_producto"];
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
//echo's:'.$search_sucursal.'t:'.$search_tipo_producto.'p:'.$search_producto;
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
  <h1>Monitor de Stock de Productos </h1>
  <!--Start Tabla  -->
   <table class="form">
    <tr>
    <td>
    <?php
    //Instancio el objeto
    $link=Conectarse();
    $pro = new productos();
    $stock = $pro->getstock_productosSQL($search_sucursal,$search_tipo_producto,$search_producto);
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
    <form action='abm_stock_productos2.php' method='POST' enctype='multipart/form-data'>
    <table align="center"  border="0">
      <tr>
            <td>Sucursal:</td>
            <td>
                <?php
                include_once 'class/sucursales.php'; // incluye las clases
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
            <td>Producto:</td>
            <td>
                <?php
                 if ($search_tipo_producto!="" and $search_tipo_producto!="0"
                 and $search_tipo_producto!="Elige" and $search_tipo_producto!="Selecciona Opción...") {
                    //include_once 'class/productos.php';
                    $pro = new productos();
                    $res = $pro->getproductosCombo($search_producto);
                    print $res;
                 } else {
                    print '<select disabled="disabled" name="productos" id="productos">';
                    print '<option value="0">Selecciona opci&oacute;n...</option>';
                    print '</select>';
                 }
         ?>
            </td>
        <td colspan="1" align="right"><input type="submit" value="Buscar" />&nbsp;</td>
      </tr>
    </table>
    </form>
    <?php
    print '<table class="form">'
          .'<tr class="rowGris">'
          //.'<td class="formTitle"><b>ID</b></td>'
          .'<td width="100px" class="formTitle"><b>SUCURSAL</b></td>'
          .'<td class="formTitle"><b>T.PROD.</b></td>'
          .'<td class="formTitle"><b>DESCRIPCION</b></td>'
          .'<td class="formTitle"><b>MARCA</b></td>'
          .'<td class="formTitle"><b>MODELO</b></td>'
          .'<td class="formTitle"><b>DIAMETRO</b></td>'
          .'<td class="formTitle"><b>ANCHO</b></td>'
          .'<td class="formTitle"><b>ALTO</b></td>'
          .'<td class="formTitle"><b>DISTRIBUCION</b></td>'
          .'<td class="formTitle"><b>ESTADO</b></td>'
          .'<td class="formTitle"><b>CANTIDAD</b></td>'
          .'<td class="formTitle"><b>PRECIO</b></td>'
          .'</tr>';

    while ($row=mysql_fetch_Array($_pagi_result)) 
    {
     print '<tr class="rowBlanco">'
          //.'<td class="formFields">'.$row['pro_id'] .'</td>'
          .'<td class="formFields">'.$row['suc_descripcion'] .'</td>'
          .'<td class="formFields">'.$row['tip_descripcion'] .'</td>'
          .'<td class="formFields">'.$row['pro_descripcion'] .'</td>'
          .'<td class="formFields">'.$row['mar_descripcion'] .'</td>'
          .'<td class="formFields">'.$row['mod_descripcion'] .'</td>'
          .'<td class="formFields">'.$row['pro_med_diametro'] .'</td>'
          .'<td class="formFields">'.$row['pro_med_ancho'] .'</td>'
          .'<td class="formFields">'.$row['pro_med_alto'] .'</td>'
          .'<td class="formFields">'.$row['pro_distribucion'] .'</td>'
          .'<td class="formFields">'.$row['estado'] .'</td>'
          .'<td class="formFields">'.$pro->getCantidadProducto($row['pro_id'],$row['suc_id']) .'</td>'
          .'<td class="formFields">'.$row['pro_precio_costo'] .'</td>';
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
</body>
</html>