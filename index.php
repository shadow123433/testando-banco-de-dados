<?php
// Dados de conexão com o banco de dados
$hostname = "localhost";  // Ou o IP do seu servidor
$bancodedados = "th2";    // Nome do banco de dados
$usuario = "root";        // Usuário do MySQL
$senha = "";              // Senha do MySQL

// Criando a conexão com o banco de dados
$mysqli = new mysqli($hostname, $usuario, $senha, $bancodedados);

// Verificar se houve erro na conexão
if ($mysqli->connect_errno) {
    die("Falha ao conectar ao banco de dados: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);         
}

// Verificando se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recebendo os dados do formulário
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Consultando o banco de dados para verificar se o e-mail existe
    $stmt = $mysqli->prepare("SELECT id, email, senha FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email); // Passando o e-mail para a consulta
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificando se o e-mail existe no banco de dados
    if ($result->num_rows > 0) {
        // O e-mail existe, vamos pegar a senha armazenada
        $row = $result->fetch_assoc();
        $senha_armazenada = $row['senha'];

        // Verificando se a senha fornecida corresponde à senha armazenada
        if (password_verify($senha, $senha_armazenada)) {
            echo "Login realizado com sucesso!";
            // Aqui você pode redirecionar para outra página ou criar uma sessão
            // Exemplo: header('Location: dashboard.php');
        } else {
            echo "Senha incorreta!";
        }
    } else {
        echo "E-mail não encontrado!";
    }

    // Fechar a declaração e a conexão
    $stmt->close();
    $mysqli->close();
}
?>
