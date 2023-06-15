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
                return 602;
            } else {//sesion ya iniciada
                $vencimiento = $this->planDescuento($_SESSION['SesionTrabajador']['plan'], $_SESSION['SesionTrabajador']['gimnasioId']);
                if ($vencimiento) {
                    return $this->crearDescuento($data, $_SESSION['SesionTrabajador']['gimnasioId'], $_SESSION['SesionTrabajador']['trabajadoId'], $_SESSION['SesionTrabajador']['trabajadorId']);
                } else {
                    return 601;
                }
            }
        
        
    }

    public function cargarDescuentosPorId($trabajado)
    {
        return $this->obtenerDescuentoTrabajado($trabajado);
    }



}
?>