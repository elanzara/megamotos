<?php
include_once 'class/session.php';
include_once 'class/conex.php';
include_once 'class/tipo_productos.php'; // incluye las clases
include_once 'class/modelos.php'; // incluye las clases
include_once 'class/marcas.php'; // incluye las clases
include_once 'class/productos.php'; // incluye las clases

$resp = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $select = (isset($_POST['select'])) ?  $_POST['select'] : '';
    $select = str_replace(array("\\", "\""),'',$select);
    /*$select = str_replace(array("\\", "¨", "º", "-", "~",
             "#", "@", "|", "!", "\"",
             "·", "$", "%", "&", "/",
             "(", ")", "?", "'", "¡",
             "¿", "[", "^", "`", "]",
             "+", "}", "{", "¨", "´",
             ">", "< ", ";", ",", ":",
             ".", " "),'',$select);*/
    $from = (isset($_POST['from'])) ?  $_POST['from'] : '';
    $where2 = (isset($_POST['where2'])) ?  $_POST['where2'] : '';
    $where2 = str_replace(array("\\", "\""),'',$where2);
    $orderby = (isset($_POST['orderby'])) ?  $_POST['orderby'] : '';
    /*$orderby = str_replace(array("\\", "¨", "º", "-", "~",
             "#", "@", "|", "!", "\"",
             "·", "$", "%", "&", "/",
             "(", ")", "?", "'", "¡",
             "¿", "[", "^", "`", "]",
             "+", "}", "{", "¨", "´",
             ">", "< ", ";", ",", ":",
             ".", " "),'',$orderby);*/
    $porcentaje = (isset($_POST['porcentaje'])) ? (double) $_POST['porcentaje'] : 0;
    
    $select2 = "select pro_id,pro_precio_costo ";

    $sql = $select2 . $from . $where2 . $orderby;
    //echo'sql:'.$sql;
    $link=Conectarse();
    $consulta= mysql_query($sql,$link);
    $sql2 = "";
    $resultado = 1;
    while($row= mysql_fetch_assoc($consulta)) {
        //$sql2 = "update productos set pro_precio_costo = pro_precio_costo + (pro_precio_costo * ".$porcentaje." / 100) ";
        //$sql2 .= "where pro_id = " . $row['pro_id'] .";";
        //$result=mysql_query($sql2,$link);
        $pro_precio_costo=$row['pro_precio_costo'] + ($row['pro_precio_costo'] * $porcentaje / 100);
        $pro = new productos($row['pro_id']);
        $pro->set_pro_precio_costo($pro_precio_costo);
        $result=$pro->update_PRO();
        if ($result<=0){$resultado = 0;}
    }
    if ($resultado == 1){
        $resp = "Se actualizaron los precios correctamente";
    } else {
        $resp = "Error: No se pudieron actualizar los precios";
    }
    $tip_id = (isset($_POST['tip_id'])) ? (int) $_POST['tip_id'] : 0;
    $mar_id = (isset($_POST['mar_id'])) ? (int) $_POST['mar_id'] : 0;
    $mod_id = (isset($_POST['mod_id'])) ? (int) $_POST['mod_id'] : 0;
    $pro_med_diametro = (isset($_POST['pro_med_diametro'])) ? (int) $_POST['pro_med_diametro'] : 0;
    $pro_med_ancho = (isset($_POST['pro_med_ancho'])) ? (int) $_POST['pro_med_ancho'] : 0;
    $pro_distribucion = (isset($_POST['pro_distribucion'])) ? (int) $_POST['pro_distribucion'] : 0;
    $pro_med_alto = (isset($_POST['pro_med_alto'])) ? (int) $_POST['pro_med_alto'] : 0;
    $pro_clasificacion = (isset($_POST['pro_clasificacion'])) ? $_POST['pro_clasificacion'] : 'T';
    $pro_estado = (isset($_POST['pro_estado'])) ? (int) $_POST['pro_estado'] : -1;
    $tr_id = (isset($_POST['tr_id'])) ? (int) $_POST['tr_id'] : -1;
}//POST

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $tip_id = (isset($_GET['tip_id'])) ? (int) $_GET['tip_id'] : 0;
    $mar_id = (isset($_GET['mar_id'])) ? (int) $_GET['mar_id'] : 0;
    $mod_id = (isset($_GET['mod_id'])) ? (int) $_GET['mod_id'] : 0;
    $pro_med_diametro = (isset($_GET['pro_med_diametro'])) ? (int) $_GET['pro_med_diametro'] : 0;
    $pro_med_ancho = (isset($_GET['pro_med_ancho'])) ? (int) $_GET['pro_med_ancho'] : 0;
    $pro_distribucion = (isset($_GET['pro_distribucion'])) ? (int) $_GET['pro_distribucion'] : 0;
    $pro_med_alto = (isset($_GET['pro_med_alto'])) ? (int) $_GET['pro_med_alto'] : 0;
    $pro_clasificacion = (isset($_GET['pro_clasificacion'])) ? $_GET['pro_clasificacion'] : 'T';
    $pro_estado = (isset($_GET['pro_estado'])) ? (int) $_GET['pro_estado'] : -1;
    $tr_id = (isset($_GET['tr_id'])) ? (int) $_GET['tr_id'] : -1;
    
    // Set the query
    $select = "select p.pro_id
    , p.pro_descripcion
    , p.tip_id
    , tp.tip_descripcion
    , p.mar_id
    , m.mar_descripcion
    , p.mod_id
    , mo.mod_descripcion
    , p.pro_med_diametro as rodado
    , p.pro_med_ancho as ancho
    , p.pro_distribucion as distribucion
    , p.pro_med_alto as lateral
    , p.pro_clasificacion as clasif
    , (case when p.pro_nueva = 1 then 'Nuevo' else 'Usado' end) as estado
    , tr.tr_descripcion
    , p.pro_precio_costo
    , ((COALESCE(tp.tip_3cuotas,0)*p.pro_precio_costo/100)+p.pro_precio_costo) as 3cuotas
    , ((COALESCE(tp.tip_6cuotas,0)*p.pro_precio_costo/100)+p.pro_precio_costo) as 6cuotas
    , ((COALESCE(tp.tip_12cuotas,0)*p.pro_precio_costo/100)+p.pro_precio_costo) as 12cuotas ";
    
    $from = " from productos p
    left join marcas m on p.mar_id = m.mar_id
    left join modelos mo on p.mod_id = mo.mod_id
     left join tipo_rango tr on tr.tr_id = p.tr_id
    , tipo_productos tp ";
    
    $id = "pro_id";
    
    $where2 = " where p.pro_estado = 0 and p.tip_id = tp.tip_id ";
    //p.pro_estado = 0
    //and p.tip_id = tp.tip_id ";
