<?php
class sucursales_x_usuario {

var $sxu_id;
var $suc_id;
var $usu_id;
var $sxu_estado;
var $usu_id_audit;


function sucursales_x_usuario($sxu_id=0) {
if ($sxu_id!=0) {
$link=Conectarse();
$consulta= mysql_query(' select * from sucursales_x_usuario where sxu_id = '.$sxu_id,$link);
while($row= mysql_fetch_assoc($consulta)) {
    $this->sxu_id=$row['sxu_id'];
    $this->suc_id=$row['suc_id'];
    $this->usu_id=$row['usu_id'];
    $this->sxu_estado=$row['sxu_estado'];
    $this->usu_id_audit=$row['usu_id_audit'];
}
}
}
function insert_sxu() {
    $link=Conectarse();
    $sql="insert into sucursales_x_usuario (
             suc_id
            , usu_id
            , usu_id_audit
        ) values (
         '$this->suc_id'
        , '$this->usu_id'
        , '".$_SESSION["usu_id"]."'
        )";
    $result=mysql_query($sql,$link);
    $ultimo_id = mysql_insert_id($link);
    if ($ultimo_id>0){
        $sql1="INSERT INTO hsucursales_x_usuario
            (tipo, sxu_id, suc_id, usu_id, sxu_estado, usu_id_audit)
            VALUES
            ('I', $ultimo_id, '$this->suc_id', '$this->usu_id', 0, '".$_SESSION["usu_id"]."')";
        $result1=mysql_query($sql1,$link);
        if ($result1>0){
            return $ultimo_id;
        }else {
            return 0;
        }
    } else {
        return 0;
    }
}
function update_sxu() {
    $link=Conectarse();
    $sql="INSERT INTO hsucursales_x_usuario
         (tipo, sxu_id, suc_id, usu_id, sxu_estado, usu_id_audit)
         SELECT
            'U', sxu_id, suc_id, usu_id, sxu_estado, '".$_SESSION["usu_id"]."'
         FROM sucursales_x_usuario
         WHERE sxu_id= '$this->sxu_id'";
    $result=mysql_query($sql,$link);
    if ($result>0){
        $sql1="update sucursales_x_usuario set
            suc_id = '$this->suc_id'
            , usu_id = '$this->usu_id'
            , usu_id_audit = '".$_SESSION["usu_id"]."'
        where sxu_id = '$this->sxu_id'";
        $result1=mysql_query($sql1,$link);
        if ($result1>0){
            return 1;
        }else {
            return 0;}
    } else {
        return 0;
    }
}
function baja_sxu(){
    $link=Conectarse();
    $sql="INSERT INTO hsucursales_x_usuario
         (tipo, sxu_id, suc_id, usu_id, sxu_estado, usu_id_audit)
         SELECT
            'B', sxu_id, suc_id, usu_id, sxu_estado, '".$_SESSION["usu_id"]."'
         FROM sucursales_x_usuario
         WHERE sxu_id= '$this->sxu_id'";
    $result=mysql_query($sql,$link);
    if ($result>0){
        $sql1="update sucursales_x_usuario set sxu_estado = '1', usu_id_audit = '".$_SESSION["usu_id"].
            "' where sxu_id = '$this->sxu_id'";
        $result1=mysql_query($sql1,$link);
        if ($result1>0){
            return 1;
        }else {
            return 0;}
    } else {
        return 0;
    }
}
function getsucursales_x_usuario()
{
$link=Conectarse();
$sql="select * from sucursales_x_usuario where sxu_estado='0'";
$result=mysql_query($sql,$link);
return $result;
}
function getsucursales_x_usuarioDes()
{
$link=Conectarse();
$sql="select * from sucursales_x_usuario where sxu_estado='1'";
$result=mysql_query($sql,$link);
return $result;
}
function getsucursales_x_usuarioSQL($usu_id=0) {
if ($usu_id==0) {
    $sql="select x.*,f.usu_descripcion,r.suc_descripcion from sucursales_x_usuario x,usuarios f,sucursales r
      where f.usu_id=x.usu_id and r.suc_id=x.suc_id and x.sxu_estado='0' order by f.usu_descripcion,r.suc_descripcion";
} else {
    $sql="select x.*,f.usu_descripcion,r.suc_descripcion
                from sucursales_x_usuario x,usuarios f,sucursales r
                where x.sxu_estado=0
                AND f.usu_id=x.usu_id
                AND r.suc_id=x.suc_id
                AND f.usu_id =".$usu_id.
                " order by f.usu_descripcion,r.suc_descripcion";
}
    return $sql;
}

function get_sxu_id()
{ return $this->sxu_id;}
function set_sxu_id($val)
{ $this->sxu_id=$val;}
function get_suc_id()
{ return $this->suc_id;}
function set_suc_id($val)
{ $this->suc_id=$val;}
function get_usu_id()
{ return $this->usu_id;}
function set_usu_id($val)
{ $this->usu_id=$val;}
function get_sxu_estado()
{ return $this->sxu_estado;}
function set_sxu_estado($val)
{ $this->sxu_estado=$val;}
function get_usu_id_audit()
{ return $this->usu_id_audit;}
function set_usu_id_audit($val)
{ $this->usu_id_audit=$val;}
}
?>