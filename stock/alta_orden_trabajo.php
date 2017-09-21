<?php
include_once 'class/lib_carrito.php';
include_once 'class/session.php';
include_once 'class/fechas.php';

include_once 'class/conex.php';
include_once 'class/orden_trabajo_enc.php'; // incluye las clases
include_once 'class/orden_trabajo_det.php'; // incluye las clases
include_once 'class/clientes.php';
include_once 'class/vehiculos.php';
include_once 'class/productos.php';
include_once 'class/movimientos_stock.php';
include_once 'class/promociones.php';
include_once 'class/marcas.php';
include_once 'class/modelos.php';
include_once 'class/tipo_rango.php';
include_once 'class/tipo_productos.php';

function checkData($mydate) {
  list($dd,$mm,$yyyy)=explode("/",$mydate);
  if (is_numeric($yyyy) && is_numeric($mm) && is_numeric($dd))
  {
    //echo'dd:'.$dd.'-mm:'.$mm.'-yyyy:'.$yyyy;
    if (checkdate(str_pad($mm,2,"0",STR_PAD_LEFT), str_pad($dd,2,"0",STR_PAD_LEFT), $yyyy)){
       $fecha_final=str_pad($dd,2,"0",STR_PAD_LEFT)."/".str_pad($mm,2,"0",STR_PAD_LEFT)."/".$yyyy;
       return $fecha_final;
    }else{
        //$mensajeErrorFecha= "La fecha no es válida.</br>";
        return '';
    }
  }
    echo "La fecha no es válida.</br>";
    return '';//$mydate;
}
//incluímos la clase ajax
require ("xajax/xajax.inc.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax(); 
$xajax->setCharEncoding('ISO-8859-1');
$xajax->decodeUTF8InputOn();

function asignapmo_id($pmo_id=0){
   $_SESSION["pmo_id"]=$pmo_id;
    $respuesta = new xajaxResponse();
   //$respuesta->addAssign("pmo_id","innerHTML",$pmo_id);
   $respuesta->addAssign("pmo","innerHTML","salida");
   return $respuesta;
}
//registramos funciones
$xajax->registerFunction('asignapmo_id');

//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequests();
//registramos funciones

$mensaje="";
$mensajeError="";
$cli_razon_social = "";
$cli_id="";
$cli_apellido="";
$cli_nombre="";
$mar_id="";
$mod_id="";
$veh_patente = "";
$veh_km = "";
$tip_id = "";
$pro_id = "";
$pro_id_seleccion = ""; 
$pro_descripcion_seleccion = "";
//$pmo_id = 0;
$precio = (isset($_GET['precio'])) ? (double) $_GET['precio'] : 0;
$cantidad = (isset($_GET['cantidad'])) ? (double) $_GET['cantidad'] : 0;
$descuento = (isset($_GET['descuento'])) ? (double) $_GET['descuento'] : 0;
$observaciones_det = (isset($_GET['pro_observaciones'])) ? $_GET['pro_observaciones'] : '';

if ($_SESSION["fecha"]=='') {
    $_SESSION["fecha"]= date("d")."/".date("m")."/".date("Y");
} elseif (isset($_GET["fecha"])){
    $_SESSION["fecha"] = $_GET["fecha"];
} elseif (isset($_POST["fecha"])){
    $_SESSION["fecha"] = $_POST["fecha"];
}
if (isset($_GET["suc_id"])){
    $_SESSION["suc_id"] = $_GET["suc_id"];
} elseif (isset($_GET["sucursales"])){
    $_SESSION["suc_id"] = $_GET["sucursales"];
} elseif (isset($_POST["sucursales"])){
    $_SESSION["suc_id"] = $_POST["sucursales"];
//} elseif ($suc_id!='' or $suc_id!='0'){
//    $_SESSION["suc_id"] = $suc_id;
}//else{
//    $_SESSION["suc_id"] = 0;
//}

//$_SESSION["chk_veh"] = (isset($_GET['chk_veh'])) ? (double) $_GET['chk_veh'] : 0;
if (isset($_GET["pmo_id"])){
    $_SESSION["pmo_id"] = $_GET["pmo_id"];
} elseif (isset($_GET["promociones"])){
    $_SESSION["pmo_id"] = $_GET["promociones"];
} elseif (isset($_POST["promociones"])){
    $_SESSION["pmo_id"] = $_POST["promociones"];
} //else{
//    $_SESSION["pmo_id"] = 0;
//}

if (isset($_GET['cli_id'])) {
    $_SESSION["cli_id"] = $_GET['cli_id'];
} elseif (isset($_GET['clientes'])) {
    $_SESSION["cli_id"] = $_GET['clientes'];
} elseif (isset($_POST['clientes'])) {
    $_SESSION["cli_id"] = $_POST['clientes'];
}//else{
//    $_SESSION["cli_id"] = 0;
//}
if (isset($_GET['veh_id'])) {
      $_SESSION["veh_id"] = $_GET['veh_id'];
} elseif (isset($_GET['vehiculos'])) {
    $_SESSION["veh_id"] = $_GET['vehiculos'];
} elseif (isset($_POST['vehiculos'])) {
    $_SESSION["veh_id"] = $_POST['vehiculos'];
}//else{
//    $_SESSION["veh_id"] = 0;
//}

if (isset($_GET["chk_veh"])){
      $_SESSION["chk_veh"] = $_GET['chk_veh'];
} elseif (isset($_POST["chk_veh"])){
    if ($_POST["chk_veh"].checked==true){
        $_SESSION["chk_veh"] = 1;
    }else{
        $_SESSION["chk_veh"] = 0;
    }
}//else{
//    $_SESSION["chk_veh"] = 0;
//}

if (isset($_GET['observaciones'])) {
      $_SESSION["observaciones"] = $_GET['observaciones'];
} elseif (isset($_POST['observaciones'])) {
      $_SESSION["observaciones"] = $_POST['observaciones'];
}
if (isset($_GET['realizo'])) {
      $_SESSION["realizo"] = $_GET['realizo'];
} elseif (isset($_POST['realizo'])) {
      $_SESSION["realizo"] = $_POST['realizo'];
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    if ($_GET["error"]==1) {
        $mensajeError .= "La cantidad debe ser mayor a cero.</br>";
    }
    if ($_GET["error"]==2) {
        $mensajeError .= "La cantidad ingresada excede el stock del producto (".$_GET["stock"].").</br>";
    }
    if ($mensajeError!="") {
        $mensaje = $mensajeError;
    }

    $pro_id_seleccion = (isset($_GET['pro_id_seleccion'])) ? (int) $_GET['pro_id_seleccion'] : '';
    $tip_id = (isset($_GET['tip_id'])) ? (int) $_GET['tip_id'] : 0;
//    $pmo_id = (isset($_GET['promociones'])) ? (int) $_GET['promociones'] : 0;
//    if ($pmo_id>0){$_SESSION["pmo_id"] = $pmo_id;}
    if ($pro_id_seleccion != 0){
      $pro_sel = new productos($pro_id_seleccion);
      $descripcion = $pro_sel->get_pro_descripcion();
      $med_diametro = $pro_sel->get_pro_med_diametro();
      $med_ancho = $pro_sel->get_pro_med_ancho();
      $med_alto = $pro_sel->get_pro_med_alto(); 
      $distribucion = $pro_sel->get_pro_distribucion();
      $pro_mar_id = $pro_sel->get_mar_id();
      $pro_mod_id = $pro_sel->get_mod_id();
      $pro_tr_id = $pro_sel->get_tr_id();

      $pro_mar = new marcas($pro_mar_id);
      $pro_marca = $pro_mar->get_mar_descripcion();
        
      $pro_mod = new modelos($pro_mod_id);
      $pro_modelo = $pro_mod->get_mod_descripcion();  
        
      $pro_tr = new tipo_rango($pro_tr_id);
      $pro_rango = $pro_tr->get_tr_descripcion();

      $pro_estado_seleccion = $pro_sel->get_pro_nueva();
      if ($pro_estado_seleccion == 1){
            $estado_pro = " - Nuevo";
      } else {
            $estado_pro = " - Usado";
      }
      $pro_tip_id = $pro_sel->get_tip_id();
      $pro_tip = new tipo_productos($pro_tip_id);
      $pro_tip_descripcion = $pro_tip->get_tip_descripcion();
      $pro_estado = $pro_sel->get_pro_estado();
      if($pro_estado=='0'){
        if ($tip_id=='' or $tip_id==0){
            $tip_id=$pro_tip_id;
        }
        switch ($tip_id){
            case 9: 
                $pro_descripcion_seleccion = "Llanta original ". $estado_pro . " " . $pro_marca . " " . $pro_modelo . " " . $med_diametro . "-" . $med_ancho . "-" . $distribucion . " " . $descripcion;
                break;
            case 2: 
                $pro_descripcion_seleccion = "Llanta deportiva ". $estado_pro . " " . $med_diametro . "-" . $med_ancho . "-" . $distribucion . " " . $descripcion;
                break;
            case 4: 
                $pro_descripcion_seleccion = "Neumático ". $estado_pro . " " . $pro_marca . " " . $pro_modelo . " " . $med_ancho . "-" . $med_alto . "-" . $med_diametro . " " . $descripcion . " " . $pro_rango;
                break;
            default:
                $pro_descripcion_seleccion = $pro_tip_descripcion.'-'.$descripcion;
                break;
        }
      }else{
            $pro_descripcion_seleccion = '';
      }
    }
    $cli_id_seleccion = (isset($_GET['cli_id_seleccion'])) ? (int) $_GET['cli_id_seleccion'] : 0;
    if ($cli_id_seleccion != 0){
        $cli_sel = new clientes($cli_id_seleccion);
        $cli_apellido = $cli_sel->get_cli_apellido();
        $cli_nombre = $cli_sel->get_cli_nombre();
        $cli_razon_social = $cli_sel->get_cli_razon_social();
        $_SESSION["cli_id"] = $cli_id_seleccion;
    }

    if ($_GET["limpiar_form"]=='S'){
        $_SESSION["ocarrito"] = new carrito();
        $_SESSION["fecha"]= date("d")."/".date("m")."/".date("Y");
        $_SESSION["observaciones"] = "";
        $_SESSION["numero"]= "";
        $_SESSION["cli_id"] = "0";
        $_SESSION["veh_id"] = "";
        $_SESSION["suc_id"] = "0";
        $_SESSION["realizo"] = "";
        $_SESSION["pmo_id"] = "0";
        $_SESSION["chk_veh"] = "1";
    }
}//($_SERVER["REQUEST_METHOD"] == "GET")

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mensajeError="";
    if (isset($_POST['filtrar_cli'])) {
        $_SESSION["cli_id"] = $_POST['clientes'];
        $cliB = new clientes($_POST['clientes']);
        $cli_razon_social = $cliB->get_cli_razon_social();
        $cli_apellido = $cliB->get_cli_apellido();
        $cli_nombre= $cliB->get_cli_nombre();
    }
    if (isset($_POST['filtrar_veh'])) {
        //$_SESSION["cli_id"] = $_POST['clientes'];
/*        if (isset($_SESSION["cli_id"])) {
            if ($_SESSION["cli_id"]=="" or $_SESSION["cli_id"]=="0") {
                $mensajeError .= "Falta completar el campo Cliente.</br>";
            }
        }else{
                $mensajeError .= "Falta completar el campo Cliente.</br>";
        }*/
        $_SESSION["veh_id"] = $_POST['vehiculos'];
        $veh = new vehiculos($_SESSION["veh_id"]);
        $mar_id = $veh->get_mar_id();//$_POST['marcas'];
        $mod_id = $veh->get_mod_id();//$_POST['modelos'];
        $veh_patente= $veh->get_veh_patente();//$_POST['veh_patente'];
        $veh_km= $veh->get_veh_km();//$_POST['veh_km'];
        if ($_SESSION["cli_id"]=="" or $_SESSION["cli_id"]=="0") {
            $_SESSION["cli_id"] = $veh->get_cli_id();
            $cliB = new clientes($_SESSION["cli_id"]);
            $cli_razon_social = $cliB->get_cli_razon_social();
            $cli_apellido = $cliB->get_cli_apellido();
            $cli_nombre= $cliB->get_cli_nombre();
        } 
    }
    if (isset($_POST['btn_guardar'])) {
      /*validaciones*/
      if(isset($_POST['fecha'])){
            //Verifico la fecha ingresada.
            $_SESSION["fecha"] = checkData($_POST['fecha']);
      }
      if (isset($_SESSION["fecha"])) {
            if ($_SESSION["fecha"]=="") {
                $mensajeError .= "Falta completar el campo Fecha.</br>";}
      }else{
                $mensajeError .= "Falta completar el campo Fecha.</br>";
      }
      if(isset($_POST['clientes'])){
            $_SESSION["cli_id"] = $_POST['clientes'];
      }
      if (isset($_SESSION["cli_id"])) {
            if ($_SESSION["cli_id"]=="" or $_SESSION["cli_id"]=="0") {
                $mensajeError .= "Falta completar el campo Cliente.</br>";
            }
      }else{
                $mensajeError .= "Falta completar el campo Cliente.</br>";
      }
      $_SESSION["chk_veh"] = $_POST['chk_veh'];
      if ($_SESSION["chk_veh"]=="1"){
        /*validaciones*/
        $_SESSION["veh_id"] = $_POST['vehiculos'];
        if (isset($_SESSION["veh_id"])) {
            if ($_SESSION["veh_id"]=="" or $_SESSION["veh_id"]=="0") {
                $mensajeError .= "Falta completar el campo Vehiculo.</br>";
            }
        }else{
                $mensajeError .= "Falta completar el campo Vehiculo.</br>";
        }
      }
    }//(isset($_POST["btn_guardar"]))
    if ($mensajeError!="") {
          $mensaje = $mensajeError;
    } else {
        if (isset($_POST["btn_guardar"])) {
          $_SESSION["fecha"] = checkData($_POST["fecha"]);
          //$_SESSION["observaciones"] = $_POST["observaciones"];
          //$_SESSION["realizo"] = $_POST["realizo"];
          //$_SESSION["pmo_id"] = $_POST["promociones"];
          //$_SESSION["chk_veh"] = $_POST["chk_veh"];
          
          $cantidad = $_SESSION["ocarrito"]->get_num_productos();
          //echo'cant:'.$cantidad;
          if($cantidad!='' and $cantidad>0){
            //Instancio el objeto
            $ote = new orden_trabajo_enc();
            //Seteo las variables
            ///$ote->set_usuarios_usu_id($usuarios_usu_id);
            $fechasql = new fechas();
            $f = $_SESSION['fecha'];
            $fechaconv =$fechasql->cambiaf_a_mysql($f);
            $ote->set_fecha($fechaconv);
            $ote->set_suc_id($_SESSION["suc_id"]);
            $_SESSION["numero"] = $ote->getNumeroOrden($_SESSION["suc_id"]);
            $ote->set_numero($_SESSION["numero"]);
            $ote->set_veh_id($_SESSION["veh_id"]);
            $ote->set_cli_id($_SESSION["cli_id"]);
            $ote->set_observaciones($_SESSION["observaciones"]);
            $ote->set_realizo($_SESSION["realizo"]);
            $ote->set_pmo_id($_SESSION["pmo_id"]);
            //Inserto el registro
            $resultado=$ote->insert_ote();

            for ($i=0;$i<$cantidad;$i++){
              $rec= $_SESSION["ocarrito"]->recupera_linea($i);
              if ($rec[1]!='' and $rec[1]!=0){
                $pde = new orden_trabajo_det();
                $pde->set_pro_id($rec[1]);
                $pde->set_cantidad($rec[3]);
                $pde->set_precio($rec[4]);
                $pde->set_descuento($rec[5]);
                $pde->set_observaciones($rec[8]);
                $pde->set_ote_id($resultado);
                $resultado2=$pde->insert_otd();
                
                $mov = new movimientos_stock();
//                if ($i<1){
//                    $encabezado_id = $mov->getNumeroEncabezado();}
                if ($encabezado_id ==0){
                    $encabezado_id = $mov->getNumeroEncabezado();
                }
                $mov->set_tim_id(2);
                $mov->set_suc_id($_SESSION["suc_id"]);
                $mov->set_pro_id($rec[1]);
                $mov->set_fecha($fechaconv);
                $mov->set_cantidad($rec[3]);
                $mov->set_observaciones('O.T. Nro.:'.$_SESSION["numero"]);
                $mov->set_ote_id($resultado);
                $mov->set_encabezado_id($encabezado_id);
                $mov->insert_mov();
              }//($rec[1]!='' and $rec[1]!=0)
            }//for

            if ($resultado>0 and $resultado2>0){
                    $mensaje="La orden se dio de alta correctamente con el número:".$_SESSION["numero"];
                    $_SESSION["ocarrito"] = new carrito();
                    $_SESSION["fecha"]= date("d")."/".date("m")."/".date("Y");
                    $_SESSION["observaciones"] = "";
                    $_SESSION["suc_id"] = "0";
                    $_SESSION["cli_id"] = "0";
                    $_SESSION["veh_id"] = "";
                    $_SESSION["numero"] = "";
                    $_SESSION["realizo"] = "";
                    $_SESSION["chk_veh"] = "1";
                    $_SESSION["pmo_id"] = "0";
                    header( 'Location: abm_orden_trabajo.php');
            } else {
                    $mensaje="No se pudo dar de alta la orden";
            }
          } else {
                $mensaje .= "Se debe ingresar al menos un detalle.</br>";
          }//($cantidad>0)
        }//(isset($_POST["btn_guardar"]))
    }//else
}//($_SERVER["REQUEST_METHOD"] == "POST")
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>MEGAMOTOS - Admin</title>
<link rel="icon" href="images/favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="../imagenes/tu-logo-mitad2.jpg"></link>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php
   //En el <head> indicamos al objeto xajax se encargue de generar el javascript necesario
   $xajax->printJavascript("xajax/");