//    and p.mar_id = m.mar_id
//    and p.mod_id = mo.mod_id ";
    
    if ($tip_id > 0){
        $where2 .= " and p.tip_id = ". $tip_id;     
    }
    if ($mar_id > 0){
        $where2 .= " and p.mar_id = ". $mar_id;     
    }
    if ($mod_id > 0){
        $where2 .= " and p.mod_id = ". $mod_id;     
    }
    if ($pro_med_diametro != 'TODOS'){
        $where2 .= " and p.pro_med_diametro = ". $pro_med_diametro;     
    }
    if ($pro_med_ancho != 'TODOS'){
        $where2 .= " and p.pro_med_ancho = ". $pro_med_ancho;     
    }
    if ($pro_distribucion != 'TODOS'){
        $where2 .= " and p.pro_distribucion = ". $pro_distribucion;     
    }
    if ($pro_med_alto != 'TODOS'){
        $where2 .= " and p.pro_med_alto = ". $pro_med_alto;     
    }
    if ($pro_clasificacion != 'T'){
        $where2 .= " and p.pro_clasificacion = '". $pro_clasificacion . "'";     
    }
    if ($pro_estado != -1){
        $where2 .= " and p.pro_nueva = ". $pro_estado;     
    }
    if ($tr_id > 0){
        $where2 .= " and p.tr_id = ". $tr_id;     
    }
    //echo "where2: " . $where2 ."<br>";
    $orderby = " order by tip_descripcion, mar_descripcion, pro_descripcion ";
}

$link=Conectarse();
$sql = $select . $from . $where2 . $orderby;

