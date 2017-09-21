<?php 
include_once 'class/session.php';
include_once 'class/conex.php';
//include_once 'class/reportes.php';
//require_once('class/fpdf/fpdf.php');
//require_once('class/fpdf/fpdi.php');

//Filtro:
session_start();

$_SESSION["search_tprod"]="";
$_SESSION["search_sucursal"]="";

if (isset($_POST["tipo_productos"])){
    $_SESSION["search_tprod"] = $_POST["tipo_productos"];
}
if (isset($_POST["sucursales"])){
    $_SESSION["search_sucursal"] = $_POST["sucursales"];
}

if ($_SERVER["REQUEST_METHOD"] == "POST" /*and $_GET["imprimir"]=='S'*/) {
    $mensajeError="";

    /*validaciones*/
    /*validaciones*/

    if ($mensajeError!="") {
        $mensaje = $mensajeError;
    } else {
           //header( 'Location: imprimir_neum_ingresados.php');
?>
<script type="text/javascript">
function llamado_reporte(){
  window.open('imprimir_compara_saldos.php?tip_id='+<?php echo $_SESSION["search_tprod"]; ?>
        +'&suc_id='+<?php echo $_SESSION["search_sucursal"]; ?>
        ,"alwaysRaised=yes,toolbar=no,menubar=no,status=no,resizable=yes,width=1200,height=500,left=50,top=100");
}
</script>
<script type="text/javascript">
llamado_reporte();
</script>
<?php
    }//else
}//POST
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
  <h1>Reporte de Comparación Saldos </h1>
  <!--Start Tabla  -->
   <table class="form">
    <tr>
    <td>
    <form action='rep_compara_saldos.php' method='POST' enctype='multipart/form-data'>
    <table align="center"  border="0">
      <tr>
            <td>Tipo Producto:</td>
            <td>
                <?php
                    include_once 'class/tipo_productos.php';
                    $tip = new tipo_productos($_SESSION["search_tprod"]);
                    $res = $tip->getTipnuloCombo();
                    print $res.'<br></br>';
                ?>
            </td>
            <td style="padding-left:100px;">Sucursal:</td>
            <td>
                <?php
                include_once 'class/sucursales.php';
                $suc = new sucursales();
                $html = $suc->getsucursalesCombo($_SESSION["search_sucursal"]);
                echo $html.'<br></br>';
                ?>
            </td>
      </tr>
    </table>
    <table align="center"  border="0">
      <tr>
        <td style="padding-top:50px; padding-left:300px;"><input type="submit" value="Ver Reporte" />&nbsp;</td>
      </tr>
    </table>
    </form>
    </td>
    </tr>
    <tr>
    <td class="mensaje" style="padding-top:30px;">
         <?php
          		if (isset($mensaje)) {
          			echo $mensaje;
          		}
         ?>
    </td>
  </tr>
 </table>
<!--End Tabla -->
 </div>
<!--End CENTRAL -->
  <br clear="all" />
</div>
<script type="text/javascript" src="select_dependientes_tip_mar.js"></script>
</body>
</html>