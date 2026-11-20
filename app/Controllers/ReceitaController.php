<?php
class ReceitaController extends Controller
{
    private const DIFICULDADES = ['Fácil', 'Média', 'Difícil'];

    public function index(): void
    {
        $this->exigirLogin();
        $q = trim($_GET['q'] ?? '');
        $this->view('receitas/index', [
            'titulo'   => 'Receitas',
            'q'        => $q,
            'receitas' => Receita::pesquisar($q),
        ]);
    }

    public function ver($id): void
    {
        $this->exigirLogin();
        $receita = Receita::porIdComCategoria((int) $id);
        if (!$receita) {
            $this->naoEncontrado('Receita não encontrada');
            return;
        }
        $this->view('receitas/ver', ['titulo' => $receita['titulo'], 'receita' => $receita]);
    }

    public function criar(): void
    {
        $this->exigirLogin();
        $receita = ['titulo' => '', 'id_categoria' => 0, 'tempo_preparo' => '', 'dificuldade' => '',
                    'ingredientes' => '', 'modo_preparo' => '', 'imagem' => ''];
        $this->formulario('Nova receita', '/receitas/nova', $receita, []);
    }

    public function guardar(): void
    {
        $this->exigirLogin();
        $receita = $this->ler();
        $erros   = $this->validar($receita);
        $imagem  = Upload::guardarImagem($_FILES['imagem'] ?? null, $erros);

        if (!$erros) {
            $id = Receita::criar($receita, $imagem);
            mensagem('sucesso', 'Receita criada.');
            $this->redirect("/receitas/$id");
        }

        // Se houve erros, a imagem acabada de carregar não fica órfã
        Upload::apagar($imagem);
        $receita['imagem'] = '';
        $this->formulario('Nova receita', '/receitas/nova', $receita, $erros);
    }

    public function editar($id): void
    {
        $this->exigirLogin();
        $receita = $this->obter((int) $id);
        $this->formulario('Editar receita', "/receitas/$id/editar", $receita, []);
    }

    public function atualizar($id): void
    {
        $this->exigirLogin();
        $atual   = $this->obter((int) $id);
        $receita = $this->ler();
        $erros   = $this->validar($receita);
        $nova    = Upload::guardarImagem($_FILES['imagem'] ?? null, $erros);

        if (!$erros) {
            Receita::atualizar((int) $id, $receita, $nova ?: $atual['imagem']);
            if ($nova) {
                Upload::apagar($atual['imagem']);
            }
            mensagem('sucesso', 'Alterações guardadas.');
            $this->redirect("/receitas/$id");
        }

        Upload::apagar($nova);
        $receita['imagem'] = $atual['imagem'];
        $this->formulario('Editar receita', "/receitas/$id/editar", $receita, $erros);
    }

    public function apagar($id): void
    {
        $this->exigirLogin();
        $atual = Receita::porId((int) $id);

        if ($atual && Receita::apagar((int) $id)) {
            Upload::apagar($atual['imagem']);
            mensagem('sucesso', 'Receita apagada.');
        } else {
            mensagem('erro', 'A receita já não existia.');
        }
        $this->redirect('/receitas');
    }

    // ---- auxiliares ----
    private function obter(int $id): array
    {
        $receita = Receita::porId($id);
        if (!$receita) {
            mensagem('erro', 'Essa receita não existe.');
            $this->redirect('/receitas');
        }
        return $receita;
    }

    private function ler(): array
    {
        return [
            'titulo'        => trim($_POST['titulo'] ?? ''),
            'id_categoria'  => (int) ($_POST['id_categoria'] ?? 0),
            'tempo_preparo' => trim($_POST['tempo_preparo'] ?? ''),
            'dificuldade'   => trim($_POST['dificuldade'] ?? ''),
            'ingredientes'  => trim($_POST['ingredientes'] ?? ''),
            'modo_preparo'  => trim($_POST['modo_preparo'] ?? ''),
        ];
    }

    private function validar(array $r): array
    {
        $erros = [];
        if ($r['titulo'] === '' || mb_strlen($r['titulo']) > 200) {
            $erros[] = 'O título é obrigatório e não pode ter mais de 200 caracteres.';
        }
        if (!Categoria::existe($r['id_categoria'])) {
            $erros[] = 'Escolhe uma categoria válida.';
        }
        if ($r['tempo_preparo'] !== '' && (!ctype_digit($r['tempo_preparo']) || (int) $r['tempo_preparo'] > 32767)) {
            $erros[] = 'O tempo de preparo tem de ser um número de minutos.';
        }
        if ($r['dificuldade'] !== '' && !in_array($r['dificuldade'], self::DIFICULDADES, true)) {
            $erros[] = 'A dificuldade escolhida não é válida.';
        }
        if ($r['ingredientes'] === '') {
            $erros[] = 'Os ingredientes são obrigatórios.';
        }
        if ($r['modo_preparo'] === '') {
            $erros[] = 'O modo de preparo é obrigatório.';
        }
        return $erros;
    }

    private function formulario(string $titulo, string $acao, array $receita, array $erros): void
    {
        $this->view('receitas/form', [
            'titulo'        => $titulo,
            'acao'          => url($acao),
            'receita'       => $receita,
            'erros'         => $erros,
            'categorias'    => Categoria::todas(),
            'dificuldades'  => self::DIFICULDADES,
        ]);
    }
}
