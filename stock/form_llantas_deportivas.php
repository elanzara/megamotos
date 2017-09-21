<?php if ($formulario=="alta"){ ?>
    <form action="alta_productos.php" method="POST" enctype="multipart/form-data">
<?php } elseif ($formulario=="modifica"){ ?>
    <form action="modifica_productos.php" method="POST" enctype="multipart/form-data">
<?php } ?>   
     <table class="form" border="0"  align="center">
        <tr>
          <td class="formTitle">CODIGO</td>
          <td><input name='pro_id' id='pro_id' value="<?php print $pro_id;?>" type='text' class='campos' size='18' readonly="readonly" /></td>
        </tr>
          <tr>
            <td class="formTitle">TIPO PRODUCTO</td>
            <td>
                <?php
                    $tip = new tipo_productos();
                    $res = $tip->gettipo_productosCombo($tip_id, 'S');
                    print $res;
                ?>
                <input type="hidden" id="tipo_productos" name="tipo_productos" value="<?php echo $tip_id;?>" />
            </td>
          </tr>
          <tr>
            <td class="formTitle">DESCRIPCIÓN</td>
            <td>
            <textarea name="pro_descripcion" id="pro_descripcion" class="campos" cols="100" rows="2" onkeyup="this.value=this.value.toUpperCase()" ><?php print $pro_descripcion;?></textarea>
            </td>
          </tr>
    	  <tr>
            <td class="formTitle">ESTADO</td>
            <td>
                <?Php if ($pro_nueva==1){?>
                    <input type="radio" name="pro_nueva" id="pro_nueva" class="campos" value="Nueva" checked="true"> Nuevo</input> <?php //print $pro_nueva;?>
                    <input type="radio" name="pro_nueva" id="pro_nueva" class="campos" value="Usada"> Usado</input><?php //print $pro_nueva;?>
                <?php } else {?>
                    <input type="radio" name="pro_nueva" id="pro_nueva" class="campos" value="Nueva"> Nuevo</input> <?php //print $pro_nueva;?>
                    <input type="radio" name="pro_nueva" id="pro_nueva" class="campos" value="Usada" checked="true"> Usado</input><?php //print $pro_nueva;?>
                <?php }?>
            </td>
          </tr>
<!--          <tr>
            <td class="formTitle">TERMINACIONES</td>
            <td><input type="text" name="pro_terminaciones" id="pro_terminaciones" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $pro_terminaciones;?>" /></td>
          </tr>-->
          <tr>
            <td class="formTitle">RODADO</td><!--DIAMETRO-->
            <td><input type="text" name="pro_med_diametro" id="pro_med_diametro" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $pro_med_diametro;?>" /></td>
          </tr>
    	  <tr>
            <td class="formTitle">ANCHO</td>
            <td><input type="text" name="pro_med_ancho" id="pro_med_ancho" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $pro_med_ancho;?>" /></td>
          </tr>
          <tr>
          <tr>
            <td class="formTitle">DISTRIBUCION</td>
            <td><input type="text" name="pro_distribucion" id="pro_distribucion" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $pro_distribucion;?>" /></td>
          </tr>
            <td class="formTitle">PROVEEDOR</td>
            <td>
                <?php
                    $prv = new proveedores();
                    $res = $prv->getproveedoresCombo($prv_id);
                    print $res;
                ?>
            </td>
          </tr>
          <tr>
            <td class="formTitle">MARCA</td>
            <td>
                <?php
                    $mar = new marcas();
                    $res = $mar->getmarcasxTipIdCombo($tip_id, $mar_id);
                    print $res;
                ?>
            </td>
          </tr>
          <tr>
            <td class="formTitle">MODELO</td>
            <td>
              <?php
               if (isset($mod_id) and $mod_id!="" and $mod_id!=0) {
                    $mod = new modelos();
                    $res = $mod->get_modelosComboxTipId($tip_id, $mod_id);
                    print $res;
               } else {
                    print '<select disabled="disabled" name="modelos" id="modelos">';
                    print '<option value="0">Selecciona opci&oacute;n...</option>';
                    print '</select>';
               }
              ?>
            </td>
          </tr>
          <tr>
            <td class="formTitle">AÑO</td>
            <td><input type="text" name="pro_anio" id="pro_anio" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $pro_anio;?>" /></td>
          </tr>
          <tr>
            <td class="formTitle">CONTROLA STOCK</td>
            <?php if ($pro_controla_stock=="S"){?>
                <td><input type="checkbox" id="pro_controla_stock" name="pro_controla_stock" checked="true" /></td>
            <?php } else {?>
                <td><input type="checkbox" id="pro_controla_stock" name="pro_controla_stock" /></td>
            <?php }?>
            
          </tr>
          <tr>
            <td class="formTitle">STOCK MINIMO</td>
            <td><input type="text" name="pro_stock_min" id="pro_stock_min" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $pro_stock_min;?>" /></td>
          </tr>
          <tr>
            <td class="formTitle">PRECIO</td>
            <td><input type="text" name="pro_precio_costo" id="pro_precio_costo" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $pro_precio_costo;?>" /></td>
          </tr>
          <tr>
            <td class="formTitle">TERMINACION</td>
            <td><input type="text" name="pro_terminacion" id="pro_terminacion" class="campos" onkeyup="this.value=this.value.toUpperCase()" value="<?php print $pro_terminacion;?>" /></td>
          </tr>
          <tr>
            <td class="formTitle">CLASIFICACION</td>
            <td>
                <select name='pro_clasificacion' id='pro_clasificacion' class='formFields'  onChange='cargaContenido(this.id)'>
                    <?php if ($pro_clasificacion == 'A'){?>
                        <option value='A' selected>Auto</option>
                    <?php } else {?>
                        <option value='A'>Auto</option>    
                    <?php }?>
                    <?php if ($pro_clasificacion == 'C'){?>
                        <option value='C' selected>Camioneta</option>
                    <?php } else {?>
                        <option value='C'>Camioneta</option>    
                    <?php }?>
                    <?php if ($pro_clasificacion == 'R'){?>
                        <option value='R' selected>Replica</option>
                    <?php } else {?>
                        <option value='R'>Replica</option>    
                    <?php }?>
                    
                </select>
            </td>
          </tr>
          <tr>
          <tr>
            <td class="formTitle" align="left">FOTO</td>
            <td align="left">
                <input type='hidden' name='MAX_FILE_SIZE' value='10000000' />
                <input type="file" id="pro_foto" name="pro_foto" onchange="setfoto();" />
                <input type="text" id="foto" name="foto" value="<?php echo $pro_foto; ?>" />
                <!--<label><?php //echo $pro_foto; ?></label>-->
            </td>
          </tr>
          
          <tr>
            <td colspan="2" >
              <input type="submit" id="alta_producto" name="alta_producto" class="boton" value="Enviar" />
              <?php
              if (@ereg('alta_productos', $_SERVER["SCRIPT_FILENAME"])) {
              ?>
                <a href='alta_productos.php'>
                  <input type='button' id="boton_cambiar" class='boton' value='Cambiar Tipo Producto' onClick="window.location.href='alta_productos.php'" />
                </a>
              <?php
              }
              ?>
              <a href='abm_productos.php'>
                <input type='button' class='boton' value='Volver' onClick="window.location.href='abm_productos.php'" />
              </a>
            </td>
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
   </form>   
   <!--End FORM -->
