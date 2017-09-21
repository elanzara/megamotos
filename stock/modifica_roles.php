<?php 
include_once 'class/session.php';
include_once 'class/roles.php'; // incluye las clases
include_once 'class/conex.php';
$mensaje="";

//Si en la grilla selecciono para modificar muestro los datos del grupo
if (isset($_GET['md'])) {
	//Instancio el objeto roles
	$rol = new roles($_GET['md']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['rol_descripcion'])){
    $mensajeError="";

    /*validaciones*/
    if (isset($_POST['rol_descripcion'])) {
        if ($_POST['rol_descripcion']=="") {
            $mensajeError .= "Falta completar el campo Descripción.</br>";
        }
    }

    /*validaciones*/
    if ($mensajeError!="") {
        $mensaje = $mensajeError;
    } else {
	//si le dio un click al boton enviar modifico los datos
	if (isset($_POST['rol_id'])){
		//Instancio el objeto
                $rol = new roles($_POST['rol_id']);
		//Seteo las variables
                $rol->set_rol_DESCRIPCION($_POST['rol_descripcion']);
		$resultado=$rol->update_rol();

		if ($resultado>0){
			$mensaje="El rol se modificó correctamente";
		} else {
			$mensaje="El rol no se pudo modificar";
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
<body onLoad="Irfoco('rol_descripcion')">
<div id="page"> 
 <!--Start HEADER -->
 <?php require_once("header.php") ?>
 <!-- End HEADER -->
  <!--Start CENTRAL -->
 <div id="central">
 <h1>Modificar roles </h1>
  <!--Start FORM -->
  <table class="form">
   <tr>
   <td >
   <?php
    echo "<FORM ACTION='modifica_roles.php' METHOD='POST'  enctype='multipart/form-data'>";
    echo "<table>";
    echo "<tr>";
    echo "<td>";
    echo "<input name='rol_id' id='rol_id' value='$rol->rol_id' type='hidden' class='campos' size='18' />";
    echo "</tr>";

    echo "<tr>";
    echo "</td>";
    echo "<td class='formTitle'>";
    echo "DESCRIPCION:";
    echo "</td>";
    echo "<td class='formFields'>";
    echo "<input name='rol_descripcion' id='rol_descripcion' value='$rol->rol_descripcion' type='text' class='campos' size='80' onkeyup=\"this.value=this.value.toUpperCase()\" />";
    echo "</td>";
    echo "</tr>";
 
    echo "<tr>";
    echo "<td colspan='2' align='center' class='formFields'>";
    echo "<input type='submit' value='Enviar' class='boton' />";
    echo "<input type='button' class='boton' value='Volver' onClick=\"window.location.href='abm_roles.php'\" /></td>";
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