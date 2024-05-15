<?php
error_reporting(E_ALL & ~ E_NOTICE);

/**
 *
 * @author antonioalvarezm
 * @version 1.0.2 2024-04-19
 * @method buildPartIn
 *         Correccion de manejo de where in, where not in cuando se tienen mas de 2 campos como filtro
 */

/**
 *
 * @author antonioalvarezm.
 * @abstract
 */
class Generic
{

    private $tables;

    private $fields;

    private $values;

    private $where;

    private $whereIn;

    private $whereNotIn;

    private $fieldWhereIn;

    private $fieldWhereNotIn;

    private $field_where_in;

    private $field_where_not_in;

    /**
     * Constructor inicializa los arreglos
     */
    public function __construct()
    {
        $this->tables = array();
        $this->fields = array();
        $this->values = array();
        $this->where = array();
        $this->whereIn = array();
        $this->whereNotIn = array();
        $this->fieldWhereIn = array();
        $this->fieldWhereNotIn = array();
    }

    public function clearSuper()
    {
        $this->tables = array();
        $this->fields = array();
        $this->values = array();
        $this->where = array();
        $this->whereIn = array();
        $this->whereNotIn = array();
        $this->fieldWhereIn = array();
        $this->fieldWhereNotIn = array();
    }

    /**
     *
     * @param string $value
     * @param string $format
     * @return string
     */
    public function format_date($value, $format)
    {
        return "date_format('" . addslashes($value) . "', '" . addslashes($format) . "')";
    }

    /*
     * Agrega tabla
     */
    public function add_table($table)
    {
        array_push($this->tables, $table);
    }

    /**
     *
     * @param string $table_left
     * @param string $table_right
     * @param string $relations
     */
    public function add_left_table($table_left, $table_right, $relations)
    {
        array_push($this->tables, $table_left . " left join " . $table_right . " on (" . $relations . ")");
    }

    /*
     * Obtiene tablas
     */
    function get_table()
    {
        return $this->tables;
    }

    /**
     * campo del query
     *
     * @param string $field
     */
    public function add_field($field)
    {
        array_push($this->fields, $field);
    }

    public function add_field_str($field)
    {
        array_push($this->fields, "'" . addslashes($field) . "'");
    }

    /**
     *
     * @param string $field
     * @param string $value
     */
    public function add_field_value($field, $value)
    {
        array_push($this->fields, $field);
        array_push($this->values, "'" . addslashes($value) . "'");
    }

    /**
     *
     * @param string $field
     * @param string $value
     */
    public function add_field_value_function($field, $value)
    {
        array_push($this->fields, $field);
        array_push($this->values, addslashes($value));
    }

    /**
     * Coloca valores de los campos
     *
     * @param string $field
     * @param string $value
     */
    public function add_field_value_null($field, $value)
    {
        array_push($this->fields, $field);
        array_push($this->values, "null");
    }

    /**
     * Coloca valores de los campos y usa upper
     *
     * @param string $field
     * @param string $value
     */
    public function add_field_value_up($field, $value)
    {
        array_push($this->fields, $field);
        array_push($this->values, "upper('" . addslashes($value) . "')");
    }

    /**
     * Coloca valores de los campos
     *
     * @param string $field
     * @param string $value
     */
    public function add_field_value_abs($field, $value)
    {
        array_push($this->fields, $field);
        array_push($this->values, addslashes($value));
    }

    /*
     * Coloca valores para los campos
     */
    public function add_field_value_date($field, $value, $format)
    {
        array_push($this->fields, $field);
        array_push($this->values, "str_to_date('" . addslashes($value) . "', '" . $format . "')");
    }

    /*
     * Coloca valores para los campos
     */
    public function add_field_value_md5($field, $value)
    {
        array_push($this->fields, $field);
        array_push($this->values, "MD5('" . addslashes($value) . "')");
    }

    /**
     *
     * @param string $field
     * @param string $value
     *            Y%-%m-d%
     * @param int $month
     */
    public function add_field_value_adddate($field, $value, $month)
    {
        array_push($this->fields, $field);
        array_push($this->values, "date_add('" . addslashes($value) . "', interval " . addslashes($month) . " month)");
    }

