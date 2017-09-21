<?php
class vehiculos {

var $veh_id;
var $mod_id;
var $mar_id;
var $cli_id;
var $veh_neumaticos;
var $veh_llantas;
var $veh_patente;
var $veh_rodado;
var $veh_f_ult_cambio_rodado;
var $neumatico_mod_id;
var $neumatico_mar_id;
var $veh_neumatico_medida;
var $llanta_mod_id;
var $llanta_mar_id;
var $veh_llanta_medida;
var $veh_km;
var $veh_fotos;
var $veh_distribucion;
var $usu_id;


function vehiculos($veh_id=0) {
if ($veh_id!=0) {
$link=Conectarse();
$consulta= mysql_query(' select * from vehiculos where veh_id = '.$veh_id,$link);
while($row= mysql_fetch_assoc($consulta)) {
$this->veh_id=$row['veh_id'];
$this->mod_id=$row['mod_id'];
$this->mar_id=$row['mar_id'];
$this->cli_id=$row['cli_id'];
$this->veh_neumaticos=$row['veh_neumaticos'];
$this->veh_llantas=$row['veh_llantas'];
$this->veh_patente=$row['veh_patente'];
$this->veh_rodado=$row['veh_rodado'];
$this->veh_f_ult_cambio_rodado=$row['veh_f_ult_cambio_rodado'];
$this->neumatico_mod_id=$row['neumatico_mod_id'];
$this->neumatico_mar_id=$row['neumatico_mar_id'];
$this->veh_neumatico_medida=$row['veh_neumatico_medida'];
$this->llanta_mod_id=$row['llanta_mod_id'];
$this->llanta_mar_id=$row['llanta_mar_id'];
$this->veh_llanta_medida=$row['veh_llanta_medida'];
$this->veh_km=$row['veh_km'];
$this->veh_fotos=$row['veh_fotos'];
$this->veh_distribucion=$row['veh_distribucion'];
$this->usu_id=$row['usu_id'];
}
}
}
function insert_veh() {
$link=Conectarse();
$sql="insert into vehiculos (
 mod_id
, mar_id
, cli_id
, veh_neumaticos
, veh_llantas
, veh_patente
, veh_rodado
, veh_f_ult_cambio_rodado
, neumatico_mod_id
, neumatico_mar_id
, veh_neumatico_medida
, llanta_mod_id
, llanta_mar_id
, veh_llanta_medida
, veh_km
, veh_fotos
, veh_distribucion
, usu_id
) values ( 
 '$this->mod_id'
, '$this->mar_id'
, '$this->cli_id'
, '$this->veh_neumaticos'
, '$this->veh_llantas'
, '$this->veh_patente'
, '$this->veh_rodado'
, '$this->veh_f_ult_cambio_rodado'
, '$this->neumatico_mod_id'
, '$this->neumatico_mar_id'
, '$this->veh_neumatico_medida'
, '$this->llanta_mod_id'
, '$this->llanta_mar_id'
, '$this->veh_llanta_medida'
, '$this->veh_km'
, '$this->veh_fotos'
, '$this->veh_distribucion'
, '".$_SESSION["usu_id"]."'
)";
$result=mysql_query($sql,$link);
$ins_id = mysql_insert_id();
if ($ins_id>0){
    $sql1="INSERT INTO hvehiculos
        (tipo, veh_id, mod_id, mar_id, cli_id, veh_neumaticos
        , veh_llantas, veh_patente, veh_rodado, veh_f_ult_cambio_rodado
        , neumatico_mod_id, neumatico_mar_id, veh_neumatico_medida
        , llanta_mod_id, llanta_mar_id, veh_llanta_medida, veh_km
        , veh_fotos, veh_distribucion, veh_estado, usu_id)
        VALUES
        ('I', $ins_id, '$this->mod_id', '$this->mar_id', '$this->cli_id', '$this->veh_neumaticos'
        , '$this->veh_llantas', '$this->veh_patente', '$this->veh_rodado', '$this->veh_f_ult_cambio_rodado'
        , '$this->neumatico_mod_id', '$this->neumatico_mar_id', '$this->veh_neumatico_medida'
        , '$this->llanta_mod_id', '$this->llanta_mar_id', '$this->veh_llanta_medida', '$this->veh_km'
        , '$this->veh_fotos', '$this->veh_distribucion', 0, '".$_SESSION["usu_id"]."')";
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
function update_veh() {
$link=Conectarse();
$sql="INSERT INTO hvehiculos
     (tipo, veh_id, mod_id, mar_id, cli_id, veh_neumaticos
        , veh_llantas, veh_patente, veh_rodado, veh_f_ult_cambio_rodado
        , neumatico_mod_id, neumatico_mar_id, veh_neumatico_medida
        , llanta_mod_id, llanta_mar_id, veh_llanta_medida, veh_km
        , veh_fotos, veh_distribucion, veh_estado, usu_id)
     SELECT
        'U', veh_id, mod_id, mar_id, cli_id, veh_neumaticos
        , veh_llantas, veh_patente, veh_rodado, veh_f_ult_cambio_rodado
        , neumatico_mod_id, neumatico_mar_id, veh_neumatico_medida
        , llanta_mod_id, llanta_mar_id, veh_llanta_medida, veh_km
        , veh_fotos, veh_distribucion, veh_estado, '".$_SESSION["usu_id"]."'
     FROM vehiculos
     WHERE veh_id= '$this->veh_id'";
$result=mysql_query($sql,$link);
if ($result>0){
    $sql1="update vehiculos set
     mod_id = '$this->mod_id'
    , mar_id = '$this->mar_id'
    , cli_id = '$this->cli_id'
    , veh_neumaticos = '$this->veh_neumaticos'
    , veh_llantas = '$this->veh_llantas'
    , veh_patente = '$this->veh_patente'
    , veh_rodado = '$this->veh_rodado'
    , veh_f_ult_cambio_rodado = '$this->veh_f_ult_cambio_rodado'
    , neumatico_mod_id = '$this->neumatico_mod_id'
    , neumatico_mar_id = '$this->neumatico_mar_id'
    , veh_neumatico_medida = '$this->veh_neumatico_medida'
    , llanta_mod_id = '$this->llanta_mod_id'
    , llanta_mar_id = '$this->llanta_mar_id'
    , veh_llanta_medida = '$this->veh_llanta_medida'
    , veh_km = '$this->veh_km'
    , veh_fotos = '$this->veh_fotos'
    , veh_distribucion = '$this->veh_distribucion'
    , usu_id = '".$_SESSION["usu_id"]."'
    where veh_id = '$this->veh_id'";
    $result1=mysql_query($sql1,$link);
    if ($result1>0){
        return 1;
    }else {
        return 0;}
} else {
return 0;
}
}
function baja_veh(){
    $link=Conectarse();
    $sql="INSERT INTO hvehiculos
         (tipo, veh_id, mod_id, mar_id, cli_id, veh_neumaticos
        , veh_llantas, veh_patente, veh_rodado, veh_f_ult_cambio_rodado
        , neumatico_mod_id, neumatico_mar_id, veh_neumatico_medida
        , llanta_mod_id, llanta_mar_id, veh_llanta_medida, veh_km
        , veh_fotos, veh_distribucion, veh_estado, usu_id)
         SELECT
            'B', veh_id, mod_id, mar_id, cli_id, veh_neumaticos
            , veh_llantas, veh_patente, veh_rodado, veh_f_ult_cambio_rodado
            , neumatico_mod_id, neumatico_mar_id, veh_neumatico_medida
            , llanta_mod_id, llanta_mar_id, veh_llanta_medida, veh_km
            , veh_fotos, veh_distribucion, veh_estado, '".$_SESSION["usu_id"]."'
         FROM vehiculos
         WHERE veh_id= '$this->veh_id'";
    $result=mysql_query($sql,$link);
    if ($result>0){
        $sql1="update vehiculos set veh_estado = '1', usu_id = '".$_SESSION["usu_id"].
                 "' where veh_id = '$this->veh_id'";
    $result1=mysql_query($sql1,$link);
    if ($result1>0){
        return 1;
    }else {
        return 0;}
} else {
    return 0;
}
}
function getvehiculos()
{
$link=Conectarse();
$sql="select * from vehiculos where veh_estado='0'";
$result=mysql_query($sql,$link);
return $result;
}
function getvehiculosDes()
{
$link=Conectarse();
$sql="select * from vehiculos where veh_estado='1'";
$result=mysql_query($sql,$link);
return $result;
}
function getvehiculosSQL($cli_id=0,$mar_id=0,$mod_id=0)
{
    $link=Conectarse();
    if ($mod_id!=0) {
        $sql="select p.*,a.mar_descripcion,o.mod_descripcion,c.cli_nombre,cli_apellido,cli_razon_social
              from vehiculos p, marcas a, modelos o, clientes c
              where p.mar_id=a.mar_id and p.mod_id=o.mod_id and c.cli_id=p.cli_id
              and veh_estado='0' and p.mod_id = '$mod_id' and p.cli_id = '$cli_id'";
    } elseif ($mar_id!=0) {
        $sql="select p.*,a.mar_descripcion,o.mod_descripcion,c.cli_nombre,cli_apellido,cli_razon_social
              from vehiculos p, marcas a, modelos o, clientes c
              where p.mar_id=a.mar_id and p.mod_id=o.mod_id and c.cli_id=p.cli_id
              and veh_estado='0' and p.mar_id = '$mar_id' and p.cli_id = '$cli_id'";
    } else {
        $sql="select p.*,a.mar_descripcion,o.mod_descripcion,c.cli_nombre,cli_apellido,cli_razon_social
              from vehiculos p, marcas a, modelos o, clientes c
              where p.mar_id=a.mar_id and p.mod_id=o.mod_id and c.cli_id=p.cli_id
              and veh_estado='0' and p.cli_id = '$cli_id'";
    }
    return $sql;
}
function getvehiculosSQLCFiltro($cli_id = "",$veh_id = "", $mar_descripcion = "", $mod_descripcion = "", $veh_patente = "", $veh_km = "")
{
$link=Conectarse();
$sql="select v.*, a.mar_descripcion, o.mod_descripcion,c.cli_nombre,cli_apellido,cli_razon_social
        from vehiculos v, marcas a, modelos o, clientes c
        where v.mar_id=a.mar_id and v.mod_id=o.mod_id and c.cli_id=v.cli_id and v.veh_estado='0' ";
if ($cli_id != "") { $sql = $sql . " and v.cli_id = " . $cli_id;}
if ($veh_id != "") { $sql = $sql . " and v.veh_id = " . $veh_id;}
if ($mar_descripcion != "") { $sql = $sql . " and a.mar_descripcion like ('" . $mar_descripcion ."') ";}
if ($mod_descripcion != "") { $sql = $sql . " and o.mod_descripcion like ('" . $mod_descripcion ."') ";}
if ($veh_patente != "") { $sql = $sql . " and v.veh_patente like ('" . $veh_patente ."') ";}
if ($veh_km != "") { $sql = $sql . " and v.veh_km = ('" . $veh_km ."') ";}

return $sql;
}
function getvehiculosComboNulo($veh_id=0) {
    $link=Conectarse();
    $html = "";
    $sql="(select a.mar_descripcion, concat(IFNULL(o.mod_descripcion,' '),' ',IFNULL(v.veh_patente,' ')
        ,' ',IFNULL(v.veh_neumaticos,' '),' ',IFNULL(veh_llantas,' ')) as mod_descripcion, v.veh_id
        from vehiculos v, marcas a, modelos o
        where v.veh_estado = 0
        and v.mar_id=a.mar_id
        and v.mod_id=o.mod_id)
        union
        (select ' ' mar_descripcion, ' ' mod_descripcion, '0' veh_id
        from dual)
        order by mar_descripcion, mod_descripcion";
    $consulta= mysql_query($sql, $link);
    $html = "<select name='vehiculos' id='vehiculos' class='formFields' >";
    while($row= mysql_fetch_assoc($consulta)) {
        if ($veh_id==$row["veh_id"]){
            $html = $html . '<option value='.$row["veh_id"].' selected>'.$row["mod_descripcion"].'</option>';
        } else {
            $html = $html . '<option value='.$row["veh_id"].'>'.$row["mod_descripcion"].'</option>';
        }
    }
    $html = $html . '</select>';
    return $html;
}
function getvehiculosComboNuloxCliId($cli_id=0,$veh_id=0) {
    $link=Conectarse();
    $html = "";
    $sql="select a.mar_descripcion, concat(IFNULL(o.mod_descripcion,' '),' ',IFNULL(v.veh_patente,' ')
        ,' ',IFNULL(v.veh_neumaticos,' '),' ',IFNULL(veh_llantas,' ')) as mod_descripcion, v.veh_id
        from vehiculos v, marcas a, modelos o
        where v.veh_estado = 0
        and v.mar_id=a.mar_id
        and v.mod_id=o.mod_id
        and v.cli_id = ".$cli_id."
        union
        select ' ' mar_descripcion, ' ' mod_descripcion, '0' veh_id
        order by mar_descripcion, mod_descripcion";
