<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';
checkAuth('enseignant');

// Fetch Classes assigned to this teacher
$stmt = $pdo->prepare("
    SELECT cm.*, c.nom as classe_nom, m.nom as matiere_nom 
    FROM classe_matieres cm
    JOIN classes c ON cm.classe_id = c.id
    JOIN matieres m ON cm.matiere_id = m.id
    WHERE cm.enseignant_id = ?
");
$stmt->execute([$_SESSION['user_id']]);
$assignments = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Enseignant - LTD</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <nav class="navbar-container">
        <div class="navbar-wrapper">
            <a href="dashboard.php" class="navbar-logo">
                <div class="logo-icon"><i class="fas fa-graduation-cap"></i></div>
                <div class="logo-text"><span class="logo-title">LTD Enseignant</span></div>
            </a>
            <div class="user-profile">
                <span>Bienvenue, <?php echo $_SESSION['nom_complet']; ?></span>
                <a href="../auth/logout.php" class="btn btn-primary btn-sm"><i class="fas fa-sign-out-alt"></i></a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="breadcrumbs">
            <a href="dashboard.php">Accueil</a> <i class="fas fa-chevron-right"></i> <span>Mes Classes</span>
        </div>

        <div class="header">
            <h1><i class="fas fa-chalkboard-teacher"></i> Mes Classes & Matières</h1>
        </div>

        <div class="student-grid">
            <?php foreach($assignments as $assign): ?>
            <a href="notes.php?assignment_id=<?php echo $assign['id']; ?>" class="student-card clickable-card" style="display: block; color: inherit;">
                <div class="flex items-center gap-4 mb-4">
                    <div class="logo-icon" style="width: 50px; height: 50px;"><i class="fas fa-book"></i></div>
                    <div>
                        <div style="font-weight: bold; font-size: 1.1rem;"><?php echo htmlspecialchars($assign['classe_nom']); ?></div>
                        <div style="color: var(--text-light); font-size: 0.9rem;"><?php echo htmlspecialchars($assign['matiere_nom']); ?></div>
                    </div>
                </div>
                <div class="btn btn-primary btn-full" style="width: 100%;">
                    <i class="fas fa-edit"></i> Saisir les notes
                </div>
            </a>
            <?php endforeach; ?>
            
            <?php if(empty($assignments)): ?>
            <div class="card" style="width: 100%; grid-column: 1/-1;">
                <div class="card-body text-center">
                    <p>Aucune classe assignée pour le moment.</p>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
