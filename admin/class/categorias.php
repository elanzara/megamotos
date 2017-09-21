<?php
class categorias
{

    var $CAT_ID;
    var $GRP_ID;
    var $CAT_DESCRIPCION;
    var $CAT_FOTO;
    var $CAT_ESTADO;


    function categorias($CAT_ID = 0)
    {
        if ($CAT_ID != 0) {
            $link = Conectarse();
            $consulta = mysql_query(' select CAT_ID , GRP_ID , CAT_DESCRIPCION , CAT_FOTO , CAT_ESTADO from categorias where CAT_id = '.$CAT_ID,
                $link);
            while ($row = mysql_fetch_assoc($consulta)) {
                $this->CAT_ID = $row['CAT_ID'];
                $this->GRP_ID = $row['GRP_ID'];
                $this->CAT_DESCRIPCION = $row['CAT_DESCRIPCION'];
                $this->CAT_FOTO = $row['CAT_FOTO'];
                $this->CAT_ESTADO = $row['CAT_ESTADO'];
            }
        }
    }
    function insert_CAT()
    {
        $link = Conectarse();
        $sql = "insert into categorias (
                GRP_ID
                , CAT_DESCRIPCION
                , CAT_FOTO
                ) values ( 
                '$this->GRP_ID'
                , '$this->CAT_DESCRIPCION'
                , '$this->CAT_FOTO'
                )";
        $result = mysql_query($sql, $link);
        if ($result > 0) {
            return 1;
        } else {
            return 0;
        }
    }
    function update_CAT()
    {
        $link = Conectarse();
        $sql = "update categorias set 
            GRP_ID = '$this->GRP_ID'
            , CAT_DESCRIPCION = '$this->CAT_DESCRIPCION'
            , CAT_FOTO = '$this->CAT_FOTO'
            where CAT_ID = ".$this->CAT_ID;
        $result = mysql_query($sql, $link);
        if ($result > 0) {
            return 1;
        } else {
            return 0;
        }
    }
    function baja_CAT()
    {
        $link = Conectarse();
        $sql = "update categorias set CAT_ESTADO = '1' where CAT_ID = ".$this->CAT_ID;
        $result = mysql_query($sql, $link);
        if ($result > 0) {
            return 1;
        } else {
            return 0;
        }
    }
    function getcategorias()
    {
        $link = Conectarse();
        $sql = "select * from categorias where CAT_ESTADO='0'";
        $result = mysql_query($sql, $link);
        return $result;
    }
    function getcategoriasGrupo($grp_id=0)
    {
        $link = Conectarse();
        $sql = "select * from categorias where CAT_ESTADO='0' and GRP_ID=".$grp_id;
        $result = mysql_query($sql, $link);
        return $result;
    }

    function getcategoriasDes()
    {
        $link = Conectarse();
        $sql = "select * from categorias where CAT_ESTADO='1'";
        $result = mysql_query($sql, $link);
        return $result;
    }
    
    function getcategoriasSQL() {
        $sql="select c.CAT_ID, c.CAT_DESCRIPCION, c.CAT_FOTO, g.GRP_DESCRIPCION from categorias c, grupos g where c.GRP_ID = g.GRP_ID AND c.CAT_ESTADO=0";
        return $sql;
    }
    function get_select_categorias($cat_id='') {
        $result = $this->getcategorias();
        $html = "";
        $html.= "<select name='categorias' id='categorias'>";
        while($row= mysql_fetch_assoc($result)) {
            if ($cat_id!='') {
                if ($row['CAT_ID'] == $cat_id) {
                    $html.= "<option value=".$row['CAT_ID']." selected>".$row['CAT_DESCRIPCION']."</option>";
                } else {
                    $html.= "<option value=".$row['CAT_ID'].">".$row['CAT_DESCRIPCION']."</option>";
                }
            } else {
                $html.= "<option value=".$row['CAT_ID'].">".$row['CAT_DESCRIPCION']."</option>";
            }
        }
        $html.= "</select>";
        return $html;
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
    function get_CAT_DESCRIPCION()
    {
        return $this->CAT_DESCRIPCION;
    }
    function set_CAT_DESCRIPCION($val)
    {
        $this->CAT_DESCRIPCION = $val;
    }
    function get_CAT_FOTO()
    {
        return $this->CAT_FOTO;
    }
    function set_CAT_FOTO($val)
    {
        $this->CAT_FOTO = $val;
    }
    function get_CAT_ESTADO()
    {
        return $this->CAT_ESTADO;
    }
    function set_CAT_ESTADO($val)
    {
        $this->CAT_ESTADO = $val;
    }
}

?>