<?php
class tipo_productos {

var $tip_id;
var $tip_descripcion;
var $tip_estado;
var $tip_3cuotas;
var $tip_6cuotas;
var $tip_12cuotas;
var $usu_id;

function tipo_productos($tip_id=0) {
if ($tip_id!=0) {
$link=Conectarse();
$consulta= mysql_query(' select tip_id , tip_descripcion , tip_estado, tip_3cuotas, tip_6cuotas, tip_12cuotas from tipo_productos where tip_id = '.$tip_id,$link);
while($row= mysql_fetch_assoc($consulta)) {
    $this->tip_id=$row['tip_id'];
    $this->tip_descripcion=$row['tip_descripcion'];
    $this->tip_estado=$row['tip_estado'];
    $this->tip_3cuotas=$row['tip_3cuotas'];
    $this->tip_6cuotas=$row['tip_6cuotas'];
    $this->tip_12cuotas=$row['tip_12cuotas'];
    $this->usu_id=$row['usu_id'];
}
}
}
function insert_tip() {
    $link=Conectarse();
    $sql="insert into tipo_productos (
         tip_descripcion
        , tip_3cuotas
        , tip_6cuotas
        , tip_12cuotas
        , usu_id
        ) values (
         '$this->tip_descripcion'
        , $this->tip_3cuotas
        , $this->tip_6cuotas
        , $this->tip_12cuotas
        , '".$_SESSION["usu_id"]."'
    )";
    $result=mysql_query($sql,$link);
    $ultimo_id = mysql_insert_id($link);
    if ($ultimo_id>0){
        $sql1="INSERT INTO htipo_productos
            (tipo, tip_id, tip_descripcion, tip_3cuotas, tip_6cuotas, tip_12cuotas, tip_estado, usu_id)
            VALUES
            ('I', $ultimo_id, '$this->tip_descripcion', '$this->tip_3cuotas', '$this->tip_6cuotas'
                , '$this->tip_12cuotas', 0, '".$_SESSION["usu_id"]."')";
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
function update_tip() {
$link=Conectarse();
$sql="INSERT INTO htipo_productos
         (tipo, tip_id, tip_descripcion, tip_3cuotas, tip_6cuotas, tip_12cuotas, tip_estado, usu_id)
         SELECT
            'U', tip_id, tip_descripcion, tip_3cuotas, tip_6cuotas, tip_12cuotas, tip_estado, '".$_SESSION["usu_id"]."'
         FROM tipo_productos
         WHERE tip_id= '$this->tip_id'";
    $result=mysql_query($sql,$link);
    if ($result>0){
        $sql1="update tipo_productos set
            tip_id = '$this->tip_id'
            , tip_descripcion = '$this->tip_descripcion'
            , tip_estado = '$this->tip_estado'
            , tip_3cuotas = $this->tip_3cuotas
            , tip_6cuotas = $this->tip_6cuotas
            , tip_12cuotas = $this->tip_12cuotas
            , usu_id = '".$_SESSION["usu_id"]."'
            where tip_id = '$this->tip_id'";
            $result=mysql_query($sql,$link);
        $result1=mysql_query($sql1,$link);
        if ($result1>0){
            return 1;
        }else {
            return 0;}
    } else {
        return 0;
    }
}
function baja_tip(){
    $link=Conectarse();
    $sql1="select 0 from productos where pro_estado='0' and tip_id = '$this->tip_id'";
    $result1=mysql_query($sql1,$link);
    if ($row = mysql_fetch_array($result1)){
      $result1 = 0;
    } else {$result1 = 1;
    }
    $sql2="select 0 from marcas_tipos_prod where mtp_estado='0' and tip_id = '$this->tip_id'";
    $result2=mysql_query($sql2,$link);
    if ($row = mysql_fetch_array($result2)){
      $result2 = 0;
    } else {$result2 = 2;
    }
    if ($result1>0 and $result2>0){
        $sql="INSERT INTO htipo_productos
             (tipo, tip_id, tip_descripcion, tip_3cuotas, tip_6cuotas, tip_12cuotas, tip_estado, usu_id)
             SELECT
                'B', tip_id, tip_descripcion, tip_3cuotas, tip_6cuotas, tip_12cuotas, tip_estado, '".$_SESSION["usu_id"]."'
             FROM tipo_productos
             WHERE tip_id= '$this->tip_id'";
        $result=mysql_query($sql,$link);
        if ($result>0){
            $sql1="update tipo_productos set tip_estado = '1', usu_id = '".$_SESSION["usu_id"].
                "' where tip_id = '$this->tip_id'";
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
function gettipo_productos()
{
$link=Conectarse();
$sql="select * from tipo_productos where tip_estado='0'";
$result=mysql_query($sql,$link);
return $result;
}
function gettipo_productosDes()
{
$link=Conectarse();
$sql="select * from tipo_productos where tip_estado='1'";
$result=mysql_query($sql,$link);
return $result;
}
function gettipo_productosSQL()
{
$link=Conectarse();
$sql="select * from tipo_productos where tip_estado='0'";
return $sql;
}
function gettipo_productosCombo($tip_id=0, $deshabilitado='N') {
    $link=Conectarse();
    $html = "";
    $sql="select tip_descripcion, tip_id
        from tipo_productos
        where tip_estado = 0
        order by tip_descripcion";
    $consulta= mysql_query($sql, $link);
    if ($deshabilitado=='S'){
        $html = "<select name='tipo_productos' id='tipo_productos' class='formFields' disabled='disabled' >";
    } else {
        $html = "<select name='tipo_productos' id='tipo_productos' class='formFields' >";
    }
    while($row= mysql_fetch_assoc($consulta)) {
        if ($tip_id==$row["tip_id"]){
            $html = $html . '<option value='.$row["tip_id"].' selected>'.$row["tip_descripcion"].'</option>';
        } else {
            $html = $html . '<option value='.$row["tip_id"].'>'.$row["tip_descripcion"].'</option>';
        }
    }
    $html = $html . '</select>';
    return $html;
}
function getTipCombo($tip_id=0) {
    $link=Conectarse();
    $html = "";
    $sql="select tip_descripcion, tip_id
        from tipo_productos
        where tip_estado = 0
        order by tip_descripcion";
    $consulta= mysql_query($sql, $link);
    $html = "<select name='tipo_productos' id='tipo_productos' class='formFields'  onChange='cargaContenido(this.id)'>";
    if ($tip_id==0){
        $html = $html . '<option value="0" selected>TODOS</option>';
    } else {
        $html = $html . '<option value="0" >TODOS</option>';
    }
    while($row= mysql_fetch_assoc($consulta)) {
        if ($tip_id==$row["tip_id"]){
            $html = $html . '<option value='.$row["tip_id"].' selected>'.$row["tip_descripcion"].'</option>';
        } else {
            $html = $html . '<option value='.$row["tip_id"].'>'.$row["tip_descripcion"].'</option>';
        }
    }
    $html = $html . '</select>';
    return $html;
}
function getTipCombo2($tip_id=0) {
    $link=Conectarse();
    $html = "";
    $sql="select tip_descripcion, tip_id
        from tipo_productos
        where tip_estado = 0
        order by tip_descripcion";
    $consulta= mysql_query($sql, $link);
    $html = "<select name='tipo_productos' id='tipo_productos' class='formFields'  onChange='cargaContenido2(this.id)'>";
    if ($tip_id==0){
        $html = $html . '<option value="0" selected>TODOS</option>';
    } else {
        $html = $html . '<option value="0" >TODOS</option>';
    }
    while($row= mysql_fetch_assoc($consulta)) {
        if ($tip_id==$row["tip_id"]){
            $html = $html . '<option value='.$row["tip_id"].' selected>'.$row["tip_descripcion"].'</option>';
        } else {
            $html = $html . '<option value='.$row["tip_id"].'>'.$row["tip_descripcion"].'</option>';
        }
    }
    $html = $html . '</select>';
    return $html;
}
function getTipnuloCombo($tip_id=0) {
    $link=Conectarse();
    $html = "";
    $sql="(select tip_descripcion, tip_id
        from tipo_productos
        where tip_estado = 0)
        union
        (select ' ' tip_descripcion, '0' tip_id
        from dual)
        order by tip_descripcion";
    $consulta= mysql_query($sql, $link);
    $html = "<select name='tipo_productos' id='tipo_productos' class='formFields'  onChange='cargaContenido(this.id)'>";
    while($row= mysql_fetch_assoc($consulta)) {
        if ($tip_id==$row["tip_id"]){
            $html = $html . '<option value='.$row["tip_id"].' selected>'.$row["tip_descripcion"].'</option>';
        } else {
            $html = $html . '<option value='.$row["tip_id"].'>'.$row["tip_descripcion"].'</option>';
        }
    }
    $html = $html . '</select>';
    return $html;
}
function getTipnuloComboOT($tip_id=0) {
    $link=Conectarse();
    $html = "";
    $sql="(select tip_descripcion, tip_id
        from tipo_productos
        where tip_estado = 0
        and tip_id != 1)
        union
        (select ' ' tip_descripcion, '0' tip_id
        from dual)
        order by tip_descripcion";
    $consulta= mysql_query($sql, $link);
    $html = "<select name='tipo_productos' id='tipo_productos' class='formFields'  onChange='cargaContenido(this.id)'>";
    while($row= mysql_fetch_assoc($consulta)) {
        if ($tip_id==$row["tip_id"]){
            $html = $html . '<option value='.$row["tip_id"].' selected>'.$row["tip_descripcion"].'</option>';
        } else {
            $html = $html . '<option value='.$row["tip_id"].'>'.$row["tip_descripcion"].'</option>';
        }
    }
    $html = $html . '</select>';
    return $html;
}

function getTipComboMvtoStock($tip_id=0,$tipo='I') {
    $link=Conectarse();
    $html = "";
    $sql="(select tip_descripcion, tip_id
        from tipo_productos
        where tip_estado = 0)
        union
        (select ' ' tip_descripcion, '0' tip_id
        from dual)
        order by tip_descripcion";
    $consulta= mysql_query($sql, $link);
    //$html = "<select name='tipo_productos' id='tipo_productos' class='formFields'  onChange='armaFiltro(this.id,\"".$tipo."\")'>";
    $html = "<select name='tipo_productos' id='tipo_productos' class='formFields'  onChange='seleccionar(".$_SESSION["suc_id"].", \"".$tipo."\")'>";
    while($row= mysql_fetch_assoc($consulta)) {
        if ($tip_id==$row["tip_id"]){
            $html = $html . '<option value='.$row["tip_id"].' selected>'.$row["tip_descripcion"].'</option>';
        } else {
            $html = $html . '<option value='.$row["tip_id"].'>'.$row["tip_descripcion"].'</option>';
        }
    }
    $html = $html . '</select>';
    return $html;
}

function get_tip_id()
{ return $this->tip_id;}
function set_tip_id($val)
{ $this->tip_id=$val;}
function get_tip_descripcion()
{ return $this->tip_descripcion;}
function set_tip_descripcion($val)
{ $this->tip_descripcion=$val;}
function get_tip_3cuotas()
{ return $this->tip_3cuotas;}
function set_tip_3cuotas($val)
{ $this->tip_3cuotas=$val;}
function get_tip_6cuotas()
{ return $this->tip_6cuotas;}
function set_tip_6cuotas($val)
{ $this->tip_6cuotas=$val;}
function get_tip_12cuotas()
{ return $this->tip_12cuotas;}
function set_tip_12cuotas($val)
{ $this->tip_12cuotas=$val;}
function get_tip_estado()
{ return $this->tip_estado;}
function set_tip_estado($val)
{ $this->tip_estado=$val;}
function get_usu_id()
{ return $this->usu_id;}
function set_usu_id($val)
{ $this->usu_id=$val;}
}
?>