<?php
class Categoria 
{
    public static function listar(): array
    {
        return Database::getConnection()
            ->query('SELECT id_categoria, nome From categorias ORDER BY nome') -> fetchAll();

    }

    public static function todasComTotal(): array
    {
        return Database::getConnection()
            ->query('SELECT c.id_categoria, c.nome, COUNT(r.id_receita) AS total
                FROM categorias c
                LEFT JOIN receitas r ON r.id_categoria = c.id_categoria
                GROUP BY c.id_categoria, c.nome
                ORDER BY c.nome') 
                -> fetchAll();
    }
    public static function porId(int $id): ?array
    {
        $stmt = Database::getConnection()
            ->prepare('SELECT nome, descricao FROM categorias WHERE id_categoria = ?');
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }
    public static function existe(int $id): bool
    {
        $stmt = Database::getConnection()->prepare('SELECT 1 FROM categorias where id_categoria = ?');
        $stmt->execute([$id]);
        return (bool) $stmt->fetch();
    }

    public static function criar(array $c): int
    {
        $stmt = Database::getConnection()->prepare('INSERT INTO categorias (nome, descricao) VALUES (?, ?)');
        $stmt->execute([$nome, $descricao]);
        return (int) Database::getConnection()->lastInsertId();
    }
     public static function atualizar(int $id, string $nome, ?string $descricao): void
    {
        Database::getConnection()
            ->prepare('UPDATE categorias SET nome = ?, descricao = ? WHERE id_categoria = ?')
            ->execute([$nome, $descricao, $id]);
    }

    // Lança PDOException se a categoria tiver receitas (ON DELETE RESTRICT)
    public static function apagar(int $id): void
    {
        Database::getConnection()->prepare('DELETE FROM categorias WHERE id_categoria = ?')->execute([$id]);
    }


}