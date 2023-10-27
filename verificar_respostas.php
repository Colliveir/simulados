<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST" || empty($_POST['respostas'])) {
    // Redireciona o usuário de volta para a página 2 (simulado.php) se não houver respostas
    header("Location: simulado.php");
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "simulados";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mensagens = array();
    $acertos = 0;
    $erros = 0;

    foreach ($_POST['respostas'] as $pergunta_id => $resposta_usuario) {
        $sql = "SELECT pergunta, resposta_correta FROM perguntas WHERE id = $pergunta_id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $pergunta = $row["pergunta"];
            $resposta_correta = $row["resposta_correta"];

            if ($resposta_usuario === $resposta_correta) {
                $mensagem = "<h5 class='text-success'>Resposta correta!</h5> <hr>";
                $acertos++;
            } else {
                $mensagem = "<h5 class='text-danger'>Resposta incorreta.</h5> A resposta correta é: <b>$resposta_correta</b><hr>";
                $erros++;
            }

            $mensagens[] = "$pergunta <br> <h5 style='color:Orange;'>Sua resposta: </h5>" . ucfirst($resposta_usuario) . "<br><br>$mensagem";
        } else {
            $mensagens[] = "Erro: Pergunta não encontrada para ID: $pergunta_id";
        }
    }

    $total_perguntas = count($_POST['respostas']);
    $nota = ($acertos / $total_perguntas) * 10;
} else {
    $mensagens[] = "Erro: Dados ausentes.";
    $nota = 0;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Resultado Simulado</title>
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
        <a style="margin-top: 20px;" class="btn btn-success" href="simulado.php">Tentar simulado novamente</a>
        <a style="margin-top: 20px;" class="btn btn-primary" href="index.php">Voltar para a página Inserir Perguntas</a>

    </header>

    <div class="simulado">
        <h1 class="text-center" style="color:#024c81;">Resultado do Simulado</h1>
        <div class="questoesimulados">
            <?php $contador = 1; // Inicialize o contador 
            ?>
            <?php foreach ($mensagens as $mensagem) { ?>
                <p><?php echo "<h4> Questão " . $contador . ":</h4><br>" . $mensagem; ?></p>
            <?php
                $contador++; // Incrementar o contador
            }
            ?>
            <div class="container text-center">
                <div class="row">
                    <div class="col">
                        <h4 class="text-success">Acertos: <?php echo $acertos; ?></h4>
                    </div>
                    <div class="col">
                        <h4 class="text-danger">Erros: <?php echo $erros; ?></h4>
                    </div>
                    <div class="col">
                        <h4 class="text-warning">Nota: <?php echo number_format($nota, 1); ?></h4>
                    </div>
                </div>
            </div>
        </div><br>
    </div>
    <footer>
        <p class="text-white">Developed by Bruno Collange</p>
    </footer>
</body>

</html>