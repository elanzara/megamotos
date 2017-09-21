<?php 
include_once 'class/session.php';
include_once 'class/modelos.php'; // incluye las clases
include_once 'class/conex.php';

$mensaje="";

$MOD_DESCRIPCION="";

//Si en la grilla selecciono para modificar muestro los datos de la modegoria
if (isset($_GET['md'])) {
	//Instancio el objeto modelos
	$mod = new modelos($_GET['md']);
        $MOD_DESCRIPCION = $mod->get_MOD_DESCRIPCION();
}

if($_SERVER["REQUEST_METHOD"] == "POST" /* && isset($_POST['MOD_DESCRIPCION'])*/){

    $mensajeError="";

    $mod = new modelos($_POST['mod_id']);
    $MOD_DESCRIPCION = $mod->get_MOD_DESCRIPCION();

    /*validaciones*/
    if (isset($_POST['mod_descripcion'])) {
        if ($_POST['mod_descripcion']=="") {
            $mensajeError .= "Falta completar el campo Descripción.</br>";
        }
    }
    /*validaciones*/

    if ($mensajeError!="") {
        $mensaje = $mensajeError;
        if (isset($_POST['mod_id'])){
            $mod = new modelos($_POST['mod_id']);
        }
    } else {
	//si le dio un click al boton enviar modifico los datos
	if (isset($_POST['mod_id'])){
            //Instancio el objeto 
            $mod = new modelos($_POST['mod_id']);
            //Seteo las variables
            $mod->set_MOD_DESCRIPCION($_POST['mod_descripcion']);
            $mod->set_MAR_ID($_POST['marcas']);
            //actualizo los datos
            $resultado=$mod->update_MOD();
            if ($resultado>0){
                    $mensaje="El modelo se modificó correctamente";
                    $MOD_DESCRIPCION="";
            } else {
                    $mensaje="El modelo no se pudo modificar";
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
<body onLoad="Irfoco('mod_descripcion')">
<div id="page"> 
 <!--Start HEADER -->
 <?php require_once("header.php") ?>
 <!-- End HEADER -->
  <!--Start CENTRAL -->
 <div id="central">
  <h1>Modificar Modelos </h1>
  <!--Start FORM -->
  <table class="form">
   <tr>
   <td >
  <?php
    echo "<FORM ACTION='modifica_modelos.php' METHOD='POST'  enctype='multipart/form-data'>";
    echo "<table>";
    echo "<tr>";
    echo "<td>";
    echo "<input name='mod_id' id='mod_id' value='$mod->mod_id' type='hidden' class='campos' size='18' />";
    echo "</tr>";

    echo '<tr>';
    echo '<td class="formTitle">';
    echo 'MARCA</td>';
    echo '<td class="formFields">';
                include_once 'class/marcas.php'; // incluye las clases
                $mar = new marcas();
                $html = $mar->getmarcasComboTodos($mod->mar_id);
                echo $html;
    echo '</td>';
    echo '</tr>';

    echo "<tr>";
    echo "</td>";
    echo "<td class='formTitle'>";
    echo "DESCRIPCION:";
    echo "</td>";
    echo "<td class='formFields'>";
    echo "<input name='mod_descripcion' id='mod_descripcion' value='".$MOD_DESCRIPCION."' type='text' class='campos' size='80' onkeyup=\"this.value=this.value.toUpperCase()\" />";
    echo "</td>";
    echo "</tr>";

    echo '<tr>';
    echo '<td colspan="2" align="right">';
    echo '<a href="alta_productos.php?mar_id='.$mod->mod_id.'&mod_id='.$mod->mod_id.'"><img src="images/add.png" alt="Agregar" align="absmiddle" /> Agregar productos al modelo</a><br><br>';
    echo '</td>';
    echo '</tr>';

    echo "<tr>";
    echo "<td colspan='2' align='center' class='formFields'>";
    echo "<input type='submit' value='Enviar' class='boton' />";
    echo "<input type='button' class='boton' value='Volver' onClick=\"window.location.href='abm_modelos.php'\" /></td>";
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