<?php
class movimientos_stock {

var $mov_id;
var $suc_id;
var $pro_id;
var $tim_id;
var $fecha;
var $cantidad;
var $observaciones;
var $trans_id;
var $encabezado_id;
var $remito;
var $estado;
var $ote_id;
var $usu_id;


function movimientos_stock($mov_id=0) {
if ($mov_id!=0) {
$link=Conectarse();
$consulta= mysql_query(' select * from movimientos_stock where mov_id = '.$mov_id,$link);
while($row= mysql_fetch_assoc($consulta)) {
$this->mov_id=$row['mov_id'];
$this->suc_id=$row['suc_id'];
$this->pro_id=$row['pro_id'];
$this->tim_id=$row['tim_id'];
$this->fecha=$row['fecha'];
$this->cantidad=$row['cantidad'];
$this->observaciones=$row['observaciones'];
$this->trans_id=$row['trans_id'];
$this->encabezado_id=$row['encabezado_id'];
$this->remito=$row['remito'];
$this->estado=$row['estado'];
$this->ote_id=$row['ote_id'];
$this->usu_id=$row['usu_id'];
}
}
}
function actualiza_saldo($es_baja='') {
  $link=Conectarse();
  $stm_id=0;
  ////////Verifico si es una baja de mvto stock
  if($es_baja=='B'){
    switch($this->tim_id) {
        case 1:
            $tim_id=2;
        default:
            $tim_id=1;
    }    
  } else {
    $tim_id=$this->tim_id;
  }//echo('tim_id:'.$tim_id);
  ////////Verifico si existe saldo
  $sqle="select s.stm_id,s.stm_cantidad
        from stock_mensual s
        where s.suc_id=".$this->suc_id
       ." and s.pro_id=".$this->pro_id
       ." and s.stm_fecha='".$this->fecha."'";
  $consultae= mysql_query($sqle, $link);
  if ($consultae){
        while ($rowe = mysql_fetch_assoc($consultae)) {
               $stm_id = $rowe['stm_id'];
        }
  }//echo('-stm_id:'.$stm_id);
  if ($stm_id==0){//echo('3');
  ////////No existe saldo
    $stm_cantidad=0;
    //Recupero el saldo anterior
    $sqla="select s1.stm_cantidad
        from stock_mensual s1
        where s1.suc_id=".$this->suc_id
       ." and s1.pro_id=".$this->pro_id
       ." and s1.stm_fecha=(select max(s2.stm_fecha)
                            from stock_mensual s2
                             where s2.suc_id=s1.suc_id
                             and s2.pro_id=s1.pro_id
                             and s2.stm_fecha < '".$this->fecha."')";
    $consultaa= mysql_query($sqla, $link);
    if ($consultaa){
        while ($rowa = mysql_fetch_assoc($consultaa)) {
               $stm_cantidad = $rowa['stm_cantidad'];
        }
    }
    //Inserto saldo
    if($tim_id==1){
        //Ingreso:
        $sql1="INSERT INTO stock_mensual
            (suc_id, pro_id, stm_fecha, stm_cantidad, usu_id)
            VALUES
            ('$this->suc_id', '$this->pro_id', '".$this->fecha."', $stm_cantidad+$this->cantidad
           , '".$_SESSION["usu_id"]."')";
    }else{
        //Egreso:
        $sql1="INSERT INTO stock_mensual
            (suc_id, pro_id, stm_fecha, stm_cantidad, usu_id)
            VALUES
            ('$this->suc_id', '$this->pro_id', '".$this->fecha."', $stm_cantidad-$this->cantidad
           , '".$_SESSION["usu_id"]."')";
    }
    $result1=mysql_query($sql1,$link);
  } else {//echo('-ths_cantidad:'.$this->cantidad);
    ////////Si existe saldo
    //Modifico saldo
    if($tim_id==1){
        //Ingreso:
        $sql1="UPDATE stock_mensual SET stm_cantidad= stm_cantidad+'$this->cantidad'
                where stm_id = '$stm_id'";
    }else{
        //Egreso:
        $sql1="UPDATE stock_mensual SET stm_cantidad= stm_cantidad-'$this->cantidad'
                where stm_id = '$stm_id'";
    }
    $result1=mysql_query($sql1,$link);
  }//($stm_id==0)
  //Modifico saldos posteriores
  if ($result1>0){//echo('-pos');
    if ($this->fecha < mktime(0, 0, 0, date('m'),date('d'),date('Y'))){
      if($tim_id==1){//echo('ing');
        //Ingreso:
        $sql2="UPDATE stock_mensual SET stm_cantidad= stm_cantidad+'$this->cantidad'
               where suc_id=".$this->suc_id
            ." and pro_id=".$this->pro_id
            ." and stm_fecha > '".$this->fecha."'";
        $result2=mysql_query($sql2,$link);
      }else{//echo('eg-s:'.$this->suc_id.'-p:'.$this->pro_id.'-f:'.$this->fecha);
        //Egreso:
        $sqlp="select s1.stm_id, s1.stm_cantidad
            from stock_mensual s1
            where s1.suc_id=".$this->suc_id
           ." and s1.pro_id=".$this->pro_id
           ." and s1.stm_fecha > '".$this->fecha."'";
        $consultap= mysql_query($sqlp, $link);
        if ($consultap){
            while ($rowp = mysql_fetch_assoc($consultap)) {//echo('-stm_ca:'.$rowp['stm_cantidad']);
              if ($rowp['stm_cantidad']>=$this->cantidad){//echo('-upd1');
                $sql2="UPDATE stock_mensual SET stm_cantidad= stm_cantidad-'$this->cantidad'
                       where stm_id=".$rowp['stm_id'];
              }else{//echo('-upd2');
                $sql2="UPDATE stock_mensual SET stm_cantidad= '0'
                       where stm_id=".$rowp['stm_id'];
              }
              $result2=mysql_query($sql2,$link);
            }
        }
      }//echo('res2'.$result2);//($this->tim_id==1)
      if ($result2 !='' and !$result2>0){
            return 0;
      }
    }//($this->fecha < mktime(0, 0, 0, date('m'),date('d'),date('Y')))
  }else {//echo('2');
      return 0;
  }//echo('5');//($result1>0)
  return 1;
}
function insert_mov() {
$link=Conectarse();
$sql="insert into movimientos_stock (
 suc_id
, pro_id
, tim_id
, fecha
, cantidad
, observaciones
, trans_id
, encabezado_id
, remito
, ote_id
, usu_id
) values ( 
 '$this->suc_id'
, '$this->pro_id'
, '$this->tim_id'
, '$this->fecha'
, '$this->cantidad'
, '$this->observaciones'
, '$this->trans_id'
, '$this->encabezado_id'
, '$this->remito'
, '$this->ote_id'
, '".$_SESSION["usu_id"]."'
)";
$result=mysql_query($sql,$link);
$ins_id = mysql_insert_id();
if ($ins_id>0){
    $sql1="INSERT INTO hmovimientos_stock
        (tipo, mov_id, suc_id, pro_id, tim_id, fecha
        , cantidad, observaciones, trans_id, encabezado_id, remito
        , ote_id, estado, usu_id)
        VALUES
        ('I', $ins_id, '$this->suc_id', '$this->pro_id', '$this->tim_id', '$this->fecha'
        , '$this->cantidad', '$this->observaciones', '$this->trans_id', '$this->encabezado_id', '$this->remito'
        , '$this->ote_id', 0, '".$_SESSION["usu_id"]."')";
    $result1=mysql_query($sql1,$link);
    if ($result1>0){
        $resu_saldo = $this->actualiza_saldo();
        if ($resu_saldo>0){
            return 1;
        }else {
            return 0;
        }
    }else {
        return 0;
    }
} else {
    return 0;
}
}
function update_mov() {
$link=Conectarse();
$sql="INSERT INTO hmovimientos_stock
     (tipo, mov_id, suc_id, pro_id, tim_id, fecha
        , cantidad, observaciones, trans_id, encabezado_id, remito
        , ote_id, estado, usu_id)
     SELECT
        'U', mov_id, suc_id, pro_id, tim_id, fecha
        , cantidad, observaciones, trans_id, encabezado_id, remito
        , ote_id, estado, '".$_SESSION["usu_id"]."'
     FROM movimientos_stock
     WHERE mov_id= '$this->mov_id'";
    $result=mysql_query($sql,$link);
    if ($result>0){
        $sql1="update movimientos_stock set
             suc_id = '$this->suc_id'
            , pro_id = '$this->pro_id'
            , tim_id = '$this->tim_id'
            , fecha = '$this->fecha'
            , cantidad = '$this->cantidad'
            , observaciones = '$this->observaciones'
            , trans_id = '$this->trans_id'
            , encabezado_id = '$this->encabezado_id'
            , remito = '$this->remito'
            , estado = '$this->estado'
            , ote_id = '$this->ote_id'
            , usu_id = '".$_SESSION["usu_id"]."'
            where mov_id = '$this->mov_id'";
    $result1=mysql_query($sql1,$link);
    if ($result1>0){
        return 1;
    }else {
        return 0;}
    } else {
    return 0;
    }
}
function baja_mov(){
    $link=Conectarse();
    $sql="INSERT INTO hmovimientos_stock
         (tipo, mov_id, suc_id, pro_id, tim_id, fecha
        , cantidad, observaciones, trans_id, encabezado_id, remito
        , ote_id, estado, usu_id)
         SELECT
            'B', mov_id, suc_id, pro_id, tim_id, fecha
            , cantidad, observaciones, trans_id, encabezado_id, remito
            , ote_id, estado, '".$_SESSION["usu_id"]."'
         FROM movimientos_stock
         WHERE mov_id= '$this->mov_id'";
    $result=mysql_query($sql,$link);
    if ($result>0){
        $sql1="update movimientos_stock set mov_estado = '1', usu_id = '".$_SESSION["usu_id"].
                 "' where mov_id = '$this->mov_id'";
        $result1=mysql_query($sql1,$link);
        if ($result1>0){
            $resu_saldo = $this->actualiza_saldo('B');
            if ($resu_saldo>0){
                return 1;
            }else {
                return 0;
            }
        }else {
            return 0;}
    } else {
        return 0;
    }
}
function getmovimientos_stock()
{
$link=Conectarse();
$sql="select * from movimientos_stock where estado='0'";
$result=mysql_query($sql,$link);
return $result;
}
function getmovimientos_stockDes()
{
$link=Conectarse();
$sql="select * from movimientos_stock where estado='1'";
$result=mysql_query($sql,$link);
return $result;
}
function getmovimientos_stock_detalles($encabezado_id=0, $remito="", $fecha="", $usu_id=0, $trans_id=0, $ote_id=0)
{
$link=Conectarse();
//echo'encabezado_id:'.$encabezado_id.'-remito:'.$remito.'-fecha:'.$fecha
//.'-usu_id:'.$usu_id.'-trans_id:'.$trans_id.'-ote_id:'.$ote_id;
$sql="select m.*,'' suc_destino"
    ." from movimientos_stock m "
    ." where m.estado='0' and ifNull(m.encabezado_id,0)=".$encabezado_id
    ." and ifNull(m.remito,'')='".$remito."' and m.fecha='".$fecha."' and ifNull(m.usu_id,0)=".$usu_id
    ." and ifNull(m.trans_id,0)=".$trans_id." and ifNull(m.ote_id,0)=".$ote_id
    ." and (m.trans_id is null or m.trans_id = 0)"
    ." union"
    ." select m.*, (select s1.suc_descripcion from movimientos_stock m1, sucursales s1"
    ."              where m1.suc_id=s1.suc_id and m1.trans_id=m.trans_id and m1.tim_id=1) suc_destino"
    ." from movimientos_stock m"
    ." where m.estado='0' and ifNull(m.encabezado_id,0)=".$encabezado_id
    ." and ifNull(m.remito,'')='".$remito."' and m.fecha='".$fecha."' and ifNull(m.usu_id,0)=".$usu_id
//    ." and ifNull(m.trans_id,0)=".$trans_id." and ifNull(m.ote_id,0)=".$ote_id
    ." and ifNull(m.ote_id,0)=".$ote_id
    ." and (m.trans_id is not null and m.trans_id != 0)"
    ." and m.tim_id=2"
    ." order by suc_id, pro_id";
//echo'$sql:'.$sql;
$result=mysql_query($sql,$link);
return $result;
}
function getmovimientos_stockSQL($search_sucursal="", $search_tipo_producto="", $search_producto=""
                                , $fecha="", $hasta="", $search_cod_mvto="", $search_cod_prod="")
{
$link=Conectarse();
$fechaNormal = new fechas();
if (($search_sucursal=="" or $search_sucursal=="0") and ($search_tipo_producto=="" or $search_tipo_producto=="0")
   and ($search_nombre == "") and ($fecha =="") and ($hasta =="") and ($search_cod_mvto=="" or $search_cod_mvto == "0")
   and ($search_cod_prod=="" or $search_cod_prod == "0") ){
//and ('".$_SESSION['suc_id_usu']."'='' or s.suc_id='".$_SESSION['suc_id_usu']."')
//and ('".$_SESSION['suc_id_usu']."'='' or s.suc_id='".$_SESSION['suc_id_usu']."')
//and ('".$_SESSION['suc_id_usu']."'='' or s.suc_id='".$_SESSION['suc_id_usu']."')
//and ('".$_SESSION['suc_id_usu']."'='' or s.suc_id='".$_SESSION['suc_id_usu']."')
//and ('".$_SESSION['suc_id_usu']."'='' or s.suc_id='".$_SESSION['suc_id_usu']."')
    //Ingreso/Egreso:
    $sql="select m.*, s.suc_descripcion, p.pro_descripcion, tp.tip_descripcion, t.tim_descripcion tipo_mvto
            ,null suc_destino
          from movimientos_stock m
                ,sucursales s
                ,tipo_productos tp
                ,productos p
                ,tipo_movimientos t
            where m.estado='0'
            and m.suc_id=s.suc_id
            and ('".$_SESSION['suc_id_usu']."'=',,' or instr('".$_SESSION['suc_id_usu']."',concat(',',s.suc_id,',')))
            and m.pro_id=p.pro_id
            and tp.tip_id=p.tip_id
            and m.tim_id=t.tim_id
            and (m.trans_id is null or m.trans_id = 0)
            union
            select m.*, s.suc_descripcion, p.pro_descripcion, tp.tip_descripcion,'Transferencia' tipo_mvto
                ,(select s1.suc_descripcion from movimientos_stock m1, sucursales s1
                    where m1.suc_id=s1.suc_id and m1.trans_id=m.trans_id and m1.tim_id=1) suc_destino
            from movimientos_stock m
                ,sucursales s
                ,tipo_productos tp
                ,productos p
                ,tipo_movimientos t
            where m.estado='0'
            and m.suc_id=s.suc_id
            and ('".$_SESSION['suc_id_usu']."'=',,' or instr('".$_SESSION['suc_id_usu']."',concat(',',s.suc_id,',')))
            and m.pro_id=p.pro_id
            and tp.tip_id=p.tip_id
            and m.tim_id=t.tim_id
            and (m.trans_id is not null and m.trans_id != 0)
            and m.tim_id=2
            order by mov_id desc";
       } else {
       $sql="select m.*, s.suc_descripcion, p.pro_descripcion, tp.tip_descripcion, t.tim_descripcion tipo_mvto
            ,null suc_destino
              from movimientos_stock m
                    ,sucursales s
                    ,tipo_productos tp
                    ,productos p
                    ,tipo_movimientos t
            where m.estado='0'
            and m.suc_id=s.suc_id
            and ('".$_SESSION['suc_id_usu']."'=',,' or instr('".$_SESSION['suc_id_usu']."',concat(',',s.suc_id,',')))
            and m.pro_id=p.pro_id
            and tp.tip_id=p.tip_id
            and m.tim_id=t.tim_id
            and (m.trans_id is null or m.trans_id = 0)
             and ('".$search_sucursal."' = ''
                  or '".$search_sucursal."' = '0'
                  or ('".$search_sucursal."' <> '' and s.suc_id = '".$search_sucursal."')
                  )
             and ('".$search_tipo_producto."' = ''
                  or '".$search_tipo_producto."' = '0'
                  or ('".$search_tipo_producto."' <> '' and tp.tip_id = '".$search_tipo_producto."')
                  )
             and ('".$search_cod_mvto."' = ''
                  or '".$search_cod_mvto."' = '0'
                  or ('".$search_cod_mvto."' <> '' and m.encabezado_id = '".$search_cod_mvto."')
                  )
             and ('".$search_cod_prod."' = ''
                  or '".$search_cod_prod."' = '0'
                  or ('".$search_cod_prod."' <> '' and p.pro_id = '".$search_cod_prod."')
                  )
             and ('".$search_producto."' = ''
                  or '".$search_producto."' = '0'
                  or ('".$search_producto."' <> '' and p.pro_id = '".$search_producto."')
                  )";
        if ($fecha != ""){
            $sql .= " and m.fecha >= " . $fechaNormal->cambiaf_a_mysql($fecha);
        }
        if ($hasta != ""){
            $sql .= " and m.fecha <= " . $fechaNormal->cambiaf_a_mysql($hasta);
        }
        $sql .= " union
            select m.*, s.suc_descripcion, p.pro_descripcion, tp.tip_descripcion,'Transf-Egreso' tipo_mvto
                ,(select s1.suc_descripcion from movimientos_stock m1, sucursales s1
                    where m1.suc_id=s1.suc_id and m1.trans_id=m.trans_id and m1.tim_id=1) suc_destino
            from movimientos_stock m
                ,sucursales s
                ,tipo_productos tp
                ,productos p
                ,tipo_movimientos t
            where m.estado='0'
            and m.suc_id=s.suc_id
            and ('".$_SESSION['suc_id_usu']."'=',,' or instr('".$_SESSION['suc_id_usu']."',concat(',',s.suc_id,',')))
            and m.pro_id=p.pro_id
            and tp.tip_id=p.tip_id
            and m.tim_id=t.tim_id
            and (m.trans_id is not null and m.trans_id != 0)
            and m.tim_id=2
             and ('".$search_sucursal."' = ''
                  or '".$search_sucursal."' = '0'
                  or ('".$search_sucursal."' <> '' and s.suc_id = '".$search_sucursal."')
                  )
             and ('".$search_tipo_producto."' = ''
                  or '".$search_tipo_producto."' = '0'
                  or ('".$search_tipo_producto."' <> '' and tp.tip_id = '".$search_tipo_producto."')
                  )
             and ('".$search_cod_mvto."' = ''
                  or '".$search_cod_mvto."' = '0'
                  or ('".$search_cod_mvto."' <> '' and m.encabezado_id = '".$search_cod_mvto."')
                  )
             and ('".$search_cod_prod."' = ''
                  or '".$search_cod_prod."' = '0'
                  or ('".$search_cod_prod."' <> '' and p.pro_id = '".$search_cod_prod."')
                  )
             and ('".$search_producto."' = ''
                  or '".$search_producto."' = '0'
                  or ('".$search_producto."' <> '' and p.pro_id = '".$search_producto."')
                  )";
            if ($fecha != ""){
                $sql .= " and m.fecha >= " .$fechaNormal->cambiaf_a_mysql($fecha);
            }
            if ($hasta != ""){
                $sql .= " and m.fecha <= " . $fechaNormal->cambiaf_a_mysql($hasta);
            }
                  
            $sql .= " union
            select m.*, s.suc_descripcion, p.pro_descripcion, tp.tip_descripcion,'Transf-Ingreso' tipo_mvto
                ,(select s1.suc_descripcion from movimientos_stock m1, sucursales s1
                    where m1.suc_id=s1.suc_id and m1.trans_id=m.trans_id and m1.tim_id=2) suc_destino
            from movimientos_stock m
                ,sucursales s
                ,tipo_productos tp
                ,productos p
                ,tipo_movimientos t
            where m.estado='0'
            and m.suc_id=s.suc_id
            and ('".$_SESSION['suc_id_usu']."'=',,' or instr('".$_SESSION['suc_id_usu']."',concat(',',s.suc_id,',')))
            and m.pro_id=p.pro_id
            and tp.tip_id=p.tip_id
            and m.tim_id=t.tim_id
            and (m.trans_id is not null and m.trans_id != 0)
            and m.tim_id=1
             and ('".$search_sucursal."' = ''
                  or '".$search_sucursal."' = '0'
                  or ('".$search_sucursal."' <> '' and s.suc_id = '".$search_sucursal."')
                  )
             and ('".$search_tipo_producto."' = ''
                  or '".$search_tipo_producto."' = '0'
                  or ('".$search_tipo_producto."' <> '' and tp.tip_id = '".$search_tipo_producto."')
                  )
             and ('".$search_cod_mvto."' = ''
                  or '".$search_cod_mvto."' = '0'
                  or ('".$search_cod_mvto."' <> '' and m.encabezado_id = '".$search_cod_mvto."')
                  )
             and ('".$search_cod_prod."' = ''
                  or '".$search_cod_prod."' = '0'
                  or ('".$search_cod_prod."' <> '' and p.pro_id = '".$search_cod_prod."')
                  )
             and ('".$search_producto."' = ''
                  or '".$search_producto."' = '0'
                  or ('".$search_producto."' <> '' and p.pro_id = '".$search_producto."')
                  )";
            if ($fecha != ""){
                $sql .= " and m.fecha >= " .$fechaNormal->cambiaf_a_mysql($fecha);
            }
            if ($hasta != ""){
                $sql .= " and m.fecha <= " . $fechaNormal->cambiaf_a_mysql($hasta);
            }
                  
            $sql .= " order by mov_id desc";
       }
return $sql;
//if (($search_sucursal=="" or $search_categoria=="0") and ($search_tipo_producto=="" or $search_tipo_producto=="0")
//     and ($search_nombre == "")){
//    //Ingreso/Egreso:
//    $sql="select m.*, s.suc_descripcion, p.pro_descripcion, tp.tip_descripcion, t.tim_descripcion tipo_mvto
//            ,null suc_destino
//          from movimientos_stock m
//                ,sucursales s
//                ,tipo_productos tp
//                ,productos p
//                ,tipo_movimientos t
//            where m.estado='0'
//            and m.suc_id=s.suc_id
//            and m.pro_id=p.pro_id
//            and tp.tip_id=p.tip_id
//            and m.tim_id=t.tim_id
//            and (m.trans_id is null or m.trans_id = 0)
//            union
//            select m.*, s.suc_descripcion, p.pro_descripcion, tp.tip_descripcion,'Transferencia' tipo_mvto
//                ,(select s1.suc_descripcion from movimientos_stock m1, sucursales s1
//                    where m1.suc_id=s1.suc_id and m1.trans_id=m.trans_id and m1.tim_id=1) suc_destino
//            from movimientos_stock m
//                ,sucursales s
//                ,tipo_productos tp
//                ,productos p
//                ,tipo_movimientos t
//            where m.estado='0'
//            and m.suc_id=s.suc_id
//            and m.pro_id=p.pro_id
//            and tp.tip_id=p.tip_id
//            and m.tim_id=t.tim_id
//            and (m.trans_id is not null and m.trans_id != 0)
//            and m.tim_id=2
//            order by mov_id desc";
//       } else {
//       $sql="select m.*, s.suc_descripcion, p.pro_descripcion, tp.tip_descripcion, t.tim_descripcion tipo_mvto
//            ,null suc_destino
//              from movimientos_stock m
//                    ,sucursales s
//                    ,tipo_productos tp
//                    ,productos p
//                    ,tipo_movimientos t
//            where m.estado='0'
//            and m.suc_id=s.suc_id
//            and m.pro_id=p.pro_id
//            and tp.tip_id=p.tip_id
//            and m.tim_id=t.tim_id
//            and (m.trans_id is null or m.trans_id = 0)
//             and ('".$search_sucursal."' = ''
//                  or '".$search_sucursal."' = '0'
//                  or ('".$search_sucursal."' <> '' and s.suc_id = '".$search_sucursal."')
//                  )
//             and ('".$search_tipo_producto."' = ''
//                  or '".$search_tipo_producto."' = '0'
//                  or ('".$search_tipo_producto."' <> '' and tp.tip_id = '".$search_tipo_producto."')
//                  )
//             and ('".$search_producto."' = ''
//                  or '".$search_producto."' = '0'
//                  or ('".$search_producto."' <> '' and p.pro_id = '".$search_producto."')
//                  )
//            union
//            select m.*, s.suc_descripcion, p.pro_descripcion, tp.tip_descripcion,'Transferencia' tipo_mvto
//                ,(select s1.suc_descripcion from movimientos_stock m1, sucursales s1
//                    where m1.suc_id=s1.suc_id and m1.trans_id=m.trans_id and m1.tim_id=1) suc_destino
//            from movimientos_stock m
//                ,sucursales s
//                ,tipo_productos tp
//                ,productos p
//                ,tipo_movimientos t
//            where m.estado='0'
//            and m.suc_id=s.suc_id
//            and m.pro_id=p.pro_id
//            and tp.tip_id=p.tip_id
//            and m.tim_id=t.tim_id
//            and (m.trans_id is not null and m.trans_id != 0)
//            and m.tim_id=2
//             and ('".$search_sucursal."' = ''
//                  or '".$search_sucursal."' = '0'
//                  or ('".$search_sucursal."' <> '' and s.suc_id = '".$search_sucursal."')
//                  )
//             and ('".$search_tipo_producto."' = ''
//                  or '".$search_tipo_producto."' = '0'
//                  or ('".$search_tipo_producto."' <> '' and tp.tip_id = '".$search_tipo_producto."')
//                  )
//             and ('".$search_producto."' = ''
//                  or '".$search_producto."' = '0'
//                  or ('".$search_producto."' <> '' and p.pro_id = '".$search_producto."')
//                  )
//            order by mov_id desc";
//       }
}
function getNumeroTrans(){
    $link=Conectarse();
    $consulta= mysql_query("select max(s.trans_id) trans_id from movimientos_stock s where s.trans_id is not null",$link);
    while($row= mysql_fetch_assoc($consulta)) {
      if ($row['trans_id']!=''){
        $trans_id = $row['trans_id']+1;
      }else{
        $trans_id = 1;}
    }
    mysql_query($sql, $link);
    return $trans_id;
}
function getNumeroEncabezado(){
    $link=Conectarse();
    $consulta= mysql_query("select max(s.encabezado_id) encabezado_id from movimientos_stock s where s.encabezado_id is not null",$link);
    while($row= mysql_fetch_assoc($consulta)) {
      if ($row['encabezado_id']!=''){
        $encabezado_id = $row['encabezado_id']+1;
      }else{
        $encabezado_id = 1;}
    }
    mysql_query($sql, $link);
    return $encabezado_id;
}

