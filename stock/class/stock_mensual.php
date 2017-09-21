<?php
class stock_mensual {

var $stm_id;
var $suc_id;
var $pro_id;
var $stm_fecha;
var $stm_cantidad;
var $usu_id;


function stock_mensual($stm_id=0) {
if ($stm_id!=0) {
$link=Conectarse();
$consulta= mysql_query(' select * from stock_mensual where stm_id = '.$stm_id,$link);
while($row= mysql_fetch_assoc($consulta)) {
    $this->stm_id=$row['stm_id'];
    $this->suc_id=$row['suc_id'];
    $this->pro_id=$row['pro_id'];
    $this->stm_fecha=$row['stm_fecha'];
    $this->stm_cantidad=$row['stm_cantidad'];
    $this->usu_id=$row['usu_id'];
}
}
}
function insert_stm() {
    $link=Conectarse();
    $sql="insert into stock_mensual (
        stm_id
        , suc_id
        , pro_id
        , stm_fecha
        , stm_cantidad
        , usu_id
        ) values (
        '$this->stm_id'
        , '$this->suc_id'
        , '$this->pro_id'
        , '$this->stm_fecha'
        , '$this->stm_cantidad'
        , '".$_SESSION["usu_id"]."'
    )";
    $result=mysql_query($sql,$link);
if ($result>0){
return 1;
} else {
return 0;
}
//    $ultimo_id = mysql_insert_id($link);
//    if ($ultimo_id>0){
//        $sql1="INSERT INTO hstock_mensual
//            (tipo, stm_id, suc_id, pro_id, stm_fecha, stm_cantidad, usu_id)
//            VALUES
//            ('I', $ultimo_id, '$this->suc_id', '$this->pro_id', '$this->stm_fecha', '$this->stm_cantidad', '".$_SESSION["usu_id"]."')";
//        $result1=mysql_query($sql1,$link);
//        if ($result1>0){
//            return $ultimo_id;
//        }else {
//            return 0;
//        }
//    } else {
//        return 0;
//    }
}
function update_stm() {
    $link=Conectarse();
//    $sql="INSERT INTO hstock_mensual
//         (tipo, stm_id, suc_id, pro_id, stm_fecha, stm_cantidad, usu_id)
//         SELECT
//            'U', tim_id, suc_id, pro_id, stm_fecha, stm_cantidad, '".$_SESSION["usu_id"]."'
//         FROM stock_mensual
//         WHERE stm_id= '$this->stm_id'";
//    $result=mysql_query($sql,$link);
//    if ($result>0){
        $sql1="update stock_mensual set
            stm_id = '$this->stm_id'
            , suc_id = '$this->suc_id'
            , pro_id = '$this->pro_id'
            , stm_fecha = '$this->stm_fecha'
            , stm_cantidad = '$this->stm_cantidad'
            , usu_id = '".$_SESSION["usu_id"]."'
        where stm_id = '$this->stm_id'";
    $result1=mysql_query($sql1,$link);
    if ($result1>0){
            return 1;
        }else {
            return 0;}
//    } else {
//        return 0;
//    }
}
function baja_stm(){
    $link=Conectarse();
//    $sql="INSERT INTO hstock_mensual
//         (tipo, stm_id, suc_id, pro_id, stm_fecha, stm_cantidad, usu_id)
//         SELECT
//            'B', stm_id, suc_id, pro_id, stm_fecha, stm_cantidad, '".$_SESSION["usu_id"]."'
//         FROM stock_mensual
//         WHERE stm_id= '$this->stm_id'";
//    $result=mysql_query($sql,$link);
//    if ($result>0){
        $sql1="update stock_mensual set stm_estado = '1', usu_id = '".$_SESSION["usu_id"].
                "' where stm_id = '$this->stm_id'";
        $result1=mysql_query($sql1,$link);
        if ($result1>0){
                return 1;
            }else {
                return 0;}
//    } else {
//        return 0;
//    }
}
function getstock_mensual()
{
$link=Conectarse();
$sql="select * from stock_mensual where stm_estado='0'";
$result=mysql_query($sql,$link);
return $result;
}
function getstock_mensualDes()
{
$link=Conectarse();
$sql="select * from stock_mensual where stm_estado='1'";
$result=mysql_query($sql,$link);
return $result;
}
function get_stm_id()
{ return $this->stm_id;}
function set_stm_id($val)
{ $this->stm_id=$val;}
function get_suc_id()
{ return $this->suc_id;}
function set_suc_id($val)
{ $this->suc_id=$val;}
function get_pro_id()
{ return $this->pro_id;}
function set_pro_id($val)
{ $this->pro_id=$val;}
function get_stm_fecha()
{ return $this->stm_fecha;}
function set_stm_fecha($val)
{ $this->stm_fecha=$val;}
function get_stm_cantidad()
{ return $this->stm_cantidad;}
function set_stm_cantidad($val)
{ $this->stm_cantidad=$val;}
function get_usu_id()
{ return $this->usu_id;}
function set_usu_id($val)
{ $this->usu_id=$val;}
}
?>