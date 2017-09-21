<?php
include("lib_carrito.php");
include_once 'productos.php';
include_once 'conex.php';
$pro_id = $_GET["pro_id"];
$pro_descripcion = $_GET["pro_descripcion"];
$pro_cantidad = $_GET["pro_cantidad"];
$suc_id = $_GET["suc_id"];
$cli_id = $_GET["cli_id"];
$veh_id = $_GET["veh_id"];
$tip_id = $_GET["tip_id"];
$pro_id = $_GET["pro_id"];
$observaciones = $_GET["observaciones"];
$precio = $_GET["precio"]; 
$pro_observaciones = $_GET["pro_observaciones"];
$pro_descuento = (isset($_GET['pro_descuento'])) ? (double) $_GET['pro_descuento'] : 0;
$esModificacion = (isset($_GET['esModificacion'])) ? $_GET['esModificacion'] : 'NO';
$realizo = (isset($_GET['realizo'])) ? $_GET['realizo'] : '';
$pmo_id = (isset($_GET['pmo_id'])) ? (int) $_GET['pmo_id'] : 0;
$chk_veh = (isset($_GET['chk_veh'])) ? (int) $_GET['chk_veh'] : 0;
$fecha = $_GET["fecha"];
/*
PASOS A SEGUIR:
1) OBTENER PRECIO
2) OBTENER DESCUENTO
3) CALCULAR IMPORTE
4) CALCULAR IVA
5) VOLVER A LA PAGINA DE ALTA_ORDEN_TRABAJO
*/
//$pro_precio = 20;
//CALCULABA LA INVERSA DEL IVA
//$precio = round($precio * 0.826446281,2);
if ($esModificacion == 'NO'){
    if ($pro_cantidad<=0 or $pro_cantidad=='') {
        //"La cantidad debe ser mayor a cero.</br>";
        header('Location: ../alta_orden_trabajo.php?error=1&suc_id='.$suc_id.'&cli_id='.$cli_id.'&veh_id='.$veh_id
                .'&tip_id='.$tip_id.'&pro_id='.$pro_id.'&pro_id_seleccion='.$pro_id.'&observaciones='.$observaciones
                .'&pmo_id='.$pmo_id.'&chk_veh='.$chk_veh.'&cantidad='.$pro_cantidad.'&precio='.$precio
                .'&descuento='.$pro_descuento.'&pro_observaciones='.$pro_observaciones);
    }else{
        $pro = new productos($pro_id);
        $controla = $pro->get_pro_controla_stock();
        if ($controla == 'S'){
            ////$cant_prod=$pro->getCantidadProducto($pro_id,$suc_id,$fecha);
            $cant_prod=$pro->PermiteCarga($pro_id,$suc_id,$fecha,$pro_cantidad);
//echo("cant:".$cant_prod);
            /////if ($pro_cantidad>$cant_prod) {
            //echo('resu:'.$pro->PermiteCarga($pro_id,$suc_id,$fecha,$pro_cantidad));
            if (substr($cant_prod,0,1)=='N') {
                //"La cantidad ingresada excede el stock del producto (".$cant_prod.").</br>";
                header('Location: ../alta_orden_trabajo.php?error=2&stock='.substr($cant_prod,1).'&suc_id='.$suc_id.'&cli_id='.$cli_id
                        .'&veh_id='.$veh_id.'&tip_id='.$tip_id.'&pro_id='.$pro_id.'&pro_id_seleccion='.$pro_id
                        .'&observaciones='.$observaciones.'&pmo_id='.$pmo_id.'&realizo='.$realizo.'&chk_veh='.$chk_veh
                        .'&cantidad='.$pro_cantidad.'&precio='.$precio.'&descuento='.$pro_descuento
                        .'&pro_observaciones='.$pro_observaciones);
            }else{
                if($_SESSION["ocarrito"]->existe_producto($pro_id)=="N"){
                    $_SESSION["ocarrito"]->introduce_producto($pro_id, $pro_descripcion, $pro_cantidad,$precio,$pro_descuento,$pro_observaciones);/*$pro_precio*/
                    header( 'Location: ../alta_orden_trabajo.php?suc_id='.$suc_id.'&cli_id='.$cli_id.'&veh_id='.$veh_id.'&tip_id=0'
                            .'&pro_id='.$pro_id.'&observaciones='.$observaciones.'&pmo_id='.$pmo_id.'&realizo='.$realizo.'&chk_veh='.$chk_veh) ;
                } else {
                  $suma_cant=$pro_cantidad+$_SESSION["ocarrito"]->devuelvo_cantidad($pro_id);
                  if ($suma_cant>substr($cant_prod,1)) {
                    //"La cantidad ingresada excede el stock del producto (".$cant_prod.").</br>";
                    header('Location: ../alta_orden_trabajo.php?error=2&stock='.substr($cant_prod,1).'&suc_id='.$suc_id.'&cli_id='.$cli_id
                            .'&veh_id='.$veh_id.'&tip_id='.$tip_id.'&pro_id='.$pro_id.'&pro_id_seleccion='.$pro_id
                            .'&observaciones='.$observaciones.'&pmo_id='.$pmo_id.'&realizo='.$realizo.'&chk_veh='.$chk_veh
                            .'&cantidad='.$pro_cantidad.'&precio='.$precio.'&descuento='.$pro_descuento
                            .'&pro_observaciones='.$pro_observaciones);
                  }else{
                    $_SESSION["ocarrito"]->actualiza_cantidad2($pro_id,$pro_cantidad);
                    header( 'Location: ../alta_orden_trabajo.php?suc_id='.$suc_id.'&cli_id='.$cli_id.'&veh_id='.$veh_id.'&tip_id=0'
                            .'&pro_id='.$pro_id.'&observaciones='.$observaciones.'&pmo_id='.$pmo_id.'&realizo='.$realizo.'&chk_veh='.$chk_veh);
                  }
                }
            }
        } else {//No controla stock
            if($_SESSION["ocarrito"]->existe_producto($pro_id)=="N"){
                $_SESSION["ocarrito"]->introduce_producto($pro_id, $pro_descripcion, $pro_cantidad,$precio,$pro_descuento,$pro_observaciones);
                header( 'Location: ../alta_orden_trabajo.php?suc_id='.$suc_id.'&cli_id='.$cli_id.'&veh_id='.$veh_id.'&tip_id='.$tip_id
                        .'&pro_id='.$pro_id.'&observaciones='.$observaciones.'&pmo_id='.$pmo_id.'&realizo='.$realizo.'&chk_veh='.$chk_veh) ;
            } else {
                $_SESSION["ocarrito"]->actualiza_cantidad2($pro_id,$pro_cantidad);
                header( 'Location: ../alta_orden_trabajo.php?suc_id='.$suc_id.'&cli_id='.$cli_id.'&veh_id='.$veh_id.'&tip_id=0'
                        .'&pro_id='.$pro_id.'&observaciones='.$observaciones.'&pmo_id='.$pmo_id.'&realizo='.$realizo.'&chk_veh='.$chk_veh);
            }
        }
    }
} else {//Es una modificacion
    if ($pro_cantidad<=0 or $pro_cantidad=='') {
        //"La cantidad debe ser mayor a cero.</br>";
        header('Location: ../modifica_orden_trabajo.php?error=1&suc_id='.$suc_id.'&cli_id='.$cli_id.'&veh_id='.$veh_id
                .'&tip_id='.$tip_id.'&pro_id='.$pro_id.'&pro_id_seleccion='.$pro_id.'&observaciones='.$observaciones
                .'&pmo_id='.$pmo_id.'&chk_veh='.$chk_veh.'&cantidad='.$pro_cantidad.'&precio='.$precio
                .'&descuento='.$pro_descuento.'&pro_observaciones='.$pro_observaciones);
    }else{
        $pro = new productos($pro_id);
        $controla = $pro->get_pro_controla_stock();
        if ($controla == 'S'){
            //$cant_prod=$pro->getCantidadProducto($pro_id,$suc_id,$fecha);
            //if ($pro_cantidad>$cant_prod) {
            $cant_prod=$pro->PermiteCarga($pro_id,$suc_id,$fecha,$pro_cantidad);
            if (substr($cant_prod,0,1)=='N') {
                //"La cantidad ingresada excede el stock del producto (".$cant_prod.").</br>";
                header('Location: ../modifica_orden_trabajo.php?error=2&stock='.substr($cant_prod,1).'&suc_id='.$suc_id.'&cli_id='.$cli_id
                        .'&veh_id='.$veh_id.'&tip_id='.$tip_id.'&pro_id='.$pro_id.'&pro_id_seleccion='.$pro_id
                        .'&observaciones='.$observaciones.'&pmo_id='.$pmo_id.'&realizo='.$realizo.'&chk_veh='.$chk_veh
                        .'&cantidad='.$pro_cantidad.'&precio='.$precio.'&descuento='.$pro_descuento
                        .'&pro_observaciones='.$pro_observaciones);
            }else{
                if($_SESSION["ocarrito"]->existe_producto($pro_id)=="N"){
                    $_SESSION["ocarrito"]->introduce_producto($pro_id, $pro_descripcion, $pro_cantidad,$precio,$pro_descuento,$pro_observaciones);/*$pro_precio*/
                    header( 'Location: ../modifica_orden_trabajo.php?suc_id='.$suc_id.'&cli_id='.$cli_id.'&veh_id='.$veh_id.'&tip_id='.$tip_id
                            .'&pro_id='.$pro_id.'&observaciones='.$observaciones.'&pmo_id='.$pmo_id.'&realizo='.$realizo.'&chk_veh='.$chk_veh) ;
                } else {
                  //$suma_cant=$pro_cantidad+$_SESSION["ocarrito"]->devuelvo_cantidad($pro_id);
                  $suma_cant=$_SESSION["ocarrito"]->devuelvo_cantidad($pro_id);
                  if ($suma_cant>substr($cant_prod,1)) {
                    //"La cantidad ingresada excede el stock del producto (".$cant_prod.").</br>";
                    header('Location: ../modifica_orden_trabajo.php?error=2&stock='.substr($cant_prod,1).'&suc_id='.$suc_id.'&cli_id='.$cli_id
                            .'&veh_id='.$veh_id.'&tip_id='.$tip_id.'&pro_id='.$pro_id.'&pro_id_seleccion='.$pro_id
                            .'&observaciones='.$observaciones.'&pmo_id='.$pmo_id.'&realizo='.$realizo.'&chk_veh='.$chk_veh
                            .'&cantidad='.$pro_cantidad.'&precio='.$precio.'&descuento='.$pro_descuento
                            .'&pro_observaciones='.$pro_observaciones);
                  }else{
                    $_SESSION["ocarrito"]->actualiza_cantidad2($pro_id,$pro_cantidad);
                    header( 'Location: ../modifica_orden_trabajo.php?suc_id='.$suc_id.'&cli_id='.$cli_id.'&veh_id='.$veh_id.'&tip_id='.$tip_id
                            .'&pro_id='.$pro_id.'&observaciones='.$observaciones.'&pmo_id='.$pmo_id.'&realizo='.$realizo.'&chk_veh='.$chk_veh);
                  }
                }
            }
        }else{//No controla stock
          if($_SESSION["ocarrito"]->existe_producto($pro_id)=="N"){
             $_SESSION["ocarrito"]->introduce_producto($pro_id, $pro_descripcion, $pro_cantidad,$precio,$pro_descuento,$pro_observaciones);
             header( 'Location: ../modifica_orden_trabajo.php?suc_id='.$suc_id.'&cli_id='.$cli_id.'&veh_id='.$veh_id.'&tip_id='.$tip_id
                        .'&pro_id='.$pro_id.'&observaciones='.$observaciones.'&pmo_id='.$pmo_id.'&realizo='.$realizo.'&chk_veh='.$chk_veh);
          } else {
             $_SESSION["ocarrito"]->actualiza_cantidad2($pro_id,$pro_cantidad);
             header( 'Location: ../modifica_orden_trabajo.php?suc_id='.$suc_id.'&cli_id='.$cli_id.'&veh_id='.$veh_id.'&tip_id='.$tip_id
                     .'&pro_id='.$pro_id.'&observaciones='.$observaciones.'&pmo_id='.$pmo_id.'&realizo='.$realizo.'&chk_veh='.$chk_veh);
          }
        }
    }
}// ($esModificacion == 'NO')
?>