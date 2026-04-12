<?php
require_once 'includes/db.php';

try {
    $stmt = $pdo->query("DESCRIBE users");
    $columns = $stmt->fetchAll();
    
    echo "<h3>Structure de la table 'users' :</h3>";
    echo "<ul>";
    foreach ($columns as $col) {
        echo "<li><strong>" . $col['Field'] . "</strong> (" . $col['Type'] . ")</li>";
    }
    echo "</ul>";
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
