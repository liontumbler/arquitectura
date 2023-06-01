<?php
include_once 'Conexion.php';
include_once 'Sms.php';

class ConsultasDB extends Database
{
    public function __construct()
    {
        date_default_timezone_set("America/Bogota");
        parent::__construct(HOST, USER, PASS, DB);
    }

    public function obtenerHorasLigasPorId(string $id)
    {
        $horaliga = $this->read('horaliga', ['id' => $id], $this->ID, 'precio, horas');
        if (!empty($horaliga)) {
            return $horaliga[0];
        } else {
            return '';
        }
    }

    public function obtenerHorasLigasPorGimnasio(string $idGimnasio)
    {
        return $this->read('horaliga', ['idGimnasio' => $idGimnasio], 'idGimnasio=:idGimnasio', 'id, nombre, precio, horas, fecha');
    }

    public function obtenerProductoPrecio(string $producto)
    {
        $producto = $this->read('producto', ['id' => $producto], $this->ID, 'precio');
        if (!empty($producto)) {
            return $producto[0]['precio'];
        } else {
            return 0;
        }
    }

    public function obtenerProductoNombre(string $producto)
    {
        $producto = $this->read('producto', ['id' => $producto], $this->ID, 'nombre');
        if (!empty($producto)) {
            return $producto[0]['nombre'];
        } else {
            return 0;
        }
    }

    public function obtenerHoraligaPorId(string $id = null)
    {
        $array = empty($id) ? [] : ['id' => $id];
        $consulta = empty($id) ? '' : $this->ID;
        return $this->read('horaliga', $array, $consulta, 'id, nombre, horas, precio, fecha');
    }

    public function obtenerHoraligaNombrePorId(string $id = null)
    {
        $array = empty($id) ? [] : ['id' => $id];
        $consulta = empty($id) ? '' : $this->ID;
        return $this->read('horaliga', $array, $consulta, 'id, nombre, precio');
    }

    public function obtenerProductoPorId(string $id = null)
    {
        $array = empty($id) ? [] : ['id' => $id];
        $consulta = empty($id) ? '' : $this->ID;
        return $this->read('producto', $array, $consulta, 'id, nombre, precio, fecha, descripcion');
    }

    public function obtenerProductoNombrePorId(string $id = null)
    {
        $array = empty($id) ? [] : ['id' => $id];
        $consulta = empty($id) ? '' : $this->ID;
        return $this->read('producto', $array, $consulta, 'id, nombre, precio');
    }

    public function obtenerClaveCajaPorId(string $id = null)
    {
        $array = empty($id) ? [] : ['id' => $id];
        $consulta = empty($id) ? '' : $this->ID;
        return $this->read('trabajador', $array, $consulta, 'claveCaja');
    }

    public function obtenerPlanPorId(string $id = null)
    {
        $array = empty($id) ? [] : ['id' => $id];
        $consulta = empty($id) ? '' : $this->ID;
        return $this->read('plan', $array, $consulta);
    }

    public function obtenerGimnasioPorId(string $id = null)
    {
        $array = empty($id) ? [] : ['id' => $id];
        $consulta = empty($id) ? '' : $this->ID;
        return $this->read('gimnasio', $array, $consulta, 'color, background, habilitado, nombre, id');
    }

    public function obtenerTrabajadoPorId(string $id = null)
    {
        $array = empty($id) ? [] : ['id' => $id];
        $consulta = empty($id) ? '' : $this->ID;
        return $this->read('trabajado', $array, $consulta);
    }

    public function obtenerClientePorId(string $id = null)
    {
        $array = empty($id) ? [] : ['id' => $id];
        $consulta = empty($id) ? '' : $this->ID;
        return $this->read('cliente', $array, $consulta, 'id, nombresYapellidos, documento');
    }

    public function obtenerClienteNombrePorId(string $id = null)
    {
        $array = empty($id) ? [] : ['id' => $id];
        $consulta = empty($id) ? '' : $this->ID;
        return $this->read('cliente', $array, $consulta, 'id, nombresYapellidos');
    }

    public function obtenerNombreClientePorId(string $id)
    {
        return $this->read('cliente', ['id' => $id], $this->ID, 'nombresYapellidos')[0]['nombresYapellidos'];
    }

