<?php
session_start();
require_once 'db.php';

/*Redirection si l'utilisateur n'est pas connecté ou n'est pas administrateur
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

// Ajout d'un nouvel enseignant
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_teacher'])) {
    $nom_prenom = $_POST['nom_prenom'];
    $email = $_POST['email'];
    $mdp = password_hash($_POST['mdp'], PASSWORD_DEFAULT);
    $matiere = $_POST['matiere'];

    // Insertion de l'enseignant dans la table teachers
    $sql_insert = "INSERT INTO teachers (nom_prenom, email, mdp, matiere) VALUES (:nom_prenom, :email, :mdp, :matiere)";
    $stmt_insert = $pdo->prepare($sql_insert);
    $stmt_insert->execute([
        'nom_prenom' => $nom_prenom,
        'email' => $email,
        'mdp' => $mdp,
        'matiere' => $matiere
    ]);

    $message = 'Enseignant ajouté avec succès.';
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord Admin</title>
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
        <h2>Tableau de bord Admin</h2>
        <nav class="nav">
            <a class="nav-link active" href="admin_dashboard.php">Tableau de bord</a>
            <a class="nav-link" href="validate_grades.php">Valider les Notes</a>
            <a class="nav-link" href="logout.php">Déconnexion</a>
        </nav>

        <?php if ($message): ?>
            <div class="alert alert-info" role="alert">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <h3>Ajouter un Enseignant</h3>
        <form method="POST">
            <div class="form-group">
                <label for="nom_prenom">Nom & Prénom</label>
                <input type="text" class="form-control" id="nom_prenom" name="nom_prenom" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="mdp">Mot de passe</label>
                <input type="password" class="form-control" id="mdp" name="mdp" required>
            </div>
            <div class="form-group">
                <label for="matiere">Matière</label>
                <input type="text" class="form-control" id="matiere" name="matiere" required>
            </div>
            <button type="submit" class="btn btn-primary" name="add_teacher">Ajouter l'Enseignant</button>
        </form>

        <h3 class="mt-5">Liste des Enseignants</h3>
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Nom & Prénom</th>
                    <th>Email</th>
                    <th>Matière</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Récupérer la liste des enseignants
                $sql = "SELECT * FROM teachers";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                $teachers = $stmt->fetchAll();

                if ($teachers) {
                    foreach ($teachers as $teacher) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($teacher['id_enseignant']) . "</td>";
                        echo "<td>" . htmlspecialchars($teacher['nom_prenom']) . "</td>";
                        echo "<td>" . htmlspecialchars($teacher['email']) . "</td>";
                        echo "<td>" . htmlspecialchars($teacher['matiere']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>Aucun enseignant trouvé.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <h3 class="mt-5">Travail des Enseignants</h3>
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID Enseignant</th>
                    <th>Nom & Prénom</th>
                    <th>Cours</th>
                    <th>Notes Enregistrées</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Récupérer le travail des enseignants
                $sql = "SELECT teachers.id_enseignant, teachers.nom_prenom, grades.course, COUNT(grades.id) AS notes_enregistrees
                        FROM teachers
                        LEFT JOIN grades ON teachers.id_enseignant = grades.teacher_id
                        GROUP BY teachers.id_enseignant, teachers.nom_prenom, grades.course";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                $teacher_work = $stmt->fetchAll();

                if ($teacher_work) {
                    foreach ($teacher_work as $work) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($work['id_enseignant']) . "</td>";
                        echo "<td>" . htmlspecialchars($work['nom_prenom']) . "</td>";
                        echo "<td>" . htmlspecialchars($work['course']) . "</td>";
                        echo "<td>" . htmlspecialchars($work['notes_enregistrees']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>Aucun travail trouvé pour les enseignants.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
