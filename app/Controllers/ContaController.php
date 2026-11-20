<?php
class ContaController extends Controller
{

    public function index(): void
    {
        $this->exigirLogin();
        $this->view('conta/index', [
            'titulo' => 'A minha conta',
            'utilizador' => Utilizador::dadosConta((int) $_SESSION['id_utilizador']),
        ]);
    }

    public function apagar(): void
    {
        $this->exigirLogin(); 
        Utlizador::apagar((int) $_SESSION['id_utilizador']);

        $_SESSION = [];
        session_destroy();
        session_start();
        mensagem('Sucesso', 'A tua conta e os teus dados foram apagados.');
        $this->redirect('/');
    }
}