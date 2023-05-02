<?php
class ModelProducto extends Model
{
    public function productos()
    {
        return $this->obtenerProductos();
    }

}
?>