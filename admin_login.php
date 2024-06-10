<?php
session_start();
require_once 'db.php';  // Inclut la connexion à la base de données

// Vérification si l'administrateur est déjà connecté
if (isset($_SESSION['user_id']) && $_SESSION['role'] == 'admin') {
    header('Location: admin_dashboard.php');  // Redirection vers le tableau de bord administratif
    exit;
}

$error = '';  // Message d'erreur initial vide

// Traitement du formulaire lorsque les données sont soumises
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['username'], $_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Requête préparée pour éviter les injections SQL
    $sql = "SELECT id, username, password, role FROM users WHERE username = :username AND role = 'admin'";
    $stmt = $pdo->prepare($sql);
    
    try {
        $stmt->execute(['username' => $username]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($password, $admin['password'])) {
            // Si le mot de passe est correct, initialiser les données de session pour l'administrateur
            $_SESSION['user_id'] = $admin['id'];
            $_SESSION['username'] = $admin['username'];
            $_SESSION['role'] = $admin['role'];
            header('Location: admin_dashboard.php'); // Redirection vers le tableau de bord administratif
            exit;
        } else {
            $error = 'Identifiants incorrects ou accès non autorisé.';
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
    <title>Connexion Administrateur</title>
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
            <h2 class="header-color">Connexion Administrateur</h2>
            <?php if ($error): ?>
                <div class="alert alert-danger" role="alert">
                    <!?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            <form method="POST">
                <div class="form-group">
                    <label for="username">Nom d'utilisateur</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-custom">Connexion</button>
            </form>
        </div>
    </div>
</body>
</html>
<!--?php
// Récupérer les informations de connexion depuis le formulaire
$matricule = $_POST['matricule'];
$password = $_POST['password'];

// Vérifier les informations de connexion (par exemple, en les comparant à une base de données)
if ($matricule == 'admin2' && $password == '1234') {
    // Connexion réussie, rediriger vers la page d'accueil des enseignants
    header('Location: admin_login.php');
    exit;
} else {
    // Connexion échouée, afficher un message d'erreur
    echo "Matricule ou mot de passe incorrect.";
}
function authenticate_teacher($username, $password) {
    // Vérification des informations
    if ($username == "enseignant" && $password == "motdepasse") {
        // Redirection vers la page destinée aux enseignants
        header("Location: teacher_dashboard.php");
        exit();
    } else {
        // Afficher un message d'erreur
        echo "Nom d'utilisateur ou mot de passe incorrect.";
    }
}

// Appel de la fonction de vérification
authenticate_teacher($username, $password);
?-->
