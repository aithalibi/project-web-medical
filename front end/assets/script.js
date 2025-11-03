/**
 * ===============================================
 * Script JavaScript Principal
 * ===============================================
 */

// Configuration de l'API Backend
const API_CONFIG = {
    BASE_URL: 'http://127.0.0.1:8000/api',
    ENDPOINTS: {
        LOGIN: '/login',
        REGISTER: '/register',
        LOGOUT: '/logout',
        DOCTORS: '/doctors',
        APPOINTMENTS: '/appointments',
        USER_INFO: '/user'
    }
};

/**
 * Fonction pour basculer entre les formulaires de connexion et d'inscription
 */
function switchForm(formType) {
    const loginForm = document.getElementById('login-form');
    const registerForm = document.getElementById('register-form');
    
    if (formType === 'register') {
        loginForm.classList.remove('active');
        registerForm.classList.add('active');
    } else {
        registerForm.classList.remove('active');
        loginForm.classList.add('active');
    }
}

/**
 * Fonction de connexion utilisateur
 * Utilise fetch() pour communiquer avec l'API Laravel
 */
async function loginUser(email, password) {
    try {
        showNotification('Connexion en cours...', 'info');
        
        const response = await fetch(`${API_CONFIG.BASE_URL}${API_CONFIG.ENDPOINTS.LOGIN}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                email: email,
                password: password
            })
        });
        
        const data = await response.json();
        
        if (response.ok && data.success) {
            // Stocker les informations de l'utilisateur dans localStorage
            localStorage.setItem('auth_token', data.token);
            localStorage.setItem('user_id', data.user.id);
            localStorage.setItem('user_name', data.user.name);
            localStorage.setItem('user_role', data.user.role);
            localStorage.setItem('user_email', data.user.email);
            
            showNotification('Connexion réussie !', 'success');
            
            // Rediriger vers la page d'accueil après 1 seconde
            setTimeout(() => {
                window.location.href = 'accueil.php';
            }, 1000);
        } else {
            showNotification(data.message || 'Email ou mot de passe incorrect', 'error');
        }
    } catch (error) {
        console.error('Erreur de connexion:', error);
        showNotification('Erreur de connexion au serveur', 'error');
    }
}

/**
 * Fonction d'inscription utilisateur
 */
async function registerUser(userData) {
    try {
        showNotification('Inscription en cours...', 'info');
        
        const response = await fetch(`${API_CONFIG.BASE_URL}${API_CONFIG.ENDPOINTS.REGISTER}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(userData)
        });
        
        const data = await response.json();
        
        if (response.ok && data.success) {
            // Stocker les informations de l'utilisateur
            localStorage.setItem('auth_token', data.token);
            localStorage.setItem('user_id', data.user.id);
            localStorage.setItem('user_name', data.user.name);
            localStorage.setItem('user_role', data.user.role);
            localStorage.setItem('user_email', data.user.email);
            
            showNotification('Inscription réussie ! Bienvenue !', 'success');
            
            setTimeout(() => {
                window.location.href = 'accueil.php';
            }, 1000);
        } else {
            showNotification(data.message || 'Erreur lors de l\'inscription', 'error');
        }
    } catch (error) {
        console.error('Erreur d\'inscription:', error);
        showNotification('Erreur de connexion au serveur', 'error');
    }
}

/**
 * Fonction de déconnexion
 */
async function logoutUser() {
    try {
        const token = localStorage.getItem('auth_token');
        
        if (token) {
            await fetch(`${API_CONFIG.BASE_URL}${API_CONFIG.ENDPOINTS.LOGOUT}`, {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json'
                }
            });
        }
        
        // Vider le localStorage
        localStorage.clear();
        
        showNotification('Déconnexion réussie', 'success');
        
        setTimeout(() => {
            window.location.href = 'auth.php';
        }, 1000);
    } catch (error) {
        console.error('Erreur de déconnexion:', error);
        // Même en cas d'erreur, vider le localStorage
        localStorage.clear();
        window.location.href = 'auth.php';
    }
}

/**
 * Vérifier si l'utilisateur est connecté
 */
function isUserLoggedIn() {
    return localStorage.getItem('auth_token') !== null;
}

/**
 * Obtenir le token d'authentification
 */
function getAuthToken() {
    return localStorage.getItem('auth_token');
}

/**
 * Récupérer la liste des docteurs depuis l'API
 */
