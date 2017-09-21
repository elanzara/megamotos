<?php
class pagos {

var $tpg_id;
var $tpg_descripcion;
var $tpg_estado;
var $usu_id;


function pagos($tpg_id=0) {
    if ($tpg_id!=0) {
    $link=Conectarse();
    $consulta= mysql_query(' select * from tipo_pagos where tpg_id = '.$tpg_id,$link);
    while($row= mysql_fetch_assoc($consulta)) {
    $this->tpg_id=$row['tpg_id'];
    $this->tpg_descripcion=$row['tpg_descripcion'];
    $this->tpg_estado=$row['tpg_estado'];
    $this->usu_id=$row['usu_id'];
    }
    }
}
function insert_pgo() {
    $link=Conectarse();
    $sql="insert into tipo_pagos (
        tpg_descripcion
        , usu_id
    ) values (
        '$this->tpg_descripcion'
        , '".$_SESSION["usu_id"]."'
    )";
    $result=mysql_query($sql,$link);
    $ultimo_id = mysql_insert_id($link);
    if ($ultimo_id>0){
	   return $ultimo_id;}
     /*   $sql1="INSERT INTO hpagos
            (tipo, tpg_id, tpg_descripcion, tpg_estado, usu_id)
            VALUES
            ('I', $ultimo_id, '$this->tpg_descripcion', 0, '".$_SESSION["usu_id"]."')";
        $result1=mysql_query($sql1,$link);
        if ($result1>0){
            return $ultimo_id;
        }else {
            return 0;
        }
    }*/
	 else {
        return 0;
    }
}
function update_pgo() {
    $link=Conectarse();
    $sql1="update tipo_pagos set
             tpg_descripcion = '$this->tpg_descripcion'
            , tpg_estado = '$this->tpg_estado'
            , usu_id = '".$_SESSION["usu_id"]."'
            where tpg_id = '$this->tpg_id'";
        $result1=mysql_query($sql1,$link);
        if ($result1>0){
            return 1;
        }else {
            return 0;}
}
/*function baja_pgo(){
    $link=Conectarse();
    $sql4="select 0 from tipo_pagos where tpg_estado='0' and tpg_id = '$this->tpg_id'";
    $result4=mysql_query($sql4,$link);
    if ($row = mysql_fetch_array($result4)){
      $result4 = 0;
    } else {$result4 = 4;
    }
   if ($result4>0){
           $sql1="update tipo_pagos set tpg_estado = '1', usu_id = '".$_SESSION["usu_id"].
                "' where tpg_id = '$this->tpg_id'";
            $result1=mysql_query($sql1,$link);
            if ($result1>0){
                return 1;
            }else {
                return 0;}
        } else {
            return 0;
        }
    }
}*/
function getpagos($tpg_id=0)
{
    $link=Conectarse();
    if ($tpg_id!=0) {
        $sql="select * from tipo_pagos g where g.tpg_estado=0 and g.tpg_id =".$tpg_id." order by g.tpg_descripcion";
    } else {
        $sql="select * from tipo_pagos where tpg_estado='0'";
    }
    $result=mysql_query($sql,$link);
    return $result;
}
function getpagosDes()
{
    $link=Conectarse();
    $sql="select * from tipo_pagos where tpg_estado='1'";
    $result=mysql_query($sql,$link);
    return $result;
}
function getpagosSQL($tpg_id=0) {
  if ($tpg_id!=0) {
    $sql="select * from tipo_pagos g where g.tpg_estado=0 and g.tpg_id =".$tpg_id." order by g.tpg_descripcion";
  } else {
    $sql="select * from tipo_pagos g where g.tpg_estado=0 order by g.tpg_descripcion";
  }
    return $sql;
}

function getpagosComboTpg($tpg_id=0) {
    $link=Conectarse();
    $html = "";
    $sql=" select tpg_descripcion, tpg_id
        from tipo_pagos
        where tpg_estado = 0
		and tpg_id =".$tpg_id." order by tpg_descripcion";
    $consulta= mysql_query($sql, $link);
    $html = "<select name='pagos' id='pagos' class='formFields'  onChange='cargaContenido(this.id)'>";    
    while($row= mysql_fetch_assoc($consulta)) {
        if ($tpg_id==$row["tpg_id"]){
            $html = $html . '<option value='.$row["tpg_id"].' selected>'.$row["tpg_descripcion"].'</option>';
        } else {
            $html = $html . '<option value='.$row["tpg_id"].'>'.$row["tpg_descripcion"].'</option>';
        }
    }
    $html = $html . '</select>';
    return $html;
}

function getTpgnuloCombo($tpg_id=0) {
    $link=Conectarse();
    $html = "";
    $sql="(select tpg_descripcion, tpg_id
        from tipo_pagos
        where tpg_estado = 0)
        union
        (select ' TODOS' tpg_descripcion, '0' tpg_id
        from dual)
        order by tpg_descripcion";
    $consulta= mysql_query($sql, $link);
    $html = "<select name='tipo_pagos' id='tipo_pagos' class='formFields'  onChange='cargaContenido(this.id)'>";
    while($row= mysql_fetch_assoc($consulta)) {
        if ($tip_id==$row["tpg_id"]){
            $html = $html . '<option value='.$row["tpg_id"].' selected>'.$row["tpg_descripcion"].'</option>';
        } else {
            $html = $html . '<option value='.$row["tpg_id"].'>'.$row["tpg_descripcion"].'</option>';
        }
    }
    $html = $html . '</select>';
    return $html;
}

function gettpgCombo($tpg_id=0) {
    $link=Conectarse();
    $html = "";
    $sql="select tpg_descripcion, tpg_id
        from tipo_pagos
        where tpg_estado = 0
        order by tpg_descripcion";
    $consulta= mysql_query($sql, $link);
    $html = "<select name='pagos' id='pagos' class='formFields' >";
    while($row= mysql_fetch_assoc($consulta)) {
        if ($tpg_id==$row["tpg_id"]){
            $html = $html . '<option value='.$row["tpg_id"].' selected>'.$row["tpg_descripcion"].'</option>';
        } else {
            $html = $html . '<option value='.$row["tpg_id"].'>'.$row["tpg_descripcion"].'</option>';
        }
    }
    $html = $html . '</select>';
    return $html;
}

function get_tpg_id()
{ return $this->tpg_id;}
function set_tpg_id($val)
{ $this->tpg_id=$val;}
function get_tpg_descripcion()
{ return $this->tpg_descripcion;}
function set_tpg_descripcion($val)
{ $this->tpg_descripcion=$val;}
function get_tpg_estado()
{ return $this->tpg_estado;}
function set_tpg_estado($val)
{ $this->tpg_estado=$val;}
function get_usu_id()
{ return $this->usu_id;}
function set_usu_id($val)
{ $this->usu_id=$val;}
}
?>