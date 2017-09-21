<?php 
include_once 'class/session.php';
include_once 'class/modelos.php'; // incluye las clases
include_once 'class/marcas.php'; // incluye las clases
include_once 'class/clientes.php'; // incluye las clases
include_once 'class/conex.php';
include_once 'class/vehiculos.php';
include_once 'class/fechas.php';

$mensaje="";

$veh_id="";
$veh_neumaticos="";
$veh_llantas="";
$veh_patente="";
$veh_rodado="";
$veh_f_ult_cambio_rodado="";
$veh_neumatico_medida="";
$veh_llanta_medida="";
$veh_km="";
$marca="";
$modelo="";
$marca_neumatico="";
$modelo_neumatico="";
$marca_llanta="";
$modelo_llanta="";
$cliente="";
$veh_fotos="";
$veh_distribucion="";

$veh = new vehiculos();

if ($_SERVER["REQUEST_METHOD"] == "GET"){
    if (isset($_GET["mod_id"])){
        $mar_id = $_GET['mar_id'];
        $mod_id = $_GET["mod_id"];
    }
    if (isset($_GET["mod_id_llanta"])){
        $mar_id_llanta = $_GET['mar_id_llanta'];
        $mod_id_llanta = $_GET["mod_id_llanta"];
    }
    if (isset($_GET["mod_id_neumatico"])){
        $mar_id_neumatico = $_GET['mar_id_neumatico'];
        $mod_id_neumatico = $_GET["mod_id_neumatico"];
    }
        $cli_id = $_GET["cli_id"];
}

//Si en la grilla selecciono para modificar muestro los datos
if (isset($_GET['md'])) {
	//Instancio el objeto 
	$veh = new vehiculos($_GET['md']);
        $veh_id = $veh->get_veh_id();
        $veh_neumaticos = $veh->get_veh_neumaticos();
        $veh_llantas = $veh->get_veh_llantas();
        $veh_patente = $veh->get_veh_patente();
        $veh_rodado = $veh->get_veh_rodado();
        $veh_f_ult_cambio_rodado = $veh->get_veh_f_ult_cambio_rodado();
        $veh_neumatico_medida = $veh->get_veh_neumatico_medida();
        $veh_llanta_medida = $veh->get_veh_llanta_medida();
        $veh_km = $veh->get_veh_km();
        $marca=$veh->get_mar_id();
        $modelo=$veh->get_mod_id();
        $cliente=$veh->get_cli_id();
        $cli_id = $veh->get_cli_id();
        $marca_neumatico=$veh->get_neumatico_mar_id();
        $modelo_neumatico=$veh->get_neumatico_mod_id();
        $marca_llanta=$veh->get_llanta_mar_id();
        $modelo_llanta=$veh->get_llanta_mod_id();
        $veh_fotos=$veh->get_veh_fotos();
        $veh_distribucion=$veh->get_veh_distribucion();
}

 if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $mensajeError="";

    $veh = new vehiculos($_POST['veh_id']);
    $veh_id = $veh->get_veh_id();
    $veh_neumaticos = $veh->get_veh_neumaticos();
    $veh_llantas = $veh->get_veh_llantas();
    $veh_patente = $veh->get_veh_patente();
    $veh_rodado = $veh->get_veh_rodado();
    $veh_f_ult_cambio_rodado = $veh->get_veh_f_ult_cambio_rodado();
    $veh_neumatico_medida = $veh->get_veh_neumatico_medida();
    $veh_llanta_medida = $veh->get_veh_llanta_medida();
    $veh_km = $veh->get_veh_km();
    $marca=$_POST["marcas"];
    $modelo=$_POST["modelos"];
    $marca_neumatico=$_POST["marcas_neumatico"];
    $modelo_neumatico=$_POST["modelos_neumatico"];
    $marca_llanta=$_POST["marcas_llanta"];
    $modelo_llanta=$_POST["modelos_llanta"];
    if($_POST["clientes"]!='' and $_POST["clientes"]!='0'){
        $cliente=$_POST["clientes"];
    }else{
        $cliente=$veh->get_cli_id();
    }
    $cli_id = $veh->get_cli_id();
    $veh_distribucion=$_POST["veh_distribucion"];

    $nombre_archivo = $_FILES['veh_fotos']['name'];
    $tipo_archivo = $_FILES['veh_fotos']['type'];
    $tamano_archivo = $_FILES['veh_fotos']['size'];

    if (!((strpos($tipo_archivo, "jpg") || strpos($tipo_archivo, "jpeg") ||strpos($tipo_archivo, "gif")) && ($tamano_archivo < 10000000))) {
          // echo "La extensi?n o el tama?o de los archivos no es correcta. <br><br><table><tr><td><li>Se permiten archivos .gif o .jpg<br><li>se permiten archivos de 100 Kb m?ximo.</td></tr></table>";
    }else{
           if (move_uploaded_file($_FILES['imagen']['tmp_name'],"images//$nombre_archivo")){
           //header ("Location: add_kart.php");
           }else{
           //  echo "Ocurri? alg?n error al subir el fichero. No pudo guardarse.";
           }
    }
    $veh_fotos="images/".$nombre_archivo;


    /*validaciones*/
    if (isset($_POST['marcas'])) {
        if ($_POST['marcas']==0) {
            $mensajeError .= "Falta completar el campo Marca.</br>";
        }
    } else {
        $mensajeError .= "Falta completar el campo Marca.</br>";
    }
    if (isset($_POST['modelos'])) {
        if ($_POST['modelos']==0) {
            $mensajeError .= "Falta completar el campo Modelo.</br>";
        }
    } else {
        $mensajeError .= "Falta completar el campo Modelo.</br>";
    }
