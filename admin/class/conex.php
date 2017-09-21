<?php
function Conectarse()
{
   if (!($link=mysql_connect("127.0.0.1:3307","226741-megamotos","i810vgt01")))
   {
//      echo "Error conectando a la base de datos.";
      exit();
   }
   if (!mysql_select_db("226741-megamotos",$link))
   {
//      echo "Error seleccionando la base de datos.";
      exit();
   }
   return $link;
}
?>