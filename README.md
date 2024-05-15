Como crear un select

<pre>
$select = new Select();
$select->add_table("tabla");
$select->add_field("*");
$select->add_where_eq("columna", $valorPorBuscar);
// devuelve la cadena de select
$select->build();
</pre>

Como crear un insert
<pre>
$insert = new Insert();
$insert->add_table("tabla");
$insert->add_field_value("columna", $valorPorInsertar);
// Devuelve la cadena de insert  
$insert->build();
</pre>

Como crear un update
<pre>
$update = new Update();
$update->add_table("tabla");
$update->add_field_value("columna", $valorPorActualizar);
$update->add_where_eq("columna_filtro", $valorPorBuscar);   
// Devuelve la cadena de update
$update->build();
</pre>

Como crear un delete
<pre>
$delete = new Delete();
$delete->add_table("tabla");
$delete->add_where_eq("columna", $valorPorBuscar);
// Devuelve la cadena de delete 
$delete->build();
</pre>
 
