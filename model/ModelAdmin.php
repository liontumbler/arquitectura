<?php
class ModelAdmin extends Model
{
    public function obtenerLigaTraba($trabajado)
    {
        return $this->obtenerLigaTrabajado($trabajado);
    }

    public function obtenerLigaTrabaDebe($trabajado)
    {
        return $this->obtenerLigaTrabajadoDebe($trabajado);
    }

    public function obtenerLigaTrabaPagoE($trabajado)
    {
        return $this->obtenerLigaTrabajadoPagoE($trabajado);
    }

    public function obtenerLigaTrabaPagoD($trabajado)
    {
        return $this->obtenerLigaTrabajadoPagoD($trabajado);
    }

    public function obtenerTiendaTraba($trabajado)
    {
        return $this->obtenerTiendaTrabajado($trabajado);
    }

    public function obtenerTiendaTrabaDebe($trabajado)
    {
        return $this->obtenerTiendaTrabajadoDebe($trabajado);
    }

    public function obtenerTiendaTrabaPagoE($trabajado)
    {
        return $this->obtenerTiendaTrabajadoPagoE($trabajado);
    }

    public function obtenerTiendaTrabaPagoD($trabajado)
    {
        return $this->obtenerTiendaTrabajadoPagoD($trabajado);
    }

    public function obtenerPagosTraba($trabajado)
    {
        return $this->obtenerPagosTrabajado($trabajado);
    }

    public function obtenerPagosTrabaPagoE($trabajado)
    {
        return $this->obtenerPagosTrabajadoPagoE($trabajado);
    }

    public function obtenerPagosTrabaPagoD($trabajado)
    {
        return $this->obtenerPagosTrabajadoPagoD($trabajado);
    }

    public function obtenerDescuentoTraba($trabajado)
    {
        return $this->obtenerDescuentoTrabajado($trabajado);
    }

    public function obtenerCajaTraba($trabajado)
    {
        return $this->obtenerCajaTrabajado($trabajado);
    }

    
}
?>