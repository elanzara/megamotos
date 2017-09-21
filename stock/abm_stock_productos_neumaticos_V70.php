<?php 
include_once 'class/session.php';
include_once 'class/conex.php';
include_once 'class/tipo_productos.php'; // incluye las clases
include_once 'class/modelos.php'; // incluye las clases
include_once 'class/marcas.php'; // incluye las clases
include_once 'class/productos.php'; // incluye las clases

$mod_id=0;
$mar_id=0;
$tip_id=0;

//$search_sucursal = 2;
//$suc_id = 2;

$suc_id = '';
if (isset($_POST["sucursales"])){
    $search_sucursal = $_POST["sucursales"];
}
if (isset($_GET["suc_id"])){
    $suc_id = $_GET["suc_id"];
}
if ($suc_id == ''){
    $suc_id = 2;
}
/**
/*Manejo de la grilla
 */
 
include_once 'class.eyemysqladap.inc.php';
include_once 'class.eyedatagrid.inc.php';
// Load the database adapter
//DESCOMENTAR PARA PASAR A JEDU
//$db = new EyeMySQLAdap('127.0.0.1:3307', 'megallantas2', 'moni2012', 'megallantas2');
/*$db = new EyeMySQLAdap('127.0.0.1:3307', 'root', '', 'megallantas2');

// Load the datagrid class
$x = new EyeDataGrid($db, 'images_grilla/');

$x->setResultsPerPage(20);*/

//$select = "(select tip_descripcion from tipo_productos tp where tp.tip_id = p.tip_id)
//, p.pro_med_ancho
//, p.pro_med_alto
//, p.pro_med_diametro
//, (select tr.tr_descripcion from tipo_rango tr where tr.tr_id = p.tr_id)
//, (select ma.mar_descripcion from marcas ma where ma.mar_id = p.mar_id)
//, (select mo.mod_descripcion from modelos mo where mo.mod_id = p.mod_id)
//, (case p.pro_nueva when 1 then 'Nuevo' else 'Usado' end) as pro_nueva
//, (select s.suc_descripcion from sucursales s where s.suc_id = su.suc_id)
//, su.suc_id
//, (select ifnull(sum(cast(m.cantidad as signed)*(case m.tim_id when 1 then 1 else (-1) end)),0)
//            from movimientos_stock m
//            where m.estado=0
//            and m.pro_id = p.pro_id
//            and m.suc_id = su.suc_id) as cantidad
//, p.pro_precio_costo
//, ((COALESCE((select tp.tip_3cuotas from tipo_productos tp where tp.tip_id = p.tip_id),0)*p.pro_precio_costo/100)+p.pro_precio_costo) as 3cuotas
//, ((COALESCE((select tp.tip_6cuotas from tipo_productos tp where tp.tip_id = p.tip_id),0)*p.pro_precio_costo/100)+p.pro_precio_costo) as 6cuotas
//, ((COALESCE((select tp.tip_12cuotas from tipo_productos tp where tp.tip_id = p.tip_id),0)*p.pro_precio_costo/100)+p.pro_precio_costo) as 12cuotas
//, p.pro_foto
//, p.pro_descripcion
//, p.pro_id
//, p.pro_distribucion
//
//";
// //as ESTADO
//$from = "productos p, sucursales su";//, tipo_productos tp";
//$where = "p.pro_estado = 0 and p.pro_controla_stock = 'S'";
//$where .= " and (select ifnull(sum(cast(m.cantidad as signed)*(case m.tim_id when 1 then 1 else (-1) end)),0)
//            from movimientos_stock m
//            where m.estado=0
//            and m.pro_id = p.pro_id
//            and m.suc_id = su.suc_id) > 0";
//$where .= " and p.tip_id in (4) ";
////, p.tip_id = tp.tip_id";
//$_SESSION["FILTROS"] = array("(select tip_descripcion from tipo_productos tp where tp.tip_id = p.tip_id)"
//, "pro_med_ancho"
//, "pro_med_alto"
//, "pro_med_diametro"
//, "(select tr.tr_descripcion from tipo_rango tr where tr.tr_id = p.tr_id)"
//, "(select ma.mar_descripcion from marcas ma where ma.mar_id = p.mar_id)"
//, "(select mo.mod_descripcion from modelos mo where mo.mod_id = p.mod_id)"
//, "(select s.suc_descripcion from sucursales s where s.suc_id = su.suc_id)"
//, "cantidad"
//, "pro_precio_costo"
//, "3cuotas"
//, "6cuotas"
//, "12cuotas"
//, "pro_descripcion"
//, "pro_id"
//, "pro_nueva");
////, "(case p.pro_nueva when 1 then \"Nuevo\" else \"Usado\" end)"
////, "(case p.pro_nueva when 1 then 'Nuevo' else 'Usado' end)"
////(select tip_descripcion from tipo_productos tp where tp.tip_id = p.tip_id),
$select = "p.pro_med_ancho
, p.pro_med_alto
, p.pro_med_diametro
, (select tr.tr_descripcion from tipo_rango tr where tr.tr_id = p.tr_id)
, (select ma.mar_descripcion from marcas ma where ma.mar_id = p.mar_id)
, (select mo.mod_descripcion from modelos mo where mo.mod_id = p.mod_id)
, (case p.pro_nueva when 1 then 'Nuevo' else 'Usado' end) as pro_nueva
, p.pro_id as cantidad_Chacarita
, p.pro_id as cantidad_Taller
, p.pro_id as cantidad_Caseros
, p.pro_id as cantidad_Forest
, p.pro_precio_costo
, ((COALESCE((select tp.tip_3cuotas from tipo_productos tp where tp.tip_id = p.tip_id),0)*p.pro_precio_costo/100)+p.pro_precio_costo) as 3cuotas
, ((COALESCE((select tp.tip_6cuotas from tipo_productos tp where tp.tip_id = p.tip_id),0)*p.pro_precio_costo/100)+p.pro_precio_costo) as 6cuotas
, ((COALESCE((select tp.tip_12cuotas from tipo_productos tp where tp.tip_id = p.tip_id),0)*p.pro_precio_costo/100)+p.pro_precio_costo) as 12cuotas
, p.pro_foto
, p.pro_descripcion
, p.pro_id
, p.pro_distribucion
";