?>
</head>
<?php if ($pro_id_seleccion != 0 and $precio == ''){?>
        <body onLoad="Irfoco('cantidad')">
<?php } elseif ($pro_id_seleccion != 0 and $precio != ''){?>
            <body onLoad="Irfoco('descuento')">
<?php } elseif ($cli_id_seleccion != 0){?>
            <body onLoad="Irfoco('vehiculos')">
<?php } elseif ($_GET["limpiar_form"]=='S'){?>
            <body onLoad="Irfoco('fecha')">
<?php }  else { ?>
        <body onLoad="Irfoco('numero')">
<?php }?>
<!--<body onLoad="Irfoco('numero')">-->
<div id="page"> 
 <!--Start HEADER -->
 <?php require_once("header.php") ?>
 <!-- End HEADER -->
  <!--Start CENTRAL -->
  <div id="respuesta" style="visibility: none;"></div>
 <div id="central">
   <h1>Alta de Orden de trabajo </h1>
   <!--Start FORM -->
   <div class="containmsg">
     <form name="formulario" id="formulario" action="alta_orden_trabajo.php" method="POST" enctype="multipart/form-data">
       <table align="center" cellpadding="0" cellspacing="1" class="form">
          <tr>
            <td class="formTitle">NUMERO</td>
            <td class="formFields">
              <input name="numero" id="numero" type="text" class="campos" size="10" readonly value="<?php print $_SESSION["numero"];?>" />
            </td>
            <td class="formTitle">FECHA</td>
            <td class="formFields">
              <input name="fecha" id="fecha" type="text" class="campos" size="10" value="<?php print $_SESSION["fecha"];?>" />
            </td>
            <td class="formTitle">SUCURSAL</td>
            <td class="formFields">
                <?php
