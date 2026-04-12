<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Élèves - LTD</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <nav class="navbar-container">
        <div class="navbar-wrapper">
            <a href="dashboard.html" class="navbar-logo">
                <div class="logo-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div class="logo-text">
                    <span class="logo-title">G Bulletins</span>
                </div>
            </a>

            <div class="nav-links-wrapper">
                <ul class="nav-links-list">
                    <li><a href="dashboard.html" class="nav-link"><i class="fas fa-home"></i> Accueil</a></li>
                    <li><a href="eleves.html" class="nav-link active"><i class="fas fa-users"></i> Inscription</a></li>
                    <li><a href="#" class="nav-link"><i class="fas fa-edit"></i> Notes</a></li>
                    <li><a href="#" class="nav-link"><i class="fas fa-file-alt"></i> Bulletins</a></li>
                </ul>
            </div>

            <div class="user-profile">
                <a href="login.html" class="btn btn-primary"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="header">
            <h1><i class="fas fa-users"></i> Gestion des Élèves & Inscriptions</h1>
            <div class="header-actions">
                <button class="btn btn-primary"><i class="fas fa-user-plus"></i> Nouvel élève</button>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <div class="flex gap-4 items-center">
                    <input type="text" placeholder="Rechercher un élève..."
                        style="flex: 1; padding: 10px; border: 1px solid var(--border); border-radius: 5px;">
                    <select style="padding: 10px; border: 1px solid var(--border); border-radius: 5px;">
                        <option>Toutes les classes</option>
                        <option>6ème A</option>
                        <option>3ème B</option>
                    </select>
                    <button class="btn btn-secondary"><i class="fas fa-filter"></i> Filtrer</button>
                </div>
            </div>
        </div>

        <div class="student-grid">
            <div class="student-card">
                <div class="flex items-center gap-4 mb-4">
                    <div class="logo-icon" style="width: 50px; height: 50px;">MI</div>
                    <div>
                        <div style="font-weight: bold; font-size: 1.1rem;">MOUSSA Ibrahim</div>
                        <div style="color: var(--text-light); font-size: 0.9rem;">Dossier: #2024-001</div>
                    </div>
                </div>
                <div style="font-size: 0.9rem; margin-bottom: 15px;">
                    <div class="flex justify-between mb-2"><span>Classe:</span> <strong>6ème A</strong></div>
                    <div class="flex justify-between mb-2"><span>Genre:</span> <strong>Masculin</strong></div>
                    <div class="flex justify-between"><span>Statut:</span> <strong
                            style="color: var(--success);">Inscrit</strong></div>
                </div>
                <div class="flex gap-2">
                    <button class="btn btn-secondary btn-sm" style="flex: 1;"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-primary btn-sm" style="flex: 1;"><i class="fas fa-file-pdf"></i></button>
                </div>
            </div>

            <div class="student-card">
                <div class="flex items-center gap-4 mb-4">
                    <div class="logo-icon" style="width: 50px; height: 50px; background: #e83e8c;">FS</div>
                    <div>
                        <div style="font-weight: bold; font-size: 1.1rem;">FATIMA Sani</div>
                        <div style="color: var(--text-light); font-size: 0.9rem;">Dossier: #2024-002</div>
                    </div>
                </div>
                <div style="font-size: 0.9rem; margin-bottom: 15px;">
                    <div class="flex justify-between mb-2"><span>Classe:</span> <strong>3ème B</strong></div>
                    <div class="flex justify-between mb-2"><span>Genre:</span> <strong>Féminin</strong></div>
                    <div class="flex justify-between"><span>Statut:</span> <strong
                            style="color: var(--success);">Inscrit</strong></div>
                </div>
                <div class="flex gap-2">
                    <button class="btn btn-secondary btn-sm" style="flex: 1;"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-primary btn-sm" style="flex: 1;"><i class="fas fa-file-pdf"></i></button>
                </div>
            </div>
        </div>
    </div>

    <script src="js/main.js"></script>
</body>

</html>