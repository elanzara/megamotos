<?php
class empleados {
var $emp_id;
var $emp_legajo;
var $emp_fch_alta;
var $emp_fch_baja;
var $emp_fch_nac;
var $emp_nombre;
var $emp_apellido;
var $emp_calle;
var $emp_numero;
var $emp_piso;
var $emp_departamento;
var $emp_codigo_postal;
var $emp_ciudad;
var $emp_provincia;
var $emp_telefono1;
var $emp_telefono2;
var $emp_fax;
var $emp_email;
var $emp_cuil;
var $emp_sindicato;
var $emp_obra_soc;
var $emp_categoria;
var $emp_banco;
var $emp_cbu;
var $emp_suc_id;
var $emp_observaciones;
var $emp_estado;
var $emp_tipo_documento;
var $emp_numero_documento;
var $usu_id;

function empleados($emp_id=0) {
if ($emp_id!=0) {
$link=Conectarse();

$consulta= mysql_query(' select emp_id,
  emp_legajo,
  emp_tipo_documento,
  emp_numero_documento,
  emp_cuil,
  emp_fch_alta,
  emp_fch_baja,
  emp_fch_nac,
  emp_apellido,
  emp_nombre,
  emp_calle,
  emp_numero,
  emp_piso,
  emp_departamento,
  emp_codigo_postal,
  emp_ciudad,
  emp_provincia,
  emp_telefono1,
  emp_telefono2,
  emp_fax,
  emp_email,
  emp_sindicato,
  emp_obra_soc,
  emp_categoria,
  emp_banco,
  emp_cbu,
  emp_suc_id,
  emp_observaciones,
  emp_estado,
  usu_id  from empleados where emp_id = '.$emp_id,$link);
while($row= mysql_fetch_assoc($consulta)) {
$this->emp_id=$row['emp_id'];
$this->emp_legajo=$row['emp_legajo'];
$this->emp_tipo_documento=$row['emp_tipo_documento'];
$this->emp_numero_documento=$row['emp_numero_documento'];
$this->emp_cuil=$row['emp_cuil'];
$this->emp_fch_alta=$row['emp_fch_alta'];
$this->emp_fch_baja=$row['emp_fch_baja'];
$this->emp_fch_nac=$row['emp_fch_nac'];
$this->emp_apellido=$row['emp_apellido'];
$this->emp_nombre=$row['emp_nombre'];
$this->emp_calle=$row['emp_calle'];
$this->emp_numero=$row['emp_numero'];
$this->emp_piso=$row['emp_piso'];
$this->emp_departamento=$row['emp_departamento'];
$this->emp_codigo_postal=$row['emp_codigo_postal'];
$this->emp_ciudad=$row['emp_ciudad'];
$this->emp_provincia=$row['emp_provincia'];
$this->emp_telefono1=$row['emp_telefono1'];
$this->emp_telefono2=$row['emp_telefono2'];
$this->emp_fax=$row['emp_fax'];
$this->emp_email=$row['emp_email'];
$this->emp_sindicato=$row['emp_sindicato'];
$this->emp_obra_soc=$row['emp_obra_soc'];
$this->emp_categoria=$row['emp_categoria'];
$this->emp_banco=$row['emp_banco'];
$this->emp_cbu=$row['emp_cbu'];
$this->emp_suc_id=$row['emp_suc_id'];
$this->emp_observaciones=$row['emp_observaciones'];
$this->emp_estado=$row['emp_estado'];
$this->usu_id=$row['usu_id'];
}
}
}
function insert_emp() {
$link=Conectarse();
$sql="insert into empleados (
  emp_legajo,
  emp_tipo_documento,
  emp_numero_documento,
  emp_cuil,
  emp_fch_alta,
  emp_fch_baja,
  emp_fch_nac,
  emp_apellido,
  emp_nombre,
  emp_calle,
  emp_numero,
  emp_piso,
  emp_departamento,
  emp_codigo_postal,
  emp_ciudad,
  emp_provincia,
  emp_telefono1,
  emp_telefono2,
  emp_fax,
  emp_email,
  emp_sindicato,
  emp_obra_soc,
  emp_categoria,
  emp_banco,
  emp_cbu,
  emp_suc_id,
  emp_observaciones,
  emp_estado,
  usu_id
  ) values ( 
'$this->emp_legajo',
'$this->emp_tipo_documento',
'$this->emp_numero_documento',
'$this->emp_cuil',
'$this->emp_fch_alta',
'$this->emp_fch_baja',
'$this->emp_fch_nac',
'$this->emp_apellido',
'$this->emp_nombre',
'$this->emp_calle',
'$this->emp_numero',
'$this->emp_piso',
'$this->emp_departamento',
'$this->emp_codigo_postal',
'$this->emp_ciudad',
'$this->emp_provincia',
'$this->emp_telefono1',
'$this->emp_telefono2',
'$this->emp_fax',
'$this->emp_email',
'$this->emp_sindicato',
'$this->emp_obra_soc',
'$this->emp_categoria',
'$this->emp_banco',
'$this->emp_cbu',
'$this->emp_suc_id',
'$this->emp_observaciones',
'$this->emp_estado'
, '".$_SESSION["usu_id"]."'
)";

$result=mysql_query($sql,$link);

$ins_id = mysql_insert_id();


if ($ins_id>0){
    $sql1="INSERT INTO hempleados
        (tipo, emp_id,
  emp_legajo,
  emp_tipo_documento,
  emp_numero_documento,
  emp_cuil,
  emp_fch_alta,
  emp_fch_baja,
  emp_fch_nac,
  emp_apellido,
  emp_nombre,
  emp_calle,
  emp_numero,
  emp_piso,
  emp_departamento,
  emp_codigo_postal,
  emp_ciudad,
  emp_provincia,
  emp_telefono1,
  emp_telefono2,
  emp_fax,
  emp_email,
  emp_sindicato,
  emp_obra_soc,
  emp_categoria,
  emp_banco,
  emp_cbu,
  emp_suc_id,
  emp_observaciones,
  emp_estado,
  usu_id)
        VALUES
        ('I', ".$ins_id.", '$this->emp_legajo',
'$this->emp_tipo_documento',
'$this->emp_numero_documento',
'$this->emp_cuil',
'$this->emp_fch_alta',
'$this->emp_fch_baja',
'$this->emp_fch_nac',
'$this->emp_apellido',
'$this->emp_nombre',
'$this->emp_calle',
'$this->emp_numero',
'$this->emp_piso',
'$this->emp_departamento',
'$this->emp_codigo_postal',
'$this->emp_ciudad',
'$this->emp_provincia',
'$this->emp_telefono1',
'$this->emp_telefono2',
'$this->emp_fax',
'$this->emp_email',
'$this->emp_sindicato',
'$this->emp_obra_soc',
'$this->emp_categoria',
'$this->emp_banco',
'$this->emp_cbu',
'$this->emp_suc_id',
'$this->emp_observaciones',
'$this->emp_estado'
, '".$_SESSION["usu_id"]."')";
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
function update_emp() {
$link=Conectarse();
$sql="INSERT INTO hempleados
     (tipo, emp_id,
  emp_legajo,
  emp_tipo_documento,
  emp_numero_documento,
  emp_cuil,
  emp_fch_alta,
  emp_fch_baja,
  emp_fch_nac,
  emp_apellido,
  emp_nombre,
  emp_calle,
  emp_numero,
  emp_piso,
  emp_departamento,
  emp_codigo_postal,
  emp_ciudad,
  emp_provincia,
  emp_telefono1,
  emp_telefono2,
  emp_fax,
  emp_email,
  emp_sindicato,
  emp_obra_soc,
  emp_categoria,
  emp_banco,
  emp_cbu,
  emp_suc_id,
  emp_observaciones,
  emp_estado,
  usu_id)
     SELECT
        'U', emp_id, emp_legajo,
  emp_tipo_documento,
  emp_numero_documento,
  emp_cuil,
  emp_fch_alta,
  emp_fch_baja,
  emp_fch_nac,
  emp_apellido,
  emp_nombre,
  emp_calle,
  emp_numero,
  emp_piso,
  emp_departamento,
  emp_codigo_postal,
  emp_ciudad,
  emp_provincia,
  emp_telefono1,
  emp_telefono2,
  emp_fax,
  emp_email,
  emp_sindicato,
  emp_obra_soc,
  emp_categoria,
  emp_banco,
  emp_cbu,
  emp_suc_id,
  emp_observaciones,
  emp_estado,
  '".$_SESSION["usu_id"]."'
     FROM empleados
     WHERE emp_id= '$this->emp_id'";
$result=mysql_query($sql,$link);
if ($result>0){
    $sql1="update empleados set 
 emp_id = '$this->emp_id',
  emp_legajo = '$this->emp_legajo',
  emp_tipo_documento = '$this->emp_tipo_documento',
  emp_numero_documento = '$this->emp_numero_documento',
  emp_cuil = '$this->emp_cuil',
  emp_fch_alta = '$this->emp_fch_alta',
  emp_fch_baja = '$this->emp_fch_baja',
  emp_fch_nac = '$this->emp_fch_nac',
  emp_apellido = '$this->emp_apellido',
  emp_nombre = '$this->emp_nombre',
  emp_calle = '$this->emp_calle',
  emp_numero = '$this->emp_numero',
  emp_piso = '$this->emp_piso',
  emp_departamento = '$this->emp_departamento',
  emp_codigo_postal = '$this->emp_codigo_postal',
  emp_ciudad = '$this->emp_ciudad',
  emp_provincia = '$this->emp_provincia',
  emp_telefono1 = '$this->emp_telefono1',
  emp_telefono2 = '$this->emp_telefono2',
  emp_fax = '$this->emp_fax',
  emp_email = '$this->emp_email',
  emp_sindicato = '$this->emp_sindicato',
  emp_obra_soc = '$this->emp_obra_soc',
  emp_categoria = '$this->emp_categoria',
  emp_banco = '$this->emp_banco',
  emp_cbu = '$this->emp_cbu',
  emp_suc_id = '$this->emp_suc_id',
  emp_observaciones = '$this->emp_observaciones',
  emp_estado = '$this->emp_estado', 
  usu_id = '".$_SESSION["usu_id"]."'
  where emp_id = '$this->emp_id'";		
  $result1=mysql_query($sql1,$link);
    if ($result1>0){
        return 1;
    }else {
        return 0;}
} else {
    return 0;
}
}
function baja_emp(){
    $link=Conectarse();
    $sql1="select 0 from facturas_enc where emp_id = '$this->emp_id'";
    $result1=mysql_query($sql1,$link);
    if ($row = mysql_fetch_array($result1)){
      $result1 = 0;
    } else {$result1 = 1;
    }
    $sql2="select 0 from orden_trabajo_enc where estado='0' and emp_id = '$this->emp_id'";
    $result2=mysql_query($sql2,$link);
    if ($row = mysql_fetch_array($result2)){
      $result2 = 0;
    } else {$result2 = 2;
    }
    $sql3="select 0 from vehiculos where veh_estado='0' and emp_id = '$this->emp_id'";
    $result3=mysql_query($sql3,$link);
    if ($row = mysql_fetch_array($result3)){
      $result3 = 0;
    } else {$result3 = 3;
    }
    if ($result1>0 and $result2>0 and $result3>0){
        $sql="INSERT INTO hempleados
             (tipo, emp_id,
  emp_legajo,
  emp_tipo_documento,
  emp_numero_documento,
  emp_cuil,
  emp_fch_alta,
  emp_fch_baja,
  emp_fch_nac,
  emp_apellido,
  emp_nombre,
  emp_calle,
  emp_numero,
  emp_piso,
  emp_departamento,
  emp_codigo_postal,
  emp_ciudad,
  emp_provincia,
  emp_telefono1,
  emp_telefono2,
  emp_fax,
  emp_email,
  emp_sindicato,
  emp_obra_soc,
  emp_categoria,
  emp_banco,
  emp_cbu,
  emp_suc_id,
  emp_observaciones,
  emp_estado,
  usu_id)
             SELECT
                'B', emp_id, emp_legajo,
  emp_tipo_documento,
  emp_numero_documento,
  emp_cuil,
  emp_fch_alta,
  emp_fch_baja,
  emp_fch_nac,
  emp_apellido,
  emp_nombre,
  emp_calle,
  emp_numero,
  emp_piso,
  emp_departamento,
  emp_codigo_postal,
  emp_ciudad,
  emp_provincia,
  emp_telefono1,
  emp_telefono2,
  emp_fax,
  emp_email,
  emp_sindicato,
  emp_obra_soc,
  emp_categoria,
  emp_banco,
  emp_cbu,
  emp_suc_id,
  emp_observaciones,
  emp_estado, '".$_SESSION["usu_id"]."'
             FROM emplados
             WHERE emp_id= '$this->emp_id'";
        $result=mysql_query($sql,$link);
        if ($result>0){
            $sql1="update empleados set emp_estado = '1', usu_id = '".$_SESSION["usu_id"].
                     "' where emp_id = '$this->emp_id'";
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
function getempleados()
{
$link=Conectarse();
$sql="select * from empleados where emp_estado='0'";
$result=mysql_query($sql,$link);
return $result;
}
function getempleadosDes()
{
$link=Conectarse();
$sql="select * from empleados where emp_estado='1'";
$result=mysql_query($sql,$link);
return $result;
}
function getempleadosSQL()
{
$link=Conectarse();
$sql="select * from empleados where emp_estado='0' order by emp_nombre, emp_apellido, emp_cuil";
return $sql;
}
function getempleadosSQLTexto($texto = "")
{
$link=Conectarse();
$sql="select CASE ifnull(c.emp_apellido,'') WHEN '' THEN 'zzz' ELSE c.emp_apellido END emp_apellido_nulo
            , CASE ifnull(c.emp_nombre,'') WHEN '' THEN 'zzz' ELSE c.emp_nombre END emp_nombre_nulo
            , c.*
    from empleados c where c.emp_estado='0'";
if ($texto != "") {
    $sql = $sql ." and (upper(c.emp_apellido) like (upper('%" . $texto ."%')) "
                ." or upper(c.emp_nombre) like (upper('%" . $texto ."%')) "
                ." or upper(c.emp_cuil) like (upper('%" . $texto ."%')) "
                ." or upper(c.emp_legajo) like (upper('%" . $texto ."%')) "
                ." or upper(c.emp_tipo_documento) like (upper('%" . $texto ."%')) "
                ." or upper(c.emp_numero_documento) like (upper('%" . $texto ."%'))) ";
}
$sql.=" order by emp_apellido_nulo, emp_nombre_nulo, c.emp_legajo";
//$sql.=" order by 1, 3, 5";
return $sql;
}

function getempleadosSQLCFiltro($emp_id = "", $emp_nombre = "", $emp_apellido = "", $emp_legajo = "", $emp_tipo_documento = "", $emp_numero_documento = "")
{
$link=Conectarse();
$sql="select * 
        from empleados 
        where emp_estado='0' ";
if ($emp_id != "") { $sql = $sql . " and emp_id = " . $emp_id;}        
if ($emp_nombre != "") { $sql = $sql . " and emp_nombre like ('" . $emp_nombre ."') ";}
if ($emp_apellido != "") { $sql = $sql . " and emp_apellido like ('" . $emp_apellido ."') ";}
if ($emp_cuil != "") { $sql = $sql . " and emp_cuil like ('" . $emp_cuil ."') ";}
if ($emp_tipo_documento != "") { $sql = $sql . " and emp_tipo_documento like ('" . $emp_tipo_documento ."') ";}
if ($emp_numero_documento != "") { $sql = $sql . " and emp_numero_documento = ('" . $emp_numero_documento ."') ";}

return $sql;
}

function getempleadosCombo($emp_id=0, $deshabilitado='N') {
    $link=Conectarse();
    $html = "";
    $sql="select concat(emp_legajo,' - ',emp_nombre,' ',emp_apellido) empleado , emp_id
        from empleados
        where emp_estado = 0
        order by 1";
    $consulta= mysql_query($sql, $link);
    if ($deshabilitado=='S'){
        $html = "<select name='emplados' id='emplados' class='formFields' disabled='disabled' >";
    } else {
        $html = "<select name='emplados' id='emplados' class='formFields' >";
    }
    while($row= mysql_fetch_assoc($consulta)) {
        if ($emp_id==$row["emp_id"]){
            $html = $html . '<option value='.$row["emp_id"].' selected>'.$row["emplado"].'</option>';
        } else {
            $html = $html . '<option value='.$row["emp_id"].'>'.$row["emplado"].'</option>';
        }
    }
    $html = $html . '</select>';
    return $html;
}
function getempladosComboNulo($emp_id=0) {
    $link=Conectarse();
    $html = "";
    $sql="(select CASE ifnull(c.emp_apellido,'') WHEN '' THEN 'zzz' ELSE c.emp_apellido END emp_apellido_nulo
                , CASE ifnull(c.emp_nombre,'') WHEN '' THEN 'zzz' ELSE c.emp_nombre END emp_nombre_nulo
                , c.emp_apellido, c.emp_nombre, c.emp_cuil, c.emp_id
        from emplados c
        where c.emp_estado = 0)
        union
        (select ' ' emp_apellido_nulo, ' ' emp_nombre_nulo, ' ' emp_apellido, ' ' emp_nombre
                , ' ' emp_cuil, '0' emp_id
        from dual)
        order by emp_apellido_nulo, emp_nombre_nulo, emp_cuil";
    $consulta= mysql_query($sql, $link);
    $html = "<select name='emplados' id='emplados' class='formFields' >";
    while($row= mysql_fetch_assoc($consulta)) {
        if ($emp_id==$row["emp_id"]){
            $html = $html . '<option value='.$row["emp_id"].' selected>'.$row["emp_apellido"].' '.$row["emp_nombre"].' - '.$row["emp_cuil"].'</option>';
        } else {
            $html = $html . '<option value='.$row["emp_id"].'>'.$row["emp_apellido"].' '.$row["emp_nombre"].' - '.$row["emp_cuil"].'</option>';
        }
    }
    $html = $html . '</select>';
    return $html;
}
function getempladosCombo_OT($emp_cuil='',$emp_apellido='',$emp_nombre='',$emp_id='0') {
    $link=Conectarse();
    $html = "";
    $sql="select CASE ifnull(c.emp_apellido,'') WHEN '' THEN 'zzz' ELSE c.emp_apellido END emp_apellido_nulo
                , CASE ifnull(c.emp_nombre,'') WHEN '' THEN 'zzz' ELSE c.emp_nombre END emp_nombre_nulo
                , c.emp_nombre, c.emp_apellido, c.emp_cuil, c.emp_id
        from emplados c
        where c.emp_estado = 0";
    if ($emp_cuil!='') {
        $sql.=" and upper(c.emp_cuil) like '%".strtoupper($emp_cuil)."%'";
    }
    if ($emp_apellido!='') {
        $sql.=" and upper(c.emp_apellido) like '%".strtoupper($emp_apellido)."%'";
    }
    if ($emp_nombre!='') {
        $sql.=" and upper(c.emp_nombre) like '%".strtoupper($emp_nombre)."%'";
    }
    if ($emp_id!=0) {
        $sql.=" and c.emp_id = ".$emp_id;
    }
    $sql.=" order by emp_apellido_nulo, emp_nombre_nulo, emp_cuil";
    $consulta= mysql_query($sql, $link);
    $html = "<select name='emplados' id='emplados' class='formFields' >";
    //if ($consulta){
      while($row= mysql_fetch_assoc($consulta)) {
        if ($emp_id==$row["emp_id"]){
            $html = $html . '<option value='.$row["emp_id"].' selected>'.$row["emp_apellido"].' '.$row["emp_nombre"].' - '.$row["emp_cuil"].'</option>';
        } else {
            $html = $html . '<option value='.$row["emp_id"].'>'.$row["emp_apellido"].' '.$row["emp_nombre"].' - '.$row["emp_cuil"].'</option>';
        }
      }
    //}
    $html = $html . '</select>';
    return $html;
}
/*Devuelve un combo con los distintos apellidos cargados*/
function getApellidoSelect ($emp_apellido = "") {
    $link=Conectarse();
    $html = "";
    $sql="select distinct IFNULL(c.emp_apellido,' ') as apellido, 2 as orden
        from emplados c
        where c.emp_estado = 0
        union
        select 'TODOS' as apellido, 1 as orden
        order by 2,1";
    $consulta= mysql_query($sql, $link);
    $html = "<select name='apellido' id='apellido' class='formFields'  >";
    while($row= mysql_fetch_assoc($consulta)) {
        if ($emp_apellido==$row["apellido"]){
            $html = $html . '<option value='.$row["apellido"].' selected>'.$row["apellido"].'</option>';
        } else {
            $html = $html . '<option value='.$row["apellido"].'>'.$row["apellido"].'</option>';
        }
    }
    $html = $html . '</select>';
    return $html;
}
/*Devuelve un combo con los distintos nombres cargados*/
function getNombreSelect ($emp_nombre = "") {
    $link=Conectarse();
    $html = "";
    $sql="select distinct IFNULL(c.emp_nombre,' ') as nombre, 2 as orden
        from emplados c
        where c.emp_estado = 0
        union
        select 'TODOS' as nombre, 1 as orden
        order by 2,1";
    $consulta= mysql_query($sql, $link);
    $html = "<select name='nombre' id='nombre' class='formFields'  >";
    while($row= mysql_fetch_assoc($consulta)) {
        if ($emp_nombre==$row["nombre"]){
            $html = $html . '<option value='.$row["nombre"].' selected>'.$row["nombre"].'</option>';
        } else {
            $html = $html . '<option value='.$row["nombre"].'>'.$row["nombre"].'</option>';
        }
    }
    $html = $html . '</select>';
    return $html;
}
/*Devuelve un combo con los distintas razones sociales cargados*/
function getRSSelect ($emp_cuil = "") {
    $link=Conectarse();
    $html = "";
    $sql="select distinct IFNULL(c.emp_cuil,' ') as cuil, 2 as orden
        from emplados c
        where c.emp_estado = 0
        union
        select 'TODOS' as cuil, 1 as orden
        order by 2,1";
    $consulta= mysql_query($sql, $link);
    $html = "<select name='cuil' id='cuil' class='formFields'  >";
    while($row= mysql_fetch_assoc($consulta)) {
        if ($emp_cuil==$row["cuil"]){
            $html = $html . '<option value='.$row["cuil"].' selected>'.$row["cuil"].'</option>';
        } else {
            $html = $html . '<option value='.$row["cuil"].'>'.$row["cuil"].'</option>';
        }
    }
    $html = $html . '</select>';
    return $html;
}
/*Devuelve un combo con los distintos tipos documento cargados*/
function getTipoDocSelect ($emp_tipo_documento = "") {
    $link=Conectarse();
    $html = "";
    $sql="select distinct IFNULL(c.emp_tipo_documento,' ') as tipo_documento, 2 as orden
        from emplados c
        where c.emp_estado = 0
        union
        select 'TODOS' as tipo_documento, 1 as orden
        order by 2,1";
    $consulta= mysql_query($sql, $link);
    $html = "<select name='tipo_documento' id='tipo_documento' class='formFields'  >";
    while($row= mysql_fetch_assoc($consulta)) {
        if ($emp_tipo_documento==$row["tipo_documento"]){
            $html = $html . '<option value='.$row["tipo_documento"].' selected>'.$row["tipo_documento"].'</option>';
        } else {
            $html = $html . '<option value='.$row["tipo_documento"].'>'.$row["tipo_documento"].'</option>';
        }
    }
    $html = $html . '</select>';
    return $html;
}

function get_emp_id()
{ return $this->emp_id;}
function set_emp_id($val)
{ $this->emp_id=$val;}
function get_emp_legajo()
{ return $this->emp_legajo;}
function set_emp_legajo($val)
{ $this->emp_legajo=$val;}
function get_emp_fch_alta()
{ return $this->emp_fch_alta;}
function set_emp_fch_alta($val)
{ $this->emp_fch_alta=$val;}
function get_emp_fch_baja()
{ return $this->emp_fch_baja;}
function set_emp_fch_baja($val)
{ $this->emp_fch_baja=$val;}
function get_emp_fch_nac()
{ return $this->emp_fch_nac;}
function set_emp_fch_nac($val)
{ $this->emp_fch_nac=$val;}
function get_emp_nombre()
{ return $this->emp_nombre;}
function set_emp_nombre($val)
{ $this->emp_nombre=$val;}
function get_emp_apellido()
{ return $this->emp_apellido;}
function set_emp_apellido($val)
{ $this->emp_apellido=$val;}
function get_emp_calle()
{ return $this->emp_calle;}
function set_emp_calle($val)
{ $this->emp_calle=$val;}
function get_emp_numero()
{ return $this->emp_numero;}
function set_emp_numero($val)
{ $this->emp_numero=$val;}
function get_emp_piso()
{ return $this->emp_piso;}
function set_emp_piso($val)
{ $this->emp_piso=$val;}
function get_emp_departamento()
{ return $this->emp_departamento;}
function set_emp_departamento($val)
{ $this->emp_departamento=$val;}
function get_emp_codigo_postal()
{ return $this->emp_codigo_postal;}
function set_emp_codigo_postal($val)
{ $this->emp_codigo_postal=$val;}
function get_emp_ciudad()
{ return $this->emp_ciudad;}
function set_emp_ciudad($val)
{ $this->emp_ciudad=$val;}
function get_emp_provincia()
{ return $this->emp_provincia;}
function set_emp_provincia($val)
{ $this->emp_provincia=$val;}
function get_emp_telefono1()
{ return $this->emp_telefono1;}
function set_emp_telefono1($val)
{ $this->emp_telefono1=$val;}
function get_emp_telefono2()
{ return $this->emp_telefono2;}
function set_emp_telefono2($val)
{ $this->emp_telefono2=$val;}
function get_emp_fax()
{ return $this->emp_fax;}
function set_emp_fax($val)
{ $this->emp_fax=$val;}
function get_emp_email()
{ return $this->emp_email;}
function set_emp_email($val)
{ $this->emp_email=$val;}
function get_emp_cuil()
{ return $this->emp_cuil;}
function set_emp_cuil($val)
{ $this->emp_cuil=$val;}
function get_emp_sindicato()
{ return $this->emp_sindicato;}
function set_emp_sindicato($val)
{ $this->emp_sindicato=$val;}
function get_emp_obra_soc()
{ return $this->emp_obra_soc;}
function set_emp_obra_soc($val)
{ $this->emp_obra_soc=$val;}
function get_emp_categoria()
{ return $this->emp_categoria;}
function set_emp_categoria($val)
{ $this->emp_categoria=$val;}
function get_emp_banco()
{ return $this->emp_banco;}
function set_emp_banco($val)
{ $this->emp_banco=$val;}
function get_emp_cbu()
{ return $this->emp_cbu;}
function set_emp_cbu($val)
{ $this->emp_cbu=$val;}
function get_emp_suc_id()
{ return $this->emp_suc_id;}
function set_emp_suc_id($val)
{ $this->emp_suc_id=$val;}
function get_emp_observaciones()
{ return $this->emp_observaciones;}
function set_emp_observaciones($val)
{ $this->emp_observaciones=$val;}
function get_emp_estado()
{ return $this->emp_estado;}
function set_emp_estado($val)
{ $this->emp_estado=$val;}
function get_emp_tipo_documento()
{ return $this->emp_tipo_documento;}
function set_emp_tipo_documento($val)
{ $this->emp_tipo_documento=$val;}
function get_emp_numero_documento()
{ return $this->emp_numero_documento;}
function set_emp_numero_documento($val)
{ $this->emp_numero_documento=$val;}
function get_usu_id()
{ return $this->usu_id;}
function set_usu_id($val)
{ $this->usu_id=$val;}
}
?>