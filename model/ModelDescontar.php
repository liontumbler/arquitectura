<?php
class ModelDescontar extends Model
{
    public function descontar($data)
    {
        
        $yaInicioCaja = $this->obtenerCajaTrabajado($_SESSION['SesionTrabajador']['gimnasioId']);
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
            return $this->crearDescuento($data, $_SESSION['SesionTrabajador']['gimnasioId'], $_SESSION['SesionTrabajador']['trabajadoId'], $_SESSION['SesionTrabajador']['trabajadorId']);
        }
    }

    public function cargarDescuentosPorId($trabajado)
    {
        return $this->obtenerDescuentoTrabajado($trabajado);
    }



}
?>