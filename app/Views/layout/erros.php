<?php if (!empty($erros)): ?>
    <ul class="erros">
        <?php foreach ($erros as $erro): ?>
            <li><?= e($erro) ?></li>
        <?php endforeach; ?>    
    </ul>

<?php endif;?>    