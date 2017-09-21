<?php 
include_once 'class/session.php';
include_once 'class/conex.php';
include_once 'class/clientes.php';

$mensaje="";

$cli_nombre="";
$cli_apellido="";
$cli_razon_social="";
$cli_calle="";
$cli_numero="";
$cli_piso="";
$cli_departamento="";
$cli_codigo_postal="";
$cli_ciudad="";
$cli_provincia="";
$cli_telefono1="";
$cli_telefono2="";
$cli_fax="";
$cli_email="";
$cli_cuit="";
$cli_observaciones="";
$cli_tipo_documento="";
$cli_numero_documento="";

$cli = new clientes();

//Si en la grilla selecciono para modificar muestro los datos de la categoria
if (isset($_GET['md'])) {
	//Instancio el objeto 
	$cli = new clientes($_GET['md']);
        $cli_id = $cli->get_cli_id();
        $cli_nombre = $cli->get_cli_nombre();
        $cli_apellido = $cli->get_cli_apellido();
        $cli_razon_social = $cli->get_cli_razon_social();
        $cli_calle = $cli->get_cli_calle();
        $cli_numero = $cli->get_cli_numero();
        $cli_piso = $cli->get_cli_piso();
        $cli_departamento = $cli->get_cli_departamento();
        $cli_codigo_postal = $cli->get_cli_codigo_postal();
        $cli_ciudad = $cli->get_cli_ciudad();
        $cli_provincia = $cli->get_cli_provincia();
        $cli_telefono1 = $cli->get_cli_telefono1();
        $cli_telefono2 = $cli->get_cli_telefono2();
        $cli_fax = $cli->get_cli_fax();
        $cli_email = $cli->get_cli_email();
        $cli_cuit = $cli->get_cli_cuit();
        $cli_observaciones = $cli->get_cli_observaciones();
        $cli_tipo_documento=$cli->get_cli_tipo_documento();
        $cli_numero_documento=$cli->get_cli_numero_documento();
}
 
 if ($_SERVER["REQUEST_METHOD"] == "POST" /*&& isset($_POST['PRO_DESCRIPCION'])*/){
    $mensajeError="";

    $cli = new clientes($_POST['cli_id']);

    $cli_nombre = ($_POST['cli_nombre']);
    $cli_apellido = ($_POST['cli_apellido']);
    $cli_razon_social = ($_POST['cli_razon_social']);
    $cli_calle = ($_POST['cli_calle']);
    $cli_numero = ($_POST['cli_numero']);
    $cli_piso = ($_POST['cli_piso']);
    $cli_departamento = ($_POST['cli_departamento']);
    $cli_codigo_postal = ($_POST['cli_codigo_postal']);
    $cli_ciudad = ($_POST['cli_ciudad']);
    $cli_provincia = ($_POST['cli_provincia']);
    $cli_telefono1 = ($_POST['cli_telefono1']);
    $cli_telefono2 = ($_POST['cli_telefono2']);
    $cli_fax = ($_POST['cli_fax']);
    $cli_email = ($_POST['cli_email']);
    $cli_cuit = ($_POST['cli_cuit']);
    $cli_observaciones = ($_POST['cli_observaciones']);
    $cli_tipo_documento = ($_POST['cli_tipo_documento']);
    $cli_numero_documento = ($_POST['cli_numero_documento']);

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
	//si le dio un click al boton enviar modifico los datos
	if (isset($_POST['cli_id'])){

            //Instancio el objeto
            $cli = new clientes($_POST['cli_id']);

            //Seteo las variables
            $cli->set_cli_nombre($_POST["cli_nombre"]);
            $cli->set_cli_apellido($_POST["cli_apellido"]);
            $cli->set_cli_razon_social($_POST["cli_razon_social"]);
            $cli->set_cli_calle($_POST["cli_calle"]);
            $cli->set_cli_numero($_POST["cli_numero"]);
            $cli->set_cli_piso($_POST["cli_piso"]);
            $cli->set_cli_departamento($_POST["cli_departamento"]);
            $cli->set_cli_codigo_postal($_POST["cli_codigo_postal"]);
            $cli->set_cli_ciudad($_POST["cli_ciudad"]);
            $cli->set_cli_provincia($_POST["cli_provincia"]);
            $cli->set_cli_telefono1($_POST["cli_telefono1"]);
            $cli->set_cli_telefono2($_POST["cli_telefono2"]);
            $cli->set_cli_fax($_POST["cli_fax"]);
            $cli->set_cli_email($_POST["cli_email"]);
            $cli->set_cli_cuit($_POST["cli_cuit"]);
            $cli->set_cli_observaciones($_POST["cli_observaciones"]);
            $cli->set_cli_tipo_documento($_POST["cli_tipo_documento"]);
            $cli->set_cli_numero_documento($_POST["cli_numero_documento"]);

            //actualizo los datos
            $resultado=$cli->update_CLI();
            //echo $resultado;
            if ($resultado>0){
                $mensaje="El cliente se modificó correctamente";
                $cli_nombre="";
                $cli_apellido="";
                $cli_razon_social="";
                $cli_calle="";
                $cli_numero="";
                $cli_piso="";
                $cli_departamento="";
                $cli_codigo_postal="";
                $cli_ciudad="";
                $cli_provincia="";
                $cli_telefono1="";
                $cli_telefono2="";
                $cli_fax="";
                $cli_email="";
                $cli_cuit="";
                $cli_observaciones="";
                $cli_tipo_documento="";
                $cli_numero_documento="";
            } else {
                $mensaje="El cliente no se pudo modificar";
            }
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
  <h1>Modificar   Clientes </h1>
  <!--Start FORM -->
  <table  class="form">
   <tr>
   <td>
   <?php
        echo "<FORM ACTION='modifica_clientes.php' METHOD='POST'  enctype='multipart/form-data'>";
        echo "<table>";
        echo "<tr>";
        echo "<td>";
        echo "<input size='100' name='cli_id' id='cli_id' value='".$cli->cli_id."' type='hidden' class='campos' size='18' />";
        echo '</td>';
        echo "</tr>";

        echo "<tr>";
        echo "<td class='formTitle'>";
        echo "APELLIDO";
        echo "</td>";
        echo "<td class='formFields'>";
        echo '<input size="100" type="text" name="cli_apellido" id="cli_apellido" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="'.$cli_apellido.'" />';
        echo "</td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td class='formTitle'>";
        echo "NOMBRE";
        echo "</td>";
        echo "<td class='formFields'>";
        echo '<input size="100" type="text" name="cli_nombre" id="cli_nombre" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="'.$cli_nombre.'" />';
        echo "</td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td class='formTitle'>";
        echo "RAZON SOCIAL";
        echo "</td>";
        echo "<td class='formFields'>";
        echo '<input size="100" type="text" name="cli_razon_social" id="cli_razon_social" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="'.$cli_razon_social.'" />';
        echo "</td>";
        echo "</tr>";

        echo '<tr>';
        echo '<td class="formTitle">';
        echo 'CALLE</td>';
        echo '<td>';
        echo '<input size="100" type="text" name="cli_calle" id="cli_calle" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="'.$cli_calle.'" />';
        echo '</td>';
        echo '</tr>';

        echo "<tr>";
        echo "<td class='formTitle'>";
        echo "NUMERO";
        echo "</td>";
        echo "<td class='formFields'>";
        echo '<input size="100" type="text" name="cli_numero" id="cli_numero" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="'.$cli_numero.'" />';
        echo "</td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td class='formTitle'>";
        echo "PISO";
        echo "</td>";
        echo "<td class='formFields'>";
        echo '<input size="100" type="text" name="cli_piso" id="cli_piso" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="'.$cli_piso.'" />';
        echo "</td>";
        echo "</tr>";

        echo '<tr>';
        echo '<td class="formTitle">';
        echo 'DEPARTAMENTO</td>';
        echo '<td>';
        echo '<input size="100" type="text" name="cli_departamento" id="cli_departamento" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="'.$cli_departamento.'" />';
        echo '</td>';
        echo '</tr>';

        echo '<tr>';
        echo '<td class="formTitle">';
        echo 'CODIGO POSTAL</td>';
        echo '<td>';
        echo '<input size="100" type="text" name="cli_codigo_postal" id="cli_codigo_postal" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="'.$cli_codigo_postal.'" />';
        echo '</td>';
        echo '</tr>';

        echo '<tr>';
        echo '<td class="formTitle">';
        echo 'CIUDAD</td>';
        echo '<td>';
        echo '<input size="100" type="text" name="cli_ciudad" id="cli_ciudad" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="'.$cli_ciudad.'" />';
        echo '</td>';
        echo '</tr>';

        echo '<tr>';
        echo '<td class="formTitle">';
        echo 'PROVINCIA</td>';
        echo '<td>';
        echo '<input size="100" type="text" name="cli_provincia" id="cli_provincia" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="'.$cli_provincia.'" />';
        echo '</td>';
        echo '</tr>';

        echo '<tr>';
        echo '<td class="formTitle">';
        echo 'TELEFONO1</td>';
        echo '<td>';
        echo '<input size="100" type="text" name="cli_telefono1" id="cli_telefono1" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="'.$cli_telefono1.'" />';
        echo '</td>';
        echo '</tr>';

        echo '<tr>';
        echo '<td class="formTitle">';
        echo 'TELEFONO2</td>';
        echo '<td>';
        echo '<input size="100" type="text" name="cli_telefono2" id="cli_telefono2" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="'.$cli_telefono2.'" />';
        echo '</td>';
        echo '</tr>';

        echo '<tr>';
        echo '<td class="formTitle">';
        echo 'FAX</td>';
        echo '<td>';
        echo '<input size="100" type="text" name="cli_fax" id="cli_fax" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="'.$cli_fax.'" />';
        echo '</td>';
        echo '</tr>';

        echo '<tr>';
        echo '<td class="formTitle">';
        echo 'E-MAIL</td>';
        echo '<td>';
        echo '<input size="100" type="text" name="cli_email" id="cli_email" class="campos" value="'.$cli_email.'" />';
        echo '</td>';
        echo '</tr>';

        echo '<tr>';
        echo '<td class="formTitle">';
        echo 'CUIT</td>';
        echo '<td>';
        echo '<input size="100" type="text" name="cli_cuit" id="cli_cuit" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="'.$cli_cuit.'" />';
        echo '</td>';
        echo '</tr>';

        echo '<tr>';
        echo '<td class="formTitle">TIPO DOCUMENTO</td>';
        echo '<td><input size="100" type="text" name="cli_tipo_documento" id="cli_tipo_documento" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="'.$cli_tipo_documento.'" /></td>';
        echo '</tr>';

        echo '<tr>';
        echo '<td class="formTitle">NUMERO DOCUMENTO</td>';
        echo '<td><input size="100" type="text" name="cli_numero_documento" id="cli_numero_documento" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="'.$cli_numero_documento.'" /></td>';
        echo '</tr>';

        echo '<tr>';
        echo '<td class="formTitle">';
        echo 'OBSERVACIONES</td>';
        echo '<td>';
        echo '<input size="100" type="text" name="cli_observaciones" id="cli_observaciones" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="'.$cli_observaciones.'" />';
        echo '</td>';
        echo '</tr>';

        echo "<tr>";
        echo "<td colspan='2' align='center' class='formFields'>";
        echo "<input type='submit' value='Enviar' class='boton' />";
        echo "<a href='abm_clientes.php'><input type='button' class='boton' value='Volver' onClick=\"window.location.href='abm_clientes.php'\" />";
        echo "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td class='mensaje'>";
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