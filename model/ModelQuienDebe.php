<?php
class ModelQuienDebe extends Model
{
    public function optenerDeudor($client)
    {
        $returnArray = [];
        $tienda = $this->obtenerTiendaDefault($client);
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
                    'descripcion' => 'el producto '.$this->obtenerProductoNombre($value['idProducto']).' X '.$value['cantidad']
                )
            );
        }
        //return $returnArray;

        $ligas = $this->obtenerLigaDefault($client);
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
    }

    public function pagar($dta)
    {
        $yaInicioCaja = $this->obtenerTrabajadoTrabajador($_SESSION['SesionTrabajador']['gimnasioId'], $_SESSION['SesionTrabajador']['trabajadorId']);
        if (!$yaInicioCaja || empty($yaInicioCaja)) {
            //return 'sesion terminada';
            ?>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Ya cerro caja de esta sesión',
                    showConfirmButton: false,
                    timer: 1500
                }).then((result) => {
                    location.href = './index';
                })
            </script>
            <?php
        } else {//sesion ya iniciada
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

            $resTienda = $this->crearPagos($pagos, $_SESSION['SesionTrabajador']['gimnasioId'], $_SESSION['SesionTrabajador']['trabajadoId'], $_SESSION['SesionTrabajador']['trabajadorId']);

            if ($resTienda > 0) {
                $conteoList = 0;
                //return $listapagos;
                foreach ($listapagos as $value) {
                    $value['idPagos'] = $resTienda;
                    $resListapagos = $this->crearListapagos($value);
                    //return $resListapagos;
                    if ($resListapagos == 0) {
                        $actualizo = 0;
                        if ($value['pago'] == 'Tienda') {
                            $actualizo = $this->update('tienda', ['tipoPago' => 'pazYsalvo'.ucfirst($pagos['tipoPago'])], $value['id']);
                        } elseif ($value['pago'] == 'Liga') {
                            $actualizo = $this->update('ligas', ['tipoPago' => 'pazYsalvo'.ucfirst($pagos['tipoPago'])], $value['id']);
                        }

                        if ($actualizo > 0) {
                            $conteoList++;
                        }
                    }
                }

                //return $conteoList;
                return ($conteoList >= count($listapagos)) ? true : false;
            } else {
                return false;
            }
        }
    }
}
?>