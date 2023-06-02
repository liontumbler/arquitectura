<?php
class ModelLogin extends Model
{
    public function login($usu, $clave, $caja)
    {
        //return "$usu, $clave, $caja";

        $res = $this->obtenerTrabajadorNickname($usu);
        //return $res;
        if (!$res || empty($res)) {
            return $res;
        } else {
            $claveDb = $res[0]['clave'];
            $idTrabajador = $res[0]['id'];
            $idGimnasio = $res[0]['idGimnasio'];
            $nombreTrabajador = $res[0]['nombresYapellidos'];
            $nickname = $res[0]['nickname'];
            $correo = $res[0]['correo'];
            $telefono = $res[0]['telefono'];
            
            $gimnasio = $this->obtenerGimnasioPorId($idGimnasio);
            //return $gimnasio;

            $color = $gimnasio[0]['color'];
            $background = $gimnasio[0]['background'];
            $habilitado = $gimnasio[0]['habilitado'];
            $nombreGim = $gimnasio[0]['nombre'];
            $gimnasioId = $gimnasio[0]['id'];
            $idPlan = $gimnasio[0]['idPlan'];
            
            if ($habilitado) {
                if ($clave != '' && password_verify(sha1($clave), $claveDb)) {
                    //si existe en registro en caja sin cerrar tomo la sesion que no a cerrado
                    $yaInicioCaja = $this->obtenerTrabajadoTrabajador($idGimnasio, $idTrabajador);//`fechaInicio` > '".date('Y-m-d')." 00:00:00' AND `fechaInicio` < '".date('Y-m-d')." 23:59:59'
                    //return $yaInicioCaja;
                    $ini = false;
                    $trabajadoId = '';
                    if (!$yaInicioCaja || empty($yaInicioCaja)) {
                        $insert = $this->crearTrabajado($caja, $idGimnasio, $idTrabajador);
                        //return $insert;
                        if ($insert > 0) {
                            $trabajadoId = $insert;
                            $ini = true;
                        }
                    } else {//sesion ya iniciada
                        $trabajadoId = $yaInicioCaja[0]['id'];
                        $ini = 600;
                    }

                    $_SESSION['SesionTrabajador'] = array(
                        'trabajadorId' => $idTrabajador,
                        'nombre' => $nombreTrabajador,
                        'correo' => $correo,
                        'telefono' => $telefono,
                        'nickName' => $nickname,
                        'gimnasio' => $nombreGim,
                        'gimnasioId' => $gimnasioId,
                        'plan' => $idPlan,
                        'trabajadoId' => $trabajadoId,
                    );

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

    public function loginAdmin($usu, $clave)
    {
        //return "$usu, $clave";

        $res = $this->obtenerAdminNickname($usu);
        //return $res;
        if (!$res || empty($res)) {
            return $res;
        } else {
            $claveDb = $res[0]['clave'];
            $adminId = $res[0]['id'];
            $nombre = $res[0]['nombre'];
            $nickname = $res[0]['nickname'];
            $correo = $res[0]['correo'];
            $telefono = $res[0]['telefono'];
            $habilitado = $res[0]['habilitado'];
            $idPlan = $gimnasio[0]['idPlan'];
            
            if ($habilitado) {
                if ($clave != '' && password_verify(sha1($clave), $claveDb)) {
    
                    $_SESSION['SesionAdmin'] = array(
                        'gimnasioId' => $adminId,
                        'plan' => $idPlan,
                        'nombre' => $nombre,
                        'correo' => $correo,
                        'telefono' => $telefono,
                        'nickName' => $nickname,
                    );
                    
                    return true;
                }
            } else {
                return 800;
            }
        }

        return false;
    }

    /*public function finSesion($plata)
    {
        //TODO: falta hacer cuentas y agregar la plata en trabajado
        $this->cerrarSesion();
    }*/
}
?>