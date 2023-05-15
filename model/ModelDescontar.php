<?php
class ModelDescontar extends Model
{
    public function descontar($data)
    {
        
        $yaInicioCaja = $this->obtenerTrabajadoTrabajador($_SESSION['SesionTrabajador']['gimnasioId'], $_SESSION['SesionTrabajador']['trabajadorId']);
        if (!$yaInicioCaja || empty($yaInicioCaja)) {
            //return 'sesion terminada';
            @\session_start();
            unset($_SESSION['SesionTrabajador']);
            return 'T';
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