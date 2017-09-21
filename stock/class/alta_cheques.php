<?php
include_once 'class/session.php';
include_once 'class/conex.php';
include_once 'class/pagos.php'; // incluye las clases
include_once 'class/bancos.php'; // incluye las clases
include_once 'class/clientes.php'; // incluye las clases
include_once 'class/proveedores.php'; // incluye las clases
include_once 'class/cheques.php'; // incluye las clases
include_once 'class/fechas.php';

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

$tpg_id=0;
$bc_id=0;
$ch_fecha="";
$ch_fch_ch="";
$ch_numero=0;
$cli_id=0;
$ch_importe=0;
$prv_id=0;
$ch_fch_entrega="";
$ch_observaciones="";

if ($_SESSION["fecha"]=='') {
    $_SESSION["fecha"]= date("d")."/".date("m")."/".date("Y");
} elseif (isset($_GET["fecha"])){
    $_SESSION["fecha"] = $_GET["fecha"];
} elseif (isset($_POST["fecha"])){
    $_SESSION["fecha"] = $_POST["fecha"];
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['tpg_id'])) {
      $tpg_id = $_GET['tpg_id'];}
    if (isset($_GET['bc_id'])) {
      $bc_id = $_GET['bc_id'];}
	  if (isset($_GET['cli_id'])) {
      $cli_id = $_GET['cli_id'];}
    if (isset($_GET['prv_id'])) {
      $prv_id = $_GET['prv_id'];}
	   if (isset($_GET["fecha"])) {
    if ($_GET["fecha"] != ''){
        $_SESSION["fecha"] = $_GET["fecha"];
    }
  }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" ) 
{
    $mensajeError="";
    $tpg_id = ($_POST['pagos']);
	$bc_id = ($_POST['bancos']);
	$ch_fecha = ($_POST["fecha"]);
    $ch_fch_ch=($_POST['ch_fch_ch']);
    $ch_numero=($_POST['ch_numero']);
    $cli_id = ($_POST['clientes']);
    $ch_importe = ($_POST['ch_importe']);
    $prv_id = ($_POST['proveedores']);
    $ch_fch_entrega = ($_POST['ch_fch_entrega']);
    $ch_observaciones = ($_POST['ch_observaciones']);

    /*validaciones*/
	 if(isset($_POST["fecha"])){
        //Verifico la fecha ingresada.
        $_SESSION["fecha"] = checkData($_POST["fecha"]);
      }	  
      if ($_POST['pagos']==0) {
		  $mensajeError .= "Debe completar Tipo de pago.</br>";	
		}		
		elseif ($_POST['ch_fch_ch']=="") {
		  $mensajeError .= "Debe completar la fecha.</br>";	
		}		
		elseif ($_POST['ch_fch_ch']!="") {		
		$ch_fch_ch = checkData($ch_fch_ch);
		}		
		elseif ($_POST['bancos']==0) {
		  $mensajeError .= "Debe completar el banco.</br>";	
		}
		elseif ($_POST['ch_numero']==0) {
		  $mensajeError .= "Debe completar el numero de cheque.</br>";	
		}
		elseif ($_POST['clientes']==0){
		  $mensajeError .= "Debe completar el cliente.</br>";	
		}
		elseif ($_POST['ch_importe']==0) {
        $mensajeError .= "Debe completar el importe.</br>";		
        }
		
    /*validaciones*/

    if ($mensajeError!="") {
        $mensaje = $mensajeError;
                           } 
	else {
        //Instancio el objeto
		//$mensaje="antes del new";
        $ch = new cheques();

	//Seteo las variables	  
	    $fechasql = new fechas();
        $f = $_SESSION["fecha"];
        $fechaconv =$fechasql->cambiaf_a_mysql($f);
        $ch->set_ch_fecha($fechaconv);
		
        $ch->set_tpg_id($_POST['pagos']);
        $ch->set_bc_id($_POST['bancos']); 		
		
        $f = $ch_fch_ch;
        $fechaconv2 =$fechasql->cambiaf_a_mysql($f);		    		
        $ch->set_ch_fch_ch($fechaconv2);
		
		$ch->set_ch_numero($_POST['ch_numero']);
        $ch->set_cli_id($_POST['clientes']);
        $ch->set_ch_importe($_POST['ch_importe']);		
        $ch->set_prv_id($_POST['proveedores']);
		
		$f = $ch_fch_entrega;
        $fechaconv3 =$fechasql->cambiaf_a_mysql($f);		    
        $ch->set_ch_fch_entrega($fechaconv3);				
      
        $ch->set_ch_observaciones($_POST['ch_observaciones']);        
        $ch->set_ch_estado(0);
		
		//Inserto el registro
		$resultado=$ch->insert_ch();
		echo $resultado;
		
	//Inserto el registro    
	if ($resultado>0){	    
		$mensaje="El cheque se dio de alta correctamente";
        $tpg_id="";
		$bc_id="";
		$ch_fecha="";
		$ch_fch_ch="";
		$ch_numero="";
		$cli_id="";
		$ch_importe="";
		$prv_id="";
		$ch_fch_entrega="";
		$ch_observaciones="";
                	} 
	else {
		$mensaje=$mensaje."No se pudo dar de alta el cheque ";
		   }
  }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>MEGALLANTAS - Admin</title>
<link rel="shortcut icon" href="../imagenes/tu-logo-mitad2.jpg"></link>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>
<body onLoad="Irfoco('ch_apellido')">
<div id="page"> 
 <!--Start HEADER -->
 <?php require_once("header.php") ?>
 <!-- End HEADER -->
  <!--Start CENTRAL -->
 <div id="central">
  <h1>Alta de  Cheques </h1>
  <!--Start FORM -->
  <table  class="form">
   <tr>
   <td>
  <form ACTION="alta_cheques.php" METHOD="POST" enctype="multipart/form-data">        
        <table align="center" cellpadding="0" cellspacing="1" class="form">
		 <tr>
        <td class="formTitle">FECHA</td>
        <td><?php  print $_SESSION["fecha"];?></td>
      </tr>
          <tr>
            <td class="formTitle">TIPO DE PAGO</td>
            <td class="formFields">
                <?php
                include_once 'class/pagos.php';
                $tpg = new pagos();
                $html = $tpg->gettpgCombo($tpg_id);
                echo $html;
                ?>
            </td>
          </tr>	  
	    <tr>
            <td class="formTitle">CLIENTE</td>
            <td class="formFields">
                <?php
                include_once 'class/clientes.php'; // incluye las clases
                $cli = new clientes();
                $html = $cli->getcliCombo($cli_id);
                echo $html;
                ?>
            </td>
          </tr>
	   <tr>
        <td class="formTitle">FECHA DE PAGO</td>
        <td><input name="ch_fch_ch" type="text" class="campos" id="ch_fch_ch" onkeyup="this.value=this.value.toUpperCase()" value="<?php  print $ch_fch_ch;?>" size="10" maxlength="10" /></td>
      </tr>
	      <tr>
            <td class="formTitle">BANCO</td>
            <td class="formFields">
                <?php
                include_once 'class/bancos.php'; // incluye las clases
                $bc = new bancos();
                $html = $bc->getbcCombo($bc_id);
                echo $html;
                ?>
            </td>
          </tr>
	  <tr>
        <td class="formTitle">NRO DE CHEQUE</td>
        <td><input size="20" type="text" name="ch_numero" id="ch_numero" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $ch_numero;?>" /></td>
      </tr>	  
	  <tr>
        <td class="formTitle">IMPORTE</td>
        <td><input size="20" type="text" name="ch_importe" id="ch_importe" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $ch_importe;?>" /></td>
      </tr>
	   <tr>
            <td class="formTitle">ENTREGADO A</td>
            <td class="formFields">
                <?php
                include_once 'class/proveedores.php'; // incluye las clases
                $prv = new proveedores();
                $html = $prv->getproveedoresNuloCombo($prv_id);
                echo $html;
                ?>
            </td>
          </tr>
		   <tr>
        <td class="formTitle">FECHA DE ENTREGA</td>
        <td><input name="ch_fch_entrega" type="text" class="campos" id="ch_fch_entrega" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $ch_fch_entrega;?>" size="10" maxlength="10" /></td>
      </tr>
	  <tr>
        <td class="formTitle">OBSERVACIONES</td>
        <td><textarea name="ch_observaciones" cols="100" class="campos" id="ch_observaciones" onkeyup="this.value=this.value.toUpperCase()"><?php print $ch_observaciones;?></textarea></td>
      </tr>
	  <tr>
        <td colspan="2" >
            <input type="submit" class="boton" value="Enviar" />
            <a href='abm_cheques.php'>
              <input type='button' class='boton' value='Volver' onClick="window.location.href='abm_cheques.php'" />
            </a>
        </td>
      </tr>
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
    <?php
        if (isset($_POST["mensaje"])) {
            if ($_POST["mensaje"]!=""){
                    $mensaje=$_POST["mensaje"];
                    echo "<br><br><span class='Estilo3'><B>$mensaje</span>";
                    }}
    ?>
   </form>   
   </td>
   </tr>
  </table>
   <!--End FORM -->
 </div> 
 <!--End CENTRAL -->
 <br clear="all" />
</div>
<script type="text/javascript">
function Irfoco(ID){
document.getElementById(ID).focus();
}
</script>
</body>
</html>