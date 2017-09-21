<?php
include_once 'class/session.php';
include_once 'class/roles.php'; // incluye las clases
include_once 'class/conex.php';
$mensaje="";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['rol_descripcion'])) {
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
	//Instancio el objeto
        $rol = new roles();
	//Seteo las variables
        $rol->set_rol_descripcion($_POST['rol_descripcion']);
	//Inserto el registro
	$resultado=$rol->insert_rol();

	if ($resultado>0){
		$mensaje="El rol se dio de alta correctamente";
	} else {
		$mensaje="No se pudo dar de alta el rol";
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
<body onLoad="Irfoco('rol_descripcion')">
<div id="page"> 
 <!--Start HEADER -->
 <?php require_once("header.php") ?>
 <!-- End HEADER -->
  <!--Start CENTRAL -->
 <div id="central">
   <h1>Alta de roles </h1>
   <!--Start FORM -->
     <form ACTION="alta_roles.php" METHOD="POST" enctype="multipart/form-data">
        <table align="center" cellpadding="0" cellspacing="1" class="form">
          <tr>
            <td class="formTitle">DESCRIPCION</td>
            <td class="formFields">
                <input name="rol_descripcion" id="rol_descripcion" type="text" class="campos" size="80" onkeyup="this.value=this.value.toUpperCase()" />
            </td>
          </tr>
          <tr>
            <td colspan="2" align="center" class="formFields">
              <input type="submit" class="boton" value="Enviar" />
              <a href='abm_roles.php'>
                <input type='button' class='boton' value='Volver' onClick="window.location.href='abm_roles.php'" />
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