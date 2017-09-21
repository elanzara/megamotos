<?php 
include_once 'class/session.php';
include_once 'class/distribuidores.php'; // incluye las clases
include_once 'class/conex.php';
$dis = new distribuidores();

if (isset($_GET['br'])) {
        //Instancio el objeto
        $dis_id = $_GET['br'];
        $dis=new distribuidores($dis_id);
        $dis->set_dis_ESTADO(1);
        $resultado=$dis->baja_dis();
        //echo $resultado;
        if ($resultado>0){
                $mensaje="El distribuidor fue dado de baja correctamente";
        } else {
                $mensaje="El distribuidor no pudo ser dada de baja";
        }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>MEGAMOTOS - Admin</title>
<link rel="icon" href="images/favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="../imagenes/tu-logo-mitad2.jpg"></link>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-15" />
<!--<link href="css/admin.css" rel="stylesheet" type="text/css" />-->
</head>
<body>
<div id="page"> 
 <!--Start HEADER -->
 <?php require_once("header.php") ?>
 <!-- End HEADER -->
  <!--Start CENTRAL -->
 <div id="central">
 <h1>Administración de distribuidores </h1>
 <!--Start Tabla  -->
 <table class="form">
  <tr>
  <td>
    <?php
    //Instancio el objeto
    $link=Conectarse();
    $dis = new distribuidores();
    $distribuidores = $dis->getdistribuidoresSQL();
    //Paginacion:
    //Limito la busqueda
    $TAMANO_PAGINA = 10;
    $_pagi_sql = $distribuidores;
    //cantidad de resultados por página (opcional, por defecto 20)
    $_pagi_cuantos = 10;
    //cantidad de páginas amostrar en la barra de navegación (default = todas)
    $_pagi_nav_num_enlaces = 10;
    //Incluimos el script de paginación. Éste ya ejecuta la consulta automáticamente
    //$_pagi_nav_estilo = "navegador";
    include("class/paginator.inc.php");
    echo "<h3>Listado de distribuidores ".$_pagi_info."</h3>";
    //Incluimos la barra de navegación
    echo"<p>".$_pagi_navegacion."</p>";
    echo '<a href="alta_distribuidores.php"><img src="images/add.png" alt="Agregar" align="absmiddle" /> Agregar distribuidor</a><br><br>';
    print '<table class="form">'
	 .'<tr class="rowGris">'
         .'<td  class="formTitle" width="150px"><b>DESCRIPCION</b></td>'
	 .'<td class="formTitle" width="90px"> </td>'
         .'<td class="formTitle" width="90px"></td></tr>';
    while ($row=mysql_fetch_Array($_pagi_result)) 
    {
     print '<tr class="rowBlanco">'
	  .'<td class="formFields">'.$row['dis_descripcion'].'</td>'
	  .'<td class="formFields" width="90px"> <img src="images/delete.png" alt="Borrar" align="absmiddle" /><a href="abm_distribuidores.php?br='.$row['dis_id'].'">  Borrar</a></td>'
          .'<td class="formFields" width="90px"><img src="images/edit.png" alt="Modificar" align="absmiddle" /> <a href="modifica_distribuidores.php?md='.$row['dis_id'].'"> Modificar</a></td>'
	  .'</tr>';       
    }
    print '</table>';
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