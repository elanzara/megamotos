<?php
include_once 'class/session.php';
include_once 'class/modelos.php'; // incluye las clases
include_once 'class/marcas.php'; // incluye las clases
include_once 'class/clientes.php'; // incluye las clases
include_once 'class/conex.php';
include_once 'class/vehiculos.php'; // incluye las clases
include_once 'class/fechas.php';

$mensaje="";

$mar_id="";
$mod_id ="";
$cli_id="";
$veh_neumaticos="";
$veh_llantas="";
$veh_patente="";
$veh_rodado="";
$veh_f_ult_cambio_rodado="";
$mar_id_neumatico="";
$mod_id_neumatico="";
$veh_neumatico_medida="";
$mar_id_llanta="";
$mod_id_llanta="";
$veh_llanta_medida="";
$veh_km="";
$veh_fotos="";

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $mensajeError="";
    $veh_neumaticos = ($_POST['veh_neumaticos']);
    $veh_llantas = ($_POST['veh_llantas']);
    $veh_patente = ($_POST['veh_patente']);
    $veh_rodado = ($_POST['veh_rodado']);
    $veh_f_ult_cambio_rodado = ($_POST['veh_f_ult_cambio_rodado']);
    $veh_neumatico_medida = ($_POST['veh_neumatico_medida']);
    $veh_llanta_medida = ($_POST['veh_llanta_medida']);
    $veh_km = ($_POST['veh_km']);
    $mar_id = $_POST['marcas'];
    $mod_id = $_POST["modelos"];
    $mar_id_neumatico=$_POST["marcas_neumatico"];
    $mod_id_neumatico=$_POST["modelos_neumatico"];
    $mar_id_llanta=$_POST["marcas_llanta"];
    $mod_id_llanta=$_POST["modelos_llanta"];
    if($_POST["clientes"]!='' and $_POST["clientes"]!='0'){
        $cli_id=$_POST["clientes"];
    }else{
        $cli_id=$_GET["cli_id"];
    }
    $veh_distribucion = ($_POST['veh_distribucion']);

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
        //Instancio el objeto
        $veh = new vehiculos();

	//Seteo las variables
        $veh->set_mar_id($_POST["marcas"]);
        $veh->set_mod_id($_POST["modelos"]);
        $veh->set_neumatico_mar_id($_POST["marcas_neumatico"]);
        $veh->set_neumatico_mod_id($_POST["modelos_neumatico"]);
        $veh->set_llanta_mar_id($_POST["marcas_llanta"]);
        $veh->set_llanta_mod_id($_POST["modelos_llanta"]);
        $veh->set_cli_id($cli_id);
        $veh->set_veh_neumaticos($_POST["veh_neumaticos"]);
        $veh->set_veh_llantas($_POST["veh_llantas"]);
        $veh->set_veh_patente($_POST['veh_patente']);
        $veh->set_veh_rodado($_POST['veh_rodado']);
        $veh->set_veh_neumatico_medida($_POST['veh_neumatico_medida']);
        $veh->set_veh_llanta_medida($_POST['veh_llanta_medida']);
        $veh->set_veh_km($_POST['veh_km']);
        $veh->set_veh_distribucion($_POST['veh_distribucion']);
        $veh->set_veh_fotos($veh_fotos);
        $fechasql = new fechas();
        $f = $_POST['veh_f_ult_cambio_rodado'];
        $fechaconv =$fechasql->cambiaf_a_mysql($f);
        $veh->set_veh_f_ult_cambio_rodado($fechaconv);
        //Inserto el registro
        $resultado=$veh->insert_veh();
	//Inserto el registro    
	if ($resultado>0){
		$mensaje="El vehiculo se dio de alta correctamente";
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
                header( 'Location: abm_vehiculos.php?cli_id='.$cli_id);
	} else {
		$mensaje="No se pudo dar de alta el vehiculo";
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
<body onLoad="Irfoco('veh_neumaticos')">
<div id="page"> 
 <!--Start HEADER -->
 <?php require_once("header.php") ?>
 <!-- End HEADER -->
  <!--Start CENTRAL -->
 <div id="central">
  <h1>Alta de  vehiculos </h1>
  <!--Start FORM -->
  <form ACTION="alta_vehiculos.php?cli_id=<?php print $cli_id;?>" METHOD="POST" enctype="multipart/form-data">
     <table class="form" border="0"  align="center">
          <tr>
            <td class="formTitle">MARCA</td>
            <td>
                <?php
                    $mar = new marcas();
                    $res = $mar->getmarcasxTipIdCombo(1,$mar_id);
                    print $res;
                ?>
            </td>
          </tr>
          <tr>
            <td class="formTitle">MODELO</td>
            <td>
              <?php
               if (isset($mod_id) and $mod_id!="" and $mod_id!=0) {
                    $mod = new modelos();
                    $res = $mod->get_modelosComboxTipId(1,$mod_id);
                    print $res;
                 } else {
                    print '<select disabled="disabled" name="modelos" id="modelos">';
                    print '<option value="0">Selecciona opci&oacute;n...</option>';
                    print '</select>';
                 }
              ?>
            </td>
          </tr>
          <tr>
            <td class="formTitle">CLIENTE</td>
            <td>
                <?php
                    $cli = new clientes();
                    $res = $cli->getclientesCombo($cli_id, 'S');
                    print $res;
                ?>
            </td>
          </tr>
          <tr>
            <td class="formTitle">PATENTE</td>
            <td><input type="text" name="veh_patente" id="veh_patente" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $veh_patente;?>" /></td>
          </tr>
          <tr>
            <td class="formTitle">RODADO</td>
            <td><input type="text" name="veh_rodado" id="veh_rodado" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $veh_rodado;?>" /></td>
          </tr>
          <tr>
            <td class="formTitle">FECHA ULTIMO CAMBIO DE RODADO</td>
            <td><input type="text" name="veh_f_ult_cambio_rodado" id="veh_f_ult_cambio_rodado" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $veh_f_ult_cambio_rodado;?>" /></td>
          </tr>
          <tr>
            <td class="formTitle">KILOMETROS</td>
            <td><input type="text" name="veh_km" id="veh_km" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $veh_km;?>" /></td>
          </tr>
          <tr>
            <td class="formTitle">NEUMATICOS</td>
            <td><!--<input type="text" name="veh_neumaticos" id="veh_neumaticos" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="<?php //print $veh_neumaticos;?>" /></td>-->
          </tr>
          <tr>
            <td class="formTitle">MARCA NEUMATICO</td>
            <td>
                <?php
                    $mar = new marcas();
                    $res = $mar->getmarcasxTipIdComboNeumaticoNulo(4,$mar_id_neumatico);
                    print $res;
                ?>
            </td>
          </tr>
          <tr>
            <td class="formTitle">MODELO NEUMATICO</td>
            <td>
              <?php
               if (isset($mod_id_neumatico) and $mod_id_neumatico!="" and $mod_id_neumatico!=0) {
                    $mod = new modelos();
                    $res = $mod->get_modelosComboxTipIdNeumatico(4,$mod_id_neumatico);
                    print $res;
                 } else {
                    print '<select disabled="disabled" name="modelos_neumatico" id="modelos_neumatico">';
                    print '<option value="0">Selecciona opci&oacute;n...</option>';
                    print '</select>';
                 }
              ?>
            </td>
          </tr>
          <tr>
            <td class="formTitle">MEDIDA NEUMATICO</td>
            <td><input type="text" name="veh_neumatico_medida" id="veh_neumatico_medida" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $veh_neumatico_medida;?>" /></td>
          </tr>
	  <tr>
            <td class="formTitle">LLANTAS</td>
            <td><!--<input type="text" name="veh_llantas" id="veh_llantas" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="<?php //print $veh_llantas;?>" /></td>-->
          </tr>
          <tr>
            <td class="formTitle">MARCA LLANTA</td>
            <td>
                <?php
                    $mar = new marcas();
                    $res = $mar->getmarcas_llantaComboNulo($mar_id_llanta);
                    print $res;
                ?>
            </td>
          </tr>
          <tr>
            <td class="formTitle">MODELO LLANTA</td>
            <td>
              <?php
               if (isset($mod_id_llanta) and $mod_id_llanta!="" and $mod_id_llanta!=0) {
                    $mod = new modelos();
                    $res = $mod->get_select_modelosLlanta($mod_id_llanta);
                    print $res;
                 } else {
                    print '<select disabled="disabled" name="modelos_llanta" id="modelos_llanta">';
                    print '<option value="0">Selecciona opci&oacute;n...</option>';
                    print '</select>';
                 }
              ?>
            </td>
          </tr>
          <tr>
            <td class="formTitle">MEDIDA LLANTA</td>
            <td><input type="text" name="veh_llanta_medida" id="veh_llanta_medida" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $veh_llanta_medida;?>" /></td>
          </tr>
          <tr>
            <td class="formTitle">DISTRIBUCION</td>
            <td><input type="text" name="veh_distribucion" id="veh_distribucion" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $veh_distribucion;?>" /></td>
          </tr>
          <tr>
            <td class="formTitle" align="left">FOTO</td>
            <td align="left">
                <input type='hidden' name='MAX_FILE_SIZE' value='10000000' />
                <input type="file" id="veh_fotos" name="veh_fotos" />
                <label><?php echo $veh_fotos; ?></label>
            </td>
          </tr>
          <tr>
            <td colspan="2" >
              <input type="submit" class="boton" value="Enviar" />
              <a href='abm_vehiculos.php?cli_id=<?php print $cli_id;?>'>
                <input type='button' class='boton' value='Volver' onClick="window.location.href='abm_vehiculos.php?cli_id=<?php print $cli_id;?>'" />
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