<?php
require_once('class/fpdf/fpdf.php');
require_once('class/fpdf/fpdi.php');
require_once('class/conex.php');
include_once 'class/fechas.php';
include_once 'class/reportes.php';

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
        $pdf->SetXY(100, 38);
        $pdf->Write(0, "PRODUCTOS VENDIDOS ");			
        $pdf->Line(0,42,290,42);	
		$pdf->Write(0," DESDE ");
		$pdf->Write(0,$_GET["desde"]);	
		$pdf->Write(0," HASTA ");
		$pdf->Write(0,$_GET["hasta"]);	

        /*DETALLE*/
        $linea1 = 45;
        $pdf->SetFontSize(10);
        $pdf->SetXY(1, $linea1);       
        $pdf->SetXY(25, $linea1);
        $pdf->Write(0, "MARCA");
        $pdf->SetXY(60, $linea1);
        $pdf->Write(0, "MODELO");
        $pdf->SetXY(100, $linea1);
        $pdf->Write(0, "PRODUCTO");
        $pdf->SetXY(175, $linea1);
        $pdf->Write(0, "ANCHO");
        $pdf->SetXY(200, $linea1);
        $pdf->Write(0, "ALTO");
        $pdf->SetXY(220, $linea1);
        $pdf->Write(0, "DIAMETRO");
        $pdf->SetXY(245, $linea1);
        $pdf->Write(0, "SUCURSAL");
        $pdf->SetXY(268, $linea1);
        $pdf->Write(0, "CANTIDAD");
        $pdf->Line(0,$linea1+2,290,$linea1+2);
//echo'sd:'.$_SESSION["search_desde"].'-sh:'.$_SESSION["search_hasta"];
        $rep = new reportes();
        $i = 0;
        $cant = 0;
        $total_cant = 0;
        $linea2 = 55;
        $fechaNormal = new fechas();//echo'mar:'.$_GET["mar_id"];
//echo'd:'.$fechaNormal->cambiaf_a_mysql($_POST["desde"]).'-h:'.$fechaNormal->cambiaf_a_mysql($_POST["hasta"]);
        $detalle = $rep->get_rep_productos_vendidos(
                                $_GET["tip_id"]
                                ,$_GET["mar_id"]
                                ,$_GET["suc_id"]
                                ,$fechaNormal->cambiaf_a_mysql($_GET["desde"])
                                ,$fechaNormal->cambiaf_a_mysql($_GET["hasta"]));
        while($row= mysql_fetch_assoc($detalle)) {
            $cant = $cant + 1;
            $total_cant = $total_cant + $row['cantidad'];
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
  //              $pdf->Write(0, "FECHA");
                $pdf->SetXY(25, $linea1);
                $pdf->Write(0, "MARCA");
                $pdf->SetXY(60, $linea1);
                $pdf->Write(0, "MODELO");
                $pdf->SetXY(100, $linea1);
                $pdf->Write(0, "PRODUCTO");
                $pdf->SetXY(175, $linea1);
                $pdf->Write(0, "ANCHO");
                $pdf->SetXY(200, $linea1);
                $pdf->Write(0, "ALTO");
                $pdf->SetXY(220, $linea1);
                $pdf->Write(0, "DIAMETRO");
                $pdf->SetXY(245, $linea1);
                $pdf->Write(0, "SUCURSAL");
                $pdf->SetXY(268, $linea1);
                $pdf->Write(0, "CANTIDAD");
                $pdf->Line(0,$linea1+2,290,$linea1+2);
            }
            $pdf->SetXY(1, $linea2);
            //$pdf->Write(0, $i);
            //$pdf->SetXY(7, $linea2);
         //   $pdf->Write(0, $fechaNormal->cambiaf_a_normal($row['fecha']));
            $pdf->SetXY(25, $linea2);
            $pdf->Write(0, $row['mar_descripcion']);
            $pdf->SetXY(60, $linea2);
            $pdf->Write(0, $row['mod_descripcion']);
            $pdf->SetXY(100, $linea2);
            $pdf->Write(0, $row['pro_id'].'-'.$row['pro_descripcion']);
            $pdf->SetXY(175, $linea2);
            $pdf->Write(0, $row['pro_med_ancho']);
            $pdf->SetXY(200, $linea2);
            $pdf->Write(0, $row['pro_med_alto']);
            $pdf->SetXY(220, $linea2);
            $pdf->Write(0, $row['pro_med_diametro']);
            $pdf->SetXY(245, $linea2);
            $pdf->Write(0, $row['suc_descripcion']);
            $pdf->SetXY(268, $linea2);
            $pdf->Cell(20,0,$row['cantidad'],0,0,"R");
            $linea2 = $linea2 + 5;
        }
        $pdf->Line(268,$linea2,290,$linea2);
        $pdf->SetXY(1, $linea2+2);
        $pdf->Write(0, "TOTAL:");
        $pdf->SetXY(268, $linea2+2);
        $pdf->Cell(20,0,$total_cant,0,0,"R");
        $pdf->Output("prd_vend.pdf","I");
        $pdf->Close();
?>