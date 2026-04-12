<?php
// LTD - Lycée Technologie de Diffa
// Student Authentication Handler

require_once '../includes/db.php';
require_once '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $matricule = $_POST['matricule'] ?? '';
    $password = $_POST['password'] ?? '';

    try {
        // Find inscription by matricule
        $stmt = $pdo->prepare("
            SELECT i.id as inscription_id, i.eleve_id, u.id as user_id, u.password 
            FROM inscriptions i
            JOIN eleves e ON i.eleve_id = e.id
            JOIN users u ON e.user_id = u.id
            WHERE i.matricule = ?
        ");
        $stmt->execute([$matricule]);
        $data = $stmt->fetch();

        if ($data && password_verify($password, $data['password'])) {
            $_SESSION['user_id'] = $data['user_id'];
            $_SESSION['role'] = 'eleve';
            $_SESSION['inscription_id'] = $data['inscription_id'];
            $_SESSION['eleve_id'] = $data['eleve_id'];
            
            header('Location: ../student/dashboard.php');
            exit();
        }

        header('Location: ../student/login.php?error=Matricule ou clé incorrecte');
        exit();

    } catch (\PDOException $e) {
        header('Location: ../student/login.php?error=Erreur serveur');
        exit();
    }
}
?>
