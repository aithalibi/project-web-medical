<?php
session_start();

// Vérifier si l'utilisateur est connecté et est un médecin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'docteur') {
    header('Location: auth.php');
    exit();
}

$user_name = $_SESSION['user_name'] ?? 'Docteur';

// Statistiques du jour (à récupérer depuis la BD)
$stats = [
    'patients_jour' => 12,
    'rendez_vous_restants' => 5,
    'urgences' => 2,
    'consultations_semaine' => 47
];

// Prochains rendez-vous (données simulées)
$prochains_rdv = [
    [
        'id' => 1,
        'patient' => 'Ahmed Benjelloun',
        'heure' => '14:30',
        'type' => 'Consultation de suivi',
        'salle' => 'Cabinet 2',
        'nouveau' => false
    ],
    [
        'id' => 2,
        'patient' => 'Fatima El Amrani',
        'heure' => '15:00',
        'type' => 'Première consultation',
        'salle' => 'Cabinet 2',
        'nouveau' => true
    ],
    [
        'id' => 3,
        'patient' => 'Hassan Alaoui',
        'heure' => '15:30',
        'type' => 'Résultats analyses',
        'salle' => 'Cabinet 2',
        'nouveau' => false
    ]
];

// Liste des patients du jour
$patients_jour = [
    [
        'id' => 1,
        'nom' => 'Dupont Jean',
        'age' => 45,
        'heure' => '09:00',
        'statut' => 'terminé',
        'motif' => 'Douleurs abdominales'
    ],
    [
        'id' => 2,
        'nom' => 'Martin Sophie',
        'age' => 32,
        'heure' => '09:30',
        'statut' => 'terminé',
        'motif' => 'Contrôle tension'
    ],
    [
        'id' => 3,
        'nom' => 'Dubois Pierre',
        'age' => 58,
        'heure' => '10:00',
        'statut' => 'en_cours',
        'motif' => 'Renouvellement ordonnance'
    ]
];