//    echo"sess-suc_id:".$_SESSION["suc_id"]." suc_id:".$suc_id;
                include_once 'class/sucursales.php';
                $suc = new sucursales();
                $html = $suc->getsucursalesCombo($_SESSION["suc_id"]);
                echo $html;
                ?>
            </td>
            <td class="formTitle">PROMOCION</td>
            <td class="formFields">
                <?php
//    echo"sess-suc_id:".$_SESSION["suc_id"]." suc_id:".$suc_id;
                include_once 'class/promociones.php';
                $pmo = new promociones();
                $html = $pmo->getPromocionesCombo($_SESSION["pmo_id"]);
                echo $html;
                ?>
            </td>
          </tr>
       </table>
       <table align="center" cellpadding="0" cellspacing="1" class="form">
          <tr>
             <table align="left" cellpadding="0" cellspacing="1" class="formMedIz">
                <tr>
                  <td class="formTitle">CLIENTE</td>
                  <td class="formFields" colspan="3">
                        <?php
                        include_once 'class/clientes.php';
                        $cli = new clientes();
                        if($cli_razon_social=='' and $cli_apellido=='' and $cli_nombre==''){
                            $res = $cli->getclientesComboNulo($_SESSION["cli_id"]);
                        }else{
                            $res = $cli->getclientesCombo_OT($cli_razon_social,$cli_apellido,$cli_nombre);
                        }
                        print $res;
                        ?>
                  </td>
                  <td class="formFields">
                    <input id="filtrar_cli" name="filtrar_cli" type="submit" class="boton" value="Aceptar" ></input>
                  </td>
                  <td class="formFields">
                    <input type="button" id="busca_cliente" name="busca_cliente" class="boton" value="Buscar Cliente" onclick="seleccionar_cli(<?php //echo $_SESSION["suc_id"];?>);" />
                  </td>
                </tr>
             </table>
             <table align="center" cellpadding="0" cellspacing="1" class="formMedDer">
                <tr>
                  <td class="formTitle">VEHICULO</td>
                  <td class="formFields">
                    <?php
                    include_once 'class/vehiculos.php';
                    $veh = new vehiculos();
                    if(($mar_id=='' or $mar_id=='0') and ($mod_id=='' or $mod_id=='0') and $veh_patente==''
                        and $veh_km==''){
                        if ($_SESSION["cli_id"]==0){
                            $res = $veh->getvehiculosComboNulo();
                        } else {
                            $res = $veh->getvehiculosComboNuloxCliId($_SESSION["cli_id"],$_SESSION["veh_id"]);
                            }
                    }else{
                        $res = $veh->getvehiculosCombo_OT($_SESSION["cli_id"],$mar_id,$mod_id,$veh_patente,$veh_km);
                    }
                    print $res;
                    ?>
                  </td>
                  <td class="formFields">
                     <input id="filtrar_veh" name="filtrar_veh" type="submit" class="boton" value="Aceptar" ></input>
                  </td>
                  <td class="formFields">
                    <?php 
                    if ($_SESSION["chk_veh"]==1){
                        echo '<input type="checkbox" id="chk_veh" name="chk_veh" value="1" checked> Con Vehiculo</input>';
                    } else {
                        echo '<input type="checkbox" id="chk_veh" name="chk_veh" value="0"> Con Vehiculo</input>';
                    }
                    ?>
                  </td>
                </tr>
             </table>
          </tr>
       </table>
       <table align="center" cellpadding="0" cellspacing="1" class="form">
          <tr>
            <td class="formTitle">OBSERVACIONES</td>
            <td class="formFields" align="left">
               <textarea name="observaciones" id="observaciones"  cols="70" maxlength="180" rows="2" style="text-align: left;" onkeypress="return limita(event, 180);" onkeyup="this.value=this.value.toUpperCase()" ><?php print $_SESSION["observaciones"];?></textarea>
            </td>
            <td class="formTitle">REALIZO</td>
            <td class="formFields" align="left">
                <input type="text" id="realizo" name="realizo" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $_SESSION["realizo"]; ?>" />
            </td>
          </tr>
       </table>
       <table align="center" cellpadding="0" cellspacing="1" class="form">
          <tr>
            <td class="formTitle">DETALLE:</td>
          </tr>
          <tr>
            <td class="formTitle">TIPO PRODUCTO</td>
            <td class="formFields">
                <?php
                include_once 'class/tipo_productos.php';
                $tip = new tipo_productos();
                $res = $tip->getTipnuloComboOT($tip_id);
                print $res;// onkeypress="CodigoKEnter();"
                ?>
            </td>
            <td class="formTitle">CODIGO</td>
            <td class="formFields">
                <input name="pro_id" id="pro_id" type="text" class="campos" size="10"
                       value="<?php print $pro_id_seleccion;?>" onkeyUp="validarNroInt(this)" />
            </td>
            <td class="formFields">
                <input type="button" id="busca_producto" name="busca_producto" class="boton" value="Buscar" 
                       onclick="seleccionar(<?php //echo $_SESSION["suc_id"].','.$_SESSION["cli_id"];?>);" />
            </td>
            <td class="formTitle">PRODUCTO</td>
            <td class="formFields" colspan="4">
               <input size="70" readonly="true" type="text" id="producto" name="producto" value="<?php echo $pro_descripcion_seleccion; ?>" />
            </td>
            <td id="oculto">   
               <input type="text" id="pro_id" name="pro_id" value="<?php echo $pro_id_seleccion; ?>" />
            </td>
          </tr>
          <tr></tr>
          <tr>
            <td class="formTitle">CANTIDAD</td>
            <td class="formFields" style="width:1px; margin:0px;">
                <input type="text" id="cantidad" name="cantidad" size="10" value="<?php print $cantidad; ?>"
                       onBlur="validarNroInt(this)" />
            </td>
            <td class="formTitle" style="width:1px; margin:0px;">PRECIO</td>
            <td class="formFields">
                <input type="text" id="precio" name="precio" size="10" ondblclick="selectprecio();" 
                       value="<?php print $precio; ?>" onBlur="validarNro(this)" />
            </td>
            <td class="formTitle">DESCUENTO(%)</td>
            <td class="formFields">
                <input type="text" id="descuento" name="descuento" size="8" value="<?php print $descuento; ?>" onBlur="validarNro(this)" />
            </td>
            <td class="formTitle">OBSERVACIONES</td>
            <td class="formFields">
                <textarea name="observaciones_det" id="observaciones_det" class="campos" cols="40" rows="2"
                    onkeyup="this.value=this.value.toUpperCase()" ><?php print $observaciones_det;?></textarea>
                <!--<input type='button' id='observaciones_det' name='observaciones_det' class='boton' value='Observaciones'
                    onclick="obs_det(<?php //echo $_SESSION["suc_id"];?>);" />-->
            </td>
            <td align="center" class="formFields">
              <input type="button" id="btn_agregar" name="btn_agregar" class="boton" value="Agregar" onclick="agregar();" />
            </td>
          </tr>
       </table>
       <table align="center" cellpadding="0" cellspacing="1" class="form">
          <tr>
            <td class="rowGris">Código</td>
            <td class="rowGris">Descripción</td>
            <td class="rowGris">Cantidad</td>
            <td class="rowGris">Precio</td>
            <td class="rowGris">Dto.</td>
            <td class="rowGris">Importe</td>
