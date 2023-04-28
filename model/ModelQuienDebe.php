<?php
require_once 'Model.php';

class ModelQuienDebe extends Model
{
    public function optenerDeudor($client, $documento)
    {
        $cn = $this->conectar();
        $arr = ['documento' => $documento];
        $cadena = '`documento`=:documento';
        if (empty($client)) {
            $arr = ['documento' => $documento];
            $cadena = '`documento`=:documento';
            $cliente = $cn->read('cliente', $arr, $cadena, 'id');
        } elseif (empty($documento)){
            $cliente[0]['id'] = $client;
        } else {
            $arr = ['documento' => $documento, 'id' => $client];
            $cadena = '`documento`=:documento AND `id`=:id';
            $cliente = $cn->read('cliente', $arr, $cadena, 'id');
        }
        //$arr = ['nombresYapellidos' => "%{$nombre}%", 'documento' => $documento];
        //$cadena = '`documento`=:documento AND `nombresYapellidos`LIKE :nombresYapellidos';

        //return $cliente;

        if ($cliente > 0) {
            $cliente = $cliente[0]['id'];

            $returnArray = [];
            $tienda = $cn->read('tienda', ['idCliente' => $cliente, 'tipoPago' => 'debe'], '`idCliente`=:idCliente AND `tipoPago`=:tipoPago', 'id, fecha, tipoPago, idProducto, total, cantidad');
            //return $tienda;
            foreach ($tienda as $value) {
                array_push($returnArray, array('id' => $value['id'], 'tipoPago' => $value['tipoPago'], 'total' => $value['total'], 'fecha' => $value['fecha'], 'tipoDeuda' => 'Tienda',
                'descripcion' => 'el producto '.$value['idProducto'].' X '.$value['cantidad']));
            }
            //return $returnArray;

            $ligas = $cn->read('ligas', ['idCliente' => $cliente, 'tipoPago' => 'debe'], '`idCliente`=:idCliente AND `tipoPago`=:tipoPago', 'id, fechaInicio, tipoPago, total');
            //return $ligas;
            foreach ($ligas as $value) {
                array_push($returnArray, array('id' => $value['id'], 'tipoPago' => $value['tipoPago'], 'total' => $value['total'], 'fecha' => $value['fechaInicio'], 'tipoDeuda' => 'Liga',
                'descripcion' => '1 liga'));
            }
            return $returnArray;

        } else {
            return false;
        }
    }

    public function pagar($dta)
    {
        $cn = $this->conectar();

        //listapagos
        $listapagos = [];

        $pagos = [];
        $pagos['total'] = 0;
        $pagos['descripcion'] = '';
        foreach ($dta as $value) {
            //echo $value->tipoPago;
            if (!empty($value->tipoPago)) {
                //print_r($value);
                $pagos['total'] += $value->total;
                $pagos['descripcion'] .= $value->descripcion. "\n";

                array_push($listapagos, array(
                    'pago' => $value->tipoDeuda,
                    'id' => $value->id,
                    'idPagos' => '',
                ));
            }elseif (!empty($value->pago)) {
                $pagos['tipoPago'] = $value->pago;
                $pagos['idCliente'] = $value->idCliente;
            }
        }
    
        $pagos['idGimnasio'] = $_SESSION['gimnasioId'];
        $pagos['idTrabajado'] = $_SESSION['trabajadoId'];
        $pagos['idTrabajador'] = $_SESSION['trabajadorId'];
        //return $pagos;

        $resTienda = $cn->create('pagos', $pagos);
        //return $resTienda;

        if ($resTienda > 0) {
            //hacer inssercion de la lista

            //return $listapagos;
            foreach ($listapagos as $value) {
                $value['idPagos'] = $resTienda;
                $resListapagos = $cn->create('listapagos', $value);

                //actualizar ligas o tienda segun corresponda a 'padoDeuda' 
            }

            return true;
        } else {
            return false;
        }
    }
}
?>