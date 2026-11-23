<?php
class Receita
{
    public static function pesquisar(string $q): array
    {
        $stmt = Database::getConnection()->prepare(
            'SELECT r.id_receita, r.titulo, r.tempo_preparo, r.dificuldade, r.imagem, c.nome AS categoria
             FROM receitas r
             JOIN categorias c ON r.id_categoria = c.id_categoria
             WHERE r.titulo LIKE ?
             ORDER BY r.titulo'
        );
        $stmt->execute(['%' . $q . '%']);
        return $stmt->fetchAll();
    }

    // Com o nome da categoria (para a página de detalhe)
    public static function porIdComCategoria(int $id): ?array
    {
        $stmt = Database::getConnection()->prepare(
            'SELECT r.*, c.nome AS categoria
             FROM receitas r
             JOIN categorias c ON r.id_categoria = c.id_categoria
             WHERE r.id_receita = ?'
        );
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public static function porId(int $id): ?array
    {
        $stmt = Database::getConnection()->prepare('SELECT * FROM receitas WHERE id_receita = ?');
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public static function criar(array $d, ?string $imagem): int
    {
        $pdo = Database::getConnection();
        $pdo->prepare(
            'INSERT INTO receitas (titulo, id_categoria, tempo_preparo, dificuldade, imagem, ingredientes, modo_preparo)
             VALUES (?, ?, ?, ?, ?, ?, ?)'
        )->execute([
            $d['titulo'], $d['id_categoria'], $d['tempo_preparo'] ?: null,
            $d['dificuldade'] ?: null, $imagem, $d['ingredientes'], $d['modo_preparo'],
        ]);
        return (int) $pdo->lastInsertId();
    }

    public static function atualizar(int $id, array $d, ?string $imagem): void
    {
        Database::getConnection()->prepare(
            'UPDATE receitas
             SET titulo = ?, id_categoria = ?, tempo_preparo = ?, dificuldade = ?, imagem = ?, ingredientes = ?, modo_preparo = ?
             WHERE id_receita = ?'
        )->execute([
            $d['titulo'], $d['id_categoria'], $d['tempo_preparo'] ?: null,
            $d['dificuldade'] ?: null, $imagem, $d['ingredientes'], $d['modo_preparo'], $id,
        ]);
    }

    public static function apagar(int $id): bool
    {
        $stmt = Database::getConnection()->prepare('DELETE FROM receitas WHERE id_receita = ?');
        $stmt->execute([$id]);
        return $stmt->rowCount() === 1;
    }
}
