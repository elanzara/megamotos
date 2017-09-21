<?php
include_once 'class/lib_carrito_stock.php';
include_once 'class/session.php';
include_once 'class/fechas.php';
include_once 'class/usuarios.php';
?>
<!DOCTYPE html>
<?php
include_once 'class/conex.php';
include_once 'class/movimientos_stock.php';
include_once 'class/productos.php';
include_once 'class/sucursales.php';
include_once 'class/marcas.php';
include_once 'class/modelos.php';
include_once 'class/tipo_rango.php';

require_once('class/fpdf/fpdf.php');
require_once('class/fpdf/fpdi.php');

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

$mensaje="";
$mensajeError="";
$tipo = "";
$tip_id = "";
$mar_id="";
$mod_id="";
$pro_med_alto="";
$pro_distribucion="";
$pro_med_ancho="";
$pro_med_diametro="";
$tr_id="";
$pro_nueva="";
$mail_ori="";
$mail_des="";
$_SESSION["suc_id"]= 2;
$_SESSION["suc_des_id"]="";
$pro_id_seleccion =  (isset($_GET['pro_id_seleccion'])) ? $_GET['pro_id_seleccion'] : '';
$_SESSION["remito"]= (isset($_GET['remito'])) ? $_GET['remito'] : '';

if ($_SESSION["fecha"]=='') {
    $_SESSION["fecha"]= date("d")."/".date("m")."/".date("Y");
} elseif (isset($_GET["fecha"])){
    $_SESSION["fecha"] = $_GET["fecha"];
} elseif (isset($_POST["fecha"])){
    $_SESSION["fecha"] = $_POST["fecha"];
}
if ($_SESSION["suc_id"]=='') {
    $_SESSION["suc_id"]= $_GET['sucursales'];
}
if ($_SESSION["suc_des_id"]=='') {
    $_SESSION["suc_des_id"]= $_GET['sucursales_des'];
}
if ($_SESSION["remito"]=='') {
    $_SESSION["remito"]= $_GET['remito'];
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
  if ($pro_id_seleccion != 0){
        $pro_sel = new productos($pro_id_seleccion);
        $tip_id = $pro_sel->get_tip_id();
  }else{
      if (isset($_GET['tip_id'])) {
          $tip_id = $_GET['tip_id'];
          //$pro_id = $_GET['pro_id'];
      }else{
          $tip_id = 0;
          }
  }
  if (isset($_GET['tipo'])) {
    $tipo = $_GET['tipo'];
  }//echo'$tip_id:'.$tip_id;
  if (isset($_GET['fecha'])) {
    if ($_GET['fecha'] != ''){
        $_SESSION["fecha"] = $_GET['fecha'];
    }
  }
  if (isset($_GET['suc_id']) and $_GET['suc_id']!=0) {
    $_SESSION["suc_id"] = $_GET['suc_id'];
  }
  if (isset($_GET['suc_des_id']) and $_GET['suc_des_id']!=0) {
    $_SESSION["suc_des_id"] = $_GET['suc_des_id'];
  }
  if (isset($_GET['remito'])) {
    $_SESSION["remito"] = $_GET['remito'];
  }
  if ($_GET["limpiar_form"]=='S'){
        $_SESSION["ocarrito_stock"] = new carrito_stock();
        $_SESSION["fecha"]= date("d")."/".date("m")."/".date("Y");
        $_SESSION["remito"]= "";
        $tip_id = "";
  }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" ) {
  $mensajeError="";
  $tipo = $_POST['tipo'];
  $tip_id = $_POST['tip_id'];
  if (isset($_POST['filtrar'])) {
    $mar_id = $_POST['marcas'];
    $mod_id = $_POST['modelos'];
    $tr_id = $_POST['tipo_rango'];
    $pro_med_ancho= $_POST['pro_med_ancho'];
    $pro_med_diametro= $_POST['pro_med_diametro'];
    $pro_distribucion= $_POST['pro_distribucion'];
    $pro_med_alto= $_POST['pro_med_alto'];
    $pro_nueva= $_POST['estados'];
  }

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
  if($_POST["tipo"] == "T"){
    if (isset($_POST["remito"])){
        if ($_POST["remito"]==''){
            $mensajeError = "Debe ingresar el número de comprobante";
        }
    } else {
        $mensajeError = "Debe ingresar el número de comprobante";
    }
    if ($_POST["sucursales"] != 0 and $_POST["sucursales_des"] != 0 and $_POST["sucursales"] != ""
        and $_POST["sucursales_des"] != ""){
        if ($_POST["sucursales"] == $_POST["sucursales_des"]){
            $mensajeError = "Las sucursales deben ser diferentes";}
    }else {
        $mensajeError = "Falta ingresar alguna sucursal";
    }
  }
  if ($mensajeError!="") {
        $mensaje = $mensajeError;
  } else {
      if (isset($_POST['enviar'])) {
        $cantidad = $_SESSION["ocarrito_stock"]->get_num_productos();
        $cont=0;
        for ($i=0;$i<$cantidad;$i++){
          $rec= $_SESSION["ocarrito_stock"]->recupera_linea($i);
          if ($rec[1]!='' and $rec[1]!=0){
            $cont=$cont+1;
            //Instancio el objeto
            $mov = new movimientos_stock();
            if ($cont==1){
                $encabezado_id = $mov->getNumeroEncabezado();
            }
            $mov->set_encabezado_id($encabezado_id);
            $mov->set_remito($_POST['remito']);
            //Seteo las variables
            if ($_POST["tipo"] == "T") {
                $trans_id = $mov->getNumeroTrans();
                $mov->set_trans_id($trans_id);
            }
            //Ingreso o Transferencia
            if (($_POST["tipo"] == "I") or ($_POST["tipo"] == "T")) {
                $fechasql = new fechas();
                $f = $_SESSION['fecha'];
                $fechaconv =$fechasql->cambiaf_a_mysql($f);
                $mov->set_fecha($fechaconv);
                if ($_POST["tipo"] == "I") {
                    $mov->set_suc_id($_POST['sucursales']);
                }else{
                    $mov->set_suc_id($_POST['sucursales_des']);
                }
                $mov->set_tim_id(1);
                //$rec= $_SESSION["ocarrito_stock"]->recupera_linea($i);
                $mov->set_pro_id($rec[1]);
                $mov->set_cantidad($rec[3]);
                $mov->set_observaciones($rec[4]);
                //Inserto el registro
                $resultado=$mov->insert_mov();
                $id1=mysql_insert_id();
            }
            //Egreso o Transferencia
            if (($_POST["tipo"] == "E") or ($_POST["tipo"] == "T")) {
                $fechasql = new fechas();
                $f = $_SESSION['fecha'];
                $fechaconv =$fechasql->cambiaf_a_mysql($f);
                $mov->set_fecha($fechaconv);
                $mov->set_suc_id($_POST['sucursales']);
                $mov->set_tim_id(2);
                $rec= $_SESSION["ocarrito_stock"]->recupera_linea($i);
                $mov->set_pro_id($rec[1]);
                $mov->set_cantidad($rec[3]);
                $mov->set_observaciones($rec[4]);
                //Inserto el registro
                $resultado2=$mov->insert_mov();
            }
          }//($rec[1]!='' and $rec[1]!=0)
        }//for ($i=0;$i<$cantidad;$i++)

        /*MODULO DE IMPRESION DE REMITO*/
        if ($resultado>0 || $resultado2>0){
            /*IMPRIMIR REMITO*/
        	// initiate FPDI
        	//echo $id1; 
                /*VOLVER A DESCOMENTAR CUANDO ESTE LA IMPRESION DEL REMITO*/
                //            header ("Location: imprimir_remito.php");
                /*            $pdf =& new FPDI();
        	// add a page
        	$pdf->AddPage();
        
        	// now write some text above the imported page
        	$pdf->SetFont('courier');
        	$pdf->SetTextColor(0,0,0);
            $pdf->SetFontSize(10);
        
            $pdf->SetXY(170, 27);
        	$pdf->Write(0, "$id_orden");
            $pdf->Output('Remito.pdf', 'I');
            $pdf->Close();*/          
        }        
        //ENVIO DEL MAIL
        if ($resultado>0 and $resultado2>0 and $_POST["tipo"] == "T"){
            $suc = new sucursales($_POST["sucursales"]);
            $ori = $suc->get_suc_descripcion();
            $mail_ori = $suc->get_suc_mail();
            $suc = new sucursales($_POST["sucursales_des"]);
            $des = $suc->get_suc_descripcion();
            $mail_des = $suc->get_suc_mail();
            $html2 = "";
            $html2 .= "<table>";
            $html2 .= "<tr><td>";
            $texto = 'Se esta realizando una transferencia con fecha '.$_POST["fecha"].' bajo el número de remito '
            .$_POST["remito"].' desde la sucursal '.$ori.' a la sucursal '.$des.' con el siguiente detalle:';//\r\n';
            $html2 .= $texto;
            $html2 .= "</td></tr><tr><td><br>----------------------------------------------------------<br></td></tr>";
            for ($i=0;$i<$cantidad;$i++){
              $rec= $_SESSION["ocarrito_stock"]->recupera_linea($i);
                if ($rec[1]!='' and $rec[1]!=0){
                    $html2 .= "<tr><td>";
                    $texto = 'Nro.Movimiento: '.$encabezado_id.'<br>';
                    $html2 .= $texto."</td></tr>";
                    $pro = new productos($rec[1]);
                    $produ = $pro->get_pro_descripcion();
                    $texto = 'Producto: '.$rec[1] . ' - ' . $produ;
                    $html2 .= $texto."</td></tr>";
                    if ($pro->get_tip_id() == 2 || $pro->get_tip_id() == 4 || $pro->get_tip_id() == 9){
                        $html2 .= "<tr><td>";
                        $mar = new marcas($pro->get_mar_id());
                        $marca = $mar->get_mar_descripcion();
                        $texto = 'Marca: '.$marca;
                        $html2 .= $texto."</td></tr>";
                        $html2 .= "<tr><td>";
                        $mod = new modelos($pro->get_mod_id());
                        $modelo = $mod->get_mod_descripcion();
                        $texto = 'Modelo: '.$modelo;
                        $html2 .= $texto."</td></tr>";
                        $html2 .= "<tr><td>";
                        $ancho = $pro->get_pro_med_ancho();
                        $texto = 'Ancho: '.$ancho;
                        $html2 .= $texto."</td></tr>";
                      if ($pro->get_tip_id() == 4){//Neumaticos:
                        $html2 .= "<tr><td>";
                        $alto = $pro->get_pro_med_alto();
                        $texto = 'Alto: '.$alto;
                        $html2 .= $texto."</td></tr>";}
                        $html2 .= "<tr><td>";
                        $diametro = $pro->get_pro_med_diametro();
                        $texto = 'Diámetro: '.$diametro;
                        $html2 .= $texto."</td></tr>";
                        $html2 .= "<tr><td>";
                        $distribucion = $pro->get_pro_distribucion();
                        $texto = 'Distribución: '.$distribucion;
                        $html2 .= $texto."</td></tr>";
                        $html2 .= "<tr><td>";
                        $tr = new tipo_rango($pro->get_tr_id());
                        $rango = $tr->get_tr_descripcion();
                        $texto = 'Rango: '.$rango;
                        $html2 .= $texto."</td></tr>";
                        $html2 .= "<tr><td>";
                        if ($pro->get_pro_nueva()==1){
                            $nuevo = 'Nuevo';
                        }else{
                            $nuevo = 'Usado';
                        }
                        $texto = 'Estado: '.$nuevo;
                        $html2 .= $texto."</td></tr>";
                    }
                    $html2 .= "<tr><td>";
                    $texto = 'Cantidad: '.$rec[3];//'\r\n';
                    $html2 .= $texto."</td></tr>";
                    $html2 .= "<tr><td>";
                    $texto = 'Observaciones: '.$rec[4];//'\r\n';
                    $html2 .= $texto."</td></tr>";
                    $html2 .= "<tr><td>----------------------------------------------------------<br></td></tr>";
                }
            }
            $html2 .= "</table>";
            // Para enviar un correo HTML mail, la cabecera Content-type debe fijarse
            $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
            $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

            $usu = new usuarios();
            $mails = $usu->get_mail_admin();
            $to = $mails;//"edulanzara@gmail.com";
            if ($mail_ori!=''){
                $to .= ','.$mail_ori;    
            }
            if ($mail_des!=''){
                $to .= ','.$mail_des;    
            }

            $from = "edulanzara@gmail.com";
            $asunto = "AVISO DE TRANSFERENCIA";
//            $cabeceras = 'From: edulanzara@gmail.com' . "\r\n" .
//                        'Reply-To: edulanzara@gmail.com' . "\r\n" .
//                        'X-Mailer: PHP/' . phpversion();
            $fromaddress = "From: Megallantas"."\r\n";
//            echo "mails: ".$mails."<br>";
//            echo "from: ".$from."<br>";
//            echo "asunto:".$asunto."<br>";
//            echo "cabeceras: ".$cabeceras;
            //mail($to,$asunto,$texto, $cabeceras);
            mail($to,$asunto,$html2, $cabeceras);
        }

        //Ingreso o Transferencia
        if (($_POST["tipo"] == "I") or ($_POST["tipo"] == "T")) {
            if ($resultado>0){
                $mensaje="El movimiento stock se dio de alta correctamente";
                $_SESSION["ocarrito_stock"] = new carrito_stock();
                $_SESSION["fecha"]= date("d")."/".date("m")."/".date("Y");
                $_SESSION["remito"]= "";
                $tip_id = "";
            } else {
                $mensaje="No se pudo dar de alta el movimiento stock";
            }
        }
        //Egreso o Transferencia
        if (($_POST["tipo"] == "E") or ($_POST["tipo"] == "T")) {
            if ($resultado2>0){
                $mensaje="El movimiento stock se dio de alta correctamente";
                $_SESSION["ocarrito_stock"] = new carrito_stock();
                $_SESSION["fecha"]= date("d")."/".date("m")."/".date("Y");
                $_SESSION["remito"]= "";
            } else {
                $mensaje="No se pudo dar de alta el movimiento stock";
            }
        }      
    }//enviar
  }//else($mensajeError!="")
}//POST
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>MEGAMOTOS - Admin</title>
<link rel="icon" href="images/favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="../imagenes/tu-logo-mitad2.jpg"></link>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>
<?php if ($pro_id_seleccion != '') { ?>
    <body onLoad="Irfoco('cantidad')">
<?php } else {?>
    <body onLoad="Irfoco('tip_id')">
<?php }?>
<div id="page"> 
 <!--Start HEADER -->
 <?php require_once("header.php") ?>
 <!-- End HEADER -->
  <!--Start CENTRAL -->
 <div id="central">
   <?php
   if ($tipo == "T") { ?>
    <h1>Transferencia de Stock </h1>
   <?php
   } elseif ($tipo == "E") { ?>
    <h1>Egreso de Stock </h1>
   <?php
   } else { ?>
    <h1>Ingreso de Stock </h1>
   <?php
   } ?>
     <!--Start FORM -->
     <form ACTION="alta_movimientos_stock.php?tipo=<?php print $tipo.'&tip_id='.$tip_id;?>" METHOD="POST" enctype="multipart/form-data">
        <table align="center" cellpadding="0" cellspacing="1" class="form">
          <input name="tipo" id="tipo" type="hidden" class="campos" size="10" value="<?php print $tipo;?>" />
          <input name="tip_id" id="tip_id" type="hidden" class="campos" size="10" value="<?php print $tip_id;?>" />
          <tr>
            <td class="formTitle">FECHA</td>
            <td class="formFields">
                <input name="fecha" id="fecha" type="text" class="campos" size="10" value="<?php print $_SESSION["fecha"];?>" />
            </td>
            <td class="formTitle">COMPROBANTE</td>
            <td class="formFields">
                <input name="remito" id="remito" type="text" class="campos" size="10" value="<?php print $_SESSION["remito"];?>" />
            </td>
          <?php
          if (($tipo == "I") or ($tipo == "E")) {
          ?>
            <td class="formTitle">SUCURSAL</td>
            <td class="formFields">
                <?php 
                include_once 'class/sucursales.php';
                $suc = new sucursales();
                $html = $suc->getsucursalesCombo($_SESSION["suc_id"]);
                echo $html;
                ?>                
            </td>
          </tr>
          <?php
          } else {//($tipo == "T") {
          ?>
          <tr>
            <td class="formTitle">SUCURSAL ORIGEN</td>
            <td class="formFields">
                <?php
                include_once 'class/sucursales.php';
                $suc = new sucursales();
                $html = $suc->getsucursalesCombo($_SESSION["suc_id"]);
                echo $html;
                ?>
            </td>
            <td class="formTitle">SUCURSAL DESTINO</td>
            <td class="formFields">
                <?php
                include_once 'class/sucursales.php';
                $suc = new sucursales();
                $html1 = $suc->getsucursales_desCombo($_SESSION["suc_des_id"]);
                echo $html1;
                ?>
            </td>
          </tr>
          <?php
          }
          ?>
          <tr>
            <td class="formTitle">TIPO PRODUCTO</td>
            <td class="formFields">
                    <?php
                    include_once 'class/tipo_productos.php';
                    $tip = new tipo_productos();
                    $res = $tip->getTipComboMvtoStock($tip_id,$tipo);
                    print $res;
                    ?>
            </td>
            <td class="formTitle">CODIGO</td>
            <td class="formFields">
                <input name="pro_id" id="pro_id" type="text" class="campos" size="10" 
                       value="<?php print $pro_id_seleccion;?>" onkeyUp="validarNro(this)" />
            </td>
            <td>
                <input type="button" id="busca_producto" name="busca_producto" class="boton" value="Buscar"
                       onclick='seleccionar(<?php echo $_SESSION["suc_id"].",\"".$tipo."\",\"\",\"".$tip_id."\"";?>);' />
            </td>
            <input type="hidden" id="tip_id" name="tip_id" value="<?php echo $tip_id;?>" />
          </tr>
          <?php
