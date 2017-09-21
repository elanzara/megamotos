<?php
session_start();
include_once 'class/conex.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mensajeError="";
    $usuario = "";
    $clave = "";
    /*validaciones*/
    if (isset($_POST["usuario"])){
    } else {
        $mensajeError = $mensajeError . "1";
    }
    if (isset($_POST["clave"])){
    } else {
        $mensajeError = $mensajeError . "1";
    }
    /*validaciones*/
    if ($mensajeError!="") {
        $mensaje = "El usuario y/o clave ingresados son incorrectos.";
        session_destroy();
    } else {
        $link=Conectarse();
        $consulta= mysql_query(' select * from usuarios where usu_estado = 0 AND usu_descripcion = "'.$_POST["usuario"].'"',$link);
        while($row= mysql_fetch_assoc($consulta)) {
            $usuario = $row["usu_descripcion"];
            $usu_id = $row["usu_id"];
            $clave = $row["usu_clave"];
            $suc_id = $row["suc_id"];
            $consulta1= mysql_query(' select * from roles_x_usuario where rxu_estado = 0 AND usu_id = "'.$row["usu_id"].'"',$link);
            while($row1= mysql_fetch_assoc($consulta1)) {
                $rol_id = $row1["rol_id"];
            }
        }
        if ($usuario!="" && $clave != ""){
            if ($usuario==$_POST["usuario"] && $clave == md5($_POST["clave"])){
                $_SESSION["usuario"] = $usuario;
                $_SESSION["usu_id"] = $usu_id;
                $_SESSION["suc_id_usu"] = $suc_id;
                $_SESSION["rol_id"] = $rol_id;
                //Fecha ayer
                $fecha_ayer=date('Y-m-d', mktime(0, 0, 0, date('m'),date('d')-1,date('Y')));//date('Y-m-d');
                //echo'fe:'.$fecha;
                //Verifico si hay saldos fecha ayer
                $fecha = '';
                $sqlh="select max(s.stm_fecha) fecha
                        from stock_mensual s
                        where s.stm_fecha = '".$fecha_ayer."'";
                $consultah= mysql_query($sqlh, $link);
                if ($consultah){
                        while ($rowh = mysql_fetch_assoc($consultah)) {
                               $fecha = $rowh['fecha'];
                        }
                }//echo 'ult_fecha:'.$ult_fecha.'-ultc:'.str_replace('-','',$ult_fecha).' fecha:'.$fecha.'</br>';
                if($fecha==''){
                    $fecha_ayer=date('d/m/Y', mktime(0, 0, 0, date('m'),date('d')-1,date('Y')));//date('Y-m-d', mktime(0, 0, 0, date('m'),date('d')-1,date('Y')));//date('Y-m-d');
                    //Calculo saldo
                    header("Location:calcula_saldo.php?fecha=".$fecha_ayer);
//echo'fe1:'.$fecha;
                }else{
                    header("Location:abm_primera_pag.php");
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
   <h1>Login </h1>
   <!--Start FORM -->
   <form ACTION="login.php" METHOD="POST" enctype="multipart/form-data">
    <table class="form" border="0"  align="center">
      <tr>
        <td class="formTitle">Usuario</td>
        <td><input name="usuario" id="usuario" type="text" class="campos" size="18" /></td>
      </tr>
      <tr>
        <td class="formTitle">Password</td>
        <td><input name="clave" id="clave" type="password" class="campos" size="18" /></td>
      </tr>
      <tr>
        <td colspan="2" align="center"><input type="submit" class="boton" value="Enviar" /></td>
      </tr>
      <tr>
        <td colspan="2" align="center"><a href="cambio_clave.php" >Desea cambiar su clave</a></td>
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