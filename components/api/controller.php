<?php
session_start();
include_once __DIR__ . '/_getData.php';
include_once __DIR__ . '/_anlyzeData.php';

include_once __DIR__ . '/pipeDrive/__fetchByPhone.php';
include_once __DIR__ . '/pipeDrive/__fetchByEmail.php';
include_once __DIR__ . '/pipeDrive/__addPerson.php';
include_once __DIR__ . '/pipeDrive/__addDeal.php';

include_once __DIR__ . '/__writteDevis.php';

include_once __DIR__ . '/../utils/loadEnv.php';



$data = getData();
if ($data === null) {
    $_SESSION['formError'] = "Une erreur est survenue lors de l'envoi de votre demande. Veuillez réessayer plus tard.";
    header('Location: ../page/formSended.php');
    exit;

} else {
    // continuer le traitement
    if (!isset($_ENV['TOKEN'])) {
        loadEnv(__DIR__ . '/../../.env');
    }

    // Analyse et traite les données
    $result = analyzeData($data);

    // Vérification du résultat
    if (is_string($result)) {
        $_SESSION['formError'] = $result;
        header('Location: ../../index.php?error=validation');
        exit;
    } else {


        $token = $_ENV['TOKEN'];
        // chercher l'ID de la personne via numéro de téléphone
        // si non trouvé, chercher l'ID via email
        $userId = null;

        if ($result['phone'] !== null) {
            $userId = fetchPersonByPhoneNumber($token, $result['phone'])['data']['items'][0]['item']['id'] ?? null;
        }
        if ($result['email'] !== null && $userId === null) {
            $userId = fetchPersonByEmail($token, $result['email'])['data']['items'][0]['item']['id'] ?? null;
        }
        if ($userId === null) {
            $userId = addPerson(
                $token,
                $result['name'],
                $result['surname'],
                $result['email'],
                $result['phone'],
                $result['address']
            )['data']['id']; // à tester
        }

        $devis = writteDevis($result);

        $deal = addDeal(
            $token,
            "Devis en ligne de " . $result['name'] . ' ' . $result['surname'],
            0,
            "EUR",
            $userId,
            $result['address'],
            $devis,
            $result['TVA'],
            $_ENV['ID_STAGE']
        );

        if (isset($deal['success']) && $deal['success'] === true) {
            $_SESSION['formSuccess'] = true;
        } else {
            $_SESSION['formError'] = "Une erreur est survenue lors de l'envoi de votre demande. Veuillez réessayer plus tard.";
        }

        header('Location: ../page/formSended.php');
        exit;
    }

}

?>