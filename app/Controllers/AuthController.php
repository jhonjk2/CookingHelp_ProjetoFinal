<?php
class AuthController extends Controller
{
    public function formLogin(): void
    {
        $this->view('auth/login', ['titulo' => 'Entrar', 'erros' => [], 'email' => '']);
    }

    public function login(): void
    {
        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $utilizador = Utilizador::porEmail($email);
        if ($utilizador && password_verify($password, $utilizador['password_hash'])) {
            session_regenerate_id(true);
            $_SESSION['id_utilizador'] = $utilizador['id_utilizador'];
            $_SESSION['nome']          = $utilizador['nome'];

            mensagem('sucesso', 'Sessão iniciada. Bem-vindo, ' . $utilizador['nome'] . '!');
            $this->redirect('/receitas');
        }

        $this->view('auth/login', [
            'titulo' => 'Entrar',
            'erros'  => ['Email ou password errados.'],
            'email'  => $email,
        ]);
    }

    public function formRegisto(): void
    {
        $this->view('auth/registo', ['titulo' => 'Criar conta', 'erros' => [], 'nome' => '', 'email' => '']);
    }

    public function registo(): void
    {
        $nome     = trim($_POST['nome'] ?? '');
        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $erros    = [];

        if ($nome === '' || mb_strlen($nome) > 100) {
            $erros[] = 'O nome é obrigatório e não pode ter mais de 100 caracteres.';
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $erros[] = 'O email não é válido.';
        }
        if (strlen($password) < 8) {
            $erros[] = 'A password tem de ter pelo menos 8 caracteres.';
        }
        if (!isset($_POST['consentimento'])) {
            $erros[] = 'Tens de aceitar a política de privacidade.';
        }
        if (!$erros && Utilizador::emailExiste($email)) {
            $erros[] = 'Já existe uma conta com esse email.';
        }

        if (!$erros) {
            Utilizador::criar($nome, $email, $password);
            mensagem('sucesso', 'Conta criada. Já podes iniciar sessão.');
            $this->redirect('/login');
        }

        $this->view('auth/registo', [
            'titulo' => 'Criar conta', 'erros' => $erros, 'nome' => $nome, 'email' => $email,
        ]);
    }

    public function logout(): void
    {
        $_SESSION = [];
        session_destroy();
        session_start();
        mensagem('sucesso', 'Sessão terminada.');
        $this->redirect('/');
    }
}
