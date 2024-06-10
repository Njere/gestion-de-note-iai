<?php
require_once '../../db.php';

header('Content-Type: application/json');

try {
    $sql = "SELECT * FROM grades";
    $stmt = $pdo->query($sql);
    $grades = $stmt->fetchAll();
    echo json_encode($grades);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur de connexion à la base de données']);
}
?>
