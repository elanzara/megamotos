<?php
include_once 'class/session.php';
include_once 'class/usuarios.php'; // incluye las clases
include_once 'class/conex.php';

$mensaje="";

$usu_descripcion="";
$suc_id = "";
$usu_mail="";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['usu_descripcion'])) {
    $mensajeError="";
    $usu_descripcion = ($_POST['usu_descripcion']);
    $suc_id = ($_POST['sucursales']);
    $usu_mail = ($_POST['usu_mail']);

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
	//Instancio el objeto
        $usu = new usuarios();
	//Seteo las variables
        $usu->set_usu_descripcion($_POST['usu_descripcion']);
        $usu->set_suc_id($_POST['sucursales']);
        $usu->set_usu_clave(md5($_POST["usu_clave"]));
        $usu->set_usu_mail($_POST["usu_mail"]);
	//Inserto el registro
	$resultado=$usu->insert_usu();

	if ($resultado>0){
		$mensaje="El usuario se dio de alta correctamente";
                $usu_descripcion="";
                $usu_mail = "";
                $suc_id = "";
	} else {
		$mensaje="No se pudo dar de alta el usuario";
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
<body onLoad="Irfoco('usu_descripcion')">
<div id="page"> 
 <!--Start HEADER -->
 <?php require_once("header.php") ?>
 <!-- End HEADER -->
  <!--Start CENTRAL -->
 <div id="central">
   <h1>Alta de usuarios </h1>
   <!--Start FORM -->
     <form ACTION="alta_usuarios.php" METHOD="POST" enctype="multipart/form-data">
        <table align="center" cellpadding="0" cellspacing="1" class="form">
          <tr>
            <td class="formTitle">DESCRIPCION</td>
            <td class="formFields">
                <input name="usu_descripcion" id="usu_descripcion" type="text" class="campos" size="80" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $USU_DESCRIPCION;?>"/>
            </td>
          </tr>
          <tr>
            <td class="formTitle">SUCURSAL</td>
            <td class="formFields">
                <?php
                include_once 'class/sucursales.php';
                $suc = new sucursales();
                $html = $suc->getsucursalesnuloCombo($suc_id);
                echo $html;
                ?>
            </td>
          </tr>
          <tr>
            <td class="formTitle">MAIL</td>
            <td class="formFields">
                <input name="usu_mail" id="usu_mail" type="text" class="campos" size="80" value="<?php print $usu_mail;?>"/>
            </td>
          </tr>
          <tr>
            <td class="formTitle">CLAVE</td>
            <td><input type="password" name="usu_clave" id="usu_clave" class="campos" /></td>
          </tr>
          <tr>
            <td colspan="2" align="center" class="formFields">
              <input type="submit" class="boton" value="Enviar" />
              <a href='abm_usuarios.php'>
                <input type='button' class='boton' value='Volver' onClick="window.location.href='abm_usuarios.php'" />
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