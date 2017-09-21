<?php 
include_once 'class/session.php';
include_once 'class/conex.php';
//include_once 'class/fechas.php';
//include_once 'class/reportes.php';
//require_once('class/fpdf/fpdf.php');
//require_once('class/fpdf/fpdi.php');

//Filtro:
session_start();

$_SESSION["search_tprod"]="";
$_SESSION["search_marca"]="0";
$_SESSION["search_sucursal"]="";
if ($_SESSION["search_desde"]==""){
        $_SESSION["search_desde"]=date("d")."/".date("m")."/".date("Y");
}
if ($_SESSION["search_hasta"]==""){
        $_SESSION["search_hasta"]=date("d")."/".date("m")."/".date("Y");
}

if (isset($_POST["tipo_productos"])){
    $_SESSION["search_tprod"] = $_POST["tipo_productos"];
}
if (isset($_POST['marcas'])) {
  if ($_SESSION["search_marca"]=="Selecciona Opción..."){
    $_SESSION["search_marca"] = 0;
  }else{
    $_SESSION["search_marca"] = $_POST['marcas'];
  }
}
if (isset($_POST["sucursales"])){
    $_SESSION["search_sucursal"] = $_POST["sucursales"];
}
if (isset($_POST["desde"])){
    $_SESSION["search_desde"] = $_POST["desde"];
}
if (isset($_POST["hasta"])){
    $_SESSION["search_hasta"] = $_POST["hasta"];
}

