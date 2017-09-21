<?php
class carrito {
    //atributos de la clase
    var $num_productos;
    var $array_pro_id;
    var $array_pro_descripcion;
    var $array_pro_cantidad;
    var $array_pro_precio;
    var $array_pro_descuento;
    var $array_pro_importe;
    var $array_pro_iva;
    var $array_pro_observaciones;
    var $productos_mail;

    //constructor. Realiza las tareas de inicializar los objetos cuando se instancian
    //inicializa el numero de productos a 0
    function carrito () {
            $this->num_productos=0;
    }

    //Introduce un producto en el carrito. Recibe los datos del producto
    //Se encarga de introducir los datos en los arrays del objeto carrito
    //luego aumenta en 1 el numero de productos
    function introduce_producto($pro_id,$pro_descripcion,$pro_cantidad,$pro_precio,$pro_descuento,$pro_observaciones){
      if ($pro_id!=0 and $pro_id!=''){
       	$this->array_pro_id[$this->num_productos]=$pro_id;
       	$this->array_pro_descripcion[$this->num_productos]=$pro_descripcion;
       	$this->array_pro_cantidad[$this->num_productos]=$pro_cantidad;
        $this->array_pro_precio[$this->num_productos]=$pro_precio;
        $this->array_pro_descuento[$this->num_productos]=$pro_descuento;
        $importe = ($pro_cantidad*$pro_precio);
        $importe = ($importe - ($importe * $pro_descuento /100));
        $this->array_pro_importe[$this->num_productos]=$importe;
        $this->array_pro_iva[$this->num_productos]=$importe*0.21;
        $this->array_pro_observaciones[$this->num_productos]=$pro_observaciones;
	    $this->num_productos++;
      }
    }
    function actualiza_cantidad2($pro_id, $cantidad){
        for ($i=0;$i<$this->num_productos;$i++){
            if($this->array_pro_id[$i]==$pro_id){
                $this->array_pro_cantidad[$i] = $this->array_pro_cantidad[$i] + $cantidad;
                $importe = ($this->array_pro_cantidad[$i]*$this->array_pro_precio[$i]);
                $importe = ($importe - ($importe * $this->array_pro_descuento[$i] /100));
                $this->array_pro_importe[$i]=$importe;
            }
        }
        return 1;
    }
    function recupera_linea ($linea){
      if ($this->array_pro_id[$linea]!=0 and $this->array_pro_id[$linea]!=''){
        $respuesta[1]=$this->array_pro_id[$linea];
        $respuesta[2]=$this->array_pro_descripcion[$linea];
        $respuesta[3]=$this->array_pro_cantidad[$linea];
        $respuesta[4]=$this->array_pro_precio[$linea];
        $respuesta[5]=$this->array_pro_descuento[$linea];
        $respuesta[6]=$this->array_pro_importe[$linea];
        $respuesta[7]=$this->array_pro_iva[$linea];
        $respuesta[8]=$this->array_pro_observaciones[$linea];
        return $respuesta;
      }
    }
    //Muestra el contenido del carrito de la compra
    //ademas pone los enlaces para eliminar un producto del carrito
    function imprime_carrito2($fecha,$suc_id,$cli_id,$veh_id,$observaciones,$pmo_id,$realizo,$chk_veh){
       $mostrar = "";
       for ($i=0;$i<$this->num_productos;$i++){
        if($this->array_pro_id[$i]!=0){
            $mostrar = $mostrar . '<tr>';
            $mostrar = $mostrar . "<td class=rowBlanco style='width:30px;'>" . $this->array_pro_id[$i] . "</td>";
            $mostrar = $mostrar . "<td class=rowBlanco style='width:300px;'>" . $this->array_pro_descripcion[$i] . "</td>";
            $mostrar = $mostrar . "<td class=rowBlanco style='width:80px;'>" . $this->array_pro_cantidad[$i] . "</td>";
            $mostrar = $mostrar . "<td class=rowBlanco style='width:90px;'>" . number_format($this->array_pro_precio[$i],2) . "</td>";
            $mostrar = $mostrar . "<td class=rowBlanco style='width:90px;'>" . number_format($this->array_pro_descuento[$i],2) . "</td>";
            $mostrar = $mostrar . "<td class=rowBlanco style='width:100px;'>" . number_format($this->array_pro_importe[$i],2) . "</td>";
            $mostrar = $mostrar . "<td class=rowBlanco>" . $this->array_pro_observaciones[$i] . "</td>";
//            $mostrar = $mostrar . "<td class=rowBlanco>" . $this->array_pro_iva[$i] . "</td>";
//            $mostrar = $mostrar . "<td class=rowBlanco style='width:90px;'>
//                <input type='button' id='observaciones_det' name='observaciones_det' class='boton' value='Observaciones'
//                    onclick='obs_det(".$_SESSION["suc_id"].",".$i.");' /></td>";
            $mostrar = $mostrar . "<td class=rowBlanco style='width:20px;'><a href='class/eliminar_producto.php?linea=".
                        $i."&fecha=".$fecha."&suc_id=".$suc_id."&cli_id=".$cli_id."&veh_id=".$veh_id
                        ."&observaciones=".$observaciones."&pmo_id=".$pmo_id."&realizo=".$realizo."&chk_veh=".$chk_veh
                        ."'>Eliminar</td>";
            $mostrar = $mostrar . '</tr>';
//    			$precio = $this->array_precio_prod[$i];
//    			$cant = $this->array_cantidad_prod[$i];
            //$suma += $this->array_precio_prod[$i]*array_cantidad_prod[$i];
//    			$suma += $precio * $cant; 
        }
       }
       return $mostrar;
    }
    function imprime_carrito3($modif,$fecha,$suc_id,$cli_id,$veh_id,$observaciones,$pmo_id,$realizo,$chk_veh){
       $mostrar = "";
       for ($i=0;$i<$this->num_productos;$i++){
        if($this->array_pro_id[$i]!=0){
            $mostrar = $mostrar . '<tr>';
            $mostrar = $mostrar . "<td class=rowBlanco style='width:30px;'>" . $this->array_pro_id[$i] . "</td>";
            $mostrar = $mostrar . "<td class=rowBlanco style='width:300px;'>" . $this->array_pro_descripcion[$i] . "</td>";
            $mostrar = $mostrar . "<td class=rowBlanco style='width:80px;'>" . $this->array_pro_cantidad[$i] . "</td>";
            $mostrar = $mostrar . "<td class=rowBlanco style='width:90px;'>" . number_format($this->array_pro_precio[$i],2) . "</td>";
            $mostrar = $mostrar . "<td class=rowBlanco style='width:90px;'>" . number_format($this->array_pro_descuento[$i],2) . "</td>";
            $mostrar = $mostrar . "<td class=rowBlanco style='width:100px;'>" . number_format($this->array_pro_importe[$i],2) . "</td>";
//            $mostrar = $mostrar . "<td class=rowBlanco>" . $this->array_pro_iva[$i] . "</td>";
            $mostrar = $mostrar . "<td class=rowBlanco>".$this->array_pro_observaciones[$i]."</td>";
            if ($modif != 's') {
                $mostrar = $mostrar . "<td class=rowBlanco style='width:20px;'><a href='class/eliminar_producto_modif.php?linea=".$i
                            ."&fecha=".$fecha."&suc_id=".$suc_id."&cli_id=".$cli_id."&veh_id=".$veh_id
                            ."&observaciones=".$observaciones."&pmo_id=".$pmo_id."&realizo=".$realizo."&chk_veh=".$chk_veh
                            ."'>Eliminar</td>";
            }
            $mostrar = $mostrar . '</tr>';
//    			$precio = $this->array_precio_prod[$i];
//    			$cant = $this->array_cantidad_prod[$i];
            //$suma += $this->array_precio_prod[$i]*array_cantidad_prod[$i];
//    			$suma += $precio * $cant; 
        }
       }
       return $mostrar;
    }

