<?php
include_once 'class/session.php';
include_once 'class/conex.php';
include_once 'class/productos.php';

$mensaje="";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["cerrar"])){
    header();
}
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    if (trim($_POST["pro_precio_costo"]) != ""){
        $pro_id = (isset($_POST['pro_id'])) ? (int) $_POST['pro_id'] : 0;
        $pro_precio_costo = (isset($_POST['pro_precio_costo'])) ? (double) $_POST['pro_precio_costo'] : 0;
        //$link=Conectarse();
        //$sql='update productos set pro_precio_costo = '.$pro_precio_costo.' where pro_id = '.$pro_id;
        //$result=mysql_query($sql,$link);
        /*return $sql;*/
        $pro = new productos($pro_id);
        $pro->set_pro_precio_costo($pro_precio_costo);
        $result=$pro->update_PRO();
        if ($result>0){
            $mensaje = 'El precio se modificó satisfactoriamente.';
        } else {
            $mensaje = 'El precio no pudo ser modificado.';
        }
    } else {
        $mensaje = 'Debe ingresar un precio numérico';
    }
}
if ($_SERVER["REQUEST_METHOD"] == "GET"){
    $pro_id = (isset($_GET['pro_id'])) ? (int) $_GET['pro_id'] : 0;
    $pro_descripcion = (isset($_GET['pro_descripcion'])) ? (string) $_GET['pro_descripcion'] : '';
    $pro_precio_costo = (isset($_GET['pro_precio_costo'])) ? (double) $_GET['pro_precio_costo'] : 0;
    $tipo = (isset($_GET['tipo'])) ? (string) $_GET['tipo'] : '';
}


?>
<head>
<style>
    #oculto{visibility:hidden};
</style>

</head> 
<body>
<?PHP if (trim($mensaje) == '' ) {?>
<form action="modifica_precio.php" method="post">
<table border="1" bgcolor="#A4A4A4">
    <tr><!-- id="oculto">-->
        <td bgcolor="#585858">CODIGO: </td>
        <td bgcolor="#585858"><input style="background-color:#585858;" readonly="readonly" type="text" id="pro_id" name="pro_id" value="<?PHP PRINT $pro_id;?>" /></td>
    </tr>
    <tr><!-- id="oculto">-->
        <td bgcolor="#585858">TIPO: </td>
        <td><input type="text" id="tipo" name="tipo" disabled="disabled" value="<?PHP PRINT $tipo;?>" /></td>
    </tr>
    <tr>
        <td bgcolor="#585858">PRODUCTO: </td>
        <td><?PHP PRINT $pro_descripcion;?></td>
    </tr>
    <tr>
        <td bgcolor="#585858">PRECIO: </td>
        <td><input type="text" id="pro_precio_costo" name="pro_precio_costo" value="<?PHP PRINT $pro_precio_costo;?>" /></td>
    </tr>
    <tr>
        <td colspan="2" align="center" bgcolor="#585858"><input type="submit" class='boton' value="ACEPTAR" /></td>
    </tr>
</table>
</form>
<?php } else { ?>
<form id="cerrar" name="cerrar" action="modifica_precio.php" method="post">
<table>
    <tr>
        <td colspan="2"><?php print $mensaje;?></td>
    </tr>
    <tr>
        <td colspan="2" align="center"><input type="submit" class='boton' value="VOLVER" onclick="cerrarPU();" /></td>
    </tr>
</table>    
</form>
<?php }?>
<script type="text/javascript">
function cerrarPU()
{
	opener.location='abm_precios.php';
	window.close();
}
</script>
</body>