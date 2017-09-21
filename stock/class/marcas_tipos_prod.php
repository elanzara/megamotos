<?php
class marcas_tipos_prod {

var $mtp_id;
var $mar_id;
var $mod_id;
var $tip_id;
var $mtp_estado;
var $usu_id;


function marcas_tipos_prod($mtp_id=0) {
    if ($mtp_id!=0) {
    $link=Conectarse();
    $consulta= mysql_query(' select * from marcas_tipos_prod where mtp_id = '.$mtp_id,$link);
    while($row= mysql_fetch_assoc($consulta)) {
    $this->mtp_id=$row['mtp_id'];
    $this->mar_id=$row['mar_id'];
    $this->mod_id=$row['mod_id'];
    $this->tip_id=$row['tip_id'];
    $this->mtp_estado=$row['mtp_estado'];
    $this->usu_id=$row['usu_id'];
    }
    }
}
function insert_mtp() {
    $link=Conectarse();
    $sql="insert into marcas_tipos_prod (
    mar_id
  , mod_id
  , tip_id
  , usu_id
    ) values (
    '$this->mar_id'
  , '$this->mod_id'
  , '$this->tip_id'
  , '".$_SESSION["usu_id"]."'
    )";
    $result=mysql_query($sql,$link);
    $ins_id = mysql_insert_id();
    if ($ins_id>0){
        $sql1="INSERT INTO hmarcas_tipos_prod
            (tipo, mtp_id, mar_id, mod_id, tip_id, mtp_estado, usu_id)
            VALUES
            ('I', $ins_id, '$this->mar_id', '$this->mod_id', '$this->tip_id', 0, '".$_SESSION["usu_id"]."')";
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
function update_mtp() {
    $link=Conectarse();
    $sql="INSERT INTO hmarcas_tipos_prod
         (tipo, mtp_id, mar_id, mod_id, tip_id, mtp_estado, usu_id)
         SELECT
            'U', mtp_id, mar_id, mod_id, tip_id, mtp_estado, '".$_SESSION["usu_id"]."'
         FROM marcas_tipos_prod
         WHERE mtp_id= '$this->mtp_id'";
    $result=mysql_query($sql,$link);
    if ($result>0){
        $sql1="update marcas_tipos_prod set
         mar_id = '$this->mar_id'
        , mod_id = '$this->mod_id'
        , tip_id = '$this->tip_id'
        , mtp_estado = '$this->mtp_estado'
        , usu_id = '".$_SESSION["usu_id"]."'
        where mtp_id = '$this->mtp_id'";
        $result1=mysql_query($sql1,$link);
        if ($result1>0){
        return 1;
        }else {
            return 0;}
    } else {
        return 0;
    }
}
function baja_mtp(){
    $link=Conectarse();
    $sql="INSERT INTO hmarcas_tipos_prod
         (tipo, mtp_id, mar_id, mod_id, tip_id, mtp_estado, usu_id)
         SELECT
            'B', mtp_id, mar_id, mod_id, tip_id, mtp_estado, '".$_SESSION["usu_id"]."'
         FROM marcas_tipos_prod
         WHERE mtp_id= '$this->mtp_id'";
    $result=mysql_query($sql,$link);
    if ($result>0){
        $sql1="update marcas_tipos_prod set mtp_estado = '1', usu_id = '".$_SESSION["usu_id"].
                 "' where mtp_id = '$this->mtp_id'";
        $result1=mysql_query($sql1,$link);
        if ($result1>0){
            return 1;
        }else {
            return 0;}
    } else {
        return 0;
    }
}
function getmarcas_tipos_prod()
{
    $link=Conectarse();
    $sql="select * from marcas_tipos_prod where mtp_estado='0'";
    $result=mysql_query($sql,$link);
    return $result;
}
function getmarcas_tipos_prodDes()
{
    $link=Conectarse();
    $sql="select * from marcas_tipos_prod where mtp_estado='1'";
    $result=mysql_query($sql,$link);
    return $result;
}
function getmarcas_tipos_prodSQL($mar_id=0,$mod_id=0) {
if ($mar_id==0 and $mod_id==0) {
    $sql="select g.* from marcas_tipos_prod g where g.mtp_estado=0 order by g.mar_id";
} elseif ($mar_id==0 and $mod_id!=0) {
    $sql="select g.*,t.tip_descripcion,m.mod_descripcion from marcas_tipos_prod g, tipo_productos t, modelos m
                where g.mtp_estado=0
                AND g.mod_id = m.mod_id
                AND g.tip_id = t.tip_id
                AND g.mod_id =".$mod_id.
                " order by m.mod_descripcion, t.tip_descripcion";
} elseif ($mar_id!=0 and $mod_id==0) {
    $sql="select g.*,t.tip_descripcion,a.mar_descripcion,m.mod_descripcion
                from marcas_tipos_prod g 
                LEFT JOIN tipo_productos t ON g.tip_id = t.tip_id
                LEFT JOIN marcas a ON g.mar_id = a.mar_id
                LEFT JOIN modelos m ON g.mod_id = m.mod_id
                where g.mtp_estado=0
                AND g.mar_id =".$mar_id.
                " order by a.mar_descripcion, m.mod_descripcion, t.tip_descripcion";
} elseif ($mar_id!=0 and $mod_id!=0) {
    $sql="select g.*,t.tip_descripcion,a.mar_descripcion,m.mod_descripcion
                from marcas_tipos_prod g, tipo_productos t, marcas a, modelos m
                where g.mtp_estado=0
                AND g.mod_id = m.mod_id
                AND g.mar_id = a.mar_id
                AND g.tip_id = t.tip_id
                AND g.mod_id =".$mod_id."
                AND g.mar_id =".$mar_id.
                " order by a.mar_descripcion, m.mod_descripcion, t.tip_descripcion";
}
    return $sql;
}

function get_mtp_id()
{ return $this->mtp_id;}
function set_mtp_id($val)
{ $this->mtp_id=$val;}
function get_mar_id()
{ return $this->mar_id;}
function set_mar_id($val)
{ $this->mar_id=$val;}
function get_mod_id()
{ return $this->mod_id;}
function set_mod_id($val)
{ $this->mod_id=$val;}
function get_tip_id()
{ return $this->tip_id;}
function set_tip_id($val)
{ $this->tip_id=$val;}
function get_mtp_estado()
{ return $this->mtp_estado;}
function set_mtp_estado($val)
{ $this->mtp_estado=$val;}
function get_usu_id()
{ return $this->usu_id;}
function set_usu_id($val)
{ $this->usu_id=$val;}
}
?>