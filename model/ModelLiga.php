<?php
class ModelLiga extends Model
{
    public function vender($data)
    {
        $total = $this->obtenerLigasPrecio($data->selectHora);//$cn->read('horaliga', ['id' => $data->selectHora], 'id=:id', 'precio');
        if (empty($data->cliente)) {
            $idCliente = $this->crearCliente($data->nombreYapellido, $data->documento, $data->equipo, $_SESSION['gimnasioId']);
        } else {
            $idCliente = $data->cliente;
        }

        if ($idCliente > 0) {
            return $this->crearLigas($data, $idCliente, $total, $_SESSION['gimnasioId'], $_SESSION['trabajadoId'], $_SESSION['trabajadorId']);
        } elseif ($idCliente == -1) {
            return $idCliente;
        }

        return false;
    }

    public function horas()
    {
        return $this->obtenerHoraliga();
    }

    public function minDemas()
    {
        return $this->minDeMasLiga($_SESSION['gimnasioId']);
    }

    public function claveCaja($clave)
    {
        $trabajador = $this->obtenerClaveCaja($_SESSION['trabajadorId']);

        $valido = false;
        if (count($trabajador) == 1 && $trabajador[0]['claveCaja'] == $clave) {
            $valido = true;
        }

        return $valido;
    }

    

    
}
?>