<!--            <td class="rowGris">I.V.A.</td>-->
            <td class="rowGris">Observaciones</td>
            <td class="rowGris"></td>
          </tr>
            <?php
            $mostrar = $_SESSION["ocarrito"]->imprime_carrito2($_SESSION["fecha"],$_SESSION["suc_id"]
                    ,$_SESSION["cli_id"],$_SESSION["veh_id"],$_SESSION["observaciones"],$_SESSION["pmo_id"]
                    ,$_SESSION["realizo"],$_SESSION["chk_veh"]);
            echo $mostrar;
            ?>
       </table>
       <table align="center" cellpadding="0" cellspacing="1" class="form">
          <tr>
            <td colspan="6" class="formTitle">TOTAL</td>
          </tr>
          <tr>
<!--            <td class="formTitle">BRUTO</td>
            <td class="formFields">
                <input name="BRUTO" id="BRUTO" type="text" class="campos" size="40" readonly value="<?php echo $_SESSION["ocarrito"]->get_total_bruto();?>" />
            </td>-->
<!--            <td class="formTitle">I.V.A.</td>
            <td class="formFields">
                <input name="IVA" id="IVA" type="text" class="campos" size="40" readonly value="<?php echo $_SESSION["ocarrito"]->get_total_iva();?>" />
            </td>-->
            <td class="formTitle">TOTAL</td>
            <td class="formFields">
                <input name="NETO" id="NETO" type="text" class="campos" size="40" readonly value="<?php echo number_format($_SESSION["ocarrito"]->get_total(),2);?>" />
            </td>
          </tr>
       </table>
       <table align="center" cellpadding="0" cellspacing="1" class="form">
          <tr>
            <td colspan="2" align="center" class="formFields">
              <input type="submit" id="btn_guardar" name="btn_guardar" class="boton" value="Guardar" /><!--onclick="deshabilitar();" -->
              <a href="alta_orden_trabajo.php?limpiar_form=S"><input class="boton" type="button" value="Cancelar" /></a>
              <a href='abm_orden_trabajo.php'>
                <input type='button' class='boton' value='Volver' onClick="window.location.href='abm_orden_trabajo.php'" />
              </a>
            </td>
          </tr>
          <tr>
              <td colspan="2" class="mensaje">
          		<?php 
          		if (isset($mensaje)) {
          			echo $mensaje;
                    if ($mensaje !=''){
                        echo '<script type="text/javascript" language="JavaScript">';
                        echo 'alert("'.$mensaje.'");';
                        echo '</script>';
                    }
          		}
          		?>
          	</td>
          </tr>
       </table>		
       <?php
       if (isset($_POST["mensaje"])) {
        	if ($_POST["mensaje"]!=""){
        		$mensaje=$_POST["mensaje"];
			echo "<br><br><span class='Estilo3'><B>$mensaje</span>";
       }}
       ?>
     </form>
   </div>
   <!--End FORM -->
 </div> 
 <!--End CENTRAL -->
 <br clear="all" />