    /*
     * Obtiene los campos
     */
    function get_fields()
    {
        return $this->fields;
    }

    /*
     * Obtiene los campos
     */
    function get_value()
    {
        return $this->values;
    }

    /*
     * Coloca valores para los filtros
     */
    public function add_where($value)
    {
        array_push($this->where, $value);
    }

    public function add_where_is_null($value)
    {
        array_push($this->where, $value . " is null ");
    }

    public function add_where_is_not_null($value)
    {
        array_push($this->where, $value . " is not null ");
    }

    public function add_where_eq($field, $value)
    {
        array_push($this->where, $field . " = '" . addslashes($value) . "'");
    }

    public function add_where_op($field, $operator, $value)
    {
        array_push($this->where, $field . " " . $operator . " '" . addslashes($value) . "'");
    }

    public function add_where_not_eq($field, $value)
    {
        array_push($this->where, $field . " != '" . addslashes($value) . "'");
    }

    public function add_where_like($field, $value)
    {
        array_push($this->where, $field . " like '%" . addslashes($value) . "%'");
    }

    public function add_join($field1, $field2)
    {
        array_push($this->where, $field1 . " = " . $field2);
    }

    public function add_where_in($field, $value)
    {
        $this->field_where_in = $field;
        array_push($this->fieldWhereIn, array(
            array(
                "column" => $field,
                "value" => "'" . addslashes($value) . "'"
            )
        ));
        array_push($this->whereIn, "'" . addslashes($value) . "'");
    }

    public function add_where_not_in($field, $value)
    {
        $this->field_where_not_in = $field;
        array_push($this->fieldWhereNotIn, array(
            array(
                "column" => $field,
                "value" => "'" . addslashes($value) . "'"
            )
        ));
        array_push($this->whereNotIn, "'" . addslashes($value) . "'");
    }

    /**
     * Subquery
     *
     * @param string $field
     * @param string $value
     */
    public function add_where_subquery($field, $value)
    {
        $this->field_where_in = $field;
        array_push($this->whereIn, addslashes($value));
    }

    public function add_like($field, $value)
    {
        array_push($this->where, $field . " like '%" . addslashes($value) . "%'");
    }

    public function add_between($field, $value_start, $value_end)
    {
        array_push($this->where, $field . " between " . addslashes($value_start) . " and " . addslashes($value_end));
    }

    public function add_between_date($field, $value_start, $value_end)
    {
        array_push($this->where, "date_format(" . $field . ", '%Y-%m-%d') between str_to_date('" . addslashes($value_start) . "','%d/%m/%Y') and str_to_date('" . addslashes($value_end) . "','%d/%m/%Y')");
    }

    /*
     * Obtiene los where
     */
    function get_where()
    {
        return $this->where;
    }

    function get_where_in()
    {
        return $this->whereIn;
    }

    function get_where_not_in()
    {
        return $this->whereNotIn;
    }

    function get_field_where_in()
    {
        return $this->fieldWhereIn;
    }

    function get_field_where_not_in()
    {
        return $this->fieldWhereNotIn;
    }

    /*
     * Obtiene los filtros
     */
    public function get_filters()
    {
        return $this->filters;
    }

    /*
     * Recorre los arreglos
     */
    function buildPart($arrays, $sep)
    {
        $value = "";
        $numero = count($arrays);
        for ($i = 0; $i < $numero; $i ++) {
            $value = $value . " " . $arrays[$i] . $sep;
        }
        return substr($value, 0, strlen($value) - strlen($sep));
    }

    /**
     *
     * @param array $arrays
     * @param string $sep
     *            "and"
     * @return string
     */
    function buildPartIn($arrays, $sep)
    {
        $value = "";
        $where = array();
        $whereIn = array();
        for ($i = 0; $i < count($arrays); $i ++) {
            $where[] = array_column($arrays[$i], "value", "column");
        }
        for ($i = 0; $i < count($where); $i ++) {
            foreach ($where[$i] as $key => $values) {
                $whereIn[$key][] = $values;
            }
        }
        foreach ($whereIn as $key => $values) {
            $value .= " " . $key . " in (" . implode(",", $values) . ") " . $sep;
        }
        return substr($value, 0, strlen($value) - strlen($sep));
    }

