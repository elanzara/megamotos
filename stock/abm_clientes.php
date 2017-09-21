<?php 
include_once 'class/session.php';
include_once 'class/conex.php';
include_once 'class/clientes.php';

if (isset($_GET['br'])) {
        //Instancio el objeto
        $cli_id = $_GET['br'];
        $cli=new clientes($cli_id);
        $cli->set_CLI_ESTADO(1);
        $resultado=$cli->baja_CLI();
        if ($resultado>0){
                $mensaje="El cliente fue dado de baja correctamente";
        } else {
                $mensaje="El cliente no pudo ser dada de baja";
        }
}
if (isset($_GET['hb'])) {
        //Instancio el objeto cliente
        $cli=new clientes($_GET['hb']);
        $cli->set_CLI_ESTADO(0);
        $resultado=$cli->habilita_cli();
        if ($resultado>0){
                $mensaje="El cliente fue habilitado correctamente";
        } else {
                $mensaje="El cliente no pudo ser habilitado";
        }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>MEGAMTOS - Admin</title>
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
  <h1>Administración de Clientes </h1>
  <!--Start Tabla  -->
   <table class="form">
    <tr>
    <td>
    <?php
    //Instancio el objeto
    $link=Conectarse();
    $cli = new clientes();
    $clientes = $cli->getclientesSQLTexto($_GET['texto']);
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
    ?>
    <form action='abm_clientes.php' method='GET' enctype='multipart/form-data'>
    <table align="center"  border="0">
      <tr>
        <td>Texto para buscar:</td>
        <td><input size="100" type="text" name="texto" id="texto" class="campos" /></td>
        <td colspan="1" align="right"><input type="submit" value="Buscar" />&nbsp;</td>
      </tr>
    </table>
    </form>
    <?php
    print '<table class="form">'
          .'<tr class="rowGris">'
          .'<td class="formTitle"><b>APELLIDO</b></td>'
          .'<td class="formTitle"><b>NOMBRE</b></td>'
          .'<td class="formTitle"><b>RAZON SOCIAL</b></td>'
          .'<td width="90px" class="formTitle"><b>CUIT</b></td>'
          .'<td width="50px" class="formTitle"><b>T.DOC.</b></td>'
          .'<td width="70px" class="formTitle"><b>NRO.DOC.</b></td>'
	  .'<td width="60px" class="formTitle" ></td>'
          .'<td width="70px" class="formTitle"></td>'
          .'<td width="100px" class="formTitle"></td>';
     if ($row['cli_estado'] == '2') {
          print '<td width="30px" class="formTitle"></td>';
     }
          print '</tr>';

    while ($row=mysql_fetch_Array($_pagi_result)) 
    {
     print '<tr class="rowBlanco">'
	  .'<td class="formFields">'.$row['cli_apellido'] .'</td>'
          .'<td class="formFields">'.$row['cli_nombre'] .'</td>'
          .'<td class="formFields">'.$row['cli_razon_social'] .'</td>'
          .'<td class="formFields">'.$row['cli_cuit'] .'</td>'
          .'<td class="formFields">'.$row['cli_tipo_documento'] .'</td>'
          .'<td class="formFields">'.$row['cli_numero_documento'] .'</td>'
	  .'<td class="formField"><img src="images/delete.png" alt="Borrar" align="absmiddle" />
              <a href="abm_clientes.php?br='.$row['cli_id'].'">Borrar</a></td>'
	  .'<td class="formField"><img src="images/edit.png" alt="Modificar" align="absmiddle" />
              <a href="modifica_clientes.php?md='.$row['cli_id'].'">Modificar</a></td>'
	  //.'<td class="formField"><img src="images/edit.png" alt="Alta Vehiculos" align="absmiddle" /><a href="alta_vehiculos.php?cli_id='.$row['cli_id'].'">Alta Vehiculos</a></td>'
	  .'<td class="formField"><img src="images/edit.png" alt="Ver Vehiculos" align="absmiddle" />
              <a href="abm_vehiculos.php?cli_id='.$row['cli_id'].'">Ver Vehiculos</a></td>';
     if ($row['cli_estado'] == '2') {
         print '<td class="formField"><img src="images/edit.png" alt="Habilitar" align="absmiddle" />'
              .'<a href="abm_clientes.php?hb='.$row['cli_id'].'">Habilitar</a></td>';
     }
     print '</tr>';
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