</div>
<script type="text/javascript">
    function habilitar_cabecera(){//alert('hab');
        //document.getElementById('fecha').disabled=false;
        document.getElementById('sucursales').disabled=false;
        document.getElementById('promociones').disabled=false;
        document.getElementById('clientes').disabled=false;
        //document.getElementById('vehiculos').disabled=true;
        //document.getElementById('chk_veh').disabled=true;
        //document.getElementById('observaciones').disabled=false;
        //document.getElementById('realizo').disabled=false;
    }
    function deshabilitar_cabecera(){//alert('deshab');
        //document.getElementById('fecha').disabled=true;
        document.getElementById('sucursales').disabled=true;
        document.getElementById('promociones').disabled=true;
        document.getElementById('clientes').disabled=true;
        //document.getElementById('vehiculos').disabled=true;
        //document.getElementById('chk_veh').disabled=true;
        //document.getElementById('observaciones').disabled=true;
        //document.getElementById('realizo').disabled=true;
    }
</script>
<?php
//Si hay productos cargados, la cabecera no puede modificarse.
$cant_grilla = 0;
$cant_grilla = $_SESSION["ocarrito"]->get_num_productos();
if ($cant_grilla!='' and $cant_grilla>0) {
?>
  <script type="text/javascript">
    deshabilitar_cabecera();
  </script>
<?php
} else{
?>
  <script type="text/javascript">
    habilitar_cabecera();
  </script>
<?php
}
?>
<script type="text/javascript" src="select_dependientes_tip_pro.js"></script>
<script type="text/javascript">
//function deshabilitar(){
//    document.formulario.btn_guardar.disabled=true;
//    document.getElementById("btn_guardar").disabled = true;
//}
function Irfoco(ID){
document.getElementById(ID).focus();
}

