CREATE TABLE
  `utilisateur` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `email` VARCHAR(255) UNIQUE NOT NULL,
    `mot_de_passe` VARCHAR(255) NOT NULL,
    `role` ENUM ('client', 'technicien', 'admin') NOT NULL,
    `date_creation` TIMESTAMP DEFAULT (CURRENT_TIMESTAMP)
  );

CREATE TABLE
  `demande_reparation` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `id_utilisateur` INT,
    `type_service` ENUM ('réparation', 'entretien', 'dépannage') NOT NULL,
    `lieu_intervention` ENUM ('domicile', 'bureau', 'adresse personnalisée') NOT NULL,
    `plage_horaire` TIMESTAMP NOT NULL,
    `devis` DECIMAL(10, 2) NOT NULL,
    `statut` ENUM ('en attente', 'validée', 'terminée') DEFAULT 'en attente',
    `id_technicien` INT,
    `date_creation` TIMESTAMP DEFAULT (CURRENT_TIMESTAMP)
  );

CREATE TABLE
  `technicien` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `nom` VARCHAR(100) NOT NULL,
    `prenom` VARCHAR(100) NOT NULL,
    `email` VARCHAR(255) UNIQUE NOT NULL,
    `specialite` VARCHAR(255),
    `localisation` VARCHAR(255),
    `disponibilite` ENUM ('disponible', 'en intervention') DEFAULT 'disponible',
    `evaluation` DECIMAL(3, 2) DEFAULT 0
  );

CREATE TABLE
  `client` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `nom` VARCHAR(100) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `prenom` VARCHAR(100) NOT NULL,
    `adresse` TEXT NOT NULL,
    `telephone` VARCHAR(15)
  );

CREATE TABLE
  `intervention` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `id_demande_reparation` INT,
    `date_intervention` TIMESTAMP NOT NULL,
    `commentaire` TEXT,
    `evaluation_client` DECIMAL(3, 2),
    `statut` ENUM ('en cours', 'terminée') DEFAULT 'en cours'
  );

CREATE TABLE
  `historique_demandes` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `id_utilisateur` INT,
    `liste_demandes` text,
    `liste_notifications` TEXT
  );

CREATE TABLE
  `support_reclamation` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `id_utilisateur` INT,
    `id_technicien` INT,  
    `message_reclamation` TEXT NOT NULL,
    `statut` ENUM ('en cours', 'résolu') DEFAULT 'en cours',
    `date_creation` TIMESTAMP DEFAULT (CURRENT_TIMESTAMP),
    `reponse_support` TEXT
  );

ALTER TABLE `demande_reparation` ADD FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id`);

ALTER TABLE `demande_reparation` ADD FOREIGN KEY (`id_technicien`) REFERENCES `technicien` (`id`);

ALTER TABLE `intervention` ADD FOREIGN KEY (`id_demande_reparation`) REFERENCES `demande_reparation` (`id`);

ALTER TABLE `historique_demandes` ADD FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id`);

ALTER TABLE `support_reclamation` ADD FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id`);

ALTER TABLE `support_reclamation` ADD FOREIGN KEY (`id_technicien`) REFERENCES `technicien` (`id`);

ALTER TABLE `technicien` ADD FOREIGN KEY (`id`) REFERENCES `utilisateur` (`id`);

ALTER TABLE `client` ADD FOREIGN KEY (`id`) REFERENCES `utilisateur` (`id`);