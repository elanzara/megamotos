<?php 
include_once 'class/session.php';
include_once 'class/conex.php';
include_once 'class/empleados.php';

$mensaje="";

$emp_apellido="";
$emp_nombre="";
$emp_legajo="";
$emp_cuil="";
$emp_tipo_documento="";
$emp_numero_documento="";
$emp_fch_alta="";
$emp_fch_baja="";
$emp_fch_nac="";
$emp_sindicato="";
$emp_obra_soc="";
$emp_categoria="";
$emp_banco="";
$emp_cbu="";
$emp_suc_id="";
$emp_calle="";
$emp_numero="";
$emp_piso="";
$emp_departamento="";
$emp_codigo_postal="";
$emp_ciudad="";
$emp_provincia="";
$emp_telefono1="";
$emp_telefono2="";
$emp_fax="";
$emp_email="";
$emp_observaciones="";

$emp = new empleados();

//Si en la grilla selecciono para modificar muestro los datos de la categoria
if (isset($_GET['md'])) {
	//Instancio el objeto 
	$emp = new empleados($_GET['md']);
        $emp_id = $emp->get_emp_id();
        $emp_nombre = $emp->get_emp_nombre();
        $emp_apellido = $emp->get_emp_apellido();
        $emp_legajo = $emp->get_emp_legajo();
        $emp_fch_alta = $emp->get_emp_fch_alta();
        $emp_fch_baja = $emp->get_emp_fch_baja();		
        $emp_fch_nac = $emp->get_emp_fch_nac();		
        $emp_sindicato = $emp->get_emp_sindicato();				
        $emp_obra_soc = $emp->get_emp_obra_soc();				
        $emp_categoria = $emp->get_emp_categoria();				
        $emp_banco = $emp->get_emp_banco();				
        $emp_cbu = $emp->get_emp_cbu();				
        $emp_suc_id = $emp->get_emp_suc_id();	
        $emp_calle = $emp->get_emp_calle();
        $emp_numero = $emp->get_emp_numero();
        $emp_piso = $emp->get_emp_piso();
        $emp_departamento = $emp->get_emp_departamento();
        $emp_codigo_postal = $emp->get_emp_codigo_postal();
        $emp_ciudad = $emp->get_emp_ciudad();
        $emp_provincia = $emp->get_emp_provincia();
        $emp_telefono1 = $emp->get_emp_telefono1();
        $emp_telefono2 = $emp->get_emp_telefono2();
        $emp_fax = $emp->get_emp_fax();
        $emp_email = $emp->get_emp_email();
        $emp_cuil = $emp->get_emp_cuil();
        $emp_observaciones = $emp->get_emp_observaciones();
        $emp_tipo_documento=$emp->get_emp_tipo_documento();
        $emp_numero_documento=$emp->get_emp_numero_documento();
}
 
 if ($_SERVER["REQUEST_METHOD"] == "POST" /*&& isset($_POST['PRO_DESCRIPCION'])*/){
    $mensajeError="";

    $emp = new empleados($_POST['emp_id']);

    $emp_nombre = ($_POST['emp_nombre']);
    $emp_apellido = ($_POST['emp_apellido']);
    $emp_legajo = ($_POST['emp_legajo']);
	$emp_fch_alta = ($_POST['emp_fch_alta']);
	$emp_fch_baja = ($_POST['emp_fch_baja']);
	$emp_fch_nac = ($_POST['emp_fch_nac']);
	$emp_sindicato = ($_POST['emp_sindicato']);
	$emp_obra_soc = ($_POST['emp_obra_soc']);			
	$emp_categoria = ($_POST['emp_categoria']);
	$emp_banco = ($_POST['emp_banco']);
	$emp_cbu = ($_POST['emp_cbu']);	
	$emp_suc_id = ($_POST['emp_suc_id']);		
    $emp_calle = ($_POST['emp_calle']);
    $emp_numero = ($_POST['emp_numero']);
    $emp_piso = ($_POST['emp_piso']);
    $emp_departamento = ($_POST['emp_departamento']);
    $emp_codigo_postal = ($_POST['emp_codigo_postal']);
    $emp_ciudad = ($_POST['emp_ciudad']);
    $emp_provincia = ($_POST['emp_provincia']);
    $emp_telefono1 = ($_POST['emp_telefono1']);
    $emp_telefono2 = ($_POST['emp_telefono2']);
    $emp_fax = ($_POST['emp_fax']);
    $emp_email = ($_POST['emp_email']);
    $emp_cuil = ($_POST['emp_cuil']);
    $emp_observaciones = ($_POST['emp_observaciones']);
    $emp_tipo_documento = ($_POST['emp_tipo_documento']);
    $emp_numero_documento = ($_POST['emp_numero_documento']);

    /*validaciones*/
    if (($_POST['emp_cuil']=="") and ($_POST['emp_nombre']=="") and ($_POST['emp_apellido']=="")) {
        $mensajeError .= "Debe completar Cuil, Nombre y Apellido.</br>";
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
        if (isset($_POST['emp_legajo'])) {
            if ($_POST['emp_cuil']=="") {
                $mensajeError .= "Falta completar el campo Cuil.</br>";
            }
        }
      }
    }
    /*validaciones*/

    if ($mensajeError!="") {
        $mensaje = $mensajeError;
    } else {
	//si le dio un click al boton enviar modifico los datos
	if (isset($_POST['emp_id'])){

            //Instancio el objeto
            $emp = new empleados($_POST['emp_id']);

            //Seteo las variables
            $emp->set_emp_nombre($_POST["emp_nombre"]);
            $emp->set_emp_apellido($_POST["emp_apellido"]);
            $emp->set_emp_legajo($_POST["emp_legajo"]);
			$emp->set_emp_fch_alta($_POST["emp_fch_alta"]);
			$emp->set_emp_fch_baja($_POST["emp_fch_baja"]);
			$emp->set_emp_fch_nac($_POST["emp_fch_nac"]);
			$emp->set_emp_sindicato($_POST["emp_sindicato"]);
			$emp->set_emp_obra_soc($_POST["emp_obra_soc"]);
			$emp->set_emp_categoria($_POST["emp_categoria"]);
			$emp->set_emp_banco($_POST["emp_banco"]);
			$emp->set_emp_cbu($_POST["emp_cbu"]);
			$emp->set_emp_suc_id($_POST["emp_suc_id"]);
            $emp->set_emp_calle($_POST["emp_calle"]);
            $emp->set_emp_numero($_POST["emp_numero"]);
            $emp->set_emp_piso($_POST["emp_piso"]);
            $emp->set_emp_departamento($_POST["emp_departamento"]);
            $emp->set_emp_codigo_postal($_POST["emp_codigo_postal"]);
            $emp->set_emp_ciudad($_POST["emp_ciudad"]);
            $emp->set_emp_provincia($_POST["emp_provincia"]);
            $emp->set_emp_telefono1($_POST["emp_telefono1"]);
            $emp->set_emp_telefono2($_POST["emp_telefono2"]);
            $emp->set_emp_fax($_POST["emp_fax"]);
            $emp->set_emp_email($_POST["emp_email"]);
            $emp->set_emp_cuil($_POST["emp_cuil"]);
            $emp->set_emp_observaciones($_POST["emp_observaciones"]);
            $emp->set_emp_tipo_documento($_POST["emp_tipo_documento"]);
            $emp->set_emp_numero_documento($_POST["emp_numero_documento"]);

            //actualizo los datos
            $resultado=$emp->update_EMP();
            //echo $resultado;
            if ($resultado>0){
                $mensaje="El empleado se modificó correctamente";
                $emp_apellido="";
				$emp_nombre="";
				$emp_legajo="";
				$emp_cuil="";
				$emp_tipo_documento="";
				$emp_numero_documento="";
				$emp_fch_alta="";
				$emp_fch_baja="";
				$emp_fch_nac="";
				$emp_sindicato="";
				$emp_obra_soc="";
				$emp_categoria="";
				$emp_banco="";
				$emp_cbu="";
				$emp_suc_id="";
				$emp_calle="";
				$emp_numero="";
				$emp_piso="";
				$emp_departamento="";
				$emp_codigo_postal="";
				$emp_ciudad="";
				$emp_provincia="";
				$emp_telefono1="";
				$emp_telefono2="";
				$emp_fax="";
				$emp_email="";
				$emp_observaciones="";
            } else {
                $mensaje="El empleado no se pudo modificar";
            }
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
  <h1>Modificar   empleados </h1>
  <!--Start FORM -->
  <table  class="form">
   <tr>
   <td>
   <?php
        echo "<FORM ACTION='modifica_empleados.php' METHOD='POST'  enctype='multipart/form-data'>";
        echo "<table>";
        echo "<tr>";
        echo "<td>";
        echo "<input size='100' name='emp_id' id='emp_id' value='".$emp->emp_id."' type='hidden' class='campos' size='18' />";
        echo '</td>';
        echo "</tr>";

        echo "<tr>";
        echo "<td class='formTitle'>";
        echo "APELLIDO";
        echo "</td>";
        echo "<td class='formFields'>";
        echo '<input size="100" type="text" name="emp_apellido" id="emp_apellido" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="'.$emp_apellido.'" />';
        echo "</td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td class='formTitle'>";
        echo "NOMBRE";
        echo "</td>";
        echo "<td class='formFields'>";
        echo '<input size="100" type="text" name="emp_nombre" id="emp_nombre" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="'.$emp_nombre.'" />';
        echo "</td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td class='formTitle'>";
        echo "LEGAJO";
        echo "</td>";
        echo "<td class='formFields'>";
        echo '<input size="10" maxlength="3" type="text" name="emp_legajo" id="emp_legajo" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="'.$emp_legajo.'" />';
        echo "</td>";
        echo "</tr>";
		
        echo "<tr>";
        echo "<td class='formTitle'>";
        echo "CUIL";
        echo "</td>";
        echo "<td class='formFields'>";
        echo '<input size="30" maxlength="11" type="text" name="emp_cuil" id="emp_cuil" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="'.$emp_cuil.'" />';
        echo "</td>";
        echo "</tr>";

        echo '<tr>';
        echo '<td class="formTitle">TIPO DOCUMENTO</td>';
        echo '<td><input size="10" maxlength="3" type="text" name="emp_tipo_documento" id="emp_tipo_documento" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="'.$emp_tipo_documento.'" /></td>';
        echo '</tr>';

        echo '<tr>';
        echo '<td class="formTitle">NUMERO DOCUMENTO</td>';
        echo '<td><input size="30" maxlength="10" type="text" name="emp_numero_documento" id="emp_numero_documento" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="'.$emp_numero_documento.'" /></td>';
        echo '</tr>';
		
        echo "<tr>";
        echo "<td class='formTitle'>";
        echo "FECHA DE NACIMIENTO (YYYY-MM-DD)";
        echo "</td>";
        echo "<td class='formFields'>";
        echo '<input size="30" maxlength="10" type="text" name="emp_fch_nac" id="emp_fch_nac" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="'.$emp_fch_nac.'" />';
        echo "</td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td class='formTitle'>";
        echo "FECHA DE ALTA (YYYY-MM-DD)";
        echo "</td>";
        echo "<td class='formFields'>";
        echo '<input size="30" maxlength="10" type="text" name="emp_fch_alta" id="emp_fch_alta" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="'.$emp_fch_alta.'" />';
        echo "</td>";
        echo "</tr>";
		
        echo "<tr>";
        echo "<td class='formTitle'>";
        echo "FECHA DE BAJA (YYYY-MM-DD)";
        echo "</td>";
        echo "<td class='formFields'>";
        echo '<input size="30" maxlength="10" type="text" name="emp_fch_baja" id="emp_fch_baja" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="'.$emp_fch_baja.'" />';
        echo "</td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td class='formTitle'>";
        echo "SINDICATO";
        echo "</td>";
        echo "<td class='formFields'>";
        echo '<input size="30" maxlength="6" type="text" name="emp_sindicato" id="emp_sindicato" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="'.$emp_sindicato.'" />';
        echo "</td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td class='formTitle'>";
        echo "OBRA SOCIAL";
        echo "</td>";
        echo "<td class='formFields'>";
        echo '<input size="30" maxlength="10" type="text" name="emp_obra_soc" id="emp_obra_soc" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="'.$emp_obra_soc.'" />';
        echo "</td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td class='formTitle'>";
        echo "CATEGORIA";
        echo "</td>";
        echo "<td class='formFields'>";
        echo '<input size="30" type="text" name="emp_categoria" id="emp_categoria" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="'.$emp_categoria.'" />';
        echo "</td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td class='formTitle'>";
        echo "BANCO (159)";
        echo "</td>";
        echo "<td class='formFields'>";
        echo '<input size="10" maxlength="3" type="text" name="emp_banco" id="emp_banco" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="'.$emp_banco.'" />';
        echo "</td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td class='formTitle'>";
        echo "CBU";
        echo "</td>";
        echo "<td class='formFields'>";
        echo '<input size="20" maxlength="14" type="text" name="emp_cbu" id="emp_cbu" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="'.$emp_cbu.'" />';
        echo "</td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td class='formTitle'>";
        echo "SEDE LABORAL";
        echo "</td>";
        echo "<td class='formFields'>";
        echo '<input size="30" type="text" name="emp_suc_id" id="emp_suc_id" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="'.$emp_suc_id.'" />';
        echo "</td>";
        echo "</tr>";

        echo '<tr>';
        echo '<td class="formTitle">';
        echo 'CALLE</td>';
        echo '<td>';
        echo '<input size="100" type="text" name="emp_calle" id="emp_calle" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="'.$emp_calle.'" />';
        echo '</td>';
        echo '</tr>';

        echo "<tr>";
        echo "<td class='formTitle'>";
        echo "NUMERO";
        echo "</td>";
        echo "<td class='formFields'>";
        echo '<input size="20" maxlength="10" type="text" name="emp_numero" id="emp_numero" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="'.$emp_numero.'" />';
        echo "</td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td class='formTitle'>";
        echo "PISO";
        echo "</td>";
        echo "<td class='formFields'>";
        echo '<input size="20" maxlength="5" type="text" name="emp_piso" id="emp_piso" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="'.$emp_piso.'" />';
        echo "</td>";
        echo "</tr>";

        echo '<tr>';
        echo '<td class="formTitle">';
        echo 'DEPARTAMENTO</td>';
        echo '<td>';
        echo '<input size="20" maxlength="5" type="text" name="emp_departamento" id="emp_departamento" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="'.$emp_departamento.'" />';
        echo '</td>';
        echo '</tr>';

        echo '<tr>';
        echo '<td class="formTitle">';
        echo 'CODIGO POSTAL</td>';
        echo '<td>';
        echo '<input size="20" maxlength="20" type="text" name="emp_codigo_postal" id="emp_codigo_postal" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="'.$emp_codigo_postal.'" />';
        echo '</td>';
        echo '</tr>';

        echo '<tr>';
        echo '<td class="formTitle">';
        echo 'CIUDAD</td>';
        echo '<td>';
        echo '<input size="100" type="text" name="emp_ciudad" id="emp_ciudad" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="'.$emp_ciudad.'" />';
        echo '</td>';
        echo '</tr>';

        echo '<tr>';
        echo '<td class="formTitle">';
        echo 'PROVINCIA</td>';
        echo '<td>';
        echo '<input size="100" type="text" name="emp_provincia" id="emp_provincia" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="'.$emp_provincia.'" />';
        echo '</td>';
        echo '</tr>';

        echo '<tr>';
        echo '<td class="formTitle">';
        echo 'TELEFONO1</td>';
        echo '<td>';
        echo '<input size="30" type="text" name="emp_telefono1" id="emp_telefono1" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="'.$emp_telefono1.'" />';
        echo '</td>';
        echo '</tr>';

        echo '<tr>';
        echo '<td class="formTitle">';
        echo 'TELEFONO2</td>';
        echo '<td>';
        echo '<input size="30" type="text" name="emp_telefono2" id="emp_telefono2" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="'.$emp_telefono2.'" />';
        echo '</td>';
        echo '</tr>';

        echo '<tr>';
        echo '<td class="formTitle">';
        echo 'FAX</td>';
        echo '<td>';
        echo '<input size="30" type="text" name="emp_fax" id="emp_fax" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="'.$emp_fax.'" />';
        echo '</td>';
        echo '</tr>';

        echo '<tr>';
        echo '<td class="formTitle">';
        echo 'E-MAIL</td>';
        echo '<td>';
        echo '<input size="40" type="text" name="emp_email" id="emp_email" class="campos" value="'.$emp_email.'" />';
        echo '</td>';
        echo '</tr>';

        echo '<tr>';
        echo '<td class="formTitle">';
        echo 'OBSERVACIONES</td>';
        echo '<td>';
        echo '<input size="100" type="text" name="emp_observaciones" id="emp_observaciones" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="'.$emp_observaciones.'" />';
        echo '</td>';
        echo '</tr>';

        echo "<tr>";
        echo "<td colspan='2' align='center' class='formFields'>";
        echo "<input type='submit' value='Enviar' class='boton' />";
        echo "<a href='abm_empleados.php'><input type='button' class='boton' value='Volver' onClick=\"window.location.href='abm_empleados.php'\" />";
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