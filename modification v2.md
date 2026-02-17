# Modifications v2 - Formulaire Devis

## CSS et Interface

### Modales
- Modification de la taille des filtres dans les modales de sélection de modèles
- Modification du CSS des modales en général
- Augmentation de la hauteur maximale (max-height) du corps des modales pour améliorer la visibilité du contenu
- Ajustement des styles CSS pour les composants modaux afin d'améliorer la mise en page
- Correction des animations des rals standards

### Formulaire
- Modification du CSS pour la section des informations personnelles
- Amélioration de la mise en page du formulaire en CSS pour une meilleure réactivité
- Amélioration de la mise en page globale pour une meilleure expérience utilisateur

---

## DOM et Formulaire

### Champs de formulaire
- Ajout des champs de ville et de code postal dans l'en-tête du formulaire
- Ajout de champs honeypot cachés pour le système de détection anti-bot

### Organisation
- Changement de l'ordre de tous les sélecteurs de finitions
- Réorganisation des options dans les menus déroulants de sélection de produits pour une meilleure expérience utilisateur

### Messages
- Mise à jour du message de succès dans `formSended.php` pour plus de clarté

---

## Système de Messagerie

### Fonctionnalités d'envoi
- Ajout d'un système d'envoi de mail pour les clients
- Création de la fonction `sendClientMail` pour envoyer des emails de confirmation aux clients
- Mise à jour de la fonction `sendClientMail` pour utiliser une adresse email dynamique
- Commentaire de la gestion BCC (copie cachée)

### Contenu des emails
- Modification de l'intégralité des styles de corps de mail pour une meilleure compatibilité
- Amélioration des templates d'email pour une meilleure lisibilité et réactivité
- Ajout d'un en-tête de section pour les détails supplémentaires dans le corps de l'email
- Mise à jour du texte des mails selon qu'ils sont envoyés à un client ou non (dans `_writteMail.getProjects()`)

### Traitement des données
- Ajout d'un système de remise en place du texte pour gérer les caractères spéciaux dans les mails
- Mise à jour de `writteMail` pour utiliser une nouvelle fonction `dm` pour une meilleure désinfection des données
- Modification du champ adresse dans les mails pour obtenir plus d'informations

---

## Statistiques

### Base de données
- Création d'un système d'envoi à la base de données des statistiques récupérées depuis le sondage
- Ajout de la fonction `writteStats` pour enregistrer les statistiques dans la base de données
- Intégration de `writteStats` dans le contrôleur pour le suivi des soumissions de formulaire

### Requêtes SQL
- Ajout de requêtes SQL pour calculer les statistiques de projets et de sondages avec pourcentages
- Réorganisation des types de projets et des types de sondage dans le script d'initialisation de la base de données

---

## Sélecteur de RAL

### Système de secours
- Ajout d'un système hardcodé de sélection de RAL dans le cas où le serveur qui stocke les RALs est hors ligne

### Recherche
- Ajout d'une barre de recherche dans la modale de RAL (JavaScript)
- Amélioration de la fonctionnalité de recherche dans les modales

---

## Analyse des Données

### Traitement des adresses
- Ajout des nouvelles données d'adresse (ville et code postal)
- Ajustement de la gestion des adresses dans `analyzeData` pour inclure la ville et le code postal
- Modification du filtre d'assainissement pour la date

### Optimisation du code
- Suppression des lignes vides inutiles dans les fonctions de récupération de données pour un code plus propre
- Mise à jour des libellés d'options dans la fonction `getDataFromPergola` pour plus de cohérence

---

## Intégration PipeDrive

### Données de contact
- Modification des informations d'adresse
- Modification des fonctions `addPerson` et `addDeal` pour accepter le code postal et la localité
- Ajout des étiquettes dans l'ajout d'une personne

---

## Base de Données et Configuration

### Base de données
- Suppression du fichier obsolète `connect.php` et remplacement par une nouvelle implémentation
- Mise à jour de `init.sql` avec les nouvelles structures de données

### Configuration
- Mise à jour de `.env-backup` avec des options de configuration supplémentaires pour la base de données et le géocodage
- Refactorisation de la configuration d'environnement dans `.env-backup` pour plus de clarté et d'organisation

---

## Sécurité et Anti-Doublons

### Protection anti-bot
- Ajout de vérifications anti-bot dans le traitement des données
- Intégration de champs honeypot cachés pour détecter les bots

### Prévention des doublons
- Implémentation d'un système de stockage de fichiers JSON pour empêcher les soumissions en double
- Création d'un fichier JSON d'exemple pour les tests

---

## Corrections de Bugs

### Corrections techniques
- Correction de l'unité de mesure pour la longueur dans les fonctions `getCloture`
- Suppression du fichier obsolète `copy.json`
- Corrections diverses pour améliorer la stabilité du système

---

*Période : du 5 février au 16 février 2026*