//          if ($tip_id!='') {
          ?>
<!--                <input type="button" id="busca_producto" name="busca_producto" class="boton" value="Buscar" onclick='seleccionar(<?php //echo $_SESSION["suc_id"].",\"".$tipo."\",\"\",\"".$tip_id."\"";?>);' />
                <input type="button" id="busca_producto" name="busca_producto" class="boton" value="Buscar" onclick='seleccionar(<?php //echo $_SESSION["suc_id"].",\"".$tipo."\",\"\",".$tip_id;?>);' />
              <tr>
                <td class="formTitle">MARCA</td>
                <td>
                        <?php
/*                        include_once 'class/marcas.php';
                        $mar = new marcas();
                        $res = $mar->getmarcasxTipIdComboNulo($tip_id, $mar_id);
                        print $res;
*/                        ?>
                </td>
                <td class="formTitle">MODELO</td>
                <td>
-->                    <?php
/*                    include_once 'class/modelos.php';
                    if (isset($mod_id) and $mod_id!="" and $mod_id!=0) {
                        $mod = new modelos();
                        $res = $mod->get_modelosComboxTipIdyMarId($tip_id, $mar_id, $mod_id);
                        print $res;
                    } else {
                        print '<select disabled="disabled" name="modelos" id="modelos">';
                        print '<option value="0">Selecciona opci&oacute;n...</option>';
                        print '</select>';
                    }
*/                    ?>
<!--                </td>
              </tr>
