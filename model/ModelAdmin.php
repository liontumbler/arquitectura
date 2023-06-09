<?php
class ModelAdmin extends Model
{
    public function obtenerLigaTrabaTotal($trabajado)
    {
        return $this->obtenerLigaTrabajadoTotal($trabajado);
    }

    public function obtenerLigaTrabaDebeTotal($trabajado)
    {
        return $this->obtenerLigaTrabajadoDebeTotal($trabajado);
    }

    public function obtenerLigaTrabaPagoETotal($trabajado)
    {
        return $this->obtenerLigaTrabajadoPagoETotal($trabajado);
    }

    public function obtenerLigaTrabaPagoDTotal($trabajado)
    {
        return $this->obtenerLigaTrabajadoPagoDTotal($trabajado);
    }

    public function obtenerTiendaTrabaTotal($trabajado)
    {
        return $this->obtenerTiendaTrabajadoTotal($trabajado);
    }

    public function obtenerTiendaTrabaDebeTotal($trabajado)
    {
        return $this->obtenerTiendaTrabajadoDebeTotal($trabajado);
    }

    public function obtenerTiendaTrabaPagoETotal($trabajado)
    {
        return $this->obtenerTiendaTrabajadoPagoETotal($trabajado);
    }

    public function obtenerTiendaTrabaPagoDTotal($trabajado)
    {
        return $this->obtenerTiendaTrabajadoPagoDTotal($trabajado);
    }

    public function obtenerPagosTrabaTotal($trabajado)
    {
        return $this->obtenerPagosTrabajadoTotal($trabajado);
    }

    public function obtenerPagosTrabaPagoETotal($trabajado)
    {
        return $this->obtenerPagosTrabajadoPagoETotal($trabajado);
    }

    public function obtenerPagosTrabaPagoDTotal($trabajado)
    {
        return $this->obtenerPagosTrabajadoPagoDTotal($trabajado);
    }

    public function obtenerDescuentoTrabaTotal($trabajado)
    {
        return $this->obtenerDescuentoTrabajadoTotal($trabajado);
    }

    public function obtenerCajaTraba($trabajado)
    {
        return $this->obtenerCajaTrabajado($trabajado);
    }

    public function obtenerColorGim($gimnasio)
    {
        return $this->obtenerColorGimnasio($gimnasio);
    }

    public function obtenerBackgroundGim($gimnasio)
    {
        return $this->obtenerBackgroundGimnasio($gimnasio);
    }

    public function salir()
    {
        @\session_start();
        unset($_SESSION['SesionAdmin']);
        return true;
    }

    public function buscarLigas($dto)
    {
        return $this->obtenerLigas($dto);
    }

    public function buscarTiendas($dto)
    {
        return $this->obtenerTiendas($dto);
    }

    

    
}
?>