//    if (isset($_POST['clientes'])) {
//        if ($_POST['clientes']==0) {
//            $mensajeError .= "Falta completar el campo cliente.</br>";
//        }
//    } else {
//        $mensajeError .= "Falta completar el campo cliente.</br>";
//    }
    if ($cli_id=='' or $cli_id==0) {
        $mensajeError .= "Falta completar el campo cliente.</br>";
    }
    /*validaciones*/

    if ($mensajeError!="") {
        $mensaje = $mensajeError;
    } else {
	//si le dio un click al boton enviar modifico los datos
	if (isset($_POST['veh_id'])){

            //Instancio el objeto
            $veh = new vehiculos($_POST['veh_id']);

            //Seteo las variables
            $veh->set_mar_id($_POST["marcas"]);
            $veh->set_mod_id($_POST["modelos"]);
            $veh->set_cli_id($cli_id);
            //$veh->set_cli_id($_POST["clientes"]);
            $veh->set_veh_neumaticos($_POST["veh_neumaticos"]);
            $veh->set_veh_llantas($_POST["veh_llantas"]);
            $veh->set_veh_patente($_POST['veh_patente']);
            $veh->set_veh_rodado($_POST['veh_rodado']);
            $fechasql = new fechas();
            $f = $_POST['veh_f_ult_cambio_rodado'];
            $fechaconv =$fechasql->cambiaf_a_mysql($f);
            $veh->set_veh_f_ult_cambio_rodado($fechaconv);
            $veh->set_neumatico_mar_id($_POST["marcas_neumatico"]);
            $veh->set_neumatico_mod_id($_POST["modelos_neumatico"]);
            $veh->set_veh_neumatico_medida($_POST['veh_neumatico_medida']);
            $veh->set_llanta_mar_id($_POST["marcas_llanta"]);
            $veh->set_llanta_mod_id($_POST["modelos_llanta"]);
            $veh->set_veh_llanta_medida($_POST['veh_llanta_medida']);
            $veh->set_veh_km($_POST['veh_km']);
            $veh->set_veh_distribucion($_POST['veh_distribucion']);
            $veh->set_veh_fotos($veh_fotos);
            //actualizo los datos
            $resultado=$veh->update_veh();
            //echo $resultado;
            if ($resultado>0){
                $mensaje="El vehiculo se modificó correctamente";
                $veh_neumaticos="";
                $veh_llantas="";
                $veh_patente="";
                $veh_rodado="";
                $veh_f_ult_cambio_rodado="";
                $veh_neumatico_medida="";
                $veh_llanta_medida="";
                $veh_km="";
                $veh_fotos="";
                $veh_distribucion="";
            } else {
                $mensaje="El vehiculo no se pudo modificar";
            }
	}
    }
}
//echo'ma:'.$marca.'mo:'.$modelo.'man:'.$marca_neumatico.'mon:'.$modelo_neumatico.'mall:'.$marca_llanta.'moll:'.$modelo_llanta;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>MEGALLANTAS - Admin</title>
<link rel="shortcut icon" href="../imagenes/tu-logo-mitad2.jpg"></link>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>
<body onLoad="Irfoco('veh_neumaticos')">
<div id="page"> 
 <!--Start HEADER -->
 <?php require_once("header.php") ?>
 <!-- End HEADER -->
  <!--Start CENTRAL -->
 <div id="central">
  <h1>Modificar   vehiculos </h1>
  <!--Start FORM -->
  <table  class="form">
   <tr>
   <td>
   <?php
    echo "<FORM ACTION='modifica_vehiculos.php?cli_id=$cli_id' METHOD='POST'  enctype='multipart/form-data'>";
    echo "<table>";
    echo "<tr>";
    echo "<td>";
    echo "<input name='veh_id' id='veh_id' value='".$veh_id."' type='hidden' class='campos' size='18' />";
    echo '<input type="hidden" name="cli_id" id="cli_id" value="'.$cli_id.'" />';
    echo "</tr>";

    echo '<tr>';
    echo '<td class="formTitle">';
    echo 'MARCA</td>';
    echo '<td>';
          $mar = new marcas();
          $res = $mar->getmarcasxTipIdCombo(1,$marca);
          print $res;
    echo '</td>';
    echo '</tr>';

    echo '<td class="formTitle">';
    echo 'MODELO</td>';
    echo '<td class="formFields">';
          $mod = new modelos();
          $res = $mod->get_modelosComboxTipId(1,$modelo);
          print $res;
    echo '</td>';
    echo '</tr>';

    echo '<tr>';
    echo '<td class="formTitle">';
    echo 'CLIENTE</td>';
    echo '<td>';
          $cli = new clientes();
          $res = $cli->getclientesCombo($cliente, 'S');
          print $res;
    echo '</td>';
    echo '</tr>';

    echo "<tr>";
    echo "<td class='formTitle'>";
    echo "PATENTE";
    echo "</td>";
    echo "<td class='formFields'>";
    echo '<input type="text" name="veh_patente" id="veh_patente" class="campos" value="'.$veh_patente.'" onkeyup="this.value=this.value.toUpperCase()" />';
    echo "</td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td class='formTitle'>";
    echo "RODADO";
    echo "</td>";
    echo "<td class='formFields'>";
    echo '<input type="text" name="veh_rodado" id="veh_rodado" class="campos" value="'.$veh_rodado.'" onkeyup="this.value=this.value.toUpperCase()" />';
    echo "</td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td class='formTitle'>";
    echo "FECHA ULTIMO CAMBIO DE RODADO";
    echo "</td>";
    echo "<td class='formFields'>";
    $fechaNormal = new fechas();
    echo "<input name='veh_f_ult_cambio_rodado' id='veh_f_ult_cambio_rodado' value='".$fechaNormal->cambiaf_a_normal($veh->veh_f_ult_cambio_rodado)."' type='text' class='Estilo1' size='18' />";
    echo "</td>";
    echo "</tr>";

    echo '<tr>';
    echo '<td class="formTitle">';
    echo 'NEUMATICOS</td>';
    echo '<td>';
