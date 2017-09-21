<?php
class tipo_rango {

var $tr_id;
var $tr_descripcion;
var $tr_velocidad_desde;
var $tr_velocidad_hasta;
var $tr_estado;
var $usu_id;


function tipo_rango($tr_id=0) {
    if ($tr_id!=0) {
        $link=Conectarse();
        $consulta= mysql_query(' select * from tipo_rango where tr_id = '.$tr_id,$link);
        while($row= mysql_fetch_assoc($consulta)) {
            $this->tr_id=$row['tr_id'];
            $this->tr_descripcion=$row['tr_descripcion'];
            $this->tr_velocidad_desde=$row['tr_velocidad_desde'];
            $this->tr_velocidad_hasta=$row['tr_velocidad_hasta'];
            $this->tr_estado=$row['tr_estado'];
            $this->usu_id=$row['usu_id'];
        }
    }
}
function insert_tr() {
    $link=Conectarse();
    $sql="insert into tipo_rango (
    tr_id
    , tr_descripcion
    , tr_velocidad_desde
    , tr_velocidad_hasta
    , tr_estado
    , usu_id
    ) values ( 
    '".$this->tr_id."'
    , '".$this->tr_descripcion."'
    , '".$this->tr_velocidad_desde."'
    , '".$this->tr_velocidad_hasta."'
    , '".$this->tr_estado."'
    , '".$_SESSION["usu_id"]."'
    )";
    $result=mysql_query($sql,$link);
    $ins_id = mysql_insert_id();
    if ($ins_id>0){
        $sql1="INSERT INTO htipo_rango
            (tipo, tr_id, tr_descripcion, tr_velocidad_desde, tr_velocidad_hasta, tr_estado, usu_id)
            VALUES
            ('I', $ins_id, '$this->tr_descripcion', '$this->tr_velocidad_desde'
            , '$this->tr_velocidad_hasta',0, '".$_SESSION["usu_id"]."')";
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
function update_tr() {
    $link=Conectarse();
    $sql="INSERT INTO htipo_rango
         (tipo, tr_id, tr_descripcion, tr_velocidad_desde, tr_velocidad_hasta, tr_estado, usu_id)
         SELECT
            'U', tr_id, tr_descripcion, tr_velocidad_desde, tr_velocidad_hasta, tr_estado, '".$_SESSION["usu_id"]."'
         FROM tipo_rango
         WHERE tr_id= '$this->tr_id'";
    $result=mysql_query($sql,$link);
    if ($result>0){
        $sql1="update tipo_rango set
            tr_id = '$this->tr_id'
            , tr_descripcion = '".$this->tr_descripcion."'
            , tr_velocidad_desde = '".$this->tr_velocidad_desde."'
            , tr_velocidad_hasta = '".$this->tr_velocidad_hasta."'
            , tr_estado = '".$this->tr_estado."'
            , usu_id = '".$_SESSION["usu_id"]."'
            where tr_id = '".$this->tr_id."'";
        $result1=mysql_query($sql1,$link);
        if ($result1>0){
            return 1;
        }else {
            return 0;}
    } else {
        return 0;
    }
}
function baja_tr(){
    $link=Conectarse();
    $sql1="select 0 from productos where pro_estado='0' and tr_id = '$this->tr_id'";
    $result1=mysql_query($sql1,$link);
    if ($row = mysql_fetch_array($result1)){
      $result1 = 0;
    } else {$result1 = 1;
    }
    if ($result1>0){
        $sql="INSERT INTO htipo_rango
             (tipo, tr_id, tr_descripcion, tr_velocidad_desde, tr_velocidad_hasta, tr_estado, usu_id)
             SELECT
                'B', tr_id, tr_descripcion, tr_velocidad_desde, tr_velocidad_hasta, tr_estado
                , '".$_SESSION["usu_id"]."'
             FROM tipo_rango
             WHERE tr_id= '$this->tr_id'";
        $result=mysql_query($sql,$link);
        if ($result>0){
            $sql1="update tipo_rango set tr_estado = '1', usu_id = '".$_SESSION["usu_id"].
                     "' where tr_id = '".$this->tr_id."'";
            $result1=mysql_query($sql1,$link);
            if ($result1>0){
                return 1;
            }else {
                return 0;}
        } else {
            return 0;
        }
    }
}
function gettipo_rango()
{
    $link=Conectarse();
    $sql="select * from tipo_rango where tr_estado='0'";
    $result=mysql_query($sql,$link);
    return $result;
}
function gettipo_rangoDes()
{
    $link=Conectarse();
    $sql="select * from tipo_rango where tr_estado='1'";
    $result=mysql_query($sql,$link);
    return $result;
}
function gettipo_rangoSQL() {
    $sql="select * from tipo_rango tr where tr.tr_estado=0 order by tr.tr_descripcion";
    return $sql;
}
function gettipo_rangoCombo($tr_id=0) {
    $link=Conectarse();
    $html = "";
    $sql="(select tr_descripcion, tr_id, 1 as orden
        from tipo_rango
        where tr_estado = 0)
        union
        (select 'Todos' tr_descripcion, '0' tr_id, 0 as orden
        from dual)
        order by orden, tr_descripcion";
    $consulta= mysql_query($sql, $link);
    $html = "<select name='tipo_rango' id='tipo_rango' class='formFields' >";
    while($row= mysql_fetch_assoc($consulta)) {
        if ($tr_id==$row["tr_id"]){
            $html = $html . '<option value='.$row["tr_id"].' selected>'.$row["tr_descripcion"].'</option>';
        } else {
            $html = $html . '<option value='.$row["tr_id"].'>'.$row["tr_descripcion"].'</option>';
        }
    }
    $html = $html . '</select>';
    return $html;
}

function gettipo_rangoComboNulo($tr_id=0) {
    $link=Conectarse();
    $html = "";
    $sql="(select tr_descripcion, tr_id, 1 as orden
        from tipo_rango
        where tr_estado = 0)
        union
        (select 'Todos' tr_descripcion, '0' tr_id, 0 as orden
        from dual)
        order by orden, tr_descripcion";
    $consulta= mysql_query($sql, $link);
    $html = "<select name='tipo_rango' id='tipo_rango' class='formFields' >";
    while($row= mysql_fetch_assoc($consulta)) {
        if ($tr_id==$row["tr_id"]){
            $html = $html . '<option value='.$row["tr_id"].' selected>'.$row["tr_descripcion"].'</option>';
        } else {
            $html = $html . '<option value='.$row["tr_id"].'>'.$row["tr_descripcion"].'</option>';
        }
    }
    $html = $html . '</select>';
    return $html;
}


function get_tr_id()
{ return $this->tr_id;}
function set_tr_id($val)
{ $this->tr_id=$val;}
function get_tr_descripcion()
{ return $this->tr_descripcion;}
function set_tr_descripcion($val)
{ $this->tr_descripcion=$val;}
function get_tr_velocidad_desde()
{ return $this->tr_velocidad_desde;}
function set_tr_velocidad_desde($val)
{ $this->tr_velocidad_desde=$val;}
function get_tr_velocidad_hasta()
{ return $this->tr_velocidad_hasta;}
function set_tr_velocidad_hasta($val)
{ $this->tr_velocidad_hasta=$val;}
function get_tr_estado()
{ return $this->tr_estado;}
function set_tr_estado($val)
{ $this->tr_estado=$val;}
}
?>