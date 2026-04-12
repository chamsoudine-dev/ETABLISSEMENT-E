<?php require_once '../includes/functions.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Élève - LTD</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="bg-light">
    <div class="container" style="max-width: 500px; margin-top: 100px;">
        <div class="card">
            <div class="card-header text-center">
                <h3><i class="fas fa-user-graduate"></i> Portail Élève</h3>
                <p>Consultez vos notes et bulletins</p>
            </div>
            <div class="card-body">
                <?php if(isset($_GET['error'])): ?>
                    <div style="background: #ffeaea; color: var(--danger); padding: 10px; border-radius: 5px; margin-bottom: 20px;">
                        <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($_GET['error']); ?>
                    </div>
                <?php endif; ?>

                <form action="../auth/student_login_process.php" method="POST">
                    <div class="form-group mb-4">
                        <label>Numéro de Matricule</label>
                        <input type="text" name="matricule" placeholder="Ex: LTD-2024-0001" required 
                               style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 6px;">
                    </div>
                    <div class="form-group mb-4">
                        <label>Clé Secrète (Mot de passe)</label>
                        <input type="password" name="password" placeholder="••••••••" required 
                               style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 6px;">
                    </div>
                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 12px;">
                        <i class="fas fa-sign-in-alt"></i> Se Connecter
                    </button>
                </form>
            </div>
            <div class="card-footer text-center">
                <a href="../login.php" class="text-primary" style="font-size: 0.9rem;">Retour à l'espace personnel / enseignant</a>
            </div>
        </div>
    </div>
</body>
</html>
