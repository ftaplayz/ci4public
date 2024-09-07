<main>
    <h1>Consulta <?php echo $consulta->id; ?></h1>
    <p>Médico: <?php echo $consulta->medico->nome; ?></p>
    <p>Utente: <?php echo $consulta->utente->nome; ?></p>
    <?php if(!empty($consulta->enfermeiros)): ?>
    <div>
        <p>Lista de enfermeiros</p>
        <ul>
            <?php for($it = new \App\Core\Iterator($consulta->enfermeiros);!$it->isDone();$it->next()): ?>
                <li><?php echo $it->current()->nome; ?></li>
            <?php endfor; ?>
        </ul>
    </div>
    <?php endif; ?>
    <div>
        <?php if(!empty($consulta->receita->produtos)): ?>
            <table>
                <thead>
                <tr>
                    <th>Nome</th>
                    <th>Imagem</th>
                </tr>
                </thead>
                <tbody>
                <?php for($it = new \App\Core\Iterator($consulta->receita->produtos);!$it->isDone();$it->next()): ?>
                    <tr>
                        <td><?php echo $it->current()->nome; ?></td>
                        <td><img src="<?php echo $it->current()->imagem; ?>" alt="<?php echo $it->current()->nome; ?>" /></td>
                    </tr>
                <?php endfor; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Não há produtos</p>
        <?php endif; ?>
        <p>Utilização: <?php echo $consulta->receita->utilizacao; ?></p>
        <a href="<?php echo $consulta->receita->receitaPdf ?>">PDF</a>
    </div>
</main>