-->            <?php
            //Neumaticos:
//            if ($tip_id==4) {
            ?>
<!--              <tr>
                <td class="formTitle">ALTO</td>
                <td><input type="text" name="pro_med_alto" id="pro_med_alto" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $pro_med_alto;?>" /></td>
-->            <?php
            //Llantas_deportivas/Llantas_originales/Llantas Replicas:
//            } elseif (($tip_id==3 || $tip_id==2) or ($tip_id==9)) {
            ?>
<!--              <tr>
                <td class="formTitle">DISTRIBUCION</td>
                <td><input type="text" name="pro_distribucion" id="pro_distribucion" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $pro_distribucion;?>" /></td>
-->            <?php
/*            } 
            //Neumaticos-Llantas_deportivas/Llantas_originales/Llantas Replicas:
            if (($tip_id==4) or (($tip_id==3 || $tip_id==2) or ($tip_id==9))) {
*/            ?>
<!--                <td class="formTitle">ANCHO</td>
                <td><input type="text" name="pro_med_ancho" id="pro_med_ancho" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $pro_med_ancho;?>" /></td>
                <td class="formTitle">DIAMETRO</td>
                <td><input type="text" name="pro_med_diametro" id="pro_med_diametro" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $pro_med_diametro;?>" /></td>
              </tr>
              <tr>
                <td class="formTitle">RANGO</td>
                <td>
