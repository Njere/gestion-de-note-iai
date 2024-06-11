<!DOCTYPE html>
<html>
<head>
    <title>Fiche de Notes</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 15px;
        }

        th, td {
            text-align: left;
            padding: 8px;
            border: 1px solid black;
        }

        th {
            background-color: #f2f2f2;
        }
        .form-group{
            display: inline;
            justify-content: space-between;
        }
        .submit{
            margin-top: 15px;
        }
    </style>
    <script>
        function addRow() {
            var table = document.getElementById("notesTable");
            var newRow = table.insertRow();

            // Créer les cellules de la nouvelle ligne
            var cell1 = newRow.insertCell();
            var cell2 = newRow.insertCell();
            var cell3 = newRow.insertCell();
            var cell4 = newRow.insertCell();
            var cell5 = newRow.insertCell();
            var cell6 = newRow.insertCell();
            var cell7 = newRow.insertCell();
            var cell8 = newRow.insertCell();

            // Ajouter les champs de saisie dans les cellules
            cell1.innerHTML = "<input type='text' name='etudiant[]' placeholder='Nom'>";
            cell2.innerHTML = "<input type='text' name='prenom[]' placeholder='Prénom'>";
            cell3.innerHTML = "<input type='text' name='filiere[]' placeholder='Filière'>";
            cell4.innerHTML = "<input type='text' name='matiere[]' placeholder='Matière'>";
            cell5.innerHTML = "<input type='text' name='enseignant[]' placeholder='Enseignant'>";
            cell6.innerHTML = "<input type='number' name='note1[]' placeholder='Note 1'>";
            cell7.innerHTML = "<input type='number' name='note2[]' placeholder='Note 2'>";
            cell8.innerHTML = "<input type='number' name='note3[]' placeholder='Note 3'>";
        }
    </script>
</head>
<body>

<h2>Fiche de Notes</h2>

<form method="post" action="insert.php">
    <div class="form-group">
        <label for="enseignant_id">ID Enseignant</label>
        <input type="text" class="form-control" id="enseignant_id" name="enseignant_id" required>
    </div>
    <div class="form-group">
        <label for="nom_ens">Nom&Prénom</label>
        <input type="text" class="form-control" id="Nom&Prénom" name="Nom&Prénom" required>
    </div>
    <div class="form-group">
        <label for="course">matière</label>
        <input type="text" class="form-control" id="Matière" name="Matière" required>
    </div>
    <div class="form-group">
        <label for="classe">Classe</label>
        <input type="text" class="form-control" id="classe" name="Classe" required>
    </div>

    <table id="notesTable">
        <thead>
        <tr>
            <th>Étudiant</th>
            <th>Prénom</th>
            <th>Matricule</th>
            <th>Matière</th>
            <th>Enseignant</th>
            <th>Note 1</th>
            <th>Note 2</th>
            <th>Note 3</th>
        </tr>
        </thead>
        <tbody>
        <!-- Ligne initiale -->
        <tr>
            <td><input type="text" name="etudiant[]" placeholder="Nom"></td>
            <td><input type="text" name="prenom[]" placeholder="Prénom"></td>
            <td><input type="text" name="matricule[]" placeholder="Matricule"></td>
            <td><input type="text" name="filiere[]" placeholder="Filière"></td>
            <td><input type="text" name="matiere[]" placeholder="Matière"></td>
            <td><input type="text" name="enseignant[]" placeholder="Enseignant"></td>
            <td><input type="text" name="note1[]" placeholder="Note 1"></td>
            <td><input type='text' name='note2[]' placeholder='Note 2'></td>
            <td><input type='text' name='note3[]' placeholder='Note 3'></td>
        </tr>
        </tbody>
    </table>

        <div class="submit">
            <button type="button" onclick="addRow()">Ajouter une ligne</button>
            <input type="submit" value="Enregistrer">
            <input type="submit" value="Envoyer">
        </div>
</form>


</body>
</html>