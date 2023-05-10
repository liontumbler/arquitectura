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

    public function obtenerLigaTrabaPago($trabajado)
    {
        return $this->obtenerLigaTrabajadoPago($trabajado);
    }

    public function obtenerTiendaTraba($trabajado)
    {
        return $this->obtenerTiendaTrabajado($trabajado);
    }

    public function obtenerTiendaTrabaDebe($trabajado)
    {
        return $this->obtenerTiendaTrabajadoDebe($trabajado);
    }

    public function obtenerTiendaTrabaPago($trabajado)
    {
        return $this->obtenerTiendaTrabajadoPago($trabajado);
    }

    public function obtenerPagosTrabaPago($trabajado)
    {
        return $this->obtenerPagosTrabajadoPago($trabajado);
    }
}
?>