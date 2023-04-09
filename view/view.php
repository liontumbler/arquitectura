<?php
interface PaginaX
{
    public function nav();
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
        $this->title = $title;
        $this->description = $description;
        $this->keywords = $keywords;
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

                <meta name="description" content="<?= $this->description; ?>">
                <meta name="keywords" content="<?= $this->keywords; ?>">

                <title><?= $this->title; ?></title>

                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">

                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
                
                <style>
                    #sideBar{
                        width: 22%;
                        z-index: 1;
                    }

                    #sideBarrar{
                        width: 280px;
                        height: 92%;
                        position: fixed;
                    }

                    #sideBarrar ul{
                        display: block;
                    }

                    #contentConSidebar{
                        width: 100%;
                        display: block;
                        margin: auto;
                    }

                    body{
                        padding-top: 56px;
                    }
                </style>
            </head>

            <body>
                <?= $this->nav(); ?>
                <?= $this->content(); ?>
                <?= $this->footer(); ?>
            </body>
        </html>
        <?php
    }
}
?>