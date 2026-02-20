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

include_once __DIR__ . '/imgbb/__getImage.php';

include_once __DIR__ . '/mail/_writteMail.php';
include_once __DIR__ . '/mail/_sendMail.php';

include_once __DIR__ . "/db/_writteStats.php";

include_once __DIR__ . "/copy.json";


$data = getData();
if ($data === null) {
    $_SESSION['formError'] = "Une erreur est survenue lors de l'envoi de votre demande. Veuillez réessayer plus tard.";
    header('Location: ../page/formSended.php');
    exit;
} else {

    // convertir $data d'un tableau associatif en une chaîne de caractères pour pouvoir la stocker dans un fichier json
    $dataString = json_encode($data);
    // récupérer les données du fichier copy.json
    $copyData = json_decode(file_get_contents(__DIR__ . "/copy.json"), true);
    // si copyData est strictement égal à $data, cela signifie que les données ont déjà été traitées récemment
    if ($copyData === null) {
        $copyData = [];
    }
    if ($copyData === $data) {
        $_SESSION['formSuccess'] = true;
        header('Location: ../page/formSended.php');
        exit;
    } else {
        // sinon, stocker les données dans copy.json
        file_put_contents(__DIR__ . "/copy.json", $dataString);
    }


    // continuer le traitement
    if (!isset($_ENV['TOKEN'])) {
        loadEnv(__DIR__ . '/../../.env');
    }

    // Analyse et traite les données
    $result = analyzeData($data);

    // Vérification du résultat
    if (is_string($result)) {
        $_SESSION['formError'] = $result;
        header('Location: ../page/formSended.php');
        exit;
    } else {

        // écrire les stats dans la base de données
        $stats = writteStats($result);
        if ($stats["valid"] === false) {
            $_SESSION['formError'] = $stats["message"];
            header('Location: ../page/formSended.php');
            exit;
        }

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
                $result["address"],
                $result["addressPostcode"],
                $result["addressCity"]
            )['data']['id'];
        }

        $devis = writteDevis($result);
        sendMail($result);

        if ($data["email"] !== null) {
            sendClientMail($result);
        }

        // echo $devis;

        $deal = addDeal(
            $token,
            "Devis en ligne de " . $result['name'] . ' ' . $result['surname'],
            0,
            "EUR",
            $userId,
            $result["addressFull"],
            $result["addressPostcode"],
            $result["addressCity"],
            $devis,
            $result['TVA'],
            $_ENV["ID_STAGE"] ?? 17
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