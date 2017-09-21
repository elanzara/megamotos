<?php
require_once('class/fpdf/fpdf.php');
require_once('class/fpdf/fpdi.php');
require_once('class/conex.php');
include_once 'class/reportes.php';
include_once 'class/productos.php';

        // initiate FPDI
        $pdf = new FPDI('L','mm','A4');
        // add a page
        $pdf->AddPage();
        $pdf->SetMargins(5, 5, 5);
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

        /*TITULO*/
        $pdf->Line(0,35,290,35);
        $pdf->SetFontSize(14);
        $pdf->SetXY(105, 38);
        $pdf->Write(0, "COMPARACION SALDOS");
        $pdf->Line(0,42,290,42);

        /*DETALLE*/
        $linea1 = 45;
        $pdf->SetFontSize(10);
        $pdf->SetXY(1, $linea1);
        $pdf->Write(0, "MARCA");
        $pdf->SetXY(30, $linea1);
        $pdf->Write(0, "MODELO");
        $pdf->SetXY(65, $linea1);
        $pdf->Write(0, "PRODUCTO");
        $pdf->SetXY(145, $linea1);
        $pdf->Write(0, "ANCHO");
        $pdf->SetXY(165, $linea1);
        $pdf->Write(0, "ALTO");
        $pdf->SetXY(180, $linea1);
        $pdf->Write(0, "DIAMETRO");
        $pdf->SetXY(210, $linea1);
        $pdf->Write(0, "SALDO NUEVO");
        $pdf->SetXY(240, $linea1);
        $pdf->Write(0, "SALDO VIEJO");
        $pdf->SetXY(268, $linea1);
        $pdf->Write(0, "DIFERENCIA");
        $pdf->Line(0,$linea1+2,290,$linea1+2);

        $rep = new reportes();
        $i = 0;
        $cant = 0;
        $linea2 = 55;
        $detalle = $rep->get_rep_compara_saldos(
                                $_GET["tip_id"]
                                ,$_GET["suc_id"]);
        while($row= mysql_fetch_assoc($detalle)) {
            $cant = $cant + 1;
            $i = $i + 1;//echo'i:'.$i;
            if (($cant<=28 and $i==28) or ($cant>28 and $i==32)){//echo'add-page-i:'.$i;
                $pdf->AddPage();
                $pdf->SetMargins(5, 5, 5);
                $pdf->SetFont('courier');
                $pdf->SetTextColor(0,0,0);
                $pdf->SetFontSize(10);
                $linea1 = 15;
                $linea2 = 25;
                $i = 0;
                $pdf->SetFontSize(10);
                $pdf->SetXY(1, $linea1);
                $pdf->Write(0, "MARCA");
                $pdf->SetXY(30, $linea1);
                $pdf->Write(0, "MODELO");
                $pdf->SetXY(65, $linea1);
                $pdf->Write(0, "PRODUCTO");
                $pdf->SetXY(145, $linea1);
                $pdf->Write(0, "ANCHO");
                $pdf->SetXY(165, $linea1);
                $pdf->Write(0, "ALTO");
                $pdf->SetXY(180, $linea1);
                $pdf->Write(0, "DIAMETRO");
                $pdf->SetXY(210, $linea1);
                $pdf->Write(0, "SALDO NUEVO");
                $pdf->SetXY(240, $linea1);
                $pdf->Write(0, "SALDO VIEJO");
                $pdf->SetXY(268, $linea1);
                $pdf->Write(0, "DIFERENCIA");
                $pdf->Line(0,$linea1+2,290,$linea1+2);
            }
            $pdf->SetXY(1, $linea2);
            //$pdf->Write(0, $i);
            //$pdf->SetXY(7, $linea2);
            $pdf->Write(0, $row['mar_descripcion']);
            $pdf->SetXY(30, $linea2);
            $pdf->Write(0, $row['mod_descripcion']);
            $pdf->SetXY(65, $linea2);
            $pdf->Write(0, $row['pro_id'].'-'.$row['pro_descripcion']);
            $pdf->SetXY(145, $linea2);
            $pdf->Write(0, $row['pro_med_ancho']);
            $pdf->SetXY(165, $linea2);
            $pdf->Write(0, $row['pro_med_alto']);
            $pdf->SetXY(180, $linea2);
            $pdf->Write(0, $row['pro_med_diametro']);
            $pdf->SetXY(210, $linea2);
            $pro_cant = new productos();
            $pdf->Cell(20,0,$pro_cant->getCantidadProducto($row['pro_id'], $row['suc_id']),0,0,"R");
            $pdf->SetXY(240, $linea2);
            $pdf->Cell(20,0,$row['saldo_viejo'],0,0,"R");
            $pdf->SetXY(268, $linea2);
            $pdf->Cell(20,0,$pro_cant->getCantidadProducto($row['pro_id'], $row['suc_id'])
                    -$row['saldo_viejo'],0,0,"R");
            $linea2 = $linea2 + 5;
        }
        $pdf->Output("comp_saldo.pdf","I");
        $pdf->Close();
?>