</script>
<script type="text/javascript" language="JavaScript">
function error(mensaje){
    Alert("Error: "+mensaje);
}

function selectprecio(){
    var fecha=document.getElementById('fecha').value;
    var suc_id=document.getElementById('sucursales').value; 
    var pmo_id=document.getElementById('promociones').value;
    var cli_id = document.getElementById('clientes').value;
    var veh_id = document.getElementById('vehiculos').value;
    var observaciones=document.getElementById('observaciones').value;
    var realizo=document.getElementById('realizo').value;
    if(document.formulario.chk_veh.checked==true){
        var chk_veh=1;
    }else{
        var chk_veh=0;
    }
    var tip_id=document.getElementById('tipo_productos').value;
    var pro_id= document.getElementById('pro_id').value;
    var cantidad=document.getElementById('cantidad').value; 
    var descuento=document.getElementById('descuento').value; 
    var pro_observaciones = document.getElementById('observaciones_det').value;

    window.open('seleccion_precio_producto.php?pro_id='+pro_id+'&tip_id='+tip_id+'&suc_id='+suc_id + '&cli_id=' + cli_id
        + '&veh_id=' + veh_id+'&pmo_id='+pmo_id+'&observaciones='+observaciones+'&realizo='+realizo+'&fecha='+fecha
        +'&chk_veh='+chk_veh+'&cantidad='+cantidad+'&descuento='+descuento+'&pro_observaciones='+pro_observaciones
        ,'Selecciona precio por producto','scrollbars=No,status=yes,width=400,height=200,left=200,top=150 1');
}

