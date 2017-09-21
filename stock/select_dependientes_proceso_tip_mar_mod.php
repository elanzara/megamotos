<?php
// Array que vincula los IDs de los selects declarados en el HTML con el nombre de la tabla donde se encuentra su contenido
$listadoSelects=array(
"tipo_productos"=>"tipo_productos",
"marcas"=>"marcas",
"modelos"=>"modelos"
);

function validaSelect($selectDestino)
{
	// Se valida que el select enviado via GET exista
	global $listadoSelects;
	if(isset($listadoSelects[$selectDestino])) return true;
	else return false;
}

function validaOpcion($opcionSeleccionada)
{
	// Se valida que la opcion seleccionada por el usuario en el select tenga un valor numerico
	if(is_numeric($opcionSeleccionada)) return true;
	else return false;
}

$selectDestino=$_GET["select"]; $opcionSeleccionada=$_GET["opcion"];


if(validaSelect($selectDestino) && validaOpcion($opcionSeleccionada))
{
	$tabla=$listadoSelects[$selectDestino];
	//include 'conexion.php';
	//conectar();
        include_once "class/conex.php";
        Conectarse();
	if ($selectDestino == 'marcas')
	{
		$consulta=mysql_query("SELECT distinct(m.mar_id)
                                        ,(select m2.mar_descripcion from marcas m2 where m.mar_id = m2.mar_id) as mar_descripcion
                                        FROM `marcas` m, marcas_tipos_prod t
                                        WHERE t.mtp_estado = 0
                                        and m.mar_id=t.mar_id
                                        and t.tip_id = '$opcionSeleccionada'
                                        order by m.mar_descripcion") or die(mysql_error());
 	}
	else 	if ($selectDestino == 'modelos')
	{
		$consulta=mysql_query("SELECT mod_id
							, mod_descripcion
							FROM `modelos`
							WHERE mod_estado = 0
							and mar_id = '$opcionSeleccionada'
							order by mar_id
							, mod_id") or die(mysql_error());

	}
	else 
	{
		$consulta=mysql_query("SELECT id, opcion FROM $tabla WHERE relacion='$opcionSeleccionada'") or die(mysql_error());
	}
	//desconectar();
	
	// Comienzo a imprimir el select
	echo "<select name='".$selectDestino."' id='".$selectDestino."' onChange='cargaContenido(this.id)'>";
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