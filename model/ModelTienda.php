<?php
class ModelTienda extends Model
{
    public function vender($data)
    {
        $yaInicioCaja = $this->obtenerTrabajadoTrabajador($_SESSION['SesionTrabajador']['gimnasioId'], $_SESSION['SesionTrabajador']['trabajadorId']);
        if (!$yaInicioCaja || empty($yaInicioCaja)) {
            //return 'sesion terminada';
            @\session_start();
            unset($_SESSION['SesionTrabajador']);
            return 602;
        } else {//sesion ya iniciada
            $producto = $this->obtenerProductoPrecio($data->producto);
            $total = $data->cantidad * $producto;
            //return $producto;
            
            if (empty($data->cliente)) {
                $idCliente = $this->$this->crearCliente($data, $_SESSION['SesionTrabajador']['gimnasioId']);
            } else {
                $idCliente = $data->cliente;
            }
            //return $resCliente;

            if ($idCliente > 0) {
                $vencimiento = $this->planTienda($_SESSION['SesionTrabajador']['plan'], $_SESSION['SesionTrabajador']['gimnasioId']);
                if ($vencimiento) {
                    return $this->crearTienda($data, $idCliente, $total, $_SESSION['SesionTrabajador']['gimnasioId'], $_SESSION['SesionTrabajador']['trabajadoId'], $_SESSION['SesionTrabajador']['trabajadorId']);
                } else {
                    return 601;
                }
            }

            return false;
        }
    }

    public function cargarTiendaCaja()
    {
        return $this->obtenerTiendaTrabajado($_SESSION['SesionTrabajador']['trabajadoId']);
    }

    public function cargarTiendaPorId($id)
    {
        return $this->obtenerTiendaPorId($id);
    }
}
?>