-->                        <?php
/*                        include_once 'class/tipo_rango.php';
                        $tpr = new tipo_rango();
                        $res = $tpr->gettipo_rangoComboNulo($tr_id);
                        print $res;
*/                        ?>
<!--                </td>
                <td class="formTitle">ESTADO</td>
                <td>
                <select name='estados' id='estados' class='formFields' >
-->                <?php //if ($pro_nueva=='1'){?>
<!--                    <option value=''></option>
                    <option value='1' selected>Nuevo</option>
-->                <?php// } else {?>
<!--                    <option value='' selected></option>
                    <option value='1'>Nuevo</option>
-->                <?php // }?>
<!--                </select>
                </td>
              </tr>
-->            <?php
//            }//$tip_id==4
            ?>
<!--              <tr>
                <td colspan="6" align="center" class="formFields">
                  <input id="filtrar" name="filtrar" type="submit" class="boton" value="Filtrar" ></input>
                  <a href="alta_movimientos_stock.php?tipo=<?php //echo$tipo;?>&limpiar_form=S">
                      <input class="boton" type="button" value="Limpiar" />
                  </a>
                </td>
              </tr>
-->            <?php
            //$cantidad = $_SESSION["ocarrito_stock"]->get_num_productos();
            /*            if (isset($_POST['filtrar']) or isset($_POST['agregar']) or
                         ($_SESSION["ocarrito_stock"]->existe_carrito()=='si') or isset($_GET['error'])){
            */
            ?>
              <tr>
                <td class="formTitle">PRODUCTO</td>
                <td>
                    <?php
                    //   ." dist:".$pro_distribucion." tr:".$tr_id." nueva:".$pro_nueva." alto:".$pro_med_alto;
                    //if (isset($tip_id)) {
                     if ($tip_id!="" and $tip_id!="0") {
                        include_once 'class/productos.php';
                        $pro = new productos();
                        $res = $pro->getproductosCombo_MS($tip_id,$mar_id,$mod_id,$pro_med_ancho,$pro_med_diametro
                                ,$pro_distribucion,$tr_id,$pro_nueva,$pro_med_alto,'',$tipo,$_SESSION["suc_id"]
                                , $pro_id_seleccion);
                        print $res;
                     } elseif ($pro_id_seleccion!="" and $pro_id_seleccion!="0") {
                        include_once 'class/productos.php';
                        $pro1 = new productos();
                        $res1 = $pro1->getproductosCombo_MS($tip_id,'','','','','','','','','',$tipo,$_SESSION["suc_id"]
                                ,$pro_id_seleccion);
                        print $res1;
                     } else {
                        print '<select disabled="disabled" name="productos_ms" id="productos_ms">';
                        print '<option value="0">Selecciona opci&oacute;n...</option>';
                        print '</select>';
                     }
                    ?>
                </td>
            <td class="formTitle">CANTIDAD</td>
            <td class="formFields">
                <input name="cantidad" id="cantidad" type="text" class="campos" size="15" onkeyUp="validarNro(this)" />
            </td>
            <td class="formTitle">OBSERVACIONES</td>
            <td class="formFields">
                <textarea id="observaciones" name="observaciones" rows="1" cols="30" onKeyUp="this.value=this.value.toUpperCase()"></textarea>
            </td>
          </tr>
          <tr>
            <td colspan="6" align="center" class="formFields">
              <!--<input id="agregar" name="agregar" type="submit" class="boton" value="Agregar" />-->
              <input type="button" id="btn_agregar" name="btn_agregar" class="boton" value="Agregar" onClick="agregar();" />
            </td>
          </tr>
       </table>
       <table align="center" cellpadding="0" cellspacing="1" class="form">
          <tr>
            <td class="rowGris">Código</td>
            <td class="rowGris">Descripción</td>
            <td class="rowGris">Cantidad</td>
            <td class="rowGris">Observaciones</td>
            <td class="rowGris"></td>
          </tr>
            <?php
            $mostrar = $_SESSION["ocarrito_stock"]->imprime_carrito($tipo,$tip_id,$_SESSION["suc_id"]
                    ,$_SESSION["suc_des_id"],$_SESSION["remito"]);
            echo $mostrar;
            ?>
            <?php
