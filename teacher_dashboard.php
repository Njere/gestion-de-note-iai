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

    // Vérification si la note existe déjà
    $sql_check = "SELECT id FROM grades WHERE student_id = :student_id AND course = :course AND teacher_id = :teacher_id";
    $stmt_check = $pdo->prepare($sql_check);
    $stmt_check->execute(['student_id' => $student_id, 'course' => $course, 'teacher_id' => $teacher_id]);
    $existing_grade = $stmt_check->fetch();

    if ($existing_grade) {
        // Mise à jour de la note existante
        $sql_update = "UPDATE grades SET grade = :grade WHERE id = :id";
        $stmt_update = $pdo->prepare($sql_update);
        $stmt_update->execute(['grade' => $grade, 'id' => $existing_grade['id']]);
        $message = 'Note mise à jour avec succès.';
    } else {
        // Insertion d'une nouvelle note
        $sql_insert = "INSERT INTO grades (student_id, teacher_id, course, grade) VALUES (:student_id, :teacher_id, :course, :grade)";
        $stmt_insert = $pdo->prepare($sql_insert);
        $stmt_insert->execute(['student_id' => $student_id, 'teacher_id' => $teacher_id, 'course' => $course, 'grade' => $grade]);
        $message = 'Nouvelle note ajoutée avec succès.';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord Enseignant</title>
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
        <h2>Tableau de bord Enseignant</h2>
        <p>Bienvenue, <?= htmlspecialchars($_SESSION['username']) ?></p>
        
        <nav class="nav">
            <a class="nav-link active" href="teacher_dashboard.php">Tableau de bord</a>
            <a class="nav-link" href="insert.php">Ajouter des Notes</a>
            <a class="nav-link" href="logout.php">Déconnexion</a>
        </nav>

        <?php if ($message): ?>
            <div class="alert alert-info" role="alert">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <h3 class="mt-5">Liste des Notes</h3>
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID Étudiant</th>
                    <th>ID Enseignant</th>
                    <th>Cours</th>
                    <th>Note</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Récupérer les notes enregistrées
                $sql = "SELECT * FROM grades WHERE teacher_id = :teacher_id";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(['teacher_id' => $_SESSION['user_id']]);
                $grades = $stmt->fetchAll();

                if ($grades) {
                    foreach ($grades as $grade) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($grade['student_id']) . "</td>";
                        echo "<td>" . htmlspecialchars($grade['teacher_id']) . "</td>";
                        echo "<td>" . htmlspecialchars($grade['course']) . "</td>";
                        echo "<td>" . htmlspecialchars($grade['grade']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>Aucune donnée disponible</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
