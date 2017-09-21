<?php 
include_once 'class/session.php';
include_once 'class/pagos.php'; // incluye las clases
include_once 'class/bancos.php'; // incluye las clases
include_once 'class/clientes.php'; // incluye las clases
include_once 'class/proveedores.php'; // incluye las clases
include_once 'class/conex.php';
include_once 'class/cheques.php';
include_once 'class/fechas.php';


//Filtro:
session_start();
if (isset($_GET["limpiar"])){
    if ($_GET["limpiar"]=="S"){
        include_once 'class/fechas.php';
        $fechaNormal = new fechas();
        $_SESSION["search_fecha"]=date('d/m/Y', mktime(0, 0, 0, date('m')-1,date('d'),date('Y')));
        $_SESSION["search_hasta"]=date('d/m/Y', mktime(0, 0, 0, date('m'),date('d'),date('Y')));		
    }
}

if ($_SERVER["REQUEST_METHOD"]=="GET") {   
    $search_fecha = $_SESSION["search_fecha"];
    $search_hasta = $_SESSION["search_hasta"];
}
/*
if (isset($_POST["fecha"])){
    $search_fecha = $_POST["fecha"];
    $_SESSION["search_fecha"] = $search_fecha;
}
if (isset($_POST["hasta"])){
    $search_hasta = $_POST["hasta"];
    $_SESSION["search_hasta"] = $search_hasta;
}
*/
if (isset($_GET["fecha"])){
    $search_fecha = $_GET["fecha"];
    $_SESSION["search_fecha"] = $search_fecha;
}
if (isset($_GET["hasta"])){
    $search_hasta = $_GET["hasta"];
    $_SESSION["search_hasta"] = $search_hasta;
}

if (isset($_GET['tipo_pagos'])) {
    $tpg_id = $_GET["tipo_pagos"];
}
if (isset($_GET['bancos'])) {
    $bc_id = $_GET['bancos'];
	
}
if (isset($_GET['br'])) {
        //Instancio el objeto
        $ch_id = $_GET['br'];
        $ch=new cheques($pro_id);
        $ch->set_CH_ESTADO(1);
        $resultado=$ch->baja_CH();
        //echo 'resu:'.$resultado.' ch_id:'.$ch_id.' p:'.$p;
        if ($resultado>0){
                $mensaje="El cheque fue dado de baja correctamente";
        } else {
                $mensaje="El cheque no pudo ser dada de baja";
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
  <h1>Administración de Cheques </h1>
  <!--Start Tabla  -->
   <table class="form">
    <tr>
    <td>
    <?php
    //Instancio el objeto
    $link=Conectarse();
    $ch = new cheques();		    		
    $cheques = $ch->getchequesSQL($tpg_id,$bc_id,$_GET['texto'],$_SESSION["search_fecha"],$_SESSION["search_hasta"]);
    
    //Paginacion: 
    //Limito la busqueda
    $TAMANO_PAGINA = 10;
    $_pagi_sql = $cheques;
    //cantidad de resultados por página (opcional, por defecto 20)
    $_pagi_cuantos = 10;
    //cantidad de páginas amostrar en la barra de navegación (default = todas)
    $_pagi_nav_num_enlaces = 10;
    //$_pagi_nav_estilo = "navegador";
    //Incluimos el script de paginación. Éste ya ejecuta la consulta automáticamente
    include("class/paginator.inc.php");
    echo "<h3>Listado de Cheques ".$_pagi_info."</h3>";
    //Incluimos la barra de navegación
    echo"<p>".$_pagi_navegacion."</p>";

    echo '<a href="alta_cheques.php"><img src="images/add.png" alt="Agregar" align="absmiddle" /> Agregar Cheques</a><br><br>';

 ?>
    <form action='abm_cheques.php' method='GET' enctype='multipart/form-data'>
    <table align="center"  border="0">
      <tr>
            <td>Tipo de Pago:</td>
            <td>
                <?php
                    include_once 'class/pagos.php';
                    $tpg = new pagos();
                    $res = $tpg->getTpgnuloCombo();
                    print $res;
                ?>
            </td>			
            <td>  Bancos:</td>
            <td>
                <?php
                    include_once 'class/bancos.php';
                    $bco = new bancos();
                    $res = $bco->getbancosNuloCombo();
                    print $res;       
                ?>
            </td>
      </tr>
	  <tr>
	  <td>Desde:</td>
            <td><input type="text" id="fecha" name="fecha" value="<?php echo $_SESSION["search_fecha"];?>" /></td>
            <td>Hasta:</td>
            <td><input type="text" id="hasta" name="hasta" value="<?php echo $_SESSION["search_hasta"];?>" /></td>
	  <td>Texto para buscar:</td>
            <td><input size="30" type="text" name="texto" id="texto" class="campos" /></td>
			<td colspan="1" align="right"><input type="submit" value="Buscar" />&nbsp;</td>
	  </tr>
    </table>
    </form>
<?php
    print '<table class="form">'
          .'<tr class="rowGris">';
    
    print '<td  class="formTitle" width="125px" ><b>T.Pago</b></td>'
              .'<td  class="formTitle" width="15%" ><b>Banco</b></td>'
              .'<td class="formTitle" width="100px"><b>Fecha</b></td>'
              .'<td class="formTitle"><b>Numero</b></td>'
              .'<td width="30%" class="formTitle"><b>Cliente</b></td>'
              .'<td width="100px" class="formTitle"><b>Importe</b></td>'
          .'</tr>';

    while ($row=mysql_fetch_Array($_pagi_result))
    {
     print '<tr class="rowBlanco">';
     print '<td class="formFields">'.$row['tpg_descripcion'] .'</td>'
              .'<td class="formFields">'.$row['bc_descripcion'] .'</td>'
              .'<td class="formFields">'.$row['ch_fch_ch'] .'</td>'
              .'<td class="formFields">'.$row['ch_numero'] .'</td>'
              .'<td class="formFields">'.$row['cli_razon_social'] .'</td>'
              .'<td class="formFields">'.$row['ch_importe'] .'</td>';
     
    print '<td class="formField"><img src="images/delete.png" alt="Borrar" align="absmiddle" /> <a href="abm_cheques.php?br='.$row['ch_id'].'">Borrar</a></td>'
    .'<td class="formField"><img src="images/edit.png" alt="Modificar" align="absmiddle" /><a href="modifica_cheques.php?md='.$row['ch_id'].'">Modificar</a></td>'
    .'</tr>';
    }
    print '</table>';
    ?>
    </td>
    </tr>
    <tr>
    <td class="mensaje">
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