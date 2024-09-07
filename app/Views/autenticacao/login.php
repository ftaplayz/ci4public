<main>
    <div class="login">
        <?php if (isset($error)) : ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <?php
        echo form_open(url_to('login'));
        // label do utilizador
        echo form_label($user['label'], $user['data']['id']);
        // input do utilizador
        echo form_input($user['data'], set_value($user['data']['name']));
        // label da password
        echo form_label($password['label'], $password['data']['id']);
        // input da password
        echo form_password($password['data'], set_value($password['data']['name']));?>
        <div class="g-recaptcha" data-sitekey="6Le9bRwpAAAAALi32SClejD9qj5nXHAy8QMLF2Fd"></div>
        <?php
        //submit
        echo form_submit($submit['data']);
        echo form_close();
        ?>
    </div>
</main>