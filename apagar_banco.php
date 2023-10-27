<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "simulados";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// SQL para apagar todas as perguntas
$sql = "DELETE FROM perguntas";

if ($conn->query($sql) === true) {
    echo "<script> alert('Banco de dados apagado com sucesso!'); </script>";
} else {
    echo "<script> alert('Ocorreu algum erro ao apagar o banco de dados.'); </script>" . $conn->error;
}

// Feche a conexão
$conn->close();

?>

<script>
    setTimeout(function () {
        window.location.href = 'index.php'; // Substitua 'pagina1.php' pelo nome correto do arquivo da página 1
    }, 0001); // Redireciona após 3 segundos (3000 milissegundos)
</script>

