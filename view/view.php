<?php
require_once 'controller/ViewController.php';

interface PaginaX
{
    public function content();
    public function libsJS();
}

class Web
{
    public $title;
    public $description;
    public $keywords;

    function __construct($title, $description, $keywords)
    {
        csrf_token_update();
        $this->title = $title;
        $this->description = $description;
        $this->keywords = $keywords;
    }

    public function nav()
    {
        require_once 'layout/nav.php';
    }

    public function libsJS(){}
    public function footer(){}

    public function libsJSGlobal()
    {
        ?>
        <script src="resources/js/global.js"></script>
        <?php
    }

    public function libsCSS()
    {
        ?>
        <link rel="stylesheet" href="resources/css/global.css">
        <?php
    }

    public function libBootstrapTable()
    {
        ?>
        <link rel="stylesheet" href="resources/libs/bootstrap-table.min.css">
        <script src="resources/libs/jquery-3.6.4.min.js"></script>
        <script src="resources/libs/tableExport.min.js"></script>
        <script src="resources/libs/jspdf.min.js"></script>
        <script src="resources/libs/jspdf.plugin.autotable.js"></script>
        <script src="resources/libs/bootstrap-table.min.js"></script>
        <script src="resources/libs/bootstrap-table-export.min.js"></script>
        <?php
    }

    public function libBootstrap5()
    {
        ?>
        <link href="resources/libs/bootstrap.min.css" rel="stylesheet" >
        <link href="resources/libs/bootstrap-icons.css" rel="stylesheet">
        <script src="resources/libs/bootstrap.bundle.min.js"></script>
        <?php
    }

    public function libSweetAlert()
    {
        ?>
        <script src="resources/libs/sweetalert2.js"></script>
        <?php
    }

    public function libsJSHeader()
    {
        $this->libBootstrap5();
        $this->libBootstrapTable();
        $this->libSweetAlert();
    }

    public function crearHtml()
    {
        ?>
        <!DOCTYPE html>
        <html lang="es-CO">

            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <meta http-equiv="content-language" content="es-CO">
                <link rel="icon" type="image/png" href="resources/img/adminLig.ico">

                <!-- Chrome 25+, Firefox 23+ and Safari 7+ >
                <meta http-equiv="Content-Security-Policy"
                content="script-src 'self' https: 'unsafe-inline'; style-src 'self' 'unsafe-inline';
                object-src 'none'; img-src 'self' https: data:; media-src https:;
                frame-src 'none'; font-src 'self' https:; connect-src 'self';">
                <!-- Firefox 4.0+ and Internet Explorer 10+ >
                <meta http-equiv="X-Content-Security-Policy"
                content="script-src 'self' https: 'unsafe-inline'; style-src 'self' 'unsafe-inline';
                object-src 'none'; img-src 'self' https: data:; media-src https:;
                frame-src 'none'; font-src 'self' https:; connect-src 'self';">
                <!-- Chrome 14+ and Safari 6+ >
                <meta http-equiv="X-WebKit-CSP"
                content="script-src 'self' https: 'unsafe-inline'; style-src 'self' 'unsafe-inline';
                object-src 'none'; img-src 'self' https: data:; media-src https:;
                frame-src 'none'; font-src 'self' https:; connect-src 'self';"-->

                <meta name="description" content="<?= $this->description; ?>">
                <meta name="keywords" content="<?= $this->keywords; ?>">

                <title><?= $this->title; ?></title>

                <?= $this->libsJSHeader(); ?>
                <?= $this->libsCSS(); ?>
            </head>

            <body>
                <?= $this->nav(); ?>
                <?= $this->content(); ?>
                <?= $this->footer(); ?>
                <?= $this->libsJSGlobal(); ?>
                <?= $this->libsJS(); ?>
            </body>
        </html>
        <?php
    }

    public function model($model, $metodo = null, $data = null)
    {
        $vc = new ViewController($model);
        return $vc->metodo($metodo, $data);
    }
}
?>