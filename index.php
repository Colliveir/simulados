<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "simulados";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if (isset($_POST['submit'])) {
    $pergunta = $conn->real_escape_string($_POST['pergunta']);
    $resposta_correta = $conn->real_escape_string($_POST['resposta_correta']);
    $opcao1 = $conn->real_escape_string($_POST['opcao1']);
    $opcao2 = $conn->real_escape_string($_POST['opcao2']);
    $opcao3 = $conn->real_escape_string($_POST['opcao3']);
    $opcao4 = $conn->real_escape_string($_POST['opcao4']);
    $opcao5 = $conn->real_escape_string($_POST['opcao5']);

    $sql = "INSERT INTO perguntas (pergunta, resposta_correta, opcao1, opcao2, opcao3, opcao4, opcao5) 
            VALUES ('$pergunta', '$resposta_correta', '$opcao1', '$opcao2', '$opcao3', '$opcao4', '$opcao5')";

    if ($conn->query($sql) === true) {
        echo "<script> alert('Pergunta inserida com sucesso!'); </script>";
    } else {
        echo "<script> alert('Ocorreu algum erro, por favor, insira a pergunta novamente. Se o problema persistir, contate o desenvolvedor do sistema.'); </script>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Inserir Perguntas</title>
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <!-- CSS -->
    <link rel="stylesheet" href="style.css">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans&display=swap" rel="stylesheet">
</head>

<body>

    <header>
        <img class="logo" src="images/logoWhite.png">
        <h2 style="color:white; margin-top:20px;">Sistema de Simulados</p>
    </header>

    <div class="inserirperguntas">
        <h1 class="text-center" style="color:#024c81;">Insira as Questões:</h1>
        <div class="inserirperguntasbckg">
            <form method="post" action="">
                <p>Questão:</p> <textarea class="textareainserirperguntas" type="text" name="pergunta" required></textarea><br>
                <p>A.</p> <input class="inputinserirperguntas" type="text" name="opcao1" required><br>
                <p>B.</p> <input class="inputinserirperguntas" type="text" name="opcao2" required><br>
                <p>C.</p> <input class="inputinserirperguntas" type="text" name="opcao3" required><br>
                <p>D.</p> <input class="inputinserirperguntas" type="text" name="opcao4" required><br>
                <p>E.</p> <input class="inputinserirperguntas" type="text" name="opcao5" required><br>
                <p>Insira a resposta correta:</p> <input class="inputinserirperguntas" type="text" name="resposta_correta" required><br>
                <div class="text-center"><br>
                    <input style="width:40%;" class="btn btn-success" type="submit" name="submit" value="Inserir Pergunta">
                </div>
            </form><br>
            <?php
            // Verificar se há perguntas no banco de dados
            $result = $conn->query("SELECT id FROM perguntas");
            if ($result->num_rows > 0) {
                echo '<div class="text-center">
                            <a style="width:40%;" class="btn btn-primary" href="simulado.php">Ir para o simulado!</a><br>
                            <br><a style="width:40%;" class="btn btn-danger" href="apagar_banco.php">Deletar Banco de Dados e começar novamente</a>
                        </div>';
            }
            ?>
        </div>
    </div>

    <footer>
        <p class="text-white">Developed by Bruno Collange</p>
    </footer>
</body>

</html>