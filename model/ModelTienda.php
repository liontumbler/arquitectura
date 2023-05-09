<?php
class ModelTienda extends Model
{
    public function vender($data)
    {
        $producto = $this->obtenerProductoPrecio($data->producto);
        $total = $data->cantidad * $producto;
        //return $producto;
        
        if (empty($data->cliente)) {
            $idCliente = $this->$this->crearCliente($data, $_SESSION['gimnasioId']);
        } else {
            $idCliente = $data->cliente;
        }
        //return $resCliente;

        if ($idCliente > 0) {
            $resTienda = $this->crearTienda($data, $idCliente, $total, $_SESSION['gimnasioId'], $_SESSION['trabajadoId'], $_SESSION['trabajadorId']);

            return ($resTienda > 0);
        }

        return false;
    }
}
?>