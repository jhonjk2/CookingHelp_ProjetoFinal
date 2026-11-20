<?php
class PaginaController extends Controller
{
    public function home(): void
    {

    $this->view('paginas/home', ['titulo' => 'Início']);
    }

    public function privacidade(): void
    {
        $this->view('paginas/privacidade', ['titulo' => 'Política de privacidade']);
    }
}