//            }//(isset($_POST['filtrar']) or isset($_POST['agregar']))
            ?>
            <?php
            if ((isset($_POST['agregar'])) or
             ($_SESSION["ocarrito_stock"]->existe_carrito()=='si')){
//echo"agregar-exis-carr";
            ?>
          <tr>
            <td colspan="6" align="center" class="formFields">
              <input id="enviar" name="enviar" type="submit" class="boton" value="Enviar" />
              <a href="alta_movimientos_stock.php?tipo=<?php echo$tipo;?>&limpiar_form=S">
                  <input class="boton" type="button" value="Cancelar" />
              </a>
            </td>
          </tr>
          <?php
            }//(isset($_POST['filtrar']) or isset($_POST['agregar']))
//          }//if ($tip_id!='')
          ?>
          <tr>
              <td colspan="2" class="mensaje">
          		<?php
          		if (isset($mensaje)) {
          			echo $mensaje;
          		}
          		?>
          	</td>
          </tr>
       </table>
    </form>
    <!--End FORM -->
 </div> 
 <!--End CENTRAL -->
 <br clear="all" />
</div>
<script type="text/javascript" src="select_dependientes_xTipId.js"></script>
<script type="text/javascript">
function Irfoco(ID){
document.getElementById(ID).focus();
}
</script>
<script type="text/javascript">
  function armaFiltro(idSelectOrigen,tipo)
  {
    //alert('tipo'+tipo);
    // Obtengo la posicion que ocupa el select que debe ser cargado en el array declarado mas arriba
    var posicionSelectDestino=buscarEnArray(listadoSelects, idSelectOrigen)+1;
    // Obtengo el select que el usuario modifico
    var selectOrigen=document.getElementById(idSelectOrigen);
    // Obtengo la opcion que el usuario selecciono
    var opcionSeleccionada=selectOrigen.options[selectOrigen.selectedIndex].value;

    var fecha = document.getElementById('fecha').value;
    var remito = document.getElementById('remito').value;
    var suc_id = document.getElementById('sucursales').value;
    if(tipo=='T'){
        var suc_des_id = document.getElementById('sucursales_des').value;
    }else{
        var suc_des_id =0;
    }
    if(opcionSeleccionada!=0)
    {
        // Obtengo el elemento del select que debo cargar
        var idSelectDestino=listadoSelects[posicionSelectDestino];
        var selectDestino=document.getElementById(idSelectDestino);
        location.href = 'alta_movimientos_stock.php?tipo='+tipo+'&tip_id='+opcionSeleccionada+'&fecha='+fecha
            +'&suc_id='+suc_id+'&suc_des_id='+suc_des_id+'&remito='+remito;
    }
  }
