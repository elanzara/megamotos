<?php
require 'class.eyemysqladap.inc.php';
require 'class.eyedatagrid.inc.php';

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
, 0 3cuotas
, 0 6cuotas
, 0 12cuotas";

$from = "productos p
, tipo_productos tp
, marcas m
, modelos mo";

$id = "pro_id";

$where = "p.pro_estado = 0
and p.tip_id = tp.tip_id
and p.mar_id = m.mar_id
and p.mod_id = mo.mod_id";

$orderby = "tip_descripcion, mar_descripcion, pro_descripcion";

$x->setQuery($select, $from, $id, $where);

//$x->setOrder($orderby);

// Allows filters
$x->allowFilters();

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
//$x->setColumnType('Done', EyeDataGrid::TYPE_PERCENT, false, array('Back' => '#c3daf9', 'Fore' => 'black'));

// Show reset grid control
$x->showReset();

// Add custom control, order does matter
//$x->addCustomControl(EyeDataGrid::CUSCTRL_TEXT, "alert('%FirstName%\'s been promoted!')", EyeDataGrid::TYPE_ONCLICK, 'Promote Me');

// Add standard control
//$x->addStandardControl(EyeDataGrid::STDCTRL_EDIT, "alert('Editing %LastName%, %FirstName% (ID: %_P%)')");
//$x->addStandardControl(EyeDataGrid::STDCTRL_DELETE, "alert('Deleting %_P%')");


// Add create control
//$x->showCreateButton("alert('Code for creating a new person')", EyeDataGrid::TYPE_ONCLICK, 'Add New Person');

// Show checkboxes
//$x->showCheckboxes();

// Show row numbers
$x->showRowNumber();

// Apply a function to a row
function returnSomething($lastname)
{
	return strrev($lastname);
}
//$x->setColumnType('LastName', EyeDataGrid::TYPE_FUNCTION, 'returnSomething', '%LastName%');

if (EyeDataGrid::isAjaxUsed())
{
	$x->printTable();
	exit;
}
?>
<html>
<head>
<title>prueba Megallantas</title>
<link href="table.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php
// Print the table
EyeDataGrid::useAjaxTable();
?>
</body>
</html>