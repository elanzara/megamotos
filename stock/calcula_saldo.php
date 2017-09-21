<?php 
include_once 'class/session.php';
include_once 'class/conex.php';
include_once 'class/fechas.php';
include_once 'class/sucursales.php';
include_once 'class/productos.php';
include_once 'class/stock_mensual.php';

$mensaje='';
if (isset($_GET['fecha'])) {
        //Calculo saldo
        $fechaNormal = new fechas();
        $resultado=CalculoSaldo($fechaNormal->cambiaf_a_mysql($_GET['fecha']));
        //echo $resultado;
        if ($resultado==1){
                $mensaje.="El proceso fue ejecutado correctamente.</br>";
        } elseif ($resultado==2) {
                $mensaje.="Existen saldos con fecha igual o posterior a la ingresada como parámetro.</br>";
        } else {
                $mensaje.="El proceso no pudo ser ejecutado para todos los registros.</br>";
        }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>MEGALLANTAS - Admin</title>
<link rel="shortcut icon" href="../imagenes/tu-logo-mitad2.jpg"></link>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-15" />
</head>
<body>
<div id="page"> 
 <!--Start HEADER -->
 <?php require_once("header.php") ?>
 <!-- End HEADER -->
  <!--Start CENTRAL -->
 <div id="central">
 <h1>Cálculo de saldos</h1>
 <h2>Fecha: <?php echo($_GET['fecha']); ?></h2></br></br>
 <!--Start Tabla  -->
 <table class="form">
  <tr>
  <td>
    <?php
//Dicha función recibe por parametro una fecha y recorre mediante dos loops la tabla de productos y la tabla de
//sucursales y va cargando el saldo en la tabla stock_mensual con los movimientos a la fecha recibida por parametro.
function CalculoSaldo($fecha='') {
  $link=Conectarse();
  $cantidad_inicial = 0;
  $cantidad_stock = 0;
  //Recupero ultima fecha de proceso saldo
  $sqlh="select max(s.stm_fecha) fecha
        from stock_mensual s";
  $consultah= mysql_query($sqlh, $link);
  if ($consultah){
        while ($rowh = mysql_fetch_assoc($consultah)) {
               $ult_fecha = $rowh['fecha'];
        }
  }//echo 'ult_fecha:'.$ult_fecha.'-ultc:'.str_replace('-','',$ult_fecha).' fecha:'.$fecha.'</br>';
  $fechaProceso = date_format(date_create($fecha), 'Y-m-d');
  //echo 'fechaProceso:'.$fechaProceso.'</br>';
  if($fecha > str_replace('-','',$ult_fecha)){
    //Recupero sucursales
    $suc = new sucursales();
    $sqls = $suc->getsucursalesSQL();
    $consultas = mysql_query($sqls, $link);
    while ($rows = mysql_fetch_assoc($consultas)) {//echo 'suc:'.$rows['suc_id'].'</br>';
        //Recupero productos
        $pro = new productos();
        $consultap=$pro->getproductos();
        if ($consultap){
            while ($rowp = mysql_fetch_Array($consultap)) {//echo 'pro:'.$rowp['pro_id'].'</br>';
            ////if($rowp['pro_id']==4 and $rows['suc_id']==3){
                //Recupero saldo inicial de ultima fecha
                $sqlf="select ifnull(s.stm_cantidad,0) cantidad
                        from stock_mensual s
                        where s.pro_id = ".$rowp['pro_id'].
                        " and s.suc_id = ".$rows['suc_id'].
                        " and s.stm_fecha = (select max(s1.stm_fecha)
				from stock_mensual s1
				where s1.pro_id=s.pro_id
				and s1.suc_id=s.suc_id
	                        and s1.stm_fecha <= '".$ult_fecha."')";
                $consultaf= mysql_query($sqlf, $link);
                if ($consultaf){
                    while ($rowf = mysql_fetch_assoc($consultaf)) {
                        if ($rowf['cantidad'] == ""){
                            $cantidad_inicial = 0;}
                        else {
                            $cantidad_inicial = $rowf['cantidad'];
                        }
                    }
                }//echo 'can_ini:'.$cantidad_inicial.'</br>';
                //Recupero movimientos stock
                $sqlm="select ifnull(sum(cast(m.cantidad as signed)*(case m.tim_id when 1 then 1 else (-1) end)),0) cantidad
                    from movimientos_stock m
                    where m.estado=0
                    and m.pro_id = ".$rowp['pro_id'].
                    " and m.suc_id = ".$rows['suc_id'].
                    " and m.fecha > '".$ult_fecha."'
                      and m.fecha <= '".$fechaProceso."'";
                $consultam= mysql_query($sqlm, $link);
                if ($consultam){
                    while ($rowm = mysql_fetch_assoc($consultam)) {
                        if ($rowm['cantidad'] == ""){
                            $cantidad_stock = 0;}
                        else {
                            $cantidad_stock = $rowm['cantidad'];
                        }//echo 'cant_stock:'.$cantidad_stock.'-fpro:'.$fechaProceso.'</br>';
                    }
                }//echo 'cant_stock:'.$cantidad_stock.'-sum:'.$cantidad_inicial+$cantidad_stock.'</br>';

                $stm = new stock_mensual();
                $stm->set_suc_id($rows['suc_id']);
                $stm->set_pro_id($rowp['pro_id']);
                $stm->set_stm_fecha($fecha);
                $stm->set_stm_cantidad($cantidad_inicial+$cantidad_stock);
                $result=$stm->insert_stm();
                if ($result>0){
                    $mensaje= 'Saldo insertado para sucursal:'.$rows['suc_id'].' y producto:'.$rowp['pro_id'].'.</br>';
                } else {
                    return 0;
                }
            ////}////
            }//$consultap
        }
    }//$consultas
    return 1;
  }else{
    return 2;
  }
}//CalculoSaldo
     ?>
  </td>
  </tr>
  <tr>
  <td  class="mensaje">
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
</body>
</html>