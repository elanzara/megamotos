<?php
include_once 'class/session.php';
include_once 'class/conex.php';
include_once 'class/clientes.php'; // incluye las clases

$mensaje="";

$CLI_NOMBRE="";
$CLI_APELLIDO="";
$CLI_RAZON_SOCIAL="";
$CLI_CALLE="";
$CLI_NUMERO="";
$CLI_PISO="";
$CLI_DEPARTAMENTO="";
$CLI_CODIGO_POSTAL="";
$CLI_CIUDAD="";
$CLI_PROVINCIA="";
$CLI_TELEFONO1="";
$CLI_TELEFONO2="";
$CLI_FAX="";
$CLI_EMAIL="";
$CLI_CUIT="";
$CLI_OBSERVACIONES="";
$cli_tipo_documento="";
$cli_numero_documento="";

if ($_SERVER["REQUEST_METHOD"] == "POST" /*&& isset($_POST['CLI_USUARIO'])*/) {

    $mensajeError="";
    $CLI_NOMBRE = ($_POST['cli_nombre']);
    $CLI_APELLIDO = ($_POST['cli_apellido']);
    $CLI_RAZON_SOCIAL = ($_POST['cli_razon_social']);
    $CLI_CALLE = ($_POST['cli_calle']);
    $CLI_NUMERO = ($_POST['cli_numero']);
    $CLI_PISO = ($_POST['cli_piso']);
    $CLI_DEPARTAMENTO = ($_POST['cli_departamento']);
    $CLI_CODIGO_POSTAL = ($_POST['cli_codigo_postal']);
    $CLI_CIUDAD = ($_POST['cli_ciudad']);
    $CLI_PROVINCIA = ($_POST['cli_provincia']);
    $CLI_TELEFONO1 = ($_POST['cli_telefono1']);
    $CLI_TELEFONO2 = ($_POST['cli_telefono2']);
    $CLI_FAX = ($_POST['cli_fax']);
    $CLI_EMAIL = ($_POST['cli_email']);
    $CLI_CUIT = ($_POST['cli_cuit']);
    $CLI_OBSERVACIONES = ($_POST['cli_observaciones']);
    $cli_tipo_documento=($_POST['cli_tipo_documento']);
    $cli_numero_documento=($_POST['cli_numero_documento']);

    /*validaciones*/
    if (($_POST['cli_razon_social']=="") and ($_POST['cli_nombre']=="") and ($_POST['cli_razon_social']=="")) {
        $mensajeError .= "Debe completar Razón Social o Nombre y Apellido.</br>";
    }else{
      if ($_POST['cli_razon_social']=="") {
        if (isset($_POST['cli_nombre']) or isset($_POST['cli_apellido'])) {
            if ($_POST['cli_nombre']=="") {
                $mensajeError .= "Falta completar el campo Nombre.</br>";
            }
        }
        if (isset($_POST['cli_nombre']) or isset($_POST['cli_apellido'])) {
            if ($_POST['cli_apellido']=="") {
                $mensajeError .= "Falta completar el campo Apellido.</br>";
            }
        }
      }else{
        if (isset($_POST['cli_razon_social'])) {
            if ($_POST['cli_razon_social']=="") {
                $mensajeError .= "Falta completar el campo Razón Social.</br>";
            }
        }
      }
    }
    /*validaciones*/

    if ($mensajeError!="") {
        $mensaje = $mensajeError;
    } else {
        //Instancio el objeto
        $cli = new clientes();

	//Seteo las variables
        $cli->set_CLI_NOMBRE($_POST["cli_nombre"]);
        $cli->set_CLI_APELLIDO($_POST["cli_apellido"]);
        $cli->set_CLI_RAZON_SOCIAL($_POST["cli_razon_social"]);
        $cli->set_CLI_CALLE($_POST["cli_calle"]);
        $cli->set_CLI_NUMERO($_POST["cli_numero"]);
        $cli->set_CLI_PISO($_POST["cli_piso"]);
        $cli->set_CLI_DEPARTAMENTO($_POST["cli_departamento"]);
        $cli->set_CLI_CODIGO_POSTAL($_POST["cli_codigo_postal"]);
        $cli->set_CLI_CIUDAD($_POST["cli_ciudad"]);
        $cli->set_CLI_PROVINCIA($_POST["cli_provincia"]);
        $cli->set_CLI_TELEFONO1($_POST["cli_telefono1"]);
        $cli->set_CLI_TELEFONO2($_POST["cli_telefono2"]);
        $cli->set_CLI_FAX($_POST["cli_fax"]);
        $cli->set_CLI_EMAIL($_POST["cli_email"]);
        $cli->set_CLI_CUIT($_POST["cli_cuit"]);
        $cli->set_CLI_OBSERVACIONES($_POST["cli_observaciones"]);
        $cli->set_cli_tipo_documento($_POST['cli_tipo_documento']);
        $cli->set_cli_numero_documento($_POST['cli_numero_documento']);

        $cli->set_CLI_ESTADO(2);
        //Inserto el registro
        $resultado=$cli->insert_CLI();
	//Inserto el registro    
	if ($resultado>0){
		$mensaje="El cliente se dio de alta correctamente";
                $CLI_NOMBRE="";
                $CLI_APELLIDO="";
                $CLI_RAZON_SOCIAL="";
                $CLI_CALLE="";
                $CLI_NUMERO="";
                $CLI_PISO="";
                $CLI_DEPARTAMENTO="";
                $CLI_CODIGO_POSTAL="";
                $CLI_CIUDAD="";
                $CLI_PROVINCIA="";
                $CLI_TELEFONO1="";
                $CLI_TELEFONO2="";
                $CLI_FAX="";
                $CLI_EMAIL="";
                $CLI_CUIT="";
                $CLI_OBSERVACIONES="";
                $cli_tipo_documento="";
                $cli_numero_documento="";
                header( 'Location: alta_vehiculos.php?cli_id='.$resultado);
	} else {
		$mensaje="No se pudo dar de alta el cliente";
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
<body onLoad="Irfoco('cli_apellido')">
<div id="page"> 
 <!--Start HEADER -->
 <?php require_once("header.php") ?>
 <!-- End HEADER -->
  <!--Start CENTRAL -->
 <div id="central">
  <h1>Alta de  Clientes </h1>
  <!--Start FORM -->
  <table  class="form">
   <tr>
   <td>
  <form ACTION="alta_clientes.php" METHOD="POST" enctype="multipart/form-data">
    <table><!--class="form" border="0"  align="center">-->
      <tr>
        <td class="formTitle">APELLIDO</td>
        <td><input size="100" type="text" name="cli_apellido" id="cli_apellido" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $CLI_APELLIDO;?>" /></td>
      </tr>
      <tr>
        <td class="formTitle">NOMBRE</td>
        <td><input size="100" type="text" name="cli_nombre" id="cli_nombre" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $CLI_NOMBRE;?>" /></td>
      </tr>
      <tr>
        <td class="formTitle">RAZON SOCIAL</td>
        <td><input size="100" type="text" name="cli_razon_social" id="cli_razon_social" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $CLI_RAZON_SOCIAL;?>" /></td>
      </tr>
      <tr>
        <td class="formTitle">CALLE</td>
        <td><input size="100" type="text" name="cli_calle" id="cli_calle" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $CLI_CALLE;?>" /></td>
      </tr>
      <tr>
        <td class="formTitle">NUMERO</td>
        <td><input size="100" type="text" name="cli_numero" id="cli_numero" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $CLI_NUMERO;?>" /></td>
      </tr>
      <tr>
        <td class="formTitle">PISO</td>
        <td><input size="100" type="text" name="cli_piso" id="cli_piso" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $CLI_PISO;?>" /></td>
      </tr>
      <tr>
        <td class="formTitle">DEPARTAMENTO</td>
        <td><input size="100" type="text" name="cli_departamento" id="cli_departamento" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $CLI_DEPARTAMENTO;?>" /></td>
      </tr>
      <tr>
        <td class="formTitle">CODIGO POSTAL</td>
        <td><input size="100" type="text" name="cli_codigo_postal" id="cli_codigo_postal" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $CLI_CODIGO_POSTAL;?>" /></td>
      </tr>
      <tr>
        <td class="formTitle">CIUDAD</td>
        <td><input size="100" type="text" name="cli_ciudad" id="cli_ciudad" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $CLI_LOCALIDAD;?>" /></td>
      </tr>
      <tr>
        <td class="formTitle">PROVINCIA</td>
        <td><input size="100" type="text" name="cli_provincia" id="cli_provincia" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $CLI_PROVINCIA;?>" /></td>
      </tr>
      <tr>
        <td class="formTitle">TELEFONO1</td>
        <td><input size="100" type="text" name="cli_telefono1" id="cli_telefono1" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $CLI_TELEFONO1;?>" /></td>
      </tr>
      <tr>
        <td class="formTitle">TELEFONO2</td>
        <td><input size="100" type="text" name="cli_telefono2" id="cli_telefono2" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $CLI_TELEFONO2;?>" /></td>
      </tr>
      <tr>
        <td class="formTitle">FAX</td>
        <td><input size="100" type="text" name="cli_fax" id="cli_fax" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $CLI_FAX;?>" /></td>
      </tr>
      <tr>
        <td class="formTitle">E-MAIL</td>
        <td><input size="100" type="text" name="cli_email" id="cli_email" class="campos" value="<?php print $CLI_EMAIL;?>" /></td>
      </tr>
      <tr>
        <td class="formTitle">CUIT</td>
        <td><input size="100" type="text" name="cli_cuit" id="cli_cuit" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $CLI_CUIT;?>" /></td>
      </tr>
      <tr>
        <td class="formTitle">TIPO DOCUMENTO</td>
        <td><input size="100" type="text" name="cli_tipo_documento" id="cli_tipo_documento" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $cli_tipo_documento;?>" /></td>
      </tr>
      <tr>
        <td class="formTitle">NUMERO DOCUMENTO</td>
        <td><input size="100" type="text" name="cli_numero_documento" id="cli_numero_documento" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $cli_numero_documento;?>" /></td>
      </tr>
      <tr>
        <td class="formTitle">OBSERVACIONES</td>
        <td><input size="100" type="text" name="cli_observaciones" id="cli_observaciones" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $CLI_OBSERVACIONES;?>" /></td>
      </tr>
      <tr>
        <td colspan="2" >
            <input type="submit" class="boton" value="Enviar" />
            <a href='abm_clientes.php'>
              <input type='button' class='boton' value='Volver' onClick="window.location.href='abm_clientes.php'" />
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