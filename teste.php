<!DOCTYPE html>
<html>
<head>
    <title>Boutons centrés</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            height: 100vh;
            margin: 0;
            background-image:"aceuil/img/one.jpg";
            background-size: cover;
            height: 100vh;
        }

        .button-container {
            display: flex;
            justify-content: center;
            width: 100%;
            margin: auto;
            
        }

        button {
            padding: 10px 20px;
            font-size: 16px;
            color: white;
            background-color: black;
        }
        button:hover {
            background-color: blueviolet; 
            color: black; 
        }
    </style>
</head>
<body>
<div class="text">
        <p><h1><strong>Bienvenu(e)sur votre page vous souhaitez :</strong></h1></p>
    </div>
    <div class="button-container">
        <a href="teacher_dashboard.php"><button>Continuer le travail</button></a>
    </div>
    <div class="button-container">
        <a href="teacherwork.php"><button>Remplir une Fiche de Note</button></a>
    </div>
</body>
</html>