    /**
     *
     * @param array $arrays
     * @param string $sep
     *            "and"
     * @return string
     */
    function buildPartNotIn($arrays, $sep)
    {
        $value = "";
        $where = array();
        $whereNotIn = array();
        for ($i = 0; $i < count($arrays); $i ++) {
            $where[] = array_column($arrays[$i], "value", "column");
        }
        for ($i = 0; $i < count($where); $i ++) {
            foreach ($where[$i] as $key => $values) {
                $whereNotIn[$key][] = $values;
            }
        }
        foreach ($whereNotIn as $key => $values) {
            $value .= " " . $key . " not in (" . implode(",", $values) . ") " . $sep;
        }
        return substr($value, 0, strlen($value) - strlen($sep));
    }

    // abstract function build();
    // abstract function Generic factory();
}

/**
 *
 * @author antonioalvarezm.
 * @category select
 */
class Select extends Generic
{

    private $order;

    private $extras;

    private $group;

    /**
     * Constructor inicializa los arreglos
     */
    public function __construct()
    {
        $this->clearSuper();
        $this->order = array();
        $this->extra = array();
        $this->group = array();
    }

    public function clear()
    {
        $this->clearSuper();
        $this->group = array();
        $this->order = array();
        $this->extra = array();
    }

    public function add_group($field)
    {
        array_push($this->group, $field);
    }

    public function get_group()
    {
        return $this->group;
    }

    public function add_order($field)
    {
        array_push($this->order, $field);
    }

    function get_order()
    {
        return $this->order;
    }

    public function add_extras($values)
    {
        array_push($this->extra, $values);
    }

    function get_extras()
    {
        return $this->extra;
    }

    /**
     *
     * @return string
     */
    function build()
    {
        $sql = "select " . $this->buildPart($this->get_fields(), ", ") . " from " . $this->buildPart($this->get_table(), ", ");
        $foundWhere = false;
        $wheres = count($this->get_where());
        $wheresIn = count($this->get_where_in());
        $wheresNotIn = count($this->get_where_not_in());
        $group = count($this->get_group());
        $orders = count($this->get_order());
        $extras = count($this->get_extras());

        if ($wheres > 0) {
            $sql = $sql . " where " . $this->buildPart($this->get_where(), " and ");
            $foundWhere = true;
        }
        if ($wheresIn > 0) {
            if ($foundWhere) {
                $sql = $sql . " and " . $this->buildPartIn($this->get_field_where_in(), " and ");
            } else {
                $sql = $sql . " where " . $this->buildPartIn($this->get_field_where_in(), " and ");
            }
        }
        if ($wheresNotIn > 0) {
            if ($foundWhere) {
                $sql = $sql . " and " . $this->buildPartNotIn($this->get_field_where_not_in(), " and ");
            } else {
                $sql = $sql . " where " . $this->buildPartNotIn($this->get_field_where_not_in(), " and ");
            }
        }
        if ($group > 0) {
            $sql = $sql . " group by " . $this->buildPart($this->get_group(), ", ");
        }
        if ($orders > 0) {
            $sql = $sql . " order by " . $this->buildPart($this->get_order(), ", ");
        }
        if ($extras > 0) {
            $sql = $sql . " " . $this->buildPart($this->get_extras(), " ");
        }
        return $sql;
    }
}

/**
 *
 * @author antonioalvarezm.
 * @category insert
 */
class Insert extends Generic
{

    public function __construct()
    {
        $this->clearSuper();
    }

    public function clear()
    {
        $this->clearSuper();
    }

    /**
     *
     * @return string
     */
    function build()
    {
        $sql = "insert into " . $this->buildPart($this->get_table(), ", ") . " ( " . $this->buildPart($this->get_fields(), ", ") . " ) values (" . $this->buildPart($this->get_value(), ", ") . " )";

        return $sql;
    }
}

