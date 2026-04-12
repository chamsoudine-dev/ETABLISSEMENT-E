<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';
checkAuth('enseignant');

$assignmentId = $_GET['assignment_id'] ?? null;
if (!$assignmentId) { header('Location: dashboard.php'); exit(); }

// Verify assignment belongs to teacher
$stmt = $pdo->prepare("
    SELECT cm.*, c.nom as classe_nom, m.nom as matiere_nom 
    FROM classe_matieres cm
    JOIN classes c ON cm.classe_id = c.id
    JOIN matieres m ON cm.matiere_id = m.id
    WHERE cm.id = ? AND cm.enseignant_id = ?
");
$stmt->execute([$assignmentId, $_SESSION['user_id']]);
$assign = $stmt->fetch();

if (!$assign) { header('Location: dashboard.php'); exit(); }

// Fetch Students in this class
$stmt = $pdo->prepare("
    SELECT e.*, i.matricule, i.id as inscription_id
    FROM eleves e
    JOIN inscriptions i ON e.id = i.eleve_id
    WHERE i.classe_id = ? AND i.statut = 'Inscrit'
    ORDER BY e.nom ASC
");
$stmt->execute([$assign['classe_id']]);
$students = $stmt->fetchAll();

// Handle Save
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $trimestre = $_POST['trimestre'] ?? '1er';
    $type = $_POST['type_note'] ?? 'classe';
    
    foreach ($_POST['notes'] as $insId => $value) {
        if ($value === '') continue;
        
        $stmt = $pdo->prepare("
            INSERT INTO notes (inscription_id, classe_matiere_id, trimestre, type_note, note)
            VALUES (?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE note = VALUES(note)
        ");
        $stmt->execute([$insId, $assignmentId, $trimestre, $type, $value]);
    }
    $success = "Notes enregistrées avec succès !";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saisie des Notes - LTD</title>
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
                <a href="dashboard.php" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Retour</a>
                <a href="../auth/logout.php" class="btn btn-primary btn-sm"><i class="fas fa-sign-out-alt"></i></a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="breadcrumbs">
            <a href="dashboard.php">Accueil</a> <i class="fas fa-chevron-right"></i> 
            <a href="dashboard.php">Mes Classes</a> <i class="fas fa-chevron-right"></i> 
            <span>Saisie des Notes</span>
        </div>

        <div class="header">
            <h1><i class="fas fa-edit"></i> <?php echo htmlspecialchars($assign['matiere_nom'] . ' - ' . $assign['classe_nom']); ?></h1>
        </div>

        <?php if(isset($success)): ?>
            <div style="background: #e8f5e8; color: var(--success); padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                <i class="fas fa-check-circle"></i> <?php echo $success; ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="flex gap-4">
                        <div style="flex: 1;">
                            <label>Trimestre</label>
                            <select name="trimestre" class="btn btn-secondary" style="width: 100%; text-align: left;">
                                <option value="1er">1er Trimestre</option>
                                <option value="2e">2e Trimestre</option>
                                <option value="3e">3e Trimestre</option>
                            </select>
                        </div>
                        <div style="flex: 1;">
                            <label>Type d'évaluation</label>
                            <select name="type_note" class="btn btn-secondary" style="width: 100%; text-align: left;">
                                <option value="classe">Note de Classe (Devoir/Interro)</option>
                                <option value="composition">Composition</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Matricule</th>
                            <th>Nom complet</th>
                            <th>Note /20</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($students as $student): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($student['matricule']); ?></td>
                            <td><?php echo htmlspecialchars($student['prenom'] . ' ' . $student['nom']); ?></td>
                            <td>
                                <input type="number" step="0.25" min="0" max="20" name="notes[<?php echo $student['inscription_id']; ?>]" 
                                       placeholder="..." style="width: 80px; padding: 8px; border: 1px solid var(--border); border-radius: 4px;">
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4 text-center">
                <button type="submit" class="btn btn-primary" style="padding: 15px 40px;">
                    <i class="fas fa-save"></i> Enregistrer toutes les notes
                </button>
            </div>
        </form>
    </div>
</body>
</html>
