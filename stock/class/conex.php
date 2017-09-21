<?php
function Conectarse()
{
   if (!($link=mysql_connect("localhost","226741-megamotos","i810vgt01")))
   {
//      echo "Error conectando a la base de datos.";
      exit();
   }
   if (!mysql_select_db("226741_megamotos",$link))
   {
//      echo "Error seleccionando la base de datos.";
      exit();
   }
   return $link;
}
?>