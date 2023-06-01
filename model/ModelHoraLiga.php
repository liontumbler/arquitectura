<?php
class ModelHoraLiga extends Model
{
    public function agregarHoraLiga($dta)
    {
        //return $dta;
        $horaLiga = $this->crearHoraliga($dta, $_SESSION['SesionAdmin']['gimnasioId']);
        if (!empty($horaLiga) && $horaLiga > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function cargarHoraLigas()
    {
        return $this->obtenerHorasLigasPorGimnasio($_SESSION['SesionAdmin']['gimnasioId']);
    }

}
?>