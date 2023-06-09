<?php
if (!$rutasLegitima) {
    header('Location: ../index');
}

require_once 'view.php';

class PaginaOnce extends Web implements PaginaX
{
    function __construct($title, $description, $keywords)
    {
        parent::__construct($title, $description, $keywords);
    }

    public function content()
    {
        ?>
        <div class="d-flex">
            
            <div id="contentConSidebar">
                <div class="m-4">
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <div class="card carIndex">
                                <img src="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBw0NDQ0NDRANDQ0NDQ0ODg0NDQ8NDg0NFREXFhcRExUYHiggJBonGxcVIjEhJTUtOi46Ix82ODM4NygvLisBCgoKDg0OGRAPGysdFRo3NzcrKy03LTcrLSstMC03Ky0tKy0vKy0rKysrKy0tLSstLS0rNystKzctKysrLSsrLf/AABEIAOEA4QMBIgACEQEDEQH/xAAcAAEBAQADAQEBAAAAAAAAAAAAAQQDBgcFCAL/xABJEAABAwECBQ4KCAUFAAAAAAAAAQIDBAURBxIhMZQGExQVFzVBUVRhcXKz0TI0U3SBkaGxstIiQlJic5PB4iNkgqTjM5KiwuH/xAAaAQEBAQEBAQEAAAAAAAAAAAAAAQIDBQQG/8QAKxEBAAEDAgQEBgMAAAAAAAAAAAECAxEhQQQxUWESE0LhFCKBkbHBMkNE/9oADAMBAAIRAxEAPwD4RAD9G+wAIQAAAIARAAACAACAEAAEQIAAIAAABAIAAABAIAEAAQaACHZsAAAgAQABAIAAIAQAARAgAAgAAAEAgAAAEAgAQABABCgc4AOzYQAiABrpKZuKs0yq2Fq4qI3w5n/Yb+q8BJnA4IIJJFxY2uevE1qrd0mlbLkTw3QRrxSVETV9V5/FRXvemI26KJM0Uf0W/wBS51XnUyE1G3a1fLUmkxja1fLUmkxmEDE9UbtrV8tSaTGTa1fLUmkxmIE16jbtavlqTSYxtavlqTSYzCBieo27Wr5ak0mMbWr5ak0mMwgmvUbtrV8tSaTGNrV8tSaTGYQNUbdrV8tSaTGNrV8tSaTGYQTEjdtW9fBkpnrxMqYlX3meppJYVukY5l+ZVTIvQuZThNFLXSxJitXGYvhRPTHjcnO1f0GozkN1RTxyMWeBFRG3a7Cq3rFf9Zq8LPcYREgAABAAAIUg0EAOzQAAOSnhWSRkbc73NanNeuc5rSnR8mKzJFEmtxJ91PrdKrlP7shbpHv4Y4KiROlI1u95hM7gQAoAAiBAABAAAAIBAAAAIBAAjnoqlYZGvTKiZHNXM9i5HNXpQtoU6RSua3KxbnxrxxuS9vsUzm20MsVG/hWFzPQyVyJ7DM80YiAFUIAQAABoAB2aCAAbbKzz+aVPwGE3WVnn80qfgMJmOcoAAAQADumpnUCtoUkdVsnWtcdImt6xj3Yr1bnxk4j6u5SvLU0X952HBjvRT9ep7d5921rVp6KJZ6l+txI5rcZGPk+kuZLmoqnmXOIu+OaaZ3cZrqziHQdyleWpov7xuUry1NF/edj3QbG5S7Rar5Bug2Nyl2i1XyDzOJ6T9vYzW62uCleWpov7zFW4LqxiXwz083M9HwqvR4Se47mzV9Y7luSpu61PUtT1qy4+3Z9p01U1XU80U7UzrE9r8XpuzEm/fp/l+E8VUc3gVrWPVUT0ZVQvhVb8VXXKx/VcmRTCfo+uo4qiN0M7GyxPS5zHpei/+854nq21MOsyoRGqr6aa9YXrlVt2eNy8acfCnpPps8TFzSdJdKa8uuEAPpaAAQDbW+L0XUqO2cYTbW+L0XUqO2cZnZGIgBVAAEAQEGkgB3bCAEG6ys8/mlT8BhNtlZ5/NKn4DEZ3lAgBQIAB7Xgx3op+vU9u84cKu9bvx4PepzYMd6Kfr1PbvOHCrvW78eD3qeT/AKPr+3D1vGiAHqu4c1HVSwSNmge+KVngvYuK5Obo5lznCCSj3nUZb22VEydyIkzHLFO1uRuutRFvTmVFRfTdwHBhDs9tTZdTel7oG7JYvC10eVbuluMnpOvYG8bWa77Guw3dbFW/2Yp3HVTK1lnVznZkpKhOlVjVET1qh5NUeC9inq4TpU/PgAPVdwgAA21vi9F1J+2cYTdW+LUXUn7ZxmdkYQAUCAEAEAGkgB2bAARG2ys8/mlT8BhN1lZ5/NKn4DCSOcgQAoAAg9rwY70U/Xqe3ecOFXep348HvU5sGO9FP16nt3n2besaG0IFp51ekava/wDhuRrr25sqop5FVUU3pmdpfPM/M/PQPYdzKzPtVX5rflG5lZn2qr81vyn2/F2+7p5kPHjnoaOaplbDAx0sr/BYxL16V4k51zHsMGDmyWLe6OWXmfPIif8AFUOxWdZlNSMVtNDFC1crtbYiK7ncudV6TFXGU4+WNUm5GzBqPsJLNo2QKqOlcqyTOTM6V1193MiIiJ0HV8LNvNZC2z41vklVsk92XEhRb2tXnVyIvQnOho1X6vJKVqx09NUMe69qVFVBJBEi8bGuS9y+pOnMeT1E75Xvllc6SSRyue9y3uc5eFTFizVVV5laU0zM5lxkAPudQgBAN1b4tRdSo7ZxhN1b4tRdSo7ZxmdkYSAFAgAAAAaAAdWggAG2ys8/mlT8BhN1lZ5/NKn4DCZ3kAAUCAAe2YMN6Kfr1PbvPqaprbbZ1MtS9jpUR7GYjVRq/SXPep8vBhvPT9ep7d5wYVt6necQe88iYiq9MTymXz+p8zdVg5LN+Ywbq0HJZvzGHlgPu+Ft9HXwQ9UbhVpuGlqETmfGvcfTs7CPZcyo17pqZVW7+PGmL/uYrkROm48YBmeFtyngh+kUWKeO9Nbmhkb92SORq+xUPOtW2D5iMfVWc3FVt7paVL1RW51dFz/d9XEvXMH+qWShqo4XOVaSokayRir9GN7luSVvFluv406EPbj5aoqsVaToxOaZfma8HZcIdkto7SlaxMWOdrahjUzNx1VHNT+prsnOh1o9GmqKoiY3dYnIACgba3xai6lR2zjCbq3xai6lR2zjM7DCQAoAAiAIANJADs2EAA3WVnn80qfgMJusrPP5pU/AYTO8oEAKoACD2zBhvPT9ep7d5wYVt6nfjwe85sGG89P16nt3nDhW3qd+PB7zy/7/AK/tw9TxkAHpuwQACLf9XwuC7PfwH6YbmS/PdlPDNQWp+SvrI3K1djU8jJJn/VVWrjJEnOuS9OK/mPdDz+MqiZiOjlcl5VhmRNfoV4VhnRehHNu96nnZ3LCtXpNaettW9tNCyJfxFVXu9jmp6Dpp9NiMW4bp5BADqobq3xai6lR2zjAbq3xai6lR2ziTsMIACIAAAAA0EAOzYACDbZWefzSp+Awm6ys8/mlT8BhMxzlAAFUIAEe2YMN56br1PbvPp6q7D2ypVptc1m+Rj8fE1zwVzXXodP1C6sLNorOhp6mZ0czHTq5qQTvuR0rnJla1UzKh9/dDsblDtFqvkPKrouRcmqmJ5uMxOcuubk/87/a/5BuT/wA7/a/5Dse6HY3KHaLVfIN0OxuUO0Wq+Q35nEd/t7Ga3XW4J04a1bualRP+59Kz8GFBG5HTSVFTd9RzkijX0NTG9pvXCHY3KHaLU/IZqnCZZbE+gtRMvEyFW/GqEmriJ6manbaOkigjbFCxkUbEuayNqNanoQ+Jqx1UQ2ZAq3tfUyNXWIb8qr9t3E1PbmOj2xhRqZEVlHC2nRcmuyKksl3GjbsVF6cY6HVVMk0jpZnvlket7nvcrnOXnVTVvhpmc1rFHVJ5nyPfJI5XySOc971zue5b1VfScYB9zoEAAG6t8WoupUds4wm6t8WoupUds4zOyMJACgAQgpAANAAOzYQADdZGV8jeF9NUtTpWNe4wnNRVCxSxyplxHIqpxt4U9V5/doU6RSua3Kx1z4ncDonZWr+hndGYgBQABAIAAIAQAAECAEAgAAAEQN1fkgo28KQyO9DpnKhlpoHSyMjZ4T1RE4k41XmRMpzWpO18q4n+nG1sUfUYlyL6cq+kk8xkAIAAAAABGggB2dAAEA2007JI0gnXFRFVYZrr9aVc7XfcX2GEEmEc9XSSQqiPS5Fyten0mPTja7MpwGimrpYkVrXXsXPG9EfGv9K5Dl2bEvh00Kr9x8sSepHXEzKMRDdsun5KzSJ+8my6fkrNIn7yZ7DEQ3bLp+Ss/Pn7xsum5Kz8+fvGewwg3bLpuSs0ifvGy6bkrNIn7yZ7DCQ3bLpuSs0ifvGy6bkrNIn7xnsMJDfsum5KzSJ+8my6bkrNIn7xnsMIN2y6bkrNIn7xsum5KzSJ+8meyMBy01PJK7Ejar3cSJmTjVeBOk1bNgTwaWFF+/JNInqVxx1FoyvbiXtjj8lE1I2elEz+kZkc0sjKdjoonJJM9MWWZuVrG8Mca8N/C4+cCCIAAAACERQQoHOADs6BAAgACAQAAQAgAAIEAIBAAABCCkACABCAAAABCIAEAoIANJADs2AAgEAAEAIAACBACAQAAACIEAAAEIAAAAEIgAQAACAAANAAOzYQAAQAgAAIEAIBAAAAAKQAiAIAAAIAACBACAQAAACAAAP/2Q==" class="card-img-top" alt="direcion">
                                <div class="card-body">
                                    <h5 class="card-title">Gratis</h5>
                                    <p class="card-text">
                                        Contáctate con nosotros y adquiere nuestro servicio:
                                        <ul>
                                            <li>Administrar tu tienda de tu liga</li>
                                            <li>Administra tu Liga</li>
                                            <li>Configuración de la Liga</li>
                                            <li>Hasta 4 trabajadores</li>
                                            <li>Hasta 480 registros anual o 40 resgistros mensuales de tu liga</li>
                                            <li>Hasta 480 registros anual o 40 resgistros mensuales de tu tienda</li>
                                            <li>Hasta 480 registros anual o 40 resgistros mensuales de pagos</li>
                                            <li>Hasta 10 tarifas de hora</li>
                                            <li>Hasta 50 registros de productos</li>
                                            <li>¡Pruébalo!</li>
                                            <br>
                                        </ul>
                                        <h5>$0/Mes</h5>
                                    </p>
                                    <a href="" class="btn btn-primary">Contáctanos</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-2">
                            <div class="card carIndex">
                                <img src="data:image/jpeg;base64,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" class="card-img-top" alt="direcion">
                                <div class="card-body">
                                <h5 class="card-title">Standar</h5>
                                    <p class="card-text">
                                        Contáctate con nosotros y adquiere nuestro servicio:
                                        <ul>
                                            <li>Administra tu tienda de tu liga</li>
                                            <li>Administra tu Liga</li>
                                            <li>Configuración de la Liga</li>
                                            <li>Hasta 10 trabajadores</li>
                                            <li>Hasta 1140 registros anual o 95 resgistros mensuales de tu liga</li>
                                            <li>Hasta 1140 registros anual o 95 resgistros mensuales de tu tienda</li>
                                            <li>Hasta 1140 registros anual o 95 resgistros mensuales de pagos</li>
                                            <li>Hasta 10 tarifas de hora</li>
                                            <li>Hasta 150 registros de productos</li>
                                            <li>backup de tu info al final del dia 12:00 noche y mas</li>
                                        </ul>
                                        <h5>$120.000/Mes</h5>
                                    </p>
                                    <a href="" class="btn btn-primary">Contáctanos</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-2">
                            <div class="card carIndex">
                                <img src="data:image/jpeg;base64,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" class="card-img-top" alt="direcion">
                                <div class="card-body">
                                <h5 class="card-title">Mega</h5>
                                    <p class="card-text">
                                        Contáctate con nosotros y adquiere nuestro servicio:
                                        <ul>
                                            <li>Administrar tu tienda de tu liga</li>
                                            <li>Administra tu Liga</li>
                                            <li>Configuración de la Liga</li>
                                            <li>Hasta 20 trabajadores</li>
                                            <li>Hasta 2280 registros anual o 190 resgistros mensuales de tu liga</li>
                                            <li>Hasta 2280 registros anual o 190 resgistros mensuales de tu tienda</li>
                                            <li>Hasta 2280 registros anual o 190 resgistros mensuales de pagos</li>
                                            <li>Hasta 20 tarifas de hora</li>
                                            <li>Hasta 300 registros de productos</li>
                                            <li>backup de tu info al final del dia 12:00 noche y mas</li>
                                        </ul>
                                        <h5>$200.000/Mes</h5>
                                    </p>
                                    <a href="" class="btn btn-primary">Contáctanos</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-2">
                            <div class="card carIndex">
                                <img src="data:image/jpeg;base64,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" class="card-img-top" alt="direcion">
                                <div class="card-body">
                                <h5 class="card-title">Iper</h5>
                                    <p class="card-text">
                                        Contáctate con nosotros y adquiere nuestro servicio:
                                        <ul>
                                            <li>Administrar tu tienda de tu liga</li>
                                            <li>Administra tu Liga</li>
                                            <li>Configuración de la Liga</li>
                                            <li>Hasta 20 trabajadores</li>
                                            <li>Hasta 4560 registros anual o 380 resgistros mensuales de tu liga</li>
                                            <li>Hasta 4560 registros anual o 380 resgistros mensuales de tu tienda</li>
                                            <li>Hasta 4560 registros anual o 380 resgistros mensuales de pagos</li>
                                            <li>Hasta 20 tarifas de hora</li>
                                            <li>Hasta 300 registros de productos</li>
                                            <li>backup de tu info al final del dia 12:00 noche y mas</li>
                                        </ul>
                                        <h5>$300.000/Mes</h5>
                                    </p>
                                    <a href="" class="btn btn-primary">Contáctanos</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-2">
                            <div class="card carIndex">
                                <img src="data:image/jpeg;base64,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" class="card-img-top" alt="direcion">
                                <div class="card-body">
                                <h5 class="card-title">Master</h5>
                                    <p class="card-text">
                                        Contáctate con nosotros y adquiere nuestro servicio:
                                        <ul>
                                            <li>Administrar tu tienda de tu liga</li>
                                            <li>Administra tu Liga</li>
                                            <li>Configuración de la Liga</li>
                                            <li>Hasta 40 trabajadores</li>
                                            <li>Hasta 6840 registros anual o 570 resgistros mensuales de tu liga</li>
                                            <li>Hasta 6840 registros anual o 570 resgistros mensuales de tu tienda</li>
                                            <li>Hasta 6840 registros anual o 570 resgistros mensuales de pagos</li>
                                            <li>Hasta 40 tarifas de hora</li>
                                            <li>Hasta 400 registros de productos</li>
                                            <li>backup de tu info al final del dia 12:00 noche y mas</li>
                                        </ul>
                                        <h5>$400.000/Mes</h5>
                                    </p>
                                    <a href="" class="btn btn-primary">Contáctanos</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-2">
                            <div class="card carIndex">
                                <img src="data:image/jpeg;base64,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" class="card-img-top" alt="direcion">
                                <div class="card-body">
                                <h5 class="card-title">Personalizado</h5>
                                    <p class="card-text">
                                        Contáctate con nosotros y adquiere nuestro servicio:
                                        <ul>
                                            <li>Administrar tu tienda de tu liga</li>
                                            <li>Administra tu Liga</li>
                                            <li>Configuración de la Liga</li>
                                            <li>Personaliza trabajadores</li>
                                            <li>Personaliza cuantos registros de tu liga</li>
                                            <li>Personaliza cuantos registros de tu tienda</li>
                                            <li>Personaliza cuantos registros de pagos</li>
                                            <li>Personaliza tarifas de hora</li>
                                            <li>Personaliza registros de productos</li>
                                            <li>backup de tu info al final del dia 12:00 noche y mas</li>
                                            <br>
                                            <br>
                                        </ul>
                                        <h5>Depende de la personalizada/Mes</h5>
                                    </p>
                                    <a href="" class="btn btn-primary">Contáctanos</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    public function footer()
    {
        ?>
        <script>
            //poner solo lo que se use de puro javascript con php
            /*document.getElementById('submit').addEventListener('click', async function(e) {
                let res = await fetch('controller/ControllerTest.php', {
                    method: 'POST', // *GET, POST, PUT, DELETE, etc.
                    //mode: 'cors', // no-cors, *cors, same-origin
                    //cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
                    //credentials: 'same-origin', // include, *same-origin, omit
                    headers: {
                        'Content-Type': 'application/json'
                        //'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    //redirect: 'follow', // manual, *follow, error
                    //referrerPolicy: 'no-referrer', // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
                    body: JSON.stringify({
                        accion: 'Index',
                        csrf_token: '<?= csrf_token(); ?>'
                    }) // body data type must match "Content-Type" header
                }).then((res) => {
                    return res.json()
                }) //, csrf_token:'</?= csrf_token(); ?>'
                //accion: 'Index', csrf_token:'<//?= csrf_token(); ?>'

                console.log(res);
                .then(data => {
                        console.log(data);

                        if(data.status == 404)
                            resolve(false)
                        else
                            func(data);
                        //res.text();//json()
                    }).catch(error => {
                        //console.error('error traerInformacion', error);
                        resolve(false)
                    });
            })*/
        </script>
        <?php
    }
}

$index = new PaginaOnce('Home', 'La mejor plataforma para administrar tu liga, y lo mejor de todo es gratis', 'administracion de ligas, administrador de ligas, administrador tu liga, administrador de gimnasios de gimnasia');
echo $index->crearHtml();

?>