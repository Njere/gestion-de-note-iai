<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard des Notes</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 50px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #343a40;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Dashboard des Notes</h1>
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>ID Enseignant</th>
                    <th>Nom & Prénom</th>
                    <th>Matière</th>
                    <th>Classe</th>
                    <th>Nom de l'Étudiant</th>
                    <th>Prénom</th>
                    <th>Matricule</th>
                    <th>Filière</th>
                    <th>Enseignant</th>
                    <th>Note 1</th>
                    <th>Note 2</th>
                    <th>Note 3</th>
                </tr>
            </thead>
            <tbody>
            <?php
            // Connexion à la base de données
            $servername = "localhost";
            $username = "root"; // Remplacez par votre nom d'utilisateur MySQL
            $password = ""; // Remplacez par votre mot de passe MySQL
            $dbname = "gestion_notess"; // Remplacez par le nom de votre base de données

            $conn = new mysqli($servername, $username, $password, $dbname);

            // Vérifier la connexion
            if ($conn->connect_error) {
                die("Échec de la connexion à la base de données : " . $conn->connect_error);
            }

            // Exécuter la requête SQL pour récupérer les données de la table "notes"
            $sql = "SELECT * FROM notes";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Parcourir chaque ligne de résultat
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['enseignant_id'] . "</td>";
                    echo "<td>" . $row['nom_prenom'] . "</td>";
                    echo "<td>" . $row['matiere'] . "</td>";
                    echo "<td>" . $row['classe'] . "</td>";
                    echo "<td>" . $row['nom_etudiant'] . "</td>";
                    echo "<td>" . $row['prenom'] . "</td>";
                    echo "<td>" . $row['matricule_s'] . "</td>";
                    echo "<td>" . $row['filiere'] . "</td>";
                    echo "<td>" . $row['enseignant'] . "</td>";
                    echo "<td>" . $row['note1'] . "</td>";
                    echo "<td>" . $row['note2'] . "</td>";
                    echo "<td>" . $row['note3'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='13'>Aucune donnée disponible</td></tr>";
            }

            $conn->close();
            ?>
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
