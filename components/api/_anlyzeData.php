<?php
/*
 * Analyse et valide les données du formulaire
 * 
 * Cette fonction effectue les opérations suivantes :
 * - Vérifie la présence des données obligatoires (nom, prénom, et au moins email ou téléphone)
 * - Valide et nettoie les données reçues (protection XSS, validation email/téléphone)
 * - Vérifie les contraintes de longueur pour le nom et le prénom (minimum 2 caractères)
 * - Traite les données optionnelles (adresse, code promo, TVA)
 * - Récupère et structure les données des projets associés
 * 
 * - Clés obligatoires : 'name', 'surname', et ('email' OU 'phone')
 * - Clés optionnelles : 'address', 'codePromo', 'TVA', 'projectIds'
 */


function sanitize($data = "", $type = "general") {
    if (!isset($data)) {
        return null;
    }

    if ($data === null || $data === "" || $data === false) {
        return null;
    }
    
    if (!is_string($data) && !is_numeric($data)) return null; // Seleument les chaînes et nombres
    if (is_numeric($data)) $data = strval($data); // Convertir les nombres en chaînes
    
    $data = trim($data);
    
    if (is_array($type)) {
        return in_array($data, $type, true) ? $data : null;
    }
    
    if ($data === null || $data === "" || $data === false) {
        return null;
    }

    switch ($type) {
        case "email":
            return filter_var($data, FILTER_VALIDATE_EMAIL) ? substr(htmlspecialchars($data), 0, 255) : null;
        case "phone":
            return preg_match('/^[0-9+\s()-]{6,20}$/', $data) ? substr(htmlspecialchars($data), 0, 255) : null;
        case "ral":
            return preg_match('/^[A-Z0-9]{3,10}$/', $data) ? substr(htmlspecialchars($data), 0, 255) : null;
        case "id":
            return preg_match('/^[0-9,]+$/', $data) ? substr(htmlspecialchars($data), 0, 255) : null;
        default:
            return htmlspecialchars($data);
    }
}


function analyzeData($data) {
    echo "<script>console.log(" .json_encode($data) . ");</script>";

    if (empty($data)) {
        return "Aucune donnée reçue.";
    } else {
        if (!isset($data['name']) || !isset($data['surname']) || (!isset($data['email']) && !isset($data['phone']))) {
            return "Données obligatoires manquantes.";
        } else {
            $result = [];

            $result['name'] = sanitize($data['name']);
            $result['surname'] = sanitize($data['surname']);

            if (isset($data['email'])) {
                $result['email'] = sanitize($data['email'], "email");
            }

            if (isset($data['phone'])) {
                $result['phone'] = sanitize($data['phone'], "phone");
            }

            if ($result['email'] === null && $result['phone'] === null) {
                return "Email ou téléphone invalide.";
            } else {
                if (strlen($result['name']) < 2 || strlen($result['surname']) < 2) {
                    return "Le nom et le prénom doivent contenir au moins 2 caractères.";
                } else {
                    $result['address'] = isset($data['address']) ? sanitize($data['address']) : '';
                    $result['codePromo'] = isset($data['codePromo']) ? sanitize($data['codePromo']) : '';
                    $result['TVA'] = $data['TVA'] === "true" ? true : false;

                    $result['projects'] = [];
                    echo "<script>console.log('projectIds reçu : ', " . json_encode($data['projectIds'] ?? 'NON DÉFINI') . ");</script>";
                    
                    if (isset($data['projectIds']) && sanitize($data['projectIds'], 'id') !== null) {
                        // Séparation des IDs de projets
                        $projectIds = explode(',', sanitize($data['projectIds'], 'id'));
                        echo "<script>console.log('IDs de projets à traiter : ', " . json_encode($projectIds) . ");</script>";

                        foreach ($projectIds as $id) {
                            $id = trim($id);
                            echo "<script>console.log('Traitement du projet ID : ', " . json_encode($id) . ");</script>";
                            echo "<script>console.log('Type de projet (selectProject" . $id . ") : ', " . json_encode($data['selectProject' . $id] ?? 'NON TROUVÉ') . ");</script>";
                            
                            // Vérification du type de projet et récupération des données spécifiques
                            if (isset($data['selectProject' . $id]) && verifyType($data['selectProject' . $id])) {
                                $project = getDataByType($id, $data['selectProject' . $id], $data);
                                echo "<script>console.log('Données du projet " . $id . ":', " . json_encode($project) . ");</script>";
                                if ($project !== null) {
                                    $result['projects'][$id] = $project;
                                } else {
                                    echo "<script>console.warn('Le projet " . $id . " est null (données incomplètes)');</script>";
                                }
                            } else {
                                echo "<script>console.warn('Le projet " . $id . " n\\'est pas valide ou son type n\\'existe pas');</script>";
                            }
                        }
                    } else {
                        echo "<script>console.error('projectIds est vide ou invalide !');</script>";
                    }
                    echo "<script>console.log('Nombre de projets traités:', " . count($result['projects']) . ");</script>";

                    // Récupération des images transmises
                    $imageUrl = getImages($data);
                    if ($imageUrl !== null) {
                        $result['imageUrl'] = $imageUrl;
                    }

                    // Récupération des données du sondage
                    $result['sondage'] = getSondage($data);
                    $details = getdetails($data);
                    if ($details !== "") {
                        $result['details'] = $details;
                    }

                    // Vérification de l'acceptation des CGU
                    if (!getCGU($data)) {
                        return "Les conditions générales d'utilisation doivent être acceptées.";
                    } else {
                        return $result;
                    }
                }
            }
        }
    }
}

