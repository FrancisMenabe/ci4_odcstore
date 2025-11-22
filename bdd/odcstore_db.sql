-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 22 nov. 2025 à 20:54
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `odcstore_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `accescash`
--

CREATE TABLE `accescash` (
  `id` int(10) UNSIGNED NOT NULL,
  `type_operation` varchar(50) NOT NULL,
  `nom_client` varchar(150) NOT NULL,
  `montant` decimal(15,2) NOT NULL,
  `compte` varchar(100) NOT NULL,
  `ref_transaction` varchar(150) DEFAULT NULL,
  `motif` text DEFAULT NULL,
  `date_operation` datetime NOT NULL,
  `responsable` varchar(150) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `caisse`
--

CREATE TABLE `caisse` (
  `id` int(10) UNSIGNED NOT NULL,
  `type` enum('entree','sortie') NOT NULL,
  `montant` decimal(15,2) NOT NULL,
  `categorie` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `responsable` varchar(150) NOT NULL,
  `date_operation` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cashpoint`
--

CREATE TABLE `cashpoint` (
  `id` int(10) UNSIGNED NOT NULL,
  `type_operation` varchar(50) NOT NULL,
  `nom_client` varchar(150) NOT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `montant` decimal(15,2) NOT NULL,
  `frais` decimal(15,2) NOT NULL DEFAULT 0.00,
  `benefice` decimal(15,2) NOT NULL DEFAULT 0.00,
  `responsable` varchar(150) NOT NULL,
  `date_operation` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `clients_solaire`
--

CREATE TABLE `clients_solaire` (
  `id` int(10) UNSIGNED NOT NULL,
  `nom_client` varchar(150) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `type_kit` varchar(100) NOT NULL,
  `prix_total` decimal(15,2) NOT NULL,
  `montant_mensuel` decimal(15,2) NOT NULL,
  `nombre_mois` int(11) NOT NULL,
  `date_debut` date NOT NULL,
  `prochaine_echeance` date NOT NULL,
  `retard_jours` int(11) NOT NULL DEFAULT 0,
  `responsable` varchar(150) NOT NULL,
  `date_inscription` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `journal_caisse`
--

CREATE TABLE `journal_caisse` (
  `id` int(10) UNSIGNED NOT NULL,
  `source` varchar(100) NOT NULL,
  `reference_id` int(11) NOT NULL,
  `libelle` varchar(255) NOT NULL,
  `type` enum('entree','sortie') NOT NULL,
  `montant` decimal(15,2) NOT NULL,
  `responsable` varchar(150) NOT NULL,
  `date_operation` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `paiements_solaire`
--

CREATE TABLE `paiements_solaire` (
  `id` int(10) UNSIGNED NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `mois_paye` varchar(20) NOT NULL,
  `montant` decimal(15,2) NOT NULL,
  `ref_transaction` varchar(150) DEFAULT NULL,
  `responsable` varchar(150) NOT NULL,
  `date_paiement` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

CREATE TABLE `produits` (
  `id` int(10) UNSIGNED NOT NULL,
  `reference` varchar(100) NOT NULL,
  `nom` varchar(150) NOT NULL,
  `quantite` int(11) NOT NULL DEFAULT 0,
  `prix_achat` decimal(15,2) NOT NULL,
  `prix_vente` decimal(15,2) NOT NULL,
  `description` text DEFAULT NULL,
  `fournisseur` varchar(150) DEFAULT NULL,
  `responsable` varchar(150) NOT NULL,
  `date_creation` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `nom` varchar(100) NOT NULL,
  `pseudo` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'user',
  `profile` varchar(255) NOT NULL DEFAULT 'default.png',
  `statut` varchar(20) NOT NULL DEFAULT 'actif',
  `date_creation` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `ventes`
--

CREATE TABLE `ventes` (
  `id` int(10) UNSIGNED NOT NULL,
  `reference_vente` varchar(100) NOT NULL,
  `produit_id` int(10) UNSIGNED NOT NULL,
  `quantite` int(11) NOT NULL DEFAULT 1,
  `nom_client` varchar(150) NOT NULL,
  `responsable` varchar(150) NOT NULL,
  `date_vente` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `accescash`
--
ALTER TABLE `accescash`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `caisse`
--
ALTER TABLE `caisse`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `cashpoint`
--
ALTER TABLE `cashpoint`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `clients_solaire`
--
ALTER TABLE `clients_solaire`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `journal_caisse`
--
ALTER TABLE `journal_caisse`
  ADD PRIMARY KEY (`id`),
  ADD KEY `source` (`source`),
  ADD KEY `reference_id` (`reference_id`);

--
-- Index pour la table `paiements_solaire`
--
ALTER TABLE `paiements_solaire`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `date_paiement` (`date_paiement`);

--
-- Index pour la table `produits`
--
ALTER TABLE `produits`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reference` (`reference`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `ventes`
--
ALTER TABLE `ventes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ventes_produit` (`produit_id`),
  ADD KEY `reference_vente` (`reference_vente`),
  ADD KEY `date_vente` (`date_vente`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `accescash`
--
ALTER TABLE `accescash`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `caisse`
--
ALTER TABLE `caisse`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `cashpoint`
--
ALTER TABLE `cashpoint`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `clients_solaire`
--
ALTER TABLE `clients_solaire`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `journal_caisse`
--
ALTER TABLE `journal_caisse`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `paiements_solaire`
--
ALTER TABLE `paiements_solaire`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `produits`
--
ALTER TABLE `produits`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `ventes`
--
ALTER TABLE `ventes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `paiements_solaire`
--
ALTER TABLE `paiements_solaire`
  ADD CONSTRAINT `fk_paiements_client` FOREIGN KEY (`client_id`) REFERENCES `clients_solaire` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `ventes`
--
ALTER TABLE `ventes`
  ADD CONSTRAINT `fk_ventes_produit` FOREIGN KEY (`produit_id`) REFERENCES `produits` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