function agregar(){
  //var posicion=document.getElementById('productos').options.selectedIndex; //posicion
  //var descripcion=(document.getElementById('productos').options[posicion].text); //valor
  //var pro_id=(document.getElementById('productos').options[posicion].value); //valor
  var fecha=document.getElementById('fecha').value;
  var suc_id = document.getElementById('sucursales').value;
  var pmo_id = document.getElementById('promociones').value;
  var cli_id = document.getElementById('clientes').value;
  var veh_id = document.getElementById('vehiculos').value;
  var observaciones = document.getElementById('observaciones').value;
  var realizo=document.getElementById('realizo').value;
  if(document.formulario.chk_veh.checked==true){
        var chk_veh=1;
  }else{
        var chk_veh=0;
  }
//  var chk_veh=document.getElementById('chk_veh').value;
  var tip_id = document.getElementById('tipo_productos').value;
  var pro_id= document.getElementById('pro_id').value;
  var descripcion=document.getElementById('producto').value;
  var cantidad = document.getElementById('cantidad').value;
  //var pro_id = document.getElementById('productos').value;
  var precio = document.getElementById('precio').value;
  var pro_descuento = document.getElementById('descuento').value;
  var pro_observaciones = document.getElementById('observaciones_det').value;
  //alert ('Valor:' + pro_descuento);
  if (descripcion!=''){
      location.href = 'class/agregar_carrito.php?pro_id=' + pro_id + '&pro_descripcion=' + descripcion+'&fecha='+fecha
          + '&pro_cantidad=' + cantidad + '&suc_id=' + suc_id + '&cli_id=' + cli_id + '&veh_id=' + veh_id
          + '&tip_id=' + tip_id + '&pro_id=' + pro_id + '&observaciones=' + observaciones + '&precio=' + precio
          +'&pro_descuento=' + pro_descuento + '&pmo_id=' + pmo_id+'&realizo='+realizo+'&chk_veh='+chk_veh
          +'&pro_observaciones='+pro_observaciones+'&pro_descuento='+pro_descuento;
  }
  /*var input = document.getElementById(campo);
  input.value = 'S';*/
}

