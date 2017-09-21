<?php 
include_once 'class/session.php';
include_once 'class/usuarios.php'; // incluye las clases
include_once 'class/conex.php';
$usu = new usuarios();

if (isset($_GET['br'])) {
        //Instancio el objeto
        $usu_id = $_GET['br'];
        $usu=new usuarios($usu_id);
        $usu->set_usu_ESTADO(1);
        $resultado=$usu->baja_usu();
        //echo $resultado;
        if ($resultado>0){
                $mensaje="El usuario fue dado de baja correctamente";
        } else {
                $mensaje="El usuario no pudo ser dado de baja";
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
 <h1>Administración de usuarios </h1>
 <!--Start Tabla  -->
 <table class="form">
  <tr>
  <td>
    <?php
    //Instancio el objeto
    $link=Conectarse();
    $usu = new usuarios();
    $usuarios = $usu->getusuariosSQL();
    //Paginacion:
    //Limito la busqueda
    $TAMANO_PAGINA = 10;
    $_pagi_sql = $usuarios;
    //cantidad de resultados por página (opcional, por defecto 20)
    $_pagi_cuantos = 10;
    //cantidad de páginas amostrar en la barra de navegación (default = todas)
    $_pagi_nav_num_enlaces = 10;
    //Incluimos el script de paginación. Éste ya ejecuta la consulta automáticamente
    //$_pagi_nav_estilo = "navegador";
    include("class/paginator.inc.php");
    echo "<h3>Listado de usuarios ".$_pagi_info."</h3>";
    //Incluimos la barra de navegación
    echo"<p>".$_pagi_navegacion."</p>";
    echo '<a href="alta_usuarios.php"><img src="images/add.png" alt="Agregar" align="absmiddle" /> Agregar usuario</a><br><br>';
    print '<table class="form">'
	.'<tr class="rowGris">'
        .'<td class="formTitle" width="250px"><b>DESCRIPCION</b></td>'
        .'<td class="formTitle" width="250px"><b>SUCURSAL</b></td>'
        .'<td class="formTitle"><b>MAIL</b></td>'
        .'<td class="formTitle" width="70px"> </td>'
        .'<td class="formTitle" width="80px"></td>'
        .'<td class="formTitle" width="120px"></td></tr>';
    while ($row=mysql_fetch_Array($_pagi_result)) 
    {
     print '<tr class="rowBlanco">'
	.'<td class="formFields">'.$row['usu_descripcion'].'</td>'
	.'<td class="formFields">'.$row['suc_descripcion'].'</td>'
    .'<td class="formFields">'.$row['usu_mail'].'</td>'
	.'<td class="formFields"><img src="images/delete.png" alt="Borrar" align="absmiddle" /><a href="abm_usuarios.php?br='.$row['usu_id'].'">  Borrar</a></td>'	// lo correcto seria enviarlos por post con un submit por ejem.
    .'<td class="formFields"><img src="images/edit.png" alt="Modificar" align="absmiddle" /><a href="modifica_usuarios.php?md='.$row['usu_id'].'"> Modificar</a></td>'
    .'<td class="formFields"><img src="images/edit.png" alt="Modificar" align="absmiddle" /><a href="abm_sucursales_usuarios.php?usu_id='.$row['usu_id'].'">Sucursales Adic.</a></td>'
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