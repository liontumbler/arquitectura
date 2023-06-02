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
        $vencimiento = $this->planProducto($_SESSION['SesionAdmin']['plan'], $_SESSION['SesionAdmin']['gimnasioId']);
        if ($vencimiento) {
            return $this->crearProducto($dta, $_SESSION['SesionAdmin']['gimnasioId']);
        } else {
            return 601;
        }
    }

}
?>