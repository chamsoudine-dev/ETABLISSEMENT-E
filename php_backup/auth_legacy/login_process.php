<?php
// LTD - Lycée Technologie de Diffa
// Authentication Handler

require_once '../includes/db.php';
require_once '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $telephone = $_POST['telephone'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($telephone) || empty($password)) {
        header('Location: ../login.php?error=Champs requis');
        exit();
    }

    try {
        // Search in users table (Director, Supervisor, Teacher)
        $stmt = $pdo->prepare("SELECT * FROM users WHERE telephone = ?");
        $stmt->execute([$telephone]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['nom_complet'] = $user['prenom'] . ' ' . $user['nom'];

            // Redirect based on role
            switch ($user['role']) {
                case 'admin':
                    header('Location: ../director/dashboard.php');
                    break;
                case 'personnels_admin':
                    header('Location: ../supervisor/dashboard.php');
                    break;
                case 'enseignant':
                    header('Location: ../teacher/dashboard.php');
                    break;
                default:
                    header('Location: ../login.php?error=Rôle non reconnu');
            }
            exit();
        }

        header('Location: ../login.php?error=Identifiants invalides');
        exit();

    } catch (\PDOException $e) {
        header('Location: ../login.php?error=Erreur serveur');
        exit();
    }
}
?>
