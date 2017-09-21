<?php
require_once('class/pdf/class.ezpdf.php');
require_once 'class/DB.php';
// session
require_once 'session.php';

require_once 'class/yyyy_mm.php';

$forma = new yyyy_mm();


// Conexion
$db = new DB();

    $sql = "select DATE_FORMAT(max(fechaActualizacion), '%d/%m/%Y') as fecha
            from deuda d";
    $rs = $db->query($sql);
    $row = mysql_fetch_array($rs);

    //Fecha de actualizacion
    $fecha = $row["fecha"];

    $sql = "SELECT d.importeExcedente
    FROM deuda d
    WHERE d.cuit = '{$_SESSION["cuit"]}' ";
    $rs = $db->query($sql);
    $row = mysql_fetch_array($rs);

    $excedente = $row["importeExcedente"];


    // Consulto los datos a la db
    $sql = "SELECT e.*, c.*,
                DATE_FORMAT(fecha_emision, '%d/%m/%Y') as fecha_emision,
                DATE_FORMAT(vigente_desde, '%d/%m/%Y') as vigente_desde,
                DATE_FORMAT(vigente_hasta, '%d/%m/%Y') as vigente_hasta
            FROM empresas e, contratos c
            WHERE e.cuit = c.cuit
            AND e.cuit = ".$_SESSION["cuit"];
    $rs = $db->query($sql);
    $row = mysql_fetch_array($rs);

    $domicilio = (empty ($row["calle"]))? ""    :$row["calle"]." ";
    $domicilio.= (empty ($row["nro"]))? ""      :$row["nro"]." ";
    $domicilio.= (empty ($row["piso"]))? ""     :"Piso ".$row["piso"]." ";
    $domicilio.= (empty ($row["depto"]))? ""    :"Depto ".$row["depto"]." - ";
    $domicilio.= (empty ($row["localidad"]))? "":$row["localidad"]." ";
    $domicilio.= (empty ($row["cpostal"]))? ""  :"(".$row["cpostal"].")";

    $Empresa=$row["nombre"];
    $CUIT=$row["cuit"];
    $Actividad=$row["desc_actividad"];
    $contrato=$row["nro_contrato"];


$pdf =& new Cezpdf('a4','landscape');
$pdf->selectFont('class/pdf/fonts/Times-Roman.afm');
$pdf->ezSetCmMargins(1,1,1.5,1.5);


$sql = "SELECT concat(substr(periodoCobertura,1,4),'-',substr(periodoCobertura,5,2)) periodoCobertura,
d.ddjj,
concat(substr(periodoFiscal,1,4),'-',case length(substr(periodoFiscal,5,2)) when 2 then substr(periodoFiscal,5,2) else concat('0',substr(periodoFiscal,5,2)) end) periodoFiscal,
d.cant_personas,
concat('$ ',format(d.masa_salario,2)) masa_salario,
d.componenteFija,
d.componenteVariable,
concat('$ ',format(d.premioEmitido,2)) premioEmitido,
concat('$ ',format(d.FFEPagado,2)) FFEPagado,
concat('$ ',format(d.importePagos,2)) importePagos,
concat('$ ',format(d.importeCuotaAplicado,2)) importeCuotaAplicado,
concat('$ ',format(d.saldo,2)) saldo
    FROM deuda d
    WHERE d.cuit = '{$_SESSION["cuit"]}' ";

/*$sql.="union
    select 'TOTAL'
    , ''
    , ''
    , ''
    , ''
    , ''
    , ''
    , concat('$ ',format(sum(d.premioEmitido),2)) totEmision
        , concat('$ ',format(sum(d.FFEPagado),2)) totFFE
        , concat('$ ',format(sum(d.importePagos),2)) totPagos
        , concat('$ ',format(sum(d.importeCuotaAplicado),2)) totCuota
        , concat('$ ',format(sum(d.saldo),2)) totSaldo
        from deuda d
        WHERE d.cuit = '{$_SESSION["cuit"]}' ";
*/
$sql.= "ORDER BY periodoCobertura ASC ";
$rsDeuda = $db->query($sql);
$rsCant = $db->numrows($rsDeuda);

$ixx = 0;
while($datatmp = mysql_fetch_assoc($rsDeuda)) {
    $ixx = $ixx+1;
    //$data[] = array_merge($datatmp, array('num'=>$ixx));
    $data[] = array_merge($datatmp);
}

//Calculo los totales
$sql = "select 'TOTAL'
    , ''
    , ''
    , ''
    , ''
    , ''
    , ''
    , concat('$ ',format(sum(d.premioEmitido),2)) totEmision
        , concat('$ ',format(sum(d.FFEPagado),2)) totFFE
        , concat('$ ',format(sum(d.importePagos),2)) totPagos
        , concat('$ ',format(sum(d.importeCuotaAplicado),2)) totCuota
        , concat('$ ',format(sum(d.saldo),2)) totSaldo
        from deuda d
    WHERE d.cuit = '{$_SESSION["cuit"]}' ";

