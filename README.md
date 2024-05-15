como usuarlo

$select = new Select();
$select->add_table("tabla");
$select->add_field("*");
$select->add_where_eq("columna", $id);
// devuelve la cadena de select
$select->build();
