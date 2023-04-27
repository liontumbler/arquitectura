<?php
require_once 'Model.php';

class ModelLiga extends Model
{
    public function vender($data)
    {
        $cn = $this->conectar();

        $horaliga = $cn->read('horaliga', ['id' => $data->selectHora], 'id=:id', 'precio');
        $total = $horaliga[0]['precio'];
        if (empty($data->cliente)) {

            $cliente = [
                'nombresYapellidos' => $data->nombreYapellido,
                'documento' => $data->documento,
                'idEquipo' => $data->equipo,
                'idGimnasio' => $_SESSION['gimnasioId']
            ];

            $resCliente = $cn->create('cliente', $cliente);
            //return $resCliente;
            $idCliente = $resCliente;
        } else {
            $idCliente = $data->cliente;
        }

        if ($idCliente > 0) {
            $ligas = [
                'total' => $total,
                'tipoPago' => (empty($data->tipoPago) ? 'debe': $data->tipoPago),
                'fechaInicio' => $data->fechaInicio,
                'fechaFin' => $data->fechaFin,
                'idGimnasio' => $_SESSION['gimnasioId'],
                'idTrabajado' => $_SESSION['trabajadoId'],
                'idTrabajador' => $_SESSION['trabajadorId'],
                'idCliente' => $idCliente
            ];
    
            $resTienda = $cn->create('ligas', $ligas);

            return ($resTienda > 0);
        }

        return false;
    }

    public function horas()
    {
        $cn = $this->conectar();
        return $cn->read('horaliga', [], '', 'id, nombre, horas, precio');
    }

    public function minDemas()
    {
        $cn = $this->conectar();
        return $cn->read('gimnasio', ['id' => $_SESSION['gimnasioId']], 'id=:id', 'minDeMasLiga')[0];
    }

    public function claveCaja($clave)
    {
        $cn = $this->conectar();
        $trabajador =  $cn->read('trabajador', ['id' => $_SESSION['trabajadorId']], 'id=:id', 'claveCaja');

        $valido = false;
        if (count($trabajador) == 1 && $trabajador[0]['claveCaja'] == $clave) {
            $valido = true;
        }

        return $valido;
    }

    

    
}
?>