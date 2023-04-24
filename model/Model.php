<?php
require_once '../db/DataBase.php';

$variablesPeticion = file_get_contents('php://input');
$vars = json_decode($variablesPeticion);
$valores = count((array)$vars);
//print_r($valores);
if ($valores == 0) {
    header('Location: ../index');
}

class Model
{
    public $id = null;
    protected function toArray()
    {
        return get_class_vars(get_class($this));
    }

    protected function conectar()
    {
        return new Database('localhost', 'root', '', 'test1');
    }
}
?>