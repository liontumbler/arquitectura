<?php
class ModelQuienDebe extends Model
{
    public function optenerDeudor($client, $documento)
    {
        if (empty($client)) {
            $arr = ['documento' => $documento];
            $cadena = '`documento`=:documento';
            $cliente = $this->obtenerClienteId($arr, $cadena);
        } elseif (empty($documento)){
            $cliente[0]['id'] = $client;
        } else {
            $arr = ['documento' => $documento, 'id' => $client];
            $cadena = '`documento`=:documento AND `id`=:id';
            $cliente = $this->obtenerClienteId($arr, $cadena);
        }
        //$arr = ['nombresYapellidos' => "%{$nombre}%", 'documento' => $documento];
        //$cadena = '`documento`=:documento AND `nombresYapellidos`LIKE :nombresYapellidos';

        //return $cliente;

        if ($cliente > 0) {
            $cliente = $cliente[0]['id'];

            $returnArray = [];
            $tienda = $this->obtenerTiendaDefault($cliente);
            //return $tienda;
            foreach ($tienda as $value) {
                array_push(
                    $returnArray,
                    array(
                        'id' => $value['id'],
                        'tipoPago' => $value['tipoPago'],
                        'total' => $value['total'],
                        'fecha' => $value['fecha'],
                        'tipoDeuda' => 'Tienda',
                        'descripcion' => 'el producto '.$value['idProducto'].' X '.$value['cantidad']
                    )
                );
            }
            //return $returnArray;

            $ligas = $this->obtenerLigaDefault($cliente);
            //return $ligas;
            foreach ($ligas as $value) {
                array_push(
                    $returnArray,
                    array(
                        'id' => $value['id'],
                        'tipoPago' => $value['tipoPago'],
                        'total' => $value['total'],
                        'fecha' => $value['fechaInicio'],
                        'tipoDeuda' => 'Liga',
                        'descripcion' => '1 liga'
                    )
                );
            }
            return $returnArray;

        } else {
            return false;
        }
    }

    public function pagar($dta)
    {
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
        //return $pagos;

        $resTienda = $this->crearPagos($pagos, $_SESSION['gimnasioId'], $_SESSION['trabajadoId'], $_SESSION['trabajadorId']);
        //return $resTienda;

        if ($resTienda > 0) {
            $conteoList = 0;
            //return $listapagos;
            foreach ($listapagos as $value) {
                $value['idPagos'] = $resTienda;
                $resListapagos = $this->crearListapagos($value);
                if ($resListapagos > 0) {
                    //actualizar ligas o tienda segun corresponda a 'padoDeuda'
                    $conteoList++;
                }
            }

            return ($conteoList >= count($listapagos)) ? true : false;
        } else {
            return false;
        }
    }
}
?>