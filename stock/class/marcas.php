<?php
class marcas {

var $mar_id;
var $mar_descripcion;
var $mar_estado;
var $usu_id;


function marcas($mar_id=0) {
    if ($mar_id!=0) {
    $link=Conectarse();
    $consulta= mysql_query(' select * from marcas where mar_id = '.$mar_id,$link);
    while($row= mysql_fetch_assoc($consulta)) {
    $this->mar_id=$row['mar_id'];
    $this->mar_descripcion=$row['mar_descripcion'];
    $this->mar_estado=$row['mar_estado'];
    $this->usu_id=$row['usu_id'];
    }
    }
}
function insert_mar() {
    $link=Conectarse();
    $sql="insert into marcas (
        mar_descripcion
        , usu_id
    ) values (
        '$this->mar_descripcion'
        , '".$_SESSION["usu_id"]."'
    )";
    $result=mysql_query($sql,$link);
    $ultimo_id = mysql_insert_id($link);
    if ($ultimo_id>0){
        $sql1="INSERT INTO hmarcas
            (tipo, mar_id, mar_descripcion, mar_estado, usu_id)
            VALUES
            ('I', $ultimo_id, '$this->mar_descripcion', 0, '".$_SESSION["usu_id"]."')";
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
function update_mar() {
    $link=Conectarse();
    $sql="INSERT INTO hmarcas
         (tipo, mar_id, mar_descripcion, mar_estado, usu_id)
         SELECT
            'U', mar_id, mar_descripcion, mar_estado, '".$_SESSION["usu_id"]."'
         FROM marcas
         WHERE mar_id= '$this->mar_id'";
    $result=mysql_query($sql,$link);
    if ($result>0){
        $sql1="update marcas set
             mar_descripcion = '$this->mar_descripcion'
            , mar_estado = '$this->mar_estado'
            , usu_id = '".$_SESSION["usu_id"]."'
            where mar_id = '$this->mar_id'";
        $result1=mysql_query($sql1,$link);
        if ($result1>0){
            return 1;
        }else {
            return 0;}
    } else {
    return 0;
    }
}
function baja_mar(){
    $link=Conectarse();
    $sql1="select 0 from modelos where mod_estado='0' and mar_id = '$this->mar_id'";
    $result1=mysql_query($sql1,$link);
    if ($row = mysql_fetch_array($result1)){
      $result1 = 0;
    } else {$result1 = 1;
    }
    $sql2="select 0 from marcas_tipos_prod where mtp_estado='0' and mar_id = '$this->mar_id'";
    $result2=mysql_query($sql2,$link);
    if ($row = mysql_fetch_array($result2)){
      $result2 = 0;
    } else {$result2 = 2;
    }
    $sql3="select 0 from productos where pro_estado='0' and mar_id = '$this->mar_id'";
    $result3=mysql_query($sql3,$link);
    if ($row = mysql_fetch_array($result3)){
      $result3 = 0;
    } else {$result3 = 3;
    }
    $sql4="select 0 from vehiculos where veh_estado='0' and mar_id = '$this->mar_id'";
    $result4=mysql_query($sql4,$link);
    if ($row = mysql_fetch_array($result4)){
      $result4 = 0;
    } else {$result4 = 4;
    }
    if ($result1>0 and $result2>0 and $result3>0 and $result4>0){
        $sql="INSERT INTO hmarcas
             (tipo, mar_id, mar_descripcion, mar_estado, usu_id)
             SELECT
                'B', mar_id, mar_descripcion, mar_estado, '".$_SESSION["usu_id"]."'
             FROM marcas
             WHERE mar_id= '$this->mar_id'";
        $result=mysql_query($sql,$link);
        if ($result>0){
            $sql1="update marcas set mar_estado = '1', usu_id = '".$_SESSION["usu_id"].
                "' where mar_id = '$this->mar_id'";
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
function getmarcas($mar_id=0)
{
    $link=Conectarse();
    if ($mar_id!=0) {
        $sql="select * from marcas g where g.mar_estado=0 and g.mar_id =".$mar_id." order by g.mar_descripcion";
    } else {
        $sql="select * from marcas where mar_estado='0'";
    }
    $result=mysql_query($sql,$link);
    return $result;
}
function getmarcasDes()
{
    $link=Conectarse();
    $sql="select * from marcas where mar_estado='1'";
    $result=mysql_query($sql,$link);
    return $result;
}
function getmarcasSQL($mar_id=0) {
  if ($mar_id!=0) {
    $sql="select * from marcas g where g.mar_estado=0 and g.mar_id =".$mar_id." order by g.mar_descripcion";
  } else {
    $sql="select * from marcas g where g.mar_estado=0 order by g.mar_descripcion";
  }
    return $sql;
}
function getmarcasSQLxTipId($tip_id=0,$mar_id=0)
{
$link=Conectarse();
if ($tip_id==0 and $mar_id==0) {
    $sql = "SELECT m.*
            FROM marcas m
            WHERE m.mar_estado =  '0'
            ORDER BY m.mar_descripcion";
} elseif ($tip_id==0 and $mar_id!=0) {
    $sql = "SELECT m.*
            FROM marcas m
            WHERE m.mar_estado =  '0'
            AND m.mar_id =".$mar_id."
            ORDER BY m.mar_descripcion";
} elseif ($tip_id!=0 and $mar_id!=0) {
    $sql = "SELECT m.*
            FROM marcas m,marcas_tipos_prod t
            WHERE m.mar_estado =  '0'
            AND m.mar_id = t.mar_id
            AND t.tip_id =".$tip_id." AND m.mar_id =".$mar_id."
            ORDER BY m.mar_descripcion";
} else {
    $sql = "SELECT distinct m.*
            FROM marcas m,marcas_tipos_prod t
            WHERE m.mar_estado =  '0'
            AND m.mar_id = t.mar_id
            AND t.tip_id =".$tip_id."
            ORDER BY m.mar_descripcion";
}
return $sql;
//    $sql = "SELECT m.*
//            FROM marcas m
//            WHERE m.mar_estado =  '0'
//            AND exists (select 0 from marcas_tipos_prod t
//                        where m.mar_id = t.mar_id
//                        AND t.tip_id =".$tip_id.")";
}

function getmarcasComboTodos($mar_id=0) {
    $link=Conectarse();
    $html = "";
    $sql="select mar_descripcion, mar_id
        from marcas
        where mar_estado = 0
        order by mar_descripcion";
    $consulta= mysql_query($sql, $link);
    $html = "<select name='marcas' id='marcas' class='formFields'  onChange='cargaContenido(this.id)'>";
    if ($mar_id==0){
        $html = $html . '<option value="0" selected>TODOS</option>';
    } else {
        $html = $html . '<option value="0" >TODOS</option>';
    }
    while($row= mysql_fetch_assoc($consulta)) {
        if ($mar_id==$row["mar_id"]){
            $html = $html . '<option value='.$row["mar_id"].' selected>'.$row["mar_descripcion"].'</option>';
        } else {
            $html = $html . '<option value='.$row["mar_id"].'>'.$row["mar_descripcion"].'</option>';
        }
    }
    $html = $html . '</select>';
    return $html;
}
function getmarcasxTipIdCombo($tip_id=0,$mar_id=0) {
    $link=Conectarse();
    $html = "";
    $sql="
    select 'Seleccionar..' as mar_descripcion, 0 as mar_id, 0 as orden 
    union
    select distinct m.mar_descripcion, m.mar_id, 1 as orden
        from marcas m, marcas_tipos_prod t
        where t.mtp_estado = 0
        and m.mar_id=t.mar_id
        and (t.tip_id = ".$tip_id." or ".$tip_id." = 0) 
        order by 3, 1";
    $consulta= mysql_query($sql, $link);
    $html = "<select name='marcas' id='marcas' class='formFields'  onChange='cargaContenido(this.id,\"".$tip_id."\")'>";
    while($row= mysql_fetch_assoc($consulta)) {
        if ($mar_id==$row["mar_id"]){
            $html = $html . '<option value='.$row["mar_id"].' selected>'.$row["mar_descripcion"].'</option>';
        } else {
            $html = $html . '<option value='.$row["mar_id"].'>'.$row["mar_descripcion"].'</option>';
        }
    }
    $html = $html . '</select>';
    return $html;
    //return $sql;
}
function getmarcasxTipIdComboNulo($tip_id=0,$mar_id=0) {
    $link=Conectarse();
    $html = "";
    $sql="(select distinct m.mar_descripcion, m.mar_id
        from marcas m, marcas_tipos_prod t
        where t.mtp_estado = 0
        and m.mar_estado = 0
        and m.mar_id=t.mar_id
        and t.tip_id = ".$tip_id.")
        union
        (select ' ' mar_descripcion, '0' mar_id
        from dual)
        order by mar_descripcion";
    $consulta= mysql_query($sql, $link);
    $html = "<select name='marcas' id='marcas' class='formFields'  onChange='cargaContenido(this.id,\"".$tip_id."\")'>";
    while($row= mysql_fetch_assoc($consulta)) {
        if ($mar_id==$row["mar_id"]){
            $html = $html . '<option value='.$row["mar_id"].' selected>'.$row["mar_descripcion"].'</option>';
        } else {
            $html = $html . '<option value='.$row["mar_id"].'>'.$row["mar_descripcion"].'</option>';
        }
    }
    $html = $html . '</select>';
    return $html;
}
function getmarcasxTipIdComboNuloyMarId($tip_id=0,$mar_id=0) {
    $link=Conectarse();
    $html = "";
    if ($tip_id==0 and $mar_id==0){
    $sql="(select distinct m.mar_descripcion, m.mar_id
        from marcas m, marcas_tipos_prod t
        where t.mtp_estado = 0
        and m.mar_estado = 0
        and m.mar_id=t.mar_id)
        union
        (select 'TODOS' mar_descripcion, '0' mar_id
        from dual)
        order by mar_descripcion";
    } else if ($mar_id=='' or $mar_id=='0'){
    $sql="(select distinct m.mar_descripcion, m.mar_id
        from marcas m, marcas_tipos_prod t
        where t.mtp_estado = 0
        and m.mar_estado = 0
        and m.mar_id=t.mar_id
        and t.tip_id = ".$tip_id.")
        union
        (select 'TODOS' mar_descripcion, '0' mar_id
        from dual)
        order by mar_descripcion";
        
    } else {
    $sql="(select distinct m.mar_descripcion, m.mar_id
        from marcas m, marcas_tipos_prod t
        where t.mtp_estado = 0
        and m.mar_estado = 0
        and m.mar_id=t.mar_id
        and t.tip_id = ".$tip_id.")
        union
        (select 'TODOS' mar_descripcion, '0' mar_id
        from dual)
        order by mar_descripcion";
    }
        /*and m.mar_id = ".$mar_id."*/
    $consulta= mysql_query($sql, $link);
    $html = "<select name='marcas' id='marcas' class='formFields'  onChange='cargaContenido(this.id,\"".$tip_id."\")'>";
    while($row= mysql_fetch_assoc($consulta)) {
        if ($mar_id==$row["mar_id"]){
            $html = $html . '<option value='.$row["mar_id"].' selected>'.$row["mar_descripcion"].'</option>';
        } else {
            $html = $html . '<option value='.$row["mar_id"].'>'.$row["mar_descripcion"].'</option>';
        }
    }
    $html = $html . '</select>';
    return $html;

}
//function getmarcas_vehiculoCombo($mar_id=0) {
//    $link=Conectarse();
//    $html = "";
//    $sql="select m.mar_descripcion, m.mar_id
//        from marcas m, marcas_tipos_prod t
//        where t.mtp_estado = 0
//        and m.mar_id=t.mar_id
//        and t.tip_id = 1
//        order by m.mar_descripcion";
//    $consulta= mysql_query($sql, $link);
//    $html = "<select name='marcas' id='marcas' class='formFields'  onChange='cargaContenido(this.id)'>";
//    while($row= mysql_fetch_assoc($consulta)) {
//        if ($mar_id==$row["mar_id"]){
//            $html = $html . '<option value='.$row["mar_id"].' selected>'.$row["mar_descripcion"].'</option>';
//        } else {
//            $html = $html . '<option value='.$row["mar_id"].'>'.$row["mar_descripcion"].'</option>';
//        }
//    }
//    $html = $html . '</select>';
//    return $html;
//}
function getmarcasxTipIdComboNeumaticoNulo($tip_id=0,$mar_id=0) {
    $link=Conectarse();
    $html = "";
    $sql="(select distinct m.mar_descripcion, m.mar_id
        from marcas m, marcas_tipos_prod t
        where t.mtp_estado = 0
        and m.mar_id=t.mar_id
        and t.tip_id = ".$tip_id.")
        union
        (select ' ' mar_descripcion, '0' mar_id
        from dual)
        order by mar_descripcion";
    $consulta= mysql_query($sql, $link);
    $html = "<select name='marcas_neumatico' id='marcas_neumatico' class='formFields'  onChange='cargaContenidoNeumatico(this.id,\"".$tip_id."\")'>";
    while($row= mysql_fetch_assoc($consulta)) {
        if ($mar_id==$row["mar_id"]){
            $html = $html . '<option value='.$row["mar_id"].' selected>'.$row["mar_descripcion"].'</option>';
        } else {
            $html = $html . '<option value='.$row["mar_id"].'>'.$row["mar_descripcion"].'</option>';
        }
    }
    $html = $html . '</select>';
    return $html;
}
function getmarcas_llantaComboNulo($mar_id=0) {
    $link=Conectarse();
    $html = "";
    $sql="(select distinct m.mar_descripcion, m.mar_id
        from marcas m, marcas_tipos_prod t
        where t.mtp_estado = 0
        and m.mar_id=t.mar_id
        and t.tip_id in (2,3,9))
        union
        (select ' ' mar_descripcion, '0' mar_id
        from dual)
        order by mar_descripcion";
    $consulta= mysql_query($sql, $link);
    $html = "<select name='marcas_llanta' id='marcas_llanta' class='formFields'  onChange='cargaContenidoLlanta(this.id)'>";
    while($row= mysql_fetch_assoc($consulta)) {
        if ($mar_id==$row["mar_id"]){
            $html = $html . '<option value='.$row["mar_id"].' selected>'.$row["mar_descripcion"].'</option>';
        } else {
            $html = $html . '<option value='.$row["mar_id"].'>'.$row["mar_descripcion"].'</option>';
        }
    }
    $html = $html . '</select>';
    return $html;
}
function getmarcasComboNuloTodos($mar_id=0, $deshabilitado='N') {
    $link=Conectarse();
    $html = "";
    $sql="(select distinct mar_descripcion, mar_id
        from marcas
        where mar_estado = 0)
        union
        (select ' ' mar_descripcion, '0' mar_id
        from dual)
        order by mar_descripcion";
    $consulta= mysql_query($sql, $link);
    if ($deshabilitado=='S'){
        $html = "<select name='marcas' id='marcas' class='formFields' disabled='disabled' >";
    } else {
        $html = "<select name='marcas' id='marcas' class='formFields' onChange='cargaContenido(this.id)'>";
    }
    while($row= mysql_fetch_assoc($consulta)) {
        if ($mar_id==$row["mar_id"]){
            $html = $html . '<option value='.$row["mar_id"].' selected>'.$row["mar_descripcion"].'</option>';
        } else {
            $html = $html . '<option value='.$row["mar_id"].'>'.$row["mar_descripcion"].'</option>';
        }
    }
    $html = $html . '</select>';
    return $html;
}

function get_mar_id()
{ return $this->mar_id;}
function set_mar_id($val)
{ $this->mar_id=$val;}
function get_mar_descripcion()
{ return $this->mar_descripcion;}
function set_mar_descripcion($val)
{ $this->mar_descripcion=$val;}
function get_mar_estado()
{ return $this->mar_estado;}
function set_mar_estado($val)
{ $this->mar_estado=$val;}
function get_usu_id()
{ return $this->usu_id;}
function set_usu_id($val)
{ $this->usu_id=$val;}
}
?>