    public function obtenerNombreProductoPorId(string $id)
    {
        return $this->read('producto', ['id' => $id], $this->ID, 'nombre')[0]['nombre'];
    }

    public function obtenerNombreTrabajadorPorId(string $id)
    {
        return $this->read('trabajador', ['id' => $id], $this->ID, 'nombresYapellidos')[0]['nombresYapellidos'];
    }

    public function obtenerEquiposPorId(string $id = null)
    {
        $array = empty($id) ? [] : ['id' => $id];
        $consulta = empty($id) ? '' : $this->ID;
        return $this->read('equipo', $array, $consulta);
    }

    public function obtenerEquiposNombrePorId(string $id = null)
    {
        $array = empty($id) ? [] : ['id' => $id];
        $consulta = empty($id) ? '' : $this->ID;
        return $this->read('equipo', $array, $consulta, 'id, nombre');
    }

    public function minDeMasLiga(string $gimnasio)
    {
        return $this->read('gimnasio', ['id' => $gimnasio], $this->ID, 'minDeMasLiga')[0];
    }

    public function obtenerClienteId(array $arr, string $cadena)
    {
        return $this->read('cliente', $arr, $cadena, 'id');
    }

    public function obtenerTiendaDefault(string $cliente)
    {
        return $this->read(
            'tienda',
            ['idCliente' => $cliente, 'tipoPago' => 'debe'],
            '`idCliente`=:idCliente AND `tipoPago`=:tipoPago',
            'id, fecha, tipoPago, idProducto, total, cantidad'
        );
    }

    public function obtenerTiendas(object $dta)
    {
        $array = array();
        $cadena = '';
        if (!empty($dta->cliente)) {
            $array['idCliente'] = $dta->cliente;
            $cadena .= '`idCliente`=:idCliente ';
        }

        if (!empty($dta->Trabajador)) {
            $array['idTrabajador'] = $dta->Trabajador;
            if (empty($cadena)) {
                $cadena = '`idTrabajador`=:idTrabajador ';
            } else {
                $cadena .= 'AND `idTrabajador`=:idTrabajador ';
            }
        }

        if (!empty($dta->Producto)) {
            $array['idProducto'] = $dta->Producto;
            if (empty($cadena)) {
                $cadena = '`idProducto`=:idProducto ';
            } else {
                $cadena .= 'AND `idProducto`=:idProducto ';
            }
        }

        if (!empty($dta->tipoPago)) {
            $array['tipoPago'] = $dta->tipoPago;
            if (empty($cadena)) {
                $cadena = '`tipoPago`=:tipoPago ';
            } else {
                $cadena .= 'AND `tipoPago`=:tipoPago ';
            }
        }

        if (!empty($dta->desde)) {
            $array['fecha'] = $dta->desde;
            if (empty($cadena)) {
                $cadena = '`fecha`>=:fecha ';
            } else {
                $cadena .= 'AND `fecha`>=:fecha ';
            }
        }

        if (!empty($dta->hasta)) {
            $array['fechah'] = $dta->hasta;
            if (empty($cadena)) {
                $cadena = '`fecha`<=:fechah ';
            } else {
                $cadena .= 'AND `fecha`<=:fechah ';
            }
        }

        //return $array;
        //return $cadena;
        
        return $this->read(
            'tienda',
            $array,
            $cadena,
            'id, cantidad, total, tipoPago, fecha, idProducto, idCliente, idTrabajador'
        );
    }

