<?php
class ModelTrabajador extends Model
{

    public function agregarTrabajador($data)
    {
        $vencimiento = $this->planTrabajadores($_SESSION['SesionAdmin']['plan'], $_SESSION['SesionAdmin']['gimnasioId']);
        if ($vencimiento) {
            $data->clave = password_hash(sha1($data->clave), PASSWORD_BCRYPT, [
                'cost' => 11,
            ]);
    
            return $this->crearTrabajador($data, $_SESSION['SesionAdmin']['gimnasioId']);
        } else {
            return 601;
        }
        
    }

    public function cargarTrabajadores()
    {
        return $this->obtenerTrabajadorPorId($_SESSION['SesionAdmin']['gimnasioId']);
    }

    public function cargarTrabajadoresOP()
    {
        return $this->obtenerTrabajadorNombrePorId($_SESSION['SesionTrabajador']['gimnasioId']);
    }

    public function actualizarTrabajador($dta)
    {
        $dta->clave = password_hash(sha1($dta->clave), PASSWORD_BCRYPT, [
            'cost' => 11,
        ]);
        return $this->updateTrabajador($dta);
    }

    

}
?>