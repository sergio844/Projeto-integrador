
<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "mercado";

// Cria a conexão
$mysqli = new mysqli($host, $user, $password, $database);

// Verifica a conexão
if ($mysqli->connect_error) {
    echo"Erro na conexão: (". $mysqli->connect_errno . ")". $mysqli->connect_error;
}
?>