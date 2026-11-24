<h1><?= e($titulo) ?></h1>
<?php require __DIR__ . '/../layout/erros.php'; ?>

<form method="post" action="<?= e($acao) ?>" id="form-principal" class="formulario"
      enctype="multipart/form-data" novalidate>
    <label for="titulo">Título</label>
    <input type="text" id="titulo" name="titulo" maxlength="200" required
           value="<?= e($receita['titulo']) ?>">

    <label for="id_categoria">Categoria</label>
    <select id="id_categoria" name="id_categoria" required>
        <option value="">— escolhe —</option>
        <?php foreach ($categorias as $c): ?>
            <option value="<?= (int) $c['id_categoria'] ?>"
                <?= (int) $receita['id_categoria'] === (int) $c['id_categoria'] ? 'selected' : '' ?>>
                <?= e($c['nome']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="tempo_preparo">Tempo de preparo (minutos, opcional)</label>
    <input type="number" id="tempo_preparo" name="tempo_preparo" min="1" max="32767"
           value="<?= e((string) $receita['tempo_preparo']) ?>">

    <label for="dificuldade">Dificuldade (opcional)</label>
    <select id="dificuldade" name="dificuldade">
        <option value="">—</option>
        <?php foreach ($dificuldades as $d): ?>
            <option value="<?= e($d) ?>" <?= $receita['dificuldade'] === $d ? 'selected' : '' ?>><?= e($d) ?></option>
        <?php endforeach; ?>
    </select>

    <label for="imagem">Fotografia (JPG, PNG ou WEBP, até 3 MB)</label>
    <?php if (!empty($receita['imagem'])): ?>
        <img class="detalhe-imagem" style="max-width:240px"
             src="<?= e(caminho_imagem_receita($receita['imagem'])) ?>" alt="Fotografia atual">
        <small>Carrega uma nova imagem apenas se quiseres substituir a atual.</small>
    <?php endif; ?>
    <input type="file" id="imagem" name="imagem" accept="image/jpeg,image/png,image/webp">

    <label for="ingredientes">Ingredientes (um por linha)</label>
    <textarea id="ingredientes" name="ingredientes" rows="6" required><?= e($receita['ingredientes']) ?></textarea>

    <label for="modo_preparo">Modo de preparo</label>
    <textarea id="modo_preparo" name="modo_preparo" rows="8" required><?= e($receita['modo_preparo']) ?></textarea>

    <button type="submit">Guardar</button>
</form>
