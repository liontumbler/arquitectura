<?php
class ModelHoraLiga extends Model
{
    public function agregarHoraLiga($dta)
    {
        //return $dta;
        $vencimiento = $this->planHoraLiga($_SESSION['SesionAdmin']['plan'], $_SESSION['SesionAdmin']['gimnasioId']);
        if ($vencimiento) {
            return $this->crearHoraliga($dta, $_SESSION['SesionAdmin']['gimnasioId']);
        } else {
            return 601;
        }
    }

    public function cargarHoraLigas()
    {
        return $this->obtenerHorasLigasPorGimnasio($_SESSION['SesionAdmin']['gimnasioId']);
    }

}
?>