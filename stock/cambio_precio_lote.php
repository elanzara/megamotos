<?php
include_once 'class/session.php';
include_once 'class/conex.php';
include_once 'class/tipo_productos.php'; // incluye las clases
include_once 'class/modelos.php'; // incluye las clases
include_once 'class/marcas.php'; // incluye las clases
include_once 'class/productos.php'; // incluye las clases

$tip_id = (isset($_GET['tip_id'])) ? (int) $_GET['tip_id'] : 0;
$mar_id = (isset($_GET['mar_id'])) ? (int) $_GET['mar_id'] : 0;
$mod_id = (isset($_GET['mod_id'])) ? (int) $_GET['mod_id'] : 0;
$pro_med_diametro = (isset($_GET['pro_med_diametro'])) ? (int) $_GET['pro_med_diametro'] : 0;
$pro_med_ancho = (isset($_GET['pro_med_ancho'])) ? (int) $_GET['pro_med_ancho'] : 0;
$pro_distribucion = (isset($_GET['pro_distribucion'])) ? (int) $_GET['pro_distribucion'] : 0;
$pro_med_alto = (isset($_GET['pro_med_alto'])) ? (int) $_GET['pro_med_alto'] : 0;
/**
/*Manejo de la grilla
 */
 
include_once 'class.eyemysqladap.inc.php';
include_once 'class.eyedatagrid.inc.php';
// Load the database adapter
$db = new EyeMySQLAdap('localhost', 'root', '', 'megallantas2');

// Load the datagrid class
$x = new EyeDataGrid($db, 'images_grilla/');

// Set the query
$select = "p.pro_id
, p.pro_descripcion
, p.tip_id
, tp.tip_descripcion
, p.mar_id
, m.mar_descripcion
, p.mod_id
, mo.mod_descripcion
, p.pro_precio_costo
, ((COALESCE(tp.tip_3cuotas,0)*p.pro_precio_costo/100)+p.pro_precio_costo) as 3cuotas
, ((COALESCE(tp.tip_6cuotas,0)*p.pro_precio_costo/100)+p.pro_precio_costo) as 6cuotas
, ((COALESCE(tp.tip_12cuotas,0)*p.pro_precio_costo/100)+p.pro_precio_costo) as 12cuotas";

$from = "productos p
, tipo_productos tp
, marcas m
, modelos mo";

$id = "pro_id";

$where2 = "p.pro_estado = 0
and p.tip_id = tp.tip_id
and p.mar_id = m.mar_id
and p.mod_id = mo.mod_id";

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
echo "where2: " . $where2 ."<br>";
$orderby = "tip_descripcion, mar_descripcion, pro_descripcion";

//$x->setQuery($select, $from, $id, $where2);
$x->setQuery($select, $from, $id);
//$x->setOrder($orderby);

// Allows filters
//$x->allowFilters();

// Change headers text
//$x->setColumnHeader('FirstName', 'First Name');
//$x->setColumnHeader('LastName', 'Last Name');
$x->setColumnHeader('pro_id', 'ID');
$x->setColumnHeader('pro_descripcion', 'PRODUCTO');
$x->setColumnHeader('tip_descripcion', 'TIPO PRODUCTO');
$x->setColumnHeader('mar_descripcion', 'MARCA');
$x->setColumnHeader('mod_descripcion', 'MODELO');
$x->setColumnHeader('pro_precio_costo', 'EFECTIVO');
$x->setColumnHeader('3cuotas', '3 CUOTAS');
$x->setColumnHeader('6cuotas', '6 CUOTAS');
$x->setColumnHeader('12cuotas', '12 CUOTAS');

// Hide ID Column
//$x->hideColumn('Id');
$x->hideColumn('tip_id');
$x->hideColumn('mar_id');
$x->hideColumn('mod_id');


// Change column type
//$x->setColumnType('FirstName', EyeDataGrid::TYPE_HREF, 'http://google.com/search?q=%FirstName%'); // Google Me!
//$x->setColumnType('BirthDate', EyeDataGrid::TYPE_DATE, 'M d, Y', true); // Change the date format
//$x->setColumnType('Gender', EyeDataGrid::TYPE_ARRAY, array('m' => 'Male', 'f' => 'Female')); // Convert db values to something better
$x->setColumnType('pro_precio_costo', EyeDataGrid:: TYPE_DOLLAR, false, array('Back' => '#c3daf9', 'Fore' => 'black'));
$x->setColumnType('3cuotas', EyeDataGrid:: TYPE_DOLLAR, false, array('Back' => '#c3daf9', 'Fore' => 'black'));
$x->setColumnType('6cuotas', EyeDataGrid:: TYPE_DOLLAR, false, array('Back' => '#c3daf9', 'Fore' => 'black'));
$x->setColumnType('12cuotas', EyeDataGrid:: TYPE_DOLLAR, false, array('Back' => '#c3daf9', 'Fore' => 'black'));


// Show reset grid control
$x->showReset();

// Add custom control, order does matter
//$x->addCustomControl(EyeDataGrid::CUSCTRL_TEXT, "alert('%FirstName%\'s been promoted!')", EyeDataGrid::TYPE_ONCLICK, 'Promote Me');

// Add standard control
//$x->addStandardControl(EyeDataGrid::STDCTRL_EDIT, "alert('Editar %pro_descripcion% (ID: %pro_id%)')");
//$x->addStandardControl(EyeDataGrid::STDCTRL_EDIT, "window.open('modifica_precio.php?pro_id=%pro_id%&pro_descripcion=%pro_descripcion%&pro_precio_costo=%pro_precio_costo%','Modificar precio','scrollbars=No,status=yes,width=500,height=180,left=400,top=300 1')");
//$x->addStandardControl(EyeDataGrid::STDCTRL_DELETE, "alert('Deleting %_P%')");


// Add create control
//$x->showCreateButton("alert('Code for creating a new person')", EyeDataGrid::TYPE_ONCLICK, 'Add New Person');

// Show checkboxes
//$x->showCheckboxes();

// Show row numbers
//$x->showRowNumber();

// Apply a function to a row
function returnSomething($lastname)
{
	return strrev($lastname);
}
//$x->setColumnType('LastName', EyeDataGrid::TYPE_FUNCTION, 'returnSomething', '%LastName%');

if (EyeDataGrid::isAjaxUsed())
{
	$x->printTable($where2);
	exit;
}
/**
/*FIN - Manejo de la grilla
 */
//echo "select: " . $select . "<br>";
//echo "from: " . $from . "<br>";
//echo "where: " . $where . "<br>";


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>MEGAMOTOS - Admin</title>
<link rel="icon" href="images/favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="../imagenes/tu-logo-mitad2.jpg"></link>
<!--Estilo para la grilla-->
<style>
h1,h2,h3,h4,h5,h6 {font-size:100%;font-weight:normal;}
h1 {font: normal 18px Arial;color:#b60f1d; margin-bottom:20px; border-bottom: 1px solid #58585a;}
</style>
<link href="table.css" rel="stylesheet" type="text/css"/>
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
<?PHP
EyeDataGrid::useAjaxTable();
?>  
<!--End Tabla -->
 </div>
</div>
</body>
</html>




