<h1>Bem-Vindo ao Cooking Help</h1>
<p>Esta aplicação organiza as categorias e as receitas culinárias da nossa comunidade.</p>

<?php if (isset($_SESSION['id_utilizador'])): ?>
    <p><a href="<?= url('/receitas') ?>" class="btn">Ver as Receitas</a></p>
<?php else: ?>
    <p>Para Consultar e Gerir as Receitas, Inicia a Sessão ou Crie uma Conta.</p>
    <p>
        <a href="<?= url('/login') ?>" class="btn">Entrar</a>
        <a href="<?= url('/registo') ?>" class="btn">Criar Conta</a>
    </p>   
<?php endif; ?>