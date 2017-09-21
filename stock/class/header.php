<link href="css/admin.css" rel="stylesheet" type="text/css" />
<!--Start HEADER -->
<div id="header"> 
    <div id="marca"><img src="../admin/images/bkg_boton.jpg" alt="ECOMMERS:." width="180" height="60" /></div>
    <div id="admin">CMS | Administrador</div>
    <div id="sesion">
        <img src="images/user.png" width="24" height="24" align="absmiddle" alt="" /><a href="class/session_destroy.php">Cerrar sesi&oacute;n</a>
    </div>
    <!--Start NAVBAR -->
    <div id="menu" class="menu">
      <ul id="navg">
        <li><a href="abm_orden_trabajo.php">O.TRABAJO</a>
            <ul>
             <!--   <li><a href="abm_clientes.php">CLIENTES</a></li>-->
           </ul>
        </li>
        <li><a href="">PRECIOS</a>
            <ul>
                <li><a href="abm_precios.php">ADM.PRECIOS</a></li>
           </ul>
        </li>
        <li><a href="">PRODUCTOS</a>
            <ul>
                <li><a href="abm_clientes.php">CLIENTES</a></li>
<!--                <li><a href="abm_distribuidores.php">DISTRIBUIDORES</a></li>-->
                <li><a href="abm_marcas.php">MARCAS</a></li>
                <li><a href="abm_modelos.php">MODELOS</a></li>
                <li><a href="abm_productos.php">PRODUCTOS</a></li>
                <li><a href="abm_proveedores.php">PROVEEDORES</a></li>
                <li><a href="abm_sucursales.php">SUCURSALES</a></li>
                <li><a href="abm_tipo_productos.php">TIPOS PRODUCTO</a></li>
                <li><a href="abm_tipo_movimientos.php">TIPOS MOVIMIENTO</a></li>
                <li><a href="abm_vehiculos.php">VEHICULOS</a></li>
                <li><a href="abm_tipo_rango.php">TIPO RANGO</a></li>
           </ul>
        </li>
        <li><a href="">SEGURIDAD</a>
            <ul>
                <li><a href="abm_funciones.php">FUNCIONES</a></li>
                <li><a href="abm_funciones_x_role.php">FUNCIONES X ROL</a></li>
                <li><a href="abm_roles.php">ROLES</a></li>
                <li><a href="abm_roles_x_usuario.php">ROLES X USUARIO</a></li>
                <li><a href="abm_usuarios.php">USUARIOS</a></li>
           </ul>
        </li>
        <li><a href="">STOCK</a>
            <ul>
                <li><a href="alta_movimientos_stock.php?tipo=I">INGRESO</a></li>
                <li><a href="alta_movimientos_stock.php?tipo=E">EGRESO</a></li>
                <li><a href="alta_movimientos_stock.php?tipo=T">TRANSFERENCIA</a></li>
                <li><a href="abm_movimientos_stock.php?limpiar='S'">MONITOR DE MVTOS DE STOCK</a></li>
                <li><a href="alta_movimientos_stock.php?limpiar='S'">MONITOR DE STOCK DE PRODS.</a></li>
           </ul>
        </li>		
      </ul>    
    </div>
    <!-- End NAVBAR -->
    <br clear="all" />
</div>
<!-- End HEADER -->
<br clear="all" />
