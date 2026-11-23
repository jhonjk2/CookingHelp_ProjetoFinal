<?php
class Utilizador
{
    public static function porEmail(string $email): ?array
    {
        $stmt = Database::getConnection()->prepare(
            'SELECT id_utilizador, nome, password_hash FROM utilizadores WHERE email = ?'
        );
        $stmt->execute([$email]);
        return $stmt->fetch() ?: null;
    }

    public static function emailExiste(string $email): bool
    {
        $stmt = Database::getConnection()->prepare('SELECT 1 FROM utilizadores WHERE email = ?');
        $stmt->execute([$email]);
        return (bool) $stmt->fetch();
    }

    public static function criar(string $nome, string $email, string $password): void
    {
        $stmt = Database::getConnection()->prepare(
            'INSERT INTO utilizadores (nome, email, password_hash, consentimento_em) VALUES (?, ?, ?, NOW())'
        );
        $stmt->execute([$nome, $email, password_hash($password, PASSWORD_DEFAULT)]);
    }

    public static function dadosConta(int $id): ?array
    {
        $stmt = Database::getConnection()->prepare(
            'SELECT nome, email, consentimento_em, criado_em FROM utilizadores WHERE id_utilizador = ?'
        );
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public static function apagar(int $id): void
    {
        Database::getConnection()->prepare('DELETE FROM utilizadores WHERE id_utilizador = ?')->execute([$id]);
    }
}
