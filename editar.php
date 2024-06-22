<?php
include("conexao.php");

if (!isset($_GET['funcionario'])) {
    echo "<script> alert('Codigo invalido.'); location.href='index.php?p=inicial'; </script>";
} else {
    $func_codigo = intval($_GET['funcionario']);

    session_start();

    if (isset($_POST['confirmar'])) {
       
        $erro = array();

        
        foreach ($_POST as $chave => $valor) {
            $_SESSION[$chave] = $mysqli->real_escape_string($valor);
        }

        
        if (strlen($_SESSION['nome']) == 0) {
            $erro[] = "Preencha o nome.";
        }

        if (strlen($_SESSION['sobrenome']) == 0) {
            $erro[] = "Preencha o sobrenome.";
        }

        if (strlen($_SESSION['departamento']) == 0) {
            $erro[] = "Preencha o departamento.";
        }

        if (strlen($_SESSION['funcao']) == 0) {
            $erro[] = "Preencha a função.";
        }

        
        if (count($erro) == 0) {
            $sql_code = "UPDATE funcionarios SET
                nome = '{$_SESSION['nome']}',
                sobrenome = '{$_SESSION['sobrenome']}',
                sexo = '{$_SESSION['sexo']}',
                departamento = '{$_SESSION['departamento']}',
                funcao = '{$_SESSION['funcao']}'
                WHERE codigo = '$func_codigo'";

            $confirma = $mysqli->query($sql_code) or die($mysqli->error);

            if ($confirma) {
              
                unset(
                    $_SESSION['nome'],
                    $_SESSION['sobrenome'],
                    $_SESSION['sexo'],
                    $_SESSION['departamento'],
                    $_SESSION['funcao']
                );

                echo "<script> location.href='index.php?p=inicial'; </script>";
            } else {
                $erro[] = $confirma;
            }
        }
    } else {
        $sql_code = "SELECT * FROM funcionarios WHERE codigo = '$func_codigo'";
        $sql_query = $mysqli->query($sql_code) or die($mysqli->error);
        $linha = $sql_query->fetch_assoc();

        if (!isset($_SESSION)) {
            session_start();
        }

        $_SESSION['nome'] = $linha['nome'];
        $_SESSION['sobrenome'] = $linha['sobrenome'];
        $_SESSION['sexo'] = $linha['sexo'];
        $_SESSION['departamento'] = $linha['departamento'];
        $_SESSION['funcao'] = $linha['funcao'];
    }
?>
<h1>Editar Funcionários</h1>
<?php
if (isset($erro) && count($erro) > 0) {
    echo "<div class='erro'>";
    foreach ($erro as $valor) {
        echo "$valor <br>";
    }
    echo "</div>";
}
?>

<a href="index.php?p=inicial">< Voltar</a>

<form action="index.php?p=editar=<?php echo $func_codigo; ?>" method="POST">
    <label for="nome">Nome</label>
    <input name="nome" value="<?php echo $_SESSION['nome']; ?>" required type="text">
    <p class="espaco"></p>

    <label for="sobrenome">Sobrenome</label>
    <input name="sobrenome" value="<?php echo $_SESSION['sobrenome']; ?>" required type="text">
    <p class="espaco"></p>

    <label for="sexo">Sexo</label>
    <select name="sexo" required>
        <option value="">Selecione</option>
        <option value="1" <?php if ($_SESSION['sexo'] == 1) echo 'selected'; ?>>Masculino</option>
        <option value="2" <?php if ($_SESSION['sexo'] == 2) echo 'selected'; ?>>Feminino</option>
    </select>
    <p class="espaco"></p>

    <label for="departamento">Departamento</label>
    <input name="departamento" value="<?php echo $_SESSION['departamento']; ?>" required type="text">
    <p class="espaco"></p>

    <label for="funcao">Função</label>
    <input name="funcao" value="<?php echo $_SESSION['funcao']; ?>" required type="text">
    <p class="espaco"></p>

    <input value="Salvar" name="confirmar" type="submit">
</form>

<?php } ?>
