<?php
include_once 'class/session.php';
include_once 'class/orden_trabajo_enc.php';
include_once 'class/conex.php';
include_once 'class/fechas.php';
include_once 'class/lib_carrito.php';

$ote = new orden_trabajo_enc();

if (isset($_GET['br'])) {
        //Instancio el objeto
        $ote_id = $_GET['br'];
        $ote=new orden_trabajo_enc($ote_id);
        $ote->set_estado(1);
        $resultado=$ote->baja_ote();
        if ($resultado>0){
                $mensaje="La orden fue dada de baja correctamente";
        } else {
                $mensaje="La orden no pudo ser dada de baja";
        }
}
$baja =  (isset($_GET['baja'])) ? $_GET['baja'] : 'N';
$todas =  (isset($_GET['todas'])) ? $_GET['todas'] : 'N';
if ($_GET["limpiar_form"]=='S'){
    $_SESSION["ocarrito"] = new carrito();
    $_SESSION["fecha"]= date("d")."/".date("m")."/".date("Y");
    $_SESSION["observaciones"] = "";
    $_SESSION["numero"]= "";
    $_SESSION["cli_id"] = "0";
    $_SESSION["veh_id"] = "";
    $_SESSION["suc_id"] = "";
    $_SESSION["realizo"] = "";
}
if (isset($_POST["sucursales"])){
    $search_sucursal = $_POST["sucursales"];
    $_SESSION["search_sucursal"] = $search_sucursal;
}
if (isset($_GET["sucursales"])){
    $search_sucursal = $_GET["sucursales"];
    $_SESSION["search_sucursal"] = $search_sucursal;
}
if (isset($_POST["nro"])){
    $search_nro = $_POST["nro"];
    $_SESSION["search_nro"] = $search_nro;
}
if (isset($_GET["nro"])){
    $search_nro = $_GET["nro"];
    $_SESSION["search_nro"] = $search_nro;
}
if (isset($_POST["desde"])){
    $fechasql = new fechas();
    $f = $_POST['desde'];
    $fechaconv =$fechasql->cambiaf_a_mysql($f);
    $search_desde = $fechaconv;
    $_SESSION["search_desde"] = $search_desde;
}
if (isset($_GET["desde"])){
    $fechasql = new fechas();
    $f = $_GET['desde'];
    $fechaconv =$fechasql->cambiaf_a_mysql($f);
    $search_desde = $fechaconv;
    $_SESSION["search_desde"] = $search_desde;
}
if (isset($_POST["hasta"])){
    $fechasql = new fechas();
    $f = $_POST['hasta'];
    $fechaconv =$fechasql->cambiaf_a_mysql($f);
    $search_hasta = $fechaconv;
    $_SESSION["search_hasta"] = $search_hasta;
}
if (isset($_GET["hasta"])){
    $fechasql = new fechas();
    $f = $_GET['hasta'];
    $fechaconv =$fechasql->cambiaf_a_mysql($f);
    $search_hasta = $fechaconv;
    $_SESSION["search_hasta"] = $search_hasta;
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
  <h1>Administración de Ordenes de Trabajo </h1>
  <!--Start Tabla  -->
  <table border="0" class="form">
   <tr>
   <td>
    <?php
    //Instancio el objeto 
    $link=Conectarse();
    $ote = new orden_trabajo_enc();
    $orden_trabajo_enc = $ote->getorden_trabajo_encSQL2($baja, $search_sucursal, $todas, $search_nro
                                                    , $search_desde, $search_hasta);
    //Paginacion:
    //Limito la busqueda
    $TAMANO_PAGINA = 10;
    $_pagi_sql = $orden_trabajo_enc;
    //cantidad de resultados por página (opcional, por defecto 20)
    $_pagi_cuantos = 10;
    //cantidad de páginas amostrar en la barra de navegación (default = todas)
    $_pagi_nav_num_enlaces = 10;
    //Incluimos el script de paginación. Éste ya ejecuta la consulta automáticamente
    //$_pagi_nav_estilo = "navegador";
    include("class/paginator.inc.php");
    echo "<h3>Listado de modelos ".$_pagi_info."</h3>";
    //Incluimos la barra de navegación
    echo"<p>".$_pagi_navegacion."</p>";
    echo '<a href="alta_orden_trabajo.php?limpiar_form=S">
            <img src="images/add.png" alt="Agregar" align="absmiddle" /> Agregar orden de trabajo</a><br><br>';

    echo '<form action="abm_orden_trabajo.php" method="post">';
    echo '<table align="center"  border="0">';
    echo '<tr>';
    echo '<td>Sucursal:</td>';
    echo '<td>';
    include_once 'class/sucursales.php';
    $suc = new sucursales();
    $html = $suc->getsucursalesnuloCombo($search_sucursal);
    echo $html;
    echo '</td>';
    ?>
    <td>Nro:</td>
    <td><input size="7" type="text" name="nro" id="nro" class="campos" /></td>
    <td>F.Desde(dd/mm/yyyy):</td>
    <td><input size="8" type="text" name="desde" id="desde" class="campos" /></td>
    <td>F.Hasta(dd/mm/yyyy):</td>
    <td><input size="8" type="text" name="hasta" id="hasta" class="campos" /></td>
    <?php
    echo '<td>';
    echo '<input type="submit" value="Buscar" />';
    echo '</td>';
    
    echo '<td>';
    if ($baja == "S" ){
        echo '<input type="checkbox" id="baja" name="baja" value="baja" checked onclick="VerCanceladas();"> Solo Canceladas</input>';
    } else {
        echo '<input type="checkbox" id="baja" name="baja" value="baja" onclick="VerCanceladas();"> Solo Canceladas</input>';
    }
    echo '</td>';
    echo '<td>';
    if ($todas == "S" ){
        echo '<input type="checkbox" id="todas" name="todas" value="todas" checked onclick="VerTodas();"> Ver todas </input>';
    } else {
        echo '<input type="checkbox" id="todas" name="todas" value="todas" onclick="VerTodas();"> Ver todas </input>';
    }
    echo '</td>';
    echo '</tr>';
    echo '</table>';
    echo '</form>';
    
    print '<table class="form">'
	 .'<tr class="rowGris">'
         .'<td class="formTitle" width="70px"><b>NUMERO</b></td>'
         .'<td class="formTitle" width="70px"><b>FECHA</b></td>'
         .'<td class="formTitle"><b>SUCURSAL</b></td>'
         .'<td class="formTitle"><b>CLIENTE</b></td>'
         .'<td class="formTitle"><b>VEHICULO</b></td>'
    	 .'<td class="formTitle"><b>ESTADO</b></td>'
         //.'<td class="formTitle" width="80px"> </td>'
         .'<td class="formTitle" width="80px"></td>'
         .'<td class="formTitle" width="70px"></td></tr>';
//         .'<td  class="formTitle" width="40px"><b>ID</b></td>'

    $fechaNormal = new fechas();
    while ($row=mysql_fetch_Array($_pagi_result)) 
    {
     $estado = "";
     $nombre = "estado".$row['ote_id'];
     switch ($row['estado']) {
            case 0:
                //$estado = "Cargado";
                $estado = '<select id="'.$nombre.'" name = "'.$nombre.'" class="formFields" onchange ="pop_up('.$row['ote_id'].',this.selectindex);">'
                            ."<option value='0' selected>Pendiente</option>"
                            ."<option value='2'>En ejecución</option>"
                            ."<option value='1'>Cancelada</option>"
                            ."</select>";
                break;
            case 1:
                //$estado = "En trabajo";
                $estado = '<select id="'.$nombre.'" name = "'.$nombre.'" class="formFields" onchange ="pop_up('.$row['ote_id'].',this.selectindex);">'
                            ."<option value='1' selected>Cancelada</option>"
//                            ."<option value='2'>En ejecución</option>"
                            ."</select>";
                break;
            case 2:
                //$estado = "En trabajo";
                $estado = '<select id="'.$nombre.'" name = "'.$nombre.'" class="formFields" onchange ="pop_up('.$row['ote_id'].',this.selectindex);">'
                            ."<option value='2' selected>En ejecución</option>"
                            ."<option value='4'>Finalizada</option>"
                            ."<option value='1'>Cancelada</option>"
                            ."</select>";
                break;
            case 3:
                //$estado = "A Facturar";
                break;
            case 4:
                //$estado = "Finalizado";
                $estado = '<select id="'.$nombre.'" name = "'.$nombre.'" class="formFields" onchange ="pop_up('.$row['ote_id'].',this.selectindex);">'
                            ."<option value='4' selected>Finalizada</option>"
                            ."</select>";
                break;
    }
     print '<tr class="rowBlanco">'
	  .'<td class="formFields">'.$row['numero'].'</td>'
          .'<td class="formFields">'.$fechaNormal->cambiaf_a_normal($row['fecha']).'</td>'
	  .'<td class="formFields">'.$row['suc_descripcion'].'</td>'
	  .'<td class="formFields">'.$row['cliente'].'</td>'
	  .'<td class="formFields">'.$row['vehiculo'].'</td>'
          //.'<td class="formFields" ><a href="#" onclick ="pop_up('.$row['ote_id'].');"  alt="Dar click para cambiar el estado." >'.$estado.'</a></td>'
          .'<td class="formFields" >'.$estado.'</td>';
	  //.'<td class="formFields"><img src="images/delete.png" alt="Borrar" align="absmiddle" /><a href="abm_orden_trabajo.php?br='.$row['ote_id'].'">  Borrar</a></td>'
           if ($row['estado']==1)/*Cancelada*/{
                print '<td class="formFields"><img src="images/edit.png" alt="Ver" align="absmiddle" />
                        <a href="modifica_orden_trabajo.php?md='.$row['ote_id'].'&modif=s"> Ver</a></td>';
                print '<td class="formFields">
                        <img src="images/print.jpg" width="16" height="16" alt="Imprimir" align="absmiddle" />
                        <a href="imprimir_ot.php?ote_id='.$row['ote_id'].'" target="_blank"> Imprimir</a></td>';
           } elseif ($row['estado']==4)/*Finalizada*/{
                print '<td class="formFields"></td>';
                print '<td class="formFields"><img src="images/edit.png" alt="Ver" align="absmiddle" />
                  <a href="modifica_orden_trabajo.php?md='.$row['ote_id'].'&modif=s"> Ver</a></td>';
           } else {
              print '<td class="formFields"><img src="images/edit.png" alt="Modificar" align="absmiddle" />
                  <a href="modifica_orden_trabajo.php?md='.$row['ote_id'].'"> Modificar</a></td>';
              print '<td class="formFields">
                  <img src="images/print.jpg" width="16" height="16" alt="Imprimir" align="absmiddle" />
                  <a href="imprimir_ot.php?ote_id='.$row['ote_id'].'" target="_blank"> Imprimir</a></td>';
            }
          print '</tr>';
        //	  .'<td class="formFields">'.$row['ote_id'].'</td>'
        //"cambia_estado.php?ote_id='.$row['ote_id'].'"
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
                    error($mensaje);
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
<script type="text/javascript" language="JavaScript">
function error(mensaje){
    Alert("Error: "+mensaje);
}
function pop_up(ote_id, valor){
    var sel = 'estado'+ote_id;
    var estado = document.getElementById(sel).value; 
    //var estado = valor;
    window.open('cambia_estado.php?ote_id='+ote_id+'&estado='+estado,'Cambia estado','scrollbars=No,status=yes,width=400,height=200,left=200,top=150 1');
}
function VerCanceladas(){
    if (document.getElementById("todas").checked == 1){
        var todas ="S";
    } else {
        var todas ="N";
    }
//    var posicion=document.getElementById("sucursales").options.selectedIndex; //posicion
//    var sucursales = document.getElementById("sucursales").options[posicion].text); //valor
    var sucursales = document.getElementById("sucursales").options[document.getElementById("sucursales").selectedIndex].value;
    var nro=document.getElementById('nro').value;
    var desde=document.getElementById('desde').value;
    var hasta=document.getElementById('hasta').value;
    
    if (document.getElementById("baja").checked == 1){
        location.href="abm_orden_trabajo.php?baja=S&todas="+todas+"&sucursales="+sucursales+"&nro="+nro
            +"&desde="+desde+"&hasta="+hasta;
    } else {
        location.href="abm_orden_trabajo.php?baja=N&todas="+todas+"&sucursales="+sucursales+"&nro="+nro
            +"&desde="+desde+"&hasta="+hasta;
    }
}
function VerTodas(){
    if (document.getElementById("baja").checked == 1){
        var baja ="S";
    } else {
        var baja ="N";
    }
//    var posicion=document.getElementById("sucursales").options.selectedIndex; //posicion
//    var sucursales = document.getElementById("sucursales").options[posicion].text); //valor
    var sucursales = document.getElementById("sucursales").options[document.getElementById("sucursales").selectedIndex].value;
    var nro=document.getElementById('nro').value;
    var desde=document.getElementById('desde').value;
    var hasta=document.getElementById('hasta').value;

    if (document.getElementById("todas").checked == 1){
        location.href="abm_orden_trabajo.php?todas=S&baja="+baja+"&sucursales="+sucursales+"&nro="+nro
            +"&desde="+desde+"&hasta="+hasta;
    } else {
        location.href="abm_orden_trabajo.php?todas=N&baja="+baja+"&sucursales="+sucursales+"&nro="+nro
            +"&desde="+desde+"&hasta="+hasta;
    }
}
</script>
</body>
</html>