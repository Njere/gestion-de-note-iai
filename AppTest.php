<?php

use PHPUnit\Framework\TestCase;

class AppTest extends TestCase
{
    private $pdo;

    protected function setUp(): void
    {
        $host = 'localhost';
        $dbname = 'gestion_notess';
        $username = 'root';
        $password = '';

        $this->pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    public function testDatabaseConnection()
    {
        $this->assertInstanceOf(PDO::class, $this->pdo);
    }

    public function testInsertUser()
    {
        $sql = "INSERT INTO users (nom, email, sex, mdp, poste) VALUES (:nom, :email, :sex, :mdp, :poste)";
        $stmt = $this->pdo->prepare($sql);

        $nom = 'Test User';
        $email = 'test@example.com';
        $sex = 'M';
        $mdp = password_hash('password123', PASSWORD_DEFAULT);
        $poste = 'DAA';

        $stmt->execute([
            ':nom' => $nom,
            ':email' => $email,
            ':sex' => $sex,
            ':mdp' => $mdp,
            ':poste' => $poste
        ]);

        $this->assertTrue($stmt->rowCount() > 0);

        // Clean up
        $sql = "DELETE FROM users WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':email' => $email]);
    }

    public function testUserLogin()
    {
        // Insert test user
        $sql = "INSERT INTO users (nom, email, sex, mdp, poste) VALUES (:nom, :email, :sex, :mdp, :poste)";
        $stmt = $this->pdo->prepare($sql);

        $nom = 'Login User';
        $email = 'login@example.com';
        $sex = 'F';
        $mdp = password_hash('password456', PASSWORD_DEFAULT);
        $poste = 'DSR';

        $stmt->execute([
            ':nom' => $nom,
            ':email' => $email,
            ':sex' => $sex,
            ':mdp' => $mdp,
            ':poste' => $poste
        ]);

        // Test login
        $sql = "SELECT * FROM users WHERE nom = :nom";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':nom' => $nom]);
        $user = $stmt->fetch();

        $this->assertNotEmpty($user);
        $this->assertTrue(password_verify('password456', $user['mdp']));

        // Clean up
        $sql = "DELETE FROM users WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':email' => $email]);
    }

    public function testInsertPendingGrade()
    {
        $sql = "INSERT INTO pending_grades (student_id, teacher_id, course, grade) VALUES (:student_id, :teacher_id, :course, :grade)";
        $stmt = $this->pdo->prepare($sql);

        $student_id = 1;
        $teacher_id = 1;
        $course = 'Math';
        $grade = 'A';

        $stmt->execute([
            ':student_id' => $student_id,
            ':teacher_id' => $teacher_id,
            ':course' => $course,
            ':grade' => $grade
        ]);

        $this->assertTrue($stmt->rowCount() > 0);

        // Clean up
        $sql = "DELETE FROM pending_grades WHERE student_id = :student_id AND course = :course";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':student_id' => $student_id, ':course' => $course]);
    }

    public function testValidatePendingGrade()
    {
        // Insert test pending grade
        $sql = "INSERT INTO pending_grades (student_id, teacher_id, course, grade) VALUES (:student_id, :teacher_id, :course, :grade)";
        $stmt = $this->pdo->prepare($sql);

        $student_id = 1;
        $teacher_id = 1;
        $course = 'Math';
        $grade = 'A';

        $stmt->execute([
            ':student_id' => $student_id,
            ':teacher_id' => $teacher_id,
            ':course' => $course,
            ':grade' => $grade
        ]);

        // Retrieve the inserted pending grade
        $sql = "SELECT * FROM pending_grades WHERE student_id = :student_id AND course = :course";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':student_id' => $student_id, ':course' => $course]);
        $pending_grade = $stmt->fetch();

        $this->assertNotEmpty($pending_grade);

        // Insert the grade into grades table
        $sql_insert = "INSERT INTO grades (student_id, teacher_id, course, grade) VALUES (:student_id, :teacher_id, :course, :grade)";
        $stmt_insert = $this->pdo->prepare($sql_insert);
        $stmt_insert->execute([
            ':student_id' => $pending_grade['student_id'],
            ':teacher_id' => $pending_grade['teacher_id'],
            ':course' => $pending_grade['course'],
            ':grade' => $pending_grade['grade']
        ]);

        $this->assertTrue($stmt_insert->rowCount() > 0);

        // Clean up
        $sql_delete = "DELETE FROM grades WHERE student_id = :student_id AND course = :course";
        $stmt_delete = $this->pdo->prepare($sql_delete);
        $stmt_delete->execute([':student_id' => $student_id, ':course' => $course]);

        $sql_delete = "DELETE FROM pending_grades WHERE student_id = :student_id AND course = :course";
        $stmt_delete = $this->pdo->prepare($sql_delete);
        $stmt_delete->execute([':student_id' => $student_id, ':course' => $course]);
    }

    public function testInsertTeacher()
    {
        $sql = "INSERT INTO teachers (nom_prenom, email, mdp, matiere) VALUES (:nom_prenom, :email, :mdp, :matiere)";
        $stmt = $this->pdo->prepare($sql);

        $nom_prenom = 'Test Teacher';
        $email = 'teacher@example.com';
        $mdp = password_hash('password789', PASSWORD_DEFAULT);
        $matiere = 'Science';

        $stmt->execute([
            ':nom_prenom' => $nom_prenom,
            ':email' => $email,
            ':mdp' => $mdp,
            ':matiere' => $matiere
        ]);

        $this->assertTrue($stmt->rowCount() > 0);

        // Clean up
        $sql = "DELETE FROM teachers WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':email' => $email]);
    }
}
?>
