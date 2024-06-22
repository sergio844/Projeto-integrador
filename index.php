<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Controle de Funcionários</title>
    <style>
        .principal {
            width: 50%;
            margin: 0 auto;
            background-color: #FFF;
            border: 1px solid #e3e3e3;
            border-radius: 5px;
            padding: 20px;
        }
        body {
            background: #eaeaea;
            padding: 20px;
            font-family: Arial, sans-serif;
            font-size: 18px;
        }
        label {
            display: block;
            font-weight: bold;
        }
        .espaco {
            height: 15px;
            display: block;
        }
        input {
            font-size: 16px;
            padding: 5px;
        }
        .titulo {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="cadatrar">
        <?php
        if (isset($_GET['p'])) {
            $pagina = $_GET['p'] . ".php";
            if (is_file($pagina)) {
                include($pagina);
            } else {
                include("404.php");
            }
        } else {
            include("inicial.php");
        }
        ?> 
    </div>
</body>
</html>
