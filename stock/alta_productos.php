<?php
include_once 'class/session.php';
include_once 'class/modelos.php'; // incluye las clases
include_once 'class/marcas.php'; // incluye las clases
include_once 'class/distribuidores.php'; // incluye las clases
include_once 'class/proveedores.php'; // incluye las clases
include_once 'class/tipo_productos.php'; // incluye las clases
include_once 'class/conex.php';
include_once 'class/productos.php'; // incluye las clases
include_once 'class/tipo_rango.php'; // incluye las clases

$mensaje="";

$pro_id="";
$mod_id="";
$mar_id="";
$dis_id="";
$prv_id="";
$pro_med_diametro="";
$pro_med_ancho="";
$pro_med_alto="";
$pro_nueva="1";
$pro_distribucion="";
$pro_stock_min="";
$pro_precio_costo="";
$pro_descripcion="";
$pro_tipo_llanta="";
$pro_material="";
$pro_terminaciones="";
$pro_controla_stock="S";
$pro_anio="";
$tr_id="";
$pro_foto="";
$pro_terminacion="";
$pro_clasificacion=""; /*A , C o R (A de Auto, C de camioneta y R de Replica.)*/


if (isset($_GET['boton_cambiar'])) {
    $tip_id="";
}
if ($_SERVER["REQUEST_METHOD"] == "GET"){
    if (isset($_GET["mod_id"])){
        $mar_id = $_GET['mar_id'];
        $mod_id = $_GET["mod_id"];
    }
        $dis_id = $_GET["dis_id"];
        $prv_id = $_GET["prv_id"];
        $tip_id = $_GET["tip_id"];
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['producto'])) {
    $tip_id = $_POST['tipo_productos'];

} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['alta_producto'])) {

    $mensajeError="";
    $mod_id=$_POST['modelos'];
    $mar_id=$_POST['marcas'];
    //$dis_id=$_POST['dis_id'];
    $prv_id=$_POST['proveedores'];
    $tip_id=$_POST['tipo_productos'];
    $pro_med_diametro=$_POST['pro_med_diametro'];
    $pro_med_ancho=$_POST['pro_med_ancho'];
    $pro_med_alto=$_POST['pro_med_alto'];
    $pro_nueva=$_POST['pro_nueva'];
    if ($pro_nueva=="Nueva"){
        $pro_nueva = 1;
    } else {
        if ($tip_id==5 || $tip_id==6 || $tip_id==7 || $tip_id==8){
            $pro_nueva = 1;
        } else {
            $pro_nueva = 0;
        }
    }
    $pro_distribucion=$_POST['pro_distribucion'];
    $pro_stock_min=$_POST['pro_stock_min'];
    $pro_precio_costo=$_POST['pro_precio_costo'];
    $pro_descripcion=$_POST['pro_descripcion'];
    $pro_tipo_llanta=$_POST['pro_tipo_llanta'];
    if ($tip_id==9 || $tip_id==2){
        $pro_material = $_POST['materiales'];;
    } else {
        $pro_material= $_POST['pro_material'];
    }
    $pro_terminaciones=$_POST['pro_terminaciones'];  
    $pro_controla_stock=$_POST['pro_controla_stock'];
    if ($pro_controla_stock=="on"){
        $pro_controla_stock="S";
    } else {
        $pro_controla_stock="N";
    }
    $pro_anio=$_POST['pro_anio'];
    $tr_id=$_POST['tipo_rango'];

    $nombre_archivo = $_FILES['pro_foto']['name'];
    $tipo_archivo = $_FILES['pro_foto']['type'];
    $tamano_archivo = $_FILES['pro_foto']['size'];

    if (!((strpos($tipo_archivo, "jpg") || strpos($tipo_archivo, "jpeg") ||strpos($tipo_archivo, "gif")) && ($tamano_archivo < 10000000))) {
          // echo "La extensi?n o el tama?o de los archivos no es correcta. <br><br><table><tr><td><li>Se permiten archivos .gif o .jpg<br><li>se permiten archivos de 100 Kb m?ximo.</td></tr></table>";
    }else{
           if (move_uploaded_file($_FILES['pro_foto']['tmp_name'],"images//$nombre_archivo")){
           //header ("Location: add_kart.php");
           }else{
           //  echo "Ocurri? alg?n error al subir el fichero. No pudo guardarse.";
           }
    }
    $pro_foto="images/".$nombre_archivo;
    $pro_terminacion=$_POST['pro_terminacion'];
    $pro_clasificacion=$_POST['pro_clasificacion']; /*A , C o R (A de Auto, C de camioneta y R de Replica.)*/

    /*validaciones*/
    if ($tip_id == 2 || $tip_id == 3 || $tip_id == 4 || $tip_id == 9) {
        if (isset($_POST['marcas'])) {
            if ($_POST['marcas']==0) {
                $mensajeError .= "Falta completar el campo Marca.</br>";
            }
        } else {
            $mensajeError .= "Falta completar el campo Marca.</br>";
        }
        if (isset($_POST['modelos'])) {
            /*if ($_POST['modelos']==0  or $_POST['modelos']=='' or $_POST['modelos']==' '
             or $_POST['modelos']=='Selecciona opción...' or $_POST['modelos']=='Elige')*/ 
             if ($_POST['modelos']=='Selecciona opción...' or $_POST['modelos']=='Elige') { 
                $mensajeError .= "Falta completar el campo Modelo.</br>";
            }
        } else {
            $mensajeError .= "Falta completar el campo Modelo.</br>";
        }
    }    
    if (isset($_POST['tipo_productos'])) {
        if ($_POST['tipo_productos']==0) {
            $mensajeError .= "Falta completar el campo Tipo producto.</br>";
        }
    } else {
        $mensajeError .= "Falta completar el campo Tipo producto.</br>";
    }
    /*validaciones*/

    if ($mensajeError!="") {
        $mensaje = $mensajeError;
    } else {
        //Instancio el objeto
        $pro = new productos();

	//Seteo las variables
        $pro->set_dis_id($dis_id);
        $pro->set_mar_id($mar_id);
        $pro->set_mod_id($mod_id);
        $pro->set_pro_descripcion($pro_descripcion);
        $pro->set_pro_distribucion($pro_distribucion);
        $pro->set_pro_med_alto($pro_med_alto);
        $pro->set_pro_med_ancho($pro_med_ancho);
        $pro->set_pro_med_diametro($pro_med_diametro);
        $pro->set_pro_nueva($pro_nueva);
        $pro->set_pro_precio_costo($pro_precio_costo);
        $pro->set_pro_stock_min($pro_stock_min);
        $pro->set_prv_id($prv_id);
        $pro->set_tip_id($tip_id);
        $pro->set_pro_anio($pro_anio);
        $pro->set_pro_controla_stock($pro_controla_stock);
        $pro->set_pro_material($pro_material);
        $pro->set_pro_terminaciones($pro_terminaciones);
        $pro->set_tr_id($tr_id);
        $pro->set_pro_foto($pro_foto);
        $pro->set_pro_terminacion($pro_terminacion);
        $pro->set_pro_clasificacion($pro_clasificacion);

        //Inserto el registro
        $resultado=$pro->insert_pro();
	if ($resultado>0){
            $mensaje="El producto se dio de alta correctamente";
            //$tip_id="";
            $pro_id="";
            $mod_id="";
            $mar_id="";
            $dis_id="";
            $prv_id="";
            $pro_med_diametro="";
            $pro_med_ancho="";
            $pro_med_alto="";
            $pro_nueva="1";
            $pro_distribucion="";
            $pro_stock_min="";
            $pro_precio_costo="";
            $pro_descripcion="";
            $pro_tipo_llanta="";
            $pro_material="";
            $pro_terminaciones="";
            $pro_controla_stock="S";
            $pro_anio="";
            $tr_id="";
            $pro_foto="";
            $pro_terminacion="";
            $pro_clasificacion="";

	} else {
            $mensaje="No se pudo dar de alta el Producto";
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
<?php
if ($tip_id==""){
    echo "<body onLoad=\"Irfoco('pro_descripcion')\">";
} elseif ($tip_id==4) {
    echo "<body onLoad=\"Irfoco('pro_descripcion')\">";
} elseif ($tip_id==3 || $tip_id==2) {
    echo "<body onLoad=\"Irfoco('pro_descripcion')\">";
} elseif ($tip_id==9) {
    echo "<body onLoad=\"Irfoco('pro_descripcion')\">";
}
?>

<div id="page"> 
 <!--Start HEADER -->
 <?php require_once("header.php") ?>
 <!-- End HEADER -->
  <!--Start CENTRAL -->
 <div id="central">
  <h1>Alta de  Productos </h1>
  <!--Start FORM -->
  
<?php
    if ($tip_id==""){
?>
  <form action="alta_productos.php" method="POST" enctype="multipart/form-data">
    <table class="form" border="0"  align="center">
          <tr>
            <td class="formTitle">TIPO PRODUCTO</td>
            <td>
                <?php
                    $tip = new tipo_productos();
                    $res = $tip->gettipo_productosCombo($tip_id, 'N');
                    print $res;
                ?>
            </td>
          </tr>
          <tr>
            <td colspan="3" >
              <input type="submit" id="producto" name="producto" class="boton" value="Seleccionar" />
              <a href='alta_productos.php'>
                <input type='button' id="boton_cambiar" class='boton' value='Cambiar Tipo Producto' onClick="window.location.href='alta_productos.php'" />
              </a>
              <a href='abm_productos.php'>
                <input type='button' class='boton' value='Volver' onClick="window.location.href='abm_productos.php'" />
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
</form>

<?php        
    } elseif ($tip_id==4) {
        $formulario = "alta";        
        include_once("form_neumaticos.php");
    } elseif ($tip_id==2) {
        $formulario = "alta";        
        include_once("form_llantas_deportivas.php");
    } elseif ($tip_id==9 || $tip_id==2) {
        $formulario = "alta";        
        include_once("form_llantas_originales.php");
    } else {
        $formulario = "alta";        
        include_once("form_otros.php");
    } 
 ?>
 </div> 
 <!--End CENTRAL -->
 <br clear="all" />
</div>
<script type="text/javascript" src="select_dependientes_xTipId.js"></script>
<script type="text/javascript">
function Irfoco(ID){
document.getElementById(ID).focus();
}
function setfoto(){
    var foto = document.getElementById("pro_foto").value;
    document.getElementById("pro_foto").value = foto;
}
</script>
</body>
</html>