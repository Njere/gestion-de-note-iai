<?php
session_start();
$userLoggedIn = false;
if (isset($_SESSION['user_id'])) {
    $userLoggedIn = true;
    $username = $_SESSION['username']; // Assurez-vous que 'username' est bien défini dans votre session lors de la connexion
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>GESTION DE NOTES</title>
    <link rel="shortcut icon" href="aceuil/alienware-normal.ico">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f0f9ff; /* Léger fond bleu pour un contraste doux */
        }
        .header-color {
            background-color: #f1c40f; /* Jaune */
            color: #1abc9c; /* Vert citron */
            padding: 10px 0;
            border-bottom: 5px solid #1abc9c; /* Bordure en vert citron */
        }
        .btn-custom {
            background-color: black; 
            color: white;
            font-size: 18px;
            border-radius: 6px;
            padding: 12px 24px;
        }
        .btn-custom:hover {
            background-color: blueviolet; 
            color: black; 
        }
        .link-decor {
            color: black;
        }
        .link-decor:hover {
            color: aquamarine; 
        }
        .row {
            justify-content: space-between;
            display: flex;
        }
        .dori {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <!-- Bannière -->
    <?php include('ban.php'); ?>
    <!-- Fin bannière -->

    <!-- Contenu principal -->
    <div class="container mt-5">
        <center><h1>Bienvenue dans le système de gestion des notes de IAI-CMR</h1></center> 
        <section class="about mt-5">
            <div class="row">
                <div class="col-md-4 col-lg-4 col-xs-12 col-sm-12 mb-4">
                    <h2>A Propos de nous</h2>
                    <p>Nous sommes un groupe d'étudiants de niveau 2 en informatique à l'Institut Africain d'Informatique (IAI) au Cameroun. Dans le cadre de notre formation, nous avons développé une application de gestion de notes pour notre université.</p>
                    <p>Notre objectif est de faciliter la vie du personnel administratif en leur offrant un outil simple et efficace pour la gestion des notes. Grâce à cette application, les professeurs et le personnel peuvent saisir et partager les notes de manière numérique.</p>
                    <p>Notre équipe est composée de cinq membres passionnés et engagés. N'hésitez pas à nous contacter pour en savoir plus sur notre projet!</p>
                </div>
                <div class="col-md-4 col-lg-4 col-xs-12 col-sm-12 mb-4">
                    <h2>Généralité sur l'application</h2>
                    <p>Notre application de gestion de notes vous permet de garder une trace de vos idées, réflexions et listes en un seul endroit. Avec des fonctionnalités simples et intuitives, vous pouvez :</p>
                    <ul>
                        <li>Créer facilement de nouvelles notes</li>
                        <li>Organiser vos notes dans différents cahiers ou dossiers</li>
                        <li>Rechercher rapidement une note grâce à des filtres</li>
                        <li>Partager facilement des notes avec vos collègues</li>
                    </ul>
                    <p>Notre application est conçue pour vous aider à garder le cap et à vous concentrer sur ce qui compte vraiment. Téléchargez-la dès aujourd'hui pour booster votre productivité !</p>
                </div>
                <div class="col-md-4 col-lg-4 col-xs-12 col-sm-12 mb-4">
                    <h2>Fonctionnalités</h2>
                    <p>Gérez vos notes facilement avec notre application. Notre application vous permet de garder une trace de vos idées, réflexions et listes en un seul endroit. Avec des fonctionnalités simples et intuitives, vous pouvez :</p>
                    <ul>
                        <li>Créer facilement de nouvelles notes</li>
                        <li>Organiser vos notes dans différents cahiers ou dossiers</li>
                        <li>Rechercher rapidement une note grâce à des filtres</li>
                        <li>Partager facilement des notes avec vos collègues</li>
                    </ul>
                    <p>Téléchargez notre application aujourd'hui et découvrez comment elle peut améliorer votre productivité.</p>
                </div>
            </div>
            <div class="dori">
                <?php if ($userLoggedIn): ?>
                    <p>Bonjour, <?= htmlspecialchars($username) ?>!</p>
                    <a href="admin_dashboard.php" class="btn btn-custom">Tableau de bord Admin</a>
                    <a href="teacher_dashboard.php" class="btn btn-custom">Tableau de bord Enseignant</a>
                    <a href="logout.php" class="btn btn-danger btn-custom">Déconnexion</a>
                <?php else: ?>
                    <p>Pour accéder à vos outils de gestion, veuillez vous <a href="test.php" class="btn btn-custom">connecter</a> ou <a href="cree_compte.php" class="btn btn-custom">créer un compte</a>.</p>
                <?php endif; ?>
            </div>
        </section>
    </div>
    <!-- Fin contenu principal -->
</body>
</html>
