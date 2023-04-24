<?php
require_once 'Model.php';

class ModelLogin extends Model
{
    public function login($usu, $clave, $caja)
    {
        //return "$usu, $clave, $caja";
        $cn = $this->conectar();

        $res = $cn->read('trabajador', ['nickname' => $usu], 'nickname=:nickname');
        //return $res;
        if (!$res) {
            return $res;
        } else {
            $claveDb = $res['clave'];
            $idTrabajador = $res['id'];
            $idGimnasio = $res['idGimnasio'];
            $nombreTrabajador = $res['nombresYapellidos'];
            $nickname = $res['nickname'];
            
            $gimnasio = $cn->read('gimnasio', ['id' => $idGimnasio], "id=:id");
            //return $gimnasio;

            $color = $gimnasio['color'];
            $background = $gimnasio['background'];
            $habilitado = $gimnasio['habilitado'];
            $minDeMasLiga = $gimnasio['minDeMasLiga'];
            $nombreGim = $gimnasio['nombre'];

            if ($habilitado) {
                if ($clave != '' && password_verify(sha1($clave), $claveDb)) {
                    //si existe en registro en caja sin cerrar tomo la sesion que no a cerrado
                    $yaInicioCaja = $cn->read('trabajado', ['idGimnasio' => $idGimnasio, 'idTrabajador' => $idTrabajador], "
                    `idGimnasio`=:idGimnasio
                    AND `idTrabajador`=:idTrabajador
                    AND fechaFin is null;");//`fechaInicio` > '".date('Y-m-d')." 00:00:00' AND `fechaInicio` < '".date('Y-m-d')." 23:59:59'
                    //return $yaInicioCaja;
                    $ini = false;
                    $trabajadoId = '';
                    if (!$yaInicioCaja) {
                        $trabajado = [
                            'fechaInicio' => date('Y-m-d H:i:s'),
                            'iniciCaja' => $caja,
                            'idGimnasio' => $idGimnasio,
                            'idTrabajador' => $idTrabajador
                        ];
                        $insert = $cn->create('trabajado', $trabajado);
                        //return $insert;
                        if ($insert > 0) {
                            $_SESSION['caja'] = $caja;
                            $trabajadoId = $insert;
                            $ini = true;
                        }
                    } else {
                        $trabajadoId = $yaInicioCaja['id'];
                        $_SESSION['caja'] = $yaInicioCaja['iniciCaja'];
                        $ini = 600;
                        //mostrar msg que la caja ya fue iniciada y que la caja puesta no es correcta, si quiere iniciar una nueva session, terminar primero con la que no se a cerrado
                    }
    
                    $_SESSION['SesionTrabajador'] = true;
                    $_SESSION['trabajadorId'] = $idTrabajador;
                    $_SESSION['nombre'] = $nombreTrabajador;
                    $_SESSION['nickName'] = $nickname;
                    $_SESSION['gimnasio'] = $nombreGim;
                    $_SESSION['color'] = $color;
                    $_SESSION['background'] = $background;//'#ff8d34';
                    $_SESSION['trabajadoId'] = $trabajadoId;
    
                    //mirar si se pasa cuando se consultan las ligas
                    $_SESSION['minDeMasLiga'] = $minDeMasLiga;
                    
                    return $ini;
                }
            } else {
                return 800;
            }
        }

        return false;


        /**/
    }
}

//echo __NAMESPACE__;
?>