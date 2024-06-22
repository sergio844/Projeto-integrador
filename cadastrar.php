<?php
include("conexao.php");

if (isset($_POST['confirmar'])) {
    // Iniciar a sessão, se ainda não foi iniciada
    if (!isset($_SESSION)) {
        session_start();
    }

    // Escapar os valores do POST e armazená-los na sessão
    foreach ($_POST as $chave => $valor) {
        $_SESSION[$chave] = $mysqli->real_escape_string(trim($valor));
    }

    // Inicializar array de erros
    $erro = array();

    // Validar campos obrigatórios
    if (empty($_SESSION['nome'])) {
        $erro[] = "Preencha o nome.";
    }

    if (empty($_SESSION['sobrenome'])) {
        $erro[] = "Preencha o sobrenome.";
    }

    if (empty($_SESSION['departamento'])) {
        $erro[] = "Preencha o departamento.";
    }

    if (empty($_SESSION['funcao'])) {
        $erro[] = "Preencha a função.";
    }

    // Se não houver erros, inserir os dados no banco
    if (count($erro) == 0) {
        $sql_code = "INSERT INTO funcionarios (
            nome,
            sobrenome,
            sexo,
            departamento,
            funcao,
            datadeadmissao
        ) VALUES (?, ?, ?, ?, ?, NOW())";

        $stmt = $mysqli->prepare($sql_code);
        $stmt->bind_param(
            "sssss",
            $_SESSION['nome'],
            $_SESSION['sobrenome'],
            $_SESSION['sexo'],
            $_SESSION['departamento'],
            $_SESSION['funcao']
        );

        if ($stmt->execute()) {
            // Limpar variáveis de sessão
            unset(
                $_SESSION['nome'],
                $_SESSION['sobrenome'],
                $_SESSION['sexo'],
                $_SESSION['departamento'],
                $_SESSION['funcao']
            );

            echo "<script> location.href='index.php?p=inicial'; </script>";
        } else {
            $erro[] = "Erro ao inserir os dados: " . $stmt->error;
        }

        $stmt->close();
    }
}
?>

<h1>Cadastrar Funcionários</h1>
<?php
if (isset($erro) && count($erro) > 0) {
    echo "<div class='erro'>";
    foreach ($erro as $valor) {
        echo htmlspecialchars($valor) . "<br>";
    }
    echo "</div>";
}
?>

<a href="index.php?p=inicial">< Voltar</a>

<form action="index.php?p=cadastrar" method="POST">
    <label for="nome">Nome</label>
    <input name="nome" value="<?= isset($_SESSION['nome']) ? htmlspecialchars($_SESSION['nome']) : '' ?>" required type="text">
    <p class="espaco"></p>

    <label for="sobrenome">Sobrenome</label>
    <input name="sobrenome" value="<?= isset($_SESSION['sobrenome']) ? htmlspecialchars($_SESSION['sobrenome']) : '' ?>" required type="text">
    <p class="espaco"></p>

    <label for="sexo">Sexo</label>
    <select name="sexo" required>
        <option value="">Selecione</option>
        <option value="1" <?= (isset($_SESSION['sexo']) && $_SESSION['sexo'] == '1') ? 'selected' : '' ?>>Masculino</option>
        <option value="2" <?= (isset($_SESSION['sexo']) && $_SESSION['sexo'] == '2') ? 'selected' : '' ?>>Feminino</option>
    </select>
    <p class="espaco"></p>

    <label for="departamento">Departamento</label>
    <input name="departamento" value="<?= isset($_SESSION['departamento']) ? htmlspecialchars($_SESSION['departamento']) : '' ?>" required type="text">
    <p class="espaco"></p>

    <label for="funcao">Funcao</label>
    <input name="funcao" value="<?= isset($_SESSION['funcao']) ? htmlspecialchars($_SESSION['funcao']) : '' ?>" required type="text">
    <p class="espaco"></p>

    <input value="Salvar" name= "confirmar" type="submit">
</form>