function getdetails($data)
{
    $moreInfo = sanitize($data['moreInfo'] ?? null);
    return $moreInfo === null ? "" : $moreInfo;
}


function getCGU($data)
{
    $acceptCGU = sanitize($data['chkAcceptCGU'], ['on', null]) ?? null;
    return $acceptCGU === 'on' ? true : false;
}


function getSondage($data)
{
    $result = [];
    $google = sanitize($data['chkSondageGoogle'] ?? null, ['on', null]);
    $facebook = sanitize($data['chkSondageFacebook'] ?? null, ['on', null]);
    $instagram = sanitize($data['chkSondageInstagram'] ?? null, ['on', null]);
    $pinterest = sanitize($data['chkSondagePinterest'] ?? null, ['on', null]);
    $radio = sanitize($data['chkSondageRadio'] ?? null, ['on', null]);
    $boucheOreille = sanitize($data['chkSondageBoucheOreille'] ?? null, ['on', null]);
    $publiciteGrandMail = sanitize($data['chkSondagePubliciteGrandMail'] ?? null, ['on', null]);
    $publicitePapier = sanitize($data['chkSondagePublicitePapier'] ?? null, ['on', null]);
    $publiciteExterieure = sanitize($data['chkSondagePubliciteExterieure'] ?? null, ['on', null]);
    $routeBegaar = sanitize($data['chkSondageRouteBegaar'] ?? null, ['on', null]);
    $routeLescar = sanitize($data['chkSondageRouteLescar'] ?? null, ['on', null]);
    $autre = sanitize($data['chkSondageAutre'] ?? null, ['on', null]);


    if ($google === 'on')
        $result[] = 'Google';
    if ($facebook === 'on')
        $result[] = 'Facebook';
    if ($instagram === 'on')
        $result[] = 'Instagram';
    if ($pinterest === 'on')
        $result[] = 'Pinterest';
    if ($radio === 'on')
        $result[] = 'Radio';
    if ($boucheOreille === 'on')
        $result[] = 'Bouche à oreille';
    if ($publiciteGrandMail === 'on')
        $result[] = 'Publicité Grand Mail St Paul Lès Dax';
    if ($publicitePapier === 'on')
        $result[] = 'Publicité papier (Catalogue, prospectus, flyer)';
    if ($publiciteExterieure === 'on')
        $result[] = 'Publicité extérieure (Panneau publicitaire)';
    if ($routeBegaar === 'on')
        $result[] = "Sur la route, en passant devant l'agence à Bégaar";
    if ($routeLescar === 'on')
        $result[] = "Sur la route, en passant devant l'agence à Lescar";
    if ($autre === 'on')
        $result[] = 'Autre';

    return $result;
}




function verifyType($type)
{
    $validTypes = ['Portail', 'Portillon', 'Clôture rigide', 'Clôture beton', 'Clôture aluminium', 'Porte de garage', 'Store', 'Pergola', 'Carport', 'Fournitures', 'Maçonnerie', 'Autre'];
    foreach ($validTypes as $validType) {
        if ($type === $validType) {
            return true;
        }
    }
    return false;
}




