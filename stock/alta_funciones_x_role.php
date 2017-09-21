<?php
include_once 'class/session.php';
include_once 'class/funciones_x_role.php'; // incluye las clases
include_once 'class/funciones.php'; // incluye las clases
include_once 'class/roles.php'; // incluye las clases
include_once 'class/conex.php';

$mensaje="";
$fun_id = "";
$rol_id = "";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['fun_id'])) {
      $fun_id = $_GET['fun_id'];}
    if (isset($_GET['rol_id'])) {
      $fun_id = $_GET['rol_id'];}
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mensajeError="";
    $fun_id = $_POST['funciones'];
    $rol_id = $_POST['roles'];

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

    } else {
	//Instancio el objeto 
        $fxr = new funciones_x_role();
	//Seteo las variables
        $fxr->set_FUN_ID($_POST['funciones']);
        $fxr->set_ROL_ID($_POST['roles']);
	//Inserto el registro
	$resultado=$fxr->insert_fxr();

	if ($resultado>0){
		$mensaje="La relación se dio de alta correctamente";
	} else {
		$mensaje="No se pudo dar de alta la relación";
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
<body>
<div id="page"> 
 <!--Start HEADER -->
 <?php require_once("header.php") ?>
 <!-- End HEADER -->
  <!--Start CENTRAL -->
 <div id="central">
   <h1>Alta de funciones x rol </h1>
     <!--Start FORM -->
     <form ACTION="alta_funciones_x_role.php" METHOD="POST" enctype="multipart/form-data">        
        <table align="center" cellpadding="0" cellspacing="1" class="form">
          <tr>
            <td class="formTitle">FUNCION</td>
            <td class="formFields">
                <?php 
                include_once 'class/funciones.php'; // incluye las clases
                $fun = new funciones();
                $html = $fun->getfuncionesCombo($fun_id);
                echo $html;
                ?>                
            </td>
          </tr>
          <tr>
            <td class="formTitle">ROL</td>
            <td class="formFields">
                <?php
                include_once 'class/roles.php'; // incluye las clases
                $rol = new roles();
                $html = $rol->getrolesCombo($rol_id);
                echo $html;
                ?>
            </td>
          </tr>
          <tr>
            <td colspan="2" align="center" class="formFields">
              <input type="submit" class="boton" value="Enviar" />
              <a href='abm_funciones_x_role.php'>
                <input type='button' class='boton' value='Volver' onClick="window.location.href='abm_funciones_x_role.php'" />
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
		}
        }
          ?>
    </form>
    <!--End FORM -->
 </div> 
 <!--End CENTRAL -->
 <br clear="all" />
</div>
</body>
</html>