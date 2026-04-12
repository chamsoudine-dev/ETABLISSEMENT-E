<?php
// LTD - Lycée Technologie de Diffa
// Global Helper Functions

session_start();

/**
 * Generate a unique matricule for a new student
 */
function generateMatricule($pdo) {
    $year = date('Y');
    $stmt = $pdo->query("SELECT MAX(id) as max_id FROM inscriptions");
    $row = $stmt->fetch();
    $nextId = ($row['max_id'] ?? 0) + 1;
    return "LTD-" . $year . "-" . str_pad($nextId, 4, '0', STR_PAD_LEFT);
}

/**
 * Check if user is logged in and has correct role
 */
function checkAuth($role = null) {
    if (!isset($_SESSION['user_id'])) {
        header('Location: ../login.php');
        exit();
    }
    if ($role && $_SESSION['role'] !== $role) {
        header('Location: ../login.php?error=Acces refuse');
        exit();
    }
}

/**
 * Hash secret key (password) simple for demo or secure for production
 */
function secureSecret($secret) {
    return password_hash($secret, PASSWORD_DEFAULT);
}
?>
