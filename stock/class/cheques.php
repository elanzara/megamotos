<?php
class cheques {

var $ch_id;
var $bc_id;
var $tpg_id;
var $ch_fecha;
var $ch_fch_ch;
var $ch_numero;
var $cli_id;
var $ch_importe;
var $prv_id;
var $ch_fch_entrega;
var $ch_observaciones;
var $usu_id;
var $ch_estado;

function cheques($ch_id=0) {
if ($ch_id!=0) {
$link=Conectarse();
$consulta= mysql_query(' select * from cheques where ch_id = '.$ch_id,$link);
while($row= mysql_fetch_assoc($consulta)) {
$this->ch_id=$row['ch_id'];
$this->ch_fecha=$row['ch_fecha'];
$this->ch_fch_ch=$row['ch_fch_ch'];
$this->ch_numero=$row['ch_numero'];
$this->ch_importe=$row['ch_importe'];
$this->ch_fch_entrega=$row['ch_fch_entrega'];
$this->ch_observaciones=$row['ch_observaciones'];
$this->tpg_id=$row['tpg_id'];
$this->bc_id=$row['bc_id'];
$this->prv_id=$row['prv_id'];
$this->cli_id=$row['cli_id'];
$this->usu_id=$row['usu_id'];
$this->ch_estado=$row['ch_estado'];
}
}
}
function insert_ch() {
$link=Conectarse();

$sql="insert into cheques (
 tpg_id
, ch_fch_ch
, ch_numero
, bc_id
, cli_id
, ch_importe
, prv_id
, ch_fch_entrega
, ch_observaciones
, ch_estado
, usu_id
) values ( 
 '$this->tpg_id'
, '$this->ch_fch_ch'
, '$this->ch_numero'
, '$this->bc_id'
, '$this->cli_id'
, '$this->ch_importe'
, '$this->prv_id'
, '$this->ch_fch_entrega'
, '$this->ch_observaciones'
, '$this->ch_estado'
, '".$_SESSION["usu_id"]."'
)";
$result=mysql_query($sql,$link);
$ins_id = mysql_insert_id();
if ($ins_id>0){
   $sql1="INSERT INTO hcheques
        (tipo, ch_id, tpg_id
, ch_fecha
, ch_fch_ch
, ch_numero
, bc_id
, cli_id
, ch_importe
, prv_id
, ch_fch_entrega
, ch_observaciones
, ch_estado
, usu_id)
        VALUES
        ('I', $ins_id, '$this->tpg_id'
, '$this->ch_fecha'
, '$this->ch_fch_ch'
, '$this->ch_numero'
, '$this->bc_id'
, '$this->cli_id'
, '$this->ch_importe'
, '$this->prv_id'
, '$this->ch_fch_entrega'
, '$this->ch_observaciones'
, '$this->ch_estado'
, '".$_SESSION["usu_id"]."')";
    $result1=mysql_query($sql1,$link);
   
/*    if ($result1>0){
        return 1;
    }else {
        return 0;
    }*/
	return $sql;
} else {
    return 0;
}
}

