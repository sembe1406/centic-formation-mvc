CREATE TABLE Participant (
   id_participant INT AUTO_INCREMENT,
   nom VARCHAR(50) NOT NULL,
   prenom VARCHAR(50) NOT NULL,
   sexe ENUM('M', 'F') NOT NULL,
   date_naissance DATE,
   lieu_naissance VARCHAR(100),
   telephone VARCHAR(20),
   PRIMARY KEY(id_participant)
);

CREATE TABLE Formateur (
   id_formateur INT AUTO_INCREMENT,
   nom VARCHAR(50) NOT NULL,
   telephone VARCHAR(20),
   email VARCHAR(100),
   specialite VARCHAR(100),
   PRIMARY KEY(id_formateur)
);

CREATE TABLE Formation (
   id_formation INT AUTO_INCREMENT,
   titre VARCHAR(100) NOT NULL,
   description TEXT NOT NULL,
   date_debut DATE,
   date_fin DATE,
   prix DECIMAL(10,2),
   PRIMARY KEY(id_formation)
);

-- Si une formation peut avoir plusieurs formateurs
CREATE TABLE Dispense (
   id_formation INT NOT NULL,
   id_formateur INT NOT NULL,
   PRIMARY KEY(id_formation, id_formateur),
   FOREIGN KEY(id_formation) REFERENCES Formation(id_formation),
   FOREIGN KEY(id_formateur) REFERENCES Formateur(id_formateur)
);

CREATE TABLE Seance (
   id_seance INT AUTO_INCREMENT,
   id_formation INT NOT NULL,
   date_session DATE,
   theme VARCHAR(100),
   PRIMARY KEY(id_seance),
   FOREIGN KEY(id_formation) REFERENCES Formation(id_formation)
);

CREATE TABLE Inscription (
   id_inscription INT AUTO_INCREMENT,
   id_participant INT NOT NULL,
   id_formation INT NOT NULL,
   date_inscription DATE,
   statut ENUM('en cours', 'terminé', 'annulé') DEFAULT 'en cours',
   PRIMARY KEY(id_inscription),
   FOREIGN KEY(id_participant) REFERENCES Participant(id_participant),
   FOREIGN KEY(id_formation) REFERENCES Formation(id_formation)
);

CREATE TABLE Paiement (
   id_paiement INT AUTO_INCREMENT,
   id_inscription INT NOT NULL,
   montant DECIMAL(15,2) NOT NULL,
   mode ENUM('espèces', 'mobile money', 'virement') NOT NULL,
   type_paiement ENUM('INSCRIPTION', 'TRANCHE') NOT NULL,
   date_paiement DATE,
   PRIMARY KEY(id_paiement),
   FOREIGN KEY(id_inscription) REFERENCES Inscription(id_inscription)
);

CREATE TABLE Presence (
   id_presence INT AUTO_INCREMENT,
   id_seance INT NOT NULL,
   id_inscription INT NOT NULL,
   est_present BOOLEAN DEFAULT FALSE,
   PRIMARY KEY(id_presence),
   UNIQUE(id_seance, id_inscription),
   FOREIGN KEY(id_seance) REFERENCES Seance(id_seance),
   FOREIGN KEY(id_inscription) REFERENCES Inscription(id_inscription)
);

-- Table pour l'authentification et les rôles
CREATE TABLE Utilisateur (
   id_utilisateur INT AUTO_INCREMENT,
   nom_utilisateur VARCHAR(50) NOT NULL UNIQUE,
   email VARCHAR(100) NOT NULL UNIQUE,
   mot_de_passe VARCHAR(255) NOT NULL,
   role ENUM('admin', 'formateur', 'participant') NOT NULL DEFAULT 'participant',
   est_actif BOOLEAN DEFAULT TRUE,
   date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
   date_modification DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
   derniere_connexion DATETIME,
   token_reset VARCHAR(100),
   expiration_token DATETIME,
   PRIMARY KEY(id_utilisateur)
);

-- Table de liaison entre utilisateurs et participants
CREATE TABLE Utilisateur_Participant (
   id_utilisateur INT NOT NULL,
   id_participant INT NOT NULL,
   PRIMARY KEY(id_utilisateur, id_participant),
   FOREIGN KEY(id_utilisateur) REFERENCES Utilisateur(id_utilisateur) ON DELETE CASCADE,
   FOREIGN KEY(id_participant) REFERENCES Participant(id_participant) ON DELETE CASCADE
);

-- Table de liaison entre utilisateurs et formateurs
CREATE TABLE Utilisateur_Formateur (
   id_utilisateur INT NOT NULL,
   id_formateur INT NOT NULL,
   PRIMARY KEY(id_utilisateur, id_formateur),
   FOREIGN KEY(id_utilisateur) REFERENCES Utilisateur(id_utilisateur) ON DELETE CASCADE,
   FOREIGN KEY(id_formateur) REFERENCES Formateur(id_formateur) ON DELETE CASCADE
);
