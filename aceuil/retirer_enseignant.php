<?php
// Connexion à la base de données
$serveur = "localhost";
$utilisateur = "root";
$motdepasse = "";
$base = "gestion_notess";

$connexion = new mysqli($serveur, $utilisateur, $motdepasse, $base);

// Vérifier la connexion
if ($connexion->connect_error) {
    die("Échec de la connexion : " . $connexion->connect_error);
}

// Récupérer l'ID de l'enseignant à supprimer
$id_enseignant = $_POST['id_enseignant'];

// Préparer la requête SQL
$requete = "DELETE FROM teachers WHERE id = ?";
$stmt = $connexion->prepare($requete);
$stmt->bind_param("i", $id_enseignant);

// Exécuter la requête
if ($stmt->execute()) {
    echo "Enseignant supprimé avec succès !";
} else {
    echo "Erreur lors de la suppression de l'enseignant : " . $stmt->error;
}

// Fermer la connexion
$stmt->close();
$connexion->close();
?>