    function get_total_bruto(){
        $bruto = 0;
        for ($i=0;$i<$this->num_productos;$i++){
            if($this->array_pro_id[$i]!=0){
            $bruto = $bruto + $this->array_pro_importe[$i];
        }
    }
    return $bruto;
    }
    function get_total_iva(){
	$iva = 0;
    	for ($i=0;$i<$this->num_productos;$i++){
    		if($this->array_pro_id[$i]!=0){
                $iva = $iva + $this->array_pro_iva[$i];
            }
        }
        return $iva;        
    }
    function get_total(){
	$total = 0;
        $iva = 0;
        $bruto = 0;
        $iva = $this->get_total_iva();
        $bruto = $this->get_total_bruto();
        //$total = $bruto + $iva;
        $total = $bruto;
        return $total;        
    }
        
	function imprime_carrito(){
            $suma = 0;
            echo '<table border=1 cellpadding="4">
                      <tr>
                        <td class="style21"><b>Nombre producto</b></td>
                            <td class="style21"><b>Precio</b></td>
                            <td class="style21"><b>Cantidad</b></td>
                            <td>&nbsp;</td>
                      </tr>';
            for ($i=0;$i<$this->num_productos;$i++){
                if($this->array_id_prod[$i]!=0){
                    echo '<tr>';
                    echo "<form method='post' name='Formulario'> ";
                    echo "<td class=Estilo3>" . $this->array_nombre_prod[$i] . "</td>";
                    echo "<td class=Estilo3>" . $this->array_precio_prod[$i] . "</td>";
                    echo "<td class=Estilo3><INPUT TYPE=text NAME=cantidad$i onchange='javascript:cambio($i,this.value);' value=" . $this->array_cantidad_prod[$i] . "></td>";
                    echo "<td class=style19><a href='eliminar_producto.php?linea=$i'>Eliminar</td>";
                    echo "</form>";
                    echo '</tr>';
                    $precio = $this->array_precio_prod[$i];
                    $cant = $this->array_cantidad_prod[$i];
                    //$suma += $this->array_precio_prod[$i]*array_cantidad_prod[$i];
                    $suma += $precio * $cant;
                }
            }
            //muestro el total
            echo "<tr><td class=style21><b>TOTAL:</b></td><td class=style21> <b>$suma</b></td><td>&nbsp;</td></tr>";
            //total más IVA
            //echo "<tr><td><b>IVA (16%):</b></td><td> <b>" . $suma * 1.16 . "</b></td><td>&nbsp;</td></tr>";
            echo "</table>";
	}

