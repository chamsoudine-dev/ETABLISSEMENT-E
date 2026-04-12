<?php
// LTD - Système de Réparation et Diagnostic
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<body style='font-family: sans-serif; line-height: 1.6; padding: 20px; background: #f4f7f6;'>";
echo "<div style='max-width: 800px; margin: auto; background: white; padding: 30px; border-radius: 12px; shadow: 0 4px 6px rgba(0,0,0,0.1);'>";
echo "<h1 style='color: #2c3e50; border-bottom: 2px solid #3498db; padding-bottom: 10px;'>🛠️ Diagnostic & Réparation LTD</h1>";

try {
    require_once 'includes/db.php';
} catch (Exception $e) {
    checkStep("Connexion au Serveur", false, "WAMP est lancé, mais la base de données <b>'$db'</b> n'existe pas dans PHPMyAdmin.");
    echo "<p>Veuillez ouvrir PHPMyAdmin et vérifier que vous avez bien une base de données nommée <strong>gestion_bulletins</strong>.</p>";
    die("</div></body>");
}

function checkStep($name, $status, $message) {
    $color = $status ? "#27ae60" : "#e74c3c";
    $icon = $status ? "✅" : "❌";
    echo "<div style='margin-bottom: 15px; padding: 10px; border-left: 5px solid $color; background: #fafafa;'>";
    echo "<strong>$icon $name</strong> : $message";
    echo "</div>";
    return $status;
}

// 1. Test PHP
checkStep("Version PHP", true, "Version " . PHP_VERSION . " détectée.");

// 2. Test Base de données
try {
    $pdo->query("SELECT 1");
    checkStep("Base de données", true, "Connexion réussie à 'gestion_bulletins'.");
} catch (Exception $e) {
    checkStep("Base de données", false, "Impossible de se connecter. Erreur : " . $e->getMessage());
    die("</div></body>");
}

// 3. Réparation de la table 'users'
echo "<h3>🔧 Réparation du schéma...</h3>";
$requiredColumns = [
    'nom' => "VARCHAR(255) DEFAULT 'Admin'",
    'prenom' => "VARCHAR(255) DEFAULT ''",
    'telephone' => "VARCHAR(150) UNIQUE",
    'role' => "ENUM('admin', 'personnels_admin', 'enseignant', 'eleve') DEFAULT 'admin'",
    'password' => "VARCHAR(255)"
];

foreach ($requiredColumns as $col => $definition) {
    $stmt = $pdo->query("SHOW COLUMNS FROM users LIKE '$col'");
    if (!$stmt->fetch()) {
        try {
            $pdo->exec("ALTER TABLE users ADD COLUMN $col $definition");
            checkStep("Réparation : $col", true, "La colonne '$col' a été ajoutée.");
        } catch (Exception $e) {
            checkStep("Réparation : $col", false, "Erreur lors de l'ajout : " . $e->getMessage());
        }
    } else {
        checkStep("Schéma : $col", true, "La colonne '$col' est déjà présente.");
    }
}

// 4. Création compte Admin par défaut
$tel = "0000";
$passwordRaw = "admin123";
$passwordHash = password_hash($passwordRaw, PASSWORD_DEFAULT);

$stmt = $pdo->prepare("SELECT id FROM users WHERE role = 'admin' LIMIT 1");
$stmt->execute();
$admin = $stmt->fetch();

if ($admin) {
    $pdo->prepare("UPDATE users SET telephone = ?, password = ? WHERE id = ?")
        ->execute([$tel, $passwordHash, $admin['id']]);
} else {
    $pdo->prepare("INSERT INTO users (nom, prenom, telephone, password, role) VALUES ('Admin', 'LTD', ?, ?, 'admin')")
        ->execute([$tel, $passwordHash]);
}
checkStep("Compte Admin", true, "Compte mis à jour (Tel: <b>$tel</b> / Pass: <b>$passwordRaw</b>)");

echo "<hr>";
echo "<h2>🚀 C'est prêt !</h2>";
echo "<p>Cliquez sur le bouton ci-dessous pour vous connecter :</p>";
echo "<a href='login.php' style='display: inline-block; padding: 12px 24px; background: #3498db; color: white; border-radius: 6px; text-decoration: none; font-weight: bold;'>Aller à la page de Connexion</a>";
echo "<p style='margin-top: 20px; font-size: 0.8rem; color: #7f8c8d;'>Note: Assurez-vous d'utiliser <b>.php</b> dans l'URL (login.php) et non .html.</p>";
echo "</div></body>";
?>
