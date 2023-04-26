<?php
require_once 'Model.php';

class ModelProducto extends Model
{
    public function productos()
    {
        $cn = $this->conectar();
        return $cn->read('producto', []);
    }

}
?>