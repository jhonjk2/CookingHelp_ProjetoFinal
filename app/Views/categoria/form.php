<h1><?=  e($titulo) ?></h1>
<?php require __DIR__ . '/../layout/erros.php'; ?>

<form method="post" action="<?= e($acao) ?>"
id="form-principal" class="formulario" novalidade>
    <label for="nome">Nome da categoria</label>
    <input type="text" id="nome" name="nome" maxlength="120" required value="<?= e($categoria['nome']) ?>">

    <label for="descricao">Descrição (opcional)</label>
    <input type="text" id="descricao"
    name="descricao" maxlength="200" value="<?= e($categoria['descricao'] ?? '') ?>">

    <button type="submit">Guardar</button>
</form>