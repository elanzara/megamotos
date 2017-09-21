<?php 
include_once 'class/session.php';
include_once 'class/conex.php';
include_once 'class/clientes.php';


if (isset($_GET["cli_id"])){
    $cli_id = $_GET["cli_id"];
} else {
    $cli_id = "";
}
if (isset($_GET["cli_nombre"])){
    $cli_nombre = $_GET["cli_nombre"];
} else {
    $cli_nombre = "";
}
if (isset($_GET["cli_apellido"])){
    $cli_apellido = $_GET["cli_apellido"];
} else {
    $cli_apellido = "";
}
if (isset($_GET["cli_razon_social"])){
    $cli_razon_social = $_GET["cli_razon_social"];
} else {
    $cli_razon_social = "";
}
if (isset($_GET["cli_tipo_documento"])){
    $cli_tipo_documento = $_GET["cli_tipo_documento"];
} else {
    $cli_tipo_documento = "";
}
if (isset($_GET["cli_numero_documento"])){
    $cli_numero_documento = $_GET["cli_numero_documento"];
} else {
    $cli_numero_documento = "";
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>MEGAMOTOS - Admin</title>
<link rel="icon" href="images/favicon.ico" type="image/x-icon">
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
  <h1>Buscar Clientes </h1>
  <!--Start Tabla  -->
   <table class="form">
    <tr>
    <td>
    <?php
    //Instancio el objeto
    $link=Conectarse();
    $cli = new clientes();
    $clientes = $cli->getclientesSQLCFiltro($cli_id, $cli_nombre, $cli_apellido, $cli_razon_social, $cli_tipo_documento, $cli_numero_documento);
    //Paginacion: 
    //Limito la busqueda
    $TAMANO_PAGINA = 10;
    $_pagi_sql = $clientes;
    //cantidad de resultados por página (opcional, por defecto 20)
    $_pagi_cuantos = 10;
    //cantidad de páginas amostrar en la barra de navegación (default = todas)
    $_pagi_nav_num_enlaces = 10;
    //$_pagi_nav_estilo = "navegador";
    //Incluimos el script de paginación. Éste ya ejecuta la consulta automáticamente
    include("class/paginator.inc.php");
    echo "<h3>Listado de clientes ".$_pagi_info."</h3>";
    //Incluimos la barra de navegación
    echo"<p>".$_pagi_navegacion."</p>";

    echo '<a href="alta_clientes.php"><img src="images/add.png" alt="Agregar" align="absmiddle" /> Agregar Cliente</a><br><br>';
    
    print '<table class="form">'
          .'<tr class="rowGris">'
          .'<td class="formTitle"><b>NOMBRE</b></td>'
          .'<td class="formTitle"><b>APELLIDO</b></td>'
          .'<td width="100px" class="formTitle"><b>RAZON SOCIAL</b></td>'
          .'<td class="formTitle"><b>E-MAIL</b></td>'
          .'<td class="formTitle"><b>T.DOCUMENTO</b></td>'
          .'<td class="formTitle"><b>NUMERO</b></td>'
          .'<td class="formTitle"><b>C.U.I.T</b></td>'
          .'<td width="90px" class="formTitle" ></td>'
          .'<td width="90px" class="formTitle" ></td>'
          .'</tr>';

    while ($row=mysql_fetch_Array($_pagi_result)) 
    {
     print '<tr class="rowBlanco">'
          .'<td class="formFields">'.$row['cli_nombre'] .'</td>'
	       .'<td class="formFields">'.$row['cli_apellido'] .'</td>'
          .'<td class="formFields">'.$row['cli_razon_social'] .'</td>'
          .'<td class="formFields">'.$row['cli_email'] .'</td>'
          .'<td class="formFields">'.$row['cli_tipo_documento'] .'</td>'
          .'<td class="formFields">'.$row['cli_numero_documento'] .'</td>'
          .'<td class="formFields">'.$row['cli_cuit'] .'</td>'
	      .'<td class="formField"><img src="images/search.png" alt="Seleccionar" align="absmiddle" /><a href="alta_orden_trabajo.php?cli_id='.$row['cli_id'].'">Seleccionar</a></td>'
          .'<td class="formField">';
     print '</td></tr>';
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
</body>
</html>