<?php
class ofertas
{

    var $OFE_ID;
    var $OFE_TITULO;
    var $OFE_DESCRIPCION;
    var $OFE_PRECIO;
    var $OFE_FOTO;
    var $OFE_ESTADO;


    function ofertas($OFE_ID = 0)
    {
        if ($OFE_ID != 0) {
            $link = Conectarse();
            $consulta = mysql_query(' select OFE_ID , OFE_TITULO , OFE_DESCRIPCION , OFE_PRECIO , OFE_FOTO , OFE_ESTADO from ofertas where OFE_ID = '.$OFE_ID,
                $link);
            while ($row = mysql_fetch_assoc($consulta)) {
                $this->OFE_ID = $row['OFE_ID'];
                $this->OFE_TITULO = $row['OFE_TITULO'];
                $this->OFE_DESCRIPCION = $row['OFE_DESCRIPCION'];
                $this->OFE_PRECIO = $row['OFE_PRECIO'];
                $this->OFE_FOTO = $row['OFE_FOTO'];
                $this->OFE_ESTADO = $row['OFE_ESTADO'];
            }
        }
    }
    function insert_OFE()
    {
        $link = Conectarse();
        $sql = "insert into ofertas (
            OFE_TITULO
            , OFE_DESCRIPCION
            , OFE_PRECIO
            , OFE_FOTO
            ) values ( 
            '$this->OFE_TITULO'
            , '$this->OFE_DESCRIPCION'
            , '$this->OFE_PRECIO'
            , '$this->OFE_FOTO'
            )";
        $result = mysql_query($sql, $link);
        if ($result > 0) {
            return 1;
        } else {
            return 0;
        }
    }
    function update_OFE()
    {
        $link = Conectarse();
        $sql = "update ofertas set 
            OFE_TITULO = '$this->OFE_TITULO'
            , OFE_DESCRIPCION = '$this->OFE_DESCRIPCION'
            , OFE_PRECIO = '$this->OFE_PRECIO'
            , OFE_FOTO = '$this->OFE_FOTO'
            where OFE_ID = ".$this->OFE_ID;
        $result = mysql_query($sql, $link);
        if ($result > 0) {
            return 1;
        } else {
            return 0;
        }
    }
    function baja_OFE()
    {
        $link = Conectarse();
        $sql = "update ofertas set OFE_ESTADO = '1' where OFE_ID = ".$this->OFE_ID;
        $result = mysql_query($sql, $link);
        if ($result > 0) {
            return 1;
        } else {
            return 0;
        }
    }
    function getofertas()
    {
        $link = Conectarse();
        $sql = "select * from ofertas where OFE_ESTADO='0'";
        $result = mysql_query($sql, $link);
        return $result;
    }
    function getofertasDes()
    {
        $link = Conectarse();
        $sql = "select * from ofertas where OFE_ESTADO='1'";
        $result = mysql_query($sql, $link);
        return $result;
    }
    function getofertasSQL() {
        $sql="select * from ofertas o where o.OFE_ESTADO=0";
        return $sql;
    }

    function get_OFE_ID()
    {
        return $this->OFE_ID;
    }
    function set_OFE_ID($val)
    {
        $this->OFE_ID = $val;
    }
    function get_OFE_TITULO()
    {
        return $this->OFE_TITULO;
    }
    function set_OFE_TITULO($val)
    {
        $this->OFE_TITULO = $val;
    }
    function get_OFE_DESCRIPCION()
    {
        return $this->OFE_DESCRIPCION;
    }
    function set_OFE_DESCRIPCION($val)
    {
        $this->OFE_DESCRIPCION = $val;
    }
    function get_OFE_PRECIO()
    {
        return $this->OFE_PRECIO;
    }
    function set_OFE_PRECIO($val)
    {
        $this->OFE_PRECIO = $val;
    }
    function get_OFE_FOTO()
    {
        return $this->OFE_FOTO;
    }
    function set_OFE_FOTO($val)
    {
        $this->OFE_FOTO = $val;
    }
    function get_OFE_ESTADO()
    {
        return $this->OFE_ESTADO;
    }
    function set_OFE_ESTADO($val)
    {
        $this->OFE_ESTADO = $val;
    }
}

?>