<?php
include_once 'class/session.php';
include_once 'class/conex.php';
include_once 'class/empleados.php'; // incluye las clases

$mensaje="";

$EMP_APELLIDO="";
$EMP_NOMBRE="";
$EMP_LEGAJO="";
$EMP_CUIL="";
$emp_tipo_documento="";
$emp_numero_documento="";
$EMP_FCH_ALTA="";
$EMP_FCH_BAJA="";
$EMP_FCH_NAC="";
$EMP_SINDICATO="";
$EMP_OBRA_SOC="";
$EMP_CATEGORIA="";
$EMP_BANCO="";
$EMP_CBU="";
$EMP_SUC_ID="";
$EMP_CALLE="";
$EMP_NUMERO="";
$EMP_PISO="";
$EMP_DEPARTAMENTO="";
$EMP_CODIGO_POSTAL="";
$EMP_CIUDAD="";
$EMP_PROVINCIA="";
$EMP_TELEFONO1="";
$EMP_TELEFONO2="";
$EMP_FAX="";
$EMP_EMAIL="";
$EMP_OBSERVACIONES="";


if ($_SERVER["REQUEST_METHOD"] == "POST" /*&& isset($_POST['EMP_USUARIO'])*/) {

    $mensajeError="";
    $EMP_LEGAJO = ($_POST['emp_legajo']);
    $emp_tipo_documento=($_POST['emp_tipo_documento']);
    $emp_numero_documento=($_POST['emp_numero_documento']);
    $EMP_CUIL = ($_POST['emp_cuil']);
    $EMP_FCH_ALTA = ($_POST['emp_fch_alta']);
    $EMP_FCH_BAJA = ($_POST['emp_fch_baja']);
    $EMP_FCH_NAC = ($_POST['emp_fch_nac']);
    $EMP_APELLIDO = ($_POST['emp_apellido']);
    $EMP_NOMBRE = ($_POST['emp_nombre']);
    $EMP_CALLE = ($_POST['emp_calle']);
    $EMP_NUMERO = ($_POST['emp_numero']);
    $EMP_PISO = ($_POST['emp_piso']);
    $EMP_DEPARTAMENTO = ($_POST['emp_departamento']);
    $EMP_CODIGO_POSTAL = ($_POST['emp_codigo_postal']);
    $EMP_CIUDAD = ($_POST['emp_ciudad']);
    $EMP_PROVINCIA = ($_POST['emp_provincia']);
    $EMP_TELEFONO1 = ($_POST['emp_telefono1']);
    $EMP_TELEFONO2 = ($_POST['emp_telefono2']);
    $EMP_FAX = ($_POST['emp_fax']);
    $EMP_EMAIL = ($_POST['emp_email']);
    $EMP_SINDICATO = ($_POST['emp_sindicato']);
    $EMP_OBRA_SOC = ($_POST['emp_obra_soc']);
    $EMP_CATEGORIA = ($_POST['emp_categoria']);
    $EMP_BANCO = ($_POST['emp_banco']);
    $EMP_CBU = ($_POST['emp_cbu']);
    $EMP_SUC_ID = ($_POST['emp_suc_id']);
    $EMP_OBSERVACIONES = ($_POST['emp_observaciones']);

    /*validaciones*/
        if (($_POST['emp_cuil']=="") and ($_POST['emp_nombre']=="") and ($_POST['emp_apellido']=="")) {
        $mensajeError .= "Debe completar Cuil o Nombre y Apellido.</br>";
    }else{
      if ($_POST['emp_cuil']=="") {
        if (isset($_POST['emp_nombre']) or isset($_POST['emp_apellido'])) {
            if ($_POST['emp_nombre']=="") {
                $mensajeError .= "Falta completar el campo Nombre.</br>";
            }
        }
        if (isset($_POST['emp_nombre']) or isset($_POST['emp_apellido'])) {
            if ($_POST['emp_apellido']=="") {
                $mensajeError .= "Falta completar el campo Apellido.</br>";
            }
        }
      }else{
        if (isset($_POST['emp_cuil'])) {
            if ($_POST['emp_cuil']=="") {
                $mensajeError .= "Falta completar el campo cuil.</br>";
            }
        }
      }
    }
    /*validaciones*/

    if ($mensajeError!="") {
        $mensaje = $mensajeError;
    } else {
        //Instancio el objeto
//		$mensaje="antes del new";
        $emp = new empleados();

	//Seteo las variables
        $emp->set_EMP_NOMBRE($_POST["emp_nombre"]);
        $emp->set_EMP_APELLIDO($_POST["emp_apellido"]);
        $emp->set_EMP_LEGAJO($_POST["emp_legajo"]);
        $emp->set_EMP_CUIL($_POST["emp_cuil"]);
		$emp->set_emp_tipo_documento($_POST['emp_tipo_documento']);
        $emp->set_emp_numero_documento($_POST['emp_numero_documento']);
        $emp->set_EMP_FCH_ALTA($_POST["emp_fch_alta"]);		
        $emp->set_EMP_FCH_BAJA($_POST["emp_fch_baja"]);		
        $emp->set_EMP_FCH_NAC($_POST["emp_fch_nac"]);		
        $emp->set_EMP_SINDICATO($_POST["emp_sindicato"]);		
        $emp->set_EMP_OBRA_SOC($_POST["emp_obra_soc"]);				
        $emp->set_EMP_CATEGORIA($_POST["emp_categoria"]);				
        $emp->set_EMP_BANCO($_POST["emp_banco"]);
        $emp->set_EMP_CBU($_POST["emp_cbu"]);												
        $emp->set_EMP_SUC_ID($_POST["emp_suc_id"]);						
        $emp->set_EMP_CALLE($_POST["emp_calle"]);
        $emp->set_EMP_NUMERO($_POST["emp_numero"]);
        $emp->set_EMP_PISO($_POST["emp_piso"]);
        $emp->set_EMP_DEPARTAMENTO($_POST["emp_departamento"]);
        $emp->set_EMP_CODIGO_POSTAL($_POST["emp_codigo_postal"]);
        $emp->set_EMP_CIUDAD($_POST["emp_ciudad"]);
        $emp->set_EMP_PROVINCIA($_POST["emp_provincia"]);
        $emp->set_EMP_TELEFONO1($_POST["emp_telefono1"]);
        $emp->set_EMP_TELEFONO2($_POST["emp_telefono2"]);
        $emp->set_EMP_FAX($_POST["emp_fax"]);
        $emp->set_EMP_EMAIL($_POST["emp_email"]);
        $emp->set_EMP_OBSERVACIONES($_POST["emp_observaciones"]);
        
        $emp->set_EMP_ESTADO(0);
        //Inserto el registro
		//		$mensaje=$mensaje ."despues del new";
        $resultado=$emp->insert_emp();
		//echo "Resultado: ".$resultado;
	//Inserto el registro    
	if ($resultado>0){
		$mensaje="El empleado se dio de alta correctamente";
                $EMP_APELLIDO="";
       			$EMP_NOMBRE="";
				$EMP_LEGAJO="";
				$EMP_CUIL="";
				$emp_tipo_documento="";
				$emp_numero_documento="";
				$EMP_FCH_ALTA="";
				$EMP_FCH_BAJA="";
				$EMP_FCH_NAC="";
				$EMP_SINDICATO="";
				$EMP_OBRA_SOC="";
				$EMP_CATEGORIA="";
				$EMP_BANCO="";
				$EMP_CBU="";
				$EMP_SUC_ID="";
				$EMP_CALLE="";
				$EMP_NUMERO="";
				$EMP_PISO="";
				$EMP_DEPARTAMENTO="";
				$EMP_CODIGO_POSTAL="";
				$EMP_CIUDAD="";
				$EMP_PROVINCIA="";
				$EMP_TELEFONO1="";
				$EMP_TELEFONO2="";
				$EMP_FAX="";
				$EMP_EMAIL="";
				$EMP_OBSERVACIONES="";
	} else {
		$mensaje=$mensaje."No se pudo dar de alta el empleado ";
	}
    }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>MEGALLANTAS - Admin</title>
<link rel="shortcut icon" href="../imagenes/tu-logo-mitad2.jpg"></link>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>
<body onLoad="Irfoco('emp_apellido')">
<div id="page"> 
 <!--Start HEADER -->
 <?php require_once("header.php") ?>
 <!-- End HEADER -->
  <!--Start CENTRAL -->
 <div id="central">
  <h1>Alta de  Empleados </h1>
  <!--Start FORM -->
  <table  class="form">
   <tr>
   <td>
  <form ACTION="alta_empleados.php" METHOD="POST" enctype="multipart/form-data">
    <table><!--class="form" border="0"  align="center">-->
      <tr>
        <td class="formTitle">APELLIDO</td>
        <td><input size="100" type="text" name="emp_apellido" id="emp_apellido" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $EMP_APELLIDO;?>" /></td>
      </tr>
      <tr>
        <td class="formTitle">NOMBRE</td>
        <td><input size="100" type="text" name="emp_nombre" id="emp_nombre" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $EMP_NOMBRE;?>" /></td>
      </tr>	  
      <tr>
        <td class="formTitle">LEGAJO</td>
        <td><input name="emp_legajo" type="text" class="campos" id="emp_legajo" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $EMP_LEGAJO;?>" size="10" maxlength="3" /></td>
      </tr>
	        <tr>
        <td class="formTitle">CUIL</td>
        <td><input name="emp_cuil" type="text" class="campos" id="emp_cuil" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $EMP_CUIL;?>" size="30" maxlength="11" /></td>
      </tr>
      <tr>
        <td class="formTitle">TIPO DOCUMENTO</td>
        <td><input name="emp_tipo_documento" type="text" class="campos" id="emp_tipo_documento" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $emp_tipo_documento;?>" size="10" maxlength="3" /></td>
      </tr>
      <tr>
        <td class="formTitle">NUMERO DOCUMENTO</td>
        <td><input name="emp_numero_documento" type="text" class="campos" id="emp_numero_documento" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $emp_numero_documento;?>" size="30" maxlength="10" /></td>
      </tr>
	  <tr>
        <td class="formTitle">FECHA DE NACIMIENTO(YYYY-MM-DD)</td>
        <td><input name="emp_fch_nac" type="text" class="campos" id="emp_fch_nac" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $emp_fch_nac;?>" size="30" maxlength="10" /></td>
      </tr>
      <tr>
        <td class="formTitle">FECHA DE ALTA(YYYY-MM-DD)</td>
        <td><input name="emp_fch_alta" type="text" class="campos" id="emp_fch_alta" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $emp_fch_alta;?>" size="30" maxlength="10" /></td>
      </tr>
	  <tr>
        <td class="formTitle">FECHA DE BAJA(YYYY-MM-DD)</td>
        <td><input name="emp_fch_baja" type="text" class="campos" id="emp_fch_baja" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $emp_fch_baja;?>" size="30" maxlength="10" /></td>
      </tr>
	  <tr>
        <td class="formTitle">SINDICATO</td>
        <td><input name="emp_sindicato" type="text" class="campos" id="emp_sindicato" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $emp_sindicato;?>" size="30" maxlength="6" /></td>
      </tr>
	  <tr>
        <td class="formTitle">OBRA SOCIAL</td>
        <td><input name="emp_obra_soc" type="text" class="campos" id="emp_obra_soc" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $emp_obra_soc;?>" size="30" maxlength="10" /></td>
      </tr>
	  <tr>
        <td class="formTitle">CATEGORIA - PUESTO</td>
        <td><input size="30" type="text" name="emp_categoria" id="emp_categoria" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $emp_categoria;?>" /></td>
      </tr>
	  <tr>
        <td class="formTitle">BANCO (159)</td>
        <td><input name="emp_banco" type="text" class="campos" id="emp_banco" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $emp_banco;?>" size="10" maxlength="3" /></td>
      </tr>
	  <tr>
        <td class="formTitle">CBU</td>
        <td><input name="emp_cbu" type="text" class="campos" id="emp_cbu" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $emp_cbu;?>" size="20" maxlength="14" /></td>
      </tr>
	  <tr>
        <td class="formTitle">SEDE LABORAL</td>
        <td><input size="30" type="text" name="emp_suc_id" id="emp_suc_id" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $emp_suc_id;?>" /></td>
      </tr>
      <tr>
        <td class="formTitle">CALLE</td>
        <td><input size="100" type="text" name="emp_calle" id="emp_calle" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $EMP_CALLE;?>" /></td>
      </tr>
      <tr>
        <td class="formTitle">NUMERO</td>
        <td><input name="emp_numero" type="text" class="campos" id="emp_numero" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $EMP_NUMERO;?>" size="20" maxlength="10" /></td>
      </tr>
      <tr>
        <td class="formTitle">PISO</td>
        <td><input name="emp_piso" type="text" class="campos" id="emp_piso" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $EMP_PISO;?>" size="20" maxlength="5" /></td>
      </tr>
      <tr>
        <td class="formTitle">DEPARTAMENTO</td>
        <td><input name="emp_departamento" type="text" class="campos" id="emp_departamento" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $EMP_DEPARTAMENTO;?>" size="20" maxlength="5" /></td>
      </tr>
      <tr>
        <td class="formTitle">CODIGO POSTAL</td>
        <td><input name="emp_codigo_postal" type="text" class="campos" id="emp_codigo_postal" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $EMP_CODIGO_POSTAL;?>" size="20" maxlength="20" /></td>
      </tr>
      <tr>
        <td class="formTitle">CIUDAD</td>
        <td><input size="100" type="text" name="emp_ciudad" id="emp_ciudad" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $EMP_LOCALIDAD;?>" /></td>
      </tr>
      <tr>
        <td class="formTitle">PROVINCIA</td>
        <td><input size="100" type="text" name="emp_provincia" id="emp_provincia" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $EMP_PROVINCIA;?>" /></td>
      </tr>
      <tr>
        <td class="formTitle">TELEFONO1</td>
        <td><input size="30" type="text" name="emp_telefono1" id="emp_telefono1" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $EMP_TELEFONO1;?>" /></td>
      </tr>
      <tr>
        <td class="formTitle">TELEFONO2</td>
        <td><input size="30" type="text" name="emp_telefono2" id="emp_telefono2" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $EMP_TELEFONO2;?>" /></td>
      </tr>
      <tr>
        <td class="formTitle">FAX</td>
        <td><input size="30" type="text" name="emp_fax" id="emp_fax" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $EMP_FAX;?>" /></td>
      </tr>
      <tr>
        <td class="formTitle">E-MAIL</td>
        <td><input size="40" type="text" name="emp_email" id="emp_email" class="campos" value="<?php print $EMP_EMAIL;?>" /></td>
      </tr>
      <tr>
        <td class="formTitle">OBSERVACIONES</td>
        <td><textarea name="emp_observaciones" cols="100" class="campos" id="emp_observaciones" onkeyup="this.value=this.value.toUpperCase()"><?php print $EMP_OBSERVACIONES;?></textarea></td>
      </tr>
      <tr>
        <td colspan="2" >
            <input type="submit" class="boton" value="Enviar" />
            <a href='abm_empleados.php'>
              <input type='button' class='boton' value='Volver' onClick="window.location.href='abm_empleados.php'" />
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