if ($_SERVER["REQUEST_METHOD"] == "POST" /*and $_GET["imprimir"]=='S'*/) {
    $mensajeError="";

    /*validaciones*/
    if (isset($_POST['desde'])) {
        if ($_POST['desde']=="") {
            $mensajeError .= "Falta completar el campo Fecha Desde.</br>";
        }
    }
    if (isset($_POST['hasta'])) {
        if ($_POST['hasta']=="") {
            $mensajeError .= "Falta completar el campo Fecha Hasta.</br>";
        }
    }
    if (isset($_POST['desde']) and isset($_POST['hasta'])) {
        if (strtotime(str_replace('/', '-', $_POST['desde'])) > strtotime(str_replace('/', '-', $_POST['hasta']))) {
            $mensajeError .= "La fecha hasta debe ser mayor o igual a la Fecha Desde.</br>";
        }
    }
    /*validaciones*/

    if ($mensajeError!="") {
        $mensaje = $mensajeError;
    } else {
           //header( 'Location: imprimir_neum_ingresados.php');
        //$fechaNormal = new fechas();
//echo'd:'.$fechaNormal->cambiaf_a_mysql($_SESSION["search_desde"]).'-h:'.$fechaNormal->cambiaf_a_mysql($_SESSION["search_hasta"]);
//echo'd:'.$_SESSION["search_desde"].'-h:'.$_SESSION["search_hasta"];
?>
<script type="text/javascript">
function llamado_reporte(){
    ///alert('etro'+<?php ////echo json_encode($_SESSION["search_desde"]); ?>);
    //var desde=document.getElementById('desde').value;
    //var hasta=document.getElementById('hasta').value;
    //    window.open('imprimir_neum_ingresados.php?desde='+<?php ////echo $_SESSION["search_desde"]; ?>
    //+'&hasta='+<?php ////echo $_SESSION["search_hasta"]; ?>);
  window.open('imprimir_prod_ingresados.php?tip_id='+<?php echo $_SESSION["search_tprod"]; ?>
        +'&mar_id='+<?php echo $_SESSION["search_marca"]; ?>
        +'&suc_id='+<?php echo $_SESSION["search_sucursal"]; ?>
        +'&desde='+<?php echo json_encode($_SESSION["search_desde"]); ?>
        +'&hasta='+<?php echo json_encode($_SESSION["search_hasta"]); ?>
        ,"alwaysRaised=yes,toolbar=no,menubar=no,status=no,resizable=yes,width=1200,height=500,left=50,top=100");
}
</script>
<script type="text/javascript">
llamado_reporte();
</script>
<?php
////        // initiate FPDI
////        $pdf = new FPDI('L','mm','A4');
////        // add a page
////        $pdf->AddPage();
////        $pdf->SetMargins(5, 5, 5);
////        //$pdf->SetAutoPageBreak(30, 5);
////        // now write some text above the imported page
////        $pdf->SetFont('courier');
////        $pdf->SetTextColor(0,0,0);
////        $pdf->SetFontSize(10);
////
////        /*ENCABEZADO*/
////        $pdf->Image("mega.png",5,5);
////        $pdf->SetXY(65, 10);
////        $pdf->Write(0, "Céspedes 3823 Esq. Av. Forest – C.A.B.A ");
////        $pdf->SetXY(65, 15);
////        $pdf->Write(0, "Tel: 4555–0344 / 4553–3977");
////        $pdf->SetXY(65, 20);
////        $pdf->Write(0, "Cordoba 4171 - C.A.B.A  -  Tel: 4866 - 5947  /  4861 - 2980 ");
////        $pdf->SetXY(65, 25);
////        $pdf->Write(0, "Santa Fé 1215 – Morón  Tel: 4628 - 7808");
////        /*FIN ENCABEZADO*/
////
////        /*TITULO*/
////        $pdf->Line(0,35,290,35);
////        $pdf->SetFontSize(14);
////        $pdf->SetXY(105, 38);
////        $pdf->Write(0, "NEUMATICOS INGRESADOS");
////        $pdf->Line(0,42,290,42);
////
////        /*DETALLE*/
////        $linea1 = 45;
////        $pdf->SetFontSize(10);
////        $pdf->SetXY(1, $linea1);
////        $pdf->Write(0, "SUCURSAL");
////        $pdf->SetXY(30, $linea1);
////        $pdf->Write(0, "MARCA");
////        $pdf->SetXY(60, $linea1);
////        $pdf->Write(0, "MODELO");
////        $pdf->SetXY(100, $linea1);
////        $pdf->Write(0, "PRODUCTO");
////        $pdf->SetXY(165, $linea1);
////        $pdf->Write(0, "FECHA");
////        $pdf->SetXY(190, $linea1);
////        $pdf->Write(0, "DIAMETRO");
////        $pdf->SetXY(220, $linea1);
////        $pdf->Write(0, "ANCHO");
////        $pdf->SetXY(240, $linea1);
////        $pdf->Write(0, "ALTO");
////        $pdf->SetXY(268, $linea1);
////        $pdf->Write(0, "CANTIDAD");
////        $pdf->Line(0,$linea1+2,290,$linea1+2);
////
////        $rep = new reportes();
////        $i = 0;
////        $cant = 0;
////        $linea2 = 55;
////        $fechaNormal = new fechas();
//////echo'd:'.$fechaNormal->cambiaf_a_mysql($_POST["desde"]).'-h:'.$fechaNormal->cambiaf_a_mysql($_POST["hasta"]);
////        $detalle = $rep->get_rep_neumaticos_ingresados(
////                                $fechaNormal->cambiaf_a_mysql($_SESSION["search_desde"])
////                                ,$fechaNormal->cambiaf_a_mysql($_SESSION["search_hasta"]));
////        while($row= mysql_fetch_assoc($detalle)) {
////            $cant = $cant + 1;
////            $i = $i + 1;//echo'i:'.$i;
////            //if($pdf->GetY()+$h>$pdf->PageBreakTrigger){$pdf->AddPage();}
////            if (($cant<=28 and $i==28) or ($cant>28 and $i==32)){//echo'add-page-i:'.$i;
////                $pdf->AddPage();
////                $pdf->SetMargins(5, 5, 5);
////                $pdf->SetFont('courier');
////                $pdf->SetTextColor(0,0,0);
////                $pdf->SetFontSize(10);
////                $linea1 = 15;
////                $linea2 = 25;
////                $i = 0;
////                $pdf->SetXY(1, $linea1);
////                $pdf->Write(0, "SUCURSAL");
////                $pdf->SetXY(30, $linea1);
////                $pdf->Write(0, "MARCA");
////                $pdf->SetXY(60, $linea1);
////                $pdf->Write(0, "MODELO");
////                $pdf->SetXY(100, $linea1);
////                $pdf->Write(0, "PRODUCTO");
////                $pdf->SetXY(165, $linea1);
////                $pdf->Write(0, "FECHA");
////                $pdf->SetXY(190, $linea1);
////                $pdf->Write(0, "DIAMETRO");
////                $pdf->SetXY(220, $linea1);
////                $pdf->Write(0, "ANCHO");
////                $pdf->SetXY(240, $linea1);
////                $pdf->Write(0, "ALTO");
////                $pdf->SetXY(268, $linea1);
////                $pdf->Write(0, "CANTIDAD");
////                $pdf->Line(0,$linea1+2,290,$linea1+2);
////            }//echo'datos';
////            //$pdf->SetXY(1, $linea2);
////            //$pdf->Write(0, $i);
////            //$pdf->SetXY(7, $linea2);
////            $pdf->SetXY(1, $linea2);
////            $pdf->Write(0, $row['suc_descripcion']);
////            $pdf->SetXY(30, $linea2);
////            $pdf->Write(0, $row['mar_descripcion']);
////            $pdf->SetXY(60, $linea2);
////            $pdf->Write(0, $row['mod_descripcion']);
////            $pdf->SetXY(100, $linea2);
////            $pdf->Write(0, $row['pro_id']);
////            $pdf->SetXY(120, $linea2);
////            $pdf->Write(0, $row['pro_descripcion']);
////            $pdf->SetXY(165, $linea2);
////            $pdf->Write(0, $fechaNormal->cambiaf_a_normal($row['fecha']));
////            $pdf->SetXY(190, $linea2);
////            $pdf->Write(0, $row['pro_med_diametro']);
////            $pdf->SetXY(220, $linea2);
////            $pdf->Write(0, $row['pro_med_ancho']);
////            $pdf->SetXY(240, $linea2);
////            $pdf->Write(0, $row['pro_med_alto']);
////            $pdf->SetXY(268, $linea2);
////            $pdf->Write(0, $row['cantidad']);
////            //$pdf->Cell(10,0,$row['cantidad'],0,0,"R");
////            $linea2 = $linea2 + 5;
////        }//echo'output';
////        //$pdf->SetY(-10);
////        $pdf->Output("neu_ing.pdf","I");
////        $pdf->Close();
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
  <h1>Reporte de Productos Ingresados </h1>
  <!--Start Tabla  -->
   <table class="form">
    <tr>
    <td>
    <form action='rep_productos_ingresados.php' method='POST' enctype='multipart/form-data'>
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
            <td style="padding-left:10px;">Marca:</td>
            <td>
                <?php
                 if ($_SESSION["search_tprod"]!="" and $_SESSION["search_tprod"]!="0"
                 and $_SESSION["search_tprod"]!="Elige" and $_SESSION["search_tprod"]!="Selecciona Opción...") {
                    include_once 'class/marcas.php';
                    $mar = new marcas();
                    $res = $mar->getmarcasxTipIdComboNulo($_SESSION["search_tprod"]);
                    print $res;
                 } else {
                    print '<select disabled="disabled" name="marcas" id="marcas">';
                    print '<option value=0>Selecciona opci&oacute;n...</option>';
                    print '</select>';
                 }
                ?>
            </td>
            <td style="padding-left:100px;">Sucursal:</td>
            <td>
                <?php
                include_once 'class/sucursales.php';
                $suc = new sucursales();
                $html = $suc->getsucursalesnuloCombo($_SESSION["search_sucursal"]);
                echo $html.'<br></br>';
                ?>
            </td>
      </tr>
      <tr>
            <td>Desde (DD/MM/YYYY):</td>
            <td><input type="text" id="desde" name="desde" size="10" value="<?php echo $_SESSION["search_desde"];?>" /></td>
            <td style="padding-left:10px;">Hasta (DD/MM/YYYY):</td>
            <td><input type="text" id="hasta" name="hasta" size="10" value="<?php echo $_SESSION["search_hasta"];?>" /></td>
      </tr>
    </table>
    <table align="center"  border="0">
      <tr>
        <td style="padding-top:50px; padding-left:300px;"><input type="submit" value="Ver Reporte" />&nbsp;</td>
        <!--<td style="padding-top:50px; padding-left:300px;">
          <a href="rep_neumaticos_ingresados.php?desde=<?php //echo $_SESSION["search_desde"];?>
          &hasta=<?php //echo $_SESSION["search_hasta"];?>&imprimir=S" target="_blank">
                <input type='button' class='boton' value='Ver Reporte' />
                <input type='button' class='boton' value='Ver Reporte' />
          </a>
        </td>-->
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