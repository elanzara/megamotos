<?php
if(session_start()){
    if(empty ($_SESSION["usuario"])){
        header("Location:login.php");
    }
}else header("Location:login.php");
?>