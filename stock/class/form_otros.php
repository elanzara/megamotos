<?php if ($formulario=="alta"){ ?>
    <form action="alta_productos.php" method="POST" enctype="multipart/form-data">
<?php } elseif ($formulario=="modifica"){ ?>
    <form action="modifica_productos.php" method="POST" enctype="multipart/form-data">
<?php } ?>   
     <table class="form" border="0"  align="center">
        <tr>
            <td>
                <input name='pro_id' id='pro_id' value="<?php print $pro_id;?>" type='hidden' class='campos' size='18' />
            </td>
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
            <textarea name="pro_descripcion" id="pro_descripcion" class="campos" cols="100" rows="10" ><?php print $pro_descripcion;?></textarea>
            </td>
          </tr>
          <tr>
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
            <td class="formTitle">CONTROLA STOCK</td>
            <?Php if ($pro_controla_stock=="S"){?>
                <td><input type="checkbox" id="pro_controla_stock" name="pro_controla_stock" checked="true" /></td>
            <?php } else {?>
                <td><input type="checkbox" id="pro_controla_stock" name="pro_controla_stock" /></td>
            <?php }?>
            
          </tr>
          <tr>
            <td class="formTitle">STOCK MINIMO</td>
            <td><input type="text" name="pro_stock_min" id="pro_stock_min" class="campos" value="<?php print $pro_stock_min;?>" /></td>
          </tr>
          <tr>
            <td class="formTitle">PRECIO</td>
            <td><input type="text" name="pro_precio_costo" id="pro_precio_costo" class="campos" value="<?php print $pro_precio_costo;?>" /></td>
          </tr>
          <tr>
          	<td colspan="2" >
          		<input type="submit" id="alta_producto" name="alta_producto" class="boton" value="Enviar" />
                <!--  <a href='index.php'><input type='button' value='Volver' /></a>-->
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
