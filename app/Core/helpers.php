<?php
// Caminho base do projeto (funciona em /Cooking_Help_PHP/ e em virtual host)
define('BASE_URL', rtrim(preg_replace('#/public$#', '', dirname($_SERVER['SCRIPT_NAME'])), '/\\'));

function url(string $caminho = '/'): string
{
    return BASE_URL . '/' . ltrim($caminho, '/');
}

function e(?string $texto): string
{
    return htmlspecialchars((string) $texto, ENT_QUOTES, 'UTF-8');
}

// Mensagens flash (sucesso/erro) mostradas no cabeçalho
function mensagem(string $tipo, string $texto): void
{
    $_SESSION['mensagem'] = ['tipo' => $tipo, 'texto' => $texto];
}

function obter_mensagem(): ?array
{
    $m = $_SESSION['mensagem'] ?? null;
    unset($_SESSION['mensagem']);
    return $m;
}

function caminho_imagem_receita(?string $imagem): string
{
    if (!$imagem) {
        return 'data:image/svg+xml;utf8,' . rawurlencode(
            '<svg xmlns="http://www.w3.org/2000/svg" width="800" height="500"><rect width="100%" height="100%" fill="#eee"/>'
            . '<text x="50%" y="50%" fill="#999" font-family="sans-serif" font-size="32" text-anchor="middle">Sem fotografia</text></svg>'
        );
    }
    if (preg_match('#^https?://#i', $imagem)) {
        return $imagem;
    }
    return url('uploads/receitas/' . rawurlencode($imagem));
}
