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
            <textarea name="pro_descripcion" id="pro_descripcion" class="campos" cols="100" rows="10" onkeyup="this.value=this.value.toUpperCase()" ><?php print $pro_descripcion;?></textarea>
            </td>
          </tr>
          <tr>
            <td class="formTitle">MARCA</td>
            <td>
                <?php
                    //echo "11-tip_id: " . $tip_id."-mar_id: " . $mar_id. "<br>";
                    $mar = new marcas();
                    $res = $mar->getmarcasxTipIdComboNulo($tip_id, $mar_id);
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
          <!--<tr>
            <td class="formTitle">PROVEEDOR</td>
            <td>
                <?php
                    //$prv = new proveedores();
                    //$res = $prv->getproveedoresCombo($prv_id);
                    //print $res;
                ?>
            </td>
          </tr>-->
          <tr>
            <td class="formTitle">CONTROLA STOCK</td>
            <?Php if ($pro_controla_stock=="S"){?>
                <td><input type="checkbox" id="pro_controla_stock" name="pro_controla_stock" checked="true" onkeyup="this.value=this.value.toUpperCase()" /></td>
            <?php } else {?>
                <td><input type="checkbox" id="pro_controla_stock" name="pro_controla_stock" onkeyup="this.value=this.value.toUpperCase()" /></td>
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