<?php
session_start();
require_once 'db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $sex = $_POST['sex'];
    $poste = $_POST['poste'];

    // Vérification si l'email existe déjà
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        $message = 'Cet email est déjà utilisé.';
    } else {
        // Insertion des données dans la table users
        $stmt = $pdo->prepare("INSERT INTO users (nom, email, sex, mdp, poste) VALUES (?, ?, ?, ?, ?)");
        if ($stmt->execute([$nom, $email, $sex, $password, $poste])) {
            $message = 'Compte créé avec succès. Vous pouvez maintenant vous <a href="login.php">connecter</a>.';
        } else {
            $message = 'Erreur lors de la création du compte.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un Compte</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f7f7f7; /* Couleur de fond plus neutre pour mieux faire ressortir les éléments colorés */
        }
        .form-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            margin-top: 20px;
        }
        .header-color {
            background-color: #f1c40f; /* Jaune */
            color: #1abc9c; /* Vert citron */
            padding: 10px 15px;
            border-radius: 5px;
        }
        .btn-custom {
            background-color: #1abc9c; /* Vert citron */
            color: #fff;
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
            <h2 class="header-color">Créer un Compte</h2>
            <form action="cree_compte.php" method="POST">
                <div class="form-group">
                    <label for="nom">Nom et Prénom</label>
                    <input type="text" class="form-control" id="nom" name="nom" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="sex">Sexe</label>
                    <select class="form-control" id="sex" name="sex" required>
                        <option value="M">Masculin</option>
                        <option value="F">Féminin</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="poste">Poste</label>
                    <select class="form-control" id="poste" name="poste">
                        <option value="DAA">DAA</option>
                        <option value="DAAA">DAAA</option>
                        <option value="DGL">DGL</option>
                        <option value="DSR">DSR</option>
                        <option value="DSE">DSE</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-custom">Créer un compte administratif</button>
            </form>
            <?php if ($message): ?>
                <p><?= $message ?></p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
