<?php
require_once('class/fpdf/fpdf.php');
require_once('class/fpdf/fpdi.php');

require_once('class/movimientos_stock.php');
require_once('class/sucursales.php');
require_once('class/usuarios.php');
require_once('class/tipo_movimientos.php');
require_once('class/conex.php');
require_once('class/marcas.php');
require_once('class/modelos.php');
require_once('class/productos.php');
require_once('class/tipo_productos.php');

/*IMPRIMIR REMITO*/

/*OBTENGO NRO MOV*/
$mov_id = (isset($_GET['mov_id'])) ? (int) $_GET['mov_id'] : 0;

/*OBTENER LOS DATOS PARA EL ENCABEZADO*/
$mov = new movimientos_stock($mov_id);

$fecha_arr = explode("-", $mov->get_fecha());
$fecha     = $fecha_arr[2]."/".$fecha_arr[1]."/".$fecha_arr[0];
$suc_id = $mov->get_suc_id();
$ote_id = $mov->get_ote_id();
$trans_id = $mov->get_trans_id();
$encabezado_id = $mov->get_encabezado_id();
$remito = $mov->get_remito();
$usu_id = $mov->get_usu_id();

$suc = new sucursales($suc_id);
$sucursal = $suc->get_suc_descripcion();

$usu = new usuarios($usu_id);
$usuario = $usu->get_usu_descripcion();

if($trans_id!="" and $trans_id!="0"){
    //echo'encabezado_id:'.$encabezado_id.'-remito:'.$remito.'-fecha:'.$mov->get_fecha()
    //.'-usu_id:'.$usu_id.'-trans_id:'.$trans_id.'-ote_id:'.$ote_id;
    $tdetalle = $mov->getmovimientos_stock_detalles($encabezado_id, $remito, $mov->get_fecha(), $usu_id, $trans_id, $ote_id);
    while($trow= mysql_fetch_assoc($tdetalle)) {
        $sucursal_destino = $trow['suc_destino'];
    }
}
/*FIN - OBTENER LOS DATOS PARA EL ENCABEZADO*/

// initiate FPDI
$pdf = new FPDI();
// add a page
$pdf->AddPage();

// now write some text above the imported page
$pdf->SetFont('courier');
$pdf->SetTextColor(0,0,0);
$pdf->SetFontSize(10);

/*ENCABEZADO*/
$pdf->Image("mega.png",5,5);
$pdf->SetXY(65, 10);
$pdf->Write(0, "Céspedes 3823 Esq. Av. Forest – C.A.B.A ");
$pdf->SetXY(65, 15);
$pdf->Write(0, "Tel: 4555–0344 / 4553–3977");
$pdf->SetXY(65, 20);
$pdf->Write(0, "Cordoba 4171 - C.A.B.A  -  Tel: 4866 - 5947  /  4861 - 2980 ");
$pdf->SetXY(65, 25);
$pdf->Write(0, "Santa Fé 1215 – Morón  Tel: 4628 - 7808");
/*FIN ENCABEZADO*/

/*DATOS ENCABEZADO*/
$pdf->Line(0,35,250,35);
$pdf->SetFontSize(14);
$pdf->SetXY(90, 38);
$pdf->Write(0, "REMITO");
$pdf->SetFontSize(10);
$pdf->Line(0,42,250,42);

$pdf->SetXY(05, 45);
$pdf->Write(0, "ENCABEZADO: ".$encabezado_id);
$pdf->SetXY(100, 45);
$pdf->Write(0, "N° REMITO: ".$remito);
$pdf->SetXY(05, 50);
$pdf->Write(0, "FECHA: ".$fecha);
$pdf->SetXY(05, 55);
$pdf->Write(0, "SUCURSAL: ".$sucursal);
$pdf->SetXY(100, 55);
$pdf->Write(0, "SUCURSAL DESTINO: ".$sucursal_destino);
$pdf->SetXY(05, 60);
$pdf->Write(0, "NRO.OTE: ".$ote_id);
$pdf->SetXY(100, 60);
$pdf->Write(0, "TRANSFERENCIA: ".$trans_id);
//$pdf->SetXY(05, 65);
//$pdf->Write(0, "USUARIO: ".$usuario);
$pdf->Line(0,67,250,67);
/*FIN - DATOS ENCABEZADO*/

/*DETALLE*/
$pdf->SetFontSize(12);
$pdf->SetXY(75, 70);
$pdf->Write(0, "MOVIMIENTO DE STOCK");
$pdf->SetFontSize(10);
$pdf->Line(0,72,250,72);

