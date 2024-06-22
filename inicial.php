<?php
include("conexao.php");

$sql_code = "SELECT * FROM funcionarios";
$sql_query = $mysqli->query($sql_code) or die($mysqli->error);
$linha = $sql_query->fetch_assoc();
?>        

<h1>Funcionários</h1>
<a href="index.php?p=cadastrar">Cadastrar Funcionário</a>
<p class="espaco"></p>
<table border="1" cellpadding="10">
    <tr class="titulo">
        <td>Nome</td>
        <td>Sobrenome</td>
        <td>Sexo</td>
        <td>Departamento</td>
        <td>Função</td>
        <td>Data de Admissão</td>
        <td>Ação</td>
    </tr>
    <?php
    do {
    ?> 
    <tr>
        <td><?php echo $linha['nome']; ?></td>
        <td><?php echo $linha['sobrenome']; ?></td>
        <td><?php echo $linha['sexo']; ?></td>
        <td><?php echo $linha['departamento']; ?></td>
        <td><?php echo $linha['funcao']; ?></td>
        <td><?php
            $d = explode(" ", $linha['datadeadmissao']);
            $data = explode("-", $d[0]);
            echo "$data[2]/$data[1]/$data[0] às $d[1]";
            ?></td>
        <td>
            <a href="index.php?p=editar&funcionario=<?php echo $linha['codigo']; ?>">Editar</a>
            <a href="javascript: if(confirm('Tem certeza que deseja deletar o funcionário <?php echo $linha['codigo']; ?>?'))
                location.href='index.php?p=deletar&funcionario=<?php echo $linha['codigo']; ?>';">Deletar</a>
        </td>
    </tr>
    <?php } while ($linha = $sql_query->fetch_assoc()); ?>
</table>
