<nav class="menu">
    <ul>
        <li><?php echo anchor(url_to('home'), 'Home', ['class' => url_to('home')==current_url()?'active':'']) ?></li>
        <li><?php echo anchor(url_to('contacto'), 'Contacto', ['class' => url_to('contacto')==current_url()?'active':'']) ?></li>
        <li><?php echo anchor(url_to('listarMedicos'), 'Listagem de medicos', ['class' => url_to('listarMedicos')==current_url()?'active':'']) ?></li>
        <li><?php echo anchor(url_to('listarUtentes'), 'Listagem de utentes', ['class' => url_to('listarUtentes')==current_url()?'active':'']) ?></li>
        <li><?php echo anchor(url_to('listarConsultas'), 'Listagem de consultas', ['class' => url_to('listarConsultas')==current_url()?'active':'']) ?></li>
        <li><?php echo anchor(url_to('login'), 'Login', ['class' => url_to('login')==current_url()?'active':'']) ?></li>
    </ul>
</nav>