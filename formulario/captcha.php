<?php
require_once('php-captcha.inc.php');
$aFonts = array('./captcha.font.ttf');
// create new image
$oPhpCaptcha = new PhpCaptcha($aFonts, 200, 35);
$oPhpCaptcha->SetBackgroundImages('captcha.bg.jpg');
$oPhpCaptcha->Create();
?>