$pdf->SetXY(0, 75);
$pdf->Write(0, "T.MVTO");
$pdf->SetXY(20, 75);
$pdf->Write(0, "PRODUCTO");
$pdf->SetXY(110, 75);
$pdf->Write(0, "CANTIDAD");
$pdf->SetXY(130, 75);
$pdf->Write(0, "OBSERVACIONES");
$pdf->Line(0,77,250,77);

$linea = 80;
//echo'fecha:'.$mov->get_fecha().'-remito:'.$remito;
if($encabezado==''){$encabezado=0;}
if($remito==''){$remito='';}
if($usu_id==''){$usu_id=0;}
if($trans_id==''){$trans_id=0;}
if($ote_id==''){$ote_id=0;}
//echo'enc:'.$encabezado_id.'-rem:'.$remito.'-fec:'.$mov->get_fecha().'-usu:'.$usu_id.'-trans:'.$trans_id.'-ote:'.$ote_id;

$detalle = $mov->getmovimientos_stock_detalles($encabezado_id, $remito, $mov->get_fecha(), $usu_id, $trans_id, $ote_id);
    //echo'enc:'.$encabezado_id.'-rem:'.$remito.'-fec:'.$mov->get_fecha().'-usu:'.$usu_id.'-tra:'.$trans_id.'-ote:'.$ote_id;
while($row= mysql_fetch_assoc($detalle)) {
    //echo'pro:'.$row['pro_id'].'-canti:'.$row['cantidad'];
    $tim_id = $mov->get_tim_id();
    $tim = new tipo_movimientos($tim_id);
    $pro = new productos($row['pro_id']);
    $tip = new tipo_productos($pro->get_tip_id());
    /*ARMO LA DESCRIPCION DEL PRODUCTO*/
    $descripcion = $pro->get_pro_descripcion();
    $med_diametro = $pro->get_pro_med_diametro();
    $med_ancho = $pro->get_pro_med_ancho();
    $med_alto = $pro->get_pro_med_alto();
    $distribucion = $pro->get_pro_distribucion();
    $pro_mar_id = $pro->get_mar_id();
    $pro_mod_id = $pro->get_mod_id();

    $pro_mar = new marcas($pro_mar_id);
    $pro_marca = $pro_mar->get_mar_descripcion();

    $pro_mod = new modelos($pro_mod_id);
    $pro_modelo = $pro_mod->get_mod_descripcion();

    $pro_estado_seleccion = $pro->get_pro_nueva();
    if ($pro_estado_seleccion == 1){
        $estado_pro = " - Nuevo";
    } else {
        $estado_pro = " - Usado";
    }
    switch ($pro->get_tip_id()){
        case 9:
            $pro_descripcion_seleccion = $row['pro_id']. " ". $estado_pro . " " . $pro_marca . " " . $pro_modelo . " " . $med_diametro . "-" . $med_ancho . "-" . $distribucion . " " . $descripcion;
            break;
        case 2:
            $pro_descripcion_seleccion = $row['pro_id']. " ". $estado_pro . " " . $med_diametro . "-" . $med_ancho . "-" . $distribucion . " " . $descripcion;
            break;
        case 4:
            $pro_descripcion_seleccion = $row['pro_id']. " ". $estado_pro . " " . $pro_marca . " " . $pro_modelo . " " . $med_ancho . "-" . $med_alto . "-" . $med_diametro . " " . $descripcion;
            break;
        default:
            $pro_descripcion_seleccion = $row['pro_id']. " ".$descripcion;
            break;
    }
    /*FIN - ARMO LA DESCRIPCION DEL PRODUCTO*/

    $pdf->SetXY(0, $linea);
    if($trans_id==0){
        $transferencia='';
    }else{
        $transferencia='Tf.';
    }
    $pdf->Write(0, $transferencia.$tim->get_tim_descripcion());
    $pdf->SetXY(20, $linea);
    $pdf->Write(0, substr($pro_descripcion_seleccion,0,43));
    $pdf->SetXY(110, $linea);
    //$pdf->Write(0, $row['cantidad']);
    $pdf->Cell(19,0,$row['cantidad'],0,0,"R");
    //$pdf->Cell(10,0,$row['cantidad'],0,0,"R");
    $pdf->SetXY(130, $linea);
    $pdf->Write(0, substr($row['observaciones'],0,30));

    $linea = $linea + 5;
}
/*FIN - DETALLE*/

/*FOOTER*/
$pdf->Line(0,262,250,262);
$pdf->SetXY(5, 245);

$pdf->SetXY(5, 270);
$pdf->Write(0, "USUARIO: ".$usuario);

$pdf->Line(0,277,250,277);
/*FIN - FOOTER*/

$pdf->Output("remito.pdf","I");
$pdf->Close();
?>