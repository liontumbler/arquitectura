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

    public function obtenerPagosTrabaPago($trabajado)
    {
        return $this->obtenerPagosTrabajadoPago($trabajado);
    }
}
?>