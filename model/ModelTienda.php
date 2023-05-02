<?php
class ModelTienda extends Model
{
    public function vender($data)
    {
        $producto = $this->obtenerProducto($data->producto);
        $total = $data->cantidad * $producto[0]['precio'];
        //return $producto;
        
        if (empty($data->cliente)) {
            $idCliente = $this->crearCliente($data->nombreYapellido, $data->documento, $data->equipo, $_SESSION['gimnasioId']);
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