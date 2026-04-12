<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';
checkAuth('personnels_admin');

// Statistics for supervisor
$stmt = $pdo->query("SELECT COUNT(*) FROM eleves");
$totalEleves = $stmt->fetchColumn();

$stmt = $pdo->query("SELECT COUNT(DISTINCT inscription_id) FROM notes");
$elevesNotes = $stmt->fetchColumn();

$stmt = $pdo->query("SELECT COUNT(*) FROM notes WHERE type_note = 'composition'");
$totalComps = $stmt->fetchColumn();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Surveillant - LTD</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <nav class="navbar-container">
        <div class="navbar-wrapper">
            <a href="dashboard.php" class="navbar-logo">
                <div class="logo-icon"><i class="fas fa-graduation-cap"></i></div>
                <div class="logo-text"><span class="logo-title">LTD Surveillant</span></div>
            </a>
            <div class="user-profile">
                <span>Bienvenue, <?php echo $_SESSION['nom_complet']; ?></span>
                <a href="../auth/logout.php" class="btn btn-primary btn-sm"><i class="fas fa-sign-out-alt"></i></a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="breadcrumbs">
            <a href="dashboard.php">Accueil</a> <i class="fas fa-chevron-right"></i> <span>Statistiques Trimestrielles</span>
        </div>

        <div class="header">
            <h1><i class="fas fa-chart-line"></i> Évolution du Trimestre</h1>
        </div>

        <div class="stats-cards">
            <a href="eleves.php" class="stat-card info clickable-card" style="display: flex; flex-direction: column;">
                <div class="stat-icon bg-info"><i class="fas fa-users"></i></div>
                <div class="stat-number"><?php echo $totalEleves; ?></div>
                <div class="stat-label">Élèves Totaux (Voir liste)</div>
            </a>
            <div class="stat-card success">
                <div class="stat-icon bg-success"><i class="fas fa-check-double"></i></div>
                <div class="stat-number"><?php echo $elevesNotes; ?></div>
                <div class="stat-label">Élèves Évalués</div>
            </div>
            <div class="stat-card warning">
                <div class="stat-icon bg-warning"><i class="fas fa-file-invoice"></i></div>
                <div class="stat-number"><?php echo $totalComps; ?></div>
                <div class="stat-label">Compositions Saisies</div>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><h6>Suivi des Traveaux</h6></div>
            <div class="card-body">
                <p>Progression globale du trimestre en cours : <strong>75%</strong></p>
                <div style="width: 100%; bg-light: #eee; height: 10px; border-radius: 5px; margin-top: 10px;">
                    <div style="width: 75%; background: var(--success); height: 100%; border-radius: 5px;"></div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
