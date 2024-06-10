<?php
require_once '../../db.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!empty($data['id'])) {
    try {
        $sql = "DELETE FROM grades WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $data['id']]);
        echo json_encode(['message' => 'Note supprimée avec succès']);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Erreur de connexion à la base de données']);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Données incomplètes']);
}
?>
