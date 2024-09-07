<h1>
    <?php
    echo !empty($id) ? 'Editar' : 'Criar';
    echo ' ' . $entity . ' ';
    echo $id ?? '';
    ?>
</h1>
<?php if(!empty($errors)): ?>
    <ul class="error">
        <?php for($it = new \App\Core\Iterator($errors);!$it->isDone();$it->next()): ?>
            <li><?php echo $it->current(); ?></li>
        <?php endfor; ?>
    </ul>
<?php endif; ?>
<?php echo $form; ?>