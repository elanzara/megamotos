<?php
class sucursales {

var $suc_id;
var $suc_descripcion;
var $suc_calle;
var $suc_numero;
var $suc_piso;
var $suc_departamento;
var $suc_codigo_postal;
var $suc_ciudad;
var $suc_provincia;
var $suc_telefono1;
var $suc_telefono2;
var $suc_rubro;
var $suc_numero_sucursal;
var $suc_ultima_factura;
var $suc_ultima_nc;
var $suc_ultima_nd;
var $suc_ultimo_recibo;
var $suc_estado;
var $suc_mail;
var $usu_id;

function sucursales($suc_id=0) {
    if ($suc_id!=0) {
        $link=Conectarse();
        $consulta= mysql_query(' select * from sucursales where suc_id = '.$suc_id,$link);
        while($row= mysql_fetch_assoc($consulta)) {
            $this->suc_id=$row['suc_id'];
            $this->suc_descripcion=$row['suc_descripcion'];
            $this->suc_calle=$row['suc_calle'];
            $this->suc_numero=$row['suc_numero'];
            $this->suc_piso=$row['suc_piso'];
            $this->suc_departamento=$row['suc_departamento'];
            $this->suc_codigo_postal=$row['suc_codigo_postal'];
            $this->suc_ciudad=$row['suc_ciudad'];
            $this->suc_provincia=$row['suc_provincia'];
            $this->suc_telefono1=$row['suc_telefono1'];
            $this->suc_telefono2=$row['suc_telefono2'];
            $this->suc_rubro=$row['suc_rubro'];
            $this->suc_numero_sucursal=$row['suc_numero_sucursal'];
            $this->suc_ultima_factura=$row['suc_ultima_factura'];
            $this->suc_ultima_nc=$row['suc_ultima_nc'];
            $this->suc_ultima_nd=$row['suc_ultima_nd'];
            $this->suc_ultimo_recibo=$row['suc_ultimo_recibo'];
            $this->suc_estado=$row['suc_estado'];
            $this->suc_mail=$row['suc_mail'];
            $this->usu_id=$row['usu_id'];
        }
    }
}
function insert_suc() {
    $link=Conectarse();
    $sql="insert into sucursales (
        suc_descripcion
        , suc_calle
        , suc_numero
        , suc_piso
        , suc_departamento
        , suc_codigo_postal
        , suc_ciudad
        , suc_provincia
        , suc_telefono1
        , suc_telefono2
        , suc_rubro
        , suc_numero_sucursal
        , suc_ultima_factura
        , suc_ultima_nc
        , suc_ultima_nd
        , suc_ultimo_recibo
        , suc_estado
        , suc_mail
        , usu_id
        ) values ( 
        '$this->suc_descripcion'
        , '$this->suc_calle'
        , '$this->suc_numero'
        , '$this->suc_piso'
        , '$this->suc_departamento'
        , '$this->suc_codigo_postal'
        , '$this->suc_ciudad'
        , '$this->suc_provincia'
        , '$this->suc_telefono1'
        , '$this->suc_telefono2'
        , '$this->suc_rubro'
        , '$this->suc_numero_sucursal'
        , '$this->suc_ultima_factura'
        , '$this->suc_ultima_nc'
        , '$this->suc_ultima_nd'
        , '$this->suc_ultimo_recibo'
        , '$this->suc_estado'
        , '$this->suc_mail'
        , '".$_SESSION["usu_id"]."'
        )";
    $result=mysql_query($sql,$link);
    $ultimo_id = mysql_insert_id($link);
    if ($ultimo_id>0){
        $sql1="INSERT INTO hsucursales
            (tipo, suc_id, suc_descripcion, suc_calle, suc_numero, suc_piso, suc_departamento, suc_codigo_postal
            , suc_ciudad, suc_provincia, suc_telefono1, suc_telefono2, suc_rubro, suc_numero_sucursal
            , suc_ultima_factura, suc_ultima_nc, suc_ultima_nd, suc_ultimo_recibo, suc_mail, suc_estado, usu_id)
            VALUES
            ('I', $ultimo_id, '$this->suc_descripcion', '$this->suc_calle', '$this->suc_numero', '$this->suc_piso'
            , '$this->suc_departamento', '$this->suc_codigo_postal', '$this->suc_ciudad', '$this->suc_provincia'
            , '$this->suc_telefono1', '$this->suc_telefono2', '$this->suc_rubro', '$this->suc_numero_sucursal'
            , '$this->suc_ultima_factura', '$this->suc_ultima_nc', '$this->suc_ultima_nd', '$this->suc_ultimo_recibo'
            , '$this->suc_mail', 0, '".$_SESSION["usu_id"]."')";
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
function update_suc() {
    $link=Conectarse();
    $sql="INSERT INTO hsucursales
            (tipo, suc_id, suc_descripcion, suc_calle, suc_numero, suc_piso, suc_departamento, suc_codigo_postal
            , suc_ciudad, suc_provincia, suc_telefono1, suc_telefono2, suc_rubro, suc_numero_sucursal
            , suc_ultima_factura, suc_ultima_nc, suc_ultima_nd, suc_ultimo_recibo, suc_mail, suc_estado, usu_id)
         SELECT
            'U', suc_id, suc_descripcion, suc_calle, suc_numero, suc_piso, suc_departamento, suc_codigo_postal
            , suc_ciudad, suc_provincia, suc_telefono1, suc_telefono2, suc_rubro, suc_numero_sucursal
            , suc_ultima_factura, suc_ultima_nc, suc_ultima_nd, suc_ultimo_recibo, suc_mail, suc_estado, '".$_SESSION["usu_id"]."'
         FROM sucursales
         WHERE suc_id= '$this->suc_id'";
    $result=mysql_query($sql,$link);
    if ($result>0){
        $sql1="update sucursales set
            suc_id = '$this->suc_id'
            , suc_descripcion = '$this->suc_descripcion'
            , suc_calle = '$this->suc_calle'
            , suc_numero = '$this->suc_numero'
            , suc_piso = '$this->suc_piso'
            , suc_departamento = '$this->suc_departamento'
            , suc_codigo_postal = '$this->suc_codigo_postal'
            , suc_ciudad = '$this->suc_ciudad'
            , suc_provincia = '$this->suc_provincia'
            , suc_telefono1 = '$this->suc_telefono1'
            , suc_telefono2 = '$this->suc_telefono2'
            , suc_rubro = '$this->suc_rubro'
            , suc_numero_sucursal = '$this->suc_numero_sucursal'
            , suc_ultima_factura = '$this->suc_ultima_factura'
            , suc_ultima_nc = '$this->suc_ultima_nc'
            , suc_ultima_nd = '$this->suc_ultima_nd'
            , suc_ultimo_recibo = '$this->suc_ultimo_recibo'
            , suc_estado = '$this->suc_estado'
            , suc_mail = '$this->suc_mail'
            , usu_id = '".$_SESSION["usu_id"]."'
        where suc_id = '$this->suc_id'";
        $result1=mysql_query($sql1,$link);
        if ($result1>0){
            return 1;
        }else {
            return 0;}
    } else {
        return 0;
    }
}
function baja_suc(){
    $link=Conectarse();
    $sql1="select 0 from movimientos_stock where estado='0' and suc_id = '$this->suc_id'";
    $result1=mysql_query($sql1,$link);
    if ($row1 = mysql_fetch_array($result1)){
      $result1 = 0;
    } else {$result1 = 1;
    }
    $sql2="select 0 from orden_trabajo_enc where estado='0' and suc_id = '$this->suc_id'";
    $result2=mysql_query($sql2,$link);
    if ($row2 = mysql_fetch_array($result2)){
      $result2 = 0;
    } else {$result2 = 2;
    }
    $sql3="select 0 from stock_mensual where suc_id = '$this->suc_id'";
    $result3=mysql_query($sql3,$link);
    if ($row3 = mysql_fetch_array($result3)){
      $result3 = 0;
    } else {$result3 = 3;
    }
    if ($result1>0 and $result2>0 and $result3>0){
        $sql="INSERT INTO hsucursales
             (tipo, suc_id, suc_descripcion, suc_calle, suc_numero, suc_piso, suc_departamento, suc_codigo_postal
             , suc_ciudad, suc_provincia, suc_telefono1, suc_telefono2, suc_rubro, suc_numero_sucursal
             , suc_ultima_factura, suc_ultima_nc, suc_ultima_nd, suc_ultimo_recibo, suc_mail, suc_estado, usu_id)
             SELECT
                'B', suc_id, suc_descripcion, suc_calle, suc_numero, suc_piso, suc_departamento, suc_codigo_postal
            , suc_ciudad, suc_provincia, suc_telefono1, suc_telefono2, suc_rubro, suc_numero_sucursal
            , suc_ultima_factura, suc_ultima_nc, suc_ultima_nd, suc_ultimo_recibo, suc_mail, suc_estado, '".$_SESSION["usu_id"]."'
             FROM sucursales
             WHERE suc_id= '$this->suc_id'";
        $result=mysql_query($sql,$link);
        if ($result>0){
            $sql1="update sucursales set suc_estado = '1', usu_id = '".$_SESSION["usu_id"].
                "' where suc_id = '$this->suc_id'";
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
function getsucursales()
{
    $link=Conectarse();
    $sql="select * from sucursales where suc_estado='0'";
    $result=mysql_query($sql,$link);
    return $result;
}
function getsucursalesDes()
{
    $link=Conectarse();
    $sql="select * from sucursales where suc_estado='1'";
    $result=mysql_query($sql,$link);
    return $result;
}
function getsucursalesSQL() {
    $sql="select * from sucursales s where s.suc_estado=0 order by s.suc_descripcion";
    return $sql;
}
function getsucursalesCombo($suc_id=0) {
    $link=Conectarse();
    $html = "";
    $sql="select suc_descripcion, suc_id
        from sucursales
        where suc_estado = 0
        and ('".$_SESSION['suc_id_usu']."'=',,' or instr('".$_SESSION['suc_id_usu']."',concat(',',suc_id,',')))
        order by suc_descripcion";
    //echo'sql:'.$sql;
    //  and ('".$_SESSION['suc_id_usu']."'='' or suc_id='".$_SESSION['suc_id_usu']."')
    $consulta= mysql_query($sql, $link);
    $html = "<select name='sucursales' id='sucursales' class='formFields' onchange='filtrar();'>";
    while($row= mysql_fetch_assoc($consulta)) {
        if ($suc_id==$row["suc_id"]){
            $html = $html . '<option value='.$row["suc_id"].' selected>'.$row["suc_descripcion"].'</option>';
        } else {
            $html = $html . '<option value='.$row["suc_id"].'>'.$row["suc_descripcion"].'</option>';
        }
    }
    $html = $html . '</select>';
    return $html;
}
function getsucursales_desCombo($suc_des_id=0) {
    $link=Conectarse();
    $html = "";
    $sql="select suc_descripcion, suc_id
        from sucursales
        where suc_estado = 0
        order by suc_descripcion";
        /*and ('".$_SESSION['suc_id_usu']."'='' or suc_id='".$_SESSION['suc_id_usu']."')*/
    $consulta= mysql_query($sql, $link);
    $html = "<select name='sucursales_des' id='sucursales_des' class='formFields' >";
    while($row= mysql_fetch_assoc($consulta)) {
        if ($suc_des_id==$row["suc_id"]){
            $html = $html . '<option value='.$row["suc_id"].' selected>'.$row["suc_descripcion"].'</option>';
        } else {
            $html = $html . '<option value='.$row["suc_id"].'>'.$row["suc_descripcion"].'</option>';
        }
    }
    $html = $html . '</select>';
    return $html;
}
function getsucursalesnuloCombo($suc_id=0) {
    $link=Conectarse();
    $html = "";
    $sql="(select suc_descripcion, suc_id
        from sucursales
        where suc_estado = 0
        and ('".$_SESSION['suc_id_usu']."'=',,' or instr('".$_SESSION['suc_id_usu']."',concat(',',suc_id,','))))
        union
        (select 'Todas' suc_descripcion, '0' suc_id
        from dual)
        order by suc_descripcion";
        //and ('".$_SESSION['suc_id_usu']."'='' or suc_id='".$_SESSION['suc_id_usu']."'))
    $consulta= mysql_query($sql, $link);
    $html = "<select name='sucursales' id='sucursales' class='formFields' >";
    while($row= mysql_fetch_assoc($consulta)) {
        if ($suc_id==$row["suc_id"]){
            $html = $html . '<option value='.$row["suc_id"].' selected>'.$row["suc_descripcion"].'</option>';
        } else {
            $html = $html . '<option value='.$row["suc_id"].'>'.$row["suc_descripcion"].'</option>';
        }
    }
    $html = $html . '</select>';
    return $html;
}
/*function getsucursalesComboOT($suc_id=0) {
    $link=Conectarse();
    $html = "";
    $sql="select suc_descripcion, suc_id
        from sucursales
        where suc_estado = 0
        order by suc_descripcion";
    $consulta= mysql_query($sql, $link);
    $html = "<select name='sucursales' id='sucursales' class='formFields' onChange='modifica_suc(this.id)'> >";
    while($row= mysql_fetch_assoc($consulta)) {
        if ($suc_id==$row["suc_id"]){
            $html = $html . '<option value='.$row["suc_id"].' selected>'.$row["suc_descripcion"].'</option>';
        } else {
            $html = $html . '<option value='.$row["suc_id"].'>'.$row["suc_descripcion"].'</option>';
        }
    }
    $html = $html . '</select>';
    return $html;
}*/

function get_suc_id()
{ return $this->suc_id;}
function set_suc_id($val)
{ $this->suc_id=$val;}
function get_suc_descripcion()
{ return $this->suc_descripcion;}
function set_suc_descripcion($val)
{ $this->suc_descripcion=$val;}
function get_suc_calle()
{ return $this->suc_calle;}
function set_suc_calle($val)
{ $this->suc_calle=$val;}
function get_suc_numero()
{ return $this->suc_numero;}
function set_suc_numero($val)
{ $this->suc_numero=$val;}
function get_suc_piso()
{ return $this->suc_piso;}
function set_suc_piso($val)
{ $this->suc_piso=$val;}
function get_suc_departamento()
{ return $this->suc_departamento;}
function set_suc_departamento($val)
{ $this->suc_departamento=$val;}
function get_suc_codigo_postal()
{ return $this->suc_codigo_postal;}
function set_suc_codigo_postal($val)
{ $this->suc_codigo_postal=$val;}
function get_suc_ciudad()
{ return $this->suc_ciudad;}
function set_suc_ciudad($val)
{ $this->suc_ciudad=$val;}
function get_suc_provincia()
{ return $this->suc_provincia;}
function set_suc_provincia($val)
{ $this->suc_provincia=$val;}
function get_suc_telefono1()
{ return $this->suc_telefono1;}
function set_suc_telefono1($val)
{ $this->suc_telefono1=$val;}
function get_suc_telefono2()
{ return $this->suc_telefono2;}
function set_suc_telefono2($val)
{ $this->suc_telefono2=$val;}
function get_suc_rubro()
{ return $this->suc_rubro;}
function set_suc_rubro($val)
{ $this->suc_rubro=$val;}
function get_suc_numero_sucursal()
{ return $this->suc_numero_sucursal;}
function set_suc_numero_sucursal($val)
{ $this->suc_numero_sucursal=$val;}
function get_suc_ultima_factura()
{ return $this->suc_ultima_factura;}
function set_suc_ultima_factura($val)
{ $this->suc_ultima_factura=$val;}
function get_suc_ultima_nc()
{ return $this->suc_ultima_nc;}
function set_suc_ultima_nc($val)
{ $this->suc_ultima_nc=$val;}
function get_suc_ultima_nd()
{ return $this->suc_ultima_nd;}
function set_suc_ultima_nd($val)
{ $this->suc_ultima_nd=$val;}
function get_suc_ultimo_recibo()
{ return $this->suc_ultimo_recibo;}
function set_suc_ultimo_recibo($val)
{ $this->suc_ultimo_recibo=$val;}
function get_suc_estado()
{ return $this->suc_estado;}
function set_suc_estado($val)
{ $this->suc_estado=$val;}
function get_suc_mail()
{ return $this->suc_mail;}
function set_suc_mail($val)
{ $this->suc_mail=$val;}
function get_usu_id()
{ return $this->usu_id;}
function set_usu_id($val)
{ $this->usu_id=$val;}
}?>