<?php
class ModelProducto extends Model
{
    public function productos()
    {
        return $this->obtenerProductoPorId();
    }

    public function cargarNombreProductoPorId($id)
    {
        return $this->obtenerNombreProductoPorId($id);
    }

}
?>