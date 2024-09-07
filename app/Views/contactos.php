<main>
    <div class="contacto">
        <h1>Deixe o seu contacto</h1>
        <?php if(isset($errors)) echo $errors;?>
        <?php if(isset($sucesso) && $sucesso==true) echo 'Contacto adicionado com sucesso!';?>
        <?php
        echo form_open(url_to('contacto'));
        echo form_label($email['label'], $email['data']['id']);
        echo form_input($email['data'], set_value($email['data']['name']));
        echo form_label($subject['label'], $subject['data']['id']);
        echo form_input($subject['data'], set_value($subject['data']['name']));
        echo form_label($textarea['label'], $textarea['data']['id']);
        echo form_textarea($textarea['data'], set_value($textarea['data']['name']));
        ?>
        <div class="g-recaptcha" data-sitekey="6Le9bRwpAAAAALi32SClejD9qj5nXHAy8QMLF2Fd"></div>
        <?php
        echo form_submit($submit['data']);
        echo form_close();
        ?>
    </div>
</main>