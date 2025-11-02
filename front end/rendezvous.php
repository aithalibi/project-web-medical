<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: auth.php');
    exit();
}

$user_name = $_SESSION['user_name'] ?? 'Patient';

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_appointment'])) {
    // TODO: Insérer le rendez-vous dans la base de données
    $specialite = $_POST['specialite'] ?? '';
    $medecin = $_POST['medecin'] ?? '';
    $date = $_POST['date'] ?? '';
    $heure = $_POST['heure'] ?? '';
    $motif = $_POST['motif'] ?? '';
    
    // Simulation de succès
    $success_message = "Votre rendez-vous a été enregistré avec succès !";
}

// Liste des spécialités (à récupérer depuis la BD future)
$specialites = [
    'generale' => 'Médecine Générale',
    'cardiologie' => 'Cardiologie',
    'dermatologie' => 'Dermatologie',
    'pediatrie' => 'Pédiatrie',
    'gynecologie' => 'Gynécologie',
    'orthopédie' => 'Orthopédie',
    'ophtalmologie' => 'Ophtalmologie',
    'dentaire' => 'Soins Dentaires'
];

// Liste des médecins (à récupérer depuis la BD future)
$medecins = [
    'generale' => [
        ['id' => 1, 'nom' => 'Dr. Sophie Laurent'],
        ['id' => 2, 'nom' => 'Dr. Ahmed Benjelloun']
    ],
    'cardiologie' => [
        ['id' => 3, 'nom' => 'Dr. Martin Dubois'],
        ['id' => 4, 'nom' => 'Dr. Fatima El Amrani']
    ],
    'dermatologie' => [
        ['id' => 5, 'nom' => 'Dr. Julie Bernard'],
        ['id' => 6, 'nom' => 'Dr. Karim Alaoui']
    ]
];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prendre Rendez-vous - Clinique Médicale</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include "header.php"; ?>
    
    <main class="main-content">
        <div class="container">
            <div class="page-header">
                <h1><i class="fas fa-calendar-plus"></i> Prendre Rendez-vous</h1>
                <p>Choisissez votre spécialité et votre médecin</p>
            </div>
            
            <?php if (isset($success_message)): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <?php echo $success_message; ?>
            </div>
            <?php endif; ?>
            
            <div class="appointment-layout">
                <div class="appointment-form-section">
                    <div class="form-card">
                        <form method="POST" action="">
                            <div class="form-step active" id="step-1">
                                <h3><i class="fas fa-stethoscope"></i> Choisissez une spécialité</h3>
                                
                                <div class="form-group">
                                    <label for="specialite">Spécialité médicale *</label>
                                    <select id="specialite" name="specialite" required>
                                        <option value="">Sélectionnez une spécialité</option>
                                        <?php foreach ($specialites as $key => $nom): ?>
                                        <option value="<?php echo $key; ?>"><?php echo $nom; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="medecin">Médecin *</label>
                                    <select id="medecin" name="medecin" required>
                                        <option value="">Sélectionnez d'abord une spécialité</option>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="date">Date du rendez-vous *</label>
                                    <input type="date" id="date" name="date" required min="<?php echo date('Y-m-d'); ?>">
                                </div>
                                
                                <div class="form-group">
                                    <label for="heure">Heure *</label>
                                    <select id="heure" name="heure" required>
                                        <option value="">Sélectionnez une heure</option>
                                        <option value="08:00">08:00</option>
                                        <option value="08:30">08:30</option>
                                        <option value="09:00">09:00</option>
                                        <option value="09:30">09:30</option>
                                        <option value="10:00">10:00</option>
                                        <option value="10:30">10:30</option>
                                        <option value="11:00">11:00</option>
                                        <option value="11:30">11:30</option>
                                        <option value="14:00">14:00</option>
                                        <option value="14:30">14:30</option>
                                        <option value="15:00">15:00</option>
                                        <option value="15:30">15:30</option>
                                        <option value="16:00">16:00</option>
                                        <option value="16:30">16:30</option>
                                        <option value="17:00">17:00</option>
                                        <option value="17:30">17:30</option>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="motif">Motif de consultation *</label>
                                    <textarea id="motif" name="motif" rows="4" required placeholder="Décrivez brièvement le motif de votre consultation..."></textarea>
                                </div>
                                
                                <button type="submit" name="submit_appointment" class="btn btn-primary">
                                    <i class="fas fa-check"></i> Confirmer le rendez-vous
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="appointment-sidebar">
                    <div class="info-box">
                        <h3><i class="fas fa-info-circle"></i> Informations importantes</h3>
                        <ul class="info-list">
                            <li><i class="fas fa-check"></i> Veuillez arriver 10 minutes avant l'heure</li>
                            <li><i class="fas fa-check"></i> Apportez votre carte d'identité</li>
                            <li><i class="fas fa-check"></i> Apportez vos anciens examens médicaux</li>
                            <li><i class="fas fa-check"></i> Vous pouvez annuler 24h à l'avance</li>
                        </ul>
                    </div>
                    
                    <div class="info-box">
                        <h3><i class="fas fa-clock"></i> Horaires</h3>
                        <div class="schedule-list">
                            <div class="schedule-item">
                                <span>Lun - Ven</span>
                                <strong>8h - 20h</strong>
                            </div>
                            <div class="schedule-item">
                                <span>Samedi</span>
                                <strong>9h - 18h</strong>
                            </div>
                            <div class="schedule-item">
                                <span>Dimanche</span>
                                <strong>Urgences uniquement</strong>
                            </div>
                        </div>
                    </div>
                    
                    <div class="info-box emergency">
                        <h3><i class="fas fa-ambulance"></i> Urgences</h3>
                        <p>En cas d'urgence médicale, appelez immédiatement:</p>
                        <a href="tel:+212500000000" class="emergency-number">
                            <i class="fas fa-phone"></i> +212 5XX XX XX XX
                        </a>
                    </div>
                </div>
            </div>
            
            <section class="upcoming-appointments">
                <h2><i class="fas fa-calendar-check"></i> Vos rendez-vous à venir</h2>
                
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
                            <button class="btn-small btn-outline">Modifier</button>
                            <button class="btn-small btn-danger">Annuler</button>
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
                            <button class="btn-small btn-outline">Modifier</button>
                            <button class="btn-small btn-danger">Annuler</button>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
</body>
</html>