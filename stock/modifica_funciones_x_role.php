<?php 
include_once 'class/session.php';
include_once 'class/funciones_x_role.php'; // incluye las clases
include_once 'class/funciones.php'; // incluye las clases
include_once 'class/roles.php'; // incluye las clases
include_once 'class/conex.php';

$mensaje="";

$funcion="";
$rol="";

//Si en la grilla selecciono para modificar muestro los datos
if (isset($_GET['md'])) {
	//Instancio el objeto funciones_x_role
	$fxr = new funciones_x_role($_GET['md']);
        $funcion=$fxr->get_FUN_ID();
        $rol=$fxr->get_ROL_ID();
}

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $mensajeError="";

    $fxr = new funciones_x_role($_POST['fxr_id']);
    $funcion=$fxr->get_FUN_ID();
    $rol=$fxr->get_ROL_ID();

    /*validaciones*/
    if (isset($_POST['funciones'])) {
        if ($_POST['funciones']==0) {
            $mensajeError .= "Falta completar el campo función.</br>";
        }
    } else {
        $mensajeError .= "Falta completar el campo función.</br>";
    }
    if (isset($_POST['roles'])) {
        if ($_POST['roles']==0) {
            $mensajeError .= "Falta completar el campo rol.</br>";
        }
    } else {
        $mensajeError .= "Falta completar el campo rol.</br>";
    }
    /*validaciones*/

    if ($mensajeError!="") {
        $mensaje = $mensajeError;
        if (isset($_POST['fxr_id'])){
            $fxr = new funciones_x_role($_POST['fxr_id']);
        }
    } else {
	//si le dio un click al boton enviar fxrifico los datos
	if (isset($_POST['fxr_id'])){
            //Instancio el objeto 
            $fxr = new funciones_x_role($_POST['fxr_id']);
            //Seteo las variables
            $fxr->set_FUN_ID($_POST['funciones']);
            $fxr->set_ROL_ID($_POST['roles']);
            //actualizo los datos
            $resultado=$fxr->update_fxr();
            if ($resultado>0){
                    $mensaje="La relación se modificó correctamente";
                    $fxr_DESCRIPCION="";
            } else {
                    $mensaje="La relación no se pudo modificar";
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
<body>
<div id="page"> 
 <!--Start HEADER -->
 <?php require_once("header.php") ?>
 <!-- End HEADER -->
  <!--Start CENTRAL -->
 <div id="central">
  <h1>Modificar funciones x rol </h1>
  <!--Start FORM -->
  <table class="form">
   <tr>
   <td >
  <?php
    echo "<FORM ACTION='modifica_funciones_x_role.php' METHOD='POST'  enctype='multipart/form-data'>";
    echo "<table>";
    echo "<tr>";
    echo "<td>";
    echo "<input name='fxr_id' id='fxr_id' value='$fxr->fxr_id' type='hidden' class='campos' size='18' />";
    echo "</tr>";

    echo '<tr>';
    echo '<td class="formTitle">';
    echo 'FUNCION</td>';
    echo '<td class="formFields">';
                include_once 'class/funciones.php'; // incluye las clases
                $fun = new funciones();
                $html = $fun->getfuncionesCombo($fxr->fun_id);
                echo $html;
    echo '</td>';
    echo '</tr>';

    echo '<tr>';
    echo '<td class="formTitle">';
    echo 'ROL</td>';
    echo '<td class="formFields">';
                include_once 'class/roles.php'; // incluye las clases
                $rol = new roles();
                $html = $rol->getrolesCombo($fxr->rol_id);
                echo $html;
    echo '</td>';
    echo '</tr>';

    echo "<tr>";
    echo "<td colspan='2' align='center' class='formFields'>";
    echo "<input type='submit' value='Enviar' class='boton' />";
    echo "<input type='button' class='boton' value='Volver' onClick=\"window.location.href='abm_funciones_x_role.php'\" /></td>";
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
</body>
</html>