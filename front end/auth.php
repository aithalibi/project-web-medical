<?php
session_start();

// Structure pour connexion future au backend
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['login'])) {
        // TODO: Vérifier les identifiants avec la base de données
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        
        // Simulation de connexion réussie (à remplacer par vraie validation)
        $_SESSION['user_id'] = 1;
        $_SESSION['user_name'] = 'Patient';
        header('Location: accueil.php');
        exit();
    }
    
    if (isset($_POST['register'])) {
        // TODO: Insérer nouvel utilisateur dans la base de données
        $nom = $_POST['nom'] ?? '';
        $prenom = $_POST['prenom'] ?? '';
        $email = $_POST['email_register'] ?? '';
        $telephone = $_POST['telephone'] ?? '';
        $password = $_POST['password_register'] ?? '';
        
        // Simulation d'inscription réussie
        $_SESSION['user_id'] = 2;
        $_SESSION['user_name'] = $prenom . ' ' . $nom;
        header('Location: accueil.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clinique Médicale - Connexion</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body class="auth-page">
    <div class="auth-container">
        <div class="auth-left">
            <div class="auth-branding">
                <i class="fas fa-heartbeat"></i>
                <h1>Clinique Médicale</h1>
                <p>Votre santé, notre priorité</p>
            </div>
            <div class="auth-illustration">
                <i class="fas fa-user-md"></i>
            </div>
        </div>
        
        <div class="auth-right">
            <div class="auth-forms">
                <!-- Formulaire de Connexion -->
                <div class="form-container active" id="login-form">
                    <h2><i class="fas fa-sign-in-alt"></i> Connexion</h2>
                    <p class="form-subtitle">Accédez à votre espace patient</p>
                    
                    <form method="POST" action="">
                        <div class="form-group">
                            <label for="email">
                                <i class="fas fa-envelope"></i> Email
                            </label>
                            <input type="email" id="email" name="email" required placeholder="votre@email.com">
                        </div>
                        
                        <div class="form-group">
                            <label for="password">
                                <i class="fas fa-lock"></i> Mot de passe
                            </label>
                            <input type="password" id="password" name="password" required placeholder="••••••••">
                        </div>
                        
                        <div class="form-options">
                            <label class="checkbox-container">
                                <input type="checkbox" name="remember">
                                <span>Se souvenir de moi</span>
                            </label>
                            <a href="#" class="forgot-password">Mot de passe oublié?</a>
                        </div>
                        
                        <button type="submit" name="login" class="btn btn-primary">
                            <i class="fas fa-sign-in-alt"></i> Se connecter
                        </button>
                    </form>
                    
                    <div class="form-switch">
                        <p>Pas encore de compte? <a href="#" onclick="switchForm('register'); return false;">Inscrivez-vous</a></p>
                    </div>
                </div>
                
                <!-- Formulaire d'Inscription -->
                <div class="form-container" id="register-form">
                    <h2><i class="fas fa-user-plus"></i> Inscription</h2>
                    <p class="form-subtitle">Créez votre compte patient</p>
                    
                    <form method="POST" action="">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="nom">
                                    <i class="fas fa-user"></i> Nom
                                </label>
                                <input type="text" id="nom" name="nom" required placeholder="Nom">
                            </div>
                            
                            <div class="form-group">
                                <label for="prenom">
                                    <i class="fas fa-user"></i> Prénom
                                </label>
                                <input type="text" id="prenom" name="prenom" required placeholder="Prénom">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="email_register">
                                <i class="fas fa-envelope"></i> Email
                            </label>
                            <input type="email" id="email_register" name="email_register" required placeholder="votre@email.com">
                        </div>
                        
                        <div class="form-group">
                            <label for="telephone">
                                <i class="fas fa-phone"></i> Téléphone
                            </label>
                            <input type="tel" id="telephone" name="telephone" required placeholder="06 12 34 56 78">
                        </div>
                        
                        <div class="form-group">
                            <label for="password_register">
                                <i class="fas fa-lock"></i> Mot de passe
                            </label>
                            <input type="password" id="password_register" name="password_register" required placeholder="••••••••">
                        </div>
                        
                        <div class="form-group">
                            <label for="password_confirm">
                                <i class="fas fa-lock"></i> Confirmer le mot de passe
                            </label>
                            <input type="password" id="password_confirm" name="password_confirm" required placeholder="••••••••">
                        </div>
                        
                        <div class="form-options">
                            <label class="checkbox-container">
                                <input type="checkbox" name="terms" required>
                                <span>J'accepte les conditions d'utilisation</span>
                            </label>
                        </div>
                        
                        <button type="submit" name="register" class="btn btn-primary">
                            <i class="fas fa-user-plus"></i> S'inscrire
                        </button>
                    </form>
                    
                    <div class="form-switch">
                        <p>Déjà un compte? <a href="#" onclick="switchForm('login'); return false;">Connectez-vous</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>