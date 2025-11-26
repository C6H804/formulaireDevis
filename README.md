# Formulaire Devis ACPORTAIL

## Objectifs
- Refonte du formulaire de devis ACPORTAIL
- Connexion avec Pipedrive pour insérer les clients et devis dans le CRM

## Fonctionnalités
- Formulaire dynamique via JavaScript et PHP
- Appel à l'API ACPORTAILRAL pour récupérer les couleurs RAL et finitions
- Appel à la base de données MySQL pour récupérer les modèles des produits
- Appel à l'API Pipedrive pour vérifier si un utilisateur existe déjà et créer un deal avec les informations du formulaire

## Technologies utilisées
- **HTML/CSS/JavaScript** : Interface utilisateur du formulaire
- **PHP** : Gestion serveur et appels API
- **MySQL** : Gestion des modèles de produits
- **API ACPORTAILRAL** : Récupération des couleurs RAL et finitions
- **API Pipedrive** : Gestion des clients et devis dans le CRM

## Fonctionnement du formulaire dynamique

### Ajout d'un projet
1. La fonction JavaScript `addProject` effectue un appel AJAX vers le script PHP `addProject` avec un type de produit
2. Le script PHP renvoie un bloc HTML avec les champs appropriés (les noms et IDs des champs dépendent de l'ID du projet)
3. Le JavaScript insère le bloc HTML dans le formulaire
4. Le JavaScript met à jour le champ caché `projectIds` pour indiquer la liste des IDs des projets ajoutés

### Appel à une modal de sélection de couleur ou modèle
1. Lors de pression du bouton de sélection de couleur ou modèle, une fonction JavaScript est appelée

### Soumission du formulaire
Le fichier `controller.php` gère la soumission du formulaire :

1. **Récupération des données** : Le PHP récupère les IDs des projets depuis `projectIds` et boucle dessus pour extraire les données de chaque projet
2. **Validation** : Vérification de la validité des données
3. **Gestion de l'utilisateur** :
   - Vérification dans Pipedrive si un utilisateur possède le numéro de téléphone ou l'email du formulaire
   - Si l'utilisateur existe, il est récupéré
   - Sinon, un nouvel utilisateur est créé dans Pipedrive
4. **Création du devis** : Une variable `$devis` est créée et contient la description de tous les projets du formulaire
5. **Création du deal** : Un deal est créé avec les informations du formulaire et lié à l'utilisateur
6. **Redirection** : Le controller redirige vers `formSended.php` qui affiche un message de succès ou d'erreur
7. **Protection** : Si la page est rafraîchie ou le bouton pressé à nouveau, renvoie vers la page d'accueil

## Architecture des fichiers

```
formulaireDevis/
│
├── index.php                           # Page d'accueil
├── form.php                            # Page principale du formulaire
├── requete insertion table.sql         # Script SQL pour la base de données
├── TODO.md                             # Liste des tâches à faire
├── README.md                           # Documentation du projet
│
├── components/                         # Composants de l'application
│   │
│   ├── api/                           # Gestion des API et contrôleurs
│   │   ├── controller.php             # Contrôleur principal de soumission du formulaire
│   │   ├── _getData.php               # Récupération des données
│   │   ├── _analyzeData.php           # Analyse et validation des données
│   │   ├── __writteDevis.php          # Génération du texte du devis
│   │   │
│   │   └── pipeDrive/                 # Intégration Pipedrive
│   │       ├── __fetchPersons.php     # Récupération des personnes
│   │       ├── __fetchByEmail.php     # Recherche par email
│   │       ├── __fetchByPhone.php     # Recherche par téléphone
│   │       ├── __checkPerson.php      # Vérification de l'existence d'une personne
│   │       ├── __addPerson.php        # Ajout d'une nouvelle personne
│   │       └── __addDeal.php          # Création d'un deal
│   │
│   ├── page/                          # Composants de pages
│   │   ├── header.php                 # En-tête du site
│   │   ├── footer.php                 # Pied de page du site
│   │   ├── formHeader.php             # En-tête du formulaire
│   │   ├── formBody.php               # Corps du formulaire
│   │   ├── formFooter.php             # Pied du formulaire
│   │   ├── formSended.php             # Page de confirmation d'envoi
│   │   └── sondage.php                # Questionnaire de satisfaction
│   │
│   ├── products/                      # Templates des produits
│   │   ├── _projectHeader.php         # En-tête de projet
│   │   ├── _projectFooter.php         # Pied de projet
│   │   ├── portail.php                # Formulaire portail
│   │   ├── portillon.php              # Formulaire portillon
│   │   ├── clotureRigide.php          # Formulaire clôture rigide
│   │   ├── clotureBeton.php           # Formulaire clôture béton
│   │   ├── clotureAluminium.php       # Formulaire clôture aluminium
│   │   ├── porteGarage.php            # Formulaire porte de garage
│   │   ├── store.php                  # Formulaire store
│   │   ├── pergola.php                # Formulaire pergola
│   │   ├── carPort.php                # Formulaire carport
│   │   ├── fournitures.php            # Formulaire fournitures
│   │   ├── maconnerie.php             # Formulaire maçonnerie
│   │   └── autre.php                  # Formulaire autre projet
│   │
│   └── utils/                         # Utilitaires
│       ├── __createInput.php          # Création d'inputs dynamiques
│       ├── loadEnv.php                # Chargement des variables d'environnement
│       ├── modelButton.php            # Bouton de sélection de modèle
│       ├── ralButton.php              # Bouton de sélection de couleur RAL
│       ├── modelProject.php           # Template de projet
│       ├── colorProject.php           # Gestion des couleurs de projet
│       │
│       ├── db/                        # Gestion base de données
│       │   ├── connect.php            # Connexion à la base de données
│       │   └── getModel.php           # Récupération des modèles
│       │
│       └── modals/                    # Modales
│           ├── modelModal.php         # Modale de sélection de modèle
│           └── ralModal.php           # Modale de sélection de couleur RAL
│
├── config/                            # Configuration
│
├── css/                               # Feuilles de style
│   └── modal.css                      # Styles des modales
│
└── js/                                # Scripts JavaScript
    ├── script.js                      # Script principal
    ├── _getModal.js                   # Gestion des modales
    │
    └── components/                    # Composants JavaScript
        ├── __CreateElement.js         # Création d'éléments DOM
        ├── __uncheckAll.js            # Désélection de tous les éléments
        ├── _AddProject.js             # Ajout de projet dynamique
        └── _ChangeProject.js          # Modification de projet
```

## TODO

Pour consulter la liste des tâches à réaliser, voir [TODO.md](TODO.md)
