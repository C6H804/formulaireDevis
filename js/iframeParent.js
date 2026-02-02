/**
 * Script à intégrer dans WordPress pour recevoir le formulaire depuis l'iframe
 * Place ce script dans le footer du template WordPress ou dans un fichier JS custom
 */

// Écouter les messages en provenance de l'iframe
window.addEventListener('message', function(event) {
    // Vérifier l'origine du message (optionnel mais recommandé pour la sécurité)
    // if (event.origin !== 'https://votre-domaine.com') return;
    
    if (event.data && event.data.type === 'formulaireDevis') {
        console.log('Message reçu du formulaire:', event.data);
        
        // Option 1: Afficher le formulaire dans un conteneur WordPress
        const container = document.getElementById('formulaire-devis-container');
        if (container) {
            container.innerHTML = event.data.html;
            // Réappliquer les styles et scripts si nécessaire
            applyFormStyles();
        }
        
        // Option 2: Déclencher une action WordPress personnalisée
        if (typeof wpAjax !== 'undefined') {
            wpAjax.send('formulaire_recu', {
                html: event.data.html,
                data: event.data.data
            });
        }
        
        // Option 3: Sauvegarder les données
        sessionStorage.setItem('formulaire-devis', JSON.stringify(event.data));
    }
});

// Fonction pour appliquer les styles au formulaire injecté
function applyFormStyles() {
    // Charger les CSS du formulaire si nécessaire
    const cssFiles = [
        'css/main.css',
        'css/form.css',
        'css/modal.css'
    ];
    
    cssFiles.forEach(cssFile => {
        if (!document.querySelector(`link[href*="${cssFile}"]`)) {
            const link = document.createElement('link');
            link.rel = 'stylesheet';
            link.href = cssFile;
            document.head.appendChild(link);
        }
    });
}

// Exposer une fonction pour interagir avec l'iframe
window.sendMessageToIframe = function(message) {
    const iframe = document.querySelector('iframe[src*="formulaireDevis"]');
    if (iframe) {
        iframe.contentWindow.postMessage(message, '*');
    }
}

// Recevoir les données du formulaire soumis
window.getFormData = function() {
    return JSON.parse(sessionStorage.getItem('formulaire-devis')) || null;
}