function getDataByType($id, $type, $data)
{
    switch ($type) {
        case 'Portail':
            return getDataFromPortail($id, $data);
        case 'Portillon':
            return getDataFromPortillon($id, $data);
        case 'Clôture rigide':
            return getDataFromClotureRigide($id, $data);
        case 'Clôture beton':
            return getDataFromClotureBeton($id, $data);
        case 'Clôture aluminium':
            return getDataFromClotureAluminium($id, $data);
        case 'Porte de garage':
            return getDataFromPorteGarage($id, $data);
        case 'Store':
            return getDataFromStore($id, $data);
        case 'Pergola':
            return getDataFromPergola($id, $data);
        case 'Carport':
            return getDataFromCarport($id, $data);
        case 'Fournitures':
            return getDataFromFournitures($id, $data);
        case 'Maçonnerie':
            return getDataFromMaconnerie($id, $data);
        case 'Autre':
            return getDataFromAutre($id, $data);
        default:
            return null;

    }
}



function getColor($id, $data)
{
    if (($data['ralSelect' . $id] ?? '') === '') {
        return sanitize($data['ralStandard' . $id] ?? null);
    } else {
        return sanitize($data['ralSelect' . $id] ?? null);
    }
}






function getDataFromPortillon($id, $data)
{
    $result = [];
    $model = sanitize($data['modelSelect' . $id] ?? null);
    // $model = htmlspecialchars($data['modelSelect' . $id] ?? null);
    // Si aucun modèle sélectionné, ne pas prendre en compte le projet
    if ($model === null) {
        return null;
    }
    if (($data['ralSelect' . $id] ?? '') === '') {
        $color = sanitize($data['ralStandard' . $id] ?? null);
    } else {
        $color = sanitize($data['ralSelect' . $id] ?? null);
    }
    $finition = sanitize($data['finition' . $id] ?? null);
    $dimensionLongueur = sanitize($data['dimensionLongueur' . $id] ?? null);
    $dimensionHauteur = sanitize($data['dimensionHauteur' . $id] ?? null);
    $result = [
        "type" => "Portillon",
        "model" => $model === null ? "" : $model,
        "color" => $color === null ? "" : $color,
        "finition" => $finition === null ? "" : $finition,
        "longueur" => $dimensionLongueur === null ? "" : $dimensionLongueur,
        "hauteur" => $dimensionHauteur === null ? "" : $dimensionHauteur

    ];
    return $result;
}




function getDataFromPortail($id, $data)
{
    $result = [];
    $type = sanitize($data['typePortail' . $id] ?? null, ['Battant', 'Coulissant']);
    $automatisme = sanitize($data['automatisme' . $id] ?? null, ['Oui', 'Non']);
    if ($type === 'Battant') {
        // $model = htmlspecialchars($data['battant-modelSelect' . $id] ?? null);
        $model = sanitize($data['battant-modelSelect' . $id] ?? null);
        $sensOuverture = null;
        echo "<script>console.log('Portail Battant - Model recherché: battant-modelSelect" . $id . "', " . json_encode($data['battant-modelSelect' . $id] ?? 'NON TROUVÉ') . ");</script>";
    } else {
        $model = sanitize($data['coulissant-modelSelect' . $id] ?? null);
        $sensOuverture = sanitize($data['directionCoulissant' . $id] ?? null, ['Droite', 'Gauche']);
        echo "<script>console.log('Portail Coulissant - Model recherché: coulissant-modelSelect" . $id . "', " . json_encode($data['coulissant-modelSelect' . $id] ?? 'NON TROUVÉ') . ");</script>";
    }
    if ($model === null) {
        echo "<script>console.error('Portail ID " . $id . ": AUCUN MODÈLE SÉLECTIONNÉ ! Le projet sera ignoré.');</script>";
        return null;
    }
    try {
        $color = getColor($id, $data);
    } catch (Exception $e) {
        $color = null;
    }

    $finition = sanitize($data['finition' . $id] ?? null);

    $dimensionLongueur = sanitize($data['dimensionLongueur' . $id] ?? null);
    $dimensionHauteur = sanitize($data['dimensionHauteur' . $id] ?? null);

    $result = [
        "type" => "Portail",
        "typePortail" => $type === null ? "" : $type,
        "automatisme" => $automatisme === null ? "" : $automatisme,
        "model" => $model,  
        "sensOuverture" => $sensOuverture === null ? "" : $sensOuverture,
        "color" => $color === null ? "" : $color,
        "finition" => $finition === null ? "" : $finition,
        "longueur" => $dimensionLongueur === null ? "" : $dimensionLongueur,
        "hauteur" => $dimensionHauteur === null ? "" : $dimensionHauteur
    ];
    return $result;
}






