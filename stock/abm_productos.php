<?php 
include_once 'class/session.php';
include_once 'class/modelos.php'; // incluye las clases
include_once 'class/marcas.php'; // incluye las clases
include_once 'class/distribuidores.php'; // incluye las clases
include_once 'class/proveedores.php'; // incluye las clases
include_once 'class/tipo_productos.php'; // incluye las clases
include_once 'class/conex.php';
include_once 'class/productos.php';

//$mod_id = 1;
if (isset($_GET['tipo_productos'])) {
    $tip_id = $_GET["tipo_productos"];
}
if (isset($_GET['marcas'])) {
    $mar_id = $_GET['marcas'];
}

if (isset($_GET['br'])) {
        //Instancio el objeto
        $pro_id = $_GET['br'];
        $pro=new productos($pro_id);
        $pro->set_PRO_ESTADO(1);
        $resultado=$pro->baja_PRO();
        //echo 'resu:'.$resultado.' pro_id:'.$pro_id.' p:'.$p;
        if ($resultado>0){
                $mensaje="El producto fue dado de baja correctamente";
        } else {
                $mensaje="El producto no pudo ser dada de baja";
        }
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
  <h1>Administración de Productos </h1>
  <!--Start Tabla  -->
   <table class="form">
    <tr>
    <td>
    <?php
    //Instancio el objeto
    $link=Conectarse();
    $pro = new productos();
    $productos = $pro->getproductosSQLxTipModTexto($tip_id,$mar_id,$_GET['texto']);
    
    //Paginacion: 
    //Limito la busqueda
    $TAMANO_PAGINA = 10;
    $_pagi_sql = $productos;
    //cantidad de resultados por página (opcional, por defecto 20)
    $_pagi_cuantos = 10;
    //cantidad de páginas amostrar en la barra de navegación (default = todas)
    $_pagi_nav_num_enlaces = 10;
    //$_pagi_nav_estilo = "navegador";
    //Incluimos el script de paginación. Éste ya ejecuta la consulta automáticamente
    include("class/paginator.inc.php");
    echo "<h3>Listado de productos ".$_pagi_info."</h3>";
    //Incluimos la barra de navegación
    echo"<p>".$_pagi_navegacion."</p>";

    echo '<a href="alta_productos.php"><img src="images/add.png" alt="Agregar" align="absmiddle" /> Agregar Producto</a><br><br>';
    
//    echo "<form id='linea' name='linea' action='abm_productos.php' method='GET'>";
//    $tip = new tipo_productos();
//    $res = $tip->gettipo_productosCombo($tip_id, 'N');
//    print $res;
//    echo "<input type='submit' value='Actualizar'>";
//    echo "</form>";
 ?>
    <form action='abm_productos.php' method='GET' enctype='multipart/form-data'>
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
                    $res = $mar->getmarcasxTipIdComboNulo($tip_id);
                    print $res;
                 } else {
                    print '<select disabled="disabled" name="marcas" id="marcas">';
                    print '<option value="0">Selecciona opci&oacute;n...</option>';
                    print '</select>';
                 }
                ?>
            </td>
            <td>Texto para buscar:</td>
            <td><input size="70" type="text" name="texto" id="texto" class="campos" /></td>
            <td colspan="1" align="right"><input type="submit" value="Buscar" />&nbsp;</td>
      </tr>
    </table>
    </form>