function update_ch() {
$link=Conectarse();
$sql="INSERT INTO hcheques
     (tipo, ch_id, tpg_id
, ch_fecha
, ch_fch_ch
, ch_numero
, bc_id
, cli_id
, ch_importe
, prv_id
, ch_fch_entrega
, ch_observaciones
,ch_estado
, usu_id)
     SELECT
            'U', ch_id, tpg_id
, ch_fecha
, ch_fch_ch
, ch_numero
, bc_id
, cli_id
, ch_importe
, prv_id
, ch_fch_entrega
, ch_observaciones
, ch_estado
, '".$_SESSION["usu_id"]."'
     FROM cheques
     WHERE ch_id= '$this->ch_id'";
$result=mysql_query($sql,$link);
if ($result>0){
    $sql1="update cheques set
            ch_id = '$this->ch_id'
            , tpg_id = '$this->tpg_id'
            , ch_fecha = '$this->ch_fecha'
            , ch_fch_ch = '$this->ch_fch_ch'
            , ch_numero = '$this->ch_numero'
            , bc_id = '$this->bc_id'
            , cli_id = '$this->cli_id'
            , ch_importe = '$this->ch_importe'
            , prv_id = '$this->prv_id'
            , ch_fch_entrega = '$this->ch_fch_entrega'
            , ch_observaciones = '$this->ch_observaciones'
			, ch_estado = '$this->ch_estado'
            , usu_id = '".$_SESSION["usu_id"]."'
            where ch_id = '$this->ch_id'";
    $result1=mysql_query($sql1,$link);
    if ($result1>0){
        return 1;
    }else {
        return 0;}
} else {
    return 0;
}
}
function baja_ch(){
    $link=Conectarse();
   /* $sql1="select 0 from facturas_det where ch_id = '$this->ch_id'";
    $result1=mysql_query($sql1,$link);
    if ($row = mysql_fetch_array($result1)){
      $result1 = 0;
    } else {$result1 = 1;
    }
    $sql2="select 0 from movimientos_stock where estado='0' and ch_id = '$this->ch_id'";
    $result2=mysql_query($sql2,$link);
    if ($row = mysql_fetch_array($result2)){
      $result2 = 0;
    } else {$result2 = 2;
    }
    $sql3="select 0 from orden_trabajo_det where ch_id = '$this->ch_id'";
    $result3=mysql_query($sql3,$link);
    if ($row = mysql_fetch_array($result3)){
      $result3 = 0;
    } else {$result3 = 3;
    }
    $sql4="select 0 from stock_mensual where ch_id = '$this->ch_id'";
    $result4=mysql_query($sql4,$link);
    if ($row = mysql_fetch_array($result4)){
      $result4 = 0;
    } else {$result4 = 4;
    }
    if ($result1>0 and $result2>0 and $result3>0 and $result4>0){*/
        $sql="INSERT INTO hcheques
             (tipo,ch_id, tpg_id
, ch_fecha
, ch_fch_ch
, ch_numero
, bc_id
, cli_id
, ch_importe
, prv_id
, ch_fch_entrega
, ch_observaciones
, ch_estado
, usu_id)
             SELECT
                'B', ch_id, tpg_id
, ch_fecha
, ch_fch_ch
, ch_numero
, bc_id
, cli_id
, ch_importe
, prv_id
, ch_fch_entrega
, ch_observaciones
, ch_estado
, '".$_SESSION["usu_id"]."'
             FROM cheques
             WHERE ch_id= '$this->ch_id'";
        $result=mysql_query($sql,$link);
        if ($result>0){
            $sql1="update cheques set ch_estado = '1', usu_id = '".$_SESSION["usu_id"].
                     "' where ch_id = '$this->ch_id'";
            $result1=mysql_query($sql1,$link);
            if ($result1>0){
                return 1;
            }else {
                return 0;}
        } else {
            return 0;
        }
  //  }
}
function getcheques()
{
$link=Conectarse();
$sql="select * from cheques where ch_estado='0'";
$result=mysql_query($sql,$link);
return $result;
}
function getchequesDes()
{
$link=Conectarse();
$sql="select * from cheques where ch_estado='1'";
$result=mysql_query($sql,$link);
return $result;
}
function getchequexId($ch_id=0)
{
$link=Conectarse();
$sql="select * from cheques where ch_id= '$ch_id'";
$result=mysql_query($sql,$link);
return $result;
}

