<?php
class carrito_stock {
    //atributos de la clase
    var $num_productos;
    var $array_pro_id;
    var $array_pro_descripcion;
    var $array_pro_cantidad;
    var $array_observaciones;
    var $productos_mail;

    //constructor. Realiza las tareas de inicializar los objetos cuando se instancian
    //inicializa el numero de productos a 0
    function carrito_stock () {
            $this->num_productos=0;
    }

    //Introduce un producto en el carrito. Recibe los datos del producto
    //Se encarga de introducir los datos en los arrays del objeto carrito
    //luego aumenta en 1 el numero de productos
    function introduce_producto($pro_id,$pro_descripcion,$pro_cantidad,$observaciones){
      if ($pro_id!=0 and $pro_id!=''){
        $this->array_pro_id[$this->num_productos]=$pro_id;
        $this->array_pro_descripcion[$this->num_productos]=$pro_descripcion;
        $this->array_pro_cantidad[$this->num_productos]=$pro_cantidad;
        $this->array_observaciones[$this->num_productos]=$observaciones;
        $this->num_productos++;
      }
    }
    function recupera_linea ($linea){
      if ($this->array_pro_id[$linea]!=0 and $this->array_pro_id[$linea]!=''){
        $respuesta[1]=$this->array_pro_id[$linea];
        $respuesta[2]=$this->array_pro_descripcion[$linea];
        $respuesta[3]=$this->array_pro_cantidad[$linea];
        $respuesta[4]=$this->array_observaciones[$linea];
        return $respuesta;
      }
    }
    //Muestra el contenido del carrito de la compra
    //ademas pone los enlaces para eliminar un producto del carrito
    function imprime_carrito($tipo,$tip_id,$suc_id,$suc_des_id,$remito){
      $mostrar = "";
      for ($i=0;$i<$this->num_productos;$i++){
        if($this->array_pro_id[$i]!=0){
            $mostrar = $mostrar . '<tr>';
            $mostrar = $mostrar . "<td class=rowBlanco>" . $this->array_pro_id[$i] . "</td>";
            $mostrar = $mostrar . "<td class=rowBlanco>" . $this->array_pro_descripcion[$i] . "</td>";
            $mostrar = $mostrar . "<td class=rowBlanco>" . $this->array_pro_cantidad[$i] . "</td>";
            $mostrar = $mostrar . "<td class=rowBlanco>" . $this->array_observaciones[$i] . "</td>";
            $mostrar = $mostrar . "<td class=rowBlanco><a href='class/eliminar_producto_stock.php?linea=".
                    $i."&tipo=".$tipo."&tip_id=".$tip_id."&suc_id=".$suc_id."&suc_des_id=".$suc_des_id.
                    "&remito=".$remito."'>Eliminar</td>";
            $mostrar = $mostrar . '</tr>';
        }
      }
      return $mostrar;
    }
	
    //elimina un producto del carrito. recibe la linea del carrito que debe eliminar
    //no lo elimina realmente, simplemente pone a cero el id, para saber que esta en estado retirado
    function elimina_producto($linea){
        $this->array_pro_id[$linea]=0;
        $this->array_pro_descripcion[$linea]=0;
        $this->array_pro_cantidad[$linea]=0;
        $this->array_observaciones[$linea]=0;
        //$this->num_productos--;
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
    function get_num_productos()
    { return $this->num_productos;}
    
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
    function actualiza_cantidad2($pro_id, $cantidad){
        for ($i=0;$i<$this->num_productos;$i++){
            if($this->array_pro_id[$i]==$pro_id){
                $this->array_pro_cantidad[$i] = $this->array_pro_cantidad[$i] + $cantidad;
            }
        }
        return 1;
    }        
}
//inicio la sesión
session_start();
//si no esta creado el objeto carrito en la sesion, lo creo
if (!isset($_SESSION["ocarrito_stock"])){
	$_SESSION["ocarrito_stock"] = new carrito_stock();
}
?>