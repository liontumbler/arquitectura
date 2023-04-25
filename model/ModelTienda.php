<?php
require_once 'Model.php';

class ModelTienda extends Model
{
    public function clientes()
    {
        $cn = $this->conectar();
        return $cn->read('cliente', []);
    }

    public function productos()
    {
        $cn = $this->conectar();
        return $cn->read('producto', []);
    }

    public function equipos()
    {
        $cn = $this->conectar();
        return $cn->read('equipo', []);
    }

    public function vender($data)
    {
        $cn = $this->conectar();
        //return $_SESSION;
        
        $producto = $cn->read('producto', ['id' => $data->producto], 'id=:id', 'precio');
        $total = $data->cantidad * $producto[0]['precio'];
        //return $producto;
        
        if (empty($data->cliente)) {

            $cliente = [
                'nombresYapellidos' => $data->nombreYapellido,
                'documento' => $data->documento,
                'idEquipo' => $data->equipo,
                'idGimnasio' => $_SESSION['gimnasioId']
            ];

            $resCliente = $cn->create('cliente', $cliente);
            //return $resCliente;
            $idCliente = $resCliente;
        } else {
            $idCliente = $data->cliente;
        }

        if ($idCliente > 0) {
            $tienda = [
                'cantidad' => $data->cantidad,
                'total' => $total,
                'tipoPago' => (empty($data->tipoPago) ? 'debe': $data->tipoPago),
                'idProducto' => $data->producto,
                'idGimnasio' => $_SESSION['gimnasioId'],
                'idTrabajado' => $_SESSION['trabajadoId'],
                'idTrabajador' => $_SESSION['trabajadorId'],
                'idCliente' => $idCliente
            ];
    
            $resTienda = $cn->create('tienda', $tienda);

            return ($resTienda > 0);
        }

        return false;
    }
}
?>