async function fetchDoctors() {
    try {
        const response = await fetch(`${API_CONFIG.BASE_URL}${API_CONFIG.ENDPOINTS.DOCTORS}`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json'
            }
        });
        
        const data = await response.json();
        
        if (response.ok && data.success) {
            return data.doctors;
        } else {
            showNotification('Erreur lors du chargement des docteurs', 'error');
            return [];
        }
    } catch (error) {
        console.error('Erreur fetch docteurs:', error);
        showNotification('Erreur de connexion au serveur', 'error');
        return [];
    }
}

/**
 * Afficher les docteurs dans une liste
 */
function displayDoctors(doctors, containerId) {
    const container = document.getElementById(containerId);
    
    if (!container || !doctors || doctors.length === 0) {
        container.innerHTML = '<p style="color: var(--gray);">Aucun docteur disponible</p>';
        return;
    }
    
    const doctorsHTML = doctors.map(doctor => `
        <div class="doctor-card">
            <div class="doctor-avatar">
                <i class="fas fa-user-md"></i>
            </div>
            <div class="doctor-info">
                <h3>${doctor.name}</h3>
                <p><i class="fas fa-stethoscope"></i> ${doctor.speciality}</p>
                <p><i class="fas fa-clock"></i> Disponible</p>
                <button class="btn btn-outline" onclick="selectDoctor(${doctor.id})">
                    <i class="fas fa-calendar-plus"></i> Prendre RDV
                </button>
            </div>
        </div>
    `).join('');
    
    container.innerHTML = doctorsHTML;
}

/**
 * Charger les docteurs par spécialité
 */
async function loadDoctorsBySpeciality(speciality, medecinSelectId) {
    const medecinSelect = document.getElementById(medecinSelectId);
    
    // Réinitialiser le select
    medecinSelect.innerHTML = '<option value="">Chargement...</option>';
    
    try {
        const doctors = await fetchDoctors();
        const filteredDoctors = speciality 
            ? doctors.filter(doc => doc.speciality.toLowerCase() === speciality.toLowerCase())
            : doctors;
        
        // Populer le select
        medecinSelect.innerHTML = '<option value="">Sélectionnez un médecin</option>';
        filteredDoctors.forEach(doctor => {
            const option = document.createElement('option');
            option.value = doctor.id;
            option.textContent = doctor.name;
            medecinSelect.appendChild(option);
        });
    } catch (error) {
        console.error('Erreur chargement médecins:', error);
        medecinSelect.innerHTML = '<option value="">Erreur de chargement</option>';
    }
}

/**
 * Récupérer les rendez-vous de l'utilisateur
 */
async function fetchAppointments() {
    const token = getAuthToken();
    
    if (!token) {
        console.error('Utilisateur non connecté');
        return [];
    }
    
    try {
        const response = await fetch(`${API_CONFIG.BASE_URL}${API_CONFIG.ENDPOINTS.APPOINTMENTS}`, {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            }
        });
        
        const data = await response.json();
        
        if (response.ok && data.success) {
            return data.appointments;
        } else {
            showNotification('Erreur lors du chargement des rendez-vous', 'error');
            return [];
        }
    } catch (error) {
        console.error('Erreur fetch rendez-vous:', error);
        showNotification('Erreur de connexion au serveur', 'error');
        return [];
    }
}

/**
 * Afficher les rendez-vous
 */
function displayAppointments(appointments, containerId) {
    const container = document.getElementById(containerId);
    
    if (!container) return;
    
    if (!appointments || appointments.length === 0) {
        container.innerHTML = '<p style="color: var(--gray);">Aucun rendez-vous à venir</p>';
        return;
    }
    
    const appointmentsHTML = appointments.map(apt => {
        const date = new Date(apt.date);
        const day = date.getDate();
        const month = date.toLocaleDateString('fr-FR', { month: 'short' });
        
        return `
            <div class="appointment-card">
                <div class="appointment-date">
                    <span class="day">${day}</span>
                    <span class="month">${month}</span>
                </div>
                <div class="appointment-details">
                    <h4>${apt.doctor_name}</h4>
                    <p><i class="fas fa-stethoscope"></i> ${apt.speciality}</p>
                    <p><i class="fas fa-clock"></i> ${apt.time}</p>
                </div>
                <div class="appointment-actions">
                    <button class="btn-small btn-outline" onclick="viewAppointmentDetails(${apt.id})">
                        Détails
                    </button>
                    <button class="btn-small btn-danger" onclick="cancelAppointment(${apt.id})">
                        Annuler
                    </button>
                </div>
            </div>
        `;
    }).join('');
    
    container.innerHTML = appointmentsHTML;
}

