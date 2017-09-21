<?php 
include_once 'class/session.php';
include_once 'class/tipo_productos.php'; // incluye las clases
include_once 'class/conex.php';
$mensaje="";
$tip_3cuotas = 0;
$tip_6cuotas = 0;
$tip_12cuotas = 0;

//Si en la grilla selecciono para modificar muestro los datos del grupo
if (isset($_GET['md'])) {
	//Instancio el objeto tipo_productos
	$tip = new tipo_productos($_GET['md']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tip_descripcion'])){
    $mensajeError="";

    /*validaciones*/
    if (isset($_POST['tip_descripcion'])) {
        if ($_POST['tip_descripcion']=="") {
            $mensajeError .= "Falta completar el campo Descripción.</br>";
        }
    }

    /*validaciones*/
    if ($mensajeError!="") {
        $mensaje = $mensajeError;
    } else {
	//si le dio un click al boton enviar modifico los datos
	if (isset($_POST['tip_id'])){
		//Instancio el objeto
        $tip = new tipo_productos($_POST['tip_id']);
        $tip_3cuotas = (isset($_POST['tip_3cuotas'])) ? (double) $_POST['tip_3cuotas'] : 0;
        $tip_6cuotas = (isset($_POST['tip_6cuotas'])) ? (double) $_POST['tip_6cuotas'] : 0;
        $tip_12cuotas =  (isset($_POST['tip_12cuotas'])) ? (double) $_POST['tip_12cuotas'] : 0;

		//Seteo las variables
        $tip->set_TIP_DESCRIPCION($_POST['tip_descripcion']);
        $tip->set_tip_3cuotas($tip_3cuotas);
    	$tip->set_tip_6cuotas($tip_6cuotas);
        $tip->set_tip_12cuotas($tip_12cuotas);
        
		$resultado=$tip->update_TIP();

		if ($resultado>0){
			$mensaje="El tipo producto se modificó correctamente";
		} else {
			$mensaje="El tipo producto no se pudo modificar";
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
<body onLoad="Irfoco('tip_descripcion')">
<div id="page"> 
 <!--Start HEADER -->
 <?php require_once("header.php") ?>
 <!-- End HEADER -->
  <!--Start CENTRAL -->
 <div id="central">
 <h1>Modificar Tipos Producto </h1>
  <!--Start FORM -->
  <table class="form">
   <tr>
   <td >
   <?php
    echo "<FORM ACTION='modifica_tipo_productos.php' METHOD='POST'  enctype='multipart/form-data'>";
    echo "<table>";
    echo "<tr>";
    echo "<td>";
    echo "<input name='tip_id' id='tip_id' value='$tip->tip_id' type='hidden' class='campos' size='18' />";
    echo "</tr>";

    echo "<tr>";
    echo "</td>";
    echo "<td class='formTitle'>";
    echo "DESCRIPCION:";
    echo "</td>";
    echo "<td class='formFields'>";
    echo "<input name='tip_descripcion' id='tip_descripcion' value='$tip->tip_descripcion' type='text' class='campos' size='80' onkeyup=\"this.value=this.value.toUpperCase()\" />";
    echo "</td>";
    echo "</tr>";
 

    echo '<tr>';
    echo '<td class="formTitle">PORCENTAJE 3 CUOTAS</td>';
    echo '<td class="formFields">';
    echo '<input name="tip_3cuotas" id="tip_3cuotas" type="text" class="campos" size="80" value="'.$tip->tip_3cuotas.'" onkeyup="this.value=this.value.toUpperCase()" />';
    echo '</td>';
    echo '</tr>';
    echo '<tr>';
    echo '<td class="formTitle">PORCENTAJE 6 CUOTAS</td>';
    echo '<td class="formFields">';
    echo '<input name="tip_6cuotas" id="tip_6cuotas" type="text" class="campos" size="80" value="'.$tip->tip_6cuotas.'" onkeyup="this.value=this.value.toUpperCase()" />';
    echo '</td>';
    echo '</tr>';
    echo '<tr>';
    echo '<tr>';
    echo '<td class="formTitle">PORCENTAJE 12 CUOTAS</td>';
    echo '<td class="formFields">';
    echo '<input name="tip_12cuotas" id="tip_12cuotas" type="text" class="campos" size="80" value="'.$tip->tip_12cuotas.'" onkeyup="this.value=this.value.toUpperCase()" />';
    echo '</td>';
    echo '</tr>';

    echo "<tr>";
    echo "<td colspan='2' align='center' class='formFields'>";
    echo "<input type='submit' value='Enviar' class='boton' />";
    echo "<input type='button' class='boton' value='Volver' onClick=\"window.location.href='abm_tipo_productos.php'\" /></td>";
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