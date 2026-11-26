<?php
class Upload
{
    private const TIPOS = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];

    public static function guardarImagem(?array $ficheiro, array &$erros): ?string
    {
          if (!$ficheiro || $ficheiro['error'] === UPLOAD_ERR_NO_FILE) {
            return null;
        }
        if ($ficheiro['error'] !== UPLOAD_ERR_OK) {
            $erros[] = 'Não foi possível carregar a fotografia.';
            return null;
        }
        if ($ficheiro['size'] > UPLOAD_MAX_BYTES) {
            $erros[] = 'A fotografia não pode ter mais de 3 MB.';
            return null;
        }
        $mime = (new finfo(FILEINFO_MIME_TYPE))
        ->file($ficheiro['tmp_name']);
        if (!isset(self::TIPOS[$mime])) {
            $erros[] = 'A fotografia tem de ser JPG, PNG ou WEBP.';
            return null;
        }
        $nome = bin2hex(random_bytes(12)) . '.' .
        self::TIPOS[$mime];
        if (!move_uploaded_file($ficheiro
        ['tmp_name'], UPLOAD_DIR . $nome)) {
            $erros[] = 'Não foi possível guardar a fotografia.';
            return null;
        }
        return $nome;
}

public static function apagar(?string $nome):void

    {
        if (!$nome || preg_match('#^https?://#i', $nome)) {
        return;
        }
         $ficheiro = UPLOAD_DIR . basename($nome);
        if (is_file($ficheiro)) {
            unlink($ficheiro);
        }
    }
}