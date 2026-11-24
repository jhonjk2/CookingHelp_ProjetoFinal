<section class="detalhe">
    <h1><?= e($receita['titulo']) ?></h1>
    <img class="detalhe-imagem" src="<?= e(caminho_imagem_receita($receita['imagem'])) ?>" alt="Fotografia de <?= e($receita['titulo']) ?>">
    <dl>
        <dt>Categoria</dt>
        <dd><?= e($receita['categoria']) ?></dd>
        <dt>Tempo de preparo</dt>
        <dd><?= $receita['tempo_preparo'] ? (int) $receita['tempo_preparo'] . ' minutos' : '—' ?></dd>
        <dt>Dificuldade</dt>
        <dd><?= e($receita['dificuldade'] ?: '—') ?></dd>
        <dt>Ingredientes</dt>
        <dd><?= nl2br(e($receita['ingredientes'])) ?></dd>
        <dt>Modo de preparo</dt>
        <dd><?= nl2br(e($receita['modo_preparo'])) ?></dd>
    </dl>

    <div class="acoes">
        <a href="<?= url('/receitas/' . $receita['id_receita'] . '/editar') ?>" class="btn">Editar</a>
        <form method="post" action="<?= url('/receitas/' . $receita['id_receita'] . '/apagar') ?>"
              onsubmit="return confirm('Apagar esta receita?');">
            <button type="submit" class="perigo">Apagar</button>
        </form>
        <a href="<?= url('/receitas') ?>" class="btn secundario">Voltar</a>
    </div>
</section>
