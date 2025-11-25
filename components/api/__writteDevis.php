<?php

function writteDevis($data)
{
    $nbrProjects = count($data['projects']);
    if ($nbrProjects > 0) {
        $t = "Devis contenant " . $nbrProjects . " projet(s) : \n";
        for ($i = 0; $i < $nbrProjects; $i++) {
            $project = $data['projects'][$i];
            $t .= "Projet n°" . ($i + 1) . " : " . $project['type'];
            $t .= getProjectData($project);
        }
    } else {
        $t = "Aucun projet à traiter du à une mauvaise récupération des données.";
    }
    return $t;
}







function getProjectData($project) {
    switch ($project['type']) {
        case "Portail":
            return getDevisPortail($project);
        case "Portillon":
            return getDevisPortillon($project);
        case "Clôture rigide":
            return getClotureRigide($project);
        case "Clôture beton":
            return getClotureBeton($project);
        case "Clôture aluminium":
            return getClotureAluminium($project);
        case "Porte de garage":
            return getPorteGarage($project);
        case "Store":
            return getStore($project);
        case "Pergola":
            return getPergola($project);
        case "Carport":
            return getCarport($project);
        case "Fournitures":
            return getFournitures($project);
        case "Maçonnerie":
            return getMaconnerie($project);
        default:
            return null;
    }
}












function manageColor($c) {
    // regex to detect if starts with a number
    if (preg_match('/^\d+/', $c)) {
        return "RAL " . $c;
    }
    return $c;
}


function getDevisPortail($p) {
    if ($p['typePortail'] === "Coulissant") {
        $r = " Coulissant \n";
        $r .= "- Sens d'ouverture : " . $p['sensOuverture'] . " \n";
    } else {
        $r = " Battant \n";
    }
    $r .= "- model : " . $p['model'] . " \n";
    $color = manageColor($p['color']);
    $r .= "- Couleur : " . $color . " | " . $p['finition'] . " \n";
    $r .= "- Dimensions :  \n";
    $r .= "  - Hauteur : " . $p['hauteur'] . " cm \n";
    $r .= "  - Longueur : " . $p['longueur'] . " cm \n";
    $r .= $p['automatisme'] === "oui" ? "- Avec automatisme \n" : "- Sans automatisme \n";
return $r;
}


function getDevisPortillon($p) {
    $r = " \n";
    $r .= "- model : " . $p['model'] . " \n";
    $color = manageColor($p['color']);
    $r .= "- Couleur : " . $color . " | " . $p['finition'] . " \n";
    $r .= "- Dimensions :  \n";
    $r .= "  - Hauteur : " . $p['hauteur'] . " cm \n";
    $r .= "  - Longueur : " . $p['longueur'] . " cm \n";
    return $r;
}

function getClotureRigide($p) {
    $r = " \n";
    $color = manageColor($p['color']);
    $r .= "- Couleur : " . $color . " \n";
    $r .= "- Dimensions :  \n";
    $r .= "  - Hauteur : " . $p['hauteur'] . " m \n";
    $r .= "  - Longueur : " . $p['longueur'] . " cm \n";
    if ($p['kitOccultant'] === "Oui" || $p['kitSoubassement'] === "Oui") {
        $r .= "- Options :  \n";
        
        if ($p['kitOccultant'] === "Oui") {
            $r .= "  - Kit occultant \n";
        }
        if ($p['kitSoubassement'] === "Oui") {
            $r .= "  - Kit soubassement \n";
        }
    }
    return $r;
}

function getClotureBeton($p) {
    $r = " \n";
    $r .= "- Modèle : " . $p['model'] . " \n";
    $r .= "- Dimensions :  \n";
    $r .= "  -Hauteur : " . $p['hauteur'] . " cm \n";
    $r .= "  -Longueur : " . $p['longueur'] . " cm \n";
    return $r;

}

function getClotureAluminium($p) {
    $r = " \n";
    $r .= "- Modèle : " . $p['model'] . " \n";
    $color = manageColor($p['color']);
    $r .= "- Couleur : " . $color . " | finition " . $p['finition'] . " \n";
    $r .= "- Dimensions :  \n";
    $r .= "  - Hauteur : " . $p['hauteur'] . " m \n";
    $r .= "  - Longueur : " . $p['longueur'] . " cm \n";
    return $r;
}

function getPorteGarage($p) {
    $r = " " . $p['typePorteGarage'] . " \n";
    $r .= "- Modèle : " . $p['model'] . " \n";
    $color = manageColor($p['color']);
    $r .= "- Couleur : " . $color . " \n";
    return $r;
}

function getStore($p) {
    $r = " \n";
    $r .= "- Modèle : " . $p['model'] . " \n";
    $r .= "- Dimensions :  \n";
    $r .= "  - Largeur : " . $p['largeur'] . " cm \n";
    return $r;
}

function getPergola($p): string {
    $r = " \n";
    $r .= "- Dimensions :  \n";
    $r .= "  - Longueur : " . $p['longueur'] . " cm \n";
    $r .= "  - Largeur : " . $p['largeur'] . " cm \n";
    $r .= "  - Hauteur : " . $p['hauteur'] . " cm \n";
    $r .= "- Options :  \n";
    $r .= $p['options'] . " \n";
    return $r;
}

function getCarport($p) {
    $r = " \n";
    $r .= "- Dimensions :  \n";
    $r .= "  - Longueur : " . $p['longueur'] . " cm \n";
    $r .= "  - Largeur : " . $p['largeur'] . " cm \n";
    $r .= "  - Hauteur : " . $p['hauteur'] . " cm \n";
    $color = manageColor($p['color']);
    $r .= "- Couleur : " . $color . " | finitions " . $p['finition'] . " \n";
    $r .= "- Options : " . $p['options'] . " \n";
    return $r;
}

function getFournitures($p) {
    $r = " \n";
    if ($p['automatisme'] === "" && $p['digicode'] === "" && $p['fournituresPose'] === "" && $p['interphone'] === "" && $p['visiophone'] === "") {
        $r .= "Aucune fourniture sélectionnée. \n";
    } else {
        $r .= "- Fournitures :  \n  - ";
        $r .= $p['automatisme'] === "" ? "" : $p['automatisme'] . ", ";
        $r .= $p['digicode'] === "" ? "" : $p['digicode'] . ", ";
        $r .= $p['fournituresPose'] === "" ? "" : $p['fournituresPose'] . ", ";
        $r .= $p['interphone'] === "" ? "" : $p['interphone'] . ", ";
        $r .= $p['visiophone'] === "" ? "" : $p['visiophone'] . ", ";
        $r = substr($r, 0, -2);
        $r .= " \n";
    }
    return $r;
}

function getMaconnerie($p) {
    $r = " \n";
    if ($p['piliers'] === "" && $p['piliersAluminium'] === "" && $p['refuite'] === "" && $p['seuil'] === "") {
        $r .= "Aucune option maçonnerie sélectionnée. \n";
    } else {
        $r .= "- Options maçonnerie :  \n  - ";
        $r .= $p['piliers'] === "" ? "" : "Piliers en béton, ";
        $r .= $p['piliersAluminium'] === "" ? "" : "Piliers en aluminium, ";
        $r .= $p['refuite'] === "" ? "" : "Refuite, ";
        $r .= $p['seuil'] === "" ? "" : "Seuil, ";
        $r = substr($r, 0, -2);
        $r .= " \n";
    }
    return $r;
}

?>