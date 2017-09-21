<?php 
include_once 'class/session.php';
include_once 'class/roles.php'; // incluye las clases
include_once 'class/conex.php';
$rol = new roles();

if (isset($_GET['br'])) {
        //Instancio el objeto
        $rol_id = $_GET['br'];
        $rol=new roles($rol_id);
        $rol->set_rol_ESTADO(1);
        $resultado=$rol->baja_rol();
        //echo $resultado;
        if ($resultado>0){
                $mensaje="El rol fue dada de baja correctamente";
        } else {
                $mensaje="El rol no pudo ser dada de baja";
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
 <h1>Administraci�n de roles </h1>
 <!--Start Tabla  -->
 <table class="form">
  <tr>
  <td>
    <?php
    //Instancio el objeto
    $link=Conectarse();
    $rol = new roles();
    $roles = $rol->getrolesSQL();
    //Paginacion:
    //Limito la busqueda
    $TAMANO_PAGINA = 10;
    $_pagi_sql = $roles;
    //cantidad de resultados por p�gina (opcional, por defecto 20)
    $_pagi_cuantos = 10;
    //cantidad de p�ginas amostrar en la barra de navegaci�n (default = todas)
    $_pagi_nav_num_enlaces = 10;
    //Incluimos el script de paginaci�n. �ste ya ejecuta la consulta autom�ticamente
    //$_pagi_nav_estilo = "navegador";
    include("class/paginator.inc.php");
    echo "<h3>Listado de roles ".$_pagi_info."</h3>";
    //Incluimos la barra de navegaci�n
    echo"<p>".$_pagi_navegacion."</p>";
    echo '<a href="alta_roles.php"><img src="images/add.png" alt="Agregar" align="absmiddle" /> Agregar rol</a><br><br>';
    print '<table class="form">'
	 .'<tr class="rowGris">'
         .'<td  class="formTitle" width="150px"><b>DESCRIPCION</b></td>'
	 .'<td class="formTitle" width="90px"> </td>'
         .'<td class="formTitle" width="90px"></td></tr>';
    while ($row=mysql_fetch_Array($_pagi_result)) 
    {
     print '<tr class="rowBlanco">'
	  .'<td class="formFields">'.$row['rol_descripcion'].'</td>'
	  .'<td class="formFields" width="90px"><img src="images/delete.png" alt="Borrar" align="absmiddle" /><a href="abm_roles.php?br='.$row['rol_id'].'">  Borrar</a></td>'
          .'<td class="formFields" width="90px"><img src="images/edit.png" alt="Modificar" align="absmiddle" /><a href="modifica_roles.php?md='.$row['rol_id'].'"> Modificar</a></td>'
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
<!--
<script type="text/javascript" language="javascript" src="js/jquery.js"></script>
<script type="text/javascript" language="javascript" src="js/menu.js"></script>
<script type="text/javascript" src="js/funciones.js" language="javascript"></script>
-->
</body>
</html>