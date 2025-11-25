<?php
function getData() {
    // Vérifie si les données du formulaire ont été envoyées
    // renvoie les données du devis sous forme de tableau associatif
    // renvoie null si aucune donnée n'est présente
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST)) {
        return $_POST;
    } else {
        return null;
    }
}
?>