/**
 *
 * @author antonioalvarezm.
 * @category update
 */
class Update extends Generic
{

    public function __construct()
    {
        $this->clearSuper();
    }

    public function clear()
    {
        $this->clearSuper();
    }

    function buildSet()
    {
        $value = "";
        $sep = ", ";
        $f = $this->get_fields();
        $v = $this->get_value();
        $numero = count($f);
        if ($numero > 0) {
            for ($i = 0; $i < $numero; $i ++) {
                $value = $value . $f[$i] . " = " . $v[$i] . $sep;
            }
        }
        return substr($value, 0, strlen($value) - strlen($sep));
    }

    function build()
    {
        $foundWhere = false;
        $sql = "update " . $this->buildPart($this->get_table(), ", ") . " set " . $this->buildSet() . " ";
        $wheres = count($this->get_where());
        $wheresIn = count($this->get_where_in());
        $wheresNotIn = count($this->get_where_not_in());

        if ($wheres > 0) {
            $sql = $sql . " where " . $this->buildPart($this->get_where(), " and ");
            $foundWhere = true;
        }
        /*
         * if ($wheresIn > 0) {
         * if ($foundWhere) {
         * $sql = $sql . " and " . $this->buildPartIn($this->get_where_in(), " and ");
         * } else {
         * $sql = $sql . " where " . $this->buildPartIn($this->get_where_in(), " and ");
         * }
         * }
         */
        if ($wheresIn > 0) {
            if ($foundWhere) {
                $sql = $sql . " and " . $this->buildPartIn($this->get_field_where_in(), " and ");
            } else {
                $sql = $sql . " where " . $this->buildPartIn($this->get_field_where_in(), " and ");
            }
        }
        if ($wheresNotIn > 0) {
            if ($foundWhere) {
                $sql = $sql . " and " . $this->buildPartNotIn($this->get_field_where_not_in(), " and ");
            } else {
                $sql = $sql . " where " . $this->buildPartNotIn($this->get_field_where_not_in(), " and ");
            }
        }

        return $sql;
    }
}

/**
 *
 * @author antonioalvarezm.
 * @category delete
 */
class Delete extends Generic
{

    public function __construct()
    {
        $this->clearSuper();
    }

    public function clear()
    {
        $this->clearSuper();
    }

    /**
     *
     * @return string
     */
    function build()
    {
        $sql = "delete from " . $this->buildPart($this->get_table(), ", ");
        $wheres = count($this->get_where());
        $wheresIn = count($this->get_where_in());
        $wheresNotIn = count($this->get_where_not_in());
        if ($wheres > 0) {
            $sql = $sql . " where " . $this->buildPart($this->get_where(), " and ");
            $foundWhere = true;
        }
        /*
         * if ($wheresIn > 0) {
         * if ($foundWhere) {
         * $sql = $sql . " and " . $this->buildPartIn($this->get_where_in(), " and ");
         * } else {
         * $sql = $sql . " where " . $this->buildPartIn($this->get_where_in(), " and ");
         * }
         * }
         * if ($wheresNotIn > 0) {
         * if ($foundWhere) {
         * $sql = $sql . " and " . $this->buildPartNotIn($this->get_where_not_in(), " and ");
         * } else {
         * $sql = $sql . " where " . $this->buildPartNotIn($this->get_where_not_in(), " and ");
         * }
         * }
         */
        if ($wheresIn > 0) {
            if ($foundWhere) {
                $sql = $sql . " and " . $this->buildPartIn($this->get_field_where_in(), " and ");
            } else {
                $sql = $sql . " where " . $this->buildPartIn($this->get_field_where_in(), " and ");
            }
        }
        if ($wheresNotIn > 0) {
            if ($foundWhere) {
                $sql = $sql . " and " . $this->buildPartNotIn($this->get_field_where_not_in(), " and ");
            } else {
                $sql = $sql . " where " . $this->buildPartNotIn($this->get_field_where_not_in(), " and ");
            }
        }

        return $sql;
    }
}

?>