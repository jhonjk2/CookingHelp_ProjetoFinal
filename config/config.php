<?php
// Ligação à base de dados (igual ao config/db.php original)
define('DB_HOST', 'localhost');
define('DB_PORT', 3307);
define('DB_NAME', 'cooking_help');
define('DB_USER', 'root');
define('DB_PASS', '');

// Uploads de fotografias
define('UPLOAD_DIR', dirname(__DIR__) . '/public/uploads/receitas/');
define('UPLOAD_MAX_BYTES', 3 * 1024 * 1024);