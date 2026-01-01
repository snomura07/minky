<?php

require_once __DIR__ . '/../models/db.php'; 

class QueryBuilder {
    private $tableName;
    private $selects = [];
    private $andWheres = [];
    private $orWheres = [];
    
    public function table($tableName) {
        $this->tableName = $tableName;
        return $this;
    }

    public function select(...$columns) {
        $this->selects = array_merge($this->selects, $columns);
        print_r($this->selects);
        return $this;
    }

    public function orWhere($column, $operator=null, $value=null) {
        if($value==null){
            $value = $operator;
            $operator = "=";
        }

        $this->orWheres[] = [
            "column" => $column,
            "operator" => $operator,
            "value" => $value,
        ];
        print_r($this->orWheres);

        return $this;
    }

    public function andWhere($column, $operator=null, $value=null) {
        if($value==null){
            $value = $operator;
            $operator = "=";
        }

        $this->andWheres[] = [
            "column" => $column,
            "operator" => $operator,
            "value" => $value,
        ];
        print_r($this->andWheres);

        return $this;
    }

    public function get() {

        $query = "select ";

        # select columns
        if (empty($this->selects)) {
            $query .= "* ";
        }
        else {
            $query .= implode(", ", $this->selects) . " ";
        }

        # from
        $query .= "from " . $this->tableName . " ";

        #where
        if (!empty($this->orWheres) || !empty($this->andWheres)) {
            $query .= "where ";
        }

        # andWhere
        if (!empty($this->andWheres)) {
            $query .= "(";
            $lastKey = array_key_last($this->andWheres);
            foreach ($this->andWheres as $index => $condition) {
                if ($index == $lastKey) {
                    $query .= $condition["column"] . " " . $condition["operator"] . " " . $condition["value"] . ") ";
                }
                else {
                    $query .= $condition["column"] . " " . $condition["operator"] . " " . $condition["value"] . " and ";
                }
            }
        }

        # orWhere
        if (!empty($this->orWheres)) {
            $query .= empty($this->andWheres) ? "" : " or ";
            $lastKey = array_key_last($this->orWheres);
            foreach ($this->orWheres as $index => $condition) {
                if ($index == $lastKey) {
                    $query .= $condition["column"] . " " . $condition["operator"] . " " . $condition["value"];
                }
                else {
                    $query .= $condition["column"] . " " . $condition["operator"] . " " . $condition["value"] . " or ";
                }
            }
        }
         
        print $query . "\n";
        #order by

        $db = Db::getConnection();
        return $db->query($query)->fetchAll();
    }
}
