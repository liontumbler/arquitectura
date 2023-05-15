<?php
class ModelTrabajado extends Model
{
    public function cerrarcaja($finCaja)
    {
        $yaInicioCaja = $this->obtenerTrabajadoTrabajador($_SESSION['SesionTrabajador']['gimnasioId'], $_SESSION['SesionTrabajador']['trabajadorId']);
        if (!$yaInicioCaja || empty($yaInicioCaja)) {
            //return 'sesion terminada';
            @\session_start();
            unset($_SESSION['SesionTrabajador']);
            return 'T';
        } else { //sesion ya iniciada
            if ($this->actualizarFinCaja($finCaja, $_SESSION['SesionTrabajador']['trabajadoId'])) {
                @\session_start();
                unset($_SESSION['SesionTrabajador']);
                return true;
            }else {
                return false;
            }
        }
    }

    

    

}
?>