function getchequesSQL($tpg_id="",$bc_id="",$texto = "", $fecha="", $hasta="")
{
$link=Conectarse();
$fechaNormal = new fechas();
if ($tpg_id!=0 and $bc_id!=0)  {
    $sql = "SELECT p.*, a.tpg_descripcion, o.bc_descripcion,  concat(t.cli_razon_social,' - ',t.cli_nombre,' ',t.cli_apellido) cli_razon_social
            FROM cheques p
            LEFT JOIN tipo_pagos a ON p.tpg_id = a.tpg_id
            LEFT JOIN bancos o ON p.bc_id = o.bc_id
            LEFT JOIN clientes t ON p.cli_id = t.cli_id
            WHERE p.ch_estado =  '0'
            AND p.tpg_id =".$tpg_id." AND p.bc_id =".$bc_id."";
} elseif ($tpg_id!=0 and $bc_id==0)  {
    $sql = "SELECT p.*, a.tpg_descripcion, o.bc_descripcion,  concat(t.cli_razon_social,' - ',t.cli_nombre,' ',t.cli_apellido) cli_razon_social
            FROM cheques p
            LEFT JOIN tipo_pagos a ON p.tpg_id = a.tpg_id
            LEFT JOIN bancos o ON p.bc_id = o.bc_id
            LEFT JOIN clientes t ON p.cli_id = t.cli_id
            WHERE p.ch_estado =  '0'
            AND p.tpg_id =".$tpg_id."";
} 
 elseif ($tpg_id==0 and $bc_id!=0)  {
    $sql = "SELECT p.*, a.tpg_descripcion, o.bc_descripcion, concat(t.cli_razon_social,' - ',t.cli_nombre,' ',t.cli_apellido) cli_razon_social
            FROM cheques p
            LEFT JOIN tipo_pagos a ON p.tpg_id = a.tpg_id
            LEFT JOIN bancos o ON p.bc_id = o.bc_id
            LEFT JOIN clientes t ON p.cli_id = t.cli_id
            WHERE p.ch_estado =  '0'
            AND p.bc_id =".$bc_id."";
} 
  else {
    $sql = "SELECT p.*, a.tpg_descripcion, o.bc_descripcion,  concat(t.cli_razon_social,' - ',t.cli_nombre,' ',t.cli_apellido) cli_razon_social
            FROM cheques p
            LEFT JOIN tipo_pagos a ON p.tpg_id = a.tpg_id
            LEFT JOIN bancos o ON p.bc_id = o.bc_id
            LEFT JOIN clientes t ON p.cli_id = t.cli_id
            WHERE p.ch_estado =  '0'";
}
       if ($fecha != ""){
            $sql .= " and p.ch_fch_ch >= " .$fechaNormal->cambiaf_a_mysql($fecha);
        }
        if ($hasta != ""){
            $sql .= " and p.ch_fch_ch <= " .$fechaNormal->cambiaf_a_mysql($hasta);
        }
if ($texto != "") {
    $sql = $sql ." and (upper(a.tpg_descripcion) like (upper('%" . $texto ."%')) "
                ." or upper(o.bc_descripcion) like (upper('%" . $texto ."%')) "
				." or upper(p.ch_importe) like (upper('%" . $texto ."%')) "
				." or upper(p.ch_numero) like (upper('%" . $texto ."%')) "
                ." or upper(concat(t.cli_razon_social,' - ',t.cli_nombre,' ',t.cli_apellido)) like (upper('%" . $texto ."%')) )";
}
$sql.=" ORDER BY a.tpg_descripcion, o.bc_descripcion, p.ch_fch_ch, p.ch_numero";
return $sql;
}

function get_ch_id()
{ return $this->ch_id;}
function set_ch_id($val)
{ $this->ch_id=$val;}

function get_tpg_id()
{ return $this->tpg_id;}
function set_tpg_id($val)
{ $this->tpg_id=$val;}
function get_ch_fecha()
{ return $this->ch_fecha;}
function set_ch_fecha($val)
{ $this->ch_fecha=$val;}
function get_ch_fch_ch()
{ return $this->ch_fch_ch;}
function set_ch_fch_ch($val)
{ $this->ch_fch_ch=$val;}
function get_ch_numero()
{ return $this->ch_numero;}
function set_ch_numero($val)
{ $this->ch_numero=$val;}
function get_bc_id()
{ return $this->bc_id;}
function set_bc_id($val)
{ $this->bc_id=$val;}
function get_cli_id()
{ return $this->cli_id;}
function set_cli_id($val)
{ $this->cli_id=$val;}
function get_ch_importe()
{ return $this->ch_importe;}
function set_ch_importe($val)
{ $this->ch_importe=$val;}
function get_prv_id()
{ return $this->prv_id;}
function set_prv_id($val)
{ $this->prv_id=$val;}
function get_ch_fch_entrega()
{ return $this->ch_fch_entrega;}
function set_ch_fch_entrega($val)
{ $this->ch_fch_entrega=$val;}
function get_ch_observaciones()
{ return $this->ch_observaciones;}
function set_ch_observaciones($val)
{ $this->ch_observaciones=$val;}
function get_ch_estado()
{ return $this->ch_estado;}
function set_ch_estado($val)
{ $this->ch_estado=$val;}
function get_usu_id()
{ return $this->usu_id;}
function set_usu_id($val)
{ $this->usu_id=$val;}
}
?>