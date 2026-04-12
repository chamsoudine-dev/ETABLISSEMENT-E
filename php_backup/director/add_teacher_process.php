<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';
checkAuth('admin');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'] ?? '';
    $prenom = $_POST['prenom'] ?? '';
    $telephone = $_POST['telephone'] ?? '';
    $password = password_hash($_POST['password'] ?? '123456', PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO users (nom, prenom, telephone, password, role) VALUES (?, ?, ?, ?, 'enseignant')");
        $stmt->execute([$nom, $prenom, $telephone, $password]);
        
        header('Location: dashboard.php?success=Enseignant ajouté');
        exit();
    } catch (\PDOException $e) {
        header('Location: dashboard.php?error=Erreur lors de l\'ajout');
        exit();
    }
}
?>
