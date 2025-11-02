<?php
session_start();

// Vérifier si l'utilisateur est connecté (optionnel pour la page contact)
$is_logged_in = isset($_SESSION['user_id']);
$user_name = $_SESSION['user_name'] ?? '';

// Traitement du formulaire de contact
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_message'])) {
    // TODO: Envoyer l'email ou enregistrer le message dans la BD
    $nom = $_POST['nom'] ?? '';
    $email = $_POST['email'] ?? '';
    $telephone = $_POST['telephone'] ?? '';
    $sujet = $_POST['sujet'] ?? '';
    $message = $_POST['message'] ?? '';
    
    // Simulation d'envoi réussi
    $success = true;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nous Contacter - Clinique Médicale</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php if ($is_logged_in) include "header.php"; ?>
    
    <main class="main-content">
        <div class="container">
            <div class="page-header">
                <h1><i class="fas fa-envelope"></i> Contactez-nous</h1>
                <p>Nous sommes à votre écoute pour toutes vos questions</p>
            </div>
            
            <?php if (isset($success) && $success): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                Votre message a été envoyé avec succès ! Nous vous répondrons dans les plus brefs délais.
            </div>
            <?php endif; ?>
            
            <div class="contact-layout">
                <!-- Formulaire de contact -->
                <div class="contact-form-section">
                    <div class="form-card">
                        <h3><i class="fas fa-paper-plane"></i> Envoyez-nous un message</h3>
                        
                        <form method="POST" action="">
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="nom">
                                        <i class="fas fa-user"></i> Nom complet *
                                    </label>
                                    <input type="text" id="nom" name="nom" required placeholder="Votre nom" 
                                           value="<?php echo $is_logged_in ? htmlspecialchars($user_name) : ''; ?>">
                                </div>
                                
                                <div class="form-group">
                                    <label for="email">
                                        <i class="fas fa-envelope"></i> Email *
                                    </label>
                                    <input type="email" id="email" name="email" required placeholder="votre@email.com">
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="telephone">
                                        <i class="fas fa-phone"></i> Téléphone
                                    </label>
                                    <input type="tel" id="telephone" name="telephone" placeholder="06 12 34 56 78">
                                </div>
                                
                                <div class="form-group">
                                    <label for="sujet">
                                        <i class="fas fa-tag"></i> Sujet *
                                    </label>
                                    <select id="sujet" name="sujet" required>
                                        <option value="">Sélectionnez un sujet</option>
                                        <option value="rdv">Prise de rendez-vous</option>
                                        <option value="info">Demande d'information</option>
                                        <option value="urgence">Urgence médicale</option>
                                        <option value="resultat">Question sur résultats</option>
                                        <option value="facturation">Facturation</option>
                                        <option value="reclamation">Réclamation</option>
                                        <option value="autre">Autre</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="message">
                                    <i class="fas fa-comment"></i> Votre message *
                                </label>
                                <textarea id="message" name="message" rows="6" required placeholder="Décrivez votre demande en détail..."></textarea>
                            </div>
                            
                            <div class="form-options">
                                <label class="checkbox-container">
                                    <input type="checkbox" name="copie" checked>
                                    <span>Recevoir une copie du message</span>
                                </label>
                            </div>
                            
                            <button type="submit" name="send_message" class="btn btn-primary">
                                <i class="fas fa-paper-plane"></i> Envoyer le message
                            </button>
                        </form>
                    </div>
                </div>
                
                <!-- Informations de contact -->
                <div class="contact-info-section">
                    <div class="contact-info-card">
                        <div class="contact-method">
                            <div class="contact-icon">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <div class="contact-details">
                                <h4>Téléphone</h4>
                                <p>Standard: <a href="tel:+212500000000">+212 5XX XX XX XX</a></p>
                                <p>Urgences: <a href="tel:+212500000001" style="color: var(--danger-color); font-weight: bold;">+212 5XX XX XX XX</a></p>
                            </div>
                        </div>
                        
                        <div class="contact-method">
                            <div class="contact-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="contact-details">
                                <h4>Email</h4>
                                <p><a href="mailto:contact@clinique.ma">contact@clinique.ma</a></p>
                                <p><a href="mailto:rdv@clinique.ma">rdv@clinique.ma</a></p>
                            </div>
                        </div>
                        
                        <div class="contact-method">
                            <div class="contact-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="contact-details">
                                <h4>Adresse</h4>
                                <p>123 Avenue Mohammed V</p>
                                <p>Casablanca, Maroc 20000</p>
                                <a href="#" class="btn-small btn-outline" style="margin-top: 10px;">
                                    <i class="fas fa-directions"></i> Obtenir l'itinéraire
                                </a>
                            </div>
                        </div>
                        
                        <div class="contact-method">
                            <div class="contact-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="contact-details">
                                <h4>Horaires d'ouverture</h4>
                                <p><strong>Lun - Ven:</strong> 8h00 - 20h00</p>
                                <p><strong>Samedi:</strong> 9h00 - 18h00</p>
                                <p><strong>Dimanche:</strong> Urgences uniquement</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="social-card">
                        <h4><i class="fas fa-share-alt"></i> Suivez-nous</h4>
                        <div class="social-links">
                            <a href="#" class="social-btn facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="social-btn twitter">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="social-btn instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="social-btn linkedin">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        </div>
                    </div>
                    
                    <div class="emergency-card">
                        <i class="fas fa-ambulance"></i>
                        <h3>Urgences Médicales</h3>
                        <p>En cas d'urgence vitale, appelez immédiatement:</p>
                        <a href="tel:150" class="emergency-number">150</a>
                        <p style="font-size: 0.9rem; margin-top: 10px;">Ou contactez notre service d'urgences 24h/24</p>
                    </div>
                </div>
            </div>
            
            <!-- Carte Google Maps (placeholder) -->
            <section class="map-section">
                <h2><i class="fas fa-map"></i> Notre Localisation</h2>
                <div class="map-placeholder">
                    <i class="fas fa-map-marked-alt"></i>
                    <p>Carte interactive</p>
                    <p style="font-size: 0.9rem; color: var(--gray);">
                        123 Avenue Mohammed V, Casablanca, Maroc
                    </p>
                    <!-- Ici vous pouvez intégrer une vraie carte Google Maps avec une iframe -->
                </div>
            </section>
            
            <!-- FAQ rapide -->
            <section class="faq-section">
                <h2><i class="fas fa-question-circle"></i> Questions Fréquentes</h2>
                <div class="faq-grid">
                    <div class="faq-card">
                        <i class="fas fa-calendar-check"></i>
                        <h4>Comment prendre rendez-vous?</h4>
                        <p>Vous pouvez prendre rendez-vous en ligne via votre espace patient, par téléphone ou directement à l'accueil de la clinique.</p>
                    </div>
                    
                    <div class="faq-card">
                        <i class="fas fa-file-medical"></i>
                        <h4>Quels documents apporter?</h4>
                        <p>Apportez votre carte d'identité, votre carte de mutuelle et vos anciens examens médicaux si disponibles.</p>
                    </div>
                    
                    <div class="faq-card">
                        <i class="fas fa-credit-card"></i>
                        <h4>Modes de paiement acceptés?</h4>
                        <p>Nous acceptons les espèces, cartes bancaires, chèques et le tiers-payant pour certaines mutuelles.</p>
                    </div>
                    
                    <div class="faq-card">
                        <i class="fas fa-parking"></i>
                        <h4>Y a-t-il un parking?</h4>
                        <p>Oui, un parking gratuit est disponible pour nos patients à l'arrière de la clinique.</p>
                    </div>
                </div>
                
                <div style="text-align: center; margin-top: 30px;">
                    <a href="faq.php" class="btn btn-outline">
                        <i class="fas fa-arrow-right"></i> Voir toutes les questions
                    </a>
                </div>
            </section>
        </div>
    </main>
</body>
</html>