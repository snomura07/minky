<?php

// select
//     id, name, date
// from
//     gggTable
// where
//     id = 1 and data > yyyy/mm/dd
// ;

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
        return $this;
    }
}
