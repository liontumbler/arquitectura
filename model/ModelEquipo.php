<?php
require_once 'Model.php';

class ModelEquipo extends Model
{
    public function equipos()
    {
        $cn = $this->conectar();
        return $cn->read('equipo', []);
    }
}
?>