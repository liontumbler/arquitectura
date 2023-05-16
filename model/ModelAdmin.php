<?php
class ModelAdmin extends Model
{
    public function obtenerLigaTrabaTotal($trabajado)
    {
        $liga = $this->obtenerLigaTrabajadoTotal($trabajado);
        $totalligas = 0;
        foreach ($liga as $i => $value) {
            $totalligas = $totalligas + ($value['total']);
        }
        return $totalligas;
    }

    public function obtenerLigaTrabaDebeTotal($trabajado)
    {
        $liga = $this->obtenerLigaTrabajadoDebeTotal($trabajado);
        $totalligas = 0;
        foreach ($liga as $i => $value) {
            $totalligas = $totalligas + ($value['total']);
        }
        return $totalligas;
    }

    public function obtenerLigaTrabaPagoETotal($trabajado)
    {
        $liga = $this->obtenerLigaTrabajadoPagoETotal($trabajado);
        $totalligas = 0;
        foreach ($liga as $i => $value) {
            $totalligas = $totalligas + ($value['total']);
        }
        return $totalligas;
    }

    public function obtenerLigaTrabaPagoDTotal($trabajado)
    {
        $liga = $this->obtenerLigaTrabajadoPagoDTotal($trabajado);
        $totalligas = 0;
        foreach ($liga as $i => $value) {
            $totalligas = $totalligas + ($value['total']);
        }
        return $totalligas;
    }

    public function obtenerTiendaTrabaTotal($trabajado)
    {
        $tienda = $this->obtenerTiendaTrabajadoTotal($trabajado);
        $totaltiendas = 0;
        foreach ($tienda as $i => $value) {
            $totaltiendas = $totaltiendas + ($value['total']);
        }
        return $totaltiendas;
    }

    public function obtenerTiendaTrabaDebeTotal($trabajado)
    {
        $tienda = $this->obtenerTiendaTrabajadoDebeTotal($trabajado);
        $totaltiendas = 0;
        foreach ($tienda as $i => $value) {
            $totaltiendas = $totaltiendas + ($value['total']);
        }
        return $totaltiendas;
    }

    public function obtenerTiendaTrabaPagoETotal($trabajado)
    {
        $tienda = $this->obtenerTiendaTrabajadoPagoETotal($trabajado);
        $totaltiendas = 0;
        foreach ($tienda as $i => $value) {
            $totaltiendas = $totaltiendas + ($value['total']);
        }
        return $totaltiendas;
    }

    public function obtenerTiendaTrabaPagoDTotal($trabajado)
    {
        $tienda = $this->obtenerTiendaTrabajadoPagoDTotal($trabajado);
        $totaltiendas = 0;
        foreach ($tienda as $i => $value) {
            $totaltiendas = $totaltiendas + ($value['total']);
        }
        return $totaltiendas;
    }

    public function obtenerPagosTrabaTotal($trabajado)
    {
        $pago = $this->obtenerPagosTrabajadoTotal($trabajado);
        $totalpagos = 0;
        foreach ($pago as $i => $value) {
            $totalpagos = $totalpagos + ($value['total']);
        }
        return $totalpagos;
    }

    public function obtenerPagosTrabaPagoETotal($trabajado)
    {
        $pago = $this->obtenerPagosTrabajadoPagoETotal($trabajado);
        $totalpagos = 0;
        foreach ($pago as $i => $value) {
            $totalpagos = $totalpagos + ($value['total']);
        }
        return $totalpagos;
    }

    public function obtenerPagosTrabaPagoDTotal($trabajado)
    {
        $pago = $this->obtenerPagosTrabajadoPagoDTotal($trabajado);
        $totalpagos = 0;
        foreach ($pago as $i => $value) {
            $totalpagos = $totalpagos + ($value['total']);
        }
        return $totalpagos;
    }

    public function obtenerDescuentoTrabaTotal($trabajado)
    {
        $descuento = $this->obtenerDescuentoTrabajadoTotal($trabajado);
        $totaldescuentos = 0;
        foreach ($descuento as $i => $value) {
            $totaldescuentos = $totaldescuentos + ($value['total']);
        }
        return $totaldescuentos;
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

    public function buscarLigas($gimnasio)
    {
        return $this->obtenerLigas($gimnasio);
    }

    
}
?>