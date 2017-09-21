<?php 
include_once 'class/session.php';
include_once 'class/marcas.php'; // incluye las clases
include_once 'class/tipo_productos.php'; // incluye las clases
include_once 'class/conex.php';
$mensaje="";

//Si en la grilla selecciono para modificar muestro los datos
if (isset($_GET['md'])) {
	//Instancio el objeto marcas
	$mar = new marcas($_GET['md']);
        //$tip_id=$mar->get_tip_id();
}

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $mensajeError="";

    /*validaciones*/
    if (isset($_POST['mar_descripcion'])) {
        if ($_POST['mar_descripcion']=="") {
            $mensajeError .= "Falta completar el campo Descripción.</br>";
        }
    }

    /*validaciones*/
    if ($mensajeError!="") {
        $mensaje = $mensajeError;
    } else {
	//si le dio un click al boton enviar modifico los datos
	if (isset($_POST['mar_id'])){
		//Instancio el objeto
                $mar = new marcas($_POST['mar_id']);
		//Seteo las variables
                $mar->set_mar_descripcion($_POST['mar_descripcion']);
                //$mar->set_tip_id($_POST['tipo_productos']);
		$resultado=$mar->update_mar();

		if ($resultado>0){
			$mensaje="La marca se modificó correctamente";
		} else {
			$mensaje="La marca no se pudo modificar";
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
<body onLoad="Irfoco('mar_descripcion')">
<div id="page"> 
 <!--Start HEADER -->
 <?php require_once("header.php") ?>
 <!-- End HEADER -->
  <!--Start CENTRAL -->
 <div id="central">
 <h1>Modificar Marcas </h1>
  <!--Start FORM -->
  <table class="form">
   <tr>
   <td >
   <?php
    echo "<FORM ACTION='modifica_marcas.php' METHOD='POST'  enctype='multipart/form-data'>";
    echo "<table>";
    echo "<tr>";
    echo "<td>";
    echo "<input name='mar_id' id='mar_id' value='$mar->mar_id' type='hidden' class='campos' size='18' />";
    echo "</tr>";

//    echo "<tr>";
//    echo "  <td class='formTitle'>TIPO PRODUCTO:</td>";
//    echo "  <td>";
//        $tip = new tipo_productos();
//        $res = $tip->gettipo_productosCombo($tip_id, 'N');
//        print $res;
//    //echo "    <input type='hidden' id='tipo_productos' name='tipo_productos' value='.$tip_id.' />";
//    echo "   </td>";
//    echo "</tr>";

    echo "<tr>";
    echo "</td>";
    echo "<td class='formTitle'>";
    echo "DESCRIPCION:";
    echo "</td>";
    echo "<td class='formFields'>";
    echo "<input name='mar_descripcion' id='mar_descripcion' value='$mar->mar_descripcion' type='text' class='campos' size='80' onkeyup=\"this.value=this.value.toUpperCase()\" />";
    echo "</td>";
    echo "</tr>";
 
    echo '<tr>';
    echo '<td colspan="2" align="right">';
    echo '<a href="alta_modelos.php?mar_id='.$mar->mar_id.'"><img src="images/add.png" alt="Agregar" align="absmiddle" /> Agregar modelos a la marca </a><br><br>';
    echo '</td>';
    echo '</tr>';

    echo "<tr>";
    echo "<td colspan='2' align='center' class='formFields'>";
    echo "<input type='submit' value='Enviar' class='boton' />";
    echo "<input type='button' class='boton' value='Volver' onClick=\"window.location.href='abm_marcas.php'\" /></td>";
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