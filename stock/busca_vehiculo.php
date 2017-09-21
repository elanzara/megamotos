<?php 
include_once 'class/session.php';
include_once 'class/modelos.php'; // incluye las clases
include_once 'class/marcas.php'; // incluye las clases
include_once 'class/clientes.php'; // incluye las clases
include_once 'class/conex.php';
include_once 'class/vehiculos.php';

if (isset($_GET["cli_id"])){
    $cli_id = $_GET["cli_id"];
} else {
    $cli_id = "";
}
if (isset($_GET["veh_id"])){
    $veh_id = $_GET["veh_id"];
} else {
    $veh_id = "";
}
if (isset($_GET["mar_descripcion"])){
    $mar_descripcion = $_GET["mar_descripcion"];
} else {
    $mar_descripcion = "";
}
if (isset($_GET["mod_descripcion"])){
    $mod_descripcion = $_GET["mod_descripcion"];
} else {
    $mod_descripcion = "";
}
if (isset($_GET["veh_patente"])){
    $veh_patente = $_GET["veh_patente"];
} else {
    $veh_patente = "";
}
if (isset($_GET["veh_km"])){
    $veh_km = $_GET["veh_km"];
} else {
    $veh_km = "";
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
  <h1>Buscar Vehiculos </h1>
  <!--Start Tabla  -->
   <table class="form">
    <tr>
    <td>
    <?php
    //Instancio el objeto
    $link=Conectarse();
    $veh = new vehiculos();
    $vehiculos = $veh->getvehiculosSQLCFiltro($cli_id,$veh_id, $mar_descripcion, $mod_descripcion, $veh_patente, $veh_km);
    //Paginacion: 
    //Limito la busqueda
    $TAMANO_PAGINA = 10;
    $_pagi_sql = $vehiculos;
    //cantidad de resultados por página (opcional, por defecto 20)
    $_pagi_cuantos = 10;
    //cantidad de páginas amostrar en la barra de navegación (default = todas)
    $_pagi_nav_num_enlaces = 10;
    //$_pagi_nav_estilo = "navegador";
    //Incluimos el script de paginación. Éste ya ejecuta la consulta automáticamente
    include("class/paginator.inc.php");
    echo "<h3>Listado de vehiculos ".$_pagi_info."</h3>";
    //Incluimos la barra de navegación
    echo"<p>".$_pagi_navegacion."</p>";

    echo '<a href="alta_vehiculos.php?cli_id='.$cli_id.'"><img src="images/add.png" alt="Agregar" align="absmiddle" /> Agregar vehiculo</a><br><br>';
    
    echo "<form id='linea' name='linea' action='abm_vehiculos.php?cli_id=$cli_id' method='GET'>";
    echo '<input type="hidden" name="cli_id" id="cli_id" value="'.$cli_id.'" />';
    $mod = new modelos();
    $html = $mod->get_select_modelos($mod_id);
    echo $html;
    echo "<input type='submit' value='Actualizar'>";
    echo "</form>";
    
    print '<table class="form">'
          .'<tr class="rowGris">'
          .'<td  class="formTitle" width="200px" ><b>CLIENTE</b></td>'
          .'<td  class="formTitle" width="200px" ><b>MARCA</b></td>'
          .'<td class="formTitle" width="200px"><b>MODELO</b></td>'
          .'<td  class="formTitle"><b>PATENTE</b></td>'
          .'<td width="100px" class="formTitle"><b>NEUMATICOS</b></td>'
          .'<td  class="formTitle"><b>KM</b></td>'
          .'<td width="90px" class="formTitle"></td>'
          .'</tr>';

    while ($row=mysql_fetch_Array($_pagi_result))
    {
     print '<tr class="rowBlanco">'
	  .'<td class="formFields">'.$row['cli_nombre'].' '.$row['cli_apellido'].'-'.$row['cli_razon_social'].'</td>'
	  .'<td class="formFields">'.$row['mar_descripcion'] .'</td>'
          .'<td class="formFields">'.$row['mod_descripcion'] .'</td>'
          .'<td class="formFields">'.$row['veh_patente'] .'</td>'
          .'<td class="formFields">'.$row['veh_neumaticos'] .'</td>'
          .'<td class="formFields">'.$row['veh_km'] .'</td>'
          .'<td class="formField"><img src="images/search.png" alt="Seleccionar" align="absmiddle" /><a href="alta_orden_trabajo.php?veh_id='.$row['veh_id'].'">Seleccionar</a></td>'
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
</body>
</html>