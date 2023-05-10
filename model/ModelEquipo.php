<?php
class ModelEquipo extends Model
{
    public function equipos()
    {
        return $this->obtenerEquiposPorId();
    }
}
?>