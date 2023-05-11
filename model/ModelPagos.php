<?php
class ModelPagos extends Model
{
    public function cargarPagosCaja()
    {
        return $this->obtenerPagosTrabajado($_SESSION['SesionTrabajador']['trabajadoId']);
    }

    public function cargarListaPagosCajaId($id)
    {
        return $this->obtenerListaPagosId($id);
    }

    
}
?>