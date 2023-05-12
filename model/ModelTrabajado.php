<?php
class ModelTrabajado extends Model
{
    public function cerrarcaja($finCaja)
    {
        if ($this->actualizarFinCaja($finCaja, $_SESSION['SesionTrabajador']['trabajadoId'])) {
            @\session_start();
            unset($_SESSION['SesionTrabajador']);
            return true;
        }else {
            return false;
        }
    }

    

    

}
?>