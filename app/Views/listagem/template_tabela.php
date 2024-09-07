<main>
    <?php if(!empty($errors)) echo $errors; ?>
    <?php if(!empty($filters)) echo $filters; ?>
    <?php if(!empty($admin)) echo anchor(url_to('adminCreate', current_url(true)->getSegment(2)), 'Criar novo')?>
    <?php if(empty($table)): ?>
        <p>Não há nada para mostrar</p>
    <?php
    else:
        echo $table;
    endif;
    ?>
    <?php echo $pager->links(); ?>
</main>