function getDataFromClotureRigide($id, $data)
{
    $result = [];
    $kitOccultant = sanitize($data['kitOccultant' . $id] ?? null);
    $kitSoubassement = sanitize($data['kitSoubassement' . $id] ?? null);

    $color = sanitize($data['ralStandard' . $id] ?? null);

    $dimensionLongueur = sanitize($data['dimensionLongueur' . $id] ?? null);
    $dimensionHauteur = sanitize($data['dimensionHauteur' . $id] ?? null);


    $result = [
        "type" => "Clôture rigide",
        "kitOccultant" => $kitOccultant === null ? "" : $kitOccultant,
        "kitSoubassement" => $kitSoubassement === null ? "" : $kitSoubassement,
        "color" => $color === null ? "" : $color,
        "longueur" => $dimensionLongueur === null ? "" : $dimensionLongueur,
        "hauteur" => $dimensionHauteur === null ? "" : $dimensionHauteur
    ];
    return $result;
}




function getDataFromClotureBeton($id, $data)
{
    $result = [];
    $model = sanitize($data['modelSelect' . $id] ?? null);
    if ($model === null) {
        return null;
    }

    $longueur = sanitize($data['dimensionLongueur' . $id] ?? null);
    $hauteur = sanitize($data['dimensionHauteur' . $id] ?? null);
    $result = [
        "type" => "Clôture beton",
        "model" => $model,
        "longueur" => $longueur === null ? "" : $longueur,
        "hauteur" => $hauteur === null ? "" : $hauteur
    ];
    return $result;
}



function getDataFromClotureAluminium($id, $data)
{
    $result = [];

    $model = sanitize($data['modelSelect' . $id] ?? null);

    if ($model === null) {
        return null;
    }

    try {
        $color = getColor($id, $data);
    } catch (Exception $e) {
        $color = null;
    }
    $finition = sanitize($data['finition' . $id] ?? null);

    $dimensionLongueur = sanitize($data['dimensionLongueur' . $id] ?? null);
    $dimensionHauteur = sanitize($data['dimensionHauteur' . $id] ?? null);
    $result = [
        "type" => "Clôture aluminium",
        "model" => $model,
        "color" => $color === null ? "" : $color,
        "finition" => $finition === null ? "" : $finition,
        "longueur" => $dimensionLongueur === null ? "" : $dimensionLongueur,
        "hauteur" => $dimensionHauteur === null ? "" : $dimensionHauteur
    ];
    return $result;
}






function getDataFromPorteGarage($id, $data)
{
    $result = [];
    $model = sanitize($data['modelSelect' . $id] ?? null);

    if ($model === null) {
        return null;
    }

    try {
        $color = getColor($id, $data); // possiblement à supprimer
    } catch (Exception $e) {
        $color = null;
    }

    $result = [
        "type" => "Porte de garage",
        "model" => $model,
        "color" => $color === null ? "" : $color
    ];
    return $result;
}







function getDataFromStore($id, $data)
{
    $model = sanitize($data['modelSelect' . $id] ?? null);
    if ($model === null) {
        return null;
    }
    $largeur = sanitize($data['dimensionLargeur' . $id] ?? null);
    $projection = sanitize($data['projection' . $id] ?? null);
    $toileVerticale = sanitize($data['toileVerticale' . $id] ?? null, ['oui', 'non']);
    try {
        $color = getColor($id, $data);
    } catch (Exception $e) {
        $color = null;
    }
    $result = [
        "type" => "Store",
        "model" => $model,
        "color" => $color === null ? "": $color,
        "largeur" => $largeur === null ? "" : $largeur,
        "projection" => $projection === null ? "" : $projection,
        "toileVerticale" => $toileVerticale === null ? "" : $toileVerticale
    ];
    return $result;
}







