<?php
require_once('class/fpdf/fpdf.php');
require_once('class/fpdf/fpdi.php');
require_once('class/orden_trabajo_enc.php');
require_once('class/orden_trabajo_det.php');
require_once('class/sucursales.php');
require_once('class/vehiculos.php');
require_once('class/clientes.php');
require_once('class/promociones.php');
require_once('class/conex.php');
require_once('class/marcas.php');
require_once('class/modelos.php');
require_once('class/productos.php');
require_once('class/tipo_productos.php');

/*IMPRIMIR OT*/

/*OBTENGO NRO OT*/
$ote_id = (isset($_GET['ote_id'])) ? (int) $_GET['ote_id'] : 0;

/*OBTENER LOS DATOS PARA EL ENCABEZADO*/
$ote = new orden_trabajo_enc($ote_id);
$veh_id = $ote->get_veh_id();
$cli_id = $ote->get_cli_id();

$fecha_arr = explode("-", $ote->get_fecha());
$fecha     = $fecha_arr[2]."/".$fecha_arr[1]."/".$fecha_arr[0];
//$fecha = $ote->get_fecha();

$numero = $ote->get_numero();
$suc_id = $ote->get_suc_id();
$observaciones = $ote->get_observaciones();
$realizo = $ote->get_realizo();
$pmo_id = $ote->get_pmo_id();

 switch ($ote->get_estado()) {
        case 0:
            $estado = "Pendiente";
            break;
        case 1:
            $estado = "Cancelada";
            break;
        case 2:
            $estado = "En ejecución";
            break;
        case 3:
            $estado = "A Facturar";
            break;
        case 4:
            $estado = "Finalizada";
            break;
}
$veh = new vehiculos($veh_id);
$vehiculo_pat = $veh->get_veh_patente();
$mar_id = $veh->get_mar_id();
$mar = new marcas($mar_id);
$marca =  $mar->get_mar_descripcion();
$mod_id = $veh->get_mod_id();
$mod = new modelos($mod_id);
$modelo = $mod->get_mod_descripcion();
$vehiculo_des = $marca.' - '.$modelo;

$cli = new clientes($cli_id);
$cliente = $cli->get_cli_apellido().' '.$cli->get_cli_nombre();
$telefono = $cli->get_cli_telefono1() . ' - ' . $cli->get_cli_telefono2(); 

$suc = new sucursales($suc_id);
$sucursal = $suc->get_suc_descripcion();

$pmo = new promociones($pmo_id);
$promocion = $pmo->get_pmo_descripcion();

/*FIN - OBTENER LOS DATOS PARA EL ENCABEZADO*/

// initiate FPDI
//echo $id1; 
//header ("Location: edu.php");
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

/*DATOS ENCABEZADO OT*/
$pdf->Line(0,35,250,35);
$pdf->SetFontSize(14);
$pdf->SetXY(65, 38);
$pdf->Write(0, "ORDEN DE TRABAJO");
$pdf->SetFontSize(10);
$pdf->Line(0,42,250,42);

$pdf->SetXY(05, 45);
$pdf->Write(0, "SUCURSAL: ".$sucursal);
$pdf->SetXY(120, 45);
$pdf->Write(0, "N° ORDEN: ".$numero);

$pdf->SetXY(05, 50);
$pdf->Write(0, "FECHA: ".$fecha);

$pdf->SetXY(05, 55);
$pdf->Write(0, "CLIENTE: ".$cliente);
$pdf->SetXY(120, 55);
$pdf->Write(0, "TELEFONO: ".$telefono);

$pdf->SetXY(05, 60);
$pdf->Write(0, "VEHICULO: ".$vehiculo_des);
$pdf->SetXY(120, 60);
$pdf->Write(0, "PATENTE: ".$vehiculo_pat);

