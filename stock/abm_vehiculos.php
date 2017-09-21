<?php 
include_once 'class/session.php';
include_once 'class/modelos.php'; // incluye las clases
include_once 'class/clientes.php'; // incluye las clases
include_once 'class/conex.php';
include_once 'class/vehiculos.php';

//$mod_id = 1;
$cli_id = $_GET["cli_id"];

if (isset($_GET['br'])) {
        //Instancio el objeto
        $veh_id = $_GET['br'];
        $veh=new vehiculos($veh_id);
        $veh->set_veh_ESTADO(1);
        $resultado=$veh->baja_veh();
        if ($resultado>0){
                $mensaje="El vehiculo fue dado de baja correctamente";
        } else {
                $mensaje="El vehiculo no pudo ser dada de baja";
        }
}
if (isset($_GET['marcas'])) {
    $mar_id = $_GET['marcas'];
}
if (isset($_GET['modelos'])) {
    $mod_id = $_GET['modelos'];
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
  <h1>Administración de vehiculos </h1>
  <!--Start Tabla  -->
   <table class="form">
    <tr>
    <td>
    <?php
    //Instancio el objeto
    $link=Conectarse();
    $veh = new vehiculos();
    $vehiculos = $veh->getvehiculosSQL($cli_id,$mar_id,$mod_id);
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
    ?>
    <table align="center"  border="0">
    <tr>
      <td>Marca:</td>
      <td>
            <?php
            include_once 'class/marcas.php';
            $mar = new marcas();
            $res1 = $mar->getmarcasxTipIdComboNulo(1);
            print $res1;
            ?>
      </td>
      <td>Modelo:</td>
      <td>
        <?php
        $mod = new modelos();
        $html = $mod->get_modelosComboxTipIdNulo(1);//get_select_modelos($mod_id);
        echo $html;
        ?>
      </td>
      <td colspan="1" align="right"><input type='submit' value='Actualizar'/></td>
    </tr>
    </table>
    <?php
        echo "</form>";

    print '<table class="form">'
          .'<tr class="rowGris">'
          .'<td class="formTitle" width="120px" ><b>CLIENTE</b></td>'
          .'<td class="formTitle" width="120px" ><b>MARCA</b></td>'
          .'<td class="formTitle" width="120px"><b>MODELO</b></td>'
          .'<td class="formTitle"><b>PATENTE</b></td>'
          .'<td class="formTitle"><b>NEUMATICOS</b></td>'
          .'<td class="formTitle"><b>LLANTAS</b></td>';
	  print '<td width="60px" class="formTitle" ></td>'
          .'<td width="80px" class="formTitle"></td>'
          .'<td width="80px" class="formTitle"></td>'
          .'</tr>';

    while ($row=mysql_fetch_Array($_pagi_result))
    {
     print '<tr class="rowBlanco">'
	  .'<td class="formFields">'.$row['cli_apellido'].' '.$row['cli_nombre'].'-'.$row['cli_razon_social'].'</td>'
	  .'<td class="formFields">'.$row['mar_descripcion'] .'</td>'
          .'<td class="formFields">'.$row['mod_descripcion'] .'</td>'
          .'<td class="formFields">'.$row['veh_patente'] .'</td>'
          .'<td class="formFields">'.$row['veh_neumaticos'] .'</td>'
          .'<td class="formFields">'.$row['veh_llantas'] .'</td>';
	  print '<td class="formField"><img src="images/delete.png" alt="Borrar" align="absmiddle" />
                <a href="abm_vehiculos.php?br='.$row['veh_id'].'">Borrar</a></td>'
	  .'<td class="formField"><img src="images/edit.png" alt="Modificar" align="absmiddle" />
              <a href="modifica_vehiculos.php?md='.$row['veh_id'].'">Modificar</a></td>'
	  .'<td class="formField"><img src="images/edit.png" alt="OT" align="absmiddle" />
              <a href="alta_orden_trabajo.php?cli_id='.$row['cli_id'].'&veh_id='.$row['veh_id'].'">Ingreso OT</a></td>'
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
<script type="text/javascript" src="select_dependientes_xTipId.js"></script>
</body>
</html>