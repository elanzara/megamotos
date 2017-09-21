<?php
class funciones_x_role {

var $fxr_id;
var $fun_id;
var $rol_id;
var $fxr_estado;
var $usu_id;


function funciones_x_role($fxr_id=0) {
if ($fxr_id!=0) {
$link=Conectarse();
$consulta= mysql_query(' select * from funciones_x_role where fxr_id = '.$fxr_id,$link);
while($row= mysql_fetch_assoc($consulta)) {
    $this->fxr_id=$row['fxr_id'];
    $this->fun_id=$row['fun_id'];
    $this->rol_id=$row['rol_id'];
    $this->fxr_estado=$row['fxr_estado'];
    $this->usu_id=$row['usu_id'];
}
}
}
function insert_fxr() {
    $link=Conectarse();
    $sql="insert into funciones_x_role (
         fun_id
        , rol_id
        , usu_id
        ) values (
         '$this->fun_id'
        , '$this->rol_id'
        , '".$_SESSION["usu_id"]."'
    )";
    $result=mysql_query($sql,$link);
    $ultimo_id = mysql_insert_id($link);
    if ($ultimo_id>0){
        $sql1="INSERT INTO hfunciones_x_role
            (tipo, fxr_id, fun_id, rol_id, fxr_estado, usu_id)
            VALUES
            ('I', $ultimo_id, '$this->fun_id', '$this->rol_id', 0, '".$_SESSION["usu_id"]."')";
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
function update_fxr() {
    $link=Conectarse();
    $sql="INSERT INTO hfunciones_x_role
            (tipo, fxr_id, fun_id, rol_id, fxr_estado, usu_id)
         SELECT
            'U', fxr_id, fun_id, rol_id, fxr_estado, '".$_SESSION["usu_id"]."'
         FROM funciones_x_role
         WHERE fxr_id= '$this->fxr_id'";
    $result=mysql_query($sql,$link);
    if ($result>0){
        $sql1="update funciones_x_role set
                 fun_id = '$this->fun_id'
                , rol_id = '$this->rol_id'
                , fxr_estado = '$this->fxr_estado'
                , usu_id = '".$_SESSION["usu_id"]."'
        where fxr_id = '$this->fxr_id'";
        $result1=mysql_query($sql1,$link);
        if ($result1>0){
            return 1;
        }else {
            return 0;}
    } else {
        return 0;
    }
}
function baja_fxr(){
    $link=Conectarse();
    $sql="INSERT INTO hfunciones_x_role
            (tipo, fxr_id, fun_id, rol_id, fxr_estado, usu_id)
         SELECT
            'B', fxr_id, fun_id, rol_id, fxr_estado, '".$_SESSION["usu_id"]."'
         FROM funciones_x_role
         WHERE fxr_id= '$this->fxr_id'";
    $result=mysql_query($sql,$link);
    if ($result>0){
        $sql1="update funciones_x_role set fxr_estado = '1', usu_id = '".$_SESSION["usu_id"].
            "' where fxr_id = '$this->fxr_id'";
        $result1=mysql_query($sql1,$link);
        if ($result1>0){
            return 1;
        }else {
            return 0;}
    } else {
        return 0;
    }
}
function getfunciones_x_role()
{
$link=Conectarse();
$sql="select * from funciones_x_role where fxr_estado='0'";
$result=mysql_query($sql,$link);
return $result;
}
function getfunciones_x_roleDes()
{
$link=Conectarse();
$sql="select * from funciones_x_role where fxr_estado='1'";
$result=mysql_query($sql,$link);
return $result;
}
function getfunciones_x_roleSQL()
{
$link=Conectarse();
$sql="select x.*,f.fun_descripcion,r.rol_descripcion from funciones_x_role x,funciones f,roles r
      where f.fun_id=x.fun_id and r.rol_id=x.rol_id and x.fxr_estado='0'";
return $sql;
}
function get_fxr_id()
{ return $this->fxr_id;}
function set_fxr_id($val)
{ $this->fxr_id=$val;}
function get_fun_id()
{ return $this->fun_id;}
function set_fun_id($val)
{ $this->fun_id=$val;}
function get_rol_id()
{ return $this->rol_id;}
function set_rol_id($val)
{ $this->rol_id=$val;}
function get_fxr_estado()
{ return $this->fxr_estado;}
function set_fxr_estado($val)
{ $this->fxr_estado=$val;}
function get_usu_id()
{ return $this->usu_id;}
function set_usu_id($val)
{ $this->usu_id=$val;}
}
?>