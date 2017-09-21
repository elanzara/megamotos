<?php
//cambiar el contenido entre comillas por la dirección de su dominio -A- la cual se desea enviar el mail
$correo="formulario@megamotos.com.ar";

//se incluye la clase php-captcha
require_once('php-captcha.inc.php');

//Si no han pasado alguna variable por POST o no valida el captcha -> error
if (!count($_POST) || (!PhpCaptcha::Validate($_POST['captcha']))) header("Location: ".$_POST['errorOcurred']);
else {
  $body="";

  //estos campos no se envian al cuerpo del mensaje
  $hide = array("successfully", "errorOcurred", "subject", "captcha"); 

  //para cada campo enviado del formulario - si no son especiales se agregan al cuerpo
  foreach ($_POST as $key => $value) if (!in_array($key, $hide)) $body .= $key . ": " . $value. "\n";

  //se envia el mail
  mail($correo, $_POST['subject'], $body);
  //para mas información y ejemplos de uso de la funcion mail(); puede visitar
  //  http://ar2.php.net/manual/en/function.mail.php

  //se direcciona a la pagina de agradecimiento
  header("Location: ".$_POST['successfully']);
}
?>