//, p.pro_id as cantidad_Palermo
$from = "productos p";
$where = "p.pro_estado = 0 and p.pro_controla_stock = 'S'";
$where .= " and (
(select ifnull(sum(cast(m.cantidad as signed)*(case m.tim_id when 1 then 1 else (-1) end)),0)
            from movimientos_stock m
            where m.estado=0
            and m.pro_id = p.pro_id
            and m.suc_id = 1) > 0
or
(select ifnull(sum(cast(m.cantidad as signed)*(case m.tim_id when 1 then 1 else (-1) end)),0)
            from movimientos_stock m
            where m.estado=0
            and m.pro_id = p.pro_id
            and m.suc_id = 2) > 0
or
(select ifnull(sum(cast(m.cantidad as signed)*(case m.tim_id when 1 then 1 else (-1) end)),0)
            from movimientos_stock m
            where m.estado=0
            and m.pro_id = p.pro_id
            and m.suc_id = 4) > 0
or
(select ifnull(sum(cast(m.cantidad as signed)*(case m.tim_id when 1 then 1 else (-1) end)),0)
            from movimientos_stock m
            where m.estado=0
            and m.pro_id = p.pro_id
            and m.suc_id = 5) > 0
)";
$where .= " and p.tip_id in (4) ";

//or
//(select ifnull(sum(cast(m.cantidad as signed)*(case m.tim_id when 1 then 1 else (-1) end)),0)
//            from movimientos_stock m
//            where m.estado=0
//            and m.pro_id = p.pro_id
//            and m.suc_id = 3) > 0
$_SESSION["FILTROS"] = array(/*"(select tip_descripcion from tipo_productos tp where tp.tip_id = p.tip_id)"
,*/ "pro_med_ancho"
, "pro_med_alto"
, "pro_med_diametro"
, "(select tr.tr_descripcion from tipo_rango tr where tr.tr_id = p.tr_id)"
, "(select ma.mar_descripcion from marcas ma where ma.mar_id = p.mar_id)"
, "(select mo.mod_descripcion from modelos mo where mo.mod_id = p.mod_id)"
, "cantidad_Chacarita"
, "cantidad_Taller"
, "cantidad_Caseros"
, "cantidad_Forest"
, "pro_precio_costo"
, "3cuotas"
, "6cuotas"
, "12cuotas"
, "pro_descripcion"
, "pro_id"
, "pro_nueva");

//, "cantidad_Palermo"
/*$count = count($_SESSION["FILTROS"]);
echo "COUNT: ".$count."<br>";
//, "(case p.pro_nueva when 1 then 'Nuevo' else 'Usado' end)"

for ($i = 0; $i < $count; $i++) {
    $filtro = $_SESSION["FILTROS"][$i];
    echo "Filtro $i: ".$filtro."<br>";
}*/