/**
 * Créer un nouveau rendez-vous
 */
async function createAppointment(appointmentData) {
    const token = getAuthToken();
    
    if (!token) {
        showNotification('Vous devez être connecté pour prendre un rendez-vous', 'error');
        return false;
    }
    
    try {
        showNotification('Création du rendez-vous en cours...', 'info');
        
        const response = await fetch(`${API_CONFIG.BASE_URL}${API_CONFIG.ENDPOINTS.APPOINTMENTS}`, {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(appointmentData)
        });
        
        const data = await response.json();
        
        if (response.ok && data.success) {
            showNotification('Rendez-vous créé avec succès !', 'success');
            
            // Recharger les rendez-vous
            setTimeout(() => {
                loadUserAppointments();
            }, 1500);
            
            return true;
        } else {
            showNotification(data.message || 'Erreur lors de la création du rendez-vous', 'error');
            return false;
        }
    } catch (error) {
        console.error('Erreur création rendez-vous:', error);
        showNotification('Erreur de connexion au serveur', 'error');
        return false;
    }
}

/**
 * Annuler un rendez-vous
 */
async function cancelAppointment(appointmentId) {
    const token = getAuthToken();
    
    if (!token) {
        showNotification('Vous devez être connecté', 'error');
        return;
    }
    
    // Demander confirmation
    if (!confirm('Êtes-vous sûr de vouloir annuler ce rendez-vous ?')) {
        return;
    }
    
    try {
        const response = await fetch(`${API_CONFIG.BASE_URL}${API_CONFIG.ENDPOINTS.APPOINTMENTS}/${appointmentId}`, {
            method: 'DELETE',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            }
        });
        
        const data = await response.json();
        
        if (response.ok && data.success) {
            showNotification('Rendez-vous annulé avec succès', 'success');
            
            // Recharger les rendez-vous
            setTimeout(() => {
                loadUserAppointments();
            }, 1500);
        } else {
            showNotification(data.message || 'Erreur lors de l\'annulation', 'error');
        }
    } catch (error) {
        console.error('Erreur annulation:', error);
        showNotification('Erreur de connexion au serveur', 'error');
    }
}

/**
 * Charger les rendez-vous de l'utilisateur
 */
async function loadUserAppointments() {
    const appointments = await fetchAppointments();
    displayAppointments(appointments, 'appointments-container');
}

/**
 * Voir les détails d'un rendez-vous
 */
function viewAppointmentDetails(appointmentId) {
    console.log('Voir détails RDV:', appointmentId);
    // Implémenter la logique d'affichage des détails
    alert('Fonctionnalité en cours de développement');
}

/**
 * Sélectionner un docteur
 */
function selectDoctor(doctorId) {
    console.log('Docteur sélectionné:', doctorId);
    // Rediriger vers la page de prise de rendez-vous
    window.location.href = `rendezvous.php?doctor_id=${doctorId}`;
}


/**
 * Afficher une notification
 * Types: 'success', 'error', 'warning', 'info'
 */
function showNotification(message, type = 'info') {
    // Créer l'élément de notification
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    
    // Définir l'icône selon le type
    let icon = '';
    switch(type) {
        case 'success':
            icon = '<i class="fas fa-check-circle"></i>';
            break;
        case 'error':
            icon = '<i class="fas fa-exclamation-circle"></i>';
            break;
        case 'warning':
            icon = '<i class="fas fa-exclamation-triangle"></i>';
            break;
        case 'info':
        default:
            icon = '<i class="fas fa-info-circle"></i>';
            break;
    }
    
    notification.innerHTML = `
        <div class="notification-content">
            ${icon}
            <span>${message}</span>
        </div>
    `;
    
    // Ajouter au body
    document.body.appendChild(notification);
    
    // Animation d'apparition
    setTimeout(() => {
        notification.classList.add('show');
    }, 10);
    
    // Retirer après 4 secondes
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 4000);
}


/**
 * Gérer la soumission du formulaire de connexion
 */
function handleLoginForm(event) {
    event.preventDefault();
    
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    
    // Validation basique
    if (!email || !password) {
        showNotification('Veuillez remplir tous les champs', 'error');
        return;
    }
    
    loginUser(email, password);
}

/**
 * Gérer la soumission du formulaire d'inscription
 */
