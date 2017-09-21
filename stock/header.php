<link href="css/admin.css" rel="stylesheet" type="text/css" />
<!--Start HEADER -->   
    <div id="marca"><?php echo '<b>Usuario:</b> '.$_SESSION["usuario"]; ?><a href="class/session_destroy.php">&nbspCerrar sesi&oacute;n</a></div>
<div id="header"> 
	<div id="marca"><img src="../admin/images/favicon.PNG" alt="ECOMMERS:." width="180" height="60" /></div>   
    <!--Start NAVBAR-->
    <?php
    //Verifico la seguridad de la aplicacion.
    include_once 'class/seguridad.php';
    ?>
    <div id="menu" class="menu">
      <ul id="navg">
        <?php
        if(Opciones_habilitadas($_SESSION["rol_id"],'O.T.')=='S') {
        ?>
          <li><a href="abm_orden_trabajo.php">O.T.</a>
           <ul>
             <!--   <li><a href="abm_clientes.php">CLIENTES</a></li>-->
           </ul>
          </li>
        <?php
        }
        ?>
        <li><a href="abm_primera_pag.php">PRECIOS</a>
          <ul>
            <?php
            if(Opciones_habilitadas($_SESSION["rol_id"],'ADM.PRECIOS')=='S') {
            ?>
                <li><a href="abm_precios.php">ADM.PRECIOS</a></li>
            <?php
            }
            ?>
          </ul>
        </li>
        <li><a href="abm_primera_pag.php">PRODUCTOS</a>
          <ul>
            <?php
            if(Opciones_habilitadas($_SESSION["rol_id"],'CLIENTES')=='S') {
            ?>
                <li><a href="abm_clientes.php">CLIENTES</a></li>
                <!--<li><a href="abm_distribuidores.php">DISTRIBUIDORES</a></li>-->
            <?php
            }
            if(Opciones_habilitadas($_SESSION["rol_id"],'MARCAS')=='S') {
            ?>
                <li><a href="abm_marcas.php">MARCAS</a></li>
            <?php
            }
            if(Opciones_habilitadas($_SESSION["rol_id"],'MODELOS')=='S') {
            ?>
                <li><a href="abm_modelos.php">MODELOS</a></li>
            <?php
            }
            if(Opciones_habilitadas($_SESSION["rol_id"],'PRODUCTOS')=='S') {
            ?>
                <li><a href="abm_productos.php">PRODUCTOS</a></li>
            <?php
            }
            if(Opciones_habilitadas($_SESSION["rol_id"],'PROVEEDORES')=='S') {
            ?>
                <li><a href="abm_proveedores.php">PROVEEDORES</a></li>
            <?php
            }
            if(Opciones_habilitadas($_SESSION["rol_id"],'SUCURSALES')=='S') {
            ?>
                <li><a href="abm_sucursales.php">SUCURSALES</a></li>
            <?php
            }
            if(Opciones_habilitadas($_SESSION["rol_id"],'TIPOS MOVIMIENTO')=='S') {
            ?>
                <li><a href="abm_tipo_movimientos.php">TIPOS MOVIMIENTO</a></li>
            <?php
            }
            if(Opciones_habilitadas($_SESSION["rol_id"],'TIPOS PRODUCTO')=='S') {
            ?>
                <li><a href="abm_tipo_productos.php">TIPOS PRODUCTO</a></li>
            <?php
            }
            if(Opciones_habilitadas($_SESSION["rol_id"],'TIPO RANGO')=='S') {
            ?>
                <li><a href="abm_tipo_rango.php">TIPO RANGO</a></li>
                <!--<li><a href="abm_vehiculos.php">VEHICULOS</a></li>-->
            <?php
            }
            ?>
          </ul>
        </li>
        <li><a href="abm_primera_pag.php">STOCK</a>
          <ul>
            <?php
            if(Opciones_habilitadas($_SESSION["rol_id"],'INGRESO')=='S') {
            ?>
                <li><a href="alta_movimientos_stock.php?tipo=I&limpiar_form=S">INGRESO</a></li>
            <?php
            }
            if(Opciones_habilitadas($_SESSION["rol_id"],'EGRESO')=='S') {
            ?>
                <li><a href="alta_movimientos_stock.php?tipo=E&limpiar_form=S">EGRESO</a></li>
            <?php
            }
            if(Opciones_habilitadas($_SESSION["rol_id"],'TRANSFERENCIA')=='S') {
            ?>
                <li><a href="alta_movimientos_stock.php?tipo=T&limpiar_form=S">TRANSFERENCIA</a></li>
            <?php
            }
            if(Opciones_habilitadas($_SESSION["rol_id"],'MONITOR DE MVTOS DE STOCK')=='S') {
            ?>
                <li><a href="abm_movimientos_stock.php?limpiar=S">MONITOR DE MVTOS DE STOCK</a></li>
            <?php
            }
            if(Opciones_habilitadas($_SESSION["rol_id"],'MONITOR DE STOCK DE PRODS.')=='S') {
            ?>
                <li><a href="abm_stock_productos3.php?limpiar=S">STOCK GENERAL</a></li>
            <?php
            }
            if(Opciones_habilitadas($_SESSION["rol_id"],'MONITOR DE STOCK DE PRODS.')=='S') {
            ?>
                <li><a href="abm_stock_productos_llantas.php?limpiar=S">STOCK LLANTAS ORIGINALES</a></li>
            <?php
            }
            if(Opciones_habilitadas($_SESSION["rol_id"],'MONITOR DE STOCK DE PRODS.')=='S') {
            ?>                
                <li><a href="abm_stock_productos_neumaticos.php?limpiar=S">STOCK NEUMATICOS</a></li>
            <?php
            }
            ?>
          </ul>
        </li>
				
        <li><a href="abm_primera_pag.php">SEGURIDAD</a>
          <ul>
            <?php
            if(Opciones_habilitadas($_SESSION["rol_id"],'FUNCIONES')=='S') {
            ?>
                <li><a href="abm_funciones.php">FUNCIONES</a></li>
            <?php
            }
            if(Opciones_habilitadas($_SESSION["rol_id"],'FUNCIONES X ROL')=='S') {
            ?>
                <li><a href="abm_funciones_x_role.php">FUNCIONES X ROL</a></li>
            <?php
            }
            if(Opciones_habilitadas($_SESSION["rol_id"],'ROLES')=='S') {
            ?>
                <li><a href="abm_roles.php">ROLES</a></li>
            <?php
            }
            if(Opciones_habilitadas($_SESSION["rol_id"],'ROLES X USUARIO')=='S') {
            ?>
                <li><a href="abm_roles_x_usuario.php">ROLES X USUARIO</a></li>
            <?php
            }
            if(Opciones_habilitadas($_SESSION["rol_id"],'USUARIOS')=='S') {
            ?>
                <li><a href="abm_usuarios.php">USUARIOS</a></li>
            <?php
            }
            ?>
          </ul>
        </li>
        <li><a href="abm_primera_pag.php">REPORTES</a>
          <ul>
            <?php
            if(Opciones_habilitadas($_SESSION["rol_id"],'PRODUCTOS VENDIDOS')=='S') {
            ?>
                <li><a href="rep_productos_vendidos.php">PRODUCTOS VENDIDOS</a></li>
            <?php
            }
            if(Opciones_habilitadas($_SESSION["rol_id"],'PRODUCTOS INGRESADOS')=='S') {
            ?>
                <li><a href="rep_productos_ingresados.php">PRODUCTOS INGRESADOS</a></li>
            <?php
            }
            if(Opciones_habilitadas($_SESSION["rol_id"],'STOCK DE MERCADERIA')=='S') {
            ?>
                <li><a href="rep_stock.php">STOCK DE MERCADERIA</a></li>
            <?php
            }
            if(Opciones_habilitadas($_SESSION["rol_id"],'LISTADO OT')=='S') {
            ?>
                <li><a href="rep_listado_ot.php">LISTADO OT</a></li>
            <?php
            }
            ?>
          </ul>
        </li>
        <?php
        //if(Opciones_habilitadas($_SESSION["rol_id"],'SALDOS')=='S') {
        ?>
          <!--<li><a href="abm_primera_pag.php">SALDOS</a>
           <ul>
              <li><a href="proceso_saldos.php">PROCESO SALDOS</a></li>
              <li><a href="rep_compara_saldos.php">COMPARACION SALDOS</a></li>
           </ul>
          </li>-->
        <?php
        //}
        ?>
      </ul>    
    </div>
    <!-- End NAVBAR -->	
    <br clear="all" />
</div>
<!-- End HEADER -->
<br clear="all" />