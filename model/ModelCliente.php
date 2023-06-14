<?php
class ModelCliente extends Model
{
    public function clientes()
    {
        return $this->obtenerClienteNombrePorId($_SESSION['SesionTrabajador']['gimnasioId']);
    }

    public function cargarNombreClientePorId($id)
    {
        return $this->obtenerNombreClientePorId($id);
    }

    

}
?>