// Messages et notifications
$notifications = [
    [
        'type' => 'urgent',
        'message' => 'Résultats d\'analyses disponibles pour le patient Ahmed B.',
        'time' => 'Il y a 15 min'
    ],
    [
        'type' => 'info',
        'message' => 'Nouveau rendez-vous confirmé pour demain 10h',
        'time' => 'Il y a 1h'
    ]
];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Médecin - Clinique Médicale</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Header spécifique médecin -->
    <header class="main-header">
        <div class="container header-content">
            <a href="docteur.php" class="logo">
                <i class="fas fa-heartbeat"></i>
                <span>Clinique Médicale</span>
            </a>
            
            <nav>
                <ul class="nav-menu">
                    <li><a href="docteur.php" class="active"><i class="fas fa-home"></i> Tableau de bord</a></li>
                    <li><a href="docteur-patients.php"><i class="fas fa-users"></i> Mes Patients</a></li>
                    <li><a href="docteur-agenda.php"><i class="fas fa-calendar-alt"></i> Agenda</a></li>
                    <li><a href="docteur-ordonnances.php"><i class="fas fa-prescription"></i> Ordonnances</a></li>
                </ul>
            </nav>
            
            <div class="user-actions">
                <div class="notification-icon">
                    <i class="fas fa-bell"></i>
                    <span class="badge">2</span>
                </div>
                <div class="user-profile">
                    <div class="user-avatar doctor">
                        <i class="fas fa-user-md"></i>
                    </div>
                    <span>Dr. <?php echo htmlspecialchars($user_name); ?></span>
                </div>
                <a href="logout.php" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i> Déconnexion
                </a>
            </div>
        </div>
    </header>
    
    <main class="main-content">
        <div class="container">
            <!-- Bienvenue -->
            <div class="doctor-welcome">
                <div class="welcome-text">
                    <h1>Bonjour Dr. <?php echo htmlspecialchars($user_name); ?></h1>
                    <p><i class="fas fa-calendar"></i> <?php echo strftime('%A %d %B %Y'); ?></p>
                </div>
                <div class="quick-actions-doctor">
                    <a href="docteur-nouvelle-consultation.php" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Nouvelle consultation
                    </a>
                    <a href="docteur-ordonnance.php" class="btn btn-outline">
                        <i class="fas fa-prescription"></i> Créer ordonnance
                    </a>
                </div>
            </div>
            
            <!-- Statistiques -->
            <section class="stats-section">
                <div class="stat-card-doctor">
                    <div class="stat-icon patients">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-content">
                        <h3><?php echo $stats['patients_jour']; ?></h3>
                        <p>Patients aujourd'hui</p>
                    </div>
                </div>
                
                <div class="stat-card-doctor">
                    <div class="stat-icon appointments">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div class="stat-content">
                        <h3><?php echo $stats['rendez_vous_restants']; ?></h3>
                        <p>RDV restants</p>
                    </div>
                </div>
                
                <div class="stat-card-doctor">
                    <div class="stat-icon urgent">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="stat-content">
                        <h3><?php echo $stats['urgences']; ?></h3>
                        <p>Urgences</p>
                    </div>
                </div>
                
                <div class="stat-card-doctor">
                    <div class="stat-icon week">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="stat-content">
                        <h3><?php echo $stats['consultations_semaine']; ?></h3>
                        <p>Consultations cette semaine</p>
                    </div>
                </div>
            </section>
            
            <div class="doctor-layout">
                <!-- Colonne principale -->
                <div class="doctor-main">
                    <!-- Prochains rendez-vous -->
                    <section class="doctor-section">
                        <div class="section-header">
                            <h2><i class="fas fa-clock"></i> Prochains Rendez-vous</h2>
                            <a href="docteur-agenda.php" class="link-view-all">Voir l'agenda complet</a>
                        </div>
                        
                        <div class="appointments-timeline">
                            <?php foreach ($prochains_rdv as $rdv): ?>
                            <div class="timeline-item">
                                <div class="timeline-time">
                                    <i class="fas fa-clock"></i>
                                    <?php echo $rdv['heure']; ?>
                                </div>
                                <div class="timeline-content">
                                    <div class="timeline-header">
                                        <h4>
                                            <?php echo htmlspecialchars($rdv['patient']); ?>
                                            <?php if ($rdv['nouveau']): ?>
                                            <span class="badge-new">Nouveau</span>
                                            <?php endif; ?>
                                        </h4>
                                        <span class="timeline-room"><?php echo $rdv['salle']; ?></span>
                                    </div>
                                    <p><i class="fas fa-stethoscope"></i> <?php echo $rdv['type']; ?></p>
                                    <div class="timeline-actions">
                                        <a href="docteur-consultation.php?id=<?php echo $rdv['id']; ?>" class="btn-small btn-primary">
                                            <i class="fas fa-folder-open"></i> Ouvrir dossier
                                        </a>
                                        <button class="btn-small btn-outline">
                                            <i class="fas fa-edit"></i> Modifier
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </section>
                    
                    <!-- Patients du jour -->
                    <section class="doctor-section">
                        <div class="section-header">
                            <h2><i class="fas fa-list"></i> Patients du Jour</h2>
                            <div class="filter-tabs">
                                <button class="tab active">Tous</button>
                                <button class="tab">En attente</button>
                                <button class="tab">Terminés</button>
                            </div>
                        </div>
                        
                        <div class="patients-table">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Heure</th>
                                        <th>Patient</th>
                                        <th>Âge</th>
                                        <th>Motif</th>
                                        <th>Statut</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($patients_jour as $patient): ?>
                                    <tr>
                                        <td><strong><?php echo $patient['heure']; ?></strong></td>
                                        <td><?php echo htmlspecialchars($patient['nom']); ?></td>
                                        <td><?php echo $patient['age']; ?> ans</td>
                                        <td><?php echo $patient['motif']; ?></td>
                                        <td>
                                            <?php if ($patient['statut'] === 'terminé'): ?>
                                            <span class="status-badge completed">Terminé</span>
                                            <?php elseif ($patient['statut'] === 'en_cours'): ?>
                                            <span class="status-badge in-progress">En cours</span>
                                            <?php else: ?>
                                            <span class="status-badge pending">En attente</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="table-actions">
                                                <button class="btn-icon-small" title="Voir dossier">
                                                    <i class="fas fa-folder-open"></i>
                                                </button>
                                                <button class="btn-icon-small" title="Ajouter note">
                                                    <i class="fas fa-notes-medical"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>
                <!-- Sidebar droite -->
                <div class="doctor-sidebar">
                    <!-- Notifications -->
                    <div class="sidebar-card">
                        <h3><i class="fas fa-bell"></i> Notifications</h3>
                        <div class="notifications-list">
                            <?php foreach ($notifications as $notif): ?>
                            <div class="notification-item <?php echo $notif['type']; ?>">
                                <div class="notif-icon">
                                    <?php if ($notif['type'] === 'urgent'): ?>
                                    <i class="fas fa-exclamation-circle"></i>
                                    <?php else: ?>
                                    <i class="fas fa-info-circle"></i>
                                    <?php endif; ?>
                                </div>
                                <div class="notif-content">
                                    <p><?php echo $notif['message']; ?></p>
                                    <span class="notif-time"><?php echo $notif['time']; ?></span>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <a href="#" class="view-all-link">Voir toutes les notifications</a>
                    </div>
                    
                    <!-- Accès rapide -->
                    <div class="sidebar-card">
                        <h3><i class="fas fa-bolt"></i> Accès Rapide</h3>
                        <div class="quick-links">
                            <a href="docteur-recherche-patient.php" class="quick-link-item">
                                <i class="fas fa-search"></i>
                                <span>Rechercher un patient</span>
                            </a>
                            <a href="docteur-certificat.php" class="quick-link-item">
                                <i class="fas fa-file-alt"></i>
                                <span>Certificat médical</span>
                            </a>
                            <a href="docteur-analyses.php" class="quick-link-item">
                                <i class="fas fa-flask"></i>
                                <span>Demander analyses</span>
                            </a>
                            <a href="docteur-courrier.php" class="quick-link-item">
                                <i class="fas fa-envelope"></i>
                                <span>Courrier médical</span>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Statistiques personnelles -->
                    <div class="sidebar-card">
                        <h3><i class="fas fa-chart-bar"></i> Mes Statistiques</h3>
                        <div class="personal-stats">
                            <div class="stat-item">
                                <span class="stat-label">Taux de satisfaction</span>
                                <div class="stat-bar">
                                    <div class="stat-fill" style="width: 95%;"></div>
                                </div>
                                <span class="stat-value">95%</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Ponctualité</span>
                                <div class="stat-bar">
                                    <div class="stat-fill" style="width: 88%;"></div>
                                </div>
                                <span class="stat-value">88%</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Patients ce mois</span>
                                <span class="stat-value-large">127</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <?php include 'includes/footer.php'; ?>
</body>
</html>