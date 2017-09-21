<?php
include_once 'class/session.php';
include_once 'class/productos.php';
include_once 'class/marcas.php';
include_once 'class/modelos.php';
include_once 'class/tipo_rango.php';
include_once 'class/conex.php';
$mensaje = "";


$pro_id = (isset($_GET['pro_id'])) ? (int) $_GET['pro_id'] : 0;
$tip_id = 0;
if ($pro_id>0){
    $pro = new productos($pro_id);
    $tip_id = $pro->get_tip_id();
} else {
    $mensaje = "No hay producto a mostrar.";
}
?>
<html>
    <head>
        <title>Datos del prducto</title>
    </head>
    <body>
        <table width="100%" style="height: 100%;" border="1" bgcolor="gray">
            <tr>
                <td bgcolor="gray"><b>CÓDIGO</b></td>
                <td bgcolor="white">
                <?php echo $pro->get_pro_id();?>
                </td>
            </tr>
            <tr>
                <td bgcolor="gray"><b>DESCRIPCIÓN</b></td>
                <td bgcolor="white">
                <?php echo $pro->get_pro_descripcion();?>
                </td>
            </tr>
            <?php
            if ($tip_id==4) {
            ?>    
                <tr>
                    <td bgcolor="gray"><b>ANCHO</b></td>
                    <td bgcolor="white">
                    <?php echo $pro->get_pro_med_ancho();?>
                    </td>
                </tr>
                <tr>
                    <td bgcolor="gray"><b>LATERAL</b></td>
                    <td bgcolor="white">
                    <?php echo $pro->get_pro_med_alto();?>
                    </td>
                </tr>
                <tr>
                    <td bgcolor="gray"><b>RODADO</b></td>
                    <td bgcolor="white">
                    <?php echo $pro->get_pro_med_diametro();?>
                    </td>
                </tr>
                <tr>
                    <td bgcolor="gray"><b>ESTADO</b></td>
                    <td bgcolor="white">
                    <?php $estado = $pro->get_pro_nueva();if ($estado==1){echo "NUEVO";} else {echo "USADO";}?>
                    </td>
                </tr>
                <tr>
                    <td bgcolor="gray"><b>MARCA</b></td>
                    <td bgcolor="white">
                    <?php $mar = new marcas($pro->get_mar_id());
                           echo $mar->get_mar_descripcion(); 
                     ?>
                    </td>
                </tr>
                <tr>
                    <td bgcolor="gray"><b>MODELO</b></td>
                    <td bgcolor="white">
                    <?php $mod = new modelos($pro->get_mod_id());
                           echo $mod->get_mod_descripcion(); 
                     ?>
                    </td>
                </tr>
                <tr>
                    <td bgcolor="gray"><b>RANGO</b></td>
                    <td bgcolor="white">
                    <?php $tpr = new tipo_rango($pro->get_tr_id());
                           echo $tpr->get_tr_descripcion(); 
                     ?>
                    </td>
                </tr>
            <?php    
            } elseif ($tip_id==3) {?>
                <tr>
                    <td bgcolor="gray"><b>ESTADO</b></td>
                    <td bgcolor="white">
                    <?php if ($pro->get_pro_nueva==1){echo "NUEVO";} ELSE {echo "USADO";}?>
                    </td>
                </tr>
                <tr>
                    <td bgcolor="gray"><b>TERMINACIONES</b></td>
                    <td bgcolor="white">
                    <?php echo $pro->get_pro_terminaciones();?>
                    </td>
                </tr>
                <tr>
                    <td bgcolor="gray"><b>RODADO</b></td>
                    <td bgcolor="white">
                    <?php echo $pro->get_pro_med_diametro();?>
                    </td>
                </tr>
                <tr>
                    <td bgcolor="gray"><b>ANCHO</b></td>
                    <td bgcolor="white">
                    <?php echo $pro->get_pro_med_ancho();?>
                    </td>
                </tr>
                <tr>
                    <td bgcolor="gray"><b>DISTRIBUCIÓN</b></td>
                    <td bgcolor="white">
                    <?php echo $pro->get_pro_distribucion();?>
                    </td>
                </tr>
                <tr>
                    <td bgcolor="gray"><b>MARCA</b></td>
                    <td bgcolor="white">
                    <?php $mar = new marcas($pro->get_mar_id());
                           echo $mar->get_mar_descripcion(); 
                     ?>
                    </td>
                </tr>
                <tr>
                    <td bgcolor="gray"><b>MODELO</b></td>
                    <td bgcolor="white">
                    <?php $mod = new modelos($pro->get_mod_id());
                           echo $mod->get_mod_descripcion(); 
                     ?>
                    </td>
                </tr>
                <tr>
                    <td bgcolor="gray"><b>AÑO</b></td>
                    <td bgcolor="white">
                    <?php echo $pro->get_pro_anio();?>
                    </td>
                </tr>
            <?php
            } elseif ($tip_id==9 || $tip_id==2) {?>
                <tr>
                    <td bgcolor="gray"><b>MATERIAL</b></td>
                    <td bgcolor="white">
                    <?php echo $pro->get_pro_material();?>
                    </td>
                </tr>
                <tr>
                    <td bgcolor="gray"><b>RODADO</b></td>
                    <td bgcolor="white">
                    <?php echo $pro->get_pro_med_diametro();?>
                    </td>
                </tr>
                <tr>
                    <td bgcolor="gray"><b>ANCHO</b></td>
                    <td bgcolor="white">
                    <?php echo $pro->get_pro_med_ancho();?>
                    </td>
                </tr>
                <tr>
                    <td bgcolor="gray"><b>DISTRIBUCIÓN</b></td>
                    <td bgcolor="white">
                    <?php echo $pro->get_pro_distribucion();?>
                    </td>
                </tr>
                <tr>
                    <td bgcolor="gray"><b>ESTADO</b></td>
                    <td bgcolor="white">
                    <?php if ($pro->get_pro_nueva()==1){echo "NUEVO";} ELSE {echo "USADO";}?>
                    </td>
                </tr>
                <tr>
                    <td bgcolor="gray"><b>MARCA</b></td>
                    <td bgcolor="white">
                    <?php $mar = new marcas($pro->get_mar_id());
                           echo $mar->get_mar_descripcion(); 
                     ?>
                    </td>
                </tr>
                <tr>
                    <td bgcolor="gray"><b>MODELO</b></td>
                    <td bgcolor="white">
                    <?php $mod = new modelos($pro->get_mod_id());
                           echo $mod->get_mod_descripcion(); 
                     ?>
                    </td>
                </tr>
            <?php
            } else {?>
                <tr>
                    <td bgcolor="gray"><b>MARCA</b></td>
                    <td bgcolor="white">
                    <?php $mar = new marcas($pro->get_mar_id());
                           echo $mar->get_mar_descripcion(); 
                     ?>
                    </td>
                </tr>
                <tr>
                    <td bgcolor="gray"><b>MODELO</b></td>
                    <td bgcolor="white">
                    <?php $mod = new modelos($pro->get_mod_id());
                           echo $mod->get_mod_descripcion(); 
                     ?>
                    </td>
                </tr>
            <?php
            } 
            ?>
            <tr>
                <td colspan="2" align="center">
                <input type="button" class='boton' value="Volver" onclick="cerrarPU();"/> 
                </td>
            </tr>
        </table>
<script type="text/javascript">
function cerrarPU()
{
	opener.location='abm_movimientos_stock.php';
	window.close();
}
</script>

    </body>
</html>