    public function obtenerLigas(object $dta)
    {
        $array = array();
        $cadena = '';
        if (!empty($dta->cliente)) {
            $array['idCliente'] = $dta->cliente;
            $cadena .= '`idCliente`=:idCliente ';
        }

        if (!empty($dta->Trabajador)) {
            $array['idTrabajador'] = $dta->Trabajador;
            if (empty($cadena)) {
                $cadena = '`idTrabajador`=:idTrabajador ';
            } else {
                $cadena .= 'AND `idTrabajador`=:idTrabajador ';
            }
        }

        if (!empty($dta->tipoPago)) {
            $array['tipoPago'] = $dta->tipoPago;
            if (empty($cadena)) {
                $cadena = '`tipoPago`=:tipoPago ';
            } else {
                $cadena .= 'AND `tipoPago`=:tipoPago ';
            }
        }

        if (!empty($dta->desde)) {
            $array['fechaInicio'] = $dta->desde;
            if (empty($cadena)) {
                $cadena = '`fechaInicio`>=:fechaInicio ';
            } else {
                $cadena .= 'AND `fechaInicio`>=:fechaInicio ';
            }
        }

        if (!empty($dta->hasta)) {
            $array['fechaHasta'] = $dta->hasta;
            if (empty($cadena)) {
                $cadena = '`fechaInicio`<=:fechaHasta ';
            } else {
                $cadena .= 'AND `fechaInicio`<=:fechaHasta ';
            }
        }

        //return $array;
        //return $cadena;
        
        return $this->read(
            'ligas',
            $array,
            $cadena,
            'id, total, tipoPago, fechaInicio, fechaFin, idCliente, idTrabajador'
        );
    }

    public function obtenerLigaDefault(string $cliente)
    {
        return $this->read(
            'ligas',
            ['idCliente' => $cliente, 'tipoPago' => 'debe'],
            '`idCliente`=:idCliente AND `tipoPago`=:tipoPago',
            'id, fechaInicio, tipoPago, total'
        );
    }

    public function obtenerLigaTrabajado(string $trabajado)
    {
        return $this->read(
            'ligas',
            ['idTrabajado' => $trabajado],
            '`idTrabajado`=:idTrabajado ORDER BY `ligas`.`fechaInicio` DESC',
            'id, fechaInicio, total, idCliente, fechaFin, tipoPago'
        );
    }

    public function obtenerLigaTrabajadoTotal(string $trabajado)
    {
        return $this->read(
            'ligas',
            ['idTrabajado' => $trabajado],
            '`idTrabajado`=:idTrabajado',
            'SUM(total) AS Total'
        )[0]['Total'];
    }

    public function obtenerLigaTrabajadoDebeTotal(string $trabajado)
    {
        return $this->read(
            'ligas',
            ['idTrabajado' => $trabajado],
            '`idTrabajado`=:idTrabajado AND tipoPago = "debe"',
            'SUM(total) AS Total'
        )[0]['Total'];
    }

    public function obtenerLigaTrabajadoPagoETotal(string $trabajado)
    {
        return $this->read(
            'ligas',
            ['idTrabajado' => $trabajado],
            '`idTrabajado`=:idTrabajado AND tipoPago = "efectivo"',
            'SUM(total) AS Total'
        )[0]['Total'];
    }

    public function obtenerLigaTrabajadoPagoDTotal(string $trabajado)
    {
        return $this->read(
            'ligas',
            ['idTrabajado' => $trabajado],
            '`idTrabajado`=:idTrabajado AND tipoPago = "digital"',
            'SUM(total) AS Total'
        )[0]['Total'];
    }

    public function obtenerTiendaTrabajadoTotal(string $trabajado)
    {
        return $this->read(
            'tienda',
            ['idTrabajado' => $trabajado],
            '`idTrabajado`=:idTrabajado',
            'SUM(total) AS Total'
        )[0]['Total'];
    }

    public function obtenerTiendaTrabajadoDebeTotal(string $trabajado)
    {
        return $this->read(
            'tienda',
            ['idTrabajado' => $trabajado],
            '`idTrabajado`=:idTrabajado AND tipoPago = "debe"',
            'SUM(total) AS Total'
        )[0]['Total'];
    }

    public function obtenerTiendaTrabajadoPagoETotal(string $trabajado)
    {
        return $this->read(
            'tienda',
            ['idTrabajado' => $trabajado],
            '`idTrabajado`=:idTrabajado AND tipoPago = "efectivo"',
            'SUM(total) AS Total'
        )[0]['Total'];
    }

    public function obtenerTiendaTrabajadoPagoDTotal(string $trabajado)
    {
        return $this->read(
            'tienda',
            ['idTrabajado' => $trabajado],
            '`idTrabajado`=:idTrabajado AND tipoPago = "digital"',
            'SUM(total) AS Total'
        )[0]['Total'];
    }

