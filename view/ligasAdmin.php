<?php
@\session_start();
if (!$rutasLegitima) {
    header('Location: ../index');
} elseif (empty($_SESSION['SesionAdmin']) || !$_SESSION['SesionAdmin']) {
    header('Location: ./index');
}

//echo $_SESSION['SesionAdmin'];

require_once 'view.php';

class PaginaOnce extends Web implements PaginaX
{
    private $color;
    private $background;
    function __construct($title, $description, $keywords)
    {
        parent::__construct($title, $description, $keywords);
        $this->color = $this->model('ModelAdmin', 'obtenerColorGim', $_SESSION['SesionAdmin']['gimnasioId']);
        $this->background = $this->model('ModelAdmin', 'obtenerBackgroundGim', $_SESSION['SesionAdmin']['gimnasioId']);
    }

    public function content()
    {
?>
        <div class="d-flex">
            <?php require_once 'layout/sidebarAdmin.php'; ?>
            <div id="contentConSidebar">
                <div class="m-4">
                    <?= input_csrf_token(); ?>

                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="ligas-tab" data-bs-toggle="tab" data-bs-target="#ligas" type="button" role="tab" aria-controls="ligas" aria-selected="true">Ligas</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="ligas" role="tabpanel" aria-labelledby="ligas-tab">
                            <div class="row g-3 mt-3">
                                <div class="col-lg-2 col-sm-4">
                                    <label for="cliente">Clientes</label>
                                    <select id="cliente" class="form-select">
                                        <option selected value="">Seleccione una opción</option>
                                    </select>
                                </div>
                                <div class="col-lg-2 col-sm-4">
                                    <label for="Trabajador">Trabajador</label>
                                    <select id="Trabajador" class="form-select">
                                        <option selected value="">Seleccione una opción</option>
                                    </select>
                                </div>
                                <div class="col-lg-2 col-sm-4">
                                    <label for="tipoPago">Tipo de Pago</label>
                                    <select id="tipoPago" class="form-select">
                                        <option selected value="">Seleccione una opción</option>
                                        <option value="pazYsalvoEfectivo">debe pero pago Efectivo</option>
                                        <option value="pazYsalvoDigital">debe pero pago Digital</option>
                                        <option value="digital">digital</option>
                                        <option value="efectivo">efectivo</option>
                                        <option value="debe">debe</option>
                                    </select>
                                </div>
                                <div class="col-lg-2 col-sm-4">
                                    <label for="desde">Desde</label>
                                    <input type="datetime-local" id="desde" class="form-control">
                                </div>
                                <div class="col-lg-2 col-sm-4">
                                    <label for="hasta">Hasta</label>
                                    <input type="datetime-local" id="hasta" class="form-control">
                                </div>
                                <div class="col-lg-2 col-sm-4 d-grid gap-2">
                                    <button type="button" class="btn btn-primary mt-4" id="buscar">Buscar</button>
                                </div>
                            </div>
                            <table id="ligasTable"></table>
                        </div>
                    </div>

                    <div>
                        <canvas id="myChart">Your browser does not support the canvas element.</canvas>
                    </div>

                </div>
            </div>
        </div>
    <?php
    }

    public function nav()
    {
    ?>
        <?php require_once 'layout/navTrabajador.php'; ?>
    <?php
    }

    public function footer()
    {
    ?>
        <style>
            .navbar {
                color: <?= $this->color; ?> !important;
                background: <?= $this->background; ?> !important;
            }

            #sideBarrar {
                color: <?= $this->color; ?> !important;
                background: <?= $this->background; ?> !important;
            }
        </style>
    <?php
    }

    public function libsJS()
    {
    ?>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('myChart');

            /*const myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                    datasets: [{
                        label: '# de votos por color',
                        data: [12, 19, 3, 5, 2, 3],
                        borderWidth: 5
                    }]
                },
                options: {
                    responsive: true,
                    animation: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 2
                            }
                        }
                    },
                    plugins: {
                        customCanvasBackgroundColor: {
                            color: '#f9f9f9',
                        },
                        legend: {
                            labels: {
                                font: {
                                    size: 14
                                }
                            }
                        },
                        title: {
                            display: true,
                            text: 'Titulo de la grafica'
                        }
                    },
                    layout: {
                        padding: 30
                    }
                },
                plugins: [{
                    id: 'customCanvasBackgroundColor',
                    beforeDraw: (chart, args, options) => {
                        const {ctx} = chart;
                        ctx.save();
                        ctx.globalCompositeOperation = 'destination-over';
                        ctx.fillStyle = options.color || '#99ffff';
                        ctx.fillRect(0, 0, chart.width, chart.height);
                        ctx.restore();
                    }
                }],
            });

            Chart.defaults.backgroundColor = '#9BD0F5';//color barras
            Chart.defaults.borderColor = '#36A2EB';//color barras bordes
            Chart.defaults.color = '#000';*/

            function exportarCanvasComoImagen(canvas, nombreArchivo, escala = 1) {
                // Crear un canvas temporal escalado
                const canvasEscalado = document.createElement('canvas');
                canvasEscalado.width = canvas.width * escala;
                canvasEscalado.height = canvas.height * escala;

                // Dibujar el contenido del canvas original en el canvas escalado
                const contextoEscalado = canvasEscalado.getContext('2d');
                contextoEscalado.scale(escala, escala);
                contextoEscalado.drawImage(canvas, 0, 0);

                const imagenBase64 = canvasEscalado.toDataURL('image/png');

                //para descargar
                /*const imagen = new Image();
                imagen.src = canvasEscalado.toDataURL('image/png');

                // Crear un enlace de descarga y asignar la URL de la imagen como su href
                const link = document.createElement('a');
                link.href = imagen.src;
                link.download = nombreArchivo;

                // Agregar el enlace al documento y hacer clic en él para descargar la imagen
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);*/

                
            }
        </script>
        <script src="resources/js/adminGen.js"></script>
        <script src="resources/js/ligasAdmin.js"></script>
    <?php
    /*
    guardar imagen en servidor
    if (isset($_POST['imageData'])) {

        $img = str_replace('data:image/jpeg;base64,', '', $_POST['imageData']);
        $img = str_replace(' ', '+', $img);

        $data = base64_decode($img);
        $file = $_POST['nombre'].'.jpg';
        if (file_put_contents($file, $data)) {
            echo true;
        }else{
            if(is_file($file))
                unlink($file); //elimino el fichero
        }
    }
    */
    }
}

$index = new PaginaOnce('Ligas Administrador', '', '');
echo $index->crearHtml();

?>