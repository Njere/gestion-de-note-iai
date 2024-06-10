<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestion_notess";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion à la base de données : " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom_prenom = $_POST['nom_prenom'];
    $email = $_POST['email'];
    $mdp = $_POST['mdp'];
    $matiere = $_POST['matiere'];

    // Préparer et exécuter la requête SQL pour insérer un nouvel enseignant
    $sql = "INSERT INTO teachers (nom_prenom, email, mdp, matiere) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Échec de la préparation de la requête : " . $conn->error);
    }

    $stmt->bind_param("ssss", $nom_prenom, $email, $mdp, $matiere);
    if ($stmt->execute()) {
        echo "<div class='container'><div class='alert alert-success' role='alert'>Enregistrement réussi !</div></div>";
    } else {
        echo "<div class='container'><div class='alert alert-danger' role='alert'>Erreur lors de l'enregistrement : " . $stmt->error . "</div></div>";
    }

    $stmt->close();
}

// Afficher les enseignants enregistrés
$sql = "SELECT * FROM teachers";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<div class='container'><h1>Liste des Enseignants</h1><table class='table table-striped table-bordered'><thead class='thead-dark'><tr><th>ID</th><th>Nom & Prénom</th><th>Email</th><th>Matière</th></tr></thead><tbody>";
    // Parcourir chaque ligne de résultat
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row['id_enseignant'] . "</td><td>" . $row['nom_prenom'] . "</td><td>" . $row['email'] . "</td><td>" . $row['matiere'] . "</td></tr>";
    }
    echo "</tbody></table></div>";
} else {
    echo "<div class='container'><p>Aucune donnée disponible</p></div>";
}

$conn->close();
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Enseignant</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
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
        }
        input[type=text], input[type=password] {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Connexion Enseignant</h2>
        <form method="post" action="authenticate_teacher.php">
            <label for="id_enseignant">ID Enseignant :</label>
            <input type="text" id="id_enseignant" name="id_enseignant" placeholder="Entrez votre ID" required>

            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" placeholder="Entrez votre mot de passe" required>

            <button type="submit">Se connecter</button>
        </form>
    </div>
</body>
</html>
