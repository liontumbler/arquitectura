<?php
require_once 'Controller.php';

class ControllerAdmin extends Controller
{
    function __construct($token)
    {
        parent::__construct($token);
    }

    public function postSalir()
    {
        return $this->model('ModelAdmin')->salir();
    }

    public function postBuscarLigas($dta)
    {
        $contadorVacios = 0;
        foreach ($dta as $value) {
            if (empty($value)) {
                $contadorVacios++;
            }
        }

        if ($contadorVacios >= count((array) $dta)) {
            return false;
        }

        return $this->model('ModelAdmin')->buscarLigas($dta);
    }

    public function postBuscarTiendas($dta)
    {
        $contadorVacios = 0;
        foreach ($dta as $value) {
            if (empty($value)) {
                $contadorVacios++;
            }
        }

        if ($contadorVacios >= count((array) $dta)) {
            return false;
        }

        return $this->model('ModelAdmin')->buscarTiendas($dta);
    }

    public function postCargarTrabajadoresOP()
    {
        return $this->model('ModelTrabajador')->cargarTrabajadoresOP();
    }

    public function postCargarNombreCliente($dta)
    {
        return $this->model('ModelCliente')->cargarNombreClientePorId($dta->id);
    }

    public function postCargarNombreTrabajador($dta)
    {
        return $this->model('ModelTrabajado')->cargarNombreTrabajadorPorId($dta->id);
    }

    public function postCargarConfiguracion()
    {
        return $this->model('ModelGimnasio')->cargarConfiguracion();
    }

    public function postAgregarTrabajador($dta)
    {
        return $this->model('ModelTrabajador')->agregarTrabajador($dta);
    }

    public function postAgregarEquipo($dta)
    {
        return $this->model('ModelEquipo')->agregarEquipo($dta);
    }

    public function postActualizarEquipo($dta)
    {
        return $this->model('ModelEquipo')->actualizarEquipo($dta);
    }

    public function postCargarTrabajadores()
    {
        return $this->model('ModelTrabajador')->cargarTrabajadores();
    }

    public function postActualizarTrabajador($dta)
    {
        return $this->model('ModelTrabajador')->actualizarTrabajador($dta);
    }

    public function postCargarEquipos()
    {
        return $this->model('ModelEquipo')->cargarEquipos();
    }

    public function postActualizarProducto($dta)
    {
        return $this->model('ModelProducto')->actualizarProducto($dta);
    }

    public function postCargarProdutos()
    {
        return $this->model('ModelProducto')->cargarProdutos();
    }

    public function postAgregarProducto($dta)
    {
        return $this->model('ModelProducto')->agregarProducto($dta);
    }

    public function postCargarHoraLigas()
    {
        return $this->model('ModelHoraLiga')->cargarHoraLigas();
    }

    public function postAgregarHoraLiga($dta)
    {
        return $this->model('ModelHoraLiga')->agregarHoraLiga($dta);
    }

    public function postActualizarHoraLiga($dta)
    {
        return $this->model('ModelHoraLiga')->actualizarHoraLiga($dta);
    }
    

    

    
}

echo redirec('ControllerAdmin');
?>