<?php
class Router
{
    private array $rotas =[];

    public function get(string $caminho, string $handler): void { $this->add('GET', $caminho, $handler); }
    public function post(string $caminho, string $handler): void { $this->add('POST', $caminho, $handler); }

    private function add(string $metodo, string $caminho, string $handler): void

    {
        $regex = '#^' . preg_replace('#\{\w+\}#', '(\d+)', $caminho) . '$#';
        $this->rotas[] = [$metodo, $regex, $handler];
    }

    public function dispatch(string $metodo, string $uri): void
    {
        $caminho = parse_url($uri, PHP_URL_PATH) ?: '/';
        if (BASE_URL !== '' && str_starts_with($caminho, BASE_URL)) {
            $caminho = substr($caminho, strlen(BASE_URL));
        }
        if (str_starts_with($caminho, '/public')) { $caminho = substr($caminho, strlen('/public'));
        }
        $caminho = '/' . trim($caminho, '/');

        foreach ($this->rotas as [$m, $regex, $handler]) {
            if ($m === $metodo && preg_match($regex, $caminho, $partes)) {          [$classe, $accao] = explode('@', $handler); (new $classe())->$accao(... array_slice($partes, 1));
            return;
            
            }
        }

        (new Controller())->naoEncontrado('Página não encontrada');
    }
}