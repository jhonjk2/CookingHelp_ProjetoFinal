<h1>Receitas</h1>

<div class="barra">
    <form method="get" action="<?= url('/receitas') ?>" class="pesquisa">
        <input type="search" name="q" placeholder="Pesquisar por título" value="<?= e($q) ?>">
        <button type="submit">Pesquisar</button>
    </form>
    <a href="<?= url('/receitas/nova') ?>" class="btn">+ Nova receita</a>
</div>

<?php if (count($receitas) === 0): ?>
    <p class="vazio">Não foi encontrada nenhuma receita.</p>
<?php else: ?>
    <div class="cartoes">
        <?php foreach ($receitas as $receita): ?>
            <article class="cartao">
                <a class="cartao-imagem" href="<?= url('/receitas/' . $receita['id_receita']) ?>" aria-label="Ver <?= e($receita['titulo']) ?>">
                    <img src="<?= e(caminho_imagem_receita($receita['imagem'])) ?>" alt="Fotografia de <?= e($receita['titulo']) ?>" loading="lazy">
                </a>
                <div class="cartao-conteudo">
                    <h2><?= e($receita['titulo']) ?></h2>
                    <p class="meta">
                        <?= e($receita['categoria']) ?>
                        <?php if ($receita['tempo_preparo']): ?> · <?= (int) $receita['tempo_preparo'] ?> min<?php endif; ?>
                        <?php if ($receita['dificuldade']): ?> · <?= e($receita['dificuldade']) ?><?php endif; ?>
                    </p>
                    <a href="<?= url('/receitas/' . $receita['id_receita']) ?>" class="link-detalhe">Ver receita →</a>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
