<?php
class ModelProducto extends Model
{
    public function productos()
    {
        return $this->obtenerProductoNombrePorId($_SESSION['SesionTrabajador']['gimnasioId']);
    }

    public function cargarNombreProductoPorId($id)
    {
        return $this->obtenerNombreProductoPorId($id);
    }

    public function cargarProdutos()
    {
        return $this->obtenerProductoPorId($_SESSION['SesionAdmin']['gimnasioId']);
    }

    public function agregarProducto($dta)
    {
        $vencimiento = $this->planProducto($_SESSION['SesionAdmin']['plan'], $_SESSION['SesionAdmin']['gimnasioId']);
        if ($vencimiento) {
            return $this->crearProducto($dta, $_SESSION['SesionAdmin']['gimnasioId']);
        } else {
            return 601;
        }
    }

    public function actualizarProducto($dta)
    {
        return $this->updateProducto($dta);
    }

}
?>