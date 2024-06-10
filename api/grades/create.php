<?php
require_once '../../db.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!empty($data['student_id']) && !empty($data['teacher_id']) && !empty($data['course']) && !empty($data['grade'])) {
    try {
        $sql = "INSERT INTO pending_grades (student_id, teacher_id, course, grade) VALUES (:student_id, :teacher_id, :course, :grade)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':student_id' => $data['student_id'],
            ':teacher_id' => $data['teacher_id'],
            ':course' => $data['course'],
            ':grade' => $data['grade']
        ]);
        http_response_code(201);
        echo json_encode(['message' => 'Note en attente de validation']);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Erreur de connexion à la base de données']);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Données incomplètes']);
}
?>
