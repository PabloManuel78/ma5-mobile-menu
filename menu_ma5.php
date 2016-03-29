<?php 
//funciona con dos funciones más, las dos son iguales
//pero una llama a la otra para ir creando el arbol
//para el plugin de jquery
//
function menu_ma5_1($menu, $padre, $indice)
{
	global $conn;
	
	$sql = "select id, idpadre, nombre, title, url from menus where menu=" . $menu . " and idpadre=" . $padre . " order by pos";
	$result = $conn->query($sql) Or Die ("Error cargando datos");

	// Le añadimos el botón para entrar en el sub menú.
	echo "<span class='ma5-btn-enter'><i class='fa fa-chevron-right'></i></span>";

	// Abrimos la lista del nuevo menú
	echo "<ul data-ma5-order='ma5-ul" . $indice . "'>";

	$j=0;
	while($rs = $result->fetch_object())
	{
		$j++;
		
		if ($j==1)
		{
			// Añadimos la primera opción que contiene la de volver.
			echo "<li data-ma5-order='ma5-li" . $indice . "-" . $j . "'>" .
					"<div class='ma5-leave-bar'>" . 
						"<span class='ma5-btn-leave'>" .
							"<i class='fa fa-chevron-left'></i>".
						"</span>" . 
						comprobarlogico("menus", "nombre", "id=" . $padre) . 
					"</div>";
		}
		else
		{
			echo "<li data-ma5-order='ma5-li" . $indice . "-" . $j . "'>";
		}
		
		$r = "<a ##has_submenu## title='" . $rs->title . "' href='" . $rs->url . "'>" . $rs->nombre . "</a>";
		
		// Si no tiene hijos, lo dejamos sin clase.
		if (comprobarlogico("menus", "id", "idpadre=" . $rs->id) == false)
		{
			echo str_replace("##has_submenu##", "", $r);
		}
		// si sí tiene, le añadimos la clase
		else
		{
			echo str_replace("##has_submenu##", "class='ma5-has-submenu'", $r);
			
			menu_ma5_2($menu, $rs->id, $indice . "-" . $j);
			
		}

		echo "</li>";
	}
	
	echo "</ul>";
	
return $r;
}

function menu_ma5_2($menu, $padre, $indice)
{
	global $conn;
	
	$sql = "select id, idpadre, nombre, title, url from menus where menu=" . $menu . " and idpadre=" . $padre . " order by pos";
	$result = $conn->query($sql) Or Die ("Error cargando datos");

	// Le añadimos el botón para entrar en el sub menú.
	echo "<span class='ma5-btn-enter'><i class='fa fa-chevron-right'></i></span>";

	// Abrimos la lista del nuevo menú
	echo "<ul data-ma5-order='ma5-ul" . $indice . "'>";

	$j=0;
	while($rs = $result->fetch_object())
	{
		$j++;
		
		if ($j==1)
		{
			// Añadimos la primera opción que contiene la de volver.
			echo "<li data-ma5-order='ma5-li" . $indice . "-" . $j . "'>" .
					"<div class='ma5-leave-bar'>" . 
						"<span class='ma5-btn-leave'>" .
							"<i class='fa fa-chevron-left'></i>".
						"</span>" . 
						comprobarlogico("menus", "nombre", "id=" . $padre) . 
					"</div>";
		}
		else
		{
			echo "<li data-ma5-order='ma5-li" . $indice . "-" . $j . "'>";
		}
		
		$r = "<a ##has_submenu## title='" . $rs->title . "' href='" . $rs->url . "'>" . $rs->nombre . "</a>";
		
		// Si no tiene hijos, lo dejamos sin clase.
		if (comprobarlogico("menus", "id", "idpadre=" . $rs->id) == false)
		{
			echo str_replace("##has_submenu##", "", $r);
		}
		// si sí tiene, le añadimos la clase
		else
		{
			echo str_replace("##has_submenu##", "class='ma5-has-submenu'", $r);
			
			menu_ma5_1($menu, $rs->id, $indice . "-" . $j);
			
		}
		
		echo "</li>";
	}
	
	echo "</ul>";

}

function menu_ma5($menu = 0)
{	
	global $conn;
	$sql = "select id, idpadre, nombre, title, url from menus where menu=" . $menu . " and idpadre=0 order by pos";
	$result = $conn->query($sql) Or Die ("Error cargando datos");
	
	echo "<nav class='ma5-menu-mobile'>";
		
	if ($result->num_rows !== 0) echo "<ul data-ma5-order='ma5-ul'>";
	
	$i=0;
	while($rs = $result->fetch_object())
	{
		$i++;
		
		$indice = "-" . $i;
		
		echo "<li data-ma5-order='ma5-li" . $indice . "'>";
		$r = "<a ##has_submenu## title='" . $rs->title . "' href='" . $rs->url . "'>" . $rs->nombre . "</a>";
		
		// Si no tiene hijos, lo dejamos sin clase.
		if (comprobarlogico("menus", "id", "idpadre=" . $rs->id) == false)
		{
			echo str_replace("##has_submenu##", "", $r);
		}
		// si sí tiene, le añadimos la clase
		else
		{
			echo str_replace("##has_submenu##", "class='ma5-has-submenu'", $r);
			
			menu_ma5_1($menu, $rs->id, $indice);
		}

		echo "</li>";
	}
	
	if ($result->num_rows !== 0) echo "</ul>";

	$result->close();
	
	echo "</nav>";

}

?>
