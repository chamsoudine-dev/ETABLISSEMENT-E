<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';
checkAuth('admin');

// Fetch Teachers
$stmt = $pdo->prepare("SELECT * FROM users WHERE role = 'enseignant' ORDER BY nom ASC");
$stmt->execute();
$teachers = $stmt->fetchAll();

// Fetch Classes for assignment
$stmt = $pdo->query("SELECT * FROM classes ORDER BY nom ASC");
$classes = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Directeur - LTD</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <nav class="navbar-container">
        <div class="navbar-wrapper">
            <a href="dashboard.php" class="navbar-logo">
                <div class="logo-icon"><i class="fas fa-graduation-cap"></i></div>
                <div class="logo-text"><span class="logo-title">LTD Directeur</span></div>
            </a>
            <div class="user-profile">
                <span>Bienvenue, <?php echo $_SESSION['nom_complet']; ?></span>
                <a href="../auth/logout.php" class="btn btn-primary btn-sm"><i class="fas fa-sign-out-alt"></i></a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="breadcrumbs">
            <a href="dashboard.php">Accueil</a> <i class="fas fa-chevron-right"></i> <span>Tableau de Bord</span>
        </div>

        <div class="header">
            <h1><i class="fas fa-user-tie"></i> Gestion de l'établissement</h1>
        </div>
        <div class="card mb-4" style="border-top: 5px solid var(--primary);">
            <div class="card-header"><h6 style="font-size: 1.2rem;"><i class="fas fa-plus-circle"></i> AJOUTER UN NOUVEL ENSEIGNANT</h6></div>
            <div class="card-body">
                <p style="color: var(--text-light); margin-bottom: 20px;">Remplissez les champs ci-dessous pour créer l'accès d'un professeur.</p>
                <form action="add_teacher_process.php" method="POST" class="flex gap-4">
                    <input type="text" name="prenom" placeholder="Prénom" required style="flex: 1; padding: 12px; border: 1px solid var(--border); border-radius: 5px;">
                    <input type="text" name="nom" placeholder="Nom de famille" required style="flex: 1; padding: 12px; border: 1px solid var(--border); border-radius: 5px;">
                    <input type="text" name="telephone" placeholder="Numéro de Téléphone" required style="flex: 1; padding: 12px; border: 1px solid var(--border); border-radius: 5px;">
                    <input type="password" name="password" placeholder="Mot de passe" required style="flex: 1; padding: 12px; border: 1px solid var(--border); border-radius: 5px;">
                    <button type="submit" class="btn btn-primary" style="padding: 12px 25px;">
                        <i class="fas fa-save"></i> Enregistrer
                    </button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><h6 style="font-size: 1.2rem;"><i class="fas fa-list"></i> LISTE DES ENSEIGNANTS & ASSIGNATIONS</h6></div>
            <div class="card-body">
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Téléphone</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($teachers as $teacher): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($teacher['prenom'] . ' ' . $teacher['nom']); ?></td>
                                <td><?php echo htmlspecialchars($teacher['telephone']); ?></td>
                                <td>
                                    <a href="assign_class.php?teacher_id=<?php echo $teacher['id']; ?>" class="btn btn-secondary btn-sm">
                                        <i class="fas fa-link"></i> Assigner
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script type="module" src="../js/firebase-config.js"></script>
</body>
</html>
