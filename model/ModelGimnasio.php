<?php
class ModelGimnasio extends Model
{
    public function cargarConfiguracion()
    {
        return $this->obtenerGimnasioPorId($_SESSION['SesionAdmin']['gimnasioId']);
    }
}
?>