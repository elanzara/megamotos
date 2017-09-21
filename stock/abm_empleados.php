<?php 
include_once 'class/session.php';
include_once 'class/conex.php';
include_once 'class/empleados.php';

if (isset($_GET['br'])) {
        //Instancio el objeto
        $emp_id = $_GET['br'];
        $emp=new empleados($emp_id);
        $emp->set_EMP_ESTADO(1);
        $resultado=$emp->baja_EMP();
        if ($resultado>0){
                $mensaje="El empleado fue dado de baja correctamente";
        } else {
                $mensaje="El empleado no pudo ser dada de baja";
        }
}
if (isset($_GET['hb'])) {
        //Instancio el objeto empleado
        $emp=new empleado($_GET['hb']);
        $emp->set_EMP_ESTADO(0);
        $resultado=$emp->habilita_emp();
        if ($resultado>0){
                $mensaje="El empleado fue habilitado correctamente";
        } else {
                $mensaje="El empleado no pudo ser habilitado";
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
  <h1>Administración de Empleados </h1>
  <!--Start Tabla  -->
   <table class="form">
    <tr>
    <td>
    <?php
    //Instancio el objeto
    $link=Conectarse();
    $emp = new empleados();
    $empleados = $emp->getempleadosSQLTexto($_GET['texto']);
    //Paginacion: 
    //Limito la busqueda
    $TAMANO_PAGINA = 10;
    $_pagi_sql = $empleados;
    //cantidad de resultados por página (opcional, por defecto 20)
    $_pagi_cuantos = 10;
    //cantidad de páginas amostrar en la barra de navegación (default = todas)
    $_pagi_nav_num_enlaces = 10;
    //$_pagi_nav_estilo = "navegador";
    //Incluimos el script de paginación. Éste ya ejecuta la consulta automáticamente
    include("class/paginator.inc.php");
    echo "<h3>Listado de Empleados ".$_pagi_info."</h3>";
    //Incluimos la barra de navegación
    echo"<p>".$_pagi_navegacion."</p>";

    echo '<a href="alta_empleados.php"><img src="images/add.png" alt="Agregar" align="absmiddle" /> Agregar Empleados</a><br><br>';
    ?>
    <form action='abm_empleados.php' method='GET' enctype='multipart/form-data'>
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
          .'<td class="formTitle"><b>LEGAJO</b></td>'
          .'<td width="90px" class="formTitle"><b>CUIL</b></td>'
          .'<td width="50px" class="formTitle"><b>T.DOC.</b></td>'
          .'<td width="70px" class="formTitle"><b>NRO.DOC.</b></td>'
	  .'<td width="60px" class="formTitle" ></td>'
          .'<td width="70px" class="formTitle"></td>'
          .'<td width="100px" class="formTitle"></td>';
     if ($row['emp_estado'] == '2') {
          print '<td width="30px" class="formTitle"></td>';
     }
          print '</tr>';

    while ($row=mysql_fetch_Array($_pagi_result)) 
    {
     print '<tr class="rowBlanco">'
	  .'<td class="formFields">'.$row['emp_apellido'] .'</td>'
          .'<td class="formFields">'.$row['emp_nombre'] .'</td>'
          .'<td class="formFields">'.$row['emp_legajo'] .'</td>'
          .'<td class="formFields">'.$row['emp_cuil'] .'</td>'
          .'<td class="formFields">'.$row['emp_tipo_documento'] .'</td>'
          .'<td class="formFields">'.$row['emp_numero_documento'] .'</td>'
	  	  .'<td class="formField"><a href="modifica_empleados.php?md='.$row['emp_id'].'">Modificar</a></td>'
	 	  .'<td class="formField"> </td>'
		   .'<td class="formField"> </td>';
     if ($row['emp_estado'] == '2') {
         print '<td class="formField"><img src="images/edit.png" alt="Habilitar" align="absmiddle" />'
              .'<a href="abm_empleados.php?hb='.$row['emp_id'].'">Habilitar</a></td>';
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