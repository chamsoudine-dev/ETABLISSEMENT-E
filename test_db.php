<?php
// LTD - Test de connexion WAMP
require_once 'includes/db.php';

try {
    $stmt = $pdo->query("SELECT DATABASE()");
    $dbName = $stmt->fetchColumn();
    echo "<div style='padding: 20px; background: #e8f5e8; color: #27ae60; border: 1px solid #27ae60; border-radius: 8px; font-family: sans-serif;'>";
    echo "<h3>✅ Succès !</h3>";
    echo "Connexion à la base de données <strong>$dbName</strong> réussie.<br>";
    echo "Votre serveur WAMP est prêt pour le système LTD.";
    echo "</div>";
} catch (Exception $e) {
    echo "<div style='padding: 20px; background: #ffeaea; color: #e74c3c; border: 1px solid #e74c3c; border-radius: 8px; font-family: sans-serif;'>";
    echo "<h3>❌ Erreur de connexion</h3>";
    echo "Message : " . $e->getMessage() . "<br><br>";
    echo "<strong>Vérifiez que :</strong><br>";
    echo "1. WAMP est lancé (icône verte).<br>";
    echo "2. La base de données 'gestion_bulletins' existe dans PHPMyAdmin.<br>";
    echo "3. L'utilisateur 'root' n'a pas de mot de passe (ou modifiez includes/db.php).";
    echo "</div>";
}
?>
