<?php 
include_once 'class/session.php';
include_once 'class/conex.php';
include_once 'class/cheques.php';

$mensaje="";

$ch_fecha="";
$tpg_id="";
$tpg_descripcion="";
$cli_nombre="";
$ch_fch_ch="";
$bc_descripcion="";
$ch_numero="";
$ch_importe="";
$prv_descripcion="";
$ch_fch_entrega="";
$ch_observaciones="";

$ch = new cheques();

//Si en la grilla selecciono para modificar muestro los datos de la categoria
if (isset($_GET['md'])) {
	//Instancio el objeto 
	$ch = new cheques($_GET['md']);
        $ch_id = $ch->get_ch_id();
        $ch_fecha = $ch->get_ch_fecha();
        $tpg_id = $ch->get_tpg_id();
        $cli_nombre = $ch->get_cli_id();
        $ch_fch_ch = $ch->get_ch_fch_ch();
        $bc_descripcion = $ch->get_bc_id();		
        $ch_numero = $ch->get_ch_numero();		
        $ch_importe = $ch->get_ch_importe();				
        $prv_descripcion = $ch->get_prv_id();				
        $ch_fch_entrega = $ch->get_ch_fch_entrega();				
        $ch_observaciones = $ch->get_ch_observaciones();
}
 
 if ($_SERVER["REQUEST_METHOD"] == "POST" /*&& isset($_POST['PRO_DESCRIPCION'])*/){
    $mensajeError="";

    $ch = new cheques($_POST['ch_id']);

    $ch_fecha = ($_POST['ch_fecha']);
	$tpg_id = ($_POST['tpg_id']);
    $tpg_descripcion = ($_POST['tpg_descripcion']);
    $cli_nombre = ($_POST['cli_nombre']);
	$ch_fch_ch = ($_POST['ch_fch_ch']);
	$bc_descripcion = ($_POST['bc_descripcion']);
	$ch_numero = ($_POST['ch_numero']);
	$ch_importe = ($_POST['ch_importe']);
	$prv_descripcion = ($_POST['prv_descripcion']);			
	$ch_fch_entrega = ($_POST['ch_fch_entrega']);	
    $ch_observaciones = ($_POST['ch_observaciones']);

    /*validaciones*/
    if (($_POST['ch_fecha']="") or ($_POST['cli_nombre']="") or ($_POST['ch_fch_ch']="")) {
        $mensajeError .= "Debe completar Fecha, Cliente Feca de pago.</br>";
    }
    /*validaciones*/

    if ($mensajeError!="") {
        $mensaje = $mensajeError;
    } else {
	//si le dio un click al boton enviar modifico los datos
	if (isset($_POST['ch_id'])){

            //Instancio el objeto
            $ch = new cheques($_POST['ch_id']);

            //Seteo las variables
            $ch->set_ch_fecha($_POST["ch_fecha"]);
			$ch->set_tpg_id($_POST["tpg_id"]);
            $ch->set_tpg_descripcion($_POST["tpg_descripcion"]);
            $ch->set_cli_nombre($_POST["cli_nombre"]);
			$ch->set_ch_fch_ch($_POST["ch_fch_ch"]);
			$ch->set_bc_descripcion($_POST["bc_descripcion"]);
			$ch->set_ch_numero($_POST["ch_numero"]);
			$ch->set_ch_importe($_POST["ch_impore"]);
			$ch->set_prv_descripcion($_POST["prv_descripcion"]);
			$ch->set_ch_fch_entrega($_POST["ch_fch_entrega"]);
			$ch->set_ch_observaciones($_POST["ch_observaciones"]);
            
            //actualizo los datos
            $resultado=$ch->update_ch();
            //echo $resultado;
            if ($resultado>0){
                $mensaje="El Cheque se modificó correctamente";                
                $ch_fecha = "";
				$tpg_id = "";
                $tpg_descripcion = "";
                $cli_nombre = "";
                $ch_fch_ch = "";
                $bc_descripcion = "";
                $ch_numero = "";
                $ch_importe = "";
                $prv_descripcion = "";
                $ch_fch_entrega = "";		
				$ch_observaciones="";
            } else {
                $mensaje="El Cheque no se pudo modificar";
            }
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
<body onLoad="Irfoco('ch_fch_entrega')">
<div id="page"> 
 <!--Start HEADER -->
 <?php require_once("header.php") ?>
 <!-- End HEADER -->
  <!--Start CENTRAL -->
 <div id="central">
  <h1>Modificar   Cheques </h1>
  <!--Start FORM -->
  <table  class="form">
   <tr>
   <td>
   <?php
        echo "<FORM ACTION='modifica_cheques.php' METHOD='POST'  enctype='multipart/form-data'>";
        echo "<table>";
        
        echo "<tr>";
        echo "<td class='formTitle'>";
        echo "FECHA";
        echo "</td>";
        echo "<td class='formFields'>";
        echo '<input size="10" type="text" name="ch_fecha" id="ch_fecha" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="'.$ch_fecha.'" />';
        echo "</td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td class='formTitle'>";
        echo "TIPO DE PAGO";
        echo "</td>";
        echo "<td class='formFields'>";
      //  echo '<input size="30" type="text" name="tpg_descripcion" id="tpg_descripcion" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="'.$tpg_descripcion.'" />';
                include_once 'class/pagos.php'; // incluye las clases
                $pago = new pagos();
                $html = $pago->getpagosComboTpg($tpg_id);
                echo $html;
		echo "</td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td class='formTitle'>";
        echo "CLIENTE";
        echo "</td>";
        echo "<td class='formFields'>";
        echo '<input size="100" type="text" name="cli_nombre" id="cli_nombre" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="'.$cli_nombre.'" />';
        echo "</td>";
        echo "</tr>";
		
        echo "<tr>";
        echo "<td class='formTitle'>";
        echo "FECHA DE PAGO";
        echo "</td>";
        echo "<td class='formFields'>";
        echo '<input size="10" maxlength="10" type="text" name="ch_fch_ch" id="ch_fch_ch" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="'.$ch_fch_ch.'" />';
        echo "</td>";
        echo "</tr>";

        echo '<tr>';
        echo '<td class="formTitle">BANCO</td>';
        echo '<td><input size="55" type="text" name="bc_descripcion" id="bc_descripcion" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="'.$bc_descripcion.'" /></td>';
        echo '</tr>';

        echo '<tr>';
        echo '<td class="formTitle">NRO DE CHEQUE</td>';
        echo '<td><input size="30" maxlength="30" type="text" name="ch_numero" id="ch_numero" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="'.$ch_numero.'" /></td>';
        echo '</tr>';
		
        echo "<tr>";
        echo "<td class='formTitle'>";
        echo "IMPORTE";
        echo "</td>";
        echo "<td class='formFields'>";
        echo '<input size="30" type="text" name="ch_importe" id="ch_importe" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="'.$ch_importe.'" />';
        echo "</td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td class='formTitle'>";
        echo "ENTREGADO A";
        echo "</td>";
        echo "<td class='formFields'>";
        echo '<input size="50" type="text" name="prv_descripcion" id="prv_descripcion" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="'.$prv_descripcion.'" />';
        echo "</td>";
        echo "</tr>";
		
        echo "<tr>";
        echo "<td class='formTitle'>";
        echo "FECHA DE ENTREGA (YYYY-MM-DD)";
        echo "</td>";
        echo "<td class='formFields'>";
        echo '<input size="30" maxlength="10" type="text" name="ch_fch_entrega" id="ch_fch_entrega" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="'.$ch_fch_entrega.'" />';
        echo "</td>";
        echo "</tr>";

        echo '<tr>';
        echo '<td class="formTitle">';
        echo 'OBSERVACIONES</td>';
        echo '<td>';
        echo '<input size="100" type="text" name="ch_observaciones" id="ch_observaciones" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="'.$ch_observaciones.'" />';
        echo '</td>';
        echo '</tr>';

        echo "<tr>";
        echo "<td colspan='2' align='center' class='formFields'>";
        echo "<input type='submit' value='Enviar' class='boton' />";
        echo "<a href='abm_cheques.php'><input type='button' class='boton' value='Volver' onClick=\"window.location.href='abm_cheques.php'\" />";
        echo "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td class='mensaje'>";
                            if (isset($mensaje)) {
                                    echo $mensaje;
                            }
        echo "</td>";
        echo "</tr>";
        echo "</table>";
        echo "</form>";
   ?>
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