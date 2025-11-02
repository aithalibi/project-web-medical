<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: auth.php');
    exit();
}

$user_name = $_SESSION['user_name'] ?? 'Patient';

// Données simulées (à remplacer par des requêtes BD)
$patient_info = [
    'nom' => 'Dupont',
    'prenom' => 'Jean',
    'date_naissance' => '15/03/1985',
    'groupe_sanguin' => 'A+',
    'numero_securite' => 'XXX XXXX XXXX XX',
    'telephone' => '06 12 34 56 78',
    'email' => 'jean.dupont@email.com',
    'adresse' => '123 Avenue Mohammed V, Casablanca'
];

$allergies = [
    'Pénicilline',
    'Arachides',
    'Pollen'
];

$antecedents = [
    ['maladie' => 'Asthme', 'date' => '2010'],
    ['maladie' => 'Hypertension', 'date' => '2018']
];

$traitements_actuels = [
    ['medicament' => 'Lisinopril 10mg', 'posologie' => '1x par jour', 'debut' => '01/2023'],
    ['medicament' => 'Ventoline', 'posologie' => 'Si besoin', 'debut' => '03/2015']
];

$vaccinations = [
    ['vaccin' => 'COVID-19 (Rappel)', 'date' => '15/10/2024'],
    ['vaccin' => 'Grippe saisonnière', 'date' => '20/09/2024'],
    ['vaccin' => 'Tétanos', 'date' => '10/06/2021']
];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Dossier Médical - Clinique Médicale</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include "header.php"; ?>
    
    <main class="main-content">
        <div class="container">
            <div class="page-header">
                <h1><i class="fas fa-folder-open"></i> Mon Dossier Médical</h1>
                <p>Consultez toutes vos informations médicales</p>
            </div>
            
            <!-- Informations Personnelles -->
            <section class="medical-record-section">
                <div class="medical-card">
                    <h3><i class="fas fa-user"></i> Informations Personnelles</h3>
                    
                    <div class="info-row">
                        <div class="info-item">
                            <label>Nom complet</label>
                            <strong><?php echo $patient_info['prenom'] . ' ' . $patient_info['nom']; ?></strong>
                        </div>
                        <div class="info-item">
                            <label>Date de naissance</label>
                            <strong><?php echo $patient_info['date_naissance']; ?></strong>
                        </div>
                        <div class="info-item">
                            <label>Groupe sanguin</label>
                            <strong><?php echo $patient_info['groupe_sanguin']; ?></strong>
                        </div>
                    </div>
                    
                    <div class="info-row">
                        <div class="info-item">
                            <label>Numéro de sécurité sociale</label>
                            <strong><?php echo $patient_info['numero_securite']; ?></strong>
                        </div>
                        <div class="info-item">
                            <label>Téléphone</label>
                            <strong><?php echo $patient_info['telephone']; ?></strong>
                        </div>
                        <div class="info-item">
                            <label>Email</label>
                            <strong><?php echo $patient_info['email']; ?></strong>
                        </div>
                    </div>
                    
                    <div class="info-row">
                        <div class="info-item">
                            <label>Adresse</label>
                            <strong><?php echo $patient_info['adresse']; ?></strong>
                        </div>
                    </div>
                    
                    <button class="btn btn-outline" style="margin-top: 20px;">
                        <i class="fas fa-edit"></i> Modifier mes informations
                    </button>
                </div>
            </section>
            
            <!-- Allergies -->
            <section class="medical-record-section">
                <div class="medical-card">
                    <h3><i class="fas fa-exclamation-triangle"></i> Allergies Connues</h3>
                    
                    <?php if (!empty($allergies)): ?>
                    <ul class="medical-list">
                        <?php foreach ($allergies as $allergie): ?>
                        <li>
                            <span><i class="fas fa-dot-circle" style="color: var(--danger-color); margin-right: 10px;"></i></span>
                            <strong><?php echo $allergie; ?></strong>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <?php else: ?>
                    <p style="color: var(--gray);">Aucune allergie connue</p>
                    <?php endif; ?>
                    
                    <button class="btn btn-outline" style="margin-top: 15px;">
                        <i class="fas fa-plus"></i> Ajouter une allergie
                    </button>
                </div>
            </section>
            
            <!-- Antécédents Médicaux -->
            <section class="medical-record-section">
                <div class="medical-card">
                    <h3><i class="fas fa-history"></i> Antécédents Médicaux</h3>
                    
                    <?php if (!empty($antecedents)): ?>
                    <ul class="medical-list">
                        <?php foreach ($antecedents as $antecedent): ?>
                        <li>
                            <div>
                                <strong><?php echo $antecedent['maladie']; ?></strong>
                            </div>
                            <span>Depuis <?php echo $antecedent['date']; ?></span>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <?php else: ?>
                    <p style="color: var(--gray);">Aucun antécédent médical connu</p>
                    <?php endif; ?>
                    
                    <button class="btn btn-outline" style="margin-top: 15px;">
                        <i class="fas fa-plus"></i> Ajouter un antécédent
                    </button>
                </div>
            </section>
            
            <!-- Traitements en cours -->
            <section class="medical-record-section">
                <div class="medical-card">
                    <h3><i class="fas fa-prescription-bottle"></i> Traitements en Cours</h3>
                    
                    <?php if (!empty($traitements_actuels)): ?>
                    <ul class="medical-list">
                        <?php foreach ($traitements_actuels as $traitement): ?>
                        <li>
                            <div>
                                <strong><?php echo $traitement['medicament']; ?></strong>
                                <span style="display: block; color: var(--gray); font-size: 0.9rem;">
                                    <?php echo $traitement['posologie']; ?> • Depuis <?php echo $traitement['debut']; ?>
                                </span>
                            </div>
                            <button class="btn-small btn-outline">Détails</button>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <?php else: ?>
                    <p style="color: var(--gray);">Aucun traitement en cours</p>
                    <?php endif; ?>
                </div>
            </section>
            
            <!-- Vaccinations -->
            <section class="medical-record-section">
                <div class="medical-card">
                    <h3><i class="fas fa-syringe"></i> Historique des Vaccinations</h3>
                    
                    <?php if (!empty($vaccinations)): ?>
                    <ul class="medical-list">
                        <?php foreach ($vaccinations as $vaccination): ?>
                        <li>
                            <div>
                                <strong><?php echo $vaccination['vaccin']; ?></strong>
                            </div>
                            <span><i class="fas fa-calendar"></i> <?php echo $vaccination['date']; ?></span>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <?php else: ?>
                    <p style="color: var(--gray);">Aucune vaccination enregistrée</p>
                    <?php endif; ?>
                    
                    <button class="btn btn-outline" style="margin-top: 15px;">
                        <i class="fas fa-calendar-plus"></i> Planifier une vaccination
                    </button>
                </div>
            </section>
            
            <!-- Actions rapides -->
            <section class="medical-record-section">
                <div class="medical-card">
                    <h3><i class="fas fa-bolt"></i> Actions Rapides</h3>
                    
                    <div class="quick-actions">
                        <a href="resultats.php" class="action-btn">
                            <i class="fas fa-file-medical"></i>
                            <span>Voir mes résultats</span>
                        </a>
                        <a href="rendez-vous.php" class="action-btn">
                            <i class="fas fa-calendar-plus"></i>
                            <span>Prendre RDV</span>
                        </a>
                        <a href="#" class="action-btn">
                            <i class="fas fa-download"></i>
                            <span>Télécharger mon dossier</span>
                        </a>
                        <a href="#" class="action-btn">
                            <i class="fas fa-print"></i>
                            <span>Imprimer</span>
                        </a>
                    </div>
                </div>
            </section>
        </div>
    </main>
</body>
</html>