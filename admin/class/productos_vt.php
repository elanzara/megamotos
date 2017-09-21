<?php
class productos
{

    var $PRO_ID;
    var $CAT_ID;
    var $GRP_ID;
    var $PRO_DESCRIPCION;
    var $PRO_FOTO;
    var $PRO_PRECIO_COSTO;
    var $PRO_PROVEEDOR;
    var $PRO_ESTADO;
    var $PRO_CODIGO;


    function productos($PRO_ID = 0)
    {
        if ($PRO_ID != 0) {
            $link = Conectarse();
            $consulta = mysql_query(' select PRO_ID , CAT_ID , GRP_ID , PRO_DESCRIPCION , PRO_FOTO , PRO_PRECIO_COSTO , PRO_PROVEEDOR , PRO_ESTADO , PRO_CODIGO from productos_web where PRO_ID = '.$PRO_ID,
                $link);
            while ($row = mysql_fetch_assoc($consulta)) {
                $this->PRO_ID = $row['PRO_ID'];
                $this->CAT_ID = $row['CAT_ID'];
                $this->GRP_ID = $row['GRP_ID'];
                $this->PRO_DESCRIPCION = $row['PRO_DESCRIPCION'];
                $this->PRO_FOTO = $row['PRO_FOTO'];
                $this->PRO_PRECIO_COSTO = $row['PRO_PRECIO_COSTO'];
                $this->PRO_PROVEEDOR = $row['PRO_PROVEEDOR'];
                $this->PRO_ESTADO = $row['PRO_ESTADO'];
                $this->PRO_CODIGO = $row['PRO_CODIGO'];
            }
        }
    }
    function insert_PRO()
    {
        $link = Conectarse();
        $sql = "insert into productos (
            CAT_ID
            , GRP_ID
            , PRO_DESCRIPCION
            , PRO_FOTO
            , PRO_PRECIO_COSTO
            , PRO_PROVEEDOR
            , PRO_CODIGO
            ) values ( 
            '$this->CAT_ID'
            , '$this->GRP_ID'
            , '$this->PRO_DESCRIPCION'
            , '$this->PRO_FOTO'
            , '$this->PRO_PRECIO_COSTO'
            , '$this->PRO_PROVEEDOR'
            , '$this->PRO_CODIGO'
            )";
        $result = mysql_query($sql, $link);
        if ($result > 0) {
            return 1;
        } else {
            return 0;
        }
    }
    function update_PRO()
    {
        $link = Conectarse();
        $sql = "update productos set 
            CAT_ID = '$this->CAT_ID'
            , GRP_ID = '$this->GRP_ID'
            , PRO_DESCRIPCION = '$this->PRO_DESCRIPCION'
            , PRO_FOTO = '$this->PRO_FOTO'
            , PRO_PRECIO_COSTO = '$this->PRO_PRECIO_COSTO'
            , PRO_PROVEEDOR = '$this->PRO_PROVEEDOR'
            , PRO_CODIGO = '$this->PRO_CODIGO'
            where PRO_ID = ".$this->PRO_ID;
        $result = mysql_query($sql, $link);
        if ($result > 0) {
            return 1;
        } else {
            return 0;
        }
    }
    function baja_PRO()
    {
        $link = Conectarse();
        $sql = "update productos set PRO_ESTADO = '1' where PRO_ID = ".$this->PRO_ID;
        $result = mysql_query($sql, $link);
        if ($result > 0) {
            return 1;
        } else {
            return 0;
        }
    }
    function getproductos($cat_id=0)
    {
        $link = Conectarse();
        if ($cat_id==0){
            $sql = "select * from productos_web where PRO_ESTADO='0'";
        } else {
            $sql = "select * from productos_web where PRO_ESTADO='0' CAT_ID=".$cat_id;
        }
        $result = mysql_query($sql, $link);
        return $result;
    }
    function getproductosDes()
    {
        $link = Conectarse();
        $sql = "select * from productos_web where PRO_ESTADO='1'";
        $result = mysql_query($sql, $link);
        return $result;
    }
    function getproductosSQL($cat_id=1) {
        $link=Conectarse();
        //$sql="select c.CAT_DESCRIPCION, p.PRO_ID, p.PRO_TITULO, p.PRO_DESCRIPCION from productos_web p, categorias c where c.CAT_ID = ".$cat_id." and c.CAT_ID = p.CAT_ID and p.PRO_ESTADO='0'";
        $sql = "select c.CAT_DESCRIPCION, p.PRO_ID, p.PRO_DESCRIPCION, g.GRP_DESCRIPCION, g.GRP_ID, p.PRO_FOTO, p.PRO_CODIGO
                from productos_web p, categorias c, grupos g 
                where c.CAT_ID = ".$cat_id." 
                and c.CAT_ID = p.CAT_ID 
                and g.GRP_ID = p.GRP_ID
                and p.PRO_ESTADO='0'";
        return $sql;
    }

    function get_PRO_ID()
    {
        return $this->PRO_ID;
    }
    function set_PRO_ID($val)
    {
        $this->PRO_ID = $val;
    }
    function get_CAT_ID()
    {
        return $this->CAT_ID;
    }
    function set_CAT_ID($val)
    {
        $this->CAT_ID = $val;
    }
    function get_GRP_ID()
    {
        return $this->GRP_ID;
    }
    function set_GRP_ID($val)
    {
        $this->GRP_ID = $val;
    }
    function get_PRO_DESCRIPCION()
    {
        return $this->PRO_DESCRIPCION;
    }
    function set_PRO_DESCRIPCION($val)
    {
        $this->PRO_DESCRIPCION = $val;
    }
    function get_PRO_FOTO()
    {
        return $this->PRO_FOTO;
    }
    function set_PRO_FOTO($val)
    {
        $this->PRO_FOTO = $val;
    }
    function get_PRO_PRECIO_COSTO()
    {
        return $this->PRO_PRECIO_COSTO;
    }
    function set_PRO_PRECIO_COSTO($val)
    {
        $this->PRO_PRECIO_COSTO = $val;
    }
    function get_PRO_PROVEEDOR()
    {
        return $this->PRO_PROVEEDOR;
    }
    function set_PRO_PROVEEDOR($val)
    {
        $this->PRO_PROVEEDOR = $val;
    }
    function get_PRO_ESTADO()
    {
        return $this->PRO_ESTADO;
    }
    function set_PRO_ESTADO($val)
    {
        $this->PRO_ESTADO = $val;
    }
    function get_PRO_CODIGO()
    {
        return $this->PRO_CODIGO;
    }
    function set_PRO_CODIGO($val)
    {
        $this->PRO_CODIGO = $val;
    }
}

?>