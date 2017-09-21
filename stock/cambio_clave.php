<?php
session_start();
include_once 'class/conex.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mensajeError="";
    $usuario = "";
    $claveOld = "";
    $claveNew = "";
    $claveRei = "";
    /*validaciones*/
    if (isset($_POST["usuario"])){
        if ($_POST["usuario"]!=""){
            $usuario = $_POST["usuario"];
        } else {
            $mensajeError = $mensajeError . "Falta ingresar el usuario.<br>";
        }
    } else {
        $mensajeError = $mensajeError . "Falta ingresar el usuario.<br>";
    }
    if (isset($_POST["claveOld"])){
        if ($_POST["claveOld"]!=""){
            $claveOld = $_POST["claveOld"];
        } else {
            $mensajeError = $mensajeError . "Falta ingresar la clave original.<br>";
        }
    } else {
        $mensajeError = $mensajeError . "Falta ingresar la clave original.<br>";
    }
    if (isset($_POST["claveNew"])){
        if ($_POST["claveNew"]!=""){
            $claveNew = $_POST["claveNew"];
        } else {
            $mensajeError = $mensajeError . "Falta ingresar la nueva clave.<br>";
        }
    } else {
        $mensajeError = $mensajeError . "Falta ingresar la nueva clave.<br>";
    }
    if (isset($_POST["claveRei"])){
        if ($_POST["claveRei"]!=""){
            $claveRei = $_POST["claveRei"];
        } else {
            $mensajeError = $mensajeError . "Falta reingresar la nueva clave.<br>";
        }
    } else {
        $mensajeError = $mensajeError . "Falta reingresar la nueva clave.<br>";
    }
    
    if ($claveNew != $claveRei){
        $mensajeError = $mensajeError . "La clave nueva no coincide con la reingresada.<br>";
    }
    
    /*FIN validaciones*/
    if ($mensajeError!="") {
        $mensaje = $mensajeError;
        session_destroy();
    } else {
        $link=Conectarse();
        $consulta= mysql_query(' select * from usuarios where usu_estado = 0 AND usu_descripcion = "'.$usuario.'"',$link);
        while($row= mysql_fetch_assoc($consulta)) {
            $usuario = $row["usu_descripcion"];
            $clave = $row["usu_clave"];
            $suc_id = $row["suc_id"];
            $consulta1= mysql_query(' select * from roles_x_usuario where rxu_estado = 0 AND usu_id = "'.$row["usu_id"].'"',$link);
            while($row1= mysql_fetch_assoc($consulta1)) {
                $rol_id = $row1["rol_id"];
            }
        }
        if ($usuario!="" && $clave != ""){
            if ($clave == md5($claveOld)){
                $link=Conectarse();
                $sql = "update usuarios set usu_clave = '".md5($claveNew)."' where usu_descripcion = '".$usuario."'";
                $result=mysql_query($sql,$link);
                if ($result>0){
                    $mensaje = "Se realizó el cambio de clave satisfactoriamente.";
                } else {
                    $mensaje = "No se pudo realizar el cambio de clave.";
                }
            } else {
                $mensaje = "El usuario y/o clave ingresados son incorrectos.";
                session_destroy();
            }
        } else {
            $mensaje = "El usuario y/o clave ingresados son incorrectos.";
            session_destroy();
        }
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>MEGALLANTAS - Admin</title>
<link rel="shortcut icon" href="../imagenes/tu-logo-mitad2.jpg"></link>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>
<body>
<div id="page"> 
 <!--Start HEADER -->
 <?php require_once("header.php") ?>
 <!-- End HEADER -->
 <!--Start CENTRAL -->
 <div id="central">
   <h1>Cambio de clave </h1>
   <!--Start FORM -->
   <form ACTION="cambio_clave.php" METHOD="POST" enctype="multipart/form-data">
    <table class="form" border="0"  align="center">
      <tr>
        <td class="formTitle">Usuario</td>
        <td><input name="usuario" id="usuario" type="text" class="campos" size="18" /></td>
      </tr>
      <tr>
        <td class="formTitle">Password Ant.</td>
        <td><input name="claveOld" id="claveOld" type="password" class="campos" size="18" /></td>
      </tr>
      <tr>
        <td class="formTitle">Password Nueva</td>
        <td><input name="claveNew" id="claveNew" type="password" class="campos" size="18" /></td>
      </tr>
      <tr>
        <td class="formTitle">Reingrese Password</td>
        <td><input name="claveRei" id="claveRei" type="password" class="campos" size="18" /></td>
      </tr>
      <tr>
        <td colspan="2" align="center"><input type="submit" class="boton" value="Enviar" /></td>
      </tr>
      <tr>
          <td colspan="2" class="mensaje">
                    <?php
                    if (isset($mensaje)) {
                        echo $mensaje;
                    }
                    ?>
          </td>
      </tr>
    </table>
      <?php
	 if (isset($_POST["mensaje"])) {
        	if ($_POST["mensaje"]!=""){
        		$mensaje=$_POST["mensaje"];
			echo "<br><br><span class='Estilo3'><B>$mensaje</span>";
	 }}
      ?>
   </form>
   <!--End FORM -->
 </div> 
 <!--End CENTRAL -->
 <br clear="all" />
</div>
</body>
</html>