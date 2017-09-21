<?php
    function Opciones_habilitadas($rol_id='',$menu='')
    {
      if ($rol_id!='' and $menu!='') {
        $link=Conectarse();
        $sql1="select * from funciones where fun_estado = '0' and fun_descripcion = '$menu'";
        $result1=mysql_query($sql1,$link);
        while($row= mysql_fetch_assoc($result1)) {
            $menu_id=$row["fun_id"];
        }
        $sql2="select * from funciones_x_role where fxr_estado = '0' and rol_id= '".$rol_id.
             "' and fun_id = '$menu_id'";
        $result2=mysql_query($sql2,$link);
        if ($result2>0) {
            if (mysql_num_rows($result2)>0){
                return 'S';
            }else{
                return 'N';
            }
        } else {
            return 'N';
        }
      } else {
        return 'N';
      }
    }
?>