//from dual
    $consulta= mysql_query($sql, $link);
    $html = "<select name='vehiculos' id='vehiculos' class='formFields' >";
    while($row= mysql_fetch_assoc($consulta)) {
        if ($veh_id==$row["veh_id"]){
            $html = $html . '<option value='.$row["veh_id"].' selected>'.$row["mod_descripcion"].'</option>';
        } else {
            $html = $html . '<option value='.$row["veh_id"].'>'.$row["mod_descripcion"].'</option>';
        }
    }
    $html = $html . '</select>';
    return $html;
}
function getvehiculosCombo_OT($cli_id=0,$mar_id=0,$mod_id=0,$veh_patente='',$veh_km='') {
    $link=Conectarse();
    $html = "";
    $sql="select a.mar_descripcion, concat(o.mod_descripcion,' ',veh_patente,' ',veh_neumaticos
        ,' ',veh_llantas) as mod_descripcion, v.veh_id
        from vehiculos v, marcas a, modelos o
        where v.veh_estado = 0
        and v.mar_id=a.mar_id
        and v.mod_id=o.mod_id
        and v.cli_id = '$cli_id'";
    if ($mar_id!=0) {
        $sql.=" and v.mar_id = ".$mar_id;
    }
    if ($mod_id!=0) {
        $sql.=" and v.mod_id = ".$mod_id;
    }
    if ($veh_patente!='') {
        $sql.=" and upper(v.veh_patente) like '%".strtoupper($veh_patente)."%'";
    }
    if ($veh_km!='') {
        $sql.=" and upper(v.veh_km) like '%".strtoupper($veh_km)."%'";
    }
    $sql.=" order by mar_descripcion, mod_descripcion";
    $consulta= mysql_query($sql, $link);
    $html = "<select name='vehiculos' id='vehiculos' class='formFields' >";
    //if ($consulta){
      while($row= mysql_fetch_assoc($consulta)) {
        if ($veh_id==$row["veh_id"]){
            $html = $html . '<option value='.$row["veh_id"].' selected>'.$row["mod_descripcion"].'</option>';
        } else {
            $html = $html . '<option value='.$row["veh_id"].'>'.$row["mod_descripcion"].'</option>';
        }
      }
    //}
    $html = $html . '</select>';
    return $html;
}



