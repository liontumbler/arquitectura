<?php
require_once 'Model.php';
use Models\Model;

class ModelTest extends Model
{
    public $mipropiValor = ':)';
    public function obtenerValores()
    {
        return $this->toArray();
    }
}

//echo __NAMESPACE__;
?>