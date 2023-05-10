<?php
class ModelDescontar extends Model
{
    public function descontar($data)
    {
        return $this->crearDescuento($data, $_SESSION['SesionTrabajador']['gimnasioId'], $_SESSION['SesionTrabajador']['trabajadoId'], $_SESSION['SesionTrabajador']['trabajadorId']);
    }

}
?>