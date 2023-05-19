<?php
class ModelProducto extends Model
{
    public function productos()
    {
        return $this->obtenerProductoNombrePorId();
    }

    public function cargarNombreProductoPorId($id)
    {
        return $this->obtenerNombreProductoPorId($id);
    }

    public function cargarProdutos()
    {
        return $this->obtenerProductoPorId();
    }

}
?>