<?php
    print '<table class="form">'
          .'<tr class="rowGris">';
    if ($tip_id==4) {//Neumaticos
        print '<td  class="formTitle" width="100px" ><b>T.PRODUCTO</b></td>'
              .'<td class="formTitle" width="100px" ><b>MARCA</b></td>'
              .'<td class="formTitle" width="100px" ><b>MODELO</b></td>'
              .'<td width="70px" class="formTitle"><b>ANCHO</b></td>'
              .'<td width="60px" class="formTitle"><b>ALTO</b></td>'
              .'<td width="70px" class="formTitle"><b>DIAMETRO</b></td>'
              .'<td class="formTitle" width="100px"><b></b>RANGO</td>'
              .'<td class="formTitle"><b>NUEVA</b></td>';
    } elseif ($tip_id==3 || $tip_id==2) {//Llantas Deportivas,Llantas Replicas
        print '<td  class="formTitle" width="100px" ><b>T.PRODUCTO</b></td>'
              .'<td class="formTitle" width="100px" ><b>MARCA</b></td>'
              .'<td class="formTitle" width="100px" ><b>MODELO</b></td>'
              .'<td width="70px" class="formTitle"><b>ANCHO</b></td>'
              .'<td width="70px" class="formTitle"><b>DIAMETRO</b></td>'
              .'<td class="formTitle"><b>DISTRIBUCION</b></td>'
              .'<td class="formTitle" width="100px"><b>RANGO</b></td>'
              .'<td class="formTitle"><b>NUEVA</b></td>'
              .'<td class="formTitle"><b>DISEÑO</b></td>'
              .'<td class="formTitle" width="100px"><b>TERM.</b></td>'
              .'<td class="formTitle" width="100px"><b>CLASIFICACION</b></td>';
    } elseif ($tip_id==9) {//Llantas Originales
        print '<td  class="formTitle" width="130px" ><b>T.PRODUCTO</b></td>'
              .'<td class="formTitle" width="130px" ><b>MARCA</b></td>'
              .'<td class="formTitle" width="130px" ><b>MODELO</b></td>'
              .'<td class="formTitle" width="70px"><b>ANCHO</b></td>'
              .'<td class="formTitle" width="70px"><b>DIAMETRO</b></td>'
              .'<td class="formTitle"><b>DISTRIBUCION</b></td>'
              .'<td class="formTitle"><b></b>RANGO</td>'
              .'<td class="formTitle"><b>DISEÑO</b></td>'
              .'<td class="formTitle" width="50px"><b>NUEVA</b></td>';
    } else {
        print '<td  class="formTitle" width="100px" ><b>T.PRODUCTO</b></td>'
              .'<td  class="formTitle" width="100px" ><b>MARCA</b></td>'
              .'<td class="formTitle" width="100px"><b>MODELO</b></td>'
              .'<td class="formTitle"><b>DESCRIPCION</b></td>'
              .'<td width="70px" class="formTitle"><b>ANCHO</b></td>'
              .'<td width="60px" class="formTitle"><b>ALTO</b></td>'
              .'<td width="70px" class="formTitle"><b>DIAMETRO</b></td>'
              .'<td class="formTitle"><b>PRECIO</b></td>';
    }
    print '<td width="60px" class="formTitle" ></td>'
    .'<td width="70px" class="formTitle"></td>'
    .'<td class="formTitle"><b>CODIGO</b></td>'
    .'</tr>';

    while ($row=mysql_fetch_Array($_pagi_result))
    {
     if ($row['pro_nueva']==1){
         $nueva='Si';
     } else {
         $nueva='No';
     }
     print '<tr class="rowBlanco">';
     if ($tip_id==4) {//Neumaticos
        print '<td class="formFields">'.$row['tip_descripcion'] .'</td>'
              .'<td class="formFields">'.$row['mar_descripcion'] .'</td>'
              .'<td class="formFields">'.$row['mod_descripcion'] .'</td>'
              .'<td class="formFields">'.$row['pro_med_ancho'] .'</td>'
              .'<td class="formFields">'.$row['pro_med_alto'] .'</td>'
              .'<td class="formFields">'.$row['pro_med_diametro'] .'</td>'
              .'<td class="formFields">'.$row['tr_descripcion'] .'</td>'
              .'<td class="formFields">'.$nueva .'</td>';
     } elseif ($tip_id==3 || $tip_id==2) {//Llantas Deportivas,Llantas Replicas
        print '<td class="formFields">'.$row['tip_descripcion'] .'</td>'
              .'<td class="formFields">'.$row['mar_descripcion'] .'</td>'
              .'<td class="formFields">'.$row['mod_descripcion'] .'</td>'
              .'<td class="formFields">'.$row['pro_med_ancho'] .'</td>'
              .'<td class="formFields">'.$row['pro_med_diametro'] .'</td>'
              .'<td class="formFields">'.$row['pro_distribucion'] .'</td>'
              .'<td class="formFields">'.$row['tr_descripcion'] .'</td>'
              .'<td class="formFields">'.$nueva .'</td>'
              .'<td class="formFields">'.$row['pro_descripcion'] .'</td>'
              .'<td class="formFields">'.$row['pro_terminacion'] .'</td>'
              .'<td class="formFields">'.$row['pro_clasificacion'] .'</td>'
              ;
     } elseif ($tip_id==9) {//Llantas Originales
        print '<td class="formFields">'.$row['tip_descripcion'] .'</td>'
              .'<td class="formFields">'.$row['mar_descripcion'] .'</td>'
              .'<td class="formFields">'.$row['mod_descripcion'] .'</td>'
              .'<td class="formFields">'.$row['pro_med_ancho'] .'</td>'
              .'<td class="formFields">'.$row['pro_med_diametro'] .'</td>'
              .'<td class="formFields">'.$row['pro_distribucion'] .'</td>'
              .'<td class="formFields">'.$row['tr_descripcion'] .'</td>'
              .'<td class="formFields">'.$row['pro_descripcion'] .'</td>'
              .'<td class="formFields">'.$nueva .'</td>';
     } else {
        print '<td class="formFields">'.$row['tip_descripcion'] .'</td>'
              .'<td class="formFields">'.$row['mar_descripcion'] .'</td>'
              .'<td class="formFields">'.$row['mod_descripcion'] .'</td>'
              .'<td class="formFields">'.$row['pro_descripcion'] .'</td>'
              .'<td class="formFields">'.$row['pro_med_ancho'] .'</td>'
              .'<td class="formFields">'.$row['pro_med_alto'] .'</td>'
              .'<td class="formFields">'.$row['pro_med_diametro'] .'</td>'
              .'<td class="formFields" style="text-align: right;">'.number_format($row['pro_precio_costo'],2,",",".") .'</td>';
    }
    print '<td class="formField"><img src="images/delete.png" alt="Borrar" align="absmiddle" /> <a href="abm_productos.php?br='.$row['pro_id'].'">Borrar</a></td>'
    .'<td class="formField"><img src="images/edit.png" alt="Modificar" align="absmiddle" /><a href="modifica_productos.php?md='.$row['pro_id'].'">Modificar</a></td>'
    .'<td class="formFields">'.$row['pro_id'] .'</td>'
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