<?php
class modelos {

var $mod_id;
var $mar_id;
var $mod_descripcion;
var $mod_estado;
var $usu_id;


function modelos($mod_id=0) {
if ($mod_id!=0) {
$link=Conectarse();
$consulta= mysql_query(' select * from modelos where mod_id = '.$mod_id,$link);
while($row= mysql_fetch_assoc($consulta)) {
$this->mod_id=$row['mod_id'];
$this->mar_id=$row['mar_id'];
$this->mod_descripcion=$row['mod_descripcion'];
$this->mod_estado=$row['mod_estado'];
$this->usu_id=$row['usu_id'];
}
}
}
function insert_mod() {
    $link=Conectarse();
    $sql="insert into modelos (
     mar_id
    , mod_descripcion
    , usu_id
    ) values (
     '$this->mar_id'
    , '$this->mod_descripcion'
    , '".$_SESSION["usu_id"]."'
    )";
    $result=mysql_query($sql,$link);
    $ultimo_id = mysql_insert_id($link);
    if ($ultimo_id>0){
        $sql1="INSERT INTO hmodelos
            (tipo, mod_id, mar_id, mod_descripcion, mod_estado, usu_id)
            VALUES
            ('I', $ultimo_id, '$this->mar_id', '$this->mod_descripcion', 0, '".$_SESSION["usu_id"]."')";
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
function update_mod() {
$link=Conectarse();
$sql="INSERT INTO hmodelos
     (tipo, mod_id, mar_id, mod_descripcion, mod_estado, usu_id)
     SELECT
        'U', mod_id, mar_id, mod_descripcion, mod_estado, '".$_SESSION["usu_id"]."'
     FROM modelos
     WHERE mod_id= '$this->mod_id'";
    $result=mysql_query($sql,$link);
    if ($result>0){
        $sql1="update modelos set
            mod_id = '$this->mod_id'
            , mar_id = '$this->mar_id'
            , mod_descripcion = '$this->mod_descripcion'
            , mod_estado = '$this->mod_estado'
            , usu_id = '".$_SESSION["usu_id"]."'
            where mod_id = '$this->mod_id'";
    $result1=mysql_query($sql1,$link);
    if ($result1>0){
        return 1;
    }else {
        return 0;}
    } else {
        return 0;
    }
}
function baja_mod(){
    $link=Conectarse();
    $sql2="select 0 from marcas_tipos_prod where mtp_estado='0' and mod_id = '$this->mod_id'";
    $result2=mysql_query($sql2,$link);
    if ($row = mysql_fetch_array($result2)){
      $result2 = 0;
    } else {$result2 = 2;
    }
    $sql3="select 0 from productos where pro_estado='0' and mod_id = '$this->mod_id'";
    $result3=mysql_query($sql3,$link);
    if ($row = mysql_fetch_array($result3)){
      $result3 = 0;
    } else {$result3 = 3;
    }
    $sql4="select 0 from vehiculos where veh_estado='0' and mod_id = '$this->mod_id'";
    $result4=mysql_query($sql4,$link);
    if ($row = mysql_fetch_array($result4)){
      $result4 = 0;
    } else {$result4 = 4;
    }
    if ($result2>0 and $result3>0 and $result4>0){
        $sql="INSERT INTO hmodelos
         (tipo, mod_id, mar_id, mod_descripcion, mod_estado, usu_id)
         SELECT
            'B', mod_id, mar_id, mod_descripcion, mod_estado, '".$_SESSION["usu_id"]."'
         FROM modelos
         WHERE mod_id= '$this->mod_id'";
        $result=mysql_query($sql,$link);
        if ($result>0){
            $sql1="update modelos set mod_estado = '1', usu_id = '".$_SESSION["usu_id"].
                         "' where mod_id = '$this->mod_id'";
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
function getmodelos($mod_id=0)
{
    $link=Conectarse();
    if ($mod_id!=0) {
        $sql="select * from modelos g where g.mod_estado=0 and g.mod_id =".$mod_id." order by g.mod_descripcion";
    } else {
        $sql="select * from modelos where mod_estado='0'";
    }
    $result=mysql_query($sql,$link);
    return $result;
}
function getmodelosDes()
{
$link=Conectarse();
$sql="select * from modelos where mod_estado='1'";
$result=mysql_query($sql,$link);
return $result;
}
function getmodelosSQL(/*$tip_id=0,*/$mar_id=0)
{
$link=Conectarse();
if (/*$tip_id==0 and */$mar_id==0) {
    $sql="select o.mod_id, o.mod_descripcion, o.mod_estado, a.mar_id, a.mar_descripcion, a.mar_estado
        from modelos o,marcas a
        where o.mar_id=a.mar_id and o.mod_estado='0'
        order by a.mar_descripcion, o.mod_descripcion";
} elseif (/*$tip_id==0 and */$mar_id!=0) {
    $sql="select o.*,a.* from modelos o,marcas a
        where o.mar_id=a.mar_id and o.mod_estado='0'
        and o.mar_id = ".$mar_id."
        order by a.mar_descripcion, o.mod_descripcion";
}
return $sql;
}
function getmodelosSQLxTipId($tip_id=0,$mar_id=0)
{
$link=Conectarse();
if ($tip_id==0 and $mar_id==0) {
    $sql="select o.*,a.mar_descripcion
        from modelos o,marcas a
        where o.mar_id=a.mar_id and o.mod_estado='0' and a.mar_estado='0'
        order by a.mar_descripcion, o.mod_descripcion";
} elseif ($tip_id==0 and $mar_id!=0) {
    $sql="select o.*,a.mar_descripcion from modelos o,marcas a
        where o.mar_id=a.mar_id and o.mod_estado='0' and a.mar_estado='0'
        and o.mar_id = ".$mar_id."
        order by a.mar_descripcion, o.mod_descripcion";
} elseif ($tip_id!=0 and $mar_id!=0) {
    $sql="select o.*,a.mar_descripcion
        from modelos o,marcas a,marcas_tipos_prod p
        where o.mar_id=a.mar_id and o.mod_estado='0' and a.mar_estado='0'
        and a.mar_id=p.mar_id and o.mod_id=p.mod_id and p.mtp_estado='0'
        and p.tip_id = ".$tip_id." and o.mar_id = ".$mar_id."
        order by a.mar_descripcion, o.mod_descripcion";
} else {
    $sql="select o.*,a.mar_descripcion
        from modelos o,marcas a,marcas_tipos_prod p
        where o.mar_id=a.mar_id and o.mod_estado='0' and o.mod_id=p.mod_id
        and a.mar_id=p.mar_id and a.mar_estado='0' and p.mtp_estado='0'
        and p.tip_id = ".$tip_id."
        order by a.mar_descripcion, o.mod_descripcion";
}
return $sql;
/*select o.*,a.*,t.*
        from modelos o,marcas a,marcas_tipos_prod p, tipo_productos t
        where o.mar_id=a.mar_id and o.mod_estado='0' and t.tip_id=p.tip_id
        and a.mar_id=p.mar_id
        and t.tip_id = ".$tip_id."
        group by t.tip_id, a.mar_id, o.mod_id
        order by t.tip_descripcion, a.mar_descripcion, o.mod_descripcion";
(select t.tip_id, a.mar_id, o.mod_id
            ,max(o.mod_descripcion) mod_descripcion,max(a.mar_descripcion) mar_descripcion,max(t.tip_descripcion) tip_descripcion
        from modelos o,marcas a,marcas_tipos_prod p, tipo_productos t
        where o.mar_id=a.mar_id and o.mod_estado='0' and t.tip_id=p.tip_id
        and a.mar_id=p.mar_id
        and t.tip_id = ".$tip_id."
        group by t.tip_id, a.mar_id, o.mod_id
        order by t.tip_descripcion, a.mar_descripcion, o.mod_descripcion)
    $sql="select o.*,a.*
        from modelos o,marcas a
        where o.mar_id=a.mar_id and o.mod_estado='0'
        and exists (select 0
                    from marcas_tipos_prod p, tipo_productos t
                    where t.tip_id=p.tip_id
                    and a.mar_id=p.mar_id
                    and t.tip_id = ".$tip_id.")
        order by a.mar_descripcion, o.mod_descripcion";
*/
}
function get_select_modelos($mod_id=0) {
    $result = $this->getmodelos();
    $html = "";
    $html.= "<select name='modelos' id='modelos'>";
    if ($mod_id==0){
        $html.= "<option value=0 selected>TODOS</option>";
    } else {
        $html.= "<option value=0 >TODOS</option>";
    }
    while($row= mysql_fetch_assoc($result)) {
        //if ($mod_id!='') {
            if ($row['mod_id'] == $mod_id) {
                $html.= "<option value=".$row['mod_id']." selected>".$row['mod_descripcion']."</option>";
            } else {
                $html.= "<option value=".$row['mod_id'].">".$row['mod_descripcion']."</option>";
            }
        /*} else {
            $html.= "<option value=".$row['mod_id'].">".$row['mod_descripcion']."</option>";
        }*/
    }
    $html.= "</select>";
    return $html;
}
function get_modelosComboxTipIdNulo($tip_id='',$mod_id='') {
    $link=Conectarse();
    $html = "";
    $sql="(select m.mod_descripcion, m.mod_id
        from modelos m, marcas_tipos_prod t
        where t.mtp_estado = 0
        and m.mod_estado = 0
        and m.mod_id=t.mod_id
        and t.tip_id = ".$tip_id.")
        union
        (select ' ' mod_descripcion, '0' mod_id
        from dual)
        order by mod_descripcion";
    $consulta= mysql_query($sql, $link);
    $html.= "<select name='modelos' id='modelos'>";
    while($row= mysql_fetch_assoc($consulta)) {
        if ($mod_id!='') {
            if ($row['mod_id'] == $mod_id) {
                $html.= "<option value=".$row['mod_id']." selected>".$row['mod_descripcion']."</option>";
            } else {
                $html.= "<option value=".$row['mod_id'].">".$row['mod_descripcion']."</option>";
            }
        } else {
            $html.= "<option value=".$row['mod_id'].">".$row['mod_descripcion']."</option>";
        }
    }
    $html.= "</select>";
    return $html;
}
function get_modelosComboxTipId($tip_id='',$mod_id='') {
    $link=Conectarse();
    $html = "";
    $sql="select distinct m.mod_descripcion, m.mod_id, 1 orden
        from modelos m, marcas_tipos_prod t
        where t.mtp_estado = 0
        and m.mod_estado = 0
        and m.mod_id=t.mod_id
        and t.tip_id = ".$tip_id."
        union
        select 'TODOS' mod_descripcion, '0' mod_id, 0 orden
        order by orden, mod_descripcion";
//        from dual)

    $consulta= mysql_query($sql, $link);
    $html.= "<select name='modelos' id='modelos'>";
    while($row= mysql_fetch_assoc($consulta)) {
        if ($mod_id!='') {
            if ($row['mod_id'] == $mod_id) {
                $html.= "<option value=".$row['mod_id']." selected>".$row['mod_descripcion']."</option>";
            } else {
                $html.= "<option value=".$row['mod_id'].">".$row['mod_descripcion']."</option>";
            }
        } else {
            $html.= "<option value=".$row['mod_id'].">".$row['mod_descripcion']."</option>";
        }
    }
    $html.= "</select>";
    return $html;
}
function get_modelosComboxTipIdyMarId($tip_id='',$mar_id='',$mod_id='') {
    $link=Conectarse();
    $html = "";
    if ($mar_id=='' or $mar_id=='0'){
    $sql="select distinct m.mod_descripcion, m.mod_id
        from modelos m, marcas_tipos_prod t
        where t.mtp_estado = 0
        and m.mod_estado = 0
        and m.mod_id=t.mod_id
        and t.tip_id = ".$tip_id."
        order by mod_descripcion";
    } else {
    $sql="select distinct m.mod_descripcion, m.mod_id
        from modelos m, marcas_tipos_prod t
        where t.mtp_estado = 0
        and m.mod_estado = 0
        and m.mod_id=t.mod_id
        and t.mar_id = ".$mar_id."
        and t.tip_id = ".$tip_id."
        order by mod_descripcion";
    }
    $consulta= mysql_query($sql, $link);
    $html.= "<select name='modelos' id='modelos'>";
    while($row= mysql_fetch_assoc($consulta)) {
        if ($mod_id!='') {
            if ($row['mod_id'] == $mod_id) {
                $html.= "<option value=".$row['mod_id']." selected>".$row['mod_descripcion']."</option>";
            } else {
                $html.= "<option value=".$row['mod_id'].">".$row['mod_descripcion']."</option>";
            }
        } else {
            $html.= "<option value=".$row['mod_id'].">".$row['mod_descripcion']."</option>";
        }
    }
    $html.= "</select>";
    return $html;
}
function get_modelosComboxTipIdNeumatico($tip_id='',$mod_id='') {
    $link=Conectarse();
    $html = "";
    $sql="select m.mod_descripcion, m.mod_id
        from modelos m, marcas_tipos_prod t
        where t.mtp_estado = 0
        and m.mod_estado = 0
        and m.mod_id=t.mod_id
        and t.tip_id = ".$tip_id."
        order by mod_descripcion";
    $consulta= mysql_query($sql, $link);
    $html.= "<select name='modelos_neumatico' id='modelos_neumatico'>";
    while($row= mysql_fetch_assoc($consulta)) {
        if ($mod_id!='') {
            if ($row['mod_id'] == $mod_id) {
                $html.= "<option value=".$row['mod_id']." selected>".$row['mod_descripcion']."</option>";
            } else {
                $html.= "<option value=".$row['mod_id'].">".$row['mod_descripcion']."</option>";
            }
        } else {
            $html.= "<option value=".$row['mod_id'].">".$row['mod_descripcion']."</option>";
        }
    }
    $html.= "</select>";
    return $html;
}
function get_select_modelosLlanta($mod_id='') {
    $link=Conectarse();
    $html = "";
    $sql="select m.mod_descripcion, m.mod_id
        from modelos m, marcas_tipos_prod t
        where t.mtp_estado = 0
        and m.mod_estado = 0
        and m.mod_id=t.mod_id
        and t.tip_id in (2,3,9)
        order by mod_descripcion";
    $html.= "<select name='modelos_llanta' id='modelos_llanta'>";
    $result= mysql_query($sql, $link);
    while($row= mysql_fetch_assoc($result)) {
        if ($mod_id!='') {
            if ($row['mod_id'] == $mod_id) {
                $html.= "<option value=".$row['mod_id']." selected>".$row['mod_descripcion']."</option>";
            } else {
                $html.= "<option value=".$row['mod_id'].">".$row['mod_descripcion']."</option>";
            }
        } else {
            $html.= "<option value=".$row['mod_id'].">".$row['mod_descripcion']."</option>";
        }
    }
    $html.= "</select>";
    return $html;
}
function get_select_modelosNuloTodos($mod_id=0, $deshabilitado='N') {
    $link=Conectarse();
    $html = "";
    $sql="(select substr(mod_descripcion,1,39) mod_descripcion, mod_id
        from modelos
        where mod_estado = 0)
        union
        (select ' ' mod_descripcion, '0' mod_id
        from dual)
        order by mod_descripcion";
    $consulta= mysql_query($sql, $link);
    if ($deshabilitado=='S'){
        $html = "<select name='modelos' id='modelos' class='formFields' disabled='disabled' >";
    } else {
        $html = "<select name='modelos' id='modelos' class='formFields' onChange='cargaContenido(this.id)'>";
    }
    while($row= mysql_fetch_assoc($consulta)) {
        if ($row['mod_id'] == $mod_id) {
            $html.= "<option value=".$row['mod_id']." selected>".$row['mod_descripcion']."</option>";
        } else {
            $html.= "<option value=".$row['mod_id'].">".$row['mod_descripcion']."</option>";
        }
    }
    $html.= "</select>";
    return $html;
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
    $sql = "SELECT distinct m.*
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

function get_mod_id()
{ return $this->mod_id;}
function set_mod_id($val)
{ $this->mod_id=$val;}
function get_mar_id()
{ return $this->mar_id;}
function set_mar_id($val)
{ $this->mar_id=$val;}
function get_mod_descripcion()
{ return $this->mod_descripcion;}
function set_mod_descripcion($val)
{ $this->mod_descripcion=$val;}
function get_mod_estado()
{ return $this->mod_estado;}
function set_mod_estado($val)
{ $this->mod_estado=$val;}
function get_usu_id()
{ return $this->usu_id;}
function set_usu_id($val)
{ $this->usu_id=$val;}
}
?>