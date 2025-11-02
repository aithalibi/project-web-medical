<header class="main-header">
    <div class="container header-content">
        <a href="accueil.php" class="logo">
            <i class="fas fa-heartbeat"></i>
            <span>Clinique Médicale</span>
        </a>
        
        <nav>
            <ul class="nav-menu">
                <li><a href="accueil.php" class="active"><i class="fas fa-home"></i> Accueil</a></li>
                <li><a href="rendezvous.php"><i class="fas fa-calendar"></i> Rendez-vous</a></li>
                <li><a href="dossier-medical.php"><i class="fas fa-folder-open"></i> Mon Dossier</a></li>
               
            </ul>
        </nav>
        
        <div class="user-actions">
            <div class="user-profile">
                <div class="user-avatar">
                    <?php 
                    $initials = '';
                    $names = explode(' ', $user_name);
                    foreach ($names as $name) {
                        $initials .= strtoupper(substr($name, 0, 1));
                    }
                    echo $initials;
                    ?>
                </div>
                <span><?php echo htmlspecialchars($user_name); ?></span>
            </div>
            <a href="auth.php" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i> Déconnexion
            </a>
        </div>
    </div>
</header>