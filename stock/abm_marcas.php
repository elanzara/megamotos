<?php 
include_once 'class/session.php';
include_once 'class/marcas.php';
include_once 'class/conex.php';

$mar = new marcas();
$tip_id = '0';
$mar_id = '0';

if (isset($_GET['tipo_productos'])) {
    $tip_id = $_GET["tipo_productos"];
}
if (isset($_GET['marcas'])) {
    $mar_id = $_GET['marcas'];
}

if (isset($_GET['br'])) {
        //Instancio el objeto
        $mar_id = $_GET['br'];
        $mar=new marcas($mar_id);
        $mar->set_MAR_ESTADO(1);
        $resultado=$mar->baja_MAR();
        if ($resultado>0){
                $mensaje="La marca fue dada de baja correctamente";
        } else {
                $mensaje="La marca no pudo ser dada de baja";
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
</head>
<body>
<div id="page"> 
 <!--Start HEADER -->
 <?php require_once("header.php") ?>
 <!-- End HEADER -->
  <!--Start CENTRAL -->
 <div id="central">
 <h1>Administración de Marcas </h1>
 <!--Start Tabla  -->
  <table border="0" class="form">
  <tr>
  <td>
    <?php
    //Instancio el objeto
    $link=Conectarse();
//    $mar = new marcas();
//    $marcas = $mar->getmodelosSQLxTipId($tip_id,$mar_id);//getmarcasSQL($mar_id);
    include_once 'class/modelos.php'; // incluye las clases
    $mod = new modelos();
    $modelos = $mod->getmarcasSQLxTipId($tip_id,$mar_id);//getmodelosSQL(/*$tip_id,*/$mar_id);
    //Paginacion:
    //Limito la busqueda
    $TAMANO_PAGINA = 10;
    //$_pagi_sql = $marcas;
    $_pagi_sql = $modelos;
    //cantidad de resultados por página (opcional, por defecto 20)
    $_pagi_cuantos = 10;
    //cantidad de páginas amostrar en la barra de navegación (default = todas)
    $_pagi_nav_num_enlaces = 10;
    //Incluimos el script de paginación. Éste ya ejecuta la consulta automáticamente
    //$_pagi_nav_estilo = "navegador";
    include("class/paginator.inc.php");
    echo "<h3>Listado de marcas ".$_pagi_info."</h3>";
    //Incluimos la barra de navegación
    echo"<p>".$_pagi_navegacion."</p>";
    echo '<a href="alta_marcas.php"><img src="images/add.png" alt="Agregar" align="absmiddle" /> Agregar marca</a><br><br>';
//    echo "<form id='linea' name='linea' action='abm_marcas.php' method='GET'>";
//    echo "Tipo Producto:";
//    $tip = new tipo_productos();
//    $res = $tip->gettipo_productosCombo($tip_id, 'N');
//    print $res;
//    echo "<input type='submit' value='Actualizar'>";
//    echo "</form>";
 ?>
    <form action='abm_marcas.php' method='GET' enctype='multipart/form-data'>
    <table align="center"  border="0">
      <tr>
            <td>Tipo Producto:</td>
            <td>
                <?php
                    include_once 'class/tipo_productos.php';
                    $tip = new tipo_productos();
                    $res = $tip->getTipnuloCombo();
                    print $res;
                ?>
            </td>
            <td>Marca:</td>
            <td>
                <?php
                 if ($tip_id!="" and $tip_id!="0"
                 and $tip_id!="Elige" and $tip_id!="Selecciona Opción...") {
                    include_once 'class/marcas.php';
                    $mar = new marcas();
                    $res1 = $mar->getmarcasxTipIdComboNulo($tip_id);//getmarcasComboNuloTodos();
                    print $res1;
                 } else {
                    print '<select disabled="disabled" name="marcas" id="marcas">';
                    print '<option value="0">Selecciona opci&oacute;n...</option>';
                    print '</select>';
                 }
         ?>
            </td>
        <td colspan="1" align="right"><input type="submit" value="Buscar" />&nbsp;</td>
      </tr>
    </table>
    </form>
<?php
    print '<table class="form">'
	 .'<tr class="rowGris">'
         .'<td class="formTitle" width="350px"><b>MARCA</b></td>'
	 .'<td class="formTitle" width="60px"></td>'
	 .'<td class="formTitle" width="60px"></td>'
         .'<td class="formTitle" width="60px"></td></tr>';
    while ($row=mysql_fetch_Array($_pagi_result)) 
    {
     print '<tr class="rowBlanco">'
	  .'<td class="formFields">'.$row['mar_descripcion'].'</td>'
	  .'<td class="formFields"><img src="images/delete.png" alt="Borrar" align="absmiddle" /><a href="abm_marcas.php?br='.$row['mar_id'].'">Borrar</a></td>'
          .'<td class="formFields"><img src="images/edit.png" alt="Modificar" align="absmiddle" /><a href="modifica_marcas.php?md='.$row['mar_id'].'">Modificar</a></td>'
          .'<td class="formFields"><img src="images/edit.png" alt="Modificar" align="absmiddle" /><a href="abm_marcas_tipos_prod.php?mar_id='.$row['mar_id'].'">Ver Tipos Producto</a></td>'
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
<script type="text/javascript" src="select_dependientes_tip_mar.js"></script>
</body>
</html>