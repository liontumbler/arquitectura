<?php
class ModelEquipo extends Model
{
    public function equipos()
    {
        return $this->obtenerEquiposNombrePorId($_SESSION['SesionAdmin']['gimnasioId']);
    }

    public function cargarEquipos()
    {
        return $this->obtenerEquiposPorId($_SESSION['SesionAdmin']['gimnasioId']);
    }

    
}
?>