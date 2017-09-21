<?php
// Array que vincula los IDs de los selects declarados en el HTML con el nombre de la tabla donde se encuentra su contenido
$listadoSelects=array(
"marcas_llanta"=>"marcas_llanta",
"modelos_llanta"=>"modelos_llanta",
"producto_llanta"=>"stk_productos"
);

function validaSelectLlanta($selectDestino)
{
	// Se valida que el select enviado via GET exista
	global $listadoSelects;
	if(isset($listadoSelects[$selectDestino])) return true;
	else return false;
}

function validaOpcionLlanta($opcionSeleccionada)
{
	// Se valida que la opcion seleccionada por el usuario en el select tenga un valor numerico
	if(is_numeric($opcionSeleccionada)) return true;
	else return false;
}

$selectDestino=$_GET["select"]; $opcionSeleccionada=$_GET["opcion"];


if(validaSelectLlanta($selectDestino) && validaOpcionLlanta($opcionSeleccionada))
{
	$tabla=$listadoSelects[$selectDestino];
	//include 'conexion.php';
	//conectar();
        include_once "class/conex.php";
        Conectarse();
	if ($selectDestino == 'modelos_llanta')
	{
		$consulta=mysql_query("SELECT m.mod_id
                                        , m.mod_descripcion
                                        FROM modelos m, marcas_tipos_prod t
                                        where t.mtp_estado = 0
                                        and m.mod_estado = 0
                                        and m.mod_id=t.mod_id
                                        and t.tip_id in (2,3,9)
                                        and m.mar_id = ".$opcionSeleccionada."
                                        order by m.mod_descripcion") or die(mysql_error());

	}
	else if  ($selectDestino == 'producto')
	{
                $consulta=mysql_query("SELECT pro_id
                                        , pro_descripcion
                                        FROM `stk_productos`
                                        where pro_estado = 0
                                        and sct_id = '$opcionSeleccionada'") or die(mysql_error());
	}
	else 
	{
		$consulta=mysql_query("SELECT id, opcion FROM $tabla WHERE relacion='$opcionSeleccionada'") or die(mysql_error());
	}
	//desconectar();
	
	// Comienzo a imprimir el select
	echo "<select name='".$selectDestino."' id='".$selectDestino."' onChange='cargaContenidoLlanta(this.id)'>";
	echo "<option value='0'>Elige</option>";
	while($registro=mysql_fetch_row($consulta))
	{
		// Convierto los caracteres conflictivos a sus entidades HTML correspondientes para su correcta visualizacion
		$registro[1]=htmlentities($registro[1]);
		// Imprimo las opciones del select
		echo "<option value='".$registro[0]."'>".$registro[1]."</option>";
	}			
	echo "</select>";
}
?>