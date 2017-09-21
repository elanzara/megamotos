<?php 
include_once 'class/session.php';
include_once 'class/sucursales.php'; // incluye las clases
include_once 'class/conex.php';
$mensaje="";

//Si en la grilla selecciono para modificar muestro los datos del grupo
if (isset($_GET['md'])) {
	//Instancio el objeto sucursales
	$suc = new sucursales($_GET['md']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['suc_descripcion'])){
    $mensajeError="";

    /*validaciones*/
    if (isset($_POST['suc_descripcion'])) {
        if ($_POST['suc_descripcion']=="") {
            $mensajeError .= "Falta completar el campo Descripción.</br>";
        }
    }

    /*validaciones*/
    if ($mensajeError!="") {
        $mensaje = $mensajeError;
    } else {
	//si le dio un click al boton enviar modifico los datos
	if (isset($_POST['suc_id'])){
		//Instancio el objeto
        $suc = new sucursales($_POST['suc_id']);
		//Seteo las variables
        $suc->set_suc_DESCRIPCION($_POST['suc_descripcion']);
        $suc->set_suc_calle($_POST['suc_calle']);
        $suc->set_suc_numero($_POST['suc_numero']);
        $suc->set_suc_piso($_POST['suc_piso']);
        $suc->set_suc_departamento($_POST['suc_departamento']);
        $suc->set_suc_codigo_postal($_POST['suc_codigo_postal']);
        $suc->set_suc_ciudad($_POST['suc_ciudad']);
        $suc->set_suc_provincia($_POST['suc_provincia']);
        $suc->set_suc_telefono1($_POST['suc_telefono1']);
        $suc->set_suc_telefono2($_POST['suc_telefono2']);
        $suc->set_suc_rubro($_POST['suc_rubro']);
        $suc->set_suc_numero_sucursal($_POST['suc_numero_sucursal']);
        $suc->set_suc_ultima_factura($_POST['suc_ultima_factura']);
        $suc->set_suc_ultima_nc($_POST['suc_ultima_nc']);
        $suc->set_suc_ultima_nd($_POST['suc_ultima_nd']);
        $suc->set_suc_ultimo_recibo($_POST['suc_ultimo_recibo']);
        $suc->set_suc_mail($_POST['suc_mail']);
                        
		$resultado=$suc->update_suc();

		if ($resultado>0){
			$mensaje="La sucursal se modificó correctamente";
		} else {
			$mensaje="La sucursal no se pudo modificar";
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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-15" />
</head>
<body onLoad="Irfoco('suc_descripcion')">
<div id="page"> 
 <!--Start HEADER -->
 <?php require_once("header.php") ?>
 <!-- End HEADER -->
  <!--Start CENTRAL -->
 <div id="central">
 <h1>Modificar sucursales </h1>
  <!--Start FORM -->
  <table class="form">
   <tr>
   <td >
   <?php
    echo "<FORM ACTION='modifica_sucursales.php' METHOD='POST'  enctype='multipart/form-data'>";
    echo "<table>";
    echo "<tr>";
    echo "<td>";
    echo "<input name='suc_id' id='suc_id' value='".$suc->suc_id."' type='hidden' class='campos' size='18' />";
    echo "</tr>";

    echo "<tr>";
    echo "</td>";
    echo "<td class='formTitle'>";
    echo "DESCRIPCION:";
    echo "</td>";
    echo "<td class='formFields' colspan='5'>";
    echo "<input name='suc_descripcion' id='suc_descripcion' value='".$suc->suc_descripcion."' type='text' class='campos' size='80' onkeyup=\"this.value=this.value.toUpperCase()\" />";
    echo "</td>";
    echo "</tr>";
 
 
echo '<tr>';
echo '<td class="formTitle">CALLE</td>';
echo '<td class="formFields">';
echo '<input name="suc_calle" id="suc_calle" value="'.$suc->suc_calle.'" type="text" class="campos" size="60" onkeyup="this.value=this.value.toUpperCase()" />';
echo '</td>';
echo '<td class="formTitle">NUMERO</td>';
echo '<td class="formFields">';
echo '<input name="suc_numero" id="suc_numero" value="'.$suc->suc_numero.'" type="text" class="campos" size="7" onkeyup="this.value=this.value.toUpperCase()" />';
echo '</td>';
echo '<td class="formTitle">PISO</td>';
echo '<td class="formFields">';
echo '<input name="suc_piso" id="suc_piso" value="'.$suc->suc_piso.'" type="text" class="campos" size="7" onkeyup="this.value=this.value.toUpperCase()" />';
echo '</td>';
echo '<td class="formTitle">DEPARTAMENTO</td>';
echo '<td class="formFields">';
echo '<input name="suc_departamento" id="suc_departamento" value="'.$suc->suc_departamento.'" type="text" class="campos" size="7" onkeyup="this.value=this.value.toUpperCase()" />';
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td class="formTitle">CIUDAD</td>';
echo '<td class="formFields">';
echo '<input name="suc_ciudad" id="suc_ciudad" value="'.$suc->suc_ciudad.'" type="text" class="campos" size="60" onkeyup="this.value=this.value.toUpperCase()" />';
echo '</td>';
echo '<td class="formTitle">PROVINCIA</td>';
echo '<td class="formFields" colspan="3">';
echo '<input name="suc_provincia" id="suc_provincia" value="'.$suc->suc_provincia.'" type="text" class="campos" size="30" onkeyup="this.value=this.value.toUpperCase()" />';
echo '</td>';
echo '<td class="formTitle">COD.POSTAL</td>';
echo '<td class="formFields">';
echo '<input name="suc_codigo_postal" id="suc_codigo_postal" value="'.$suc->suc_codigo_postal.'" type="text" class="campos" size="7" onkeyup="this.value=this.value.toUpperCase()" />';
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td class="formTitle">RUBRO</td>';
echo '<td class="formFields">';
echo '<input name="suc_rubro" id="suc_rubro" value="'.$suc->suc_rubro.'" type="text" class="campos" size="60" onkeyup="this.value=this.value.toUpperCase()" />';
echo '</td>';
echo '<td class="formTitle">TEL. 1</td>';
echo '<td class="formFields" colspan="3">';
echo '<input name="suc_telefono1" id="suc_telefono1" value="'.$suc->suc_telefono1.'" type="text" class="campos" size="20" onkeyup="this.value=this.value.toUpperCase()" />';
echo '</td>';
echo '<td class="formTitle">TEL. 2</td>';
echo '<td class="formFields">';
echo '<input name="suc_telefono2" id="suc_telefono2" value="'.$suc->suc_telefono2.'" type="text" class="campos" size="20" onkeyup="this.value=this.value.toUpperCase()" />';
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td class="formTitle">N.SUCURSAL</td>';
echo '<td class="formFields" colspan="7">';
echo '<input name="suc_numero_sucursal" id="suc_numero_sucursal" value="'.$suc->suc_numero_sucursal.'" type="text" class="campos" size="100" onkeyup="this.value=this.value.toUpperCase()" />';
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td class="formTitle">U.FACTURA</td>';
echo '<td class="formFields">';
echo '<input name="suc_ultima_factura" id="suc_ultima_factura" value="'.$suc->suc_ultima_factura.'" type="text" class="campos" size="60" onkeyup="this.value=this.value.toUpperCase()" />';
echo '</td>';
echo '<td class="formTitle">RECIBO</td>';
echo '<td class="formFields">';
echo '<input name="suc_ultimo_recibo" id="suc_ultimo_recibo" value="'.$suc->suc_ultimo_recibo.'" type="text" class="campos" size="7" onkeyup="this.value=this.value.toUpperCase()" />';
echo '</td>';
echo '<td class="formTitle">N/C</td>';
echo '<td class="formFields">';
echo '<input name="suc_ultima_nc" id="suc_ultima_nc" value="'.$suc->suc_ultima_nc.'" type="text" class="campos" size="7" onkeyup="this.value=this.value.toUpperCase()" />';
echo '</td>';
echo '<td class="formTitle">N/D</td>';
echo '<td class="formFields">';
echo '<input name="suc_ultima_nd" id="suc_ultima_nd" value="'.$suc->suc_ultima_nd.'" type="text" class="campos" size="7" onkeyup="this.value=this.value.toUpperCase()" />';
echo '</td>';
echo '</tr>';

echo '</tr>';
echo '<td class="formTitle">Mail</td>';
echo '<td class="formFields">';
echo '<input name="suc_mail" id="suc_mail" value="'.$suc->suc_mail.'" type="text" class="campos" size="60" />';
echo '</td>';
echo '</tr>';
 


 
    echo "<tr>";
    echo "<td colspan='2' align='center' class='formFields'>";
    echo "<input type='submit' value='Enviar' class='boton' />";
    echo "<input type='button' class='boton' value='Volver' onClick=\"window.location.href='abm_sucursales.php'\" /></td>";
    echo "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class='mensaje' colspan=2>";
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