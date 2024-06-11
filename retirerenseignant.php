<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestion_notess";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

// Vérifier si l'ID de l'enseignant à supprimer est défini
if (isset($_POST['id_enseignant'])) {
    $id_enseignant = $_POST['id_enseignant'];

    // Préparer la requête SQL
    $sql = "DELETE FROM teachers WHERE id_enseignant = $id_enseignant";

    // Exécuter la requête
    if ($conn->query($sql) === TRUE) {
        echo "Enseignant supprimé avec succès !";
    } else {
        echo "Erreur lors de la suppression de l'enseignant : " . $conn->error;
    }
} else {
   // echo "ID de l'enseignant non défini.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer un Enseignant</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body { 
            background: url('background-education.jpg') no-repeat center center fixed; 
            background-size: cover; 
            color: #333;
            font-family: Arial, sans-serif;
        }
        .header-color {
            background-color: rgba(241, 196, 15, 0.9); /* Jaune */
            color: #1abc9c; /* Vert citron */
            padding: 15px;
            text-align: center;
            border-radius: 5px;
            margin-top: 20px;
        }
        .container {
            background: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }
        .btn-custom {
            background-color: #1abc9c;
            color: white;
            margin: 5px;
        }
        .btn-custom:hover {
            background-color: #16a085;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="header-color">Supprimer un Enseignant</h1>
        <form action="retirerenseignant.php" method="post">
            <label for="id_enseignant">ID de l'enseignant :</label>
            <input type="number" id="id_enseignant" name="id_enseignant" min="1" required class="form-control">
            <button type="submit" class="btn btn-custom mt-3">Supprimer l'enseignant</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