function handleRegisterForm(event) {
    event.preventDefault();
    
    const nom = document.getElementById('nom').value;
    const prenom = document.getElementById('prenom').value;
    const email = document.getElementById('email_register').value;
    const telephone = document.getElementById('telephone').value;
    const password = document.getElementById('password_register').value;
    const passwordConfirm = document.getElementById('password_confirm').value;
    
    // Validations
    if (!nom || !prenom || !email || !telephone || !password || !passwordConfirm) {
        showNotification('Veuillez remplir tous les champs', 'error');
        return;
    }
    
    if (password !== passwordConfirm) {
        showNotification('Les mots de passe ne correspondent pas', 'error');
        return;
    }
    
    if (password.length < 6) {
        showNotification('Le mot de passe doit contenir au moins 6 caractères', 'error');
        return;
    }
    
    const userData = {
        nom: nom,
        prenom: prenom,
        email: email,
        telephone: telephone,
        password: password
    };
    
    registerUser(userData);
}

/**
 * Gérer la soumission du formulaire de rendez-vous
 */
function handleAppointmentForm(event) {
    event.preventDefault();
    
    const specialite = document.getElementById('specialite').value;
    const medecin = document.getElementById('medecin').value;
    const date = document.getElementById('date').value;
    const heure = document.getElementById('heure').value;
    const motif = document.getElementById('motif').value;
    
    // Validations
    if (!specialite || !medecin || !date || !heure || !motif) {
        showNotification('Veuillez remplir tous les champs', 'error');
        return;
    }
    
    // Vérifier que la date n'est pas dans le passé
    const selectedDate = new Date(date);
    const today = new Date();
    today.setHours(0, 0, 0, 0);
    
    if (selectedDate < today) {
        showNotification('La date doit être dans le futur', 'error');
        return;
    }
    
    const appointmentData = {
        id_doctor: parseInt(medecin),
        date: date,
        heure: heure,
        motif: motif
    };
    
    createAppointment(appointmentData);
}

// ===============================================
// INITIALISATION DES EVENEMENTS
// ===============================================

/**
 * Initialiser les événements quand le DOM est chargé
 */
document.addEventListener('DOMContentLoaded', function() {
    
    // Gestion de la soumission du formulaire de connexion
    const loginForm = document.getElementById('login-form')?.querySelector('form');
    if (loginForm) {
        loginForm.addEventListener('submit', handleLoginForm);
    }
    
    // Gestion de la soumission du formulaire d'inscription
    const registerForm = document.getElementById('register-form')?.querySelector('form');
    if (registerForm) {
        registerForm.addEventListener('submit', handleRegisterForm);
    }
    
    // Gestion du changement de spécialité pour charger les médecins
    const specialiteSelect = document.getElementById('specialite');
    if (specialiteSelect) {
        specialiteSelect.addEventListener('change', function() {
            const specialiteValue = this.value;
            loadDoctorsBySpeciality(specialiteValue, 'medecin');
        });
    }
    
    // Gestion de la soumission du formulaire de rendez-vous
    const appointmentForm = document.querySelector('form[name="appointment"]') || 
                           document.querySelector('form[action*="rendezvous"]');
    if (appointmentForm) {
        appointmentForm.addEventListener('submit', handleAppointmentForm);
    }
    
    // Charger les rendez-vous si on est sur la page d'accueil
    if (document.getElementById('appointments-container')) {
        loadUserAppointments();
    }
    
    // Gestion du bouton de déconnexion
    const logoutButtons = document.querySelectorAll('.logout-btn');
    logoutButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            logoutUser();
        });
    });
    
});

// ===============================================
// FONCTIONS UTILITAIRES
// ===============================================

/**
 * Formater une date au format français
 */
function formatDateFR(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('fr-FR', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
}

/**
 * Vérifier si une date est valide
 */
function isValidDate(dateString) {
    const date = new Date(dateString);
    return !isNaN(date.getTime());
}

/**
 * Debounce function pour optimiser les requêtes API
 */
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// ===============================================
// EXPORT GLOBAL
// ===============================================

// Rendre certaines fonctions disponibles globalement
window.app = {
    loginUser,
    registerUser,
    logoutUser,
    fetchDoctors,
    fetchAppointments,
    createAppointment,
    cancelAppointment,
    showNotification,
    switchForm,
    loadUserAppointments,
    displayAppointments,
    displayDoctors,
    loadDoctorsBySpeciality,
    selectDoctor,
    viewAppointmentDetails
};

