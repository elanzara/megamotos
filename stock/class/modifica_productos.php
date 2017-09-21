<?php 
include_once 'class/session.php';
include_once 'class/modelos.php'; // incluye las clases
include_once 'class/marcas.php'; // incluye las clases
include_once 'class/distribuidores.php'; // incluye las clases
include_once 'class/proveedores.php'; // incluye las clases
include_once 'class/tipo_productos.php'; // incluye las clases
include_once 'class/conex.php';
include_once 'class/productos.php';
include_once 'class/tipo_rango.php'; // incluye las clases

$mensaje="";

$pro_id="";
$mod_id="";
$mar_id="";
$dis_id="";
$prv_id="";
$tip_id="";
$pro_med_diametro="";
$pro_med_ancho="";
$pro_med_alto="";
$pro_nueva="";
$pro_distribucion="";
$pro_stock_min="";
$pro_precio_costo="";
$pro_descripcion="";
$pro_tipo_llanta="";
$pro_material="";
$pro_terminaciones="";
$pro_controla_stock="";
$pro_anio="";
$tr_id="";
$pro_foto="";


$pro = new productos();

//Si en la grilla selecciono para modificar muestro los datos
if (isset($_GET['md'])) {
	//Instancio el objeto categorias
	$pro = new productos($_GET['md']);
    
    echo "pro_id: " . $_GET['md'] . "<br>";

    $pro_id=$pro->get_pro_id();
    $mod_id=$pro->get_mod_id();
    $mar_id=$pro->get_mar_id();
    $dis_id=$pro->get_dis_id();
    $prv_id=$pro->get_prv_id();
    $tip_id=$pro->get_tip_id();
    $pro_med_diametro=$pro->get_pro_med_diametro();
    $pro_med_ancho=$pro->get_pro_med_ancho();
    $pro_med_alto=$pro->get_pro_med_alto();
    $pro_nueva=$pro->get_pro_nueva();
    $pro_distribucion=$pro->get_pro_distribucion();
    $pro_stock_min=$pro->get_pro_stock_min();
    $pro_precio_costo=$pro->get_pro_precio_costo();
    $pro_descripcion=$pro->get_pro_descripcion();
    $pro_tipo_llanta=$pro->get_pro_tipo_llanta();
    $pro_material=$pro->get_pro_material();
    $pro_terminaciones=$pro->get_pro_terminaciones();
    $pro_controla_stock=$pro->get_pro_controla_stock();
    $pro_anio=$pro->get_pro_anio();
    $tr_id=$pro->get_tr_id();
    $pro_foto=$pro->get_pro_foto();
}

 if ($_SERVER["REQUEST_METHOD"] == "POST" /*&& isset($_POST['PRO_DESCRIPCION'])*/){
    $mensajeError="";

    $pro_id=$_POST['pro_id'];
    $mod_id=$_POST['modelos'];
    $mar_id=$_POST['marcas'];
    //$dis_id=$_POST['dis_id'];
    $prv_id=$_POST['proveedores'];
    $tip_id=$_POST['tipo_productos'];
    $pro_med_diametro=$_POST['pro_med_diametro'];
    $pro_med_ancho=$_POST['pro_med_ancho'];
    $pro_med_alto=$_POST['pro_med_alto'];
    $pro_nueva=$_POST['pro_nueva'];
    //echo "Nueva:".$pro_nueva."<br>";
    if ($pro_nueva=="Nueva"){
        $pro_nueva = 1;
    } else {
        $pro_nueva = 2;
    }
    $pro_distribucion=$_POST['pro_distribucion'];
    $pro_stock_min=$_POST['pro_stock_min'];
    $pro_precio_costo=$_POST['pro_precio_costo'];
    $pro_descripcion=$_POST['pro_descripcion'];
    $pro_tipo_llanta=$_POST['pro_tipo_llanta'];
    $pro_material=$_POST['pro_material'];
    $pro_terminaciones=$_POST['pro_terminaciones'];
    
    $pro_controla_stock=$_POST['pro_controla_stock'];
    //echo "Controla stock:".$pro_controla_stock."<br>";
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
           if (move_uploaded_file($_FILES['imagen']['tmp_name'],"images//$nombre_archivo")){
           //header ("Location: add_kart.php");
           }else{
           //  echo "Ocurri? alg?n error al subir el fichero. No pudo guardarse.";
           }
    }
    $pro_foto="images/".$nombre_archivo;



    /*validaciones*/
    if ($tip_id == 2 || $tip_id == 3 || $tip_id == 9) {
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
    }
    if (isset($_POST['proveedores'])) {
        if ($_POST['proveedores']==0) {
            $mensajeError .= "Falta completar el campo Proveedor.</br>";
        }
    } else {
        $mensajeError .= "Falta completar el campo Proveedor.</br>";
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
	//si le dio un click al boton enviar modifico los datos
	if (isset($_POST['pro_id'])){

            //Instancio el objeto
            $pro = new productos($_POST['pro_id']);

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
                //actualizo los datos
            $resultado=$pro->update_PRO();
            //echo $resultado;
            if ($resultado>0){
                $mensaje="El producto se modificó correctamente";
                $pro_id="";
                $mod_id="";
                $mar_id="";
                $dis_id="";
                $prv_id="";
                $tip_id="";
                $pro_med_diametro="";
                $pro_med_ancho="";
                $pro_med_alto="";
                $pro_nueva="";
                $pro_distribucion="";
                $pro_stock_min="";
                $pro_precio_costo="";
                $pro_descripcion="";
                $pro_tipo_llanta="";
                $pro_material="";
                $pro_terminaciones="";
                $pro_controla_stock="";
                $pro_anio="";
                $tr_id="";
            } else {
                $mensaje="El producto no se pudo modificar";
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
<body>
<div id="page"> 
 <!--Start HEADER -->
 <?php require_once("header.php") ?>
 <!-- End HEADER -->
  <!--Start CENTRAL -->
 <div id="central">
  <h1>Modificar   Productos </h1>
  <!--Start FORM -->
  <table  class="form">
   <tr>
   <td>
   <?php
   
//   if ($tip_id != ""){
//    $formulario = "modifica";
//    include_once("form_neumaticos.php");
//   }
    if ($tip_id==4) {
        $formulario = "modifica";        
        include_once("form_neumaticos.php");
    } elseif ($tip_id==3 || $tip_id==2) {
        $formulario = "modifica";        
        include_once("form_llantas_deportivas.php");
    } elseif ($tip_id==9) {
        $formulario = "modifica";        
        include_once("form_llantas_originales.php");
    } else {
        $formulario = "modifica";        
        include_once("form_otros.php");
    }
    ?>
     <?php
	//if (isset($_POST["mensaje"])) {
    if ($mensaje!=""){
       //	$mensaje=$_POST["mensaje"];
		echo "<br><br><span class='Estilo3'><B>$mensaje</span>";
	}//}
     ?>
 </div> 
 <!--End CENTRAL -->
 <br clear="all" />
</div>
<script type="text/javascript" src="select_dependientes.js"></script>
</body>
</html>