function seleccionar(/*suc_id,cli_id*/){
  //var posicion=document.getElementById('tipo_productos').options.selectedIndex.value; 
  var fecha=document.getElementById('fecha').value;
    //if (suc_id=='' || suc_id==0){
  var suc_id=document.getElementById('sucursales').value;
    //}
  var pmo_id=document.getElementById('promociones').value;
    //if (cli_id=='' || cli_id==0){
  var cli_id=document.getElementById('clientes').value;
    //}
  var veh_id=document.getElementById('vehiculos').value;
  var observaciones=document.getElementById('observaciones').value;
  var realizo=document.getElementById('realizo').value;
    //    var chk_veh=document.formulario.chk_veh.value;
  if(document.formulario.chk_veh.checked==true){
        var chk_veh=1;
  }else{
        var chk_veh=0;
  }
  var posicion=document.getElementById('tipo_productos').value;
  var pro_id = document.getElementById('pro_id').value;
  if (pro_id!='' && pro_id!=0){
      document.getElementById('tipo_productos').value=0;
      posicion=document.getElementById('tipo_productos').value;
      location.href = 'alta_orden_trabajo.php?&suc_id='+suc_id+'&cli_id='+cli_id+'&veh_id='+veh_id+'&tip_id='+posicion
            +'&pro_id_seleccion=' + pro_id+'&observaciones='+observaciones+'&pmo_id='+pmo_id+'&realizo='+realizo
            +'&chk_veh='+chk_veh+'&fecha='+fecha;
          //opener.location='alta_movimientos_stock.php?pro_id_seleccion=' + pro_id + '&tip_id=' + tip_id + '&tipo=' + tipo + '&suc_des_id=' + suc_des_id + '&suc_id=' + suc_id + '&remito=' + remito;
  } else{
      if (posicion!=='' && posicion!=0){
        if (posicion==2 || posicion==9){
          window.open('seleccion_producto.php?tip_id='+posicion+'&suc_id='+suc_id+'&observaciones='+observaciones
              +'&fecha='+fecha+ '&cli_id='+cli_id+'&veh_id='+veh_id+'&realizo='+realizo+'&chk_veh='+chk_veh
              +'&pmo_id='+pmo_id,'Selecciona producto','scrollbars=No,status=yes,width=1200,height=400,left=200,top=150 1');
        } else if(posicion==4){
          window.open('seleccion_producto_neum.php?tip_id='+posicion+'&suc_id='+suc_id+'&observaciones='+observaciones
              +'&fecha='+fecha+ '&cli_id='+cli_id+'&veh_id='+veh_id+'&realizo='+realizo+'&chk_veh='+chk_veh
              +'&pmo_id='+pmo_id,'Selecciona producto','scrollbars=No,status=yes,width=1150,height=400,left=200,top=150 1');
        } else {
          window.open('seleccion_producto_gral.php?tip_id='+posicion+'&suc_id='+suc_id+'&observaciones='+observaciones
              +'&fecha='+fecha+ '&cli_id='+cli_id+'&veh_id='+veh_id+'&realizo='+realizo+'&chk_veh='+chk_veh
              +'&pmo_id='+pmo_id,'Selecciona producto','scrollbars=No,status=yes,width=1000,height=400,left=200,top=150 1');
        }
    //window.open('seleccion_producto.php?tip_id='+posicion,'Selecciona producto','scrollbars=No,status=yes,width=1000,height=400,left=200,top=150 1');
      }else {
          alert('No se encontró producto. Buscar por Tipo Producto');
      }
  }
}
document.onkeypress=function(){
    tecla= window.event.keyCode;
    if(tecla==13){
        return false;
    }
}
document.getElementById('pro_id').onkeypress=function(){
    tecla= window.event.keyCode;
    if(tecla==13){
        seleccionar();return false;
    }
}
function limita(elEvento, maximoCaracteres) {
  var elemento = document.getElementById("texto");

  // Obtener la tecla pulsada 
  var evento = elEvento || window.event;
  var codigoCaracter = evento.charCode || evento.keyCode;
  // Permitir utilizar las teclas con flecha horizontal
  if(codigoCaracter == 37 || codigoCaracter == 39) {
    return true;
  }

  // Permitir borrar con la tecla Backspace y con la tecla Supr.
  if(codigoCaracter == 8 || codigoCaracter == 46) {
    return true;
  }
  else if(elemento.value.length >= maximoCaracteres ) {
    return false;
  }
  else {
    return true;
  }
}

function seleccionar_cli(){
    var fecha=document.getElementById('fecha').value;
    var suc_id=document.getElementById('sucursales').value;
    var pmo_id=document.getElementById('promociones').value;
    var observaciones=document.getElementById('observaciones').value;
    var realizo=document.getElementById('realizo').value;
    if(document.formulario.chk_veh.checked==true){
        var chk_veh=1;
    }else{
        var chk_veh=0;
    }

    window.open('seleccion_cliente.php?suc_id='+suc_id+'&observaciones='+observaciones+'&fecha='+fecha+'&realizo='+realizo
        +'&chk_veh='+chk_veh+'&pmo_id='+pmo_id,'Selecciona cliente','scrollbars=No,status=yes,width=1200,height=400,left=200,top=150 1');
}

//*** Este Codigo permite Validar que sea un campo Numerico
    function Solo_NumericoInt(variable){
        Numer=parseInt(variable);
        if (isNaN(Numer)){
            return "";
        }else{
            if(Numer<0){
                return "";
            }
        }
        return Numer;
    }
    function validarNroInt(Control){
        Control.value=Solo_NumericoInt(Control.value);
    }
    function Solo_Numerico(variable){
			Numer=parseFloat(variable).toFixed(2);
			if (isNaN(Numer)){
				return "";
			}else{
				if(Numer<0){
					return "";
				}
			}
			return Numer;
    }
    function validarNro(Control){
        Control.value=Solo_Numerico(Control.value);
    }
</script>
</body>
</html>