<?php
class grupos
{

    var $GRP_ID;
    var $GRP_DESCRIPCION;
    var $GRP_ESTADO;


    function grupos($GRP_ID = 0)
    {
        if ($GRP_ID != 0) {
            $link = Conectarse();
            $consulta = mysql_query(' select GRP_ID , GRP_DESCRIPCION , GRP_ESTADO from grupos where GRP_id = ' .
                $GRP_ID, $link);
            while ($row = mysql_fetch_assoc($consulta)) {
                $this->GRP_ID = $row['GRP_ID'];
                $this->GRP_DESCRIPCION = $row['GRP_DESCRIPCION'];
                $this->GRP_ESTADO = $row['GRP_ESTADO'];
            }
        }
    }
    function insert_GRP()
    {
        $link = Conectarse();
        $sql = "insert into grupos (
            GRP_DESCRIPCION
            ) values ( 
            '$this->GRP_DESCRIPCION'
            )";
        $result = mysql_query($sql, $link);
        if ($result > 0) {
            return 1;
        } else {
            return 0;
        }
    }
    function update_GRP()
    {
        $link = Conectarse();
        $sql = "update grupos set 
            GRP_DESCRIPCION = '$this->GRP_DESCRIPCION'
            where GRP_ID = ".$this->GRP_ID;
        $result = mysql_query($sql, $link);
        if ($result > 0) {
            return 1;
        } else {
            return 0;
        }
    }
    function baja_GRP()
    {
        $link = Conectarse();
        $sql = "update grupos set GRP_ESTADO = '1' where GRP_id = ".$this->GRP_ID;
        $result = mysql_query($sql, $link);
        if ($result > 0) {
            return 1;
        } else {
            return 0;
        }
    }
    function getgrupos($grp_id=0)
    {
        $link = Conectarse();
        if ($grp_id==0){
            $sql = "select * from grupos where GRP_ESTADO='0'";
        } else {
            $sql = "select * from grupos where GRP_ESTADO='0' and GRP_ID=".$grp_id;
        }
        $result = mysql_query($sql, $link);
        return $result;
    }
    function getgruposDes()
    {
        $link = Conectarse();
        $sql = "select * from grupos where GRP_ESTADO='1'";
        $result = mysql_query($sql, $link);
        return $result;
    }

    function getgruposCombo($grp_id=0) {
        $link=Conectarse();
        $html = "";
        $sql="select GRP_DESCRIPCION, GRP_ID
            from grupos
            where GRP_ESTADO = 0
            order by GRP_DESCRIPCION";
        $consulta= mysql_query($sql, $link);
        $html = "<select name='grupos' id='grupos' class='formFields'  onChange='cargaContenido(this.id)'>";
        while($row= mysql_fetch_assoc($consulta)) {
            if ($grp_id==$row["GRP_ID"]){
                $html = $html . '<option value='.$row["GRP_ID"].' selected>'.$row["GRP_DESCRIPCION"].'</option>';
            } else {
                $html = $html . '<option value='.$row["GRP_ID"].'>'.$row["GRP_DESCRIPCION"].'</option>';
            }
        }
        $html = $html . '</select>';
        return $html;
    }

    function get_GRP_ID()
    {
        return $this->GRP_ID;
    }
    function set_GRP_ID($val)
    {
        $this->GRP_ID = $val;
    }
    function get_GRP_DESCRIPCION()
    {
        return $this->GRP_DESCRIPCION;
    }
    function set_GRP_DESCRIPCION($val)
    {
        $this->GRP_DESCRIPCION = $val;
    }
    function get_GRP_ESTADO()
    {
        return $this->GRP_ESTADO;
    }
    function set_GRP_ESTADO($val)
    {
        $this->GRP_ESTADO = $val;
    }
}
?>