</script>
<script type="text/javascript" language="JavaScript">
function agregar(){
  var posicion=document.getElementById('productos_ms').options.selectedIndex; //posicion
  var descripcion=(document.getElementById('productos_ms').options[posicion].text); //valor
  var pro_id=(document.getElementById('productos_ms').options[posicion].value); //valor
  var cantidad = document.getElementById('cantidad').value;
  var observaciones = document.getElementById('observaciones').value;
  var sucursal = document.getElementById('sucursales').value;
  var remito = document.getElementById('remito').value;
  var tipo = document.getElementById('tipo').value;
  var tip_id = document.getElementById('tip_id').value;
  var fecha=document.getElementById('fecha').value;
    if(tipo=='T'){
        var suc_des_id = document.getElementById('sucursales_des').value;
    }else{
        var suc_des_id =0;
    }
  /*alert ('tip_id:' + tip_id);*/
  location.href = 'class/agregar_carrito_stock.php?pro_id=' + pro_id + '&pro_descripcion=' + descripcion+'&fecha='+fecha 
      + '&pro_cantidad=' + cantidad + '&observaciones=' + observaciones + '&sucursal=' + sucursal + '&tipo=' + tipo
      + '&tip_id=' + tip_id + '&suc_des_id=' + suc_des_id + '&remito=' + remito;
}
function seleccionar(suc_id, tipo, suc_des_id, ptip_id){
  //var posicion=document.getElementById('tipo_productos').options.selectedIndex.value;
  var pro_id = document.getElementById('pro_id').value;
  var posicion=document.getElementById('tipo_productos').value;
  var suc_id=document.getElementById('sucursales').value;
  var remito = document.getElementById('remito').value;
  var fecha=document.getElementById('fecha').value;
  //alert('posicion:'+posicion);
  if (posicion=='' || posicion==0){
    var tip_id = ptip_id;
    if (ptip_id=='' || ptip_id==0){
        var tip_id=document.getElementById('tip_id').value;
    }
  }else{
    var tip_id = posicion;
  }//alert('tip_id:'+tip_id);
  if (tipo=='T'){
        var suc_des_id = document.getElementById('sucursales_des').value;
        if (suc_id != 0 && suc_des_id != 0 && suc_id != "" && suc_des_id != ""){
            if (suc_id == suc_des_id){
                var mje_error='S';
                alert("Las sucursales deben ser diferentes");}
        }else {
            alert("Falta ingresar alguna sucursal");
        }
  } else {
        var suc_des_id =0;
  }
  
  if (tipo!='T' || (tipo=='T' && mje_error!='S')){
    if (pro_id!='' && pro_id!=0){
      location.href = 'alta_movimientos_stock.php?tip_id='+posicion+'&suc_id='+suc_id+'&tipo='+tipo
              +'&suc_des_id='+suc_des_id+'&fecha='+fecha + '&remito=' + remito + '&pro_id_seleccion=' + pro_id
              +'&tip_id='+tip_id;
          //opener.location='alta_movimientos_stock.php?pro_id_seleccion=' + pro_id + '&tip_id=' + tip_id + '&tipo=' + tipo + '&suc_des_id=' + suc_des_id + '&suc_id=' + suc_id + '&remito=' + remito;
    } else 
      if (posicion!=='' && posicion!=0){
        if (posicion==2 || posicion==9){
            window.open('seleccion_producto.php?tip_id='+posicion+'&suc_id='+suc_id+'&tipo='+tipo+'&suc_des_id='+suc_des_id
                +'&fecha='+fecha+ '&remito=' + remito,'Selecciona producto','scrollbars=No,status=yes,width=1200,height=400,left=200,top=150 1');
        } else if(posicion==4){
            window.open('seleccion_producto_neum.php?tip_id='+posicion+'&suc_id='+suc_id+'&tipo='+tipo
                +'&suc_des_id='+suc_des_id+'&fecha='+fecha + '&remito=' + remito,'Selecciona producto','scrollbars=No,status=yes,width=1150,height=400,left=200,top=150 1');
        } else {
            window.open('seleccion_producto_gral.php?tip_id='+posicion+'&suc_id='+suc_id+'&tipo='+tipo+'&suc_des_id='+suc_des_id
                +'&fecha='+fecha+ '&remito=' + remito,'Selecciona producto','scrollbars=No,status=yes,width=1000,height=400,left=200,top=150 1');
        }
        //window.open('seleccion_producto.php?tip_id='+posicion,'Selecciona producto','scrollbars=No,status=yes,width=1000,height=400,left=200,top=150 1');
      }else {
          alert('No se encontró producto. Buscar por Tipo Producto');
      }
  }
}
//*** Este Codigo permite Validar que sea un campo Numerico
    function Solo_Numerico(variable){
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
    function validarNro(Control){
        Control.value=Solo_Numerico(Control.value);
    }
</script>
</body>
</html>