//Paginacion: 
//Limito la busqueda
$TAMANO_PAGINA = 5;
$_pagi_sql = $sql;
//cantidad de resultados por página (opcional, por defecto 20)
$_pagi_cuantos = 5;
//cantidad de páginas amostrar en la barra de navegación (default = todas)
$_pagi_nav_num_enlaces = 10;
//$_pagi_nav_estilo = "navegador";
//Incluimos el script de paginación. Éste ya ejecuta la consulta automáticamente
include("class/paginator.inc.php");

//echo "sql: " . $sql;
//$consulta= mysql_query($sql,$link);
$tabla = "";
$tabla = "<table>";
$tabla .= "<tr class='rowBlanco'>";
$tabla .= '<td class="formTitle" width="10px" ><b>CODIGO</b></td>';
$tabla .= '<td class="formTitle" width="100px" ><b>PRODUCTO</b></td>';
//$tabla .= '<td width="0px" ></td>';//<b>tip_id</b>
$tabla .= '<td class="formTitle" width="100px" ><b>TIPO</b></td>';
//$tabla .= '<td width="0px" ></td>';//<b>mar_id</b>
$tabla .= '<td class="formTitle" width="100px" ><b>MARCA</b></td>';
//$tabla .= '<td width="0px" ></td>';//<b>mod_id</b>
$tabla .= '<td class="formTitle" width="100px" ><b>MODELO</b></td>';
$tabla .= '<td class="formTitle" width="100px" ><b>ANCHO</b></td>';
$tabla .= '<td class="formTitle" width="100px" ><b>LATERAL</b></td>';
$tabla .= '<td class="formTitle" width="100px" ><b>RODADO</b></td>';
$tabla .= '<td class="formTitle" width="100px" ><b>DISTR.</b></td>';
$tabla .= '<td class="formTitle" width="100px" ><b>CLASIF.</b></td>';
$tabla .= '<td class="formTitle" width="100px" ><b>ESTADO</b></td>';
$tabla .= '<td class="formTitle" width="100px" ><b>T.RANGO</b></td>';
$tabla .= '<td class="formTitle" width="80px" ><b>PRECIO</b></td>';
$tabla .= '<td class="formTitle" width="80px" ><b>3 CUOTAS</b></td>';
$tabla .= '<td class="formTitle" width="80px" ><b>6 CUOTAS</b></td>';
$tabla .= '<td class="formTitle" width="80px" ><b>12 CUOTAS</b></td>';
$tabla .= "</tr>";
while ($row=mysql_fetch_Array($_pagi_result)){
$tabla .=  '<tr class="rowBlanco">';
$tabla .=  '<td class="formFields">'.$row['pro_id'] .'</td>';
$tabla .=  '<td class="formFields">'.$row['pro_descripcion'] .'</td>';
//$tabla .=  '<td class="formFields">'.$row['tip_id'] .'</td>';
$tabla .=  '<td class="formFields">'.$row['tip_descripcion'] .'</td>';
//$tabla .=  '<td class="formFields">'.$row['mar_id'] .'</td>';
$tabla .=  '<td class="formFields">'.$row['mar_descripcion'] .'</td>';
//$tabla .=  '<td class="formFields">'.$row['mod_id'] .'</td>';
$tabla .=  '<td class="formFields">'.$row['mod_descripcion'] .'</td>';

$tabla .=  '<td class="formFields">'.$row['ancho'] .'</td>';
$tabla .=  '<td class="formFields">'.$row['lateral'] .'</td>';
$tabla .=  '<td class="formFields">'.$row['rodado'] .'</td>';
$tabla .=  '<td class="formFields">'.$row['distribucion'] .'</td>';
$tabla .=  '<td class="formFields">'.$row['clasif'] .'</td>';
$tabla .=  '<td class="formFields">'.$row['estado'] .'</td>';
$tabla .=  '<td class="formFields">'.$row['tr_descripcion'] .'</td>';

$tabla .=  '<td class="formFields">'.number_format($row['pro_precio_costo'],2) .'</td>';
$tabla .=  '<td class="formFields">'.number_format($row['3cuotas'],2) .'</td>';
$tabla .=  '<td class="formFields">'.number_format($row['6cuotas'],2) .'</td>';
$tabla .=  '<td class="formFields">'.number_format($row['12cuotas'],2) .'</td>';
$tabla .= "</tr>";
}
$tabla .= "</table>";
/**
/*FIN - Manejo de la grilla
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>MEGAMOTOS - Admin</title>
<link rel="icon" href="images/favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="../imagenes/tu-logo-mitad2.jpg"></link>
<link href="css/admin.css" rel="stylesheet" type="text/css" />
<!--Estilo para la grilla-->
<style>
h1,h2,h3,h4,h5,h6,p {font-size:100%;font-weight:normal; text-align: center; margin: auto;}
h1 {font: normal 18px Arial;color:#b60f1d; margin-bottom:20px; border-bottom: 1px solid #58585a;}
table {
margin: auto;
}
</style>
<!--<link href="table.css" rel="stylesheet" type="text/css"/>-->
<!--FIN - Estilo para la grilla-->
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>
<body>
<div id="page"> 
 <!--Start HEADER -->
 <?php //require_once("header.php") ?>
 <!-- End HEADER -->
  <!--Start CENTRAL -->
 <div id="central">
  <h1>Cambio de precios por lote </h1>
  <!--Start Tabla  -->
<?php
    echo "<h3>Listado de productos ".$_pagi_info."</h3>";
    //Incluimos la barra de navegación
    echo"<p>".$_pagi_navegacion."</p>";
    print $tabla;
?>
<!--End Tabla -->
<!--Formulario carga procentaje-->
<form action="cambio_precio_lote2.php?tip_id=<?php echo $tip_id; ?>&mar_id=<?php echo $mar_id; ?>
      &mod_id=<?php echo $mod_id; ?>&pro_med_diametro=<?php echo $pro_med_diametro; ?>
      &pro_med_ancho=<?php echo $pro_med_ancho; ?>&pro_distribucion=<?php echo $pro_distribucion; ?>
      &pro_med_alto=<?php echo $pro_med_alto; ?>&pro_clasificacion=<?php echo $pro_clasificacion; ?>
      &pro_estado=<?php echo $pro_estado; ?>&tr_id=<?php echo $tr_id; ?>" method="POST">
    <table>
      <tr></tr>
      <tr>
        <td><b>Porcentaje a aplicar:</b></td>
        <td><input type="text" id="porcentaje" name="porcentaje" /></td>
        <td><input type="hidden" id="select" name="select" value="<?php print $select; ?>" /></td>
        <td><input type="hidden" id="from" name="from" value="<?php print $from; ?>" /></td>
        <td><input type="hidden" id="where2" name="where2" value="<?php print $where2; ?>" /></td>
        <td><input type="hidden" id="orderby" name="orderby" value="<?php print $orderby; ?>" /></td>
        <td><input type="submit" class="boton" value="Aplicar" /></td>
        <td><input type="button" class="boton" value="Volver" onclick="cerrarPU();" /></td>
        <td><input type="hidden" id="tip_id" name="tip_id" value="<?php print $tip_id; ?>" /></td>
        <td><input type="hidden" id="mar_id" name="mar_id" value="<?php print $mar_id; ?>" /></td>
        <td><input type="hidden" id="mod_id" name="mod_id" value="<?php print $mod_id; ?>" /></td>
        <td><input type="hidden" id="pro_med_diametro" name="pro_med_diametro" value="<?php print $pro_med_diametro; ?>" /></td>
        <td><input type="hidden" id="pro_med_ancho" name="pro_med_ancho" value="<?php print $pro_med_ancho; ?>" /></td>
        <td><input type="hidden" id="pro_distribucion" name="pro_distribucion" value="<?php print $pro_distribucion; ?>" /></td>
        <td><input type="hidden" id="pro_med_alto" name="pro_med_alto" value="<?php print $pro_med_alto; ?>" /></td>
        <td><input type="hidden" id="pro_clasificacion" name="pro_clasificacion" value="<?php print $pro_clasificacion; ?>" /></td>
        <td><input type="hidden" id="pro_estado" name="pro_estado" value="<?php print $pro_estado; ?>" /></td>
        <td><input type="hidden" id="tr_id" name="tr_id" value="<?php print $tr_id; ?>" /></td>
      </tr>
      <tr>
            <td>
                <?php 
                    if ($resp != ""){
                        print $resp;
                        }
                ?>
            </td>
      </tr>
    </table>
</form>
<!--End Formulario carga procentaje -->
 </div>
</div>
<script type="text/javascript">
function cerrarPU()
{
	opener.location='abm_precios.php';
	window.close();
}
</script>
</body>
</html>