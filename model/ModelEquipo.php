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

    public function agregarEquipo($dta)
    {
        $vencimiento = $this->planEquipos($_SESSION['SesionAdmin']['plan'], $_SESSION['SesionAdmin']['gimnasioId']);
        if ($vencimiento) {
            return $this->crearEquipo($dta->nombre, $_SESSION['SesionAdmin']['gimnasioId']);
        } else {
            return 601;
        }
    }
}
?>