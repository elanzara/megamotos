<?php 
include_once 'class/session.php';
include_once 'class/conex.php';
include_once 'class/marcas_tipos_prod.php';

if (isset($_GET['mar_id'])){
    $mar_id = $_GET['mar_id'];
}
if (isset($_GET['mod_id'])){
    $mod_id = $_GET['mod_id'];
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $mtp = new marcas_tipos_prod();
    $mtp->set_TIP_ID($_POST['tipo_productos']);
    $mtp->set_MAR_ID($_POST['mar_id']);
    $mtp->set_MOD_ID($_POST['mod_id']);
    $resultado = $mtp->insert_mtp();
    if ($resultado>0){
            $mensaje="La relación se agrego correctamente";
    } else {
            $mensaje="La relación no se pudo agregar";
    }
}
if (isset($_GET['br'])) {
        //Instancio el objeto
        $mtp_id = $_GET['br'];
        $mtp=new marcas_tipos_prod($mtp_id);
        $mtp->set_MTP_ESTADO(1);
        $resultado=$mtp->baja_mtp();
        //echo "Resultado: " . $resultado;
        if ($resultado>0){
                $mensaje="La relación se dió de baja correctamente";
        } else {
                $mensaje="La relación no pudo ser dado de baja";
        }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ABM Tipos Producto x Marcas y Modelos</title>
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
  <h1>Administración Tipos Producto por Marcas y Modelos</h1>
  <!--Start Tabla  -->
   <table class="form">
    <tr>
    <td>
    <?php
    if ($mar_id!=''){
        include_once 'class/marcas.php';
        $mar = new marcas();
        $marcas = $mar->getmarcas($mar_id);
        while ($rowm=mysql_fetch_Array($marcas))
        {echo'<h3><b>Marca: '.$rowm['mar_descripcion'].'</b></h3>';}
    }
    if ($mod_id!=''){
        include_once 'class/modelos.php';
        $mod = new modelos();
        $modelos = $mod->getmodelos($mod_id);
        while ($rowo=mysql_fetch_Array($modelos))
        {echo'<h3><b>Modelo: '.$rowo['mod_descripcion'].'</b></h3>';}
    }
    //Instancio el objeto
    $link=Conectarse();
    $mtp = new marcas_tipos_prod();
    $marcas_tipos_prod = $mtp->getmarcas_tipos_prodSQL($mar_id,$mod_id);
    //Paginacion: 
    //Limito la busqueda
    $TAMANO_PAGINA = 10;
    $_pagi_sql = $marcas_tipos_prod;
    //cantidad de resultados por página (opcional, por defecto 20)
    $_pagi_cuantos = 10;
    //cantidad de páginas amostrar en la barra de navegación (default = todas)
    $_pagi_nav_num_enlaces = 10;
    //$_pagi_nav_estilo = "navegador";
    //Incluimos el script de paginación. Éste ya ejecuta la consulta automáticamente
    include("class/paginator.inc.php");
    echo "<h3>Listado de tipos producto por marca ".$_pagi_info."</h3>";
    //Incluimos la barra de navegación
    echo"<p>".$_pagi_navegacion."</p>";
    //echo '<a href="alta_proyectos.php"><img src="images/add.png" alt="Agregar" align="absmiddle" /> Agregar Proyecto</a><br><br>';
    
    print '<table class="form">'
          .'<tr class="rowGris">'
          .'<td width="100px" class="formTitle"><b>ID</b></td>'
          .'<td width="130px" class="formTitle"><b>MARCA</b></td>'
          .'<td width="130px" class="formTitle"><b>MODELO</b></td>'
          .'<td width="130px" class="formTitle"><b>TIPO PRODUCTO</b></td>'
          .'<td width="60px" class="formTitle"></td>'
          .'</tr>';

    while ($row=mysql_fetch_Array($_pagi_result)) 
    {
     print '<tr class="rowBlanco">'
          .'<td class="formFields">'.$row['mtp_id'] .'</td>'
          .'<td class="formFields">'.$row['mar_descripcion'] .'</td>'
          .'<td class="formFields">'.$row['mod_descripcion'] .'</td>'
          .'<td class="formFields">'.$row['tip_descripcion'] .'</td>'
	  .'<td class="formField"><img src="images/delete.png" alt="Borrar" align="absmiddle" />
              <a href="abm_marcas_tipos_prod.php?br='.$row['mtp_id'].'&mar_id='.$mar_id.'">Borrar</a></td>'
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
  <tr>
    <td>
        <form action="abm_marcas_tipos_prod.php?mar_id=<?php print $mar_id;?>&mod_id=<?php print $mod_id;?>" method="POST" enctype='multipart/form-data'>
                <?php
                    include_once 'class/tipo_productos.php';
                    $tip = new tipo_productos();
                    $res = $tip->getTipCombo();
                    print $res;
                ?>
            <input type="hidden" id="mar_id" name="mar_id" value="<?php print $mar_id;?>" />
            <input type="hidden" id="mod_id" name="mod_id" value="<?php print $mod_id;?>" />
            <input type="submit" value="Agregar" />
        </form>
    </td>
  </tr>
  <tr>
    <td colspan="2" align="center" class="formFields">
    <?php
      if($mod_id != "" and $mod_id != "0"){
    ?>
      <a href='abm_modelos.php?marcas=<?php print $mar_id;?>'>
        <input type='button' class='boton' value='Volver' onClick="window.location.href='abm_modelos.php'" />
      </a>
    <?php
      } else {
    ?>
      <a href='abm_marcas.php?marcas=<?php print $mar_id;?>'>
        <input type='button' class='boton' value='Volver' onClick="window.location.href='abm_marcas.php'" />
      </a>
    <?php
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