//    echo '<input type="text" name="veh_neumaticos" id="veh_neumaticos" class="campos" value="'.$veh_neumaticos.'" onkeyup="this.value=this.value.toUpperCase()" />';
    echo '</td>';
    echo '</tr>';

    echo '<tr>';
    echo '<td class="formTitle">';
    echo 'MARCA NEUMATICO</td>';
    echo '<td>';
          $mar = new marcas();
          $res = $mar->getmarcasxTipIdComboNeumaticoNulo(4,$marca_neumatico);
          print $res;
    echo '</td>';
    echo '</tr>';

    echo '<td class="formTitle">';
    echo 'MODELO NEUMATICO</td>';
    echo '<td class="formFields">';
    if (isset($modelo_neumatico) and $modelo_neumatico!="" and $modelo_neumatico!=0) {
          $mod = new modelos();
          $res = $mod->get_modelosComboxTipIdNeumatico(4,$modelo_neumatico);
          print $res;
    } else {
        print '<select disabled="disabled" name="modelos_neumatico" id="modelos_neumatico">';
        print '<option value="0">Selecciona opci&oacute;n...</option>';
        print '</select>';
    }
    echo '</td>';
    echo '</tr>';

    echo "<tr>";
    echo "<td class='formTitle'>";
    echo "MEDIDA NEUMATICO";
    echo "</td>";
    echo "<td class='formFields'>";
    echo '<input type="text" name="veh_neumatico_medida" id="veh_neumatico_medida" class="campos" value="'.$veh_neumatico_medida.'" onkeyup="this.value=this.value.toUpperCase()" />';
    echo "</td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td class='formTitle'>";
    echo "LLANTAS";
    echo "</td>";
    echo "<td class='formFields'>";