    public function obtenerPagosTrabajadoTotal(string $trabajado)
    {
        return $this->read(
            'pagos',
            ['idTrabajado' => $trabajado],
            '`idTrabajado`=:idTrabajado',
            'SUM(total) AS Total'
        )[0]['Total'];
    }

    public function obtenerPagosTrabajadoPagoETotal(string $trabajado)
    {
        return $this->read(
            'pagos',
            ['idTrabajado' => $trabajado],
            '`idTrabajado`=:idTrabajado AND tipoPago = "efectivo"',
            'SUM(total) AS Total'
        )[0]['Total'];
    }

    public function obtenerPagosTrabajadoPagoDTotal(string $trabajado)
    {
        return $this->read(
            'pagos',
            ['idTrabajado' => $trabajado],
            '`idTrabajado`=:idTrabajado AND tipoPago = "digital"',
            'SUM(total) AS Total'
        )[0]['Total'];
    }

    public function obtenerDescuentoTrabajadoTotal(string $trabajado)
    {
        return $this->read(
            'descuento',
            ['idTrabajado' => $trabajado],
            '`idTrabajado`=:idTrabajado',
            'SUM(total) AS Total'
        )[0]['Total'];
    }

    public function obtenerDescuentoTrabajado(string $trabajado)
    {
        return $this->read(
            'descuento',
            ['idTrabajado' => $trabajado],
            '`idTrabajado`=:idTrabajado',
            'id, titulo, descripcion, total, fecha'
        );
    }

    public function obtenerCajaTrabajado(string $trabajado)
    {
        $consulta = $this->read(
            'trabajado',
            ['id' => $trabajado],
            "`id`=:id",
            'iniciCaja'
        );

        return isset($consulta[0]['iniciCaja']) ? $consulta[0]['iniciCaja'] : null;
    }

    public function obtenerColorGimnasio(string $gimnasio)
    {
        return $this->read(
            'gimnasio',
            ['id' => $gimnasio],
            "`id`=:id",
            'color'
        )[0]['color'];
    }

    public function obtenerBackgroundGimnasio(string $gimnasio)
    {
        return $this->read(
            'gimnasio',
            ['id' => $gimnasio],
            "`id`=:id",
            'background'
        )[0]['background'];
    }

    public function obtenerPagosTrabajado(string $trabajado)
    {
        return $this->read(
            'pagos',
            ['idTrabajado' => $trabajado],
            '`idTrabajado`=:idTrabajado',
            'id, tipoPago, total, descripcion, fecha, idCliente'
        );
    }

    public function obtenerLigaPorId(string $id)
    {
        return $this->read(
            'ligas',
            ['id' => $id],
            '`id`=:id',
            'id, fechaInicio, total, idCliente, fechaFin, tipoPago'
        );
    }

    public function obtenerTiendaPorId(string $id)
    {
        return $this->read(
            'tienda',
            ['id' => $id],
            '`id`=:id',
            'id, cantidad, total, tipoPago, idProducto, idCliente, fecha'
        );
    }

    public function obtenerTiendaTrabajado(string $trabajado)
    {
        return $this->read(
            'tienda',
            ['idTrabajado' => $trabajado],
            '`idTrabajado`=:idTrabajado',
            'id, cantidad, total, tipoPago, idProducto, idCliente, fecha'
        );
    }

    public function obtenerListaPagosId(string $id)
    {
        return $this->read(
            'listapagos',
            ['idPagos' => $id],
            '`idPagos`=:idPagos',
            'id, pago, idPagos'
        );
    }

    public function obtenerTrabajadorNickname(string $trabajador)
    {
        //$sms = new EnvioSMSLM(USERSMS, KEY);
        //$sms->saldo()->credits;
        //return $sms->preciosXPais();
        return $this->read(
            'trabajador',
            ['nickname' => $trabajador],
            'nickname=:nickname',
            'clave, id, idGimnasio, nombresYapellidos, nickname, correo, telefono'
        );
    }

