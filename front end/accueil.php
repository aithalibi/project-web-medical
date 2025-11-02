<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: auth.php');
    exit();
}

$user_name = $_SESSION['user_name'] ?? 'Patient';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clinique Médicale - Accueil</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include "header.php"; ?>
    
    <main class="main-content">
        <!-- Section Bienvenue -->
        <section class="welcome-section">
            <div class="container">
                <div class="welcome-content">
                    <h1>Bienvenue, <?php echo htmlspecialchars($user_name); ?> !</h1>
                    <p>Accédez rapidement à tous nos services médicaux</p>
                </div>
                <div class="quick-stats">
                    <div class="stat-card">
                        <i class="fas fa-calendar-check"></i>
                        <div class="stat-info">
                            <h3>3</h3>
                            <p>Rendez-vous à venir</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <i class="fas fa-file-medical"></i>
                        <div class="stat-info">
                            <h3>12</h3>
                            <p>Visites effectuées</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <i class="fas fa-prescription-bottle"></i>
                        <div class="stat-info">
                            <h3>2</h3>
                            <p>Ordonnances actives</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Section Services -->
        <section class="services-section">
            <div class="container">
                <h2 class="section-title">Nos Services</h2>
                <div class="services-grid">
                    <a href="rendezvous.php" class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-calendar-plus"></i>
                        </div>
                        <h3>Prendre Rendez-vous</h3>
                        <p>Planifiez votre consultation avec nos médecins spécialistes</p>
                        <span class="service-arrow"><i class="fas fa-arrow-right"></i></span>
                    </a>
                    
                    <a href="docteur.php" class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-user-md"></i>
                        </div>
                        <h3>Consultations</h3>
                        <p>Consultez nos médecins généralistes et spécialistes</p>
                        <span class="service-arrow"><i class="fas fa-arrow-right"></i></span>
                    </a>
                    
                    <a href="analyses.php" class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-flask"></i>
                        </div>
                        <h3>Analyses Médicales</h3>
                        <p>Laboratoire d'analyses et tests médicaux</p>
                        <span class="service-arrow"><i class="fas fa-arrow-right"></i></span>
                    </a>
                    
                    <a href="urgences.php" class="service-card urgent">
                        <div class="service-icon">
                            <i class="fas fa-ambulance"></i>
                        </div>
                        <h3>Urgences</h3>
                        <p>Service d'urgences disponible 24h/24</p>
                        <span class="service-arrow"><i class="fas fa-arrow-right"></i></span>
                    </a>
                    
                    <a href="vaccinations.php" class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-syringe"></i>
                        </div>
                        <h3>Vaccinations</h3>
                        <p>Calendrier vaccinal et rappels</p>
                        <span class="service-arrow"><i class="fas fa-arrow-right"></i></span>
                    </a>
                    
                    <a href="radiologie.php" class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-x-ray"></i>
                        </div>
                        <h3>Radiologie</h3>
                        <p>Examens radiologiques et imagerie médicale</p>
                        <span class="service-arrow"><i class="fas fa-arrow-right"></i></span>
                    </a>
                </div>
            </div>
        </section>
        
        <!-- Section Rendez-vous à venir -->
        <section class="appointments-section">
            <div class="container">
                <h2 class="section-title">Vos Prochains Rendez-vous</h2>
                <div class="appointments-list">
                    <div class="appointment-card">
                        <div class="appointment-date">
                            <span class="day">15</span>
                            <span class="month">Nov</span>
                        </div>
                        <div class="appointment-details">
                            <h4>Dr. Martin Dubois</h4>
                            <p><i class="fas fa-stethoscope"></i> Cardiologie</p>
                            <p><i class="fas fa-clock"></i> 14:30</p>
                        </div>
                        <div class="appointment-actions">
                            <a href="rendez-vous.php?id=1" class="btn-small btn-outline">Détails</a>
                        </div>
                    </div>
                    
                    <div class="appointment-card">
                        <div class="appointment-date">
                            <span class="day">20</span>
                            <span class="month">Nov</span>
                        </div>
                        <div class="appointment-details">
                            <h4>Dr. Sophie Laurent</h4>
                            <p><i class="fas fa-stethoscope"></i> Médecine Générale</p>
                            <p><i class="fas fa-clock"></i> 10:00</p>
                        </div>
                        <div class="appointment-actions">
                            <a href="rendez-vous.php?id=2" class="btn-small btn-outline">Détails</a>
                        </div>
                    </div>
                    
                    <div class="appointment-card">
                        <div class="appointment-date">
                            <span class="day">25</span>
                            <span class="month">Nov</span>
                        </div>
                        <div class="appointment-details">
                            <h4>Laboratoire d'Analyses</h4>
                            <p><i class="fas fa-flask"></i> Prise de sang</p>
                            <p><i class="fas fa-clock"></i> 08:00</p>
                        </div>
                        <div class="appointment-actions">
                            <a href="analyses.php?id=3" class="btn-small btn-outline">Détails</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Section Informations -->
        <section class="info-section">
            <div class="container">
                <div class="info-grid">
                    <div class="info-card">
                        <i class="fas fa-clock"></i>
                        <h3>Horaires d'ouverture</h3>
                        <p>Lun - Ven: 8h00 - 20h00</p>
                        <p>Sam: 9h00 - 18h00</p>
                        <p>Dim: Urgences uniquement</p>
                    </div>
                    
                    <div class="info-card">
                        <i class="fas fa-phone"></i>
                        <h3>Contact</h3>
                        <p>Tel: +212 5XX XX XX XX</p>
                        <p>Email: contact@clinique.ma</p>
                        <p>Urgences: +212 5XX XX XX XX</p>
                    </div>
                    
                    <div class="info-card">
                        <i class="fas fa-map-marker-alt"></i>
                        <h3>Adresse</h3>
                        <p>123 Avenue Mohammed V</p>
                        <p>Casablanca, Maroc</p>
                        <p>20000</p>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>
</html>