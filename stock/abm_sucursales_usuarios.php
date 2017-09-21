<?php 
include_once 'class/session.php';
include_once 'class/conex.php';
include_once 'class/sucursales_x_usuario.php';

if (isset($_GET['usu_id'])){
    $usu_id = $_GET['usu_id'];
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $sxu = new sucursales_x_usuario();
    $sxu->set_SUC_ID($_POST['sucursales']);
    $sxu->set_USU_ID($_POST['usu_id']);
    $resultado = $sxu->insert_sxu();
    if ($resultado>0){
            $mensaje="La relación se agrego correctamente";
    } else {
            $mensaje="La relación no se pudo agregar";
    }
}
if (isset($_GET['br'])) {
        //Instancio el objeto
        $sxu_id = $_GET['br'];
        $sxu=new sucursales_x_usuario($sxu_id);
        $sxu->set_SXU_ESTADO(1);
        $resultado=$sxu->baja_sxu();
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
<title>ABM Sucursales x Usuario</title>
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
  <h1>Administración Sucursales por Usuario</h1>
  <!--Start Tabla  -->
   <table class="form">
    <tr>
    <td>
    <?php
    if ($usu_id!=''){
        include_once 'class/usuarios.php';
        $usu = new usuarios();
        $usuarios = $usu->getusuarios($usu_id);
        while ($rowo=mysql_fetch_Array($usuarios))
        {echo'<h3><b>Usuario: '.$rowo['usu_descripcion'].'</b></h3>';}
    }
    //Instancio el objeto
    $link=Conectarse();
    $sxu = new sucursales_x_usuario();
    $sucursales_x_usuario = $sxu->getsucursales_x_usuarioSQL($usu_id);
    //Paginacion: 
    //Limito la busqueda
    $TAMANO_PAGINA = 10;
    $_pagi_sql = $sucursales_x_usuario;
    //cantidad de resultados por página (opcional, por defecto 20)
    $_pagi_cuantos = 10;
    //cantidad de páginas amostrar en la barra de navegación (default = todas)
    $_pagi_nav_num_enlaces = 10;
    //$_pagi_nav_estilo = "navegador";
    //Incluimos el script de paginación. Éste ya ejecuta la consulta automáticamente
    include("class/paginator.inc.php");
    echo "<h3>Listado de sucursales por usuario ".$_pagi_info."</h3>";
    //Incluimos la barra de navegación
    echo"<p>".$_pagi_navegacion."</p>";
    //echo '<a href="alta_proyectos.php"><img src="images/add.png" alt="Agregar" align="absmiddle" /> Agregar Proyecto</a><br><br>';
    
    print '<table class="form">'
          .'<tr class="rowGris">'
          .'<td width="100px" class="formTitle"><b>ID</b></td>'
          .'<td width="400px" class="formTitle"><b>USUARIO</b></td>'
          .'<td class="formTitle"><b>SUCURSAL</b></td>'
          .'<td width="60px" class="formTitle"></td>'
          .'</tr>';

    while ($row=mysql_fetch_Array($_pagi_result)) 
    {
     print '<tr class="rowBlanco">'
          .'<td class="formFields">'.$row['sxu_id'] .'</td>'
          .'<td class="formFields">'.$row['usu_descripcion'] .'</td>'
          .'<td class="formFields">'.$row['suc_descripcion'] .'</td>'
          .'<td class="formField"><img src="images/delete.png" alt="Borrar" align="absmiddle" />
              <a href="abm_sucursales_usuarios.php?br='.$row['sxu_id'].'&usu_id='.$usu_id.'">Borrar</a></td>'
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
        <form action="abm_sucursales_usuarios.php?usu_id=<?php print $usu_id;?>" method="POST" enctype='multipart/form-data'>
                <?php
                    include_once 'class/sucursales.php';
                    $suc = new sucursales();
                    $res = $suc->getsucursalesCombo();
                    print $res;
                ?>
            <input type="hidden" id="usu_id" name="usu_id" value="<?php print $usu_id;?>" />
            <input type="submit" value="Agregar" />
        </form>
    </td>
  </tr>
  <tr>
    <td colspan="2" align="center" class="formFields">
    <?php
      if($usu_id != "" and $usu_id != "0"){
    ?>
      <a href='abm_usuarios.php'>
        <input type='button' class='boton' value='Volver' onClick="window.location.href='abm_usuarios.php'" />
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