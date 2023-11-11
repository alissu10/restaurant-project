<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

try {
    $pdo = new PDO("mysql:dbname=restaurant;host=localhost", "root", "tinoca123");

    // Consulta para obter todas as reservas
    $sql = $pdo->prepare('SELECT * FROM reservations');
    $sql->execute();

    $reservations = $sql->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($reservations);
} catch (PDOException $e) {
    $errorResponse = array(
        'error' => 'Erro de conexão com o banco de dados: ' . $e->getMessage()
    );
    echo json_encode($errorResponse);
}
?>
