<?php
session_start();
require_once 'db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $password = $_POST['password'];

    // Requête préparée pour éviter les injections SQL
    $sql = "SELECT * FROM users WHERE nom = :nom";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute(['nom' => $nom]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['mdp'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['nom'];
            $_SESSION['role'] = $user['poste'];
            header('Location: admin_dashboard.php');
            exit();
        } else {
            $error = 'Identifiants incorrects.';
        }
    } catch (PDOException $e) {
        $error = 'Erreur de connexion à la base de données : ' . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f7f7f7;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background-color: white;
            padding: 40px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #1abc9c;
            background-color: #f1c40f;
            padding: 10px;
            border-radius: 5px;
        }
        .error {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }
        .btn-custom {
            background-color: #1abc9c;
            color: #fff;
            border: none;
            width: 100%;
        }
        .btn-custom:hover {
            background-color: #f1c40f;
            color: #1abc9c;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Connexion</h2>
        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="post" action="">
            <div class="form-group">
                <label for="nom">Nom d'utilisateur</label>
                <input type="text" class="form-control" id="nom" name="nom" required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-custom">Connexion</button>
        </form>
    </div>
</body>
</html>
