<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($titulo ?? 'Cooking Help') ?> - Cooking Help</title>
    <link rel="stylesheet" href="<?= url('css/estilo.css') ?>">
</head>
<body>
<header class="topo">
    <a href="<?= url('/') ?>" class="logo">Cooking Help</a>
    <nav>
         <?php if (isset($_SESSION ['id_utilizador'])): ?>
            <a href="<?= url('/receitas') ?>">Receitas</a>
            <a href="<?= url('/categorias') ?>">Categorias</a>
            <a href="<?= url('/conta') ?>">Minha Conta</a>
            <a href="<?= url('/logout') ?>">Sair (<?= e($_SESSION['nome']?? '') ?>)</a>
        <?php else: ?>
            <a href="<?= url('/login') ?>">Entrar</a>
            <a href="<?= url('/registo') ?>">Criar Conta</a>
        <?php endif; ?>    

    </nav>
</header>
<main>
    <?php if ($msg = obter_mensagem()): ?>
        <div class="mensagem <?= e($msg['tipo']) ?>"><?= e($msg['texto']) ?>
        </div>
    <?php endif; ?>
</main>

</body>
</html>