<?php
class ModelLogin extends Model
{
    public function login($usu, $clave, $caja)
    {
        //return "$usu, $clave, $caja";

        $res = $this->obtenerTrabajador($usu);
        //return $res;
        if (!$res || count($res) == 0) {
            return $res;
        } else {
            $claveDb = $res[0]['clave'];
            $idTrabajador = $res[0]['id'];
            $idGimnasio = $res[0]['idGimnasio'];
            $nombreTrabajador = $res[0]['nombresYapellidos'];
            $nickname = $res[0]['nickname'];
            $correo = $res[0]['correo'];
            $telefono = $res[0]['telefono'];
            
            $gimnasio = $this->obtenerGimnasio($idGimnasio);
            //return $gimnasio;

            $color = $gimnasio[0]['color'];
            $background = $gimnasio[0]['background'];
            $habilitado = $gimnasio[0]['habilitado'];
            $nombreGim = $gimnasio[0]['nombre'];
            $gimnasioId = $gimnasio[0]['id'];
            
            if ($habilitado) {
                if ($clave != '' && password_verify(sha1($clave), $claveDb)) {
                    //si existe en registro en caja sin cerrar tomo la sesion que no a cerrado
                    $yaInicioCaja = $this->obtenerTrabajado($idGimnasio, $idTrabajador);//`fechaInicio` > '".date('Y-m-d')." 00:00:00' AND `fechaInicio` < '".date('Y-m-d')." 23:59:59'
                    //return $yaInicioCaja;
                    $ini = false;
                    $trabajadoId = '';
                    if (!$yaInicioCaja || count($yaInicioCaja) == 0) {
                        $insert = $this->crearTrabajado($caja, $idGimnasio, $idTrabajador);
                        //return $insert;
                        if ($insert > 0) {
                            $_SESSION['caja'] = $caja;
                            $trabajadoId = $insert;
                            $ini = true;
                        }
                    } else {//sesion ya iniciada
                        $trabajadoId = $yaInicioCaja[0]['id'];
                        $_SESSION['caja'] = $yaInicioCaja[0]['iniciCaja'];
                        $ini = 600;
                    }
    
                    $_SESSION['SesionTrabajador'] = true;
                    $_SESSION['trabajadorId'] = $idTrabajador;
                    $_SESSION['nombre'] = $nombreTrabajador;
                    $_SESSION['correo'] = $correo;
                    $_SESSION['telefono'] = $telefono;
                    $_SESSION['nickName'] = $nickname;
                    $_SESSION['gimnasio'] = $nombreGim;
                    $_SESSION['gimnasioId'] = $gimnasioId;
                    $_SESSION['color'] = $color;
                    $_SESSION['background'] = $background;//'#ff8d34';
                    $_SESSION['trabajadoId'] = $trabajadoId;

                    $medio = (!empty($telefono)) ? $telefono : $correo;
                    $updateTrabajador = $this->actualizarCaja($idTrabajador, $medio);
                    //return $updateTrabajador;
                    if ($updateTrabajador == -1) {
                        $ini = $updateTrabajador;
                    }elseif ($updateTrabajador == -2) {
                        $ini = $updateTrabajador;
                    }

                    return $ini;
                }
            } else {
                return 800;
            }
        }

        return false;
    }

    public function finSesion($plata)
    {
        //TODO: falta hacer cuentas y agregar la plata en trabajado
        $this->cerrarSesion();
    }
}
?>