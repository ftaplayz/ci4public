<?php // ESTA PAGINA NÃO É USADA ?>
<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>{{title}}</title>
        {{#styles}}
            <link rel="stylesheet" href="{{.}}" />
        {{/styles}}
        <meta name="author" content="Abilio" />
        <meta name="description" content="Projeto CodeIgniter 4" />
        {{#scripts}}
            <script type="text/javascript" src="{{.}}"></script>
        {{/scripts}}
    </head>
    <body>
        <?php echo $this->include('comuns/menu'); ?>
        <main>
            {{#main}}
                {{.}}
            {{/main}}
        </main>
        <footer>
            <p>Copyright: Abílio 2023</p>
        </footer>
    </body>
</html>