$pdf->SetXY(05, 65);
$pdf->Write(0, "PROMOCION: ".$promocion);
$pdf->SetXY(120, 65);
$pdf->Write(0, "ESTADO: ".$estado);
$pdf->Line(0,67,250,67);
/*FIN - DATOS ENCABEZADO OT*/

/*DETALLE DE LA OT*/
$pdf->SetFontSize(12);
$pdf->SetXY(35, 70);
$pdf->Write(0, "TRABAJO A REALIZAR");
$pdf->SetXY(170, 70);
$pdf->Write(0, "COSTO");
$pdf->SetFontSize(10);
$pdf->Line(0,72,250,72);

$pdf->SetXY(15, 75);
$pdf->Write(0, "SERVICIOS");
$pdf->SetXY(40, 75);
$pdf->Write(0, "CANT.");
$pdf->SetXY(80, 75);
$pdf->Write(0, "DESCRIPCION");
$pdf->SetXY(160, 75);
$pdf->Write(0, "UNITARIO");
$pdf->SetXY(185, 75);
$pdf->Write(0, "TOTAL");
$pdf->Line(0,77,250,77);

$otd = new orden_trabajo_det();
$pro = new productos();
$tip = new tipo_productos();
$total = 0;
$linea = 80;
$detalle = $otd->getorden_trabajo_det_X_ote_id($ote_id);
while($row= mysql_fetch_assoc($detalle)) {
    //d.otd_id , d.pro_id , d.ote_id , d.cantidad , d.precio, p.pro_descripcion
    //$this->otd_id=$row['otd_id'];
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



    $pdf->SetXY(5, $linea);
    $pdf->Write(0, $tip->get_tip_descripcion());
    $pdf->SetXY(40, $linea);
    $pdf->Cell(10,0,$row['cantidad'],0,0,"R");
    //$pdf->Write(0, $row['cantidad']);
    $pdf->SetXY(55, $linea);
    $linea_aux = 0;
    //$pdf->Write(0, $row['pro_id'].' - '.$row['pro_descripcion']);
    //$pdf->Write(0, $pro_descripcion_seleccion);
    if (strlen($pro_descripcion_seleccion)>45){
        $cantidad = strlen($pro_descripcion_seleccion)/45;
        $cantidad = intval($cantidad);
        $cantidad    = $cantidad +1;
        $linea_aux = $linea;
        $inicio = 0;
        $pro_descripcion_aux = $pro_descripcion_seleccion;
        for($i = 1; $i <= $cantidad; $i++) {
            $pdf->SetXY(55, $linea_aux);
            $pro_descripcion_aux = substr($pro_descripcion_seleccion,$inicio,45);
            $pdf->Cell(80,0,$pro_descripcion_aux,0,0,"L");
            $inicio = $inicio + 45;
            $linea_aux = $linea_aux + 5;
        }
        
    } else {
        $pro_descripcion_seleccion = substr($pro_descripcion_seleccion,0,45);
        $pdf->Cell(80,0,$pro_descripcion_seleccion,0,0,"L");
    }
    /*AJUSTO LAS POSICIONES PARA MOSTRAR ORDENADOS LOS DECIMALES*/
    $pdf->SetXY(150, $linea);
    $entero = "0";
    $decimal = ".00";
    $pos = strpos($row['precio'],".");
    if ($pos === false){
        $entero = $row['precio'];
    } else {
        $entero = substr($row['precio'],0,$pos);
        $cant = strlen($row['precio']);
        $dif = $cant - $pos;
        $decimal = substr($row['precio'],$pos,$dif);
    }
    $pdf->Cell(15,0,$entero,0,0,"R");
    $pdf->SetXY(163, $linea);
    $pdf->Cell(5,0,$decimal,0,0,"L");
    
    /*FIN - AJUSTO LAS POSICIONES PARA MOSTRAR ORDENADOS LOS DECIMALES*/
    /*AJUSTO LAS POSICIONES PARA MOSTRAR ORDENADOS LOS DECIMALES*/
    $pdf->SetXY(180, $linea);
    //$pdf->Cell(19,0,$row['precio']*$row['cantidad'],0,0,"R");
    $importe = $row['precio']*$row['cantidad'];
    $entero = "0";
    $decimal = ".00";
    $pos = strpos($importe,".");
    if ($pos === false){
        $entero = $importe;
    } else {
        $entero = substr($importe,0,$pos);
        $cant = strlen($importe);
        $dif = $cant - $pos;
        $decimal = substr($importe,$pos,$dif);
    }
    $pdf->Cell(15,0,$entero,0,0,"R");
    $pdf->SetXY(193, $linea);
    $pdf->Cell(5,0,$decimal,0,0,"L");
    $total = $total +$importe;
    /*FIN - AJUSTO LAS POSICIONES PARA MOSTRAR ORDENADOS LOS DECIMALES*/
    if ($linea_aux>0){
        $linea = $linea_aux + 5;
    } else {
        $linea = $linea + 5;
    }
}

