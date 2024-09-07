<?php if(isset($redirect)): ?>
<h1>Redirecionando...</h1>
<?php echo anchor($redirect ?? base_url(), 'Se o seu browser não suporta redirecionamento automatico clique aqui')?>
<?php else:?>
<h1>Erro no redirecionamento</h1>
<?php endif; ?>

