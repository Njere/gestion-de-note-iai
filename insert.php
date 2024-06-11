<?php
session_start();
require_once 'db.php';

// Redirection si l'utilisateur n'est pas connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: loginE.php');
    exit;
}

// Message pour les actions
$message = '';

// Ajout ou mise à jour des notes d'un étudiant
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_grades'])) {
    $student_id = $_POST['student_id'];
    $grade = $_POST['grade'];
    $course = $_POST['course'];
    $teacher_id = $_SESSION['user_id'];

    // Insertion de la note dans la table pending_grades
    $sql_insert = "INSERT INTO pending_grades (student_id, teacher_id, course, grade) VALUES (:student_id, :teacher_id, :course, :grade)";
    $stmt_insert = $pdo->prepare($sql_insert);
    $stmt_insert->execute(['student_id' => $student_id, 'teacher_id' => $teacher_id, 'course' => $course, 'grade' => $grade]);
    $message = 'Nouvelle note ajoutée avec succès et en attente de validation.';
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter des Notes</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 50px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .alert {
            margin-top: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .btn-custom {
            margin-top: 10px;
        }
        .nav-link {
            margin-right: 15px;
        }
        .nav-link.active {
            font-weight: bold;
            color: #1abc9c;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Ajouter des Notes</h2>
        <nav class="nav">
            <a class="nav-link" href="teacher_dashboard.php">Tableau de bord</a>
            <a class="nav-link active" href="insert.php">Ajouter des Notes</a>
            <a class="nav-link" href="logout.php">Déconnexion</a>
        </nav>

        <?php if ($message): ?>
            <div class="alert alert-info" role="alert">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="student_id">ID de l'étudiant</label>
                <input type="text" class="form-control" id="student_id" name="student_id" required>
            </div>
            <div class="form-group">
                <label for="course">Cours</label>
                <input type="text" class="form-control" id="course" name="course" required>
            </div>
            <div class="form-group">
                <label for="grade">Note</label>
                <input type="text" class="form-control" id="grade" name="grade" required>
            </div>
            <button type="submit" class="btn btn-primary btn-custom" name="submit_grades">Soumettre</button>
        </form>
    </div>
</body>
</html>
