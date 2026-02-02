# Guide d'intégration iframe avec WordPress

## Problème
Le formulaire est appelé via une iframe dans WordPress, mais les éléments HTML restent confinés à l'iframe et ne peuvent pas être directement manipulés par WordPress.

## Solution
Utilisation de l'API **postMessage** pour communiquer entre l'iframe et le parent (WordPress).

---

## Installation

### 1. Côté formulaire (iframe)
Le fichier `js/script.js` contient maintenant :
- `sendFormToParent()` : Envoie le HTML et les données du formulaire au parent
- `updateParentForm()` : Met à jour le parent à chaque modification du formulaire

**Automatiquement appelé après :**
- Ajout d'un projet
- Suppression d'un projet
- Initialisation du formulaire

### 2. Côté WordPress (parent)
Intégrez le fichier `js/iframeParent.js` dans votre template WordPress :

```html
<!-- Dans le footer du template ou en en-tête -->
<script src="/chemin/vers/formulaireDevis/js/iframeParent.js"></script>
```

Créez un conteneur pour recevoir le formulaire :

```html
<div id="formulaire-devis-container"></div>
<!-- ou l'iframe reste visible -->
<iframe id="devis-form" src="/formulaireDevis/"></iframe>
```

---

## Comment ça fonctionne

1. **Dans l'iframe** : Le formulaire envoie son contenu HTML et ses données au parent via `postMessage`
2. **Dans WordPress** : Un listener reçoit le message et peut :
   - Afficher le formulaire dans un conteneur DOM
   - Sauvegarder les données
   - Déclencher des actions WordPress

```javascript
// Message envoyé
{
    type: 'formulaireDevis',
    html: '<form>...</form>',
    data: [ { id: 1, type: 'Portail', ... }, ... ]
}
```

---

## Options d'utilisation

### Option 1 : Afficher le formulaire dans WordPress
```javascript
// Dans votre template WordPress
window.addEventListener('message', function(event) {
    if (event.data.type === 'formulaireDevis') {
        document.getElementById('formulaire-devis-container').innerHTML = event.data.html;
    }
});
```

### Option 2 : Récupérer les données du formulaire
```javascript
const formData = window.getFormData();
console.log(formData.data); // Array de projets
console.log(formData.html); // HTML du formulaire
```

### Option 3 : Communiquer avec l'iframe depuis WordPress
```javascript
window.sendMessageToIframe({
    type: 'mon-action',
    data: { ... }
});
```

---

## Sécurité

Par défaut, les messages sont acceptés de toute origine (`postMessage(message, '*')`).

**Pour plus de sécurité, modifiez :**

### Dans `js/iframeParent.js` :
```javascript
// Remplacez:
window.addEventListener('message', function(event) {

// Par:
window.addEventListener('message', function(event) {
    if (event.origin !== 'https://votre-domaine.com') return;
```

### Dans `js/script.js` :
```javascript
// Remplacez:
window.parent.postMessage({...}, '*');

// Par:
window.parent.postMessage({...}, 'https://wordpress-domaine.com');
```

---

## Dépannage

**Le message n'est pas reçu :**
- Vérifiez que l'iframe a la permission d'accès au parent
- Vérifiez la console du navigateur pour les erreurs
- Assurez-vous que le script WordPress est chargé après l'iframe

**L'HTML ne s'affiche pas :**
- Vérifiez que le conteneur `#formulaire-devis-container` existe
- Chargez les fichiers CSS du formulaire

**Les fonctions JavaScript de l'iframe ne fonctionnent pas :**
- Les scripts doivent être inclus avec le HTML envoyé
- Ou rechargez les modules JavaScript dans le parent