function get_mov_id()
{ return $this->mov_id;}
function set_mov_id($val)
{ $this->mov_id=$val;}
function get_suc_id()
{ return $this->suc_id;}
function set_suc_id($val)
{ $this->suc_id=$val;}
function get_pro_id()
{ return $this->pro_id;}
function set_pro_id($val)
{ $this->pro_id=$val;}
function get_tim_id()
{ return $this->tim_id;}
function set_tim_id($val)
{ $this->tim_id=$val;}
function get_fecha()
{ return $this->fecha;}
function set_fecha($val)
{ $this->fecha=$val;}
function get_cantidad()
{ return $this->cantidad;}
function set_cantidad($val)
{ $this->cantidad=$val;}
function get_observaciones()
{ return $this->observaciones;}
function set_observaciones($val)
{ $this->observaciones=$val;}
function get_trans_id()
{ return $this->trans_id;}
function set_trans_id($val)
{ $this->trans_id=$val;}
function get_encabezado_id()
{ return $this->encabezado_id;}
function set_encabezado_id($val)
{ $this->encabezado_id=$val;}
function get_remito()
{ return $this->remito;}
function set_remito($val)
{ $this->remito=$val;}
function get_estado()
{ return $this->estado;}
function set_estado($val)
{ $this->estado=$val;}
function get_ote_id()
{ return $this->ote_id;}
function set_ote_id($val)
{ $this->ote_id=$val;}
function get_usu_id()
{ return $this->usu_id;}
function set_usu_id($val)
{ $this->usu_id=$val;}
}
?>