// Load the database adapter
//DESCOMENTAR PARA PASAR A JEDU
$db = new EyeMySQLAdap('127.0.0.1:3307', '209583-mega', 'i810vgt', '209583_mega');
//$db = new EyeMySQLAdap('127.0.0.1:3307', 'megallantas2', 'moni2012', 'megallantas2');
//$db = new EyeMySQLAdap('127.0.0.1:3307', 'root', '', 'megallantas2');

// Load the datagrid class
$x = new EyeDataGrid($db, 'images_grilla/');
$x->setResultsPerPage(20);

$x->setQuery($select, $from, $id, $where);
//$x->setOrderBy("suc_id asc, pro_id asc ");
////$x->setOrderBy("2, 3, 5, 6, 7, 9, 10, 11");
$x->setOrderBy("1, 6, 7, 8");
// Allows filters
$x->allowFilters();
// Change headers text
////$x->setColumnHeader('FirstName', 'First Name');
////$x->setColumnHeader('LastName', 'Last Name');
////$x->setColumnHeader('(select s.suc_descripcion from sucursales s where s.suc_id = '.$suc_id.')', 'SUCURSAL');
//$x->setColumnHeader('(select s.suc_descripcion from sucursales s where s.suc_id = su.suc_id)', 'SUCURSAL');
//$x->setColumnHeader('pro_id', 'CODIGO');
//$x->setColumnHeader('(select tip_descripcion from tipo_productos tp where tp.tip_id = p.tip_id)', 'TIPO PRODUCTO');
//$x->setColumnHeader('(select ma.mar_descripcion from marcas ma where ma.mar_id = p.mar_id)', 'MARCA');
//$x->setColumnHeader('(select mo.mod_descripcion from modelos mo where mo.mod_id = p.mod_id)', 'MODELO');
//$x->setColumnHeader('pro_med_diametro','RODADO');
//$x->setColumnHeader('(select tr.tr_descripcion from tipo_rango tr where tr.tr_id = p.tr_id)','RANGO');
////$x->setColumnHeader('pro_distribucion','DISTRIBUCION');
//$x->setColumnHeader('pro_descripcion', 'PRODUCTO');
////$x->setColumnHeader("(case p.pro_nueva when 1 then 'Nuevo' else 'Usado' end)",'ESTADO');
//$x->setColumnHeader("pro_nueva",'ESTADO');
//$x->setColumnHeader('cantidad','CANTIDAD');
////$x->setColumnHeader('((COALESCE((select tp.tip_3cuotas from tipo_productos tp where tp.tip_id = p.tip_id),0)*p.pro_precio_costo/100)+p.pro_precio_costo)','3 CUOTAS');
////$x->setColumnHeader('((COALESCE((select tp.tip_6cuotas from tipo_productos tp where tp.tip_id = p.tip_id),0)*p.pro_precio_costo/100)+p.pro_precio_costo)','6 CUOTAS');
////$x->setColumnHeader('((COALESCE((select tp.tip_12cuotas from tipo_productos tp where tp.tip_id = p.tip_id),0)*p.pro_precio_costo/100)+p.pro_precio_costo)','12 CUOTAS');
//$x->setColumnHeader('pro_precio_costo', 'EFECTIVO');
//$x->setColumnHeader('3cuotas','3 CUOTAS');
//$x->setColumnHeader('6cuotas','6 CUOTAS');
//$x->setColumnHeader('12cuotas','12 CUOTAS');
//$x->setColumnHeader('pro_med_ancho','ANCHO');
//$x->setColumnHeader('pro_med_alto','ALTO');
//$x->setColumnHeader('pro_foto','FOTO');
////$x->setColumnHeader("(case p.pro_nueva when 1 then 'Nuevo' else 'Usado' end)",'ESTADO');
//$x->setColumnHeader('(select s.suc_descripcion from sucursales s where s.suc_id = su.suc_id)', 'SUCURSAL');
////$x->setColumnHeader('(select tip_descripcion from tipo_productos tp where tp.tip_id = p.tip_id)', 'TIPO PRODUCTO');
$x->setColumnHeader('(select ma.mar_descripcion from marcas ma where ma.mar_id = p.mar_id)', 'MARCA');
$x->setColumnHeader('(select mo.mod_descripcion from modelos mo where mo.mod_id = p.mod_id)', 'MODELO');
$x->setColumnHeader('pro_med_diametro','RODADO');
$x->setColumnHeader('(select tr.tr_descripcion from tipo_rango tr where tr.tr_id = p.tr_id)','RANGO');
$x->setColumnHeader("pro_nueva",'ESTADO');
$x->setColumnHeader('cantidad_Chacarita','CANT. CHACARITA');
//$x->setColumnHeader('cantidad_Palermo','CANT. PALERMO');
$x->setColumnHeader('cantidad_Taller','CANT. TALLER');
$x->setColumnHeader('cantidad_Caseros','CANT. CASEROS');
$x->setColumnHeader('cantidad_Forest','CANT. FOREST');
$x->setColumnHeader('cantidad','CANTIDAD');
$x->setColumnHeader('pro_precio_costo', 'EFECTIVO');
$x->setColumnHeader('3cuotas','3 CUOTAS');
$x->setColumnHeader('6cuotas','6 CUOTAS');
$x->setColumnHeader('12cuotas','12 CUOTAS');
$x->setColumnHeader('pro_med_ancho','ANCHO');
$x->setColumnHeader('pro_med_alto','ALTO');
$x->setColumnHeader('pro_foto','FOTO');
$x->setColumnHeader('pro_descripcion', 'PRODUCTO');
$x->setColumnHeader('pro_id', 'CODIGO');

// Hide ID Column
//$x->hideColumn('Id');
//$x->hideColumn('tip_id');
//$x->hideColumn('mar_id');
//$x->hideColumn('mod_id');
//$x->hideColumn('pro_foto');
////$x->hideColumn('suc_id');
//$x->hideColumn('(select tr.tr_descripcion from tipo_rango tr where tr.tr_id = p.tr_id)');
$x->hideColumn('pro_distribucion');


// Change column type
//$x->setColumnType('FirstName', EyeDataGrid::TYPE_HREF, 'http://google.com/search?q=%FirstName%'); // Google Me!
//$x->setColumnType('BirthDate', EyeDataGrid::TYPE_DATE, 'M d, Y', true); // Change the date format
//$x->setColumnType('Gender', EyeDataGrid::TYPE_ARRAY, array('m' => 'Male', 'f' => 'Female')); // Convert db values to something better


$x->setColumnType('pro_precio_costo', EyeDataGrid:: TYPE_DOLLAR, false, array('Back' => '#c3daf9', 'Fore' => 'black'));
$x->setColumnType('cantidad', EyeDataGrid:: TYPE_NUMBER, false, array('Back' => '#c3daf9', 'Fore' => 'black'));
$x->setColumnType('3cuotas', EyeDataGrid:: TYPE_DOLLAR, false, array('Back' => '#c3daf9', 'Fore' => 'black'));
$x->setColumnType('6cuotas', EyeDataGrid:: TYPE_DOLLAR, false, array('Back' => '#c3daf9', 'Fore' => 'black'));
$x->setColumnType('12cuotas', EyeDataGrid:: TYPE_DOLLAR, false, array('Back' => '#c3daf9', 'Fore' => 'black'));
$x->setColumnType('pro_foto', EyeDataGrid::TYPE_IMAGE,"%pro_foto%"); // Google Me!
//self::TYPE_IMAGE

// Show reset grid control
$x->showReset();

// Add custom control, order does matter
//$x->addCustomControl(EyeDataGrid::CUSCTRL_TEXT, "alert('%FirstName%\'s been promoted!')", EyeDataGrid::TYPE_ONCLICK, 'Promote Me');

// Add standard control
//$x->addStandardControl(EyeDataGrid::STDCTRL_EDIT, "alert('Editar %pro_descripcion% (ID: %pro_id%)')");
//$x->addStandardControl(EyeDataGrid::STDCTRL_EDIT, "window.open('modifica_precio.php?pro_id=%pro_id%&pro_descripcion=%pro_descripcion%&pro_precio_costo=%pro_precio_costo%&tipo=%TIPO%','Modificar precio','scrollbars=No,status=yes,width=500,height=180,left=400,top=300 1')");
//$x->addStandardControl(EyeDataGrid::STDCTRL_DELETE, "alert('Deleting %_P%')");

//Agregar imagen
//$x->addCustomControl(EyeDataGrid::CUSCTRL_IMAGE,"","","","images/%pro_foto%");//%pro_foto%");
//$x->addStandardControl(EyeDataGrid::CUSCTRL_IMAGE,"","","","%pro_foto%");


// Add create control
//$x->showCreateButton("alert('Code for creating a new person')", EyeDataGrid::TYPE_ONCLICK, 'Add New Person');

// Show checkboxes
//$x->showCheckboxes();

// Show row numbers
//$x->showRowNumber();

//$_SESSION["FILTROS"] = $x->setArrayFiltro();
// Apply a function to a row
function returnSomething($lastname)
{
	return strrev($lastname);
}
//$x->setColumnType('LastName', EyeDataGrid::TYPE_FUNCTION, 'returnSomething', '%LastName%');

if (EyeDataGrid::isAjaxUsed())
{
	$x->printTableNeu();
	exit;
}
/**
/*FIN - Manejo de la grilla
 */


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>MEGALLANTAS - Admin</title>
<link rel="shortcut icon" href="../imagenes/tu-logo-mitad2.jpg"></link>
<!--Estilo para la grilla-->
<link href="table.css" rel="stylesheet" type="text/css"/>
<!--FIN - Estilo para la grilla-->
<!-- AGREGADO PARA EL LIGTHBOX-->
<script type="text/javascript" src="lib/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="lib/jquery.jcarousel.min.js"></script>
<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />
<script src="js/prototype.js" type="text/javascript"></script>
<script type="text/javascript" src="js/scriptaculous.js?load=effects,builder"></script>
<script src="js/lightbox.js" type="text/javascript"></script>
<!--FIN - ESTILOS Y LIBRERIAS PARA EL LIGHT BOX-->

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>
<body>
<div id="page"> 
 <!--Start HEADER -->
 <?php require_once("header.php") ?>
 <!-- End HEADER -->
  <!--Start CENTRAL -->
 <div id="central">
  <h1>.:Monitor de Stock - NEUMATICOS:. </h1>
<!--    <table>
        <tr>
            <td>Sucursal:</td>
            <td>
                <?php
/*                include_once 'class/sucursales.php'; // incluye las clases
                $suc = new sucursales();
                $html = $suc->getsucursalesCombo($suc_id);
                echo $html;*/
                ?>
            </td>
        </tr>
    </table>
||>
  <!--Start Tabla  -->
<?PHP
EyeDataGrid::useAjaxTable();
?>  
<!--End Tabla -->
 </div>
<!--End CENTRAL -->
</div>
<script type="text/javascript" src="select_dependientes.js"></script>
<script>
function seleccionar(suc_id){
    //var posicion=document.getElementById('tipo_productos').options.selectedIndex.value; 
var tip_id=document.getElementById('tipo_productos').value;
var mar_id=document.getElementById('marcas').value;
var mod_id=document.getElementById('modelos').value;
var pro_med_diametro=document.getElementById('rodados').value;
var pro_med_ancho=document.getElementById('anchos').value;
var pro_distribucion=document.getElementById('distribucion').value;
var pro_med_alto=document.getElementById('lateral').value;
window.open('cambio_precio_lote2.php?tip_id='+tip_id+'&mar_id='+mar_id+'&mod_id='+mod_id+'&pro_med_diametro='+pro_med_diametro+'&pro_med_ancho='+pro_med_ancho+'&pro_distribucion='+pro_distribucion+'&pro_med_alto='+pro_med_alto,'Modificar precio por lote','scrollbars=No,status=yes,width=1150,height=400,left=200,top=150 1');
    
/*    if (posicion==2 || posicion==9){
        window.open('seleccion_producto.php?tip_id='+posicion+'&suc_id='+suc_id,'Selecciona producto','scrollbars=No,status=yes,width=1000,height=400,left=200,top=150 1');    
    } else if(posicion==4){
        window.open('seleccion_producto_neum.php?tip_id='+posicion+'&suc_id='+suc_id,'Selecciona producto','scrollbars=No,status=yes,width=1000,height=400,left=200,top=150 1');
    } else {
        window.open('seleccion_producto_gral.php?tip_id='+posicion+'&suc_id='+suc_id,'Selecciona producto','scrollbars=No,status=yes,width=1000,height=400,left=200,top=150 1');
    }
    //window.open('seleccion_producto.php?tip_id='+posicion,'Selecciona producto','scrollbars=No,status=yes,width=1000,height=400,left=200,top=150 1');
*/
}

function filtrar(){
    var suc_id=document.getElementById('sucursales').value;
    location.href = 'abm_stock_productos3.php?suc_id='+suc_id;
    //window.open('abm_stock_productos3.php?suc_id='+suc_id,'Stock de productos','scrollbars=No,status=yes,width=1150,height=400,left=200,top=150 1');
}
</script>

</body>
</html>