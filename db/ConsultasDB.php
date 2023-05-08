<?php
include_once 'Conexion.php';
include_once 'Sms.php';
class ConsultasDB extends Database {
    public function __construct()
    {
        parent::__construct(HOST, USER, PASS, DB);
    }

    public function obtenerLigasPrecio($id)
    {
        $horaliga = $this->read('horaliga', ['id' => $id], 'id=:id', 'precio');
        if (count($horaliga) > 0) {
            return $horaliga[0]['precio'];
        } else {
            return '';
        }
    }

    public function obtenerProductos()
    {
        return $this->read('producto', []);
    }

    public function obtenerProductoPrecio($producto)
    {
        $producto = $this->read('producto', ['id' => $producto], 'id=:id', 'precio');
        if (count($producto) > 0) {
            return $producto[0]['precio'];
        } else {
            return 0;
        }
    }

    public function obtenerClienteId($arr, $cadena)
    {
        return $this->read('cliente', $arr, $cadena, 'id');
    }

    public function obtenerTiendaDefault($cliente)
    {
        return $this->read('tienda', ['idCliente' => $cliente, 'tipoPago' => 'debe'], '`idCliente`=:idCliente AND `tipoPago`=:tipoPago', 'id, fecha, tipoPago, idProducto, total, cantidad');
    }

    public function obtenerLigaDefault($cliente)
    {
        return $this->read('ligas', ['idCliente' => $cliente, 'tipoPago' => 'debe'], '`idCliente`=:idCliente AND `tipoPago`=:tipoPago', 'id, fechaInicio, tipoPago, total');
    }

    public function obtenerTrabajador($trabajador)
    {
        //$sms = new EnvioSMSLM(USERSMS, KEY);
        //$sms->saldo()->credits;
        //return $sms->preciosXPais();
        return $this->read('trabajador', ['nickname' => $trabajador], 'nickname=:nickname', 'clave, id, idGimnasio, nombresYapellidos, nickname, correo, telefono');
    }

    public function obtenerTrabajado($gimnasio, $trabajador)
    {
        return $this->read('trabajado', ['idGimnasio' => $gimnasio, 'idTrabajador' => $trabajador],
        "`idGimnasio`=:idGimnasio
        AND `idTrabajador`=:idTrabajador
        AND fechaFin is null;", 'id, iniciCaja');
    }

    public function obtenerGimnasio($gimnasio)
    {
        return $this->read('gimnasio', ['id' => $gimnasio], "id=:id", 'color, background, habilitado, nombre, id');
    }

    public function obtenerHoraliga()
    {
        return $this->read('horaliga', [], '', 'id, nombre, horas, precio');
    }

    public function obtenerCliente()
    {
        return $this->read('cliente', [], '', 'id, nombresYapellidos, documento');
    }

    public function obtenerEquipos()
    {
        return $this->read('equipo', []);
    }

    public function obtenerClaveCaja($trabajador)
    {
        return $this->read('trabajador', ['id' => $trabajador], 'id=:id', 'claveCaja');
    }

    public function minDeMasLiga($gimnasio)
    {
        return $this->read('gimnasio', ['id' => $gimnasio], 'id=:id', 'minDeMasLiga')[0];
    }

    public function crearCliente($nombre, $documento, $equipo, $gimnasio)
    {
        $cliente = [
            'nombresYapellidos' => $nombre,
            'documento' => !empty($documento) ? $documento : NULL,
            'idEquipo' => !empty($equipo)? $equipo : NULL,
            'idGimnasio' => $gimnasio
        ];

        return $this->create('cliente', $cliente);
    }

    public function crearTienda($data, $idCliente, $total, $gimnasio, $trabajado, $trabajador)
    {
        $tienda = [
            'cantidad' => $data->cantidad,
            'total' => $total,
            'tipoPago' => (empty($data->tipoPago) ? 'debe': $data->tipoPago),
            'idProducto' => $data->producto,
            'idGimnasio' => $gimnasio,
            'idTrabajado' => $trabajado,
            'idTrabajador' => $trabajador,
            'idCliente' => $idCliente
        ];

        return $this->create('tienda', $tienda);
    }

    public function crearPagos($pagos)
    {
        return $this->create('pagos', $pagos);
    }

    public function crearListapagos($value)
    {
        return $this->create('listapagos', $value);
    }
    

    public function crearTrabajado($caja, $gimnasio, $trabajador)
    {
        $trabajado = [
            //'fechaInicio' => date('Y-m-d H:i:s'),
            'iniciCaja' => $caja,
            'idGimnasio' => $gimnasio,
            'idTrabajador' => $trabajador
        ];
        return $this->create('trabajado', $trabajado);
    }

    public function crearProducto($nombre, $precio, $gimnasio)
    {
        $producto = [
            //'fecha' => date('Y-m-d H:i:s'),
            'nombre' => $nombre,
            'precio' => $precio,
            'idGimnasio' => $gimnasio
        ];
        return $this->create('producto', $producto);
    }

    public function crearLigas($data, $idCliente, $total, $gimnasio, $trabajado, $trabajador)
    {
        $ligas = [
            'total' => $total,
            'tipoPago' => (empty($data->tipoPago) ? 'debe': $data->tipoPago),
            'fechaInicio' => $data->fechaInicio,
            'fechaFin' => $data->fechaFin,
            'idGimnasio' => $gimnasio,
            'idTrabajado' => $trabajado,
            'idTrabajador' => $trabajador,
            'idCliente' => $idCliente
        ];

        $resTienda = $this->create('ligas', $ligas);
        return ($resTienda > 0);
    }

    public function actualizarCaja($trabajador, $medio)
    {
        $claveCajaNueva = rand(1000, 9999);
        $mj = 'El codigo para ingresar a la su caja el dia hoy '.date('Y-m-d H:i:s').' es '.$claveCajaNueva;

        if (is_numeric($medio)) {
            $sms = new EnvioSMSLM(USERSMS, KEY);
            $smsRes = $sms->enviarSMS($mj, $medio);
            if ($smsRes->code == '0') {
                $this->update('trabajador', ['claveCaja' => $claveCajaNueva], $trabajador);
                return 1;
            }elseif ($smsRes->code == '403') {
                return -1;
            }elseif ($smsRes->code == '35') {
                return -2;
            }
        }else{
            //actualizar clave de caja  claveCaja, enviar codigo por correo
            return 'correo';
        }
    }
}
?>