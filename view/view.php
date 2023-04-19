<?php
interface PaginaX
{
    public function content();
    public function footer();
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

    public function libsJS()
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

                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">

                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

                <link rel="stylesheet" href="resources/libs/bootstrap-table.min.css">
                
                <script src="resources/libs/jquery-3.6.4.min.js"></script>
                <script src="resources/libs/tableExport.min.js"></script>
                <script src="resources/libs/jspdf.min.js"></script>
                <script src="resources/libs/jspdf.plugin.autotable.js"></script>
                <script src="resources/libs/bootstrap-table.min.js"></script>
                <script src="resources/libs/bootstrap-table-export.min.js"></script>

                <script src="resources/libs/sweetalert2.js"></script>

                <?= $this->libsCSS(); ?>
            </head>

            <body>
                <?= $this->nav(); ?>
                <?= $this->content(); ?>
                <?= $this->footer(); ?>
                <?= $this->libsJS(); ?>
            </body>
        </html>
        <?php
    }
}
?>