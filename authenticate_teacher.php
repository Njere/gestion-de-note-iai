<?php
session_start();
require_once 'db.php';  // Assurez-vous que ce fichier contient la connexion à la base de données

// Traitement du formulaire lorsque les données sont soumises
if (isset($_POST['id_enseignant']) && isset($_POST['password'])) {
    $id_enseignant = $_POST['id_enseignant'];
    $password = $_POST['password'];

    // Requête préparée pour éviter les injections SQL
    $sql = "SELECT id_enseignant, mdp, nom_prenom FROM teachers WHERE id_enseignant = :id_enseignant";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute(['id_enseignant' => $id_enseignant]);
        $user = $stmt->fetch();

        if ($user && $password == $user['mdp']) {
            $_SESSION['user_id'] = $user['id_enseignant'];
            $_SESSION['username'] = $user['nom_prenom'];
            header('Location: teacher_dashboard.php');
            exit();
        } else {
            $error = 'Identifiants incorrects.';
        }
    } catch (PDOException $e) {
        $error = 'Erreur de connexion à la base de données : ' . $e->getMessage();
    }

    if ($error) {
        header('Location: loginE.php?error=' . urlencode($error));
        exit();
    }
}
?>