function getDataFromPergola($id, $data)
{
    $largeur = sanitize($data['dimensionLargeur' . $id] ?? null);
    $hauteur = sanitize($data['dimensionHauteur' . $id] ?? null);
    $longueur = sanitize($data['dimensionLongueur' . $id] ?? null);
    $options = sanitize($data['options' . $id] ?? null, ['Aucune', 'LED', 'Store verticaux', 'chauffage', 'parois vitrées']);
    $result = [
        "type" => "Pergola",
        "largeur" => $largeur === null ? "" : $largeur,
        "hauteur" => $hauteur === null ? "" : $hauteur,
        "longueur" => $longueur === null ? "" : $longueur,
        "options" => $options === null ? "" : $options
    ];
    return $result;
}









function getDataFromCarport($id, $data)
{
    $largeur = sanitize($data['dimensionLargeur' . $id] ?? null);
    $hauteur = sanitize($data['dimensionHauteur' . $id] ?? null);
    $longueur = sanitize($data['dimensionLongueur' . $id] ?? null);

    try {
        $color = getColor($id, $data);
    } catch (Exception $e) {
        $color = null;
    }

    $finition = sanitize($data['finition' . $id] ?? null);
    $options = sanitize($data['options' . $id] ?? null, ['Aucune', 'LED']);

    $result = [
        "type" => "Carport",
        "largeur" => $largeur === null ? "" : $largeur,
        "hauteur" => $hauteur === null ? "" : $hauteur,
        "longueur" => $longueur === null ? "" : $longueur,
        "color" => $color === null ? "" : $color,
        "finition" => $finition === null ? "" : $finition,
        "options" => $options === null ? "" : $options
    ];
    return $result;
}







function getDataFromFournitures($id, $data)
{
    $visiophone = sanitize($data['visiophone' . $id] ?? null, ['on', null]);
    $digicode = sanitize($data['digicode' . $id] ?? null, ['on', null]);
    $interphone = sanitize($data['interphone' . $id] ?? null, ['on', null]);
    $fournituresPose = sanitize($data['fournituresPose' . $id] ?? null, ['on', null]);
    $automatisme = sanitize($data['automatisme' . $id] ?? null, ['on', null]);
    $result = [
        "type" => "Fournitures",
        "visiophone" => $visiophone === 'on' ? "Visiophone" : "",
        "digicode" => $digicode === 'on' ? "Digicode" : "",
        "interphone" => $interphone === 'on' ? "Interphone" : "",
        "fournituresPose" => $fournituresPose === 'on' ? "Fournitures Pose" : "",
        "automatisme" => $automatisme === 'on' ? "Automatisme" : ""
    ];
    return $result;
}




function getDataFromMaconnerie($id, $data)
{
    $piliers = sanitize($data['piliers' . $id] ?? null, ['on', null]);
    $piliersAluminium = sanitize($data['piliersAluminium' . $id] ?? null, ['on', null]);
    $seuil = sanitize($data['seuil' . $id] ?? null, ['on', null]);
    $refuite = sanitize($data['refuite' . $id] ?? null, ['on', null]);

    $result = [
        "type" => "Maçonnerie",
        "piliers" => $piliers === 'on' ? "Piliers béton" : "",
        "piliersAluminium" => $piliersAluminium === 'on' ? "Piliers aluminium" : "",
        "seuil" => $seuil === 'on' ? "Seuil de porte" : "",
        "refuite" => $refuite === 'on' ? "Réfuite" : ""
    ];
    return $result;
}


function getDataFromAutre($id, $data)
{
    $description = sanitize($data['descriptionAutre' . $id] ?? null);
    if ($description === null || $description === "") {
        return null;
    }
    $result = [
        "type" => "Autre",
        "descriptionAutre" => $description === null ? "" : $description
    ];
    return $result;
}

function getImages($data) {
    if (isset($_FILES["projectFile"])) {
        $file = $_FILES["projectFile"];
        if ($file["error"] === UPLOAD_ERR_OK && $file["size"] > 0 && $file["size"] <= 5 * 1024 * 1024) {
            if ($file["type"] === "image/jpeg" || $file["type"] === "image/png" || $file["type"] === "image/gif") {
                $imageUrl = getImageUrl($file);
                if ($imageUrl === "") {
                    return null;
                } else {
                    return $imageUrl;
                }
            } else {
                return null;
            }
        } else {
            return null;
        }
    } else {
        return null;
    }
}

?>