<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Receba os dados do formulário
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        $pdo = new PDO("mysql:dbname=restaurant;host=localhost", "root", "tinoca123");

        // Verificar se o usuário já existe
        $checkUser = $pdo->prepare('SELECT * FROM users WHERE email = :email');
        $checkUser->bindParam(':email', $email);
        $checkUser->execute();

        if ($checkUser->rowCount() > 0) {
            // Usuário já cadastrado
            http_response_code(400);
            $errorResponse = array(
                'error' => 'already registered user '
            );
            echo json_encode($errorResponse);
        } else {
            // Inserir novo usuário
            $sql = $pdo->prepare('INSERT INTO users (name, email, password) VALUES (:name, :email, :password)');
            $sql->bindParam(':name', $name);
            $sql->bindParam(':email', $email);
            $sql->bindParam(':password', $password);

            if ($sql->execute()) {
                $response = array(
                    'message' => 'Usuário cadastrado com sucesso'
                );
                echo json_encode($response);
            } else {
                $errorResponse = array(
                    'error' => 'Erro ao cadastrar usuário'
                );
                echo json_encode($errorResponse);
            }
        }
    } catch (PDOException $e) {
        $errorResponse = array(
            'error' => 'Erro de conexão com o banco de dados: ' . $e->getMessage()
        );
        echo json_encode($errorResponse);
    }
} else {
    $errorResponse = array(
        'error' => 'Método não permitido'
    );
    echo json_encode($errorResponse);
}

// Defina o cabeçalho Content-Type como JSON
header('Content-Type: application/json');
?>