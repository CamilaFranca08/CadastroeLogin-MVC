<?php
namespace Models;

class ClassCrud extends ClassConexao{

    private $crud;
    private function prepareExecute($prep,$exec)
    {
        $this->crud=$this->conectaDB()->prepare($prep);
        $this->crud->execute($exec);
    }

    public function selectDB($fields , $table , $where , $exec)
    {
        $this->prepareExecute("select {$fields} from {$table} {$where}" , $exec);
        return $this->crud;
    }

    public function insertDB($table , $values , $exec)
    {
        $this->prepareExecute("insert into {$table} values ({$values})",$exec);
        return $this->crud;
    }

    public function deleteDB($table , $where , $exec)
    {
        $this->prepareExecute("delete from {$table} where {$where}" , $exec);
        return $this->crud;
    }

    public function updateDB($table , $values , $where , $exec)
    {
        $this->prepareExecute("update {$table} set {$values} where {$where}",$exec);
        return $this->crud;
    }
}