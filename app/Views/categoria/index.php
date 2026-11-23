<h1>Categorias</h1>

<div class="barra">
    <p><?= count($categorias) ?> categorias registadas</p>
    <a href="<?= url('/categorias/nova') ?>" class="btn">+ Nova categoria</a>
</div>

<table class="tabela">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Descrição</th>
            <th>Receitas</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($categorias as $cat): ?>
            <tr>
                <td><?= e($cat['nome']) ?></td>
                <td><?= e($cat['descricao'] ?? '—') ?></td>
                <td><?= (int) $cat['total_receitas'] ?></td>
                <td class="acoes">
                    <a href="<?= url('/categorias/' . $cat['id_categoria'] . '/editar') ?>">Editar</a>
                    <form method="post" action="<?= url('/categorias/' . $cat['id_categoria'] . '/apagar') ?>"
                          onsubmit="return confirm('Apagar esta categoria?');">
                        <button type="submit" class="perigo">Apagar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>