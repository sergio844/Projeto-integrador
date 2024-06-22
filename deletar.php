<?php
include("conexao.php");

// Obtém o código do usuário a partir do parâmetro GET, convertendo-o para inteiro
$usu_codigo = intval($_GET['funcionario']);

// Prepara a consulta SQL para deletar o funcionário
$sql_code = "DELETE FROM funcionarios WHERE codigo = ?";
$stmt = $mysqli->prepare($sql_code);


if ($stmt) {
    
    $stmt->bind_param("i", $usu_codigo);

    // Executa a consulta
    $executado = $stmt->execute();

   
    if ($executado) {
        echo "
        <script> 
            alert('O funcionário foi deletado com sucesso');
            location.href='index.php?p=inicial';
        </script>";
    } else {
        echo "
        <script> 
            alert('Não foi possível deletar o funcionário.');
            location.href='index.php?p=inicial';
        </script>";
    }

    // Fecha a declaração
    $stmt->close();
} else {
    echo "
    <script> 
        alert('Erro na preparação da consulta SQL.');
        location.href='index.php?p=inicial';
    </script>";
}

// Fecha a conexão com o banco de dados
$mysqli->close();
?>
