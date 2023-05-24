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

    public function agregarProducto($dta)
    {
        $producto = $this->crearProducto($dta, $_SESSION['SesionAdmin']['gimnasioId']);
        if ($producto > 0) {
            return true;
        }else{
            return false;
        }
    }

}
?>