<?php 
include_once 'class/session.php';
include_once 'class/usuarios.php'; // incluye las clases
include_once 'class/conex.php';

$mensaje="";
$suc_id = 0;

//Si en la grilla selecciono para modificar muestro los datos del grupo
if (isset($_GET['md'])) {
	//Instancio el objeto usuarios
	$usu = new usuarios($_GET['md']);

        if($usu->get_suc_id()==''){
            $suc_id = 0;
        }else{
            $suc_id = $usu->get_suc_id();
        };
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['usu_descripcion'])){
    $mensajeError="";

    /*validaciones*/
    if (isset($_POST['usu_descripcion'])) {
        if ($_POST['usu_descripcion']=="") {
            $mensajeError .= "Falta completar el campo Descripción.</br>";
        }
    }
    if (isset($_POST['usu_clave'])) {
        if ($_POST['usu_clave']=="") {
            $mensajeError .= "Falta completar el campo Clave.</br>";
        }
    }

    /*validaciones*/
    if ($mensajeError!="") {
        $mensaje = $mensajeError;
    } else {
	//si le dio un click al boton enviar modifico los datos
	if (isset($_POST['usu_id'])){
		//Instancio el objeto
                $usu = new usuarios($_POST['usu_id']);
		//Seteo las variables
                $usu->set_usu_descripcion($_POST['usu_descripcion']);
                $usu->set_suc_id($_POST['sucursales']);
                $usu->set_usu_clave(md5($_POST["usu_clave"]));
                $usu->set_usu_mail($_POST["usu_mail"]);
		$resultado=$usu->update_usu();

		if ($resultado>0){
			$mensaje="El usuario se modificó correctamente";
		} else {
			$mensaje="El usuario no se pudo modificar";
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
<body onLoad="Irfoco('usu_descripcion')">
<div id="page"> 
 <!--Start HEADER -->
 <?php require_once("header.php") ?>
 <!-- End HEADER -->
  <!--Start CENTRAL -->
 <div id="central">
 <h1>Modificar usuarios </h1>
  <!--Start FORM -->
  <table class="form">
   <tr>
   <td >
   <?php
    echo "<FORM ACTION='modifica_usuarios.php' METHOD='POST'  enctype='multipart/form-data'>";
    echo "<table>";
    echo "<tr>";
    echo "<td>";
    echo "<input name='usu_id' id='usu_id' value='$usu->usu_id' type='hidden' class='campos' size='18' />";
    echo "</tr>";

    echo "<tr>";
    echo "</td>";
    echo "<td class='formTitle'>";
    echo "DESCRIPCION:";
    echo "</td>";
    echo "<td class='formFields'>";
    echo "<input name='usu_descripcion' id='usu_descripcion' value='$usu->usu_descripcion' type='text' class='campos' size='80' onkeyup=\"this.value=this.value.toUpperCase()\" />";
    echo "</td>";
    echo "</tr>";

    echo '<tr>';
    echo '<td class="formTitle">';
    echo 'SUCURSAL</td>';
    echo '<td class="formFields">';
                include_once 'class/sucursales.php';
                $suc = new sucursales();
                $html = $suc->getsucursalesnuloCombo($suc_id);
                echo $html;
    echo '</td>';
    echo '</tr>';

    echo "<tr>";
    echo "</td>";
    echo "<td class='formTitle'>";
    echo "MAIL:";
    echo "</td>";
    echo "<td class='formFields'>";
    echo "<input name='usu_mail' id='usu_mail' value='$usu->usu_mail' type='text' class='campos' size='80' />";
    echo "</td>";
    echo "</tr>";
 
    echo "<tr>";
    echo "<td class='formTitle'>";
    echo "CLAVE";
    echo "</td>";
    echo "<td class='formFields'>";
    echo "<input type='password' name='usu_clave' id='usu_clave' value='$usu->usu_clave' class='campos' />";
    echo "</td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td colspan='2' align='center' class='formFields'>";
    echo "<input type='submit' value='Enviar' class='boton' />";
    echo "<input type='button' class='boton' value='Volver' onClick=\"window.location.href='abm_usuarios.php'\" /></td>";
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