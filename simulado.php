<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "simulados";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

function obterPerguntasAleatorias($conn, $quantidade)
{
    $sql = "SELECT id, pergunta, resposta_correta, opcao1, opcao2, opcao3, opcao4, opcao5 
            FROM perguntas 
            ORDER BY RAND() 
            LIMIT $quantidade";
    $result = $conn->query($sql);
    $perguntas = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $pergunta = $row;
            $alternativas = [$row['opcao1'], $row['opcao2'], $row['opcao3'], $row['opcao4'], $row['opcao5']];
            
            // Embaralhe as alternativas aleatoriamente
            shuffle($alternativas);

            $pergunta['alternativas'] = array_combine(['A', 'B', 'C', 'D', 'E'], $alternativas);

            $perguntas[] = $pergunta;
        }
    }

    return $perguntas;
}

$quantidade_perguntas = 10;

$perguntasAleatorias = obterPerguntasAleatorias($conn, $quantidade_perguntas);
?>


<!DOCTYPE html>
<html>

<head>
    <title>Simulado</title>
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

    <header class="text-end">
        <img class="logo" src="images/logoWhite.png">
        <a style="margin-top:20px;" class="btn btn-primary" href="index.php">Voltar para a página Inserir Perguntas</a>
    </header>

    <div class="simulado">

        <h1 style="color:#024c81;" class="text-center">Simulado</h1>

        <div class="questoesimulados">
            <form method="post" action="verificar_respostas.php">
                <?php $contador = 1; // Inicialize o contador 
                ?>
                <?php foreach ($perguntasAleatorias as $pergunta) { ?>
                    <h3><?php echo "<p style='font-size:20px;'>" . $contador . '. ' . $pergunta['pergunta'] . "<p>"; ?></h3>

                    <?php foreach ($pergunta['alternativas'] as $letra => $alternativa) { ?>
                        <label>
                            <input type="radio" name="respostas[<?php echo $pergunta['id']; ?>]" value="<?php echo $alternativa; ?>" required>
                            <?php echo $letra . '. ' . $alternativa; ?>
                        </label><br>
                    <?php } ?>

                    <hr>
                    <?php $contador++; // Incrementar o contador 
                    ?>
                <?php } ?>
                <div class="text-center">
                    <input class="btn btn-success" type="submit" name="submit" value="Responder Tudo e Finalizar">
                </div>
            </form>
        </div>
    </div>
    <footer>
        <p class="text-white">Developed by Bruno Collange</p>
    </footer>
</body>

</html>