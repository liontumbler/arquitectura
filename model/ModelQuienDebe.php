<?php
require_once 'Model.php';

class ModelQuienDebe extends Model
{
    public function optenerDeudor($nombre, $documento)
    {
        $arr = ['documento' => $documento];
        $cadena = '`documento`=:documento';
        if (!empty($nombre)) {
            $arr = ['nombresYapellidos' => "%{$nombre}%", 'documento' => $documento];
            $cadena = '`documento`=:documento AND `nombresYapellidos`LIKE :nombresYapellidos';
        }

        $cn = $this->conectar();
        $cliente = $cn->read('cliente', $arr, $cadena);
        return $cliente;
    }
}
?>