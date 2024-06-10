<?php
require_once '../../db.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!empty($data['id']) && !empty($data['grade'])) {
    try {
        $sql = "UPDATE grades SET grade = :grade WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':id' => $data['id'],
            ':grade' => $data['grade']
        ]);
        echo json_encode(['message' => 'Note mise à jour avec succès']);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Erreur de connexion à la base de données']);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Données incomplètes']);
}
?>
