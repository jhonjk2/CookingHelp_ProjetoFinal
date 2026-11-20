<?php
class CategoriaController extends Controller
{
    public function index(): void
    {
        $this->exigirLogin();
        $this->view('categorias/index',[
            'titulo' => 'Categorias',
            'categorias' => Categoria::todasComTotal(),
        ]);
    }

    public function criar(): void
    {
        $this->exigirLogin();
        $this->formulario('Nova categoria', '/categorias/nova', ['nome' => '', 'descricao' => ''], []);
    }

    public function guardar(): void
    {
        $this->exigirLogin();
        $categoria = $this->ler();
        $erros     = $this->validar($categoria);

        if (!$erros){
            try {
                Categoria::criar($categoria['nome'], $categoria ['descricao']?: null);
                mensagem('sucesso', 'Categoria criada.');
                $this->redirect('/categorias');

            }catch (PDOException $e){
                if ($e->getCode() != 23000) {
                    throw $e;
                }

                $erros[] = 'Já existe uma categoria com esse nome.';
            }
        }
        $this->formulario('Nova categoria', '/categorias/nova', $categoria, $erros);
    }

    public function editar($id): void
    {
        $this->exigirLogin();
        $categoria = $this->obter((int) $id);
        $this->formulario('Editar categoria', '/categorias/' . $id . '/editar', $categoria, []); 
    }

    public function atualizar($id): void
    {
        $this->exigirLogin();
        $this->obter((int) $id);
        $categoria = $this->ler();
        $erros     = $this->validar($categoria);

        if (!$erros){
            try {
                Categoria::atualizar((int) $id, $categoria['nome'],
                $categoria['descricao']?: null);
                mensagem('sucesso', 'Categoria atualizada.');
                $this->redirect('/categorias');

            }catch (PDOException $e){
                if ($e->getCode() != 23000) {
                    throw $e;
                }

                $erros[] = 'Já existe uma categoria com esse nome.';
            }
        }
        $this->formulario('Editar categoria', "/categorias/$id/editar", $categoria, $erros);
    }

    public function apagar($id): void
    {
        $this->exigirLogin();
        try{
            Categoria::apagar((int) $id);
            mensagem('sucesso', 'Categoria apagada.');

        }catch (PDOException $e){
            mensagem('erro', 'Não é possivel apagar a categoria, porque tem receitas registadas.');
        }
        $this->redirect('/categorias');
    }



    //------Auxiliares------

    private function obter(int $id): array
    {

        $categoria = Categoria::porId($id);
        if(!$categoria) {
            mensagem('erro', 'Essa categoria não existe.');
            $this->redirect('/categorias');
        }
        return $categoria;

    }

    private function ler(): array
    {
        
        return [
            'nome' => trim($_POST['nome'] ?? ''),
            'descricao' => trim($_POST['descricao'] ?? ''),
        ];

    }

    private function validar(array $categoria): array
    {
        $erros = [];
        if ($categoria['nome'] === '' || mb_strlen($categoria['nome']) > 120) {
            $erros[] = 'O nome é obrigatório e não pode ter mais de 120 caracteres.';
        }
        if (mb_strlen($categoria['descricao']) > 255) {
            $erros[] = 'A descrição não pode ter mais de 255 caracteres.';
        }
        return $erros;
    }

    private function formulario(string $titulo, string $acao, array $categoria, array $erros): void
    {

        $this->view('categorias/form',[
            'titulo' => $titulo, 'acao' => url($acao), 'categoria' => $categoria, 'erros' => $erros
        ]);
    }
}