# Projet Web Médical

Application web médicale pour la gestion des rendez-vous, dossiers médicaux et communication entre patients et médecins.

## Fonctionnalités

- **Authentification** : Connexion et inscription pour patients et médecins
- **Gestion des rendez-vous** : Prise de rendez-vous et suivi
- **Dossier médical** : Consultation et gestion du dossier médical
- **Contact** : Formulaire de contact et informations de l'établissement
- **Interface docteur** : Dashboard pour les médecins avec statistiques et gestion des patients

## Structure du Projet

```
last-one/
├── backend/          # Backend Laravel (à développer)
├── front end/        # Interface utilisateur
│   ├── assets/       # Ressources JavaScript
│   │   └── script.js # Script principal (Personne 5)
│   ├── accueil.php
│   ├── auth.php
│   ├── contact.php
│   ├── docteur.php
│   ├── dossier-medical.php
│   ├── header.php
│   ├── rendezvous.php
│   ├── style.css
│   ├── README_JS.md
│   ├── DOCUMENTATION_JS.md
│   └── IMPLEMENTATION_RECAP.md
└── README.md
```

## Technologies Utilisées

- **Backend** : Laravel, PHP, MySQL
- **Frontend** : HTML5, CSS3, JavaScript (ES6+)
- **API** : REST API avec Laravel Sanctum
- **Stockage** : localStorage, MySQL

## Installation

1. Cloner le dépôt
2. **Backend** : Configurer Laravel et les routes API
3. **Frontend** : Les fichiers sont prêts à l'emploi
4. Configurer `BASE_URL` dans `assets/script.js`
5. Accéder à l'application via le navigateur

## Répartition des Tâches

### Backend (3 personnes)
- **Personne 1** : Gestion des utilisateurs (Patients & Docteurs)
- **Personne 2** : Gestion des rendez-vous
- **Personne 3** : Administration & gestion des docteurs

### Frontend (2 personnes)
- **Personne 4** : Interface utilisateur & structure HTML/CSS
- **Personne 5** : Dynamique et interaction JavaScript ✅ **COMPLÉTÉ**

## Documentation JavaScript

Consultez les fichiers dans `front end/` :
- `README_JS.md` - Guide rapide d'utilisation
- `DOCUMENTATION_JS.md` - Documentation complète
- `IMPLEMENTATION_RECAP.md` - Récapitulatif technique

## Auteur

aithalibi