    public function obtenerTrabajadorNombrePorId(string $id = null)
    {
        $array = empty($id) ? [] : ['id' => $id];
        $consulta = empty($id) ? '' : $this->ID;
        return $this->read('trabajador', $array, $consulta, 'id, nombresYapellidos');
    }

    public function obtenerAdminNickname(string $gimnasio)
    {
        return $this->read(
            'gimnasio',
            ['nickname' => $gimnasio],
            'nickname=:nickname',
            'clave, id, nombre, nickname, correo, telefono, habilitado'
        );
    }

    public function obtenerTrabajadoTrabajador(string $gimnasio, string $trabajador)
    {
        return $this->read(
            'trabajado',
            ['idGimnasio' => $gimnasio, 'idTrabajador' => $trabajador],
            "`idGimnasio`=:idGimnasio
            AND `idTrabajador`=:idTrabajador
            AND fechaFin is null;",
            'id, iniciCaja'
        );
    }

    public function obtenerLigaHoy(string $trabajador)///
    {
        return $this->read(
            'ligas',
            ['idTrabajador' => $trabajador, ''],
            '`idTrabajador`=:idTrabajador AND `fechaInicio` >= '.date('Y-m-d').' 00:00:00 AND `fechaInicio` <= '.date('Y-m-d').' 23:59:59',
            'id, fechaInicio, fechaFin, tipoPago, total'
        );
    }

    public function obtenerTiendaHoy(string $trabajador)///
    {
        return $this->read(
            'tienda',
            ['idTrabajador' => $trabajador, ''],
            '`idTrabajador`=:idTrabajador AND `fecha` >= '.date('Y-m-d').' 00:00:00 AND `fecha` <= '.date('Y-m-d').' 23:59:59',
            'id, cantidad, fecha, tipoPago, total, idProducto'
        );
    }

    public function crearCliente(object $data, string $gimnasio)
    {
        $cliente = [
            'nombresYapellidos' => $data->nombreYapellido,
            'correo' => !empty($data->correo) ? $data->correo : null,
            'telefono' => !empty($data->telefono) ? $data->telefono : null,
            'documento' => !empty($data->documento) ? $data->documento : null,
            'idEquipo' => !empty($data->equipo)? $data->equipo : null,
            'idGimnasio' => $gimnasio
        ];

        return $this->create('cliente', $cliente);
    }

    public function crearTienda(object $data, string $idCliente, string $total, string $gimnasio, string $trabajado, string $trabajador)
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

    public function crearPagos(array $pagos, string $gimnasio, string $trabajado, string $trabajador)
    {
        $pagos['descripcion'] = (!empty($pagos['descripcion'])) ? $pagos['descripcion'] : null;
        $pagos['idGimnasio'] = $gimnasio;
        $pagos['idTrabajado'] = $trabajado;
        $pagos['idTrabajador'] = $trabajador;
        return $this->create('pagos', $pagos);
    }

    public function crearListapagos(array $value)
    {
        return $this->create('listapagos', $value);
    }

    public function crearTrabajado(string $caja, string $gimnasio, string $trabajador)
    {
        $trabajado = [
            'iniciCaja' => $caja,
            'idGimnasio' => $gimnasio,
            'idTrabajador' => $trabajador,
        ];
        return $this->create('trabajado', $trabajado);
    }

    public function crearProducto(object $data, string $gimnasio)
    {
        $producto = [
            'nombre' => $data->nombre,
            'descripcion' => $data->descripcion,
            'precio' => $data->precio,
            'idGimnasio' => $gimnasio
        ];
        return $this->create('producto', $producto);
    }

    public function crearLigas(object $data, string $idCliente, string $total, string $gimnasio, string $trabajado, string $trabajador)
    {
        $ligas = [
            'total' => $total,
            'tipoPago' => (empty($data->tipoPago) ? 'debe': $data->tipoPago),
            'fechaInicio' => !empty($data->fechaInicio)? $data->fechaInicio : null,
            'fechaFin' => !empty($data->fechaFin)? $data->fechaFin : null,
            'idGimnasio' => $gimnasio,
            'idTrabajado' => $trabajado,
            'idTrabajador' => $trabajador,
            'idCliente' => $idCliente
        ];

        $resTienda = $this->create('ligas', $ligas);
        return ($resTienda > 0);
    }

