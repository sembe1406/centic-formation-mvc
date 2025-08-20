# Centic Formation MVC

Application de gestion des formations, formateurs, participants, présences et paiements.

## Description

Centic Formation est une application MVC en PHP qui permet de gérer:

- Formations (création, modification, suppression)
- Formateurs et participants
- Inscriptions aux formations
- Séances de formation et suivi des présences
- Paiements (inscriptions et tranches)
- Génération de rapports
- Authentification et gestion des rôles (Admin, Formateur, Participant)

## Prérequis

- PHP 7.4 ou supérieur
- MySQL 5.7 ou supérieur
- Serveur web (Apache, Nginx) ou serveur PHP intégré

## Installation

1. Cloner le dépôt
```
git clone https://github.com/sembe1406/centic-formation-mvc.git
cd centic-formation-mvc
```

2. Créer la base de données
```sql
CREATE DATABASE centic_formation CHARACTER SET utf8 COLLATE utf8_general_ci;
```

3. Importer le schéma SQL
```
mysql -u [username] -p centic_formation < schema.sql
```

4. Configurer la base de données

Ouvrir le fichier `config/config.php` et modifier les paramètres de connexion à la base de données:
```php
'database' => [
    'host' => 'localhost',
    'name' => 'centic_formation',
    'user' => 'root',
    'password' => '',
    'charset' => 'utf8',
],
```

5. Lancer l'application

Si vous utilisez un serveur web (Apache, Nginx), configurez le document root vers le dossier `public/`.

Pour utiliser le serveur PHP intégré:
```
cd public
php -S localhost:8000
```

## Structure du projet

```
centic-formation-mvc/
├── app/                    # Cœur de l'application
│   ├── Controllers/        # Contrôleurs
│   ├── Core/               # Classes de base (Database, Router, Controller)
│   ├── Middleware/         # Middleware (Auth, etc.)
│   ├── Models/             # Modèles
│   └── views/              # Vues
│       └── layouts/        # Layouts pour les vues
├── config/                 # Configuration
│   ├── config.php          # Configuration de l'application
│   └── routes.php          # Définition des routes
├── core/                   # Classes de base globales
│   ├── Controller.php      # Classe Controller de base
│   ├── Model.php           # Classe Model de base
│   └── View.php            # Classe View de base
├── public/                 # Dossier public accessible
│   ├── css/                # Feuilles de style
│   ├── files/              # Fichiers téléchargeables
│   ├── js/                 # JavaScript
│   └── index.php           # Point d'entrée de l'application
└── schema.sql              # Schéma de la base de données
```

## Fonctionnalités

### Gestion des formations
- Liste des formations
- Création, modification et suppression de formations
- Affichage des détails d'une formation
- Association des formateurs aux formations

### Gestion des participants
- Inscription des participants
- Gestion des profils des participants
- Suivi des formations suivies

### Gestion des formateurs
- Enregistrement des formateurs
- Attribution des formations
- Gestion des spécialités

### Suivi des présences
- Enregistrement des présences par séance
- Génération de rapports de présence
- Statistiques de présence par formation

### Gestion des paiements
- Enregistrement des paiements (inscription, tranches)
- Suivi des paiements par participant
- États des paiements par formation

### Rapports
- Rapports sur les formations
- Rapports sur les participants
- Rapports sur les paiements
- Rapports sur les présences

### Authentification et autorisations
- Connexion/Déconnexion
- Inscription des utilisateurs
- Gestion des rôles (Admin, Formateur, Participant)
- Restrictions d'accès basées sur les rôles

## Routes principales

- `/` - Page d'accueil
- `/login` - Connexion
- `/register` - Inscription
- `/dashboard` - Tableau de bord
- `/formations` - Liste des formations
- `/formations/{id}` - Détails d'une formation
- `/participants` - Liste des participants
- `/formateurs` - Liste des formateurs
- `/inscriptions` - Liste des inscriptions
- `/seances` - Liste des séances
- `/presences` - Gestion des présences
- `/paiements` - Gestion des paiements
- `/rapports` - Génération de rapports

## Modèle de données

L'application utilise le modèle de données suivant:

- **Participant**: Informations sur les participants
- **Formateur**: Informations sur les formateurs
- **Formation**: Détails des formations proposées
- **Seance**: Séances de formation
- **Inscription**: Inscriptions des participants aux formations
- **Paiement**: Paiements effectués
- **Presence**: Suivi des présences par séance
- **Utilisateur**: Gestion des utilisateurs et authentification

## Développement

### Ajouter une nouvelle fonctionnalité

1. Créer un nouveau modèle dans `app/Models/` si nécessaire
2. Créer un nouveau contrôleur dans `app/Controllers/`
3. Ajouter les vues correspondantes dans `app/views/`
4. Définir les routes dans `config/routes.php`

### Tests

L'application ne dispose pas encore d'une suite de tests automatisés.

## Contribution

1. Fork le projet
2. Créer une branche pour votre fonctionnalité (`git checkout -b feature/ma-fonctionnalite`)
3. Commiter vos changements (`git commit -am 'Ajout de ma fonctionnalité'`)
4. Pousser votre branche (`git push origin feature/ma-fonctionnalite`)
5. Créer une Pull Request

## Licence

Ce projet est sous licence [MIT](LICENSE).

## Contact

Pour toute question ou suggestion, veuillez contacter [l'équipe Centic](mailto:contact@centic.com).
