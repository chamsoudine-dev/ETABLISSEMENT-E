<?php
// LTD - Initialisation du compte Directeur
require_once 'includes/db.php';

$nom = "Directeur";
$prenom = "Admin";
$tel = "0000"; // Identifiant par défaut
$password = password_hash("admin123", PASSWORD_DEFAULT);

try {
    // Étape 0 : Réparation complète du schéma
    $requiredColumns = [
        'nom' => "VARCHAR(255) DEFAULT 'Admin'",
        'prenom' => "VARCHAR(255) DEFAULT ''",
        'telephone' => "VARCHAR(150) UNIQUE",
        'role' => "ENUM('admin', 'personnels_admin', 'enseignant', 'eleve') DEFAULT 'admin'"
    ];

    foreach ($requiredColumns as $col => $definition) {
        $stmt = $pdo->query("SHOW COLUMNS FROM users LIKE '$col'");
        if (!$stmt->fetch()) {
            $pdo->exec("ALTER TABLE users ADD COLUMN $col $definition");
            echo "<div style='color:orange;'>⚠️ Colonne '$col' ajoutée à la table 'users'.</div>";
        }
    }

    // Étape 1 : Gérer le compte admin
    $stmt = $pdo->prepare("SELECT id FROM users WHERE role = 'admin' LIMIT 1");
    $stmt->execute();
    $existingAdmin = $stmt->fetch();

    if ($existingAdmin) {
        // Force update existing admin to known credentials
        $stmt = $pdo->prepare("UPDATE users SET telephone = ?, password = ? WHERE id = ?");
        $stmt->execute([$tel, $password, $existingAdmin['id']]);
        echo "<div style='padding:20px; background:#d1ecf1; color:#0c5460; border-radius:8px;'>";
        echo "<h3>🔄 Compte Admin Réinitialisé !</h3>";
        echo "L'administrateur existant a été mis à jour avec ces codes :<br>";
        echo "<strong>Téléphone :</strong> $tel<br>";
        echo "<strong>Mot de passe :</strong> admin123<br><br>";
        echo "<a href='login.php' style='color:#0c5460; font-weight:bold;'>Aller à la page de connexion</a>";
        echo "</div>";
    } else {
        $stmt = $pdo->prepare("INSERT INTO users (nom, prenom, telephone, password, role) VALUES (?, ?, ?, ?, 'admin')");
        $stmt->execute([$nom, $prenom, $tel, $password]);
        echo "<div style='padding:20px; background:#d4edda; color:#155724; border-radius:8px;'>";
        echo "<h3>✅ Compte Créé !</h3>";
        echo "Utilisez ces codes pour votre première connexion :<br>";
        echo "<strong>Téléphone :</strong> $tel<br>";
        echo "<strong>Mot de passe :</strong> admin123<br><br>";
        echo "<a href='login.php' style='color:#155724; font-weight:bold;'>Aller à la page de connexion</a>";
        echo "</div>";
    }
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
