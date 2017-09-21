<?php 
include_once 'class/session.php';
include_once 'class/tipo_rango.php'; // incluye las clases
include_once 'class/conex.php';

$mensaje="";
$tr_descripcion="";
$tr_velocidad_desde="";
$tr_velocidad_hasta="";

//Si en la grilla selecciono para modificar muestro los datos
if (isset($_GET['md'])) {
	//Instancio el objeto
	$tr = new tipo_rango($_GET['md']);

        $tr_id = $tr->get_tr_id();
        $tr_descripcion = $tr->get_tr_descripcion();
        $tr_velocidad_desde = $tr->get_tr_velocidad_desde();
        $tr_velocidad_hasta = $tr->get_tr_velocidad_hasta();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tr_descripcion'])){
    $mensajeError="";

    //Instancio el objeto
    $tr = new tipo_rango($_POST['tr_id']);

    $tr_descripcion = ($_POST['tr_descripcion']);
    $tr_velocidad_desde = ($_POST['tr_velocidad_desde']);
    $tr_velocidad_hasta = ($_POST['tr_velocidad_hasta']);

    /*validaciones*/
    if (isset($_POST['tr_descripcion'])) {
        if ($_POST['tr_descripcion']=="") {
            $mensajeError .= "Falta completar el campo Descripción.</br>";
        }
    }

    /*validaciones*/
    if ($mensajeError!="") {
        $mensaje = $mensajeError;
    } else {
	//si le dio un click al boton enviar modifico los datos
	if (isset($_POST['tr_id'])){
            //Seteo las variables
            $tr->set_tr_descripcion($_POST['tr_descripcion']);
            $tr->set_tr_velocidad_desde($_POST['tr_velocidad_desde']);
            $tr->set_tr_velocidad_hasta($_POST['tr_velocidad_hasta']);
                
            $resultado=$tr->update_tr();

            if ($resultado>0){
                    $mensaje="El tipo rango se modificó correctamente";
                    $tr_descripcion="";
                    $tr_velocidad_desde="";
                    $tr_velocidad_hasta="";
            } else {
                    $mensaje="El tipo rango no se pudo modificar";
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
<body onLoad="Irfoco('tr_descripcion')">
<div id="page"> 
 <!--Start HEADER -->
 <?php require_once("header.php") ?>
 <!-- End HEADER -->
  <!--Start CENTRAL -->
 <div id="central">
 <h1>Modificar tipo rango </h1>
  <!--Start FORM -->
  <table class="form">
   <tr>
   <td >
   <?php
    echo "<FORM ACTION='modifica_tipo_rango.php' METHOD='POST'  enctype='multipart/form-data'>";
    echo "<table>";
    echo "<tr>";
    echo "<td>";
    echo "<input name='tr_id' id='tr_id' value='".$tr->tr_id."' type='hidden' class='campos' size='18' />";
    echo "</tr>";

    echo "<tr>";
    echo "</td>";
    echo "<td class='formTitle'>";
    echo "DESCRIPCION:";
    echo "</td>";
    echo "<td class='formFields' colspan='5'>";
    echo "<input name='tr_descripcion' id='tr_descripcion' value='".$tr_descripcion."' type='text' class='campos' size='80' onkeyup=\"this.value=this.value.toUpperCase()\" />";
    echo "</td>";
    echo "</tr>";
 
echo '<tr>';
echo '<td class="formTitle">VELOCIDAD DESDE</td>';
echo '<td class="formFields">';
echo '    <input name="tr_velocidad_desde" id="tr_velocidad_desde" value="'.$tr_velocidad_desde.'" type="text" class="campos" size="60" onkeyup="this.value=this.value.toUpperCase()" />';
echo '</td>';
echo '<td class="formTitle">VELOCIDAD HASTA</td>';
echo '<td class="formFields">';
echo '    <input name="tr_velocidad_hasta" id="tr_velocidad_hasta" value="'.$tr_velocidad_hasta.'" type="text" class="campos" size="7" onkeyup="this.value=this.value.toUpperCase()" />';
echo '</td>';
echo '</tr>';
 
    echo "<tr>";
    echo "<td colspan='2' align='center' class='formFields'>";
    echo "<input type='submit' value='Enviar' class='boton' />";
    echo "<input type='button' class='boton' value='Volver' onClick=\"window.location.href='abm_tipo_rango.php'\" /></td>";
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