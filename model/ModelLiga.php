<?php
class ModelLiga extends Model
{
    public function vender($data)
    {
        $total = $this->obtenerLigasPrecio($data->selectHora);
        if (empty($data->cliente)) {
            $idCliente = $this->crearCliente($data, $_SESSION['SesionTrabajador']['gimnasioId']);
        } else {
            $idCliente = $data->cliente;
        }

        if ($idCliente > 0) {
            return $this->crearLigas($data, $idCliente, $total, $_SESSION['SesionTrabajador']['gimnasioId'], $_SESSION['SesionTrabajador']['trabajadoId'], $_SESSION['SesionTrabajador']['trabajadorId']);
        } elseif ($idCliente == -1) {
            return $idCliente;
        }

        return false;
    }

    public function horas()
    {
        return $this->obtenerHoraligaPorId();
    }

    public function minDemas()
    {
        return $this->minDeMasLiga($_SESSION['SesionTrabajador']['gimnasioId']);
    }

    public function claveCaja($clave)
    {
        $trabajador = $this->obtenerClaveCajaPorId($_SESSION['SesionTrabajador']['trabajadorId']);

        $valido = false;
        if (count($trabajador) == 1 && $trabajador[0]['claveCaja'] == $clave) {
            $valido = true;
        }

        return $valido;
    }

    public function cargarLigasCaja()
    {
        return $this->obtenerLigaTrabajado($_SESSION['SesionTrabajador']['trabajadoId']);
    }

    public function cargarLigaPorId($id)
    {
        return $this->obtenerLigaPorId($id);
    }

    

    
}
?>