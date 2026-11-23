<h1>Entrar</h1>
<?php require __DIR__ . '/../layout/erros.php'; ?>

<form method="post" action="<?= url('/login') ?>" id="form-principal" class="formulario" novalidate>
    <label for="email">Email</label>
    <input type="email" id="email" name="email" required value="<?= e($email) ?>">

    <label for="password">Password</label>
    <input type="password" id="password" name="password" required>

    <button type="submit">Entrar</button>
</form>
<p>Ainda não tens conta? <a href="<?= url('/registo') ?>">Cria uma aqui</a>.</p>
