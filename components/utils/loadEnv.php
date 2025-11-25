<?php
/**
 * Charge les variables d'environnement depuis le fichier .env
 */
function loadEnv($path)
{
    if (!file_exists($path)) {
        throw new Exception("Le fichier .env n'existe pas : $path");
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
    foreach ($lines as $line) {
        // Ignorer les commentaires
        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        // Séparer clé et valeur
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);

            // Supprimer les guillemets si présents
            if (preg_match('/^(["\'])(.*)\\1$/', $value, $matches)) {
                $value = $matches[2];
            }

            // Définir la variable d'environnement si elle n'existe pas déjà
            if (!getenv($key)) {
                putenv("$key=$value");
                $_ENV[$key] = $value;
                $_SERVER[$key] = $value;
            }
        }
    }
}

// Charger automatiquement le .env depuis la racine du projet
$envPath = __DIR__ . '/../../.env';
if (file_exists($envPath)) {
    loadEnv($envPath);
}
?>
