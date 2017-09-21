<?php
class facturas_det {

var $fad_id;
var $pro_id;
var $otd_id;
var $fae_id;


function facturas_det($fad_id=0) {
if ($fad_id!=0) {
$link=Conectarse();
$consulta= mysql_query(' select fad_id , pro_id , otd_id , fae_id from facturas_det where fad_id = '.$fad_id,$link);
while($row= mysql_fetch_assoc($consulta)) {
$this->fad_id=$row['fad_id'];
$this->pro_id=$row['pro_id'];
$this->otd_id=$row['otd_id'];
$this->fae_id=$row['fae_id'];
}
}
}
function insert_fad() {
$link=Conectarse();
$sql="insert into facturas_det (
fad_id
, pro_id
, otd_id
, fae_id
) values ( 
'$this->fad_id'
, '$this->pro_id'
, '$this->otd_id'
, '$this->fae_id'
)";
$result=mysql_query($sql,$link);
if ($result>0){
return 1;
} else {
return 0;
}
}
function update_fad() {
$link=Conectarse();
$sql="update facturas_det set 
fad_id = '$this->fad_id'
, pro_id = '$this->pro_id'
, otd_id = '$this->otd_id'
, fae_id = '$this->fae_id'
where fad_id = '$this->fad_id'";
$result=mysql_query($sql,$link);
if ($result>0){
return 1;
} else {
return 0;
}
}
function baja_fad(){
$link=Conectarse();
$sql="update facturas_det set fad_estado = '1' where fad_id = '$this->fad_id'";
$result=mysql_query($sql,$link);
if ($result>0){
return 1;
} else {
return 0;
}
}
function getfacturas_det()
{
$link=Conectarse();
$sql="select * from facturas_det where fad_estado='0'";
$result=mysql_query($sql,$link);
return $result;
}
function getfacturas_detDes()
{
$link=Conectarse();
$sql="select * from facturas_det where fad_estado='1'";
$result=mysql_query($sql,$link);
return $result;
}
function get_fad_id()
{ return $this->fad_id;}
function set_fad_id($val)
{ $this->fad_id=$val;}
function get_pro_id()
{ return $this->pro_id;}
function set_pro_id($val)
{ $this->pro_id=$val;}
function get_otd_id()
{ return $this->otd_id;}
function set_otd_id($val)
{ $this->otd_id=$val;}
function get_fae_id()
{ return $this->fae_id;}
function set_fae_id($val)
{ $this->fae_id=$val;}
}
?>