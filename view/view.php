<?php
interface PaginaX
{
    public function crearHtml();
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
}
?>