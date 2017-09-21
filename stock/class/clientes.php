<?php
class clientes {

var $cli_id;
var $cli_nombre;
var $cli_apellido;
var $cli_razon_social;
var $cli_calle;
var $cli_numero;
var $cli_piso;
var $cli_departamento;
var $cli_codigo_postal;
var $cli_ciudad;
var $cli_provincia;
var $cli_telefono1;
var $cli_telefono2;
var $cli_fax;
var $cli_email;
var $cli_cuit;
var $cli_observaciones;
var $cli_estado;
var $cli_tipo_documento;
var $cli_numero_documento;
var $usu_id;

function clientes($cli_id=0) {
if ($cli_id!=0) {
$link=Conectarse();
$consulta= mysql_query(' select cli_id , cli_nombre , cli_apellido , cli_razon_social , cli_calle , cli_numero
    , cli_piso , cli_departamento , cli_codigo_postal , cli_ciudad , cli_provincia , cli_telefono1 , cli_telefono2
    , cli_fax , cli_email , cli_cuit , cli_observaciones,cli_estado, cli_tipo_documento, cli_numero_documento
    , usu_id from clientes where cli_id = '.$cli_id,$link);
while($row= mysql_fetch_assoc($consulta)) {
$this->cli_id=$row['cli_id'];
$this->cli_nombre=$row['cli_nombre'];
$this->cli_apellido=$row['cli_apellido'];
$this->cli_razon_social=$row['cli_razon_social'];
$this->cli_calle=$row['cli_calle'];
$this->cli_numero=$row['cli_numero'];
$this->cli_piso=$row['cli_piso'];
$this->cli_departamento=$row['cli_departamento'];
$this->cli_codigo_postal=$row['cli_codigo_postal'];
$this->cli_ciudad=$row['cli_ciudad'];
$this->cli_provincia=$row['cli_provincia'];
$this->cli_telefono1=$row['cli_telefono1'];
$this->cli_telefono2=$row['cli_telefono2'];
$this->cli_fax=$row['cli_fax'];
$this->cli_email=$row['cli_email'];
$this->cli_cuit=$row['cli_cuit'];
$this->cli_observaciones=$row['cli_observaciones'];
$this->cli_estado=$row['cli_estado'];
$this->cli_tipo_documento=$row['cli_tipo_documento'];
$this->cli_numero_documento=$row['cli_numero_documento'];
$this->usu_id=$row['usu_id'];
}
}
}
function insert_cli() {
$link=Conectarse();
$sql="insert into clientes (
 cli_nombre
, cli_apellido
, cli_razon_social
, cli_calle
, cli_numero
, cli_piso
, cli_departamento
, cli_codigo_postal
, cli_ciudad
, cli_provincia
, cli_telefono1
, cli_telefono2
, cli_fax
, cli_email
, cli_cuit
, cli_observaciones
, cli_tipo_documento
, cli_numero_documento
, usu_id
) values ( 
 '$this->cli_nombre'
, '$this->cli_apellido'
, '$this->cli_razon_social'
, '$this->cli_calle'
, '$this->cli_numero'
, '$this->cli_piso'
, '$this->cli_departamento'
, '$this->cli_codigo_postal'
, '$this->cli_ciudad'
, '$this->cli_provincia'
, '$this->cli_telefono1'
, '$this->cli_telefono2'
, '$this->cli_fax'
, '$this->cli_email'
, '$this->cli_cuit'
, '$this->cli_observaciones'
, '$this->cli_tipo_documento' 
, '$this->cli_numero_documento'
, '".$_SESSION["usu_id"]."'
)";
$result=mysql_query($sql,$link);
$ins_id = mysql_insert_id();
if ($ins_id>0){
    $sql1="INSERT INTO hclientes
        (tipo, cli_id, cli_nombre, cli_apellido, cli_razon_social, cli_calle
        , cli_numero, cli_piso, cli_departamento, cli_codigo_postal, cli_ciudad
        , cli_provincia, cli_telefono1, cli_telefono2, cli_fax, cli_email, cli_cuit
        , cli_observaciones, cli_estado, cli_tipo_documento, cli_numero_documento, usu_id)
        VALUES
        ('I', $ins_id, '$this->cli_nombre', '$this->cli_apellido'
        , '$this->cli_razon_social', '$this->cli_calle'
        , '$this->cli_numero', '$this->cli_piso', '$this->cli_departamento'
        , '$this->cli_codigo_postal', '$this->cli_ciudad'
        , '$this->cli_provincia', '$this->cli_telefono1', '$this->cli_telefono2', '$this->cli_fax'
        , '$this->cli_email', '$this->cli_cuit'
        , '$this->cli_observaciones', 0, '$this->cli_tipo_documento'
        , '$this->cli_numero_documento', '".$_SESSION["usu_id"]."')";
    $result1=mysql_query($sql1,$link);
    if ($result1>0){
        return $ins_id;
    }else {
        return 0;
    }
} else {
    return 0;
}
}
function update_cli() {
$link=Conectarse();
$sql="INSERT INTO hclientes
     (tipo, cli_id, cli_nombre, cli_apellido, cli_razon_social, cli_calle, cli_numero
     , cli_piso, cli_departamento, cli_codigo_postal, cli_ciudad, cli_provincia, cli_telefono1
     , cli_telefono2, cli_fax, cli_email, cli_cuit, cli_observaciones, cli_estado
     , cli_tipo_documento, cli_numero_documento, usu_id)
     SELECT
        'U', cli_id, cli_nombre, cli_apellido, cli_razon_social, cli_calle, cli_numero
        , cli_piso, cli_departamento, cli_codigo_postal, cli_ciudad, cli_provincia, cli_telefono1
        , cli_telefono2, cli_fax, cli_email, cli_cuit, cli_observaciones, cli_estado
        , cli_tipo_documento, cli_numero_documento, '".$_SESSION["usu_id"]."'
     FROM clientes
     WHERE cli_id= '$this->cli_id'";
$result=mysql_query($sql,$link);
if ($result>0){
    $sql1="update clientes set
        cli_id = '$this->cli_id'
        , cli_nombre = '$this->cli_nombre'
        , cli_apellido = '$this->cli_apellido'
        , cli_razon_social = '$this->cli_razon_social'
        , cli_calle = '$this->cli_calle'
        , cli_numero = '$this->cli_numero'
        , cli_piso = '$this->cli_piso'
        , cli_departamento = '$this->cli_departamento'
        , cli_codigo_postal = '$this->cli_codigo_postal'
        , cli_ciudad = '$this->cli_ciudad'
        , cli_provincia = '$this->cli_provincia'
        , cli_telefono1 = '$this->cli_telefono1'
        , cli_telefono2 = '$this->cli_telefono2'
        , cli_fax = '$this->cli_fax'
        , cli_email = '$this->cli_email'
        , cli_cuit = '$this->cli_cuit'
        , cli_observaciones = '$this->cli_observaciones'
        , cli_tipo_documento = '$this->cli_tipo_documento'
        , cli_numero_documento = '$this->cli_numero_documento'
        , usu_id = '".$_SESSION["usu_id"]."'
        where cli_id = '$this->cli_id'";
    $result1=mysql_query($sql1,$link);
    if ($result1>0){
        return 1;
    }else {
        return 0;}
} else {
    return 0;
}
}
function baja_cli(){
    $link=Conectarse();
    $sql1="select 0 from facturas_enc where cli_id = '$this->cli_id'";
    $result1=mysql_query($sql1,$link);
    if ($row = mysql_fetch_array($result1)){
      $result1 = 0;
    } else {$result1 = 1;
    }
    $sql2="select 0 from orden_trabajo_enc where estado='0' and cli_id = '$this->cli_id'";
    $result2=mysql_query($sql2,$link);
    if ($row = mysql_fetch_array($result2)){
      $result2 = 0;
    } else {$result2 = 2;
    }
    $sql3="select 0 from vehiculos where veh_estado='0' and cli_id = '$this->cli_id'";
    $result3=mysql_query($sql3,$link);
    if ($row = mysql_fetch_array($result3)){
      $result3 = 0;
    } else {$result3 = 3;
    }
    if ($result1>0 and $result2>0 and $result3>0){
        $sql="INSERT INTO hclientes
             (tipo, cli_id, cli_nombre, cli_apellido, cli_razon_social, cli_calle, cli_numero
             , cli_piso, cli_departamento, cli_codigo_postal, cli_ciudad, cli_provincia, cli_telefono1
             , cli_telefono2, cli_fax, cli_email, cli_cuit, cli_observaciones, cli_estado
             , cli_tipo_documento, cli_numero_documento, usu_id)
             SELECT
                'B', cli_id, cli_nombre, cli_apellido, cli_razon_social, cli_calle, cli_numero
                , cli_piso, cli_departamento, cli_codigo_postal, cli_ciudad, cli_provincia, cli_telefono1
                , cli_telefono2, cli_fax, cli_email, cli_cuit, cli_observaciones, cli_estado
                , cli_tipo_documento, cli_numero_documento, '".$_SESSION["usu_id"]."'
             FROM clientes
             WHERE cli_id= '$this->cli_id'";
        $result=mysql_query($sql,$link);
        if ($result>0){
            $sql1="update clientes set cli_estado = '1', usu_id = '".$_SESSION["usu_id"].
                     "' where cli_id = '$this->cli_id'";
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
function getclientes()
{
$link=Conectarse();
$sql="select * from clientes where cli_estado='0'";
$result=mysql_query($sql,$link);
return $result;
}
function getclientesDes()
{
$link=Conectarse();
$sql="select * from clientes where cli_estado='1'";
$result=mysql_query($sql,$link);
return $result;
}
function getclientesSQL()
{
$link=Conectarse();
$sql="select * from clientes where cli_estado='0' order by cli_nombre, cli_apellido, cli_razon_social";
return $sql;
}
function getclientesSQLTexto($texto = "")
{
$link=Conectarse();
//$sql="select CASE ifnull(c.cli_apellido,'') WHEN '' THEN 'zzz' ELSE c.cli_apellido END cli_apellido_nulo
//            , c.cli_apellido, CASE ifnull(c.cli_nombre,'') WHEN '' THEN 'zzz' ELSE c.cli_nombre END cli_nombre_nulo
//            , c.cli_nombre, c.cli_razon_social, c.cli_email, c.cli_id, c.cli_estado
//            , c.cli_calle, c.cli_numero, c.cli_piso, c.cli_departamento, c.cli_codigo_postal, c.cli_ciudad
//            , c.cli_provincia, c.cli_telefono1, c.cli_telefono2, c.cli_fax, c.cli_cuit, c.cli_observaciones
//            , c.cli_tipo_documento, c.cli_numero_documento, c.usu_id
$sql="select CASE ifnull(c.cli_apellido,'') WHEN '' THEN 'zzz' ELSE c.cli_apellido END cli_apellido_nulo
            , CASE ifnull(c.cli_nombre,'') WHEN '' THEN 'zzz' ELSE c.cli_nombre END cli_nombre_nulo
            , c.*
    from clientes c where c.cli_estado='0'";
if ($texto != "") {
    $sql = $sql ." and (upper(c.cli_apellido) like (upper('%" . $texto ."%')) "
                ." or upper(c.cli_nombre) like (upper('%" . $texto ."%')) "
                ." or upper(c.cli_razon_social) like (upper('%" . $texto ."%')) "
                ." or upper(c.cli_cuit) like (upper('%" . $texto ."%')) "
                ." or upper(c.cli_tipo_documento) like (upper('%" . $texto ."%')) "
                ." or upper(c.cli_numero_documento) like (upper('%" . $texto ."%'))) ";
}
$sql.=" order by cli_apellido_nulo, cli_nombre_nulo, c.cli_razon_social";
//$sql.=" order by 1, 3, 5";
return $sql;
}

function getclientesSQLCFiltro($cli_id = "", $cli_nombre = "", $cli_apellido = "", $cli_razon_social = "", $cli_tipo_documento = "", $cli_numero_documento = "")
{
$link=Conectarse();
$sql="select * 
        from clientes 
        where cli_estado='0' ";
if ($cli_id != "") { $sql = $sql . " and cli_id = " . $cli_id;}        
if ($cli_nombre != "") { $sql = $sql . " and cli_nombre like ('" . $cli_nombre ."') ";}
if ($cli_apellido != "") { $sql = $sql . " and cli_apellido like ('" . $cli_apellido ."') ";}
if ($cli_razon_social != "") { $sql = $sql . " and cli_razon_social like ('" . $cli_razon_social ."') ";}
if ($cli_tipo_documento != "") { $sql = $sql . " and cli_tipo_documento like ('" . $cli_tipo_documento ."') ";}
if ($cli_numero_documento != "") { $sql = $sql . " and cli_numero_documento = ('" . $cli_numero_documento ."') ";}

return $sql;
}

function getclientesCombo($cli_id=0, $deshabilitado='N') {
    $link=Conectarse();
    $html = "";
    $sql="select concat(cli_razon_social,' - ',cli_nombre,' ',cli_apellido) cliente , cli_id
        from clientes
        where cli_estado = 0
        order by 1";
    $consulta= mysql_query($sql, $link);
    if ($deshabilitado=='S'){
        $html = "<select name='clientes' id='clientes' class='formFields' disabled='disabled' >";
    } else {
        $html = "<select name='clientes' id='clientes' class='formFields' >";
    }
    while($row= mysql_fetch_assoc($consulta)) {
        if ($cli_id==$row["cli_id"]){
            $html = $html . '<option value='.$row["cli_id"].' selected>'.$row["cliente"].'</option>';
        } else {
            $html = $html . '<option value='.$row["cli_id"].'>'.$row["cliente"].'</option>';
        }
    }
    $html = $html . '</select>';
    return $html;
}
function getclientesComboNulo($cli_id=0) {
    $link=Conectarse();
    $html = "";
    $sql="(select CASE ifnull(c.cli_apellido,'') WHEN '' THEN 'zzz' ELSE c.cli_apellido END cli_apellido_nulo
                , CASE ifnull(c.cli_nombre,'') WHEN '' THEN 'zzz' ELSE c.cli_nombre END cli_nombre_nulo
                , c.cli_apellido, c.cli_nombre, c.cli_razon_social, c.cli_id
        from clientes c
        where c.cli_estado = 0)
        union
        (select ' ' cli_apellido_nulo, ' ' cli_nombre_nulo, ' ' cli_apellido, ' ' cli_nombre
                , ' ' cli_razon_social, '0' cli_id
        from dual)
        order by cli_apellido_nulo, cli_nombre_nulo, cli_razon_social";
    $consulta= mysql_query($sql, $link);
    $html = "<select name='clientes' id='clientes' class='formFields' >";
    while($row= mysql_fetch_assoc($consulta)) {
        if ($cli_id==$row["cli_id"]){
            $html = $html . '<option value='.$row["cli_id"].' selected>'.$row["cli_apellido"].' '.$row["cli_nombre"].' - '.$row["cli_razon_social"].'</option>';
        } else {
            $html = $html . '<option value='.$row["cli_id"].'>'.$row["cli_apellido"].' '.$row["cli_nombre"].' - '.$row["cli_razon_social"].'</option>';
        }
    }
    $html = $html . '</select>';
    return $html;
}
function getclientesCombo_OT($cli_razon_social='',$cli_apellido='',$cli_nombre='',$cli_id='0') {
    $link=Conectarse();
    $html = "";
    $sql="select CASE ifnull(c.cli_apellido,'') WHEN '' THEN 'zzz' ELSE c.cli_apellido END cli_apellido_nulo
                , CASE ifnull(c.cli_nombre,'') WHEN '' THEN 'zzz' ELSE c.cli_nombre END cli_nombre_nulo
                , c.cli_nombre, c.cli_apellido, c.cli_razon_social, c.cli_id
        from clientes c
        where c.cli_estado = 0";
    if ($cli_razon_social!='') {
        $sql.=" and upper(c.cli_razon_social) like '%".strtoupper($cli_razon_social)."%'";
    }
    if ($cli_apellido!='') {
        $sql.=" and upper(c.cli_apellido) like '%".strtoupper($cli_apellido)."%'";
    }
    if ($cli_nombre!='') {
        $sql.=" and upper(c.cli_nombre) like '%".strtoupper($cli_nombre)."%'";
    }
    if ($cli_id!=0) {
        $sql.=" and c.cli_id = ".$cli_id;
    }
    $sql.=" order by cli_apellido_nulo, cli_nombre_nulo, cli_razon_social";
    $consulta= mysql_query($sql, $link);
    $html = "<select name='clientes' id='clientes' class='formFields' >";
    //if ($consulta){
      while($row= mysql_fetch_assoc($consulta)) {
        if ($cli_id==$row["cli_id"]){
            $html = $html . '<option value='.$row["cli_id"].' selected>'.$row["cli_apellido"].' '.$row["cli_nombre"].' - '.$row["cli_razon_social"].'</option>';
        } else {
            $html = $html . '<option value='.$row["cli_id"].'>'.$row["cli_apellido"].' '.$row["cli_nombre"].' - '.$row["cli_razon_social"].'</option>';
        }
      }
    //}
    $html = $html . '</select>';
    return $html;
}
/*Devuelve un combo con los distintos apellidos cargados*/
function getApellidoSelect ($cli_apellido = "") {
    $link=Conectarse();
    $html = "";
    $sql="select distinct IFNULL(c.cli_apellido,' ') as apellido, 2 as orden
        from clientes c
        where c.cli_estado = 0
        union
        select 'TODOS' as apellido, 1 as orden
        order by 2,1";
    $consulta= mysql_query($sql, $link);
    $html = "<select name='apellido' id='apellido' class='formFields'  >";
    while($row= mysql_fetch_assoc($consulta)) {
        if ($cli_apellido==$row["apellido"]){
            $html = $html . '<option value='.$row["apellido"].' selected>'.$row["apellido"].'</option>';
        } else {
            $html = $html . '<option value='.$row["apellido"].'>'.$row["apellido"].'</option>';
        }
    }
    $html = $html . '</select>';
    return $html;
}
/*Devuelve un combo con los distintos nombres cargados*/
function getNombreSelect ($cli_nombre = "") {
    $link=Conectarse();
    $html = "";
    $sql="select distinct IFNULL(c.cli_nombre,' ') as nombre, 2 as orden
        from clientes c
        where c.cli_estado = 0
        union
        select 'TODOS' as nombre, 1 as orden
        order by 2,1";
    $consulta= mysql_query($sql, $link);
    $html = "<select name='nombre' id='nombre' class='formFields'  >";
    while($row= mysql_fetch_assoc($consulta)) {
        if ($cli_nombre==$row["nombre"]){
            $html = $html . '<option value='.$row["nombre"].' selected>'.$row["nombre"].'</option>';
        } else {
            $html = $html . '<option value='.$row["nombre"].'>'.$row["nombre"].'</option>';
        }
    }
    $html = $html . '</select>';
    return $html;
}
/*Devuelve un combo con los distintas razones sociales cargados*/
function getRSSelect ($cli_razon_social = "") {
    $link=Conectarse();
    $html = "";
    $sql="select distinct IFNULL(c.cli_razon_social,' ') as razon_social, 2 as orden
        from clientes c
        where c.cli_estado = 0
        union
        select 'TODOS' as razon_social, 1 as orden
        order by 2,1";
    $consulta= mysql_query($sql, $link);
    $html = "<select name='razon_social' id='razon_social' class='formFields'  >";
    while($row= mysql_fetch_assoc($consulta)) {
        if ($cli_razon_social==$row["razon_social"]){
            $html = $html . '<option value='.$row["razon_social"].' selected>'.$row["razon_social"].'</option>';
        } else {
            $html = $html . '<option value='.$row["razon_social"].'>'.$row["razon_social"].'</option>';
        }
    }
    $html = $html . '</select>';
    return $html;
}
/*Devuelve un combo con los distintos tipos documento cargados*/
function getTipoDocSelect ($cli_tipo_documento = "") {
    $link=Conectarse();
    $html = "";
    $sql="select distinct IFNULL(c.cli_tipo_documento,' ') as tipo_documento, 2 as orden
        from clientes c
        where c.cli_estado = 0
        union
        select 'TODOS' as tipo_documento, 1 as orden
        order by 2,1";
    $consulta= mysql_query($sql, $link);
    $html = "<select name='tipo_documento' id='tipo_documento' class='formFields'  >";
    while($row= mysql_fetch_assoc($consulta)) {
        if ($cli_tipo_documento==$row["tipo_documento"]){
            $html = $html . '<option value='.$row["tipo_documento"].' selected>'.$row["tipo_documento"].'</option>';
        } else {
            $html = $html . '<option value='.$row["tipo_documento"].'>'.$row["tipo_documento"].'</option>';
        }
    }
    $html = $html . '</select>';
    return $html;
}

function getcliCombo($cli_id=0) {
    $link=Conectarse();
    $html = "";
    $sql="select concat(cli_razon_social,' - ',cli_nombre,' ',cli_apellido) cliente, cli_id
        from clientes
        where cli_estado = 0
        order by 1";
    $consulta= mysql_query($sql, $link);
    $html = "<select name='clientes' id='clientes' class='formFields' >";
    while($row= mysql_fetch_assoc($consulta)) {
        if ($cli_id==$row["cli_id"]){
            $html = $html . '<option value='.$row["cli_id"].' selected>'.$row["cliente"].'</option>';
        } else {
            $html = $html . '<option value='.$row["cli_id"].'>'.$row["cliente"].'</option>';
        }
    }
    $html = $html . '</select>';
    return $html;
}

function get_cli_id()
{ return $this->cli_id;}
function set_cli_id($val)
{ $this->cli_id=$val;}
function get_cli_nombre()
{ return $this->cli_nombre;}
function set_cli_nombre($val)
{ $this->cli_nombre=$val;}
function get_cli_apellido()
{ return $this->cli_apellido;}
function set_cli_apellido($val)
{ $this->cli_apellido=$val;}
function get_cli_razon_social()
{ return $this->cli_razon_social;}
function set_cli_razon_social($val)
{ $this->cli_razon_social=$val;}
function get_cli_calle()
{ return $this->cli_calle;}
function set_cli_calle($val)
{ $this->cli_calle=$val;}
function get_cli_numero()
{ return $this->cli_numero;}
function set_cli_numero($val)
{ $this->cli_numero=$val;}
function get_cli_piso()
{ return $this->cli_piso;}
function set_cli_piso($val)
{ $this->cli_piso=$val;}
function get_cli_departamento()
{ return $this->cli_departamento;}
function set_cli_departamento($val)
{ $this->cli_departamento=$val;}
function get_cli_codigo_postal()
{ return $this->cli_codigo_postal;}
function set_cli_codigo_postal($val)
{ $this->cli_codigo_postal=$val;}
function get_cli_ciudad()
{ return $this->cli_ciudad;}
function set_cli_ciudad($val)
{ $this->cli_ciudad=$val;}
function get_cli_provincia()
{ return $this->cli_provincia;}
function set_cli_provincia($val)
{ $this->cli_provincia=$val;}
function get_cli_telefono1()
{ return $this->cli_telefono1;}
function set_cli_telefono1($val)
{ $this->cli_telefono1=$val;}
function get_cli_telefono2()
{ return $this->cli_telefono2;}
function set_cli_telefono2($val)
{ $this->cli_telefono2=$val;}
function get_cli_fax()
{ return $this->cli_fax;}
function set_cli_fax($val)
{ $this->cli_fax=$val;}
function get_cli_email()
{ return $this->cli_email;}
function set_cli_email($val)
{ $this->cli_email=$val;}
function get_cli_cuit()
{ return $this->cli_cuit;}
function set_cli_cuit($val)
{ $this->cli_cuit=$val;}
function get_cli_observaciones()
{ return $this->cli_observaciones;}
function set_cli_observaciones($val)
{ $this->cli_observaciones=$val;}
function get_cli_estado()
{ return $this->cli_estado;}
function set_cli_estado($val)
{ $this->cli_estado=$val;}
function get_cli_tipo_documento()
{ return $this->cli_tipo_documento;}
function set_cli_tipo_documento($val)
{ $this->cli_tipo_documento=$val;}
function get_cli_numero_documento()
{ return $this->cli_numero_documento;}
function set_cli_numero_documento($val)
{ $this->cli_numero_documento=$val;}
function get_usu_id()
{ return $this->usu_id;}
function set_usu_id($val)
{ $this->usu_id=$val;}
}
?>