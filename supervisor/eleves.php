<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';
checkAuth('personnels_admin');

$stmt = $pdo->query("
    SELECT e.*, c.nom as classe_nom 
    FROM eleves e
    LEFT JOIN inscriptions i ON e.id = i.eleve_id
    LEFT JOIN classes c ON i.classe_id = c.id
    ORDER BY c.nom, e.nom
");
$eleves = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste Élèves - LTD</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <nav class="navbar-container">
        <div class="navbar-wrapper">
            <a href="dashboard.php" class="navbar-logo">
                <div class="logo-icon"><i class="fas fa-users"></i></div>
                <div class="logo-text"><span class="logo-title">Suivi Élèves</span></div>
            </a>
            <div class="user-profile">
                <a href="dashboard.php" class="btn btn-secondary btn-sm">Retour</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="breadcrumbs">
            <a href="dashboard.php">Accueil</a> <i class="fas fa-chevron-right"></i> <span>Liste des Élèves</span>
        </div>

        <div class="card">
            <div class="card-header"><h6>Tous les élèves inscrits</h6></div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nom & Prénom</th>
                            <th>Classe</th>
                            <th>Sexe</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($eleves as $e): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($e['prenom'] . ' ' . $e['nom']); ?></td>
                            <td><?php echo htmlspecialchars($e['classe_nom'] ?? 'Non assigné'); ?></td>
                            <td><?php echo $e['sexe']; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
