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
        return $this->obtenerHoraligaPorId($_SESSION['SesionAdmin']['gimnasioId']);
    }

    public function actualizarHoraLiga($dta)
    {
        return $this->updateHoraLiga($dta);
    }

}
?>