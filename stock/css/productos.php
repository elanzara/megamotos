<?php
class productos {

var $pro_id;
var $mod_id;
var $mar_id;
var $dis_id;
var $prv_id;
var $tip_id;
var $pro_med_diametro;
var $pro_med_ancho;
var $pro_med_alto;
var $pro_nueva;
var $pro_distribucion;
var $pro_stock_min;
var $pro_precio_costo;
var $pro_descripcion;

var $pro_tipo_llanta;
var $pro_material;
var $pro_terminaciones;
var $pro_controla_stock;
var $pro_anio;
var $tr_id;
var $pro_foto;
var $pro_terminacion;
var $pro_clasificacion; /*A , C o R (A de Auto, C de camioneta y R de Replica.)*/
var $usu_id;
var $pro_estado;

function productos($pro_id=0) {
if ($pro_id!=0) {
$link=Conectarse();
$consulta= mysql_query(' select * from productos where pro_id = '.$pro_id,$link);
while($row= mysql_fetch_assoc($consulta)) {
$this->pro_id=$row['pro_id'];
$this->mod_id=$row['mod_id'];
$this->mar_id=$row['mar_id'];
$this->dis_id=$row['dis_id'];
$this->prv_id=$row['prv_id'];
$this->tip_id=$row['tip_id'];
$this->pro_med_diametro=$row['pro_med_diametro'];
$this->pro_med_ancho=$row['pro_med_ancho'];
$this->pro_med_alto=$row['pro_med_alto'];
$this->pro_nueva=$row['pro_nueva'];
$this->pro_distribucion=$row['pro_distribucion'];
$this->pro_stock_min=$row['pro_stock_min'];
$this->pro_precio_costo=$row['pro_precio_costo'];
$this->pro_descripcion=$row['pro_descripcion'];

$this->pro_tipo_llanta=$row['pro_tipo_llanta'];
$this->pro_material=$row['pro_material'];
$this->pro_terminaciones=$row['pro_terminaciones'];
$this->pro_controla_stock=$row['pro_controla_stock'];
$this->pro_anio=$row['pro_anio'];
$this->tr_id=$row['tr_id'];
$this->pro_foto=$row['pro_foto'];
$this->pro_terminacion=$row['pro_terminacion'];
$this->pro_clasificacion=$row['pro_clasificacion'];
$this->usu_id=$row['usu_id'];
$this->pro_estado=$row['pro_estado'];
}
}
}
function insert_pro() {
$link=Conectarse();
if ($this->pro_med_diametro=='') {$v_med_diametro = 'null';} else {$v_med_diametro = $this->pro_med_diametro;}
if ($this->pro_med_ancho=='') {$v_med_ancho = 'null';} else {$v_med_ancho = $this->pro_med_ancho;}
if ($this->pro_med_alto=='') {$v_med_alto = 'null';} else {$v_med_alto = $this->pro_med_alto;}
if ($this->pro_nueva=='') {$v_nueva = 'null';} else {$v_nueva = $this->pro_nueva;}
if ($this->pro_stock_min=='') {$v_stock_min = 'null';} else {$v_stock_min = $this->pro_stock_min;}
if ($this->pro_precio_costo=='') {$v_precio_costo = 'null';} else {$v_precio_costo = $this->pro_precio_costo;}
$sql="insert into productos (
 mod_id
, mar_id
, dis_id
, prv_id
, tip_id
, pro_med_diametro
, pro_med_ancho
, pro_med_alto
, pro_nueva
, pro_distribucion
, pro_stock_min
, pro_precio_costo
, pro_descripcion
, pro_tipo_llanta
, pro_material
, pro_terminaciones
, pro_controla_stock
, pro_anio
, tr_id
, pro_foto
, pro_terminacion
, pro_clasificacion
, usu_id
) values ( 
 '$this->mod_id'
, '$this->mar_id'
, '$this->dis_id'
, '$this->prv_id'
, '$this->tip_id'
, $v_med_diametro
, $v_med_ancho
, $v_med_alto
, $v_nueva
, '$this->pro_distribucion'
, $v_stock_min
, $v_precio_costo
, '$this->pro_descripcion'
, '$this->pro_tipo_llanta'
, '$this->pro_material'
, '$this->pro_terminaciones'
, '$this->pro_controla_stock'
, '$this->pro_anio'
, '$this->tr_id'
, '$this->pro_foto'
, '$this->pro_terminacion'
, '$this->pro_clasificacion'
, '".$_SESSION["usu_id"]."'
)";
$result=mysql_query($sql,$link);
$ins_id = mysql_insert_id();
if ($ins_id>0){
    $sql1="INSERT INTO hproductos
        (tipo, pro_id, mod_id, mar_id, dis_id, prv_id
        , tip_id, pro_med_diametro, pro_med_ancho, pro_med_alto, pro_nueva
        , pro_distribucion, pro_stock_min, pro_precio_costo, pro_descripcion, pro_tipo_llanta
        , pro_material, pro_terminaciones, pro_controla_stock, pro_anio
        , tr_id, pro_foto, pro_terminacion, pro_clasificacion
        , pro_estado, usu_id)
        VALUES
        ('I', $ins_id, '$this->mod_id', '$this->mar_id', '$this->dis_id', '$this->prv_id'
        , '$this->tip_id', $v_med_diametro, $v_med_ancho, $v_med_alto, $v_nueva
        , '$this->pro_distribucion', $v_stock_min, $v_precio_costo, '$this->pro_descripcion', '$this->pro_tipo_llanta'
        , '$this->pro_material', '$this->pro_terminaciones', '$this->pro_controla_stock', '$this->pro_anio'
        , '$this->tr_id', '$this->pro_foto', '$this->pro_terminacion', '$this->pro_clasificacion'
        , 0, '".$_SESSION["usu_id"]."')";
    $result1=mysql_query($sql1,$link);
    /*return $sql;*/
    if ($result1>0){
        return 1;
    }else {
        return 0;
    }
} else {
    return 0;
}
}
function update_pro() {
$link=Conectarse();
if ($this->pro_med_diametro=='') {$v_med_diametro = 'null';} else {$v_med_diametro = $this->pro_med_diametro;}
if ($this->pro_med_ancho=='') {$v_med_ancho = 'null';} else {$v_med_ancho = $this->pro_med_ancho;}
if ($this->pro_med_alto=='') {$v_med_alto = 'null';} else {$v_med_alto = $this->pro_med_alto;}
if ($this->pro_nueva=='') {$v_nueva = 'null';} else {$v_nueva = $this->pro_nueva;}
if ($this->pro_stock_min=='') {$v_stock_min = 'null';} else {$v_stock_min = $this->pro_stock_min;}
if ($this->pro_precio_costo=='') {$v_precio_costo = 'null';} else {$v_precio_costo = $this->pro_precio_costo;}
$sql="INSERT INTO hproductos
     (tipo, pro_id, mod_id, mar_id, dis_id, prv_id
        , tip_id, pro_med_diametro, pro_med_ancho, pro_med_alto, pro_nueva
        , pro_distribucion, pro_stock_min, pro_precio_costo, pro_descripcion, pro_tipo_llanta
        , pro_material, pro_terminaciones, pro_controla_stock, pro_anio
        , tr_id, pro_foto, pro_terminacion, pro_clasificacion
        , pro_estado, usu_id)
     SELECT
            'U', pro_id, mod_id, mar_id, dis_id, prv_id
            , tip_id, pro_med_diametro, pro_med_ancho, pro_med_alto, pro_nueva
            , pro_distribucion, pro_stock_min, pro_precio_costo, pro_descripcion, pro_tipo_llanta
            , pro_material, pro_terminaciones, pro_controla_stock, pro_anio
            , tr_id, pro_foto, pro_terminacion, pro_clasificacion
            , pro_estado, '".$_SESSION["usu_id"]."'
     FROM productos
     WHERE pro_id= '$this->pro_id'";
$result=mysql_query($sql,$link);
if ($result>0){
    $sql1="update productos set
            pro_id = '$this->pro_id'
            , mod_id = '$this->mod_id'
            , mar_id = '$this->mar_id'
            , dis_id = '$this->dis_id'
            , prv_id = '$this->prv_id'
            , tip_id = '$this->tip_id'
            , pro_med_diametro = $v_med_diametro
            , pro_med_ancho = $v_med_ancho
            , pro_med_alto = $v_med_alto
            , pro_nueva = $v_nueva
            , pro_distribucion = '$this->pro_distribucion'
            , pro_stock_min = $v_stock_min
            , pro_precio_costo = $v_precio_costo
            , pro_descripcion = '$this->pro_descripcion'
            , pro_tipo_llanta = '$this->pro_tipo_llanta'
            , pro_material = '$this->pro_material'
            , pro_terminaciones = '$this->pro_terminaciones'
            , pro_controla_stock = '$this->pro_controla_stock'
            , pro_anio = '$this->pro_anio'
            , tr_id = '$this->tr_id'
            , pro_foto = '$this->pro_foto'
            , pro_terminacion = '$this->pro_terminacion'
            , pro_clasificacion = '$this->pro_clasificacion'
            , usu_id = '".$_SESSION["usu_id"]."'
            where pro_id = '$this->pro_id'";
    $result1=mysql_query($sql1,$link);
    if ($result1>0){
        return 1;
    }else {
        return 0;}
} else {
    return 0;
}
}
function baja_pro(){
    $link=Conectarse();
    $sql1="select 0 from facturas_det where pro_id = '$this->pro_id'";
    $result1=mysql_query($sql1,$link);
    if ($row = mysql_fetch_array($result1)){
      $result1 = 0;
    } else {$result1 = 1;
    }
    $sql2="select 0 from movimientos_stock where estado='0' and pro_id = '$this->pro_id'";
    $result2=mysql_query($sql2,$link);
    if ($row = mysql_fetch_array($result2)){
      $result2 = 0;
    } else {$result2 = 2;
    }
    $sql3="select 0 from orden_trabajo_det where pro_id = '$this->pro_id'";
    $result3=mysql_query($sql3,$link);
    if ($row = mysql_fetch_array($result3)){
      $result3 = 0;
    } else {$result3 = 3;
    }
    $sql4="select 0 from stock_mensual where pro_id = '$this->pro_id'";
    $result4=mysql_query($sql4,$link);
    if ($row = mysql_fetch_array($result4)){
      $result4 = 0;
    } else {$result4 = 4;
    }
    if ($result1>0 and $result2>0 and $result3>0 and $result4>0){
        $sql="INSERT INTO hproductos
             (tipo, pro_id, mod_id, mar_id, dis_id, prv_id
            , tip_id, pro_med_diametro, pro_med_ancho, pro_med_alto, pro_nueva
            , pro_distribucion, pro_stock_min, pro_precio_costo, pro_descripcion, pro_tipo_llanta
            , pro_material, pro_terminaciones, pro_controla_stock, pro_anio
            , tr_id, pro_foto, pro_terminacion, pro_clasificacion
            , pro_estado, usu_id)
             SELECT
                'B', pro_id, mod_id, mar_id, dis_id, prv_id
                , tip_id, pro_med_diametro, pro_med_ancho, pro_med_alto, pro_nueva
                , pro_distribucion, pro_stock_min, pro_precio_costo, pro_descripcion, pro_tipo_llanta
                , pro_material, pro_terminaciones, pro_controla_stock, pro_anio
                , tr_id, pro_foto, pro_terminacion, pro_clasificacion
                , pro_estado, '".$_SESSION["usu_id"]."'
             FROM productos
             WHERE pro_id= '$this->pro_id'";
        $result=mysql_query($sql,$link);
        if ($result>0){
            $sql1="update productos set pro_estado = '1', usu_id = '".$_SESSION["usu_id"].
                     "' where pro_id = '$this->pro_id'";
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
function getproductos()
{
$link=Conectarse();
$sql="select * from productos where pro_estado='0'";
$result=mysql_query($sql,$link);
return $result;
}
function getproductosDes()
{
$link=Conectarse();
$sql="select * from productos where pro_estado='1'";
$result=mysql_query($sql,$link);
return $result;
}
function getproductoxId($pro_id=0)
{
$link=Conectarse();
$sql="select * from productos where pro_id= '$pro_id'";
$result=mysql_query($sql,$link);
return $result;
}
function getproductosSQL($mod_id=0)
{
$link=Conectarse();
if ($mod_id==0) {
    $sql="select p.*,a.*,o.* from productos p, marcas a, modelos o
          where p.mar_id=a.mar_id and p.mod_id=o.mod_id and p.pro_estado='0'";
} else {
    $sql="select p.*,a.*,o.* from productos p, marcas a, modelos o
          where p.mar_id=a.mar_id and p.mod_id=o.mod_id and p.pro_estado='0' and p.mod_id = '$mod_id'";
}
return $sql;
}

function getproductosSQL2($tip_id=0)
{
$link=Conectarse();
if ($tip_id==0) {
    //$sql="select p.*,a.*,o.* from productos p, marcas a, modelos o
    //      where p.mar_id=a.mar_id and p.mod_id=o.mod_id and p.pro_estado='0'";
    $sql = "SELECT p.*, a.*, o.*, t.*, r.*
            FROM productos p
            LEFT JOIN marcas a ON p.mar_id = a.mar_id
            LEFT JOIN modelos o ON p.mod_id = o.mod_id
            LEFT JOIN tipo_productos t ON p.tip_id = t.tip_id
            LEFT JOIN tipo_rango r ON p.tr_id = r.tr_id
            WHERE p.pro_estado =  '0'";
            //AND p.tip_id =6
} else {
    //$sql="select p.*,a.*,o.* from productos p, marcas a, modelos o
    //      where p.mar_id=a.mar_id and p.mod_id=o.mod_id and p.pro_estado='0' and p.tip_id = ".$tip_id;
    $sql = "SELECT p.*, a.*, o.*, t.*, r.*
            FROM productos p
            LEFT JOIN marcas a ON p.mar_id = a.mar_id
            LEFT JOIN modelos o ON p.mod_id = o.mod_id
            LEFT JOIN tipo_productos t ON p.tip_id = t.tip_id
            LEFT JOIN tipo_rango r ON p.tr_id = r.tr_id
            WHERE p.pro_estado =  '0'
            AND p.tip_id =".$tip_id;
}
return $sql;
}

function getproductosSQLxTipMod($tip_id=0,$mar_id=0)
{
$link=Conectarse();
if ($tip_id!=0 and $mar_id!=0) {
    $sql = "SELECT p.*, a.mar_descripcion, o.mod_descripcion, t.tip_descripcion, r.tr_descripcion
            FROM productos p
            LEFT JOIN marcas a ON p.mar_id = a.mar_id
            LEFT JOIN modelos o ON p.mod_id = o.mod_id
            LEFT JOIN tipo_productos t ON p.tip_id = t.tip_id
            LEFT JOIN tipo_rango r ON p.tr_id = r.tr_id
            WHERE p.pro_estado =  '0'
            AND p.tip_id =".$tip_id." AND p.mar_id =".$mar_id."
            ORDER BY t.tip_descripcion, a.mar_descripcion, o.mod_descripcion, p.pro_descripcion";
} elseif ($tip_id!=0 and $mar_id==0)  {
    $sql = "SELECT p.*, a.mar_descripcion, o.mod_descripcion, t.tip_descripcion, r.tr_descripcion
            FROM productos p
            LEFT JOIN marcas a ON p.mar_id = a.mar_id
            LEFT JOIN modelos o ON p.mod_id = o.mod_id
            LEFT JOIN tipo_productos t ON p.tip_id = t.tip_id
            LEFT JOIN tipo_rango r ON p.tr_id = r.tr_id
            WHERE p.pro_estado =  '0'
            AND p.tip_id =".$tip_id."
            ORDER BY t.tip_descripcion, a.mar_descripcion, o.mod_descripcion, p.pro_descripcion";
} else {
    $sql = "SELECT p.*, a.mar_descripcion, o.mod_descripcion, t.tip_descripcion, r.tr_descripcion
            FROM productos p
            LEFT JOIN marcas a ON p.mar_id = a.mar_id
            LEFT JOIN modelos o ON p.mod_id = o.mod_id
            LEFT JOIN tipo_productos t ON p.tip_id = t.tip_id
            LEFT JOIN tipo_rango r ON p.tr_id = r.tr_id
            WHERE p.pro_estado =  '0'
            ORDER BY t.tip_descripcion, a.mar_descripcion, o.mod_descripcion, p.pro_descripcion";
}
return $sql;
}

function getproductosSQLxTipModTexto($tip_id=0,$mar_id=0,$texto = "")
{
$link=Conectarse();
if ($tip_id!=0 and $mar_id!=0) {
    $sql = "SELECT p.*, a.mar_descripcion, o.mod_descripcion, t.tip_descripcion, r.tr_descripcion
            FROM productos p
            LEFT JOIN marcas a ON p.mar_id = a.mar_id
            LEFT JOIN modelos o ON p.mod_id = o.mod_id
            LEFT JOIN tipo_productos t ON p.tip_id = t.tip_id
            LEFT JOIN tipo_rango r ON p.tr_id = r.tr_id
            WHERE p.pro_estado =  '0'
            AND p.tip_id =".$tip_id." AND p.mar_id =".$mar_id."";
} elseif ($tip_id!=0 and $mar_id==0)  {
    $sql = "SELECT p.*, a.mar_descripcion, o.mod_descripcion, t.tip_descripcion, r.tr_descripcion
            FROM productos p
            LEFT JOIN marcas a ON p.mar_id = a.mar_id
            LEFT JOIN modelos o ON p.mod_id = o.mod_id
            LEFT JOIN tipo_productos t ON p.tip_id = t.tip_id
            LEFT JOIN tipo_rango r ON p.tr_id = r.tr_id
            WHERE p.pro_estado =  '0'
            AND p.tip_id =".$tip_id."";
} else {
    $sql = "SELECT p.*, a.mar_descripcion, o.mod_descripcion, t.tip_descripcion, r.tr_descripcion
            FROM productos p
            LEFT JOIN marcas a ON p.mar_id = a.mar_id
            LEFT JOIN modelos o ON p.mod_id = o.mod_id
            LEFT JOIN tipo_productos t ON p.tip_id = t.tip_id
            LEFT JOIN tipo_rango r ON p.tr_id = r.tr_id
            WHERE p.pro_estado =  '0'";
}
if ($texto != "") {
    $sql = $sql ." and (upper(t.tip_descripcion) like (upper('%" . $texto ."%')) "
                ." or upper(a.mar_descripcion) like (upper('%" . $texto ."%')) "
                ." or upper(o.mod_descripcion) like (upper('%" . $texto ."%')) "
                ." or upper(r.tr_descripcion) like (upper('%" . $texto ."%')) "
                ." or upper(p.pro_descripcion) like (upper('%" . $texto ."%')) "
                ." or upper(p.pro_med_ancho) like (upper('%" . $texto ."%')) "
                ." or upper(p.pro_med_alto) like (upper('%" . $texto ."%')) "
                ." or upper(p.pro_med_diametro) like (upper('%" . $texto ."%')) "
                ." or upper(p.pro_precio_costo) like (upper('%" . $texto ."%')) "
                ." or upper(p.pro_id) like (upper('%" . $texto ."%')) "
                ." or upper(p.pro_distribucion) like (upper('%" . $texto ."%')) "
                ." or upper(p.pro_terminacion) like (upper('%" . $texto ."%')) "
                ." or upper(p.pro_clasificacion) like (upper('%" . $texto ."%'))) ";
}
$sql.=" ORDER BY t.tip_descripcion, a.mar_descripcion, o.mod_descripcion, p.pro_descripcion";
return $sql;
}

//En base al código de producto y sucursal la funcion devuelve el stock al momento.
//Dicha función debe validar el ultimo stock de dicho producto / sucursal dentro de la tabla stock_mensual y
//luego sumar y restar los movimientos de la tabla movimientos_stock.
function getCantidadProductoOrig($pro_id=0,$suc_id=0) {
    $link=Conectarse();
    $cant_inicial = 0;
    $cantidad_stock = 0;
    $cantidad = 0;
    //Recupero cantidad inicial del mes actual
    $sql="select ifnull(sum(s.stm_cantidad),0) cantidad
        from stock_mensual s
        where s.pro_id = ".$pro_id.
        " and s.suc_id = ".$suc_id.
        " and year(s.stm_fecha)=year(curdate())
        and month(s.stm_fecha)=month(curdate())";
//    (select max(s1.fecha)
//                    from stock_mensual s1
//                    where s1.pro_id = ".$pro_id.
//                    " and s1.suc_id =".$suc_id.")"
    $consulta= mysql_query($sql, $link);
    if ($consulta){
        while ($row = mysql_fetch_assoc($consulta)) {
            if ($row['cantidad'] == ""){
                $cant_inicial = 0;}
            else {
                $cant_inicial = $row['cantidad'];
            }
        }
    }
    //if($cant_inicial!=""){
        //Recupero movimientos stock
        $sql1="select ifnull(sum(cast(m.cantidad as signed)*(case m.tim_id when 1 then 1 else (-1) end)),0) cantidad
            from movimientos_stock m
            where m.estado=0
            and m.pro_id = ".$pro_id.
            " and m.suc_id = ".$suc_id;
//DESCOMENTAR
//            " and year(m.fecha)=year(curdate())
//            and month(m.fecha)=month(curdate())";
        $consulta1= mysql_query($sql1, $link);
        if ($consulta1){
            while ($row1 = mysql_fetch_assoc($consulta1)) {
                if ($row1['cantidad'] == ""){
                    $cantidad_stock = 0;}
                else {
                    $cantidad_stock = $row1['cantidad'];
                }
            }
        }
    //}
    $sql = "select pro_controla_stock from productos where pro_id = ".$pro_id;
    $consulta = mysql_query($sql, $link);
    $pro_controla_stock = "N";
    while ($row = mysql_fetch_assoc($consulta)) {
        $pro_controla_stock = $row["pro_controla_stock"];
    }
    if ($pro_controla_stock == "S"){
        $cantidad=$cant_inicial+$cantidad_stock;        
    } else {
        $cantidad=0;
    }
    //$cantidad=$cant_inicial+$cantidad_stock;
    return $cantidad;
}

function getCantidadProducto($pro_id=0,$suc_id=0) {
    $link=Conectarse();
    $cant_inicial = 0;
    $cantidad_stock = 0;
    $cantidad = 0;
    $fecha_stock = '';
    //Recupero cantidad inicial
    $sql="select ifnull(s.stm_cantidad,0) cantidad, s.stm_fecha
        from stock_mensual s
        where s.pro_id = ".$pro_id.
        " and s.suc_id = ".$suc_id.
        " and s.stm_fecha = (select max(s1.stm_fecha)
                    from stock_mensual s1
                    where s1.pro_id = s.pro_id
                    and s1.suc_id = s.suc_id
	            and s1.stm_fecha <= curdate())";
    $consulta= mysql_query($sql, $link);
    if ($consulta){
        while ($row = mysql_fetch_assoc($consulta)) {
            if ($row['cantidad'] == ""){
                $cant_inicial = 0;
                $fecha_stock = '';
                }
            else {
                $cant_inicial = $row['cantidad'];
                $fecha_stock = $row['stm_fecha'];
            }
        }
    }
    //Recupero movimientos stock
    $sql1="select ifnull(sum(cast(m.cantidad as signed)*(case m.tim_id when 1 then 1 else (-1) end)),0) cantidad
        from movimientos_stock m
        where m.estado=0
        and m.pro_id = ".$pro_id.
        " and m.suc_id = ".$suc_id.
        " and m.fecha > '".$fecha_stock."'
          and m.fecha <= curdate()";
        //DESCOMENTAR
        //" and year(m.fecha)=year(curdate())
        //and month(m.fecha)=month(curdate())";
    $consulta1= mysql_query($sql1, $link);
    if ($consulta1){
        while ($row1 = mysql_fetch_assoc($consulta1)) {
            if ($row1['cantidad'] == ""){
                $cantidad_stock = 0;}
            else {
                $cantidad_stock = $row1['cantidad'];
            }
        }
    }
    $sql = "select pro_controla_stock from productos where pro_id = ".$pro_id;
    $consulta = mysql_query($sql, $link);
    $pro_controla_stock = "N";
    while ($row = mysql_fetch_assoc($consulta)) {
        $pro_controla_stock = $row["pro_controla_stock"];
    }
    if ($pro_controla_stock == "S"){
        $cantidad=$cant_inicial+$cantidad_stock;
    } else {
        $cantidad=0;
    }
    //$cantidad=$cant_inicial+$cantidad_stock;
    return $cantidad;
}

function getproductosCombo($pro_id=0, $tip_id=0) {
    $link=Conectarse();
    $html = "";
    $sql=" select 'Elige' as pro_descripcion, 'Elige' as pro_id, 0 as orden
        union
        select pro_descripcion, pro_id, 1 as orden
        from productos
        where pro_estado = 0 ";
    if ($tip_id != 0){
        $sql .=" and tip_id = " . $tip_id;    
    }        
    $sql .=" order by orden, pro_descripcion";
    $consulta= mysql_query($sql, $link);
    $html = "<select name='productos' id='productos' class='formFields'  onChange='cargaContenido(this.id)'>";
    while($row= mysql_fetch_assoc($consulta)) {
        if ($pro_id==$row["pro_id"]){
            $html = $html . '<option value='.$row["pro_id"].' selected>'.$row["pro_descripcion"].'</option>';
        } else {
            $html = $html . '<option value='.$row["pro_id"].'>'.$row["pro_descripcion"].'</option>';
        }
    }
    $html = $html . '</select>';
    return $html;
}
function getproductosComboTipId($tip_id=0,$pro_id=0) {
    $link=Conectarse();
    $html = "";
    $sql="select concat(IFNULL(p.pro_descripcion,' '),' ',IFNULL(p.pro_med_diametro,' ')) pro_descripcion, p.pro_id
        from productos p
        where p.pro_estado = 0
        and p.tip_id = ".$tip_id.
       " order by p.pro_descripcion";
    $consulta= mysql_query($sql, $link);
    $html = "<select name='productos' id='productos' class='formFields'  onChange='cargaContenido(this.id)'>";
    while($row= mysql_fetch_assoc($consulta)) {
        if ($pro_id==$row["pro_id"]){
            $html = $html . '<option value='.$row["pro_id"].' selected>'.$row["pro_descripcion"].'</option>';
        } else {
            $html = $html . '<option value='.$row["pro_id"].'>'.$row["pro_descripcion"].'</option>';
        }
    }
    $html = $html . '</select>';
    return $html;
}

/*Devuelve un combo con los distintos rodados cargados*/
function getRodadosSelect ($pro_med_diametro = 0, $tip_id = 0) {
    $link=Conectarse();
    $html = "";
    $sql="select distinct pro_med_diametro as rodado, 2 as orden
        from productos
        where pro_estado = 0 ";
    if ($tip_id != 0){
        $sql .= " and tip_id = " . $tip_id;    
    }        
    $sql .= " union 
        select 'TODOS' as rodado, 1 as orden
        order by 2,1";
    $consulta= mysql_query($sql, $link);
    $html = "<select name='rodados' id='rodados' class='formFields'  >";
    while($row= mysql_fetch_assoc($consulta)) {
        if ($pro_med_diametro==$row["rodado"]){
            $html = $html . '<option value='.$row["rodado"].' selected>'.$row["rodado"].'</option>';
        } else {
            $html = $html . '<option value='.$row["rodado"].'>'.$row["rodado"].'</option>';
        }
    }
    $html = $html . '</select>';
    return $html;
}
/*Devuelve un combo con los distintos anchos cargados*/
function getAnchoSelect ($pro_med_ancho = 0, $tip_id = 0) {
    $link=Conectarse();
    $html = "";
    $sql="select distinct pro_med_ancho as ancho, 2 as orden
        from productos
        where pro_estado = 0 ";
        if ($tip_id != 0){
            $sql .= " and tip_id = " . $tip_id;    
        }        
        $sql .= " union 
        select 'TODOS' as ancho, 1 as orden
        order by 2,1";
    $consulta= mysql_query($sql, $link);
    $html = "<select name='anchos' id='anchos' class='formFields'  >";
    while($row= mysql_fetch_assoc($consulta)) {
        if ($pro_med_ancho==$row["ancho"]){
            $html = $html . '<option value='.$row["ancho"].' selected>'.$row["ancho"].'</option>';
        } else {
            $html = $html . '<option value='.$row["ancho"].'>'.$row["ancho"].'</option>';
        }
    }
    $html = $html . '</select>';
    return $html;
}
/*Devuelve un combo con los distintos distribuciones cargados*/
function getDistribucionSelect ($pro_distribucion = 0) {
    $link=Conectarse();
    $html = "";
    $sql="select distinct pro_distribucion as distribucion, 2 as orden
        from productos
        where pro_estado = 0 ";
        if ($tip_id != 0){
            $sql .= " and tip_id = " . $tip_id;    
        }        
        $sql .= " union 
        select 'TODOS' as distribucion, 1 as orden
        order by 2,1";
    $consulta= mysql_query($sql, $link);
    $html = "<select name='distribucion' id='distribucion' class='formFields'  >";
    while($row= mysql_fetch_assoc($consulta)) {
        if ($pro_distribucion==$row["distribucion"]){
            $html = $html . '<option value='.$row["distribucion"].' selected>'.$row["distribucion"].'</option>';
        } else {
            $html = $html . '<option value='.$row["distribucion"].'>'.$row["distribucion"].'</option>';
        }
    }
    $html = $html . '</select>';
    return $html;
}
/*Devuelve un combo con los distintos laterales cargados*/
function getLateralSelect ($pro_med_alto = 0) {
    $link=Conectarse();
    $html = "";
    $sql="select distinct pro_med_alto as lateral, 2 as orden
        from productos
        where pro_estado = 0
        union 
        select 'TODOS' as lateral, 1 as orden
        order by 2,1";
    $consulta= mysql_query($sql, $link);
    $html = "<select name='lateral' id='lateral' class='formFields'  >";
    while($row= mysql_fetch_assoc($consulta)) {
        if ($pro_med_alto==$row["lateral"]){
            $html = $html . '<option value='.$row["lateral"].' selected>'.$row["lateral"].'</option>';
        } else {
            $html = $html . '<option value='.$row["lateral"].'>'.$row["lateral"].'</option>';
        }
    }
    $html = $html . '</select>';
    return $html;
}


function getproductosCombo_MS($tip_id=0,$mar_id=0,$mod_id=0,$pro_med_ancho='',$pro_med_diametro=''
        ,$pro_distribucion='',$tr_id=0,$pro_nueva='',$pro_med_alto='',$pro_descripcion='',$tipo='I'
        ,$suc_id='',$pro_id=0) {
    $link=Conectarse();
    $html = "";
    $sql_select = "";
    $sql_enc = "";
    $sql = "";
    //$sql="select concat(p.pro_descripcion,' Diámetro:',p.pro_med_diametro,' Ancho:',p.pro_med_ancho,' Alto:',p.pro_med_alto,' Distribución:',p.pro_distribucion) pro_descripcion, pro_id
    $sql_select="select substr(concat((case p.tip_id when 4 then '' else concat(t.tip_descripcion,'-') end)
                ,ifNull(p.pro_descripcion,'')";
    //    $sql_enc=",' Diámetro:',ifNull(p.pro_med_diametro,' ')
    //        ,' Ancho:',ifNull(p.pro_med_ancho,' '),' Alto:',ifNull(p.pro_med_alto,' ')
    //        ,' Distribución:',ifNull(p.pro_distribucion,' ')";
    $sql="),1,60) pro_descripcion, p.pro_id
        from productos p
            LEFT JOIN marcas m ON p.mar_id=m.mar_id
            LEFT JOIN modelos o ON p.mod_id=o.mod_id
            LEFT JOIN tipo_rango r ON p.tr_id = r.tr_id
            LEFT JOIN tipo_productos t ON p.tip_id = t.tip_id
        where p.pro_estado = 0";
    if ($pro_id!=0) {
        $sql.=" and p.pro_id = ".$pro_id;
    }
    if ($tip_id!=0) {
        $sql.=" and p.tip_id = ".$tip_id;
    }
    if ($mar_id!=0) {
        $sql.=" and p.mar_id = ".$mar_id;
    }else{
        if ($tip_id == 2 || $tip_id == 4 || $tip_id == 9){
            $sql_enc.=",'-',ifNull(m.mar_descripcion,' ')";
        }
    }
    if ($mod_id!=0) {
        $sql.=" and p.mod_id = ".$mod_id;
    }else{
        if ($tip_id == 2 || $tip_id == 4 || $tip_id == 9){
            $sql_enc.=",'-',ifNull(o.mod_descripcion,' ')";
        }
    }
    if ($pro_med_ancho!='') {
        $sql.=" and p.pro_med_ancho = ".$pro_med_ancho;
    }else{
        if ($tip_id == 2 || $tip_id == 4 || $tip_id == 9){
            $sql_enc.=",' (',ifNull(p.pro_med_ancho,' ')";
        }
    }
    if ($pro_med_alto!='') {
        $sql.=" and p.pro_med_alto = ".$pro_med_alto;
    }else{
        if ($tip_id == 2 || $tip_id == 4 || $tip_id == 9){
            $sql_enc.=",' / ',ifNull(p.pro_med_alto,' ')";
        }
    }
    if ($pro_med_diametro!='') {
        $sql.=" and p.pro_med_diametro = ".$pro_med_diametro;
    }else{
        if ($tip_id == 2 || $tip_id == 4 || $tip_id == 9){
            $sql_enc.=",' / ',ifNull(p.pro_med_diametro,' ')";
        }
    }
    if ($pro_distribucion!='') {
        $sql.=" and upper(p.pro_distribucion) like '%".strtoupper($pro_distribucion)."%'";
    }else{
        if ($tip_id == 2 || $tip_id == 4 || $tip_id == 9){
            $sql_enc.=",' ',ifNull(p.pro_distribucion,' '),')'";
        }
    }
    if ($tr_id!=0) {
        $sql.=" and p.tr_id = ".$tr_id;
    }else{
        if ($tip_id == 2 || $tip_id == 4 || $tip_id == 9){
            $sql_enc.=",' ',ifNull(r.tr_descripcion,' ')";
        }
    }
    if ($pro_nueva!='') {
        $sql.=" and p.pro_nueva = ".$pro_nueva;
    }else{
        if ($tip_id == 2 || $tip_id == 4 || $tip_id == 9){
            $sql_enc.=",' ',(case p.pro_nueva when 1 then 'Nuevo' else '' end)";
        }
    }
    if ($pro_descripcion!='') {
        $sql.=" and upper(p.pro_descripcion) like '%".strtoupper($pro_descripcion)."%'";
    }
    $sql.=" order by p.pro_descripcion";
    //echo'cons:'.$sql_select.$sql_enc.$sql;
    $consulta= mysql_query($sql_select.$sql_enc.$sql, $link);
    $html = "<select name='productos_ms' id='productos_ms' class='formFields' style='whidth: 50px;'>";
    if ($consulta){
      while($row= mysql_fetch_assoc($consulta)) {
        if ($tipo=='E' or $tipo=='T') {
          $cant_prod=$this->getCantidadProducto($row["pro_id"],$suc_id);
          if (is_null($cant_prod)){$cant_prod=0;}
          if ($cant_prod>0){
            if ($pro_id==$row["pro_id"]){
                $html = $html . '<option value='.$row["pro_id"].' selected>'.$row["pro_descripcion"].'</option>';
            } else {
                $html = $html . '<option value='.$row["pro_id"].'>'.$row["pro_descripcion"].'</option>';
            }
          }
        }else{
            if ($pro_id==$row["pro_id"]){
                $html = $html . '<option value='.$row["pro_id"].' selected>'.$row["pro_descripcion"].'</option>';
            } else {
                $html = $html . '<option value='.$row["pro_id"].'>'.$row["pro_descripcion"].'</option>';
            }
        }
      }
    }else{
       $html = $html . '<option value=""></option>';
    }
    $html = $html . '</select>';
    return $html;
}

function getstock_productosSQL($search_sucursal = "",$search_tipo_producto = "",$search_nombre = "")
{
$link=Conectarse();
if (($search_sucursal=="" or $search_categoria=="0") and ($search_tipo_producto=="" or $search_tipo_producto=="0")
     and ($search_nombre == "")){
    $sql="select m.mar_descripcion, mo.mod_descripcion, p.*, tp.tip_descripcion, s.suc_id, s.suc_descripcion
        ,(case p.pro_nueva when 1 then 'Nuevo' else '' end) estado
          from movimientos_stock ms
            LEFT JOIN productos p ON ms.pro_id=p.pro_id
            LEFT JOIN marcas m ON p.mar_id=m.mar_id
            LEFT JOIN modelos mo ON p.mod_id=mo.mod_id
            LEFT JOIN tipo_productos tp ON tp.tip_id=p.tip_id
            LEFT JOIN sucursales s ON s.suc_id=ms.suc_id
        where p.pro_estado='0'
        and ('".$_SESSION['suc_id_usu']."'='' or s.suc_id='".$_SESSION['suc_id_usu']."')
        group by p.pro_id,ms.suc_id
        order by s.suc_descripcion,tp.tip_descripcion,p.pro_descripcion";
       } else {
       $sql="select m.mar_descripcion, mo.mod_descripcion, p.*, tp.tip_descripcion, s.suc_id, s.suc_descripcion
           ,(case p.pro_nueva when 1 then 'Nuevo' else '' end) estado
              from movimientos_stock ms
                LEFT JOIN productos p ON ms.pro_id=p.pro_id
                LEFT JOIN marcas m ON p.mar_id=m.mar_id
                LEFT JOIN modelos mo ON p.mod_id=mo.mod_id
                LEFT JOIN tipo_productos tp ON tp.tip_id=p.tip_id
                LEFT JOIN sucursales s ON s.suc_id=ms.suc_id
            where p.pro_estado='0'
            and ('".$_SESSION['suc_id_usu']."'='' or s.suc_id='".$_SESSION['suc_id_usu']."')
            and ('".$search_sucursal."' = ''
                  or '".$search_sucursal."' = '0'
                  or ('".$search_sucursal."' <> '' and s.suc_id = '".$search_sucursal."')
                  )
             and ('".$search_tipo_producto."' = ''
                  or '".$search_tipo_producto."' = '0'
                  or ('".$search_tipo_producto."' <> '' and tp.tip_id = '".$search_tipo_producto."')
                  )
             and ('".$search_producto."' = ''
                  or '".$search_producto."' = '0'
                  or ('".$search_producto."' <> '' and p.pro_id = '".$search_producto."')
                  )
            group by p.pro_id,ms.suc_id
            order by s.suc_descripcion,tp.tip_descripcion,p.pro_descripcion";
       }
return $sql;
}
function get_pro_id()
{ return $this->pro_id;}
function set_pro_id($val)
{ $this->pro_id=$val;}
function get_mod_id()
{ return $this->mod_id;}
function set_mod_id($val)
{ $this->mod_id=$val;}
function get_mar_id()
{ return $this->mar_id;}
function set_mar_id($val)
{ $this->mar_id=$val;}
function get_dis_id()
{ return $this->dis_id;}
function set_dis_id($val)
{ $this->dis_id=$val;}
function get_prv_id()
{ return $this->prv_id;}
function set_prv_id($val)
{ $this->prv_id=$val;}
function get_tip_id()
{ return $this->tip_id;}
function set_tip_id($val)
{ $this->tip_id=$val;}
function get_pro_med_diametro()
{ return $this->pro_med_diametro;}
function set_pro_med_diametro($val)
{ $this->pro_med_diametro=$val;}
function get_pro_med_ancho()
{ return $this->pro_med_ancho;}
function set_pro_med_ancho($val)
{ $this->pro_med_ancho=$val;}
function get_pro_med_alto()
{ return $this->pro_med_alto;}
function set_pro_med_alto($val)
{ $this->pro_med_alto=$val;}
function get_pro_nueva()
{ return $this->pro_nueva;}
function set_pro_nueva($val)
{ $this->pro_nueva=$val;}
function get_pro_distribucion()
{ return $this->pro_distribucion;}
function set_pro_distribucion($val)
{ $this->pro_distribucion=$val;}
function get_pro_stock_min()
{ return $this->pro_stock_min;}
function set_pro_stock_min($val)
{ $this->pro_stock_min=$val;}
function get_pro_precio_costo()
{ return $this->pro_precio_costo;}
function set_pro_precio_costo($val)
{ $this->pro_precio_costo=$val;}
function get_pro_estado()
{ return $this->pro_estado;}
function set_pro_estado($val)
{ $this->pro_estado=$val;}
function get_pro_descripcion()
{ return $this->pro_descripcion;}
function set_pro_descripcion($val)
{ $this->pro_descripcion=$val;}
function get_pro_tipo_llanta()
{ return $this->pro_tipo_llanta;}
function set_pro_tipo_llanta($val)
{ $this->pro_tipo_llanta=$val;}
function get_pro_material()
{ return $this->pro_material;}
function set_pro_material($val)
{ $this->pro_material=$val;}
function get_pro_terminaciones()
{ return $this->pro_terminaciones;}
function set_pro_terminaciones($val)
{ $this->pro_terminaciones=$val;}
function get_pro_controla_stock()
{ return $this->pro_controla_stock;}
function set_pro_controla_stock($val)
{ $this->pro_controla_stock=$val;}
function get_pro_anio()
{ return $this->pro_anio;}
function set_pro_anio($val)
{ $this->pro_anio=$val;}
function get_tr_id()
{ return $this->tr_id;}
function set_tr_id($val)
{ $this->tr_id=$val;}
function get_pro_foto()
{ return $this->pro_foto;}
function set_pro_foto($val)
{ $this->pro_foto=$val;}
function get_pro_terminacion()
{ return $this->pro_terminacion;}
function set_pro_terminacion($val)
{ $this->pro_terminacion=$val;}
function get_pro_clasificacion()
{ return $this->pro_clasificacion;}
function set_pro_clasificacion($val)
{ $this->pro_clasificacion=$val;}
function get_usu_id()
{ return $this->usu_id;}
function set_usu_id($val)
{ $this->usu_id=$val;}
}
?>