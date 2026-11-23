<h1>Criar Conta</h1>
<?php require __DIR__ . '/../layout/erros.php'; ?>
    

<form method="post" action="<?= url('/registo') ?>" id="form-principal" class="formulario" novalidate>
        <label for="nome">Nome</label>
        <input type="text" id="nome" name="nome" required value="<?= e($nome) ?>">

        <label for="email">Email</label>
        <input type="email" id="email" name="email" required value="<?= e($email) ?>">

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required data-minimo="8">

        <label class="check" for="consentimento">
            <input type="checkbox" id="consentimento" name="consentimento" required>
            <span>Li e aceito a <a href="<?= url('/privacidade') ?>
            target="_blank">política de privacidade</a>.</span>
        </label>
</form>