<?php
if (isset($_GET[clave])){

$encriptar = md5($_GET[clave]);
echo $encriptar;
}
?>
