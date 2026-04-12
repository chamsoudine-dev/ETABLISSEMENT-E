<?php require_once 'includes/functions.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - LTD Système Scolaire</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8ed 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .login-container {
            width: 100%;
            max-width: 450px;
            padding: 20px;
        }

        .login-card {
            background: white;
            border-radius: var(--radius-md);
            padding: 40px 35px;
            box-shadow: var(--shadow-lg);
            text-align: center;
        }

        .logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-bottom: 25px;
        }

        .logo-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
        }

        .logo-text {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--secondary);
        }

        .login-header {
            margin-bottom: 30px;
        }

        .login-title {
            font-size: 1.8rem;
            color: var(--secondary);
            margin-bottom: 10px;
            font-weight: 600;
        }

        .login-subtitle {
            color: var(--text-light);
            font-size: 1rem;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
            text-align: left;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--dark);
            font-size: 0.95rem;
        }

        .input-with-icon {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-light);
            font-size: 1.1rem;
        }

        input {
            width: 100%;
            padding: 14px 15px 14px 45px;
            border: 1px solid #e1e5e9;
            border-radius: var(--radius-sm);
            font-size: 1rem;
            transition: all 0.3s;
            background: #fafbfc;
        }

        input:focus {
            outline: none;
            border-color: var(--primary);
            background: white;
            box-shadow: 0 0 0 3px rgba(44, 144, 226, 0.1);
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-light);
            cursor: pointer;
            font-size: 1.1rem;
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            font-size: 0.9rem;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .remember-me input {
            width: auto;
        }

        .forgot-password {
            color: var(--primary);
            font-weight: 500;
        }

        .btn-full {
            width: 100%;
        }

        .login-footer {
            text-align: center;
            margin-top: 25px;
            color: var(--text-light);
            font-size: 0.9rem;
        }

        .login-footer a {
            color: var(--primary);
            font-weight: 500;
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 30px 20px;
            }
            .remember-forgot {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="logo">
                <div class="logo-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div class="logo-text">G-Bulletins</div>
            </div>

            <div class="login-header">
                <h2 class="login-title">Connectez-vous</h2>
                <p class="login-subtitle">Accédez à votre espace personnel</p>
            </div>

            <?php if(isset($_GET['error'])): ?>
                <div style="background: #ffeaea; color: var(--danger); padding: 10px; border-radius: 5px; margin-bottom: 20px; font-size: 0.9rem;">
                    <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($_GET['error']); ?>
                </div>
            <?php endif; ?>

            <form id="loginForm" action="auth/login_process.php" method="POST">
                <div class="mb-4 text-center">
                    <a href="student/login.php" class="btn btn-secondary w-full" style="background: var(--bg-light); color: var(--primary); border: 1px dashed var(--primary);">
                        <i class="fas fa-user-graduate"></i> Accès Portail Élève (Matricule)
                    </a>
                </div>
                <hr style="margin: 20px 0; border: 0; border-top: 1px solid var(--border);">
                <div class="form-group">
                    <label for="telephone">Numéro de téléphone</label>
                    <div class="input-with-icon">
                        <i class="input-icon fas fa-phone"></i>
                        <input type="text" id="telephone" name="telephone" placeholder="+227 99 94 16 56">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <div class="input-with-icon">
                        <i class="input-icon fas fa-lock"></i>
                        <input type="password" id="password" name="password" placeholder="Votre mot de passe">
                        <button type="button" class="password-toggle" id="passwordToggle">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="remember-forgot">
                    <div class="remember-me">
                        <input type="checkbox" id="remember">
                        <label for="remember">Se souvenir de moi</label>
                    </div>
                    <a href="#" class="forgot-password">Mot de passe oublié ?</a>
                </div>

                <button type="submit" class="btn btn-primary btn-full">
                    <i class="fas fa-sign-in-alt"></i> Se connecter
                </button>
            </form>

            <div class="login-footer">
                <p>Vous n'avez pas de compte ? <a href="#">S'inscrire</a></p>
            </div>
        </div>
    </div>

    <script src="js/main.js"></script>
    <script type="module" src="js/firebase-config.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const passwordToggle = document.getElementById('passwordToggle');
            const passwordInput = document.getElementById('password');
            const loginForm = document.getElementById('loginForm');

            passwordToggle.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                passwordToggle.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
            });

            // Le formulaire est maintenant géré par auth/login_process.php en PHP

            // Check Firebase Connection
            if (window.firebaseApp) {
                console.log("Firebase status: Connected to " + window.firebaseApp.options.projectId);
            }
        });
        });
    </script>
</body>
</html>
