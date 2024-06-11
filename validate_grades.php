<?php
session_start();
require_once 'db.php';

/* Redirection si l'utilisateur n'est pas connecté ou n'est pas administrateur
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}*/

// Message pour les actions
$message = '';

// Validation des notes en attente
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['validate_grades'])) {
    $grade_id = $_POST['grade_id'];

    // Récupération de la note en attente
    $sql = "SELECT * FROM pending_grades WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $grade_id]);
    $grade = $stmt->fetch();

    if ($grade) {
        // Insertion de la note dans la table grades
        $sql_insert = "INSERT INTO grades (student_id, teacher_id, course, grade) VALUES (:student_id, :teacher_id, :course, :grade)";
        $stmt_insert = $pdo->prepare($sql_insert);
        $stmt_insert->execute([
            'student_id' => $grade['student_id'],
            'teacher_id' => $grade['teacher_id'],
            'course' => $grade['course'],
            'grade' => $grade['grade']
        ]);

        // Suppression de la note de la table pending_grades
        $sql_delete = "DELETE FROM pending_grades WHERE id = :id";
        $stmt_delete = $pdo->prepare($sql_delete);
        $stmt_delete->execute(['id' => $grade_id]);

        $message = 'Note validée avec succès.';
    } else {
        $message = 'Erreur lors de la validation de la note.';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validation des Notes</title>
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
        <h2>Validation des Notes</h2>
        <nav class="nav">
            <a class="nav-link" href="admin_dashboard.php">Tableau de bord</a>
            <a class="nav-link active" href="validate_grades.php">Valider les Notes</a>
            <a class="nav-link" href="logout.php">Déconnexion</a>
        </nav>

        <?php if ($message): ?>
            <div class="alert alert-info" role="alert">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <h3>Notes en attente de validation</h3>
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>ID Étudiant</th>
                    <th>ID Enseignant</th>
                    <th>Cours</th>
                    <th>Note</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Récupérer les notes en attente de validation
                $sql = "SELECT * FROM pending_grades";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                $pending_grades = $stmt->fetchAll();

                if ($pending_grades) {
                    foreach ($pending_grades as $grade) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($grade['id']) . "</td>";
                        echo "<td>" . htmlspecialchars($grade['student_id']) . "</td>";
                        echo "<td>" . htmlspecialchars($grade['teacher_id']) . "</td>";
                        echo "<td>" . htmlspecialchars($grade['course']) . "</td>";
                        echo "<td>" . htmlspecialchars($grade['grade']) . "</td>";
                        echo "<td>
                                <form method='POST'>
                                    <input type='hidden' name='grade_id' value='" . htmlspecialchars($grade['id']) . "'>
                                    <button type='submit' class='btn btn-success' name='validate_grades'>Valider</button>
                                </form>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>Aucune note en attente de validation.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
