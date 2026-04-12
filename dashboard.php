<?php
session_start();
require_once 'includes/db.php';
require_once 'includes/functions.php';

// Si l'utilisateur n'est pas connecté, retour au login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Redirection forcée vers les nouveaux bureaux
$role = $_SESSION['role'];

if ($role === 'admin') {
    header('Location: director/dashboard.php');
    exit();
} elseif ($role === 'enseignant') {
    header('Location: teacher/dashboard.php');
    exit();
} elseif ($role === 'personnels_admin') {
    header('Location: supervisor/dashboard.php');
    exit();
} elseif ($role === 'eleve') {
    header('Location: student/dashboard.php');
    exit();
}

// Fallback (par sécurité)
echo "Rôle non reconnu. <a href='auth/logout.php'>Déconnexion</a>";
?>