$rsTotales = $db->query($sql);
$rsCantidad = $db->numrows($rsTotales);
//if(mysql_num_rows($rsTotales) > 0){

//    while ($row = mysql_fetch_array($rsTotales)) {
$row = mysql_fetch_array($rsTotales);
        $totales = array('periodoCobertura'=>'<b>TOTAL</b>'
                           ,'ddjj'=>''
                           ,'periodoFiscal'=>''
                            ,'cant_personas'=>''
                            ,'masa_salario'=>''
                            ,'componenteFija'=>''
                            ,'componenteVariable'=>''
                            ,'premioEmitido'=>'<b>'.$row["totEmision"].'</b>'
                            ,'FFEPagado'=>'<b>'.$row["totFFE"].'</b>'
                            ,'importePagos'=>'<b>'.$row["totPagos"].'</b>'
                            ,'importeCuotaAplicado'=>'<b>'.$row["totCuota"].'</b>'
                            ,'saldo'=>'<b>'.$row["totSaldo"].'</b>');
//    }
//}
$data[] = array_merge($totales);
$titles = array(
                //'num'=>'<b>Num</b>',
                'periodoCobertura'=>'<b>P.Cobertura</b>',
                'ddjj'=>'<b>DDJJ</b>',
                'periodoFiscal'=>'<b>P.Fiscal</b>',
                'cant_personas'=>'<b>Cant.Trabajadores</b>',
                'masa_salario'=>'<b>Masa salarial</b>',
                'componenteFija'=>'<b>Comp. fija</b>',
                'componenteVariable'=>'<b>Comp. variable %</b>',
                'premioEmitido'=>'<b>Cuota</b>',
                'FFEPagado'=>'<b>F.F.E.</b>',
                'importePagos'=>'<b>Tot. a Pagar</b>',
                'importeCuotaAplicado'=>'<b>Pagos</b>',
                'saldo'=>'<b>Saldo</b>',
            );
$options = array(
                'shadeCol'=>array(0.9,0.9,0.9),
                'xOrientation'=>'center',
                'width'=>750
            );
$txttit = "<b>LIDERAR ART</b>\n";
$txttit.= "<b>Estado de cuenta al: ".$fecha."</b>\n";
//$txttit.= "<b>Pagos a imputar en Exceso: $ ".$excedente."</b>\n\n";
$txttit.= "\n\n\n";
$txttit.= "Empresa: ".$Empresa."\n";
$txttit.= "Contrato: ".$contrato."\n";
$txttit.= "Domicilio: ".$domicilio."\n";
$txttit.= "CUIT: ".$CUIT."\n";
$txttit.= "Actividad: ".$Actividad."\n";
//src="img/logo.gif"
//$txttit.= "Ejemplo de PDF con PHP y MYSQL \n";
//$pdf->ezImage("logo.jpg",5,100,'full','center','');
$pdf->ezImage("cabezal.jpg",5,750,"","left");
$pdf->ezText($txttit, 12);
$pdf->ezTable($data, $titles, '', $options);
$pdf->ezTable($totales, '', '', $options);

$pdf->ezText("\n\n\n", 10);
$pdf->ezText("<b>Fecha de impresión: </b> ".date("d/m/Y H:i:s")."\n", 10);
$txtPie ="El presente Estado de Cuenta se emite conforme la información suministrada por la AFIP a la fecha, la que podrá ser modificada ante la presentación de información posterior.\n";
$txtPie.="En caso que Ud. verifique diferencias u omisiones en el detalle mostrado, por favor comuníquese con Atención al Cliente de LIDERAR ART.\n";
$txtPie.="Teléfono de Contacto ; 5258-7010 de 9 a 17 hs.\n";
$txtPie.="El saldo no incluye intereses por deudas atrasadas , para conocer el monto de dichos intereses comuníquese con Atención al Cliente de LIDERAR ART.\n";
$txtPie.="Aclaración: El estado de cuenta será actualizado mensualmente (S.E.U.O.).\n";
$pdf->ezText($txtPie,10);
/*$pdf->ezText("El presente Estado de Cuenta se emite conforme la información suministrada por la AFIP a la fecha, la que podrá ser modificada ante la presentación de información posterior.\n",10);
$pdf->ezText("En caso que Ud. verifique diferencias u omisiones en el detalle mostrado, por favor comuníquese con Atención al Cliente de LIDERAR ART.\n",10);
$pdf->ezText("Teléfono de Contacto ; 5258-7010 de 9 a 17 hs.\n",10);
$pdf->ezText("El saldo no incluye intereses por deudas atrasadas , para conocer el monto de dichos intereses comuníquese con Atención al Cliente de LIDERAR ART.\n",10);
$pdf->ezText("Aclaración: El estado de cuenta será actualizado mensualmente.",10);
 */
  //$pdf->ezText("<b>Hora:</b> ".date("H:i:s")."\n\n", 10);
$pdf->ezImage("pie.jpg",1,500,"","left");
$pdf->ezStream();

?>
