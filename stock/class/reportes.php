<?php
class reportes {

function get_rep_productos_ingresados($tip_id=0, $mar_id=0, $suc_id=0, $desde='', $hasta='') {
  //echo'd:'.$desde.'  h:'.$hasta;
     $link=Conectarse();
     $sql = "select
         substr(r.tip_descripcion,1,10) tip_descripcion
        , substr(s.suc_descripcion,1,10) suc_descripcion
        , substr(a.mar_descripcion,1,20) mar_descripcion
        , substr(o.mod_descripcion,1,40) mod_descripcion
        , m.mov_id
        , m.fecha
        , p.pro_id
        , substr(p.pro_descripcion,1,25) pro_descripcion
        , p.pro_med_diametro
        , p.pro_med_ancho
        , p.pro_med_alto
        , (case p.pro_nueva when 1 then 'Nuevo' else 'Usado' end) as pro_nueva
        , sum(m.cantidad) cantidad
        , p.pro_precio_costo
        , p.pro_controla_stock
        from movimientos_stock m, productos p, tipo_productos r
           , sucursales s, marcas a, modelos o
        where
        m.pro_id=p.pro_id and p.mar_id=a.mar_id and p.mod_id=o.mod_id and p.tip_id=r.tip_id
        and m.suc_id=s.suc_id and m.tim_id=1 and m.estado = 0";
    if($tip_id!='' and $tip_id!='0'){
     $sql .= " and p.tip_id= $tip_id";
    }
    if($mar_id!='' and $mar_id!='0'){
     $sql .= " and p.mar_id= $mar_id";
    }
    if($suc_id!='' and $suc_id!='0'){
     $sql .= " and m.suc_id= $suc_id";
    }
    if($desde!='' and $hasta!=''){
     $sql .= " and m.fecha between '$desde' and '$hasta'";
//     $sql .= " and (m.fecha >= '.$desde.' and m.fecha <= '.$hasta.')";
    }
     $sql .= " group by p.pro_id, p.pro_descripcion, p.pro_med_diametro, p.pro_med_ancho, p.pro_med_alto
            , (case p.pro_nueva when 1 then 'Nuevo' else 'Usado' end), p.pro_precio_costo, p.pro_controla_stock
            , r.tip_descripcion, s.suc_descripcion, a.mar_descripcion, o.mod_descripcion, m.fecha
        order by m.fecha
        , s.suc_descripcion
        , a.mar_descripcion
        , o.mod_descripcion
        , p.pro_id";//echo'sql:'.$sql;
     $consulta= mysql_query($sql, $link);
     return $consulta;
  }

function get_rep_productos_vendidos($tip_id=0,$mar_id=0,$suc_id='0',$desde='',$hasta='') {
     $link=Conectarse();
     $sql = "select
         substr(r.tip_descripcion,1,10) tip_descripcion
        , substr(s.suc_descripcion,1,10) suc_descripcion
        , substr(a.mar_descripcion,1,20) mar_descripcion
        , substr(o.mod_descripcion,1,40) mod_descripcion
        , d.ote_id       
        , p.pro_id
        , substr(p.pro_descripcion,1,30) pro_descripcion
        , p.pro_med_diametro
        , p.pro_med_ancho
        , p.pro_med_alto
        , (case p.pro_nueva when 1 then 'Nuevo' else 'Usado' end) as pro_nueva
         , sum(d.cantidad) cantidad
        , p.pro_precio_costo
        , p.pro_controla_stock
        from orden_trabajo_det d, orden_trabajo_enc t, productos p, tipo_productos r
        , sucursales s, marcas a, modelos o
        where
        d.pro_id=p.pro_id and p.mar_id=a.mar_id and p.mod_id=o.mod_id and t.ote_id=d.ote_id
        and t.suc_id=s.suc_id and p.tip_id=r.tip_id and t.estado != 1";
//and ('".$_SESSION['suc_id_usu']."'=',,' or instr('".$_SESSION['suc_id_usu']."',concat(',',s.suc_id,',')))
//and ('".$_SESSION['suc_id_usu']."'='' or s.suc_id='".$_SESSION['suc_id_usu']."')";
    if($tip_id!='' and $tip_id!='0'){
     $sql .= " and p.tip_id= $tip_id";
    }
    if($mar_id!='' and $mar_id!='0'){
     $sql .= " and p.mar_id= $mar_id";
    }
    if($suc_id!='' and $suc_id!='0'){
     $sql .= " and t.suc_id= $suc_id";
    }
    if($desde!='' and $hasta!=''){
     $sql .= " and t.fecha between '$desde' and '$hasta'";
    }
     $sql .= " group by p.pro_id, p.pro_descripcion, p.pro_med_diametro, p.pro_med_ancho, p.pro_med_alto
            , (case p.pro_nueva when 1 then 'Nuevo' else 'Usado' end), p.pro_precio_costo, p.pro_controla_stock
            , r.tip_descripcion, s.suc_descripcion, a.mar_descripcion, o.mod_descripcion
        order by s.suc_descripcion
        , a.mar_descripcion
        , o.mod_descripcion
        , p.pro_id";
     $consulta= mysql_query($sql, $link);
     return $consulta;
  }

function get_rep_stock($tip_id=0,$mar_id=0,$suc_id='0') {
     $link=Conectarse();
     $sql = "SELECT tip_id
	              , productos.pro_id
                  , marcas.mar_id
                  , substr(marcas.mar_descripcion,1,10) mar_descripcion
                  , modelos.mod_id
                  , modelos.mod_descripcion
                  , pro_med_ancho 
                  , pro_med_alto 
                  , pro_med_diametro 
                  , (select substr(tipo_rango.tr_descripcion,1,4) from tipo_rango  where (case productos.tr_id when 0 then 9 else productos.tr_id end) = tipo_rango.tr_id) tr_descripcion 
                  , substr(pro_descripcion,1,30) pro_descripcion
                  ,(case productos.pro_nueva when 1 then 'Nuevo' else 'Usado' end) as pro_nueva
                  ,substr(pro_clasificacion,1,30)  pro_clasificacion
                  ,substr(pro_terminacion,1,30) pro_terminacion
                  , (SELECT ifnull(m.stm_cantidad,0)
                     FROM  stock_mensual m
                     where ";
		             if($suc_id!='' and $suc_id!='0'){
                        $sql .= " m.suc_id= ".$suc_id;
                       }
		 $sql .= " and m.pro_id = productos.pro_id
		           and ifnull(m.stm_cantidad,0) > 0
				   and m.stm_fecha = (select max(s1.stm_fecha)
                                      from stock_mensual s1
                                      where s1.pro_id = productos.pro_id
									  and ifnull(s1.stm_cantidad,0) > 0
                                      and s1.suc_id = m.suc_id)) cantidad
                   FROM productos
                      , marcas
                      , modelos					 
                   WHERE ";
				   
				 if($tip_id!='' and $tip_id!='0'){
                   $sql .= " tip_id= ".$tip_id;
                    }
									   
         $sql .= " and marcas.mar_id = productos.mar_id
                   and modelos.mod_id = productos.mod_id
				   and (SELECT ifnull(m.stm_cantidad,0)
                     FROM  stock_mensual m
                     where";
					 
					if($suc_id!='' and $suc_id!='0'){
                        $sql .= " m.suc_id= ".$suc_id;
                       }
          $sql .= "and m.pro_id = productos.pro_id
                   and ifnull(m.stm_cantidad,0) > 0
                   and m.stm_fecha = (select max(s1.stm_fecha)
                                      from stock_mensual s1
                                      where s1.pro_id = productos.pro_id
                   and ifnull(s1.stm_cantidad,0) > 0
                                      and s1.suc_id = m.suc_id)) > 0";
				
				 if($mar_id!='' and $mar_id!='0'){
                   $sql .= " and marcas.mar_id= ".$mar_id;
                   }
          $sql .= " and productos.pro_estado = 0
                   group by productos.pro_id, 
				            marcas.mar_id, 
							marcas.mar_descripcion, 
							modelos.mod_id, 
							modelos.mod_descripcion, 
							pro_med_ancho, 
							pro_med_alto, 
							pro_med_diametro, 
							productos.tr_id, 
							pro_descripcion, 
							(case productos.pro_nueva when 1 then 'Nuevo' else 'Usado' end),
							pro_clasificacion,
                            pro_terminacion
                   order by marcas.mar_descripcion, 
				            modelos.mod_descripcion,  
							pro_med_ancho, 
							pro_med_alto, 
							pro_med_diametro,
							productos.tr_id";    
     $consulta= mysql_query($sql, $link);
     return $consulta;
  }

function get_rep_listado_ot($suc_id='0',$desde='',$hasta='') {
     $link=Conectarse();
//     echo'ses_suc:'.$_SESSION['suc_id_usu'];
     $sql = "select
         substr(s.suc_descripcion,1,10) suc_descripcion
        , t.ote_id
        , t.fecha
        , t.numero
        , substr(t.observaciones,1,20) observaciones
        , t.realizo
        , (select substr(p.pmo_descripcion,1,30) from promociones p where t.pmo_id=p.pmo_id) pmo_descripcion 
        , substr(concat(IFNULL(c.cli_apellido,''),' - ', IFNULL(c.cli_nombre,''), ' ' ,IFNULL(c.cli_razon_social,'')),1,20) as cliente
        , (case t.estado when 0 then 'Pendiente' when 2 then 'En ejecución' when 3 then 'A Facturar'
            when 4 then 'Finalizada' else 'Cancelada' end) as estado
        , sum(d.cantidad) cantidad
        , sum(d.cantidad*d.precio) importe
        from orden_trabajo_det d, orden_trabajo_enc t, sucursales s, clientes c
        where
        t.ote_id=d.ote_id and t.suc_id=s.suc_id and t.cli_id=c.cli_id and t.estado != 1";
//and ('".$_SESSION['suc_id_usu']."'='' or s.suc_id='".$_SESSION['suc_id_usu']."')
//        and ('".$_SESSION['suc_id_usu']."'=',,' or instr('".$_SESSION['suc_id_usu']."',concat(',',s.suc_id,',')))";
    if($suc_id!='' and $suc_id!='0'){
     $sql .= " and t.suc_id= $suc_id";
    }
    if($desde!='' and $hasta!=''){
     $sql .= " and t.fecha between '$desde' and '$hasta'";
    }
     $sql .= " group by substr(s.suc_descripcion,1,10), t.ote_id, t.fecha, t.numero, substr(t.observaciones,1,20)
            , t.realizo, (select substr(p.pmo_descripcion,1,30) from promociones p where t.pmo_id=p.pmo_id)
            , substr(concat(IFNULL(c.cli_apellido,''),' - ', IFNULL(c.cli_nombre,''), ' ' ,IFNULL(c.cli_razon_social,'')),1,20)
            , (case t.estado when 0 then 'Pendiente' when 2 then 'En ejecución' when 3 then 'A Facturar'
                when 4 then 'Finalizada' else 'Cancelada' end)
        order by t.fecha
        , s.suc_descripcion
        , t.ote_id";
     $consulta= mysql_query($sql, $link);
     return $consulta;
  }

function get_rep_resumen_diario($desde='',$hasta='') {
     $link=Conectarse();
     $sql = "select
 substr(s.suc_descripcion,1,10) suc_descripcion
, p.tip_id
, substr(r.tip_descripcion,1,13) tip_descripcion
, substr(a.mar_descripcion,1,20) mar_descripcion
, substr(o.mod_descripcion,1,13) mod_descripcion
, d.ote_id
, t.fecha
, p.pro_id
, substr(p.pro_descripcion,1,20) pro_descripcion
, p.pro_med_diametro
, p.pro_med_ancho
, p.pro_med_alto
, (case p.pro_nueva when 1 then 'Nuevo' else 'Usado' end) as pro_nueva
, sum(d.cantidad) cantidad
, p.pro_precio_costo
, p.pro_controla_stock
from orden_trabajo_det d, orden_trabajo_enc t, productos p
, tipo_productos r, sucursales s, marcas a, modelos o
where
d.pro_id=p.pro_id and p.mar_id=a.mar_id and p.mod_id=o.mod_id and t.ote_id=d.ote_id
and t.suc_id=s.suc_id and p.tip_id=r.tip_id and t.estado != 1";
    if($desde!='' and $hasta!=''){
     $sql .= " and t.fecha between '$desde' and '$hasta'";
    }
     $sql .= " group by p.pro_id, p.pro_descripcion, p.pro_med_diametro, p.pro_med_ancho, p.pro_med_alto
            , (case p.pro_nueva when 1 then 'Nuevo' else 'Usado' end), p.pro_precio_costo, p.pro_controla_stock, p.tip_id
            , s.suc_descripcion, a.mar_descripcion, o.mod_descripcion, t.fecha
order by s.suc_descripcion
, r.tip_descripcion
, a.mar_descripcion
, o.mod_descripcion
, p.pro_id";
     $consulta= mysql_query($sql, $link);
     return $consulta;
  }

function get_rep_compara_saldos($tip_id=0, $suc_id=0) {
     $link=Conectarse();
     $sql = "select
         substr(r.tip_descripcion,1,10) tip_descripcion
        , substr(s.suc_descripcion,1,10) suc_descripcion
        , (select substr(a.mar_descripcion,1,20) from marcas a where p.mar_id=a.mar_id) mar_descripcion
        , (select substr(o.mod_descripcion,1,20) from modelos o where p.mod_id=o.mod_id) mod_descripcion";
    if($suc_id!='' and $suc_id!='0'){
     $sql .= " , (select ifnull(sum(cast(m.cantidad as signed)*(case m.tim_id when 1 then 1 else (-1) end)),0)
            from movimientos_stock m
            where m.estado=0
            and m.pro_id = p.pro_id
            and m.suc_id= $suc_id)";
    }
     $sql .= " as saldo_viejo
        , p.pro_id
        , $suc_id as suc_id
        , substr(p.pro_descripcion,1,25) pro_descripcion
        , p.pro_med_diametro
        , p.pro_med_ancho
        , p.pro_med_alto
        , (case p.pro_nueva when 1 then 'Nuevo' else 'Usado' end) as pro_nueva
        from productos p, tipo_productos r, sucursales s 
        where
         p.tip_id=r.tip_id and $suc_id=s.suc_id and p.pro_estado = 0 and p.pro_controla_stock = 'S'";
    if($tip_id!='' and $tip_id!='0'){
     $sql .= " and p.tip_id= $tip_id";
    }
     $sql .= " order by tip_descripcion
        , mar_descripcion
        , mod_descripcion
        , p.pro_id";//echo'sql:'.$sql;
     $consulta= mysql_query($sql, $link);
     return $consulta;
  }
}
?>