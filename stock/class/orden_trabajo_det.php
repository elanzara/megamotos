<?php
class orden_trabajo_det {

var $otd_id;
var $pro_id;
var $ote_id;
var $cantidad;
var $precio;
var $descuento;
var $observaciones;
var $usu_id;


function orden_trabajo_det($otd_id=0) {
if ($otd_id!=0) {
$link=Conectarse();
$consulta= mysql_query(' select * from orden_trabajo_det where otd_id = '.$otd_id,$link);
while($row= mysql_fetch_assoc($consulta)) {
$this->otd_id=$row['otd_id'];
$this->pro_id=$row['pro_id'];
$this->ote_id=$row['ote_id'];
$this->cantidad=$row['cantidad'];
$this->precio=$row['precio'];
$this->descuento=$row['descuento'];
$this->observaciones=$row['observaciones'];
$this->usu_id=$row['usu_id'];
}
}
}
function insert_otd() {
$link=Conectarse();
$sql="insert into orden_trabajo_det (
otd_id
, pro_id
, ote_id
, cantidad
, precio
, descuento
, observaciones
, usu_id
) values ( 
'$this->otd_id'
, '$this->pro_id'
, '$this->ote_id'
, '$this->cantidad'
, '$this->precio'
, '$this->descuento'
, '$this->observaciones'
, '".$_SESSION["usu_id"]."'
)";
$result=mysql_query($sql,$link);
$ins_id = mysql_insert_id();
if ($ins_id>0){
    $sql1="INSERT INTO horden_trabajo_det
        (tipo, otd_id, pro_id, ote_id, cantidad, precio, descuento, observaciones, usu_id)
        VALUES
        ('I', $ins_id, '$this->pro_id', '$this->ote_id', '$this->cantidad', '$this->precio', '$this->descuento', '$this->observaciones'
            , '".$_SESSION["usu_id"]."')";
    $result1=mysql_query($sql1,$link);
    if ($result1>0){
        return 1;
    }else {
        return 0;
    }
} else {
    return 0;
}
}
function update_otd() {
$link=Conectarse();
$sql="INSERT INTO horden_trabajo_det
     (tipo, otd_id, pro_id, ote_id, cantidad, precio, descuento, observaciones, usu_id)
     SELECT
        'U', otd_id, pro_id, ote_id, cantidad, precio, descuento, observaciones, '".$_SESSION["usu_id"]."'
     FROM orden_trabajo_det
     WHERE otd_id= '$this->otd_id'";
$result=mysql_query($sql,$link);
if ($result>0){
    $sql1="update orden_trabajo_det set
            otd_id = '$this->otd_id'
            , pro_id = '$this->pro_id'
            , ote_id = '$this->ote_id'
            , cantidad = '$this->cantidad'
            , precio = '$this->precio'
            , descuento = '$this->descuento'
            , observaciones = '$this->observaciones'
            , usu_id = '".$_SESSION["usu_id"]."'
            where otd_id = '$this->otd_id'";
    $result=mysql_query($sql,$link);
    if ($result>0){
        return 1;
    }else {
        return 0;}
} else {
    return 0;
}
}
function baja_otd(){
$link=Conectarse();
$sql="INSERT INTO horden_trabajo_det
     (tipo, otd_id, pro_id, ote_id, cantidad, precio, descuento, observaciones, usu_id)
     SELECT
        'B', otd_id, pro_id, ote_id, cantidad, precio, descuento, observaciones, '".$_SESSION["usu_id"]."'
     FROM orden_trabajo_det
     WHERE otd_id= '$this->otd_id'";
$result=mysql_query($sql,$link);
if ($result>0){
    $sql1="update orden_trabajo_det set otd_estado = '1', usu_id = '".$_SESSION["usu_id"].
         "' where otd_id = '$this->otd_id'";
    $result1=mysql_query($sql1,$link);
    if ($result1>0){
        return 1;
    }else {
        return 0;}
} else {
    return 0;
}
}
function getorden_trabajo_det()
{
$link=Conectarse();
$sql="select * from orden_trabajo_det where otd_estado='0'";
$result=mysql_query($sql,$link);
return $result;
}
function getorden_trabajo_detDes()
{
$link=Conectarse();
$sql="select * from orden_trabajo_det where otd_estado='1'";
$result=mysql_query($sql,$link);
return $result;
}

function getorden_trabajo_det_X_ote_id($ote_id=0) {
    if ($ote_id!=0) {
        $link=Conectarse();
        $sql = "select d.*
                     , p.*, a.*, o.*, r.*
                from orden_trabajo_det d, productos p
                LEFT JOIN marcas a ON p.mar_id = a.mar_id
                LEFT JOIN modelos o ON p.mod_id = o.mod_id
                LEFT JOIN tipo_rango r ON p.tr_id = r.tr_id
                where d.pro_id = p.pro_id
                and d.ote_id = ".$ote_id;
        $consulta= mysql_query($sql, $link);
        return $consulta;
    }
}
function get_otd_id()
{ return $this->otd_id;}
function set_otd_id($val)
{ $this->otd_id=$val;}
function get_pro_id()
{ return $this->pro_id;}
function set_pro_id($val)
{ $this->pro_id=$val;}
function get_ote_id()
{ return $this->ote_id;}
function set_ote_id($val)
{ $this->ote_id=$val;}
function get_cantidad()
{ return $this->cantidad;}
function set_cantidad($val)
{ $this->cantidad=$val;}
function get_precio()
{ return $this->precio;}
function set_precio($val)
{ $this->precio=$val;}
function get_descuento()
{ return $this->descuento;}
function set_descuento($val)
{ $this->descuento=$val;}
function get_observaciones()
{ return $this->observaciones;}
function set_observaciones($val)
{ $this->observaciones=$val;}
function get_usu_id()
{ return $this->usu_id;}
function set_usu_id($val)
{ $this->usu_id=$val;}
}
?>