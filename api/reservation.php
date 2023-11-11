<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Receba os dados do formulário
    $name = $_POST['name'];
    $date = $_POST['date'];
    $hour = $_POST['hour'];
    $peopleNumber = $_POST['peopleNumber'];
    $info = $_POST['info'];

    // Formate a data para armazenamento no banco de dados
    $formattedDate = date("Y-m-d", strtotime($date));

    // Combine data e hora para armazenamento no banco de dados
    $formattedDateTime = $formattedDate . ' ' . $hour;

    try {
        $pdo = new PDO("mysql:dbname=restaurant;host=localhost", "root", "tinoca123");

        // Consulta para inserir uma nova reserva
        $sql = $pdo->prepare('INSERT INTO reservations (name, reservationDate , hour, peopleNumber, info) VALUES (:name, :reservationDate, :hour, :peopleNumber, :info)');
        $sql->bindParam(':name', $name);
        $sql->bindParam(':reservationDate', $formattedDateTime); // Corrigido para reservationDate
        $sql->bindParam(':hour', $hour);
        $sql->bindParam(':peopleNumber', $peopleNumber);
        $sql->bindParam(':info', $info);

        if ($sql->execute()) {
            $response = array(
                'message' => 'Reserva cadastrada com sucesso'
            );
            echo json_encode($response);
        } else {
            $errorResponse = array(
                'error' => 'Erro ao cadastrar reserva'
            );
            echo json_encode($errorResponse);
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
