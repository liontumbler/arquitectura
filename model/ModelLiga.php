<?php
class ModelLiga extends Model
{
    public function vender($data)
    {
        $yaInicioCaja = $this->obtenerTrabajadoTrabajador($_SESSION['SesionTrabajador']['gimnasioId'], $_SESSION['SesionTrabajador']['trabajadorId']);
        if (!$yaInicioCaja || empty($yaInicioCaja)) {
            //return 'sesion terminada';
            @\session_start();
            unset($_SESSION['SesionTrabajador']);
            return 602;
        } else {//sesion ya iniciada
            $vencimiento = $this->planLiga($_SESSION['SesionAdmin']['plan'], $_SESSION['SesionAdmin']['gimnasioId']);
            if ($vencimiento) {
                $hl = $this->obtenerHorasLigasPorId($data->selectHora);
                if (empty($data->cliente)) {
                    //verificar primero si existe para crearlo
                    $idCliente = $this->crearCliente($data, $_SESSION['SesionTrabajador']['gimnasioId']);
                } else {
                    $idCliente = $data->cliente;
                }

                $horas = $hl['horas'];
                $minutos = $this->minDemas()['minDeMasLiga'];
                if (strpos($horas, '.') !== false) {
                    $partes = explode('.', $horas);
                    $horas = $partes[0];
                    $minutos += $partes[1] * 60 / pow(10, strlen($partes[1]));
                }

                if (empty($data->fechaInicio)) {
                    $fechaInicio = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' +' . $minutos . ' minutes'));
                    $fechaFin = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' +' . $horas . ' hours +' . $minutos . ' minutes'));
                    $data->fechaInicio = $fechaInicio;
                    $data->fechaFin = $fechaFin;
                } else {
                    $fechaFin = date('Y-m-d H:i:s', strtotime($data->fechaInicio . ' +' . $horas . ' hours'));
                    $data->fechaFin = $fechaFin;
                }

                if ($idCliente > 0) {
                    return $this->crearLigas($data, $idCliente, $hl['precio'], $_SESSION['SesionTrabajador']['gimnasioId'], $_SESSION['SesionTrabajador']['trabajadoId'], $_SESSION['SesionTrabajador']['trabajadorId']);
                } elseif ($idCliente == -1) {
                    return $idCliente;
                }

                return false;
            } else {
                return 601;
            }
            
        }
    }

    public function horas()
    {
        return $this->obtenerHoraligaNombrePorId($_SESSION['SesionTrabajador']['gimnasioId']);
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