    public function crearDescuento(object $data, string $gimnasio, string $trabajado, string $trabajador)
    {
        $descuento = [];
        $descuento['titulo'] = $data->titulo;
        $descuento['descripcion'] = (!empty($data->descripcion)) ? $data->descripcion : null;
        $descuento['total'] = $data->total;
        $descuento['idGimnasio'] = $gimnasio;
        $descuento['idTrabajado'] = $trabajado;
        $descuento['idTrabajador'] = $trabajador;

        $resDescuento = $this->create('descuento', $descuento);
        return ($resDescuento > 0);
    }

    public function crearHoraliga(object $data, string $gimnasio)
    {
        $horaliga = [];
        $horaliga['nombre'] = $data->nombre;
        $horaliga['precio'] = $data->precio;
        $horaliga['horas'] = $data->horas;
        $horaliga['fecha'] = date('Y-m-d H:i:s');
        $horaliga['idGimnasio'] = $gimnasio;

        return $this->create('horaliga', $horaliga);
    }

    public function crearPlan(object $data)
    {
        $plan = [];
        $plan['nombre'] = $data->nombre;
        $plan['descripcion'] = $data->descripcion;
        $plan['trabajadores'] = $data->trabajadores;
        $plan['numCampHora'] = $data->numCampHora;
        $plan['ligas'] = $data->ligas;
        $plan['tienda'] = $data->tienda;
        $plan['pagos'] = $data->pagos;
        $plan['productos'] = $data->productos;
        $plan['graficas'] = $data->graficas;

        return $this->create('plan', $plan);
    }

    public function crearEquipo(string $nombre, string $gimnasio)
    {
        $equipo = [];
        $equipo['nombre'] = $nombre;
        $equipo['idGimnasio'] = $gimnasio;

        return $this->create('equipo', $equipo);
    }

    public function crearGimnasio(object $data)
    {
        $gimnasio = [];
        $gimnasio['correo'] = $data->correo;
        $gimnasio['nickname'] = $data->nickname;
        $gimnasio['nombre'] = $data->nombre;
        $gimnasio['clave'] = $data->clave;
        $gimnasio['color'] = $data->color;
        $gimnasio['background'] = $data->background;
        $gimnasio['direccion'] = $data->direccion;
        $gimnasio['telefono'] = $data->telefono;
        $gimnasio['descripcion'] = $data->descripcion;
        $gimnasio['habilitado'] = $data->habilitado;
        $gimnasio['minDeMasLiga'] = $data->minDeMasLiga;
        $gimnasio['idPlan'] = $data->idPlan;

        return $this->create('gimnasio', $gimnasio);
    }

    public function crearTrabajador(object $data, string $gimnasio)
    {
        $trabajador = [];
        $trabajador['nombresYapellidos'] = $data->nombresYapellidos;
        $trabajador['nickname'] = $data->nickname;
        $trabajador['correo'] = $data->correo;
        $trabajador['telefono'] = $data->telefono;
        $trabajador['documento'] = $data->documento;
        $trabajador['clave'] = $data->clave;
        $trabajador['idGimnasio'] = $gimnasio;

        return $this->create('trabajador', $trabajador);
    }

    public function actualizarCaja(string $trabajador, string $medio)
    {
        $claveCajaNueva = rand(1000, 9999);
        $mj = 'AdminLig: El codigo para ingresar a la su caja el dia hoy '.date('Y-m-d H:i:s').' es '.$claveCajaNueva;

        if (is_numeric($medio)) {
            return 1;
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
        } else {
            //actualizar clave de caja  claveCaja, enviar codigo por correo
            return 'correo';
        }
    }

    public function actualizarFinCaja($finCaja, $trabajado)
    {
        return $this->update('trabajado', ['finCaja' => $finCaja, 'fechaFin' => date('Y-m-d H:i:s')], $trabajado);
    }
    //$arr = ['nombresYapellidos' => "%{$nombre}%", 'documento' => $documento];
    //$cadena = '`documento`=:documento AND `nombresYapellidos`LIKE :nombresYapellidos';
}
?>