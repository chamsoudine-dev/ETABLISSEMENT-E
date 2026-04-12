<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';
checkAuth('admin');

$teacher_id = $_GET['teacher_id'] ?? null;
if (!$teacher_id) { header('Location: dashboard.php'); exit(); }

// Fetch Teacher Info
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ? AND role = 'enseignant'");
$stmt->execute([$teacher_id]);
$teacher = $stmt->fetch();
if (!$teacher) { header('Location: dashboard.php'); exit(); }

// Handle Assignment
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $classe_id = $_POST['classe_id'];
    $matiere_id = $_POST['matiere_id'];
    
    try {
        $stmt = $pdo->prepare("INSERT INTO classe_matieres (classe_id, matiere_id, enseignant_id) VALUES (?, ?, ?)");
        $stmt->execute([$classe_id, $matiere_id, $teacher_id]);
        $success = "Assignation réussie !";
    } catch (Exception $e) {
        $error = "Cette assignation existe déjà ou une erreur est survenue.";
    }
}

// Fetch Classes and Subjects
$classes = $pdo->query("SELECT * FROM classes ORDER BY nom")->fetchAll();
$matieres = $pdo->query("SELECT * FROM matieres ORDER BY nom")->fetchAll();

// Fetch Current Assignments
$stmt = $pdo->prepare("
    SELECT cm.*, c.nom as classe_nom, m.nom as matiere_nom 
    FROM classe_matieres cm
    JOIN classes c ON cm.classe_id = c.id
    JOIN matieres m ON cm.matiere_id = m.id
    WHERE cm.enseignant_id = ?
");
$stmt->execute([$teacher_id]);
$current_assignments = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Assignation - LTD</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <nav class="navbar-container">
        <div class="navbar-wrapper">
            <a href="dashboard.php" class="navbar-logo">
                <div class="logo-icon"><i class="fas fa-link"></i></div>
                <div class="logo-text"><span class="logo-title">Assignation</span></div>
            </a>
            <div class="user-profile">
                <a href="dashboard.php" class="btn btn-secondary btn-sm">Retour</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="breadcrumbs">
            <a href="dashboard.php">Accueil</a> <i class="fas fa-chevron-right"></i> <span>Assignation : <?php echo htmlspecialchars($teacher['prenom'] . ' ' . $teacher['nom']); ?></span>
        </div>

        <div class="card mb-4">
            <div class="card-header"><h6>Assigner une nouvelle classe/matière</h6></div>
            <div class="card-body">
                <?php if(isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>
                <?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
                
                <form method="POST" class="flex gap-4 items-end">
                    <div class="form-group flex-1">
                        <label>Classe</label>
                        <select name="classe_id" class="form-control" required style="width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 5px;">
                            <?php foreach($classes as $c): ?>
                                <option value="<?php echo $c['id']; ?>"><?php echo htmlspecialchars($c['nom']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group flex-1">
                        <label>Matière</label>
                        <select name="matiere_id" class="form-control" required style="width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 5px;">
                            <?php foreach($matieres as $m): ?>
                                <option value="<?php echo $m['id']; ?>"><?php echo htmlspecialchars($m['nom']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Assigner</button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><h6>Classes assignées à cet enseignant</h6></div>
            <div class="card-body">
                <table class="table">
                    <thead><tr><th>Classe</th><th>Matière</th></tr></thead>
                    <tbody>
                        <?php foreach($current_assignments as $ca): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($ca['classe_nom']); ?></td>
                            <td><?php echo htmlspecialchars($ca['matiere_nom']); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
