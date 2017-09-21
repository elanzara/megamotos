<?php
include_once 'class/session.php';
include_once 'class/tipo_productos.php'; // incluye las clases
include_once 'class/conex.php';
$mensaje="";
$tip_3cuotas = 0;
$tip_6cuotas = 0;
$tip_12cuotas = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tip_descripcion'])) {
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
	//Instancio el objeto
    $tip = new tipo_productos();
	//Seteo las variables
    $tip->set_TIP_DESCRIPCION($_POST['tip_descripcion']);
    $tip_3cuotas = (isset($_POST['tip_3cuotas'])) ? (double) $_POST['tip_3cuotas'] : 0;
    $tip_6cuotas = (isset($_POST['tip_6cuotas'])) ? (double) $_POST['tip_6cuotas'] : 0;
    $tip_12cuotas =  (isset($_POST['tip_12cuotas'])) ? (double) $_POST['tip_12cuotas'] : 0;
    $tip->set_tip_3cuotas($tip_3cuotas);
	$tip->set_tip_6cuotas($tip_6cuotas);
    $tip->set_tip_12cuotas($tip_12cuotas);
    
    //Inserto el registro
	$resultado=$tip->insert_TIP();

	if ($resultado>0){
		$mensaje="El tipo producto se dio de alta correctamente";
	} else {
		$mensaje="No se pudo dar de alta el tipo producto";
	}
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>MEGAMOTOS - Admin</title>
<link rel="icon" href="images/favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="../imagenes/tu-logo-mitad2.jpg"></link>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>
<body onLoad="Irfoco('tip_descripcion')">
<div id="page"> 
 <!--Start HEADER -->
 <?php require_once("header.php") ?>
 <!-- End HEADER -->
  <!--Start CENTRAL -->
 <div id="central">
   <h1>Alta de Tipos Producto</h1>
   <!--Start FORM -->
     <form ACTION="alta_tipo_productos.php" METHOD="POST" enctype="multipart/form-data">
        <table align="center" cellpadding="0" cellspacing="1" class="form">
          <tr>
            <td class="formTitle">DESCRIPCION</td>
            <td class="formFields">
                <input name="tip_descripcion" id="tip_descripcion" type="text" class="campos" size="80" onkeyup="this.value=this.value.toUpperCase()" />
            </td>
          </tr>
          <tr>
            <td class="formTitle">PORCENTAJE 3 CUOTAS</td>
            <td class="formFields">
                <input name="tip_3cuotas" id="tip_3cuotas" type="text" class="campos" size="80" onkeyup="this.value=this.value.toUpperCase()" />
            </td>
          </tr>
          <tr>
            <td class="formTitle">PORCENTAJE 6 CUOTAS</td>
            <td class="formFields">
                <input name="tip_6cuotas" id="tip_6cuotas" type="text" class="campos" size="80" onkeyup="this.value=this.value.toUpperCase()" />
            </td>
          </tr>
          <tr>
          <tr>
            <td class="formTitle">PORCENTAJE 12 CUOTAS</td>
            <td class="formFields">
                <input name="tip_12cuotas" id="tip_12cuotas" type="text" class="campos" size="80" onkeyup="this.value=this.value.toUpperCase()" />
            </td>
          </tr>
            <td colspan="2" align="center" class="formFields">
              <input type="submit" class="boton" value="Enviar" />
              <a href='abm_tipo_productos.php'>
                <input type='button' class='boton' value='Volver' onClick="window.location.href='abm_tipo_productos.php'" />
              </a>
            </td>
          </tr>
          <tr>
              <td colspan="2" class="mensaje">
          		<?php 
          		if (isset($mensaje)) {
          			echo $mensaje;
          		}
          		?>
          	</td>
          </tr>
       </table>		
       <?php
        if (isset($_POST["mensaje"])) {
        	if ($_POST["mensaje"]!=""){
        		$mensaje=$_POST["mensaje"];
			echo "<br><br><span class='Estilo3'><B>$mensaje</span>";
	}}
       ?>
     </form>
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