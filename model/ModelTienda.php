<?php
class ModelTienda extends Model
{
    public function vender($data)
    {
        $yaInicioCaja = $this->obtenerTrabajadoTrabajador($_SESSION['SesionTrabajador']['gimnasioId'], $_SESSION['SesionTrabajador']['trabajadorId']);
        if (!$yaInicioCaja || empty($yaInicioCaja)) {
            //return 'sesion terminada';
            ?>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Ya cerro caja de esta sesión',
                    showConfirmButton: false,
                    timer: 1500
                }).then((result) => {
                    location.href = './index';
                })
            </script>
            <?php
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
                $resTienda = $this->crearTienda($data, $idCliente, $total, $_SESSION['SesionTrabajador']['gimnasioId'], $_SESSION['SesionTrabajador']['trabajadoId'], $_SESSION['SesionTrabajador']['trabajadorId']);

                return ($resTienda > 0);
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