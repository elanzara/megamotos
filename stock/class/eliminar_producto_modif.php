<?php
include("lib_carrito.php");

$fecha = $_GET["fecha"];
$suc_id = $_GET["suc_id"];
$cli_id = $_GET["cli_id"];
$veh_id = $_GET["veh_id"];
$observaciones = $_GET["observaciones"];
$realizo = (isset($_GET['realizo'])) ? $_GET['realizo'] : '';
$pmo_id = (isset($_GET['pmo_id'])) ? (int) $_GET['pmo_id'] : 0;
$chk_veh = (isset($_GET['chk_veh'])) ? (int) $_GET['chk_veh'] : 0;

$_SESSION["ocarrito"]->elimina_producto($_GET["linea"]);
header( 'Location: ../modifica_orden_trabajo.php?fecha='.$fecha.'&suc_id='.$suc_id.'&cli_id='.$cli_id.'&veh_id='.$veh_id
        .'&pmo_id='.$pmo_id.'&realizo='.$realizo.'&chk_veh='.$chk_veh);
?>