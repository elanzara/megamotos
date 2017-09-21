<?php
class bancos {

var $bc_id;
var $bc_descripcion;
var $bc_estado;
var $usu_id;


function bancos($bc_id=0) {
if ($bc_id!=0) {
$link=Conectarse();
$consulta= mysql_query(' select * from bancos where bc_id = '.$bc_id,$link);
while($row= mysql_fetch_assoc($consulta)) {
$this->bc_id=$row['bc_id'];
$this->mar_id=$row['mar_id'];
$this->bc_descripcion=$row['bc_descripcion'];
$this->bc_estado=$row['bc_estado'];
$this->usu_id=$row['usu_id'];
}
}
}
function insert_bc() {
    $link=Conectarse();
    $sql="insert into bancos (
     mar_id
    , bc_descripcion
    , usu_id
    ) values (
     '$this->mar_id'
    , '$this->bc_descripcion'
    , '".$_SESSION["usu_id"]."'
    )";
    $result=mysql_query($sql,$link);
    $ultimo_id = mysql_insert_id($link);
    if ($ultimo_id>0){
	         return $ultimo_id;
        }
  else {
        return 0;
    }
}
function update_bc() {
$link=Conectarse();
     $sql1="update bancos set
            bc_id = '$this->bc_id'
            , mar_id = '$this->mar_id'
            , bc_descripcion = '$this->bc_descripcion'
            , bc_estado = '$this->bc_estado'
            , usu_id = '".$_SESSION["usu_id"]."'
            where bc_id = '$this->bc_id'";
    $result1=mysql_query($sql1,$link);
    if ($result1>0){
        return 1;
    }else {
        return 0;}
 }
/*function baja_bc(){
   $link=Conectarse();
    $sql4="select 0 from cheques where ch_estado='0' and bc_id = '$this->bc_id'";
    $result4=mysql_query($sql4,$link);
    if ($row = mysql_fetch_array($result4)){
      $result4 = 0;
    } else {$result4 = 4;
    }
   if ($result4>0){
            $sql1="update bancos set bc_estado = '1', usu_id = '".$_SESSION["usu_id"].
                         "' where bc_id = '$this->bc_id'";
            $result1=mysql_query($sql1,$link);
            if ($result1>0){
                return 1;
            }else {
                return 0;}
        } else {
            return 0;
        }
}*/
function getbancos($bc_id=0)
{
    $link=Conectarse();
    if ($bc_id!=0) {
        $sql="select * from bancos g where g.bc_estado=0 and g.bc_id =".$bc_id." order by g.bc_descripcion";
    } else {
        $sql="select * from bancos where bc_estado='0'";
    }
    $result=mysql_query($sql,$link);
    return $result;
}
function getbancosDes()
{
$link=Conectarse();
$sql="select * from bancos where bc_estado='1'";
$result=mysql_query($sql,$link);
return $result;
}

//usada vivi
function getbancosNuloCombo($bc_id=0) {
    $link=Conectarse();
    $html = "";
    $sql="(select m.bc_descripcion, m.bc_id
        from bancos m
        where m.bc_estado = 0 )
        union
        (select ' TODOS' bc_descripcion, '0' bc_id
        from dual)
        order by bc_descripcion";
    $consulta= mysql_query($sql, $link);
    $html.= "<select name='bancos' id='bancos'>";
    while($row= mysql_fetch_assoc($consulta)) {
        if ($bc_id!=0) {
            if ($row['bc_id'] == $bc_id) {
                $html.= "<option value=".$row['bc_id']." selected>".$row['bc_descripcion']."</option>";
            } else {
                $html.= "<option value=".$row['bc_id'].">".$row['bc_descripcion']."</option>";
            }
        } else {
            $html.= "<option value=".$row['bc_id'].">".$row['bc_descripcion']."</option>";
        }
    }
    $html.= "</select>";
    return $html;
}
function getbcCombo($bc_id=0) {
    $link=Conectarse();
    $html = "";
    $sql="select bc_descripcion, bc_id
        from bancos
        where bc_estado = 0
        order by bc_descripcion";
    $consulta= mysql_query($sql, $link);
    $html = "<select name='bancos' id='bancos' class='formFields' >";
    while($row= mysql_fetch_assoc($consulta)) {
        if ($bc_id==$row["bc_id"]){
            $html = $html . '<option value='.$row["bc_id"].' selected>'.$row["bc_descripcion"].'</option>';
        } else {
            $html = $html . '<option value='.$row["bc_id"].'>'.$row["bc_descripcion"].'</option>';
        }
    }
    $html = $html . '</select>';
    return $html;
}

function get_bc_id()
{ return $this->bc_id;}
function set_bc_id($val)
{ $this->bc_id=$val;}
function get_bc_descripcion()
{ return $this->bc_descripcion;}
function set_bc_descripcion($val)
{ $this->bc_descripcion=$val;}
function get_bc_estado()
{ return $this->bc_estado;}
function set_bc_estado($val)
{ $this->bc_estado=$val;}
function get_usu_id()
{ return $this->usu_id;}
function set_usu_id($val)
{ $this->usu_id=$val;}
}
?>