<?php

// Paramètres de connexion à la base de données
$host = 'localhost';      // L'hôte de la base de données
$dbname = 'gestion_notess'; // Le nom de la base de données
$username = 'root';       // Le nom d'utilisateur pour accéder à la base de données
$password = '';           // Le mot de passe pour accéder à la base de données

try {
    // Création d'une instance PDO pour la connexion à la base de données
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

    // Configuration des attributs PDO pour gérer les erreurs
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Configuration pour retourner les résultats sous forme d'arrays associatifs
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // Décommentez la ligne suivante pour activer les exceptions pour les erreurs fatales
    // $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch (PDOException $e) {
    // En cas d'erreur de connexion, on affiche l'erreur
    die('Erreur de connexion à la base de données : ' . $e->getMessage());
}

?>
