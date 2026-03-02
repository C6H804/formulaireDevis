<?php
include_once __DIR__ . '/../products/portail.php';
include_once __DIR__ . '/../products/portillon.php';
include_once __DIR__ . '/../products/clotureRigide.php';
include_once __DIR__ . '/../products/clotureBeton.php';
include_once __DIR__ . '/../products/clotureAluminium.php';
include_once __DIR__ . '/../products/porteGarage.php';
include_once __DIR__ . '/../products/store.php';
include_once __DIR__ . '/../products/pergola.php';
include_once __DIR__ . '/../products/carPort.php';
include_once __DIR__ . '/../products/fournitures.php';
include_once __DIR__ . '/../products/maconnerie.php';
include_once __DIR__ . '/../products/autre.php';

include_once __DIR__ . '/../products/_projectHeader.php';
include_once __DIR__ . '/../products/_projectFooter.php';
include_once __DIR__ . '/../utils/modelProject.php';
include_once __DIR__ . '/../utils/colorProject.php';

include_once __DIR__ . '/../utils/modals/ralModal.php';

include_once __DIR__ . '/../utils/ralButton.php';
include_once __DIR__ . '/../utils/modelButton.php';

include_once __DIR__ . '/../utils/modals/modelModal.php';

include_once __DIR__ . '/../utils/db/getModel.php';


header('Content-Type: text/html; charset=UTF-8');
if (isset($_POST['addProject'])) {

    global $formData;

    if (is_string($_POST['addProject'])) {
        $projectData = json_decode($_POST['addProject'], true);
    } else if (is_array($_POST['addProject'])) {
        $projectData = $_POST['addProject'];
    } else {
        $projectData = ['id' => 0, 'type' => 'Portail'];
    }

    $id = $projectData['id'];

    $type = $projectData['type'];

    $result = projectHeader($id, $type);


    switch ($type) {
        case "Portail":
            $result .= addPortail($id);
            break;
        case "Portillon":
            $result .= addPortillon($id);
            break;
        case "Clôture rigide":
            $result .= addClotureRigide($id);
            break;
        case "Clôture béton":
            $result .= addClotureBeton($id);
            break;
        case "Clôture aluminium":
            $result .= addClotureAluminium($id);
            break;
        case "Porte de garage":
            $result .= addPorteGarage($id);
            break;
        case "Store":
            $result .= addStore($id);
            break;
        case "Pergola":
            $result .= addPergola($id);
            break;
        case "Carport":
            $result .= addCarPort($id);
            break;
        case "Fournitures":
            $result .= addFournitures($id);
            break;
        case "Maçonnerie":
            $result .= addMaconnerie($id);
            break;
        default:
            $result .= addAutre($id);
            break;
    }

    $result .= projectFooter($id);
    echo $result;
}

if (isset($_POST['changeProject'])) {
    $projectData = json_decode($_POST['changeProject'], true);
    $id = $projectData['id'];
    $type = $projectData['type'];


    switch ($type) {
        case "Portail":
            echo addPortail($id);
            break;
        case "Portillon":
            echo addPortillon($id);
            break;
        case "Clôture rigide":
            echo addClotureRigide($id);
            break;
        case "Clôture béton":
            echo addClotureBeton($id);
            break;
        case "Clôture aluminium":
            echo addClotureAluminium($id);
            break;
        case "Porte de garage":
            echo addPorteGarage($id);
            break;
        case "Store":
            echo addStore($id);
            break;
        case "Pergola":
            echo addPergola($id);
            break;
        case "Carport":
            echo addCarPort($id);
            break;
        case "Fournitures":
            echo addFournitures($id);
            break;
        case "Maçonnerie":
            echo addMaconnerie($id);
            break;
        default:
            // echo $type;
            echo addAutre($id);
            break;
    }
}


if (isset($_POST['loadModal'])) {
    $projectData = json_decode($_POST['loadModal'], true);
    $id = $projectData['id'];
    $type = $projectData['type'];



    switch ($type) {
        case "ral":
            echo ralModal($id);
            break;
        case "portailBattant":
            echo modelPortailBattantsModal($id);
            break;
        case "portailCoulissant":
            echo modelPortailCoulissantModal($id);
            break;
        case "portillon":
            echo modelPortillonModal($id);
            break;
        case "clotureBeton":
            echo modelClotureBeton($id);
            break;
        case "clotureAluminium":
            echo modelClotureAluminiumModal($id);
            break;
        case "porteGarage":
            echo modelPorteGarageModal($id);
            break;
        case "store":
            echo modelStoreModal($id);
            break;
        default:
            echo "Type de modal inconnu, $type";
            break;
    }
}

?>