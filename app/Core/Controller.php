<?php
class Controller
{
    protected function view(string $view, array $dados = []): void
    {
        extract($dados);
        require __DIR__ . '/../Views/layout/header.php';
    }

    protected function redirect(string $caminho): void
    {
        header('Location: ' . url($caminho));
        exit;
        
    }

    protected function exigirLogin(): void
    {
        if (!isset($_SESSION['id_utilizador']))
            {
                mensagem('erro', 'Tens de iniciar sessão para aceder a esta página.');
                $this->redirect('/login');
            }
    }

    public function naoEncontrado(string $texto):
    void
    {
        http_response_code(404);
        $this->view('paginas/404', ['titulo' => $texto, 'texto' => $texto]);
    }


}