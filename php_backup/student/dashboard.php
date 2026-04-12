<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';
checkAuth('eleve');

// Fetch student info
$stmt = $pdo->prepare("SELECT * FROM eleves WHERE id = ?");
$stmt->execute([$_SESSION['eleve_id']]);
$eleve = $stmt->fetch();

// Fetch Notes
$stmt = $pdo->prepare("
    SELECT n.*, m.nom as matiere_nom 
    FROM notes n
    JOIN classe_matieres cm ON n.classe_matiere_id = cm.id
    JOIN matieres m ON cm.matiere_id = m.id
    WHERE n.inscription_id = ?
    ORDER BY n.trimestre ASC, m.nom ASC
");
$stmt->execute([$_SESSION['inscription_id']]);
$notes = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Notes - LTD</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <nav class="navbar-container">
        <div class="navbar-wrapper">
            <a href="dashboard.php" class="navbar-logo">
                <div class="logo-icon"><i class="fas fa-graduation-cap"></i></div>
                <div class="logo-text"><span class="logo-title">Espace Élève</span></div>
            </a>
            <div class="user-profile">
                <span><?php echo htmlspecialchars($eleve['prenom'] . ' ' . $eleve['nom']); ?></span>
                <a href="../auth/logout.php" class="btn btn-primary btn-sm"><i class="fas fa-sign-out-alt"></i></a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="breadcrumbs">
            <span>Matricule: <?php echo htmlspecialchars($eleve['user_id'] ? $eleve['lieu_naissance'] : 'LTD-STUDENT' ); ?></span> 
            <i class="fas fa-chevron-right"></i> <span>Mes Notes</span>
        </div>

        <div class="header">
            <h1><i class="fas fa-star"></i> Mes Notes & Résultats</h1>
        </div>

        <div class="card">
            <div class="card-header"><h6>Récapitulatif des notes</h6></div>
            <div class="card-body">
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Trimestre</th>
                                <th>Matière</th>
                                <th>Type</th>
                                <th>Note /20</th>
                                <th>Appréciation</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($notes as $note): ?>
                            <tr>
                                <td><?php echo $note['trimestre']; ?></td>
                                <td><?php echo htmlspecialchars($note['matiere_nom']); ?></td>
                                <td><?php echo $note['type_note'] === 'classe' ? 'Devoir/Interro' : 'Composition'; ?></td>
                                <td style="font-weight: bold; color: <?php echo $note['note'] >= 10 ? 'var(--success)' : 'var(--danger)'; ?>">
                                    <?php echo number_format($note['note'], 2); ?>
                                </td>
                                <td><?php echo htmlspecialchars($note['appreciation'] ?? '-'); ?></td>
                            </tr>
                            <?php endforeach; ?>
                            
                            <?php if(empty($notes)): ?>
                            <tr><td colspan="5" class="text-center">Aucune note disponible pour le moment.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
