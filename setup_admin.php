<?php
require_once 'db.php';  // Inclut la connexion à la base de données

// Remplacez par un mot de passe fort et sécurisé
$adminPassword = "POD";
$passwordHash = password_hash($adminPassword, PASSWORD_DEFAULT);

try {
    $stmt = $pdo->prepare("INSERT INTO users (username, password, role, name, sex, age) VALUES (?, ?, 'admin', 'Administrator', 'Male', 35)");
    $stmt->execute(['admin', $passwordHash]);
    echo "Administrateur ajouté avec succès.";
} catch (PDOException $e) {
    die("Erreur lors de l'ajout de l'administrateur : " . $e->getMessage());
}
?>
