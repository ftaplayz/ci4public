<nav class="menu">
    <ul>
        <li><?php echo anchor(url_to('home'), 'Home', ['class' => url_to('home')==current_url()?'active':'']) ?></li>
        <li><?php echo anchor(url_to('adminMedicos'), 'Editar medicos', ['class' => url_to('adminMedicos')==current_url()?'active':'']) ?></li>
        <li><?php echo anchor(url_to('adminEnfermeiros'), 'Editar enfermeiros', ['class' => url_to('adminEnfermeiros')==current_url()?'active':'']) ?></li>
        <li><?php echo anchor(url_to('adminConsultas'), 'Editar consultas', ['class' => url_to('adminConsultas')==current_url()?'active':'']) ?></li>
        <li><?php echo anchor(url_to('adminUtentes'), 'Editar utentes', ['class' => url_to('adminUtentes')==current_url()?'active':'']) ?></li>
        <li><?php echo anchor(url_to('adminMorada'), 'Editar moradas', ['class' => url_to('adminMorada')==current_url()?'active':'']) ?></li>
        <li><?php echo anchor(url_to('adminContacto'), 'Editar contactos', ['class' => url_to('adminContacto')==current_url()?'active':'']) ?></li>
        <li><?php echo anchor(url_to('adminProduto'), 'Editar produtos', ['class' => url_to('adminProduto')==current_url()?'active':'']) ?></li>
        <li><?php echo anchor(url_to('adminReceita'), 'Editar receitas', ['class' => url_to('adminReceita')==current_url()?'active':'']) ?></li>
    </ul>
</nav>