# TODO - Formulaire Devis

## CSS
Faire le CSS du formulaire :
- formContainer
- formHeader
- sectionIdentite
- sectionPromotion
- projectsContainer
- projectHeader
- portail
- Portillon
- Clôture rigide
- Clôture béton
- Clôture aluminium
- Porte de garage
- Store
- Pergola
- Carport
- Fournitures
- Maçonnerie
- Autre
- projectFooter
- formFooter
- sondage

## JavaScript
- Fonction de validation du formulaire si champs numéro de téléphone et email sont vides avec `preventDefault()`
- Fonction pour annuler la sélection de couleur précise lors de la sélection de RAL par défaut
- Des sections dans les modales de portail par designs

## PHP
- Empêcher la sélection de finitions pour des couleurs dont les stocks sont insuffisants
- Créer des messages d'erreurs personnalisés pour chaque champ du formulaire
- Ajouter un message de confirmation avant la soumission du formulaire
- Rendre la modal de validation/erreur sur le formulaire au lieu d'une page à part
- Gérer système d'image avec google drive
- Ajouter un système de statistiques pour le sondage en MySQL ou Pipedrive

### Système de statistiques - Analyse
**Options :**

| Solution | Avantages | Inconvénients |
|----------|-----------|---------------|
| **Pipedrive** | Peut avoir l'info de l'avancement du deal | Peut-être impossible ou plus compliqué |
| **MySQL** | Très simple à mettre en place | Pas d'info sur l'avancement du deal |

**Solution proposée :** Utiliser MySQL et regarder si un nouvel utilisateur est créé pour avoir 2 catégories : première fois et déjà client