    function existe_producto($pro_id){
        $resultado = 'N';
        for ($i=0;$i<$this->num_productos;$i++){
            if($this->array_pro_id[$i]==$pro_id){
                $resultado = 'S';
                }
            }
        return $resultado;
    }

    function devuelvo_cantidad($pro_id){
        $cantidad = 0;
        for ($i=0;$i<$this->num_productos;$i++){
            if($this->array_pro_id[$i]==$pro_id){
                $cantidad = $this->array_pro_cantidad[$i];
                }
            }
        return $cantidad;
    }

		function imprime_carrito_mail(){
		$suma = 0;
		//$productos_mail="Nombre producto\t\tPrecio\t\tCantidad \n\n";
		$productos_mail="";
		for ($i=0;$i<$this->num_productos;$i++){
			if($this->array_id_prod[$i]!=0){
				$productos_mail=$productos_mail . "Nombre producto: " . $this->array_nombre_prod[$i] . "\n";
				$productos_mail=$productos_mail . "Precio: " . $this->array_precio_prod[$i] . "\n";
				$productos_mail=$productos_mail . "Cantidad: " . $this->array_cantidad_prod[$i] . "\n\n";
				$precio = $this->array_precio_prod[$i];
				$cant = $this->array_cantidad_prod[$i];
				$suma += $precio * $cant; 
			}
		}
		//muestro el total
		$productos_mail=$productos_mail . "\nTOTAL: " . $suma;
		return $productos_mail;
	}
	
	//elimina un producto del carrito. recibe la linea del carrito que debe eliminar
	//no lo elimina realmente, simplemente pone a cero el id, para saber que esta en estado retirado
	function elimina_producto($linea){
            $this->array_pro_id[$linea]=0;
            $this->array_pro_descripcion[$linea]=0;
            $this->array_pro_cantidad[$linea]=0;
            $this->array_pro_precio[$linea]=0;
            $this->array_pro_descuento[$linea]=0;
            $this->array_pro_importe[$linea]=0;
            $this->array_pro_iva[$linea]=0;
            $this->array_pro_observaciones[$linea]="";
        //    $this->num_productos--;
	}
	function actualiza_cantidad ($linea,$cantidad) {
		$this->array_cantidad_prod[$linea]=$cantidad;
	}
	function existe_carrito () {
		if ($this->num_productos>0){
			$resultado="si";
		} else {
			$resultado="no";
		}
		return $resultado;
	}
	function comprobar_email($email){ 
   	$mail_correcto = 0; 
   	//compruebo unas cosas primeras 
   	if ((strlen($email) >= 6) && (substr_count($email,"@") == 1) && (substr($email,0,1) != "@") && (substr($email,strlen($email)-1,1) != "@")){ 
      	 if ((!strstr($email,"'")) && (!strstr($email,"\"")) && (!strstr($email,"\\")) && (!strstr($email,"\$")) && (!strstr($email," "))) { 
         	 //miro si tiene caracter . 
         	 if (substr_count($email,".")>= 1){ 
            	 //obtengo la terminacion del dominio 
            	 $term_dom = substr(strrchr ($email, '.'),1); 
            	 //compruebo que la terminación del dominio sea correcta 
            	 if (strlen($term_dom)>1 && strlen($term_dom)<5 && (!strstr($term_dom,"@")) ){ 
               	 //compruebo que lo de antes del dominio sea correcto 
               	 $antes_dom = substr($email,0,strlen($email) - strlen($term_dom) - 1); 
               	 $caracter_ult = substr($antes_dom,strlen($antes_dom)-1,1); 
               	 if ($caracter_ult != "@" && $caracter_ult != "."){ 
                  	 $mail_correcto = 1; 
               	 } 
            	 } 
         	 } 
      	 } 
   	} 
   	if ($mail_correcto) 
      	 return 1; 
   	else 
      	 return 0; 
	}
    function get_num_productos()
    { return $this->num_productos;}
}
//inicio la sesión
session_start();
//si no esta creado el objeto carrito en la sesion, lo creo
if (!isset($_SESSION["ocarrito"])){
	$_SESSION["ocarrito"] = new carrito();
}
?>