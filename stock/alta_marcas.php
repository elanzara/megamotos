<?php
include_once 'class/session.php';
include_once 'class/marcas.php';
//include_once 'class/tipo_productos.php';
include_once 'class/conex.php';
$mensaje="";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['MAR_DESCRIPCION'])) {
    $mensajeError="";
    //$tip_id=$_POST['tipo_productos'];

    /*validaciones*/
    if (isset($_POST['MAR_DESCRIPCION'])) {
        if ($_POST['MAR_DESCRIPCION']=="") {
            $mensajeError .= "Falta completar el campo Descripción.</br>";
        }
    }
    /*validaciones*/

    if ($mensajeError!="") {
        $mensaje = $mensajeError;

    } else {
	//Instancio el objeto
        $mar = new marcas();
	//Seteo las variables
        $mar->set_MAR_DESCRIPCION($_POST['MAR_DESCRIPCION']);
        //$mar->set_tip_id($tip_id);
	//Inserto el registro
	$resultado=$mar->insert_MAR();

	if ($resultado>0){
            $mensaje="La marca se dio de alta correctamente";
            //header('Location: ../admin/abm_marcas_tipos_prod.php?mar_id='.$resultado);
            header('Location: abm_marcas_tipos_prod.php?mar_id='.$resultado);
	} else {
            $mensaje="No se pudo dar de alta la marca";
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
<body onLoad="Irfoco('MAR_DESCRIPCION')">
<div id="page"> 
 <!--Start HEADER -->
 <?php require_once("header.php") ?>
 <!-- End HEADER -->
  <!--Start CENTRAL -->
 <div id="central">
   <h1>Alta de Marcas </h1>
   <!--Start FORM -->
     <form ACTION="alta_marcas.php" METHOD="POST" enctype="multipart/form-data">
        <table align="center" cellpadding="0" cellspacing="1" class="form">
          <!--<tr>
            <td class="formTitle">TIPO PRODUCTO</td>
            <td>
                <?php
                //$tip = new tipo_productos();
                //$res = $tip->gettipo_productosCombo($tip_id, 'N');
                //print $res;
                ?>
            </td>
          </tr>-->
          <tr>
            <td class="formTitle">DESCRIPCION</td>
            <td class="formFields">
              <input name="MAR_DESCRIPCION" id="MAR_DESCRIPCION" type="text" class="campos" size="80" onkeyup="this.value=this.value.toUpperCase()" />
            </td>
          </tr>
          <tr>
            <td colspan="2" align="center" class="formFields">
              <input type="submit" class="boton" value="Enviar" id="enviar" />
              <a href='abm_marcas.php'>
                <input type='button' class='boton' value='Volver' onClick="window.location.href='abm_marcas.php'" />
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