function get_veh_distribucion()
{ return $this->veh_distribucion;}
function set_veh_distribucion($val)
{ $this->veh_distribucion=$val;}

function get_veh_id()
{ return $this->veh_id;}
function set_veh_id($val)
{ $this->veh_id=$val;}
function get_mod_id()
{ return $this->mod_id;}
function set_mod_id($val)
{ $this->mod_id=$val;}
function get_mar_id()
{ return $this->mar_id;}
function set_mar_id($val)
{ $this->mar_id=$val;}
function get_cli_id()
{ return $this->cli_id;}
function set_cli_id($val)
{ $this->cli_id=$val;}
function get_veh_neumaticos()
{ return $this->veh_neumaticos;}
function set_veh_neumaticos($val)
{ $this->veh_neumaticos=$val;}
function get_veh_llantas()
{ return $this->veh_llantas;}
function set_veh_llantas($val)
{ $this->veh_llantas=$val;}
function get_veh_patente()
{ return $this->veh_patente;}
function set_veh_patente($val)
{ $this->veh_patente=$val;}
function get_veh_rodado()
{ return $this->veh_rodado;}
function set_veh_rodado($val)
{ $this->veh_rodado=$val;}
function get_veh_f_ult_cambio_rodado()
{ return $this->veh_f_ult_cambio_rodado;}
function set_veh_f_ult_cambio_rodado($val)
{ $this->veh_f_ult_cambio_rodado=$val;}
function get_veh_estado()
{ return $this->veh_estado;}
function set_veh_estado($val)
{ $this->veh_estado=$val;}
function get_neumatico_mod_id()
{ return $this->neumatico_mod_id;}
function set_neumatico_mod_id($val)
{ $this->neumatico_mod_id=$val;}
function get_neumatico_mar_id()
{ return $this->neumatico_mar_id;}
function set_neumatico_mar_id($val)
{ $this->neumatico_mar_id=$val;}
function get_veh_neumatico_medida()
{ return $this->veh_neumatico_medida;}
function set_veh_neumatico_medida($val)
{ $this->veh_neumatico_medida=$val;}
function get_llanta_mod_id()
{ return $this->llanta_mod_id;}
function set_llanta_mod_id($val)
{ $this->llanta_mod_id=$val;}
function get_llanta_mar_id()
{ return $this->llanta_mar_id;}
function set_llanta_mar_id($val)
{ $this->llanta_mar_id=$val;}
function get_veh_llanta_medida()
{ return $this->veh_llanta_medida;}
function set_veh_llanta_medida($val)
{ $this->veh_llanta_medida=$val;}
function get_veh_km()
{ return $this->veh_km;}
function set_veh_km($val)
{ $this->veh_km=$val;}
function get_veh_fotos()
{ return $this->veh_fotos;}
function set_veh_fotos($val)
{ $this->veh_fotos=$val;}
function get_usu_id()
{ return $this->usu_id;}
function set_usu_id($val)
{ $this->usu_id=$val;}
}
?>