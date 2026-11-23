<section class="detalhe">
    <h1>A minha conta</h1>
    <p>Estes são todos os dados pessoais que a aplicação guarda sobre ti:</p>
    <dl>
        <dt>Nome</dt>             <dd><?= e($eu['nome']) ?></dd>
        <dt>Email</dt>            <dd><?= e($eu['email']) ?></dd>
        <dt>Conta criada em</dt>  <dd><?= e($eu['criado_em']) ?></dd>
        <dt>Consentimento</dt>    <dd>Aceitaste a política de privacidade em <?= e($eu['consentimento_em']) ?></dd>
    </dl>
    <p>A password não aparece porque não é guardada: guardamos apenas o seu hash.</p>

    <form method="post" action="<?= url('/conta/apagar') ?>"
          onsubmit="return confirm('Apagar a conta? Esta ação não pode ser desfeita.');">
        <button type="submit" class="perigo">Apagar a minha conta</button>
    </form>
</section>
