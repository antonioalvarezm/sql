Como crear un select

<pre>
$select = new Select();
$select->add_table("tabla");
$select->add_field("*");
$select->add_where_eq("columna", $valorPorBuscar);
// devuelve la cadena de select
$select->build();
</pre>
