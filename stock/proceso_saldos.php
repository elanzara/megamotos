<?php
include_once 'class/session.php';
include_once 'class/conex.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //$mensaje="";
        $link=Conectarse();
        //Fecha ayer
        $fecha_ayer=date('Y-m-d', mktime(0, 0, 0, date('m'),date('d')-1,date('Y')));//date('Y-m-d');
        //Verifico si hay saldos fecha ayer
        $fecha = '';
        $sqlh="select max(s.stm_fecha) fecha
               from stock_mensual s
               where s.stm_fecha = '".$fecha_ayer."'";
        $consultah= mysql_query($sqlh, $link);
        if ($consultah){
                while ($rowh = mysql_fetch_assoc($consultah)) {
                       $fecha = $rowh['fecha'];
                }
        }
        if($fecha==''){
            $ok= 1;
        }else{
            $sqls="delete from stock_mensual 
                   where stm_fecha = '".$fecha_ayer."'";
            $result= mysql_query($sqls, $link);
            if ($result>0){
                $ok= 1;
            }else {
                $ok= 0;}
        }
        if ($ok== 1){
            $fecha_ayer=date('d/m/Y', mktime(0, 0, 0, date('m'),date('d')-1,date('Y')));//date('Y-m-d', mktime(0, 0, 0, date('m'),date('d')-1,date('Y')));//date('Y-m-d');
            //Calculo saldo
            header("Location:calcula_saldo.php?fecha=".$fecha_ayer);
        }
}//POST
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
   <!--Start FORM -->
   <form ACTION="proceso_saldos.php" METHOD="POST" enctype="multipart/form-data">
    <table align="center"  border="0">
      <tr>
        <td style="padding-top:50px; padding-left:300px;"><input type="submit" value="Ejecutar Proceso" />&nbsp;</td>
      </tr>
    </table>
      <?php
//	 if (isset($_POST["mensaje"])) {
//        	if ($_POST["mensaje"]!=""){
//        		$mensaje=$_POST["mensaje"];
//			echo "<br><br><span class='Estilo3'><B>$mensaje</span>";
//	 }}
      ?>
   </form>
   <!--End FORM -->
 </div> 
 <!--End CENTRAL -->
 <br clear="all" />
</div>
</body>
</html>