/*FIN - DETALLE DE LA OT*/

/*FOOTER*/
$pdf->Line(0,238,250,238);
$pdf->SetXY(160, 240);
$pdf->Write(0, "TOTAL: ");
    /*AJUSTO LAS POSICIONES PARA MOSTRAR ORDENADOS LOS DECIMALES*/
    $pdf->SetXY(179, 240);
    $entero = "0";
    $decimal = ".00";
    $pos = strpos($total,".");
    if ($pos === false){
        $entero = $total;
    } else {
        $entero = substr($total,0,$pos);
        $cant = strlen($total);
        $dif = $cant - $pos;
        $decimal = substr($total,$pos,$dif);
    }
    $pdf->Cell(15,0,$entero,0,0,"R");
    $pdf->SetXY(192, 240);
    $pdf->Cell(5,0,$decimal,0,0,"L");
    /*FIN - AJUSTO LAS POSICIONES PARA MOSTRAR ORDENADOS LOS DECIMALES*/


$pdf->Line(0,242,250,242);
$pdf->SetXY(5, 245);
//$pdf->Write(0, "OBSERVACIONES: ".$observaciones);
$pdf->Write(0, "OBSERVACIONES: ");
$linea_aux = 0;
if (strlen($observaciones)>60){
    $cantidad = strlen($observaciones)/60;
    $cantidad = intval($cantidad);
    $linea_aux = 245;
    $inicio = 0;
    $observaciones_aux = $observaciones;
    for($i = 1; $i <= $cantidad; $i++) {
        $pdf->SetXY(35, $linea_aux);
        $observaciones_aux = substr($observaciones,$inicio,60);
        $pdf->Cell(150,0,$observaciones_aux,0,0,"L");
        $inicio = $inicio + 60;
        $linea_aux = $linea_aux + 5;
    }
    
} else {
    $pdf->SetXY(35, 245);
    $observaciones = substr($observaciones,0,60);
    $pdf->Cell(80,0,$observaciones,0,0,"L");
}


//$pdf->Write(0, "OBSERVACIONES: ".$observaciones);





$pdf->SetXY(5, 260);
$pdf->Write(0, "REALIZADO POR: ".$realizo);


$pdf->SetXY(5, 265);
$pdf->Write(0, "FORMA DE PAGO:");
$pdf->SetXY(5, 270);
$pdf->Write(0, "EFECTIVO $:");
$pdf->SetXY(60, 270);
$pdf->Write(0, "3 CTAS. $:");
$pdf->SetXY(100, 270);
$pdf->Write(0, "6 CTAS. $:");
$pdf->SetXY(140, 270);
$pdf->Write(0, "12 CTAS. $:");
$pdf->SetXY(5, 275);
$pdf->Write(0, "COMISION:");
$pdf->Line(0,277,250,277);
/*FIN - FOOTER*/

$pdf->Output("ot.pdf","I");
$pdf->Close();

?>