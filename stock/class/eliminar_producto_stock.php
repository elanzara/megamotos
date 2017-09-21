<?php
$sucursal = $_GET["suc_id"];
$tipo = $_GET["tipo"];
$tip_id = $_GET["tip_id"];
$suc_des_id = $_GET["suc_des_id"];
$remito = $_GET["remito"];

include("lib_carrito_stock.php");
$_SESSION["ocarrito_stock"]->elimina_producto($_GET["linea"]);
header( 'Location: ../alta_movimientos_stock.php?tipo='.$tipo.'&tip_id='.$tip_id.'&suc_id='.$sucursal.'&suc_des_id='.$suc_des_id . '&remito=' . $remito ) ;
?>