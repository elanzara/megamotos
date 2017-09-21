<?php
include_once 'class/session.php';
include_once 'class/roles_x_usuario.php'; // incluye las clases
include_once 'class/usuarios.php'; // incluye las clases
include_once 'class/roles.php'; // incluye las clases
include_once 'class/conex.php';

$mensaje="";
$rol_id = "";
$usu_id = "";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['rol_id'])) {
      $rol_id = $_GET['rol_id'];}
    if (isset($_GET['usu_id'])) {
      $usu_id = $_GET['usu_id'];}
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mensajeError="";
    $rol_id = $_POST['roles'];
    $usu_id = $_POST['usuarios'];

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
            $mensajeError .= "Falta completar el campo usución.</br>";
        }
    } else {
        $mensajeError .= "Falta completar el campo usución.</br>";
    }
    /*validaciones*/

    if ($mensajeError!="") {
        $mensaje = $mensajeError;

    } else {
	//Instancio el objeto 
        $rxu = new roles_x_usuario();
	//Seteo las variables
        $rxu->set_ROL_ID($_POST['roles']);
        $rxu->set_USU_ID($_POST['usuarios']);
	//Inserto el registro
	$resultado=$rxu->insert_rxu();

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
   <h1>Alta de roles x usuario </h1>
     <!--Start FORM -->
     <form ACTION="alta_roles_x_usuario.php" METHOD="POST" enctype="multipart/form-data">        
        <table align="center" cellpadding="0" cellspacing="1" class="form">
          <tr>
            <td class="formTitle">ROL</td>
            <td class="formFields">
                <?php
                include_once 'class/roles.php';
                $rol = new roles();
                $html = $rol->getrolesCombo($rol_id);
                echo $html;
                ?>
            </td>
          </tr>
          <tr>
            <td class="formTitle">USUARIO</td>
            <td class="formFields">
                <?php
                include_once 'class/usuarios.php'; // incluye las clases
                $usu = new usuarios();
                $html = $usu->getusuariosCombo($usu_id);
                echo $html;
                ?>
            </td>
          </tr>
          <tr>
            <td colspan="2" align="center" class="formFields">
              <input type="submit" class="boton" value="Enviar" />
              <a href='abm_roles_x_usuario.php'>
                <input type='button' class='boton' value='Volver' onClick="window.location.href='abm_roles_x_usuario.php'" />
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