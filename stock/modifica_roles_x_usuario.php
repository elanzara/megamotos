<?php 
include_once 'class/session.php';
include_once 'class/roles_x_usuario.php'; // incluye las clases
include_once 'class/usuarios.php'; // incluye las clases
include_once 'class/roles.php'; // incluye las clases
include_once 'class/conex.php';

$mensaje="";

$rol="";
$usuario="";

//Si en la grilla selecciono para modificar muestro los datos
if (isset($_GET['md'])) {
	//Instancio el objeto roles_x_usuarios
	$rxu = new roles_x_usuario($_GET['md']);
        $rol=$rxu->get_ROL_ID();
        $usuario=$rxu->get_USU_ID();
}

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $mensajeError="";

    $rxu = new roles_x_usuario($_POST['rxu_id']);
    $rol=$rxu->get_ROL_ID();
    $usuario=$rxu->get_USU_ID();

    /*validaciones*/
    if (isset($_POST['roles'])) {
        if ($_POST['roles']==0) {
            $mensajeError .= "Falta completar el campo rol.</br>";
        }
    } else {
        $mensajeError .= "Falta completar el campo rol.</br>";
    }
    if (isset($_POST['usuarios'])) {
        if ($_POST['usuarios']==0) {
            $mensajeError .= "Falta completar el campo usuario.</br>";
        }
    } else {
        $mensajeError .= "Falta completar el campo usuario.</br>";
    }
    /*validaciones*/

    if ($mensajeError!="") {
        $mensaje = $mensajeError;
        if (isset($_POST['rxu_id'])){
            $rxu = new roles_x_usuario($_POST['rxu_id']);
        }
    } else {
	//si le dio un click al boton enviar rxuifico los datos
	if (isset($_POST['rxu_id'])){
            //Instancio el objeto 
            $rxu = new roles_x_usuario($_POST['rxu_id']);
            //Seteo las variables
            $rxu->set_ROL_ID($_POST['roles']);
            $rxu->set_USU_ID($_POST['usuarios']);
            //actualizo los datos
            $resultado=$rxu->update_rxu();
            if ($resultado>0){
                    $mensaje="La relación se modificó correctamente";
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
  <h1>Modificar roles x usuario </h1>
  <!--Start FORM -->
  <table class="form">
   <tr>
   <td >
  <?php
    echo "<FORM ACTION='modifica_roles_x_usuario.php' METHOD='POST'  enctype='multipart/form-data'>";
    echo "<table>";
    echo "<tr>";
    echo "<td>";
    echo "<input name='rxu_id' id='rxu_id' value='$rxu->rxu_id' type='hidden' class='campos' size='18' />";
    echo "</tr>";

    echo '<tr>';
    echo '<td class="formTitle">';
    echo 'ROL</td>';
    echo '<td class="formFields">';
                include_once 'class/roles.php'; // incluye las clases
                $rol = new roles();
                $html = $rol->getrolesCombo($rxu->rol_id);
                echo $html;
    echo '</td>';
    echo '</tr>';

    echo '<tr>';
    echo '<td class="formTitle">';
    echo 'USUARIO</td>';
    echo '<td class="formFields">';
                include_once 'class/usuarios.php'; // incluye las clases
                $usu = new usuarios();
                $html = $usu->getusuariosCombo($rxu->usu_id);
                echo $html;
    echo '</td>';
    echo '</tr>';

    echo "<tr>";
    echo "<td colspan='2' align='center' class='formFields'>";
    echo "<input type='submit' value='Enviar' class='boton' />";
    echo "<input type='button' class='boton' value='Volver' onClick=\"window.location.href='abm_roles_x_usuario.php'\" /></td>";
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