//    echo '<input type="text" name="veh_llantas" id="veh_llantas" class="campos" value="'.$veh_llantas.'" onkeyup="this.value=this.value.toUpperCase()" />';
    echo "</td>";
    echo "</tr>";

    echo '<tr>';
    echo '<td class="formTitle">';
    echo 'MARCA LLANTA</td>';
    echo '<td>';
          $mar = new marcas();
          $res = $mar->getmarcas_llantaComboNulo($marca_llanta);
          print $res;
    echo '</td>';
    echo '</tr>';

    echo '<td class="formTitle">';
    echo 'MODELO LLANTA</td>';
    echo '<td class="formFields">';
    if (isset($modelo_llanta) and $modelo_llanta!="" and $modelo_llanta!=0) {
          $mod = new modelos();
          $res = $mod->get_select_modelosLlanta($modelo_llanta);
          print $res;
    } else {
        print '<select disabled="disabled" name="modelos_llanta" id="modelos_llanta">';
        print '<option value="0">Selecciona opci&oacute;n...</option>';
        print '</select>';
    }
    echo '</td>';
    echo '</tr>';

    echo "<tr>";
    echo "<td class='formTitle'>";
    echo "MEDIDA LLANTA";
    echo "</td>";
    echo "<td class='formFields'>";
    echo '<input type="text" name="veh_llanta_medida" id="veh_llanta_medida" class="campos" value="'.$veh_llanta_medida.'" onkeyup="this.value=this.value.toUpperCase()" />';
    echo "</td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td class='formTitle'>";
    echo "KILOMETROS";
    echo "</td>";
    echo "<td class='formFields'>";
    echo '<input type="text" name="veh_km" id="veh_km" class="campos" value="'.$veh_km.'" onkeyup="this.value=this.value.toUpperCase()" />';
    echo "</td>";
    echo "</tr>";

    echo '<tr>';
    echo '<td class="formTitle">DISTRIBUCION</td>';
    echo '<td><input type="text" name="veh_distribucion" id="veh_distribucion" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="'.$veh_distribucion.'" /></td>';
    echo '</tr>';

    echo "<tr>";
    echo "<td class='formTitle' align='left'>FOTO</td>";
    echo "<td align='left'>";
    echo "<input type='hidden' name='MAX_FILE_SIZE' value='10000000' />";
    echo "<input type='file' id='veh_fotos' name='veh_fotos' />";
    echo "<label><?php echo $veh_fotos; ?></label>";
    echo "</td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td colspan='2' align='center' class='formFields'>";
    echo "<input type='submit' value='Enviar' class='boton' />";
    echo "<a href='abm_vehiculos.php?cli_id=$cli_id'><input type='button' class='boton' value='Volver' onClick=\"window.location.href='abm_vehiculos.php?cli_id=$cli_id'\" /></td>";
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
<script type="text/javascript" src="select_dependientes_xTipId.js"></script>
<script type="text/javascript" src="select_depen_xTipId_neu.js"></script>
<script type="text/javascript" src="select_depen_llanta.js"></script>
<script type="text/javascript">
function Irfoco(ID){
document.getElementById(ID).focus();
}
</script>
</body>
</html>