<?php 
include_once 'class/session.php';
include_once 'class/conex.php';
include_once 'class/tipo_productos.php'; // incluye las clases
include_once 'class/modelos.php'; // incluye las clases
include_once 'class/marcas.php'; // incluye las clases
include_once 'class/productos.php'; // incluye las clases
include_once 'class/tipo_rango.php'; // incluye las clases

$mod_id=0;
$mar_id=0;
$tip_id=0;
/**
/*Manejo de la grilla
 */
 
include_once 'class.eyemysqladap.inc.php';
include_once 'class.eyedatagrid.inc.php';
// Load the database adapter
//DESCOMENTAR PARA PASAR A JEDU
//$db = new EyeMySQLAdap('127.0.0.1:3307', 'megallantas2', 'moni2012', 'megallantas2');
//$db = new EyeMySQLAdap('127.0.0.1:3307', 'root', '', 'megallantas2');
$db = new EyeMySQLAdap('localhost', '226741-megamotos', 'i810vgt01', '226741_megamotos');

// Load the datagrid class
$x = new EyeDataGrid($db, 'images_grilla/');

$select = "p.pro_id
, p.pro_descripcion
, (select tip_descripcion from tipo_productos tp where tp.tip_id = p.tip_id)
, (select ma.mar_descripcion from marcas ma where ma.mar_id = p.mar_id)
, (select mo.mod_descripcion from modelos mo where mo.mod_id = p.mod_id)
, p.pro_med_ancho
, p.pro_med_alto
, p.pro_med_diametro
, (select tr.tr_descripcion from tipo_rango tr where tr.tr_id = p.tr_id)
, p.pro_distribucion
, (case p.pro_nueva when 1 then 'Nuevo' else 'Usado' end) as pro_nueva
, p.pro_precio_costo
, ((COALESCE((select tp.tip_3cuotas from tipo_productos tp where tp.tip_id = p.tip_id),0)*p.pro_precio_costo/100)+p.pro_precio_costo) as 3cuotas
, ((COALESCE((select tp.tip_6cuotas from tipo_productos tp where tp.tip_id = p.tip_id),0)*p.pro_precio_costo/100)+p.pro_precio_costo) as 6cuotas
, ((COALESCE((select tp.tip_12cuotas from tipo_productos tp where tp.tip_id = p.tip_id),0)*p.pro_precio_costo/100)+p.pro_precio_costo) as 12cuotas";

$from = "productos p";//, tipo_productos tp";
$where = "p.pro_estado = 0";
//, p.tip_id = tp.tip_id";


/*FILTROS*/
$_SESSION["FILTROS"] = array("pro_id"
, "pro_descripcion"
, "(select tip_descripcion from tipo_productos tp where tp.tip_id = p.tip_id)"
, "(select ma.mar_descripcion from marcas ma where ma.mar_id = p.mar_id)"
, "(select mo.mod_descripcion from modelos mo where mo.mod_id = p.mod_id)"
, "pro_med_ancho"
, "pro_med_alto"
, "pro_med_diametro"
, "(select tr.tr_descripcion from tipo_rango tr where tr.tr_id = p.tr_id)"
, "pro_distribucion"
, "pro_precio_costo"
, "3cuotas"
, "6cuotas"
, "12cuotas"
);
/*END - FILTROS*/



$x->setQuery($select, $from, $id, $where);

//$x->setOrder($orderby);

// Allows filters
$x->allowFilters();

// Change headers text
//$x->setColumnHeader('FirstName', 'First Name');
//$x->setColumnHeader('LastName', 'Last Name');
$x->setColumnHeader('pro_id', 'CODIGO');
$x->setColumnHeader('pro_descripcion', 'PRODUCTO');
$x->setColumnHeader('(select tip_descripcion from tipo_productos tp where tp.tip_id = p.tip_id)', 'TIPO PRODUCTO');
$x->setColumnHeader('(select ma.mar_descripcion from marcas ma where ma.mar_id = p.mar_id)', 'MARCA');
$x->setColumnHeader('(select mo.mod_descripcion from modelos mo where mo.mod_id = p.mod_id)', 'MODELO');
$x->setColumnHeader('pro_precio_costo', 'EFECTIVO');
$x->setColumnHeader('3cuotas', '3 CUOTAS');
$x->setColumnHeader('6cuotas', '6 CUOTAS');
$x->setColumnHeader('12cuotas', '12 CUOTAS');
$x->setColumnHeader('pro_med_ancho','ANCHO');
$x->setColumnHeader('pro_med_alto','ALTO');
$x->setColumnHeader('pro_med_diametro','DIAMETRO');
$x->setColumnHeader('pro_distribucion','DISTRIBUCION');
$x->setColumnHeader('(select tr.tr_descripcion from tipo_rango tr where tr.tr_id = p.tr_id)','RANGO');
$x->setColumnHeader('pro_nueva','ESTADO');

// Hide ID Column
//$x->hideColumn('Id');
//$x->hideColumn('tip_id');
//$x->hideColumn('mar_id');
//$x->hideColumn('mod_id');
//$x->hideColumn('pro_foto');


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
$x->addStandardControl(EyeDataGrid::STDCTRL_EDIT, "window.open('modifica_precio.php?pro_id=%pro_id%&pro_descripcion=%pro_descripcion%&pro_precio_costo=%pro_precio_costo%&tipo=%TIPO%','Modificar precio','scrollbars=No,status=yes,width=500,height=180,left=400,top=300 1')");
//$x->addStandardControl(EyeDataGrid::STDCTRL_DELETE, "alert('Deleting %_P%')");

//Agregar imagen
//$x->addCustomControl(EyeDataGrid::CUSCTRL_IMAGE,"","","","%pro_foto%");
//$x->addStandardControl(EyeDataGrid::CUSCTRL_IMAGE,"","","","%pro_foto%");


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
<title>MEGAMOTOS - Admin</title>
<link rel="icon" href="images/favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="../imagenes/tu-logo-mitad2.jpg"></link>
<!--Estilo para la grilla-->
<link href="table.css" rel="stylesheet" type="text/css"/>
<!--FIN - Estilo para la grilla-->
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>
<body>
<div id="page"> 
 <!--Start HEADER -->
 <?php require_once("header.php") ?>
 <!-- End HEADER -->
  <!--Start CENTRAL -->
 <div id="central">
  <h1>Administración de Precios </h1>
  <!--Start Tabla  -->
<?PHP
EyeDataGrid::useAjaxTable();
?>  
<!--End Tabla -->
 </div>
<!--End CENTRAL -->
  <br clear="all" />
  <h1>Actualizar Precios por lote </h1>
<form action="abm_precios" method="post">
<table>
    <tr>
        <td class='formTitle'>
            Tipo de producto:
        </td>
        <td class='formFields'>
            <?php
                $tip = new tipo_productos();
                //$res = $tip->gettipo_productosCombo($tip_id, 'N');
                $res = $tip->getTipCombo($tip_id);
                print $res;
            ?>
        </td>
        <td class='formTitle'>
            Marca:
        </td>
        <td class='formFields'>
            <?php
               /* $mar = new marcas();
                //$res = $mar->getmarcasxTipIdCombo($tip_id, $mar_id);
                $res = $mar->getmarcasxTipIdComboNuloyMarId($tip_id, $mod_id);
                print $res;*/
               if (isset($tip_id) and $tip_id!="" and $tip_id!=0) {
                    $mar = new marcas();
                    //$res = $mod->get_modelosComboxTipId($tip_id, $mod_id);
                    $res = $mar->getmarcasxTipIdComboNuloyMarId($tip_id);
                    print $res;
               } else {
                    print '<select disabled="disabled" name="marcas" id="marcas">';
                    print '<option value="0">Selecciona opci&oacute;n...</option>';
                    print '</select>';
               }
                
            ?>
        </td>
        <td class='formTitle'>
            Modelo:
        </td>
        <td class='formFields'>
              <?php
               if (isset($mar_id) and $mar_id!="" and $mar_id!=0) {
                    $mod = new modelos();
                    //$res = $mod->get_modelosComboxTipId($tip_id, $mod_id);
                    $res = $mod->get_select_modelos($mar_id);
                    print $res;
               } else {
                    print '<select disabled="disabled" name="modelos" id="modelos">';
                    print '<option value="0">Selecciona opci&oacute;n...</option>';
                    print '</select>';
               }
              ?>
        </td>

    </tr>
      <tr>
        <td class="formTitle">CLASIFICACION</td>
        <td>
            <select name='pro_clasificacion' id='pro_clasificacion' class='formFields'  >
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
                <?php if ($pro_clasificacion == ''){?>
                    <option value='T' selected>TODOS</option>
                <?php } else {?>
                    <option value='T'>TODOS</option>    
                <?php }?>
            </select>
        </td>
        <td class="formTitle">ESTADO</td>
        <td>
            <select id="ESTADO" name="ESTADO" class="formFields">
                <option value="-1" selected>Todos</option>
                <option value="1" >Nuevo </option>
                <option value="0">Usado</option>
            </select>
        </td>
      </tr>
    
    <tr>
        <td class="formTitle">RODADO</td>
        <td class="formFields">
            <!--<input type="text" id="rodado" name="rodado" value="<?php //print $rodado?>" onkeyup="this.value=this.value.toUpperCase()" />-->
            <?php
                $pro = new productos();
                $html = $pro->getRodadosSelect($pro_med_diametro);
                echo $html;
            ?>
        </td>        
        <td class="formTitle">ANCHO</td>
        <td class="formFields">
            <!--<input type="text" id="ancho" name="ancho" value="<?php //print $ancho?>" onkeyup="this.value=this.value.toUpperCase()" />-->
            <?php
                $pro = new productos();
                $html = $pro->getAnchoSelect($pro_med_ancho);
                echo $html;
            ?>
        </td>
        <td class="formTitle">DISTR.</td>
        <td class="formFields">
            <!--<input type="text" id="distribucion" name="distribucion" value="<?php //print $distribucion?>" onkeyup="this.value=this.value.toUpperCase()" />-->
            <?php
                $pro = new productos();
                $html = $pro->getDistribucionSelect($pro_distribucion);
                echo $html;
            ?>
        </td>
        <td class="formTitle">LATERAL</td>
        <td class="formFields">
            <!--<input type="text" id="distribucion" name="distribucion" value="<?php //print $distribucion?>" onkeyup="this.value=this.value.toUpperCase()" />-->
            <?php
                $pro = new productos();
                $html = $pro->getLateralSelect($pro_med_alto);
                echo $html;
            ?>
        </td>
        <td class="formTitle">RANGO</td>
        <td>
            <?php
                $tpr = new tipo_rango();
                $res = $tpr->gettipo_rangoCombo($tr_id);
                print $res;
            ?>
        </td>

    </tr>
    <tr>
        <td colspan="8" align="center">
            <input type="button" class='boton' id="cambia" name="cambia" value="Buscar" onclick="seleccionar(<?php echo $_SESSION["suc_id"];?>);" />
        </td>
    </tr>
</table>
</form>
</div>
<!--<script type="text/javascript" src="select_dependientes.js"></script>-->
<script type="text/javascript" src="select_dependientes_tip_mar_mod.js"></script>
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
var pro_clasificacion=document.getElementById('pro_clasificacion').value;
var pro_estado=document.getElementById('ESTADO').value;
var tr_id=document.getElementById('tipo_rango').value;
window.open('cambio_precio_lote2.php?tip_id='+tip_id+'&mar_id='+mar_id+'&mod_id='+mod_id+'&pro_med_diametro='+pro_med_diametro+'&pro_med_ancho='+pro_med_ancho+'&pro_distribucion='+pro_distribucion+'&pro_med_alto='+pro_med_alto+'&pro_clasificacion='+pro_clasificacion+'&pro_estado='+pro_estado+'&tr_id='+tr_id,'Modificar precio por lote','scrollbars=No,status=yes,width=1150,height=400,left=200,top=150 1');
    
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
</script>

</body>
</html>