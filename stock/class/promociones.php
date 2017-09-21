<?php
class promociones {

var $pmo_id;
var $pmo_descripcion;
var $pmo_fecha_desde;
var $pmo_fecha_hasta;
var $pmo_estado;
var $pmo_fecha_alta;
var $pmo_user_alta;
var $pmo_fecha_modi;
var $pmo_user_modi;


function promociones($pmo_id=0) {
if ($pmo_id!=0) {
$link=Conectarse();
$consulta= mysql_query(' select pmo_id , pmo_descripcion , pmo_fecha_desde , pmo_fecha_hasta , pmo_estado , pmo_fecha_alta , pmo_user_alta , pmo_fecha_modi , pmo_user_modi from promociones where pmo_id = '.$pmo_id,$link);
while($row= mysql_fetch_assoc($consulta)) {
$this->pmo_id=$row['pmo_id'];
$this->pmo_descripcion=$row['pmo_descripcion'];
$this->pmo_fecha_desde=$row['pmo_fecha_desde'];
$this->pmo_fecha_hasta=$row['pmo_fecha_hasta'];
$this->pmo_estado=$row['pmo_estado'];
$this->pmo_fecha_alta=$row['pmo_fecha_alta'];
$this->pmo_user_alta=$row['pmo_user_alta'];
$this->pmo_fecha_modi=$row['pmo_fecha_modi'];
$this->pmo_user_modi=$row['pmo_user_modi'];
}
}
}
function insert_pmo() {
$link=Conectarse();
$sql="insert into promociones (
pmo_id
, pmo_descripcion
, pmo_fecha_desde
, pmo_fecha_hasta
, pmo_estado
, pmo_fecha_alta
, pmo_user_alta
, pmo_fecha_modi
, pmo_user_modi
) values ( 
'$this->pmo_id'
, '$this->pmo_descripcion'
, '$this->pmo_fecha_desde'
, '$this->pmo_fecha_hasta'
, '$this->pmo_estado'
, '$this->pmo_fecha_alta'
, '$this->pmo_user_alta'
, '$this->pmo_fecha_modi'
, '$this->pmo_user_modi'
)";
$result=mysql_query($sql,$link);
if ($result>0){
return 1;
} else {
return 0;
}
}
function update_pmo() {
$link=Conectarse();
$sql="update promociones set 
pmo_id = '$this->pmo_id'
, pmo_descripcion = '$this->pmo_descripcion'
, pmo_fecha_desde = '$this->pmo_fecha_desde'
, pmo_fecha_hasta = '$this->pmo_fecha_hasta'
, pmo_estado = '$this->pmo_estado'
, pmo_fecha_alta = '$this->pmo_fecha_alta'
, pmo_user_alta = '$this->pmo_user_alta'
, pmo_fecha_modi = '$this->pmo_fecha_modi'
, pmo_user_modi = '$this->pmo_user_modi'
where pmo_id = '$this->pmo_id'";
$result=mysql_query($sql,$link);
if ($result>0){
return 1;
} else {
return 0;
}
}
function baja_pmo(){
$link=Conectarse();
$sql="update promociones set pmo_estado = '1' where pmo_id = '$this->pmo_id'";
$result=mysql_query($sql,$link);
if ($result>0){
return 1;
} else {
return 0;
}
}
function getpromociones()
{
$link=Conectarse();
$sql="select * from promociones where pmo_estado='0'";
$result=mysql_query($sql,$link);
return $result;
}
function getpromocionesDes()
{
$link=Conectarse();
$sql="select * from promociones where pmo_estado='1'";
$result=mysql_query($sql,$link);
return $result;
}

function getPromocionesCombo($pmo_id=0) {
    $link=Conectarse();
    $html = "";
    $sql="select *
        from promociones
        where pmo_estado = 0
        order by pmo_descripcion";
    $consulta= mysql_query($sql, $link);
    $html = "<select name='promociones' id='promociones' class='formFields' onchange='xajax_asignapmo_id(this.value);'>";
    $html = $html . '<option value="-1" selected>NINGUNA</option>';
    while($row= mysql_fetch_assoc($consulta)) {
        if ($pmo_id==$row["pmo_id"]){
            $html = $html . '<option value='.$row["pmo_id"].' selected>'.$row["pmo_descripcion"].'</option>';
        } else {
            $html = $html . '<option value='.$row["pmo_id"].'>'.$row["pmo_descripcion"].'</option>';
        }
    }
    $html = $html . '</select>';
    return $html;
}



function get_pmo_id()
{ return $this->pmo_id;}
function set_pmo_id($val)
{ $this->pmo_id=$val;}
function get_pmo_descripcion()
{ return $this->pmo_descripcion;}
function set_pmo_descripcion($val)
{ $this->pmo_descripcion=$val;}
function get_pmo_fecha_desde()
{ return $this->pmo_fecha_desde;}
function set_pmo_fecha_desde($val)
{ $this->pmo_fecha_desde=$val;}
function get_pmo_fecha_hasta()
{ return $this->pmo_fecha_hasta;}
function set_pmo_fecha_hasta($val)
{ $this->pmo_fecha_hasta=$val;}
function get_pmo_estado()
{ return $this->pmo_estado;}
function set_pmo_estado($val)
{ $this->pmo_estado=$val;}
function get_pmo_fecha_alta()
{ return $this->pmo_fecha_alta;}
function set_pmo_fecha_alta($val)
{ $this->pmo_fecha_alta=$val;}
function get_pmo_user_alta()
{ return $this->pmo_user_alta;}
function set_pmo_user_alta($val)
{ $this->pmo_user_alta=$val;}
function get_pmo_fecha_modi()
{ return $this->pmo_fecha_modi;}
function set_pmo_fecha_modi($val)
{ $this->pmo_fecha_modi=$val;}
function get_pmo_user_modi()
{ return $this->pmo_user_modi;}
function set_pmo_user_modi($val)
{ $this->pmo_user_modi=$val;}
}
?>