<?php
session_start();
require_once 'db.php';

$error = '';
$success = '';

// Traitement du formulaire lorsqu'il est soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $sex = $_POST['sex'] ?? '';
    $mdp = $_POST['mdp'] ?? '';
    $poste = $_POST['poste'] ?? '';

    // Insertion des données dans la base de données
    $sql = "INSERT INTO user (name, email, sex, mdp, poste) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([$name, $email, $sex, $mdp, $poste]);
        $success = 'Admin enregistré avec succès.';
    } catch (PDOException $e) {
        $error = 'Erreur lors de l\'inscription de l\'admin : ' . $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription Membre de l'Adminstration</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body { background-color: #f7f7f7; }
        .form-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            margin-top: 50px;
        }
        .header-color {
            background-color: #f1c40f; /* Jaune */
            color: #1abc9c; /* Vert citron */
            padding: 10px;
            text-align: center;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .btn-custom {
            background-color: #1abc9c; /* Vert citron */
            color: white;
            border: none;
        }
        .btn-custom:hover {
            background-color: #f1c40f; /* Jaune */
            color: #1abc9c;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2 class="header-color">Inscription Membre de l'Adminstration</h2>
            <?php if ($error): ?>
                <div class="alert alert-danger" role="alert"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="alert alert-success" role="alert"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>
            <form method="POST">
                <div class="form-group">
                    <label for="name">Nom complet</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="sex">Sexe</label>
                    <select class="form-control" id="sex" name="sex">
                        <option value="Male">Masculin</option>
                        <option value="Female">Féminin</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="age">Mot de passe</label>
                    <input type="password" class="form-control" id="mdp" name="mdp" required>
                </div>
                <div class="form-group">
                    <label for="class">Poste</label>
                    <input type="text" class="form-control" id="poste" name="poste" required>
                </div>
                <button type="submit" class="btn btn-custom">S'inscrire</button>
            </form>
        </div>
    </div>
</body>
</html>
