<?php
include_once 'class/session.php';
include_once 'class/sucursales.php'; // incluye las clases
include_once 'class/conex.php';
$mensaje="";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['suc_descripcion'])) {
    $mensajeError="";

    /*validaciones*/
    if (isset($_POST['suc_descripcion'])) {
        if ($_POST['suc_descripcion']=="") {
            $mensajeError .= "Falta completar el campo Descripción.</br>";
        }
    }
    /*validaciones*/

    if ($mensajeError!="") {
        $mensaje = $mensajeError;

    } else {
	//Instancio el objeto
        $suc = new sucursales();
	//Seteo las variables
        $suc->set_suc_descripcion($_POST['suc_descripcion']);
        $suc->set_suc_calle($_POST['suc_calle']);
        $suc->set_suc_numero($_POST['suc_numero']);
        $suc->set_suc_piso($_POST['suc_piso']);
        $suc->set_suc_departamento($_POST['suc_departamento']);
        $suc->set_suc_codigo_postal($_POST['suc_codigo_postal']);
        $suc->set_suc_ciudad($_POST['suc_ciudad']);
        $suc->set_suc_provincia($_POST['suc_provincia']);
        $suc->set_suc_telefono1($_POST['suc_telefono1']);
        $suc->set_suc_telefono2($_POST['suc_telefono2']);
        $suc->set_suc_rubro($_POST['suc_rubro']);
        $suc->set_suc_numero_sucursal($_POST['suc_numero_sucursal']);
        $suc->set_suc_ultima_factura($_POST['suc_ultima_factura']);
        $suc->set_suc_ultima_nc($_POST['suc_ultima_nc']);
        $suc->set_suc_ultima_nd($_POST['suc_ultima_nd']);
        $suc->set_suc_ultimo_recibo($_POST['suc_ultimo_recibo']);
        $suc->set_suc_mail($_POST['suc_mail']);
                
	//Inserto el registro
	$resultado=$suc->insert_suc();

	if ($resultado>0){
		$mensaje="La sucursal se dio de alta correctamente";
	} else {
		$mensaje="No se pudo dar de alta la sucursal";
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
<body onLoad="Irfoco('suc_descripcion')">
<div id="page"> 
 <!--Start HEADER -->
 <?php require_once("header.php") ?>
 <!-- End HEADER -->
  <!--Start CENTRAL -->
 <div id="central">
   <h1>Alta de sucursales </h1>
   <!--Start FORM -->
     <form ACTION="alta_sucursales.php" METHOD="POST" enctype="multipart/form-data">
        <table align="center" cellpadding="0" cellspacing="1" class="form">
          <tr>
            <td class="formTitle">DESCRIPCION</td>
            <td class="formFields" colspan="7">
                <input name="suc_descripcion" id="suc_descripcion" type="text" class="campos" size="100" onkeyup="this.value=this.value.toUpperCase()" />
            </td>
          </tr>
          <tr>
            <td class="formTitle">CALLE</td>
            <td class="formFields">
                <input name="suc_calle" id="suc_calle" type="text" class="campos" size="60" onkeyup="this.value=this.value.toUpperCase()" />
            </td>
            <td class="formTitle">NUMERO</td>
            <td class="formFields">
                <input name="suc_numero" id="suc_numero" type="text" class="campos" size="7" onkeyup="this.value=this.value.toUpperCase()" />
            </td>
            <td class="formTitle">PISO</td>
            <td class="formFields">
                <input name="suc_piso" id="suc_piso" type="text" class="campos" size="7" onkeyup="this.value=this.value.toUpperCase()" />
            </td>
            <td class="formTitle">DEPARTAMENTO</td>
            <td class="formFields">
                <input name="suc_departamento" id="suc_departamento" type="text" class="campos" size="7" onkeyup="this.value=this.value.toUpperCase()" />
            </td>
          </tr>
          <tr>
            <td class="formTitle">CIUDAD</td>
            <td class="formFields">
                <input name="suc_ciudad" id="suc_ciudad" type="text" class="campos" size="60" onkeyup="this.value=this.value.toUpperCase()" />
            </td>
            <td class="formTitle">PROVINCIA</td>
            <td class="formFields" colspan="3">
                <input name="suc_provincia" id="suc_provincia" type="text" class="campos" size="30" onkeyup="this.value=this.value.toUpperCase()" />
            </td>
            <td class="formTitle">COD.POSTAL</td>
            <td class="formFields">
                <input name="suc_codigo_postal" id="suc_codigo_postal" type="text" class="campos" size="7" onkeyup="this.value=this.value.toUpperCase()" />
            </td>
          </tr>
          <tr>
            <td class="formTitle">RUBRO</td>
            <td class="formFields">
                <input name="suc_rubro" id="suc_rubro" type="text" class="campos" size="60" onkeyup="this.value=this.value.toUpperCase()" />
            </td>
            <td class="formTitle">TELEFONO 1</td>
            <td class="formFields" colspan="3">
                <input name="suc_telefono1" id="suc_telefono1" type="text" class="campos" size="20" onkeyup="this.value=this.value.toUpperCase()" />
            </td>
            <td class="formTitle">TELEFONO 2</td>
            <td class="formFields">
                <input name="suc_telefono2" id="suc_telefono2" type="text" class="campos" size="20" onkeyup="this.value=this.value.toUpperCase()" />
            </td>
          </tr>
          <tr>
            <td class="formTitle">N.SUCURSAL</td>
            <td class="formFields" colspan="7">
                <input name="suc_numero_sucursal" id="suc_numero_sucursal" type="text" class="campos" size="100" onkeyup="this.value=this.value.toUpperCase()" />
            </td>
          </tr>
          <tr>
            <td class="formTitle">ULT. FACTURA</td>
            <td class="formFields">
                <input name="suc_ultima_factura" id="suc_ultima_factura" type="text" class="campos" size="60" onkeyup="this.value=this.value.toUpperCase()" />
            </td>
            <td class="formTitle">RECIBO</td>
            <td class="formFields">
                <input name="suc_ultimo_recibo" id="suc_ultimo_recibo" type="text" class="campos" size="7" onkeyup="this.value=this.value.toUpperCase()" />
            </td>
            <td class="formTitle">N/C</td>
            <td class="formFields">
                <input name="suc_ultima_nc" id="suc_ultima_nc" type="text" class="campos" size="7" onkeyup="this.value=this.value.toUpperCase()" />
            </td>
            <td class="formTitle">N/D</td>
            <td class="formFields">
                <input name="suc_ultima_nd" id="suc_ultima_nd" type="text" class="campos" size="7" onkeyup="this.value=this.value.toUpperCase()" />
            </td>
          </tr>
          <tr>
            <td class="formTitle">MAIL:</td>
            <td class="formFields">
                <input name="suc_mail" id="suc_mail" type="text" class="campos" size="60" />
            </td>
          </tr>
          <tr>
            <td colspan="2" align="center" class="formFields">
              <input type="submit" class="boton" value="Enviar" />
              <a href='abm_sucursales.php'>
                <input type='button' class='boton' value='Volver' onClick="window.location.href='abm_sucursales.php'" />
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