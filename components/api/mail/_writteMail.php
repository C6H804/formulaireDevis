<?php
function writteMail($data)
{
    // retourne le body du mail à envoyer
    ob_start();
    ?>
    <h1>Demande de devis en ligne</h1>
    <div><i>Reçu le <?php echo date('d/m/Y \à H:i'); ?></i></div>
    <h2>Informations personnelles</h2>
    <?php echo getPersonalInfoM($data); ?>
    <?php echo getProjectsM($data); ?>
    <?php echo getDetailsSupplementairesM($data); ?>

    <?php echo style() ?>
    <?php
    return ob_get_clean();
}

function getDetailsSupplementairesM($data) {
    ob_start();
    if (isset($data['details'])) {
        echo "<h2>Détails supplémentaires</h2>";
        echo "<div><b>Détails supplémentaires :</b>";
        echo "<div class='delay'>" . htmlspecialchars($data['details']) . "</div>";    
    }
    echo getImageCodeM($data);
    echo getSondageTextM($data);
    echo getCodePromoTextM($data);
    return ob_get_clean();
}

function getCodePromoTextM($data) {
    ob_start();
    if (isset($data["codePromo"])) {
        echo "<div><b>Code promotionnel utilisé : </b><div class='delay'>" . htmlspecialchars($data["codePromo"]) . "</div></div>";
    }
    return ob_get_clean();
}

function getSondageTextM($data) {
    ob_start();
    if (isset($data["sondage"]) && count($data["sondage"]) > 0) {
        echo "<div><b>A entendu parlé de l'entreprise via :</b></div>";
        echo "<div class='list'>";
        foreach($data["sondage"] as $response) {
            echo "<div class='delay'>" . htmlspecialchars($response) . "</div>";
        }
        echo "</div>";
    }
    return ob_get_clean();
}

function getImageCodeM($data) {
    if (isset($data['imageUrl'])) {
        return "<div><b>Image du projet : </b><a href='" . htmlspecialchars($data['imageUrl']) . "'>" . htmlspecialchars($data['imageUrl']) . "</a></div>";
    } else {
        return "";
    }
}

function getPersonalInfoM($data)
{
    $nom = $data["name"] ?? "Non renseigné";
    $prenom = $data["surname"] ?? "Non renseigné";
    $email = $data["email"] ?? "Non renseigné";
    $adresse = $data["address"] ?? "Non renseigné";
    $telephone = $data["phone"] ?? "Non renseigné";


    ob_start();
    ?>
    <div class="infoPerso">
        <div class="inputLineNotLast">
            <div><b>Nom : </b></div>
            <div class="delay"><?php echo htmlspecialchars($nom); ?></div>
        </div>
        <div class="inputLineNotLast">
            <div><b>Prénom : </b></div>
            <div class="delay"><?php echo htmlspecialchars($prenom); ?></div>
        </div>
        <div class="inputLineNotLast">
            <div><b>Email : </b></div>
            <div class="delay"><?php echo htmlspecialchars($email); ?></div>
        </div>
        <div class="inputLineNotLast">
            <div><b>Téléphone : </b></div>
            <div class="delay"><?php echo htmlspecialchars($telephone); ?></div>
        </div>
        <div class="inputLineLast">
            <div><b>Adresse : </b></div>
            <div class="delay"><?php echo htmlspecialchars($adresse); ?></div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

function getProjectsM($data) {
    $nbrProjects = count($data['projects'] ?? []);
    
    
    ob_start();
    ?>
    <h2>Devis (<?php echo $nbrProjects; ?> projet<?php echo $nbrProjects > 1 ? 's' : ''; ?>)</h2>
    <div class="Devis">
        <?php
        foreach (($data["projects"] ?? []) as $projectId => $project) {
            echo "<div class='project'>";
            echo "<h3>" . htmlspecialchars($project['type'] ?? 'Non spécifié') . "</h3>";
            echo getProjectDataM($project);
            echo "</div>";
        }
        ?>

    </div>
    <?php
    return ob_get_clean();
}

function getProjectDataM($project) {
    switch ($project['type'] ?? '') {
        case "Portail":
            return getDevisPortailM($project);
        case "Portillon":
            return getDevisPortillonM($project);
        case "Clôture rigide":
            return getClotureRigideM($project);
        case "Clôture beton":
            return getClotureBetonM($project);
        case "Clôture aluminium":
            return getClotureAluminiumM($project);
        case "Porte de garage":
            return getPorteGarageM($project);
        case "Store":
            return getStoreM($project);
        case "Pergola":
            return getPergolaM($project);
        case "Carport":
            return getCarportM($project);
        case "Fournitures":
            return getFournituresM($project);
        case "Maçonnerie":
            return getMaconnerieM($project);
        case "Autre":
            return getAutreM($project);
        default:
            return null;
    }
}

function getAutreM($p) {
    ob_start();
    echo "<div><b>Description : </b></div>";
    echo "<div class='delay'>" . htmlspecialchars($p['descriptionAutre'] ?? '') . "</div>";
    return ob_get_clean();
}

function getMaconnerieM($p) {
    ob_start();
    $piliers = $p['piliers'] ?? "";
    $piliersAluminium = $p['piliersAluminium'] ?? "";
    $refuite = $p['refuite'] ?? "";
    $seuil = $p['seuil'] ?? "";
    
    if ($piliers === "" && $piliersAluminium === "" && $refuite === "" && $seuil === "") {
        echo "<div><b>Aucune option maçonnerie sélectionnée</b></div>";
    } else {
        echo "<div><b>Options maçonnerie : </b></div>";
        echo "<div class='list'>";
        if ($piliers !== "") echo "<div>" . htmlspecialchars($piliers) . "</div>";
        if ($piliersAluminium !== "") echo "<div>" . htmlspecialchars($piliersAluminium) . "</div>";
        if ($refuite !== "") echo "<div>" . htmlspecialchars($refuite) . "</div>";
        if ($seuil !== "") echo "<div>" . htmlspecialchars($seuil) . "</div>";
        echo "</div>";
    }
    return ob_get_clean();
}

function getFournituresM($p) {
    ob_start();
    $automatisme = $p['automatisme'] ?? "";
    $digicode = $p['digicode'] ?? "";
    $fournituresPose = $p['fournituresPose'] ?? "";
    $interphone = $p['interphone'] ?? "";
    $visiophone = $p['visiophone'] ?? "";
    
    if ($automatisme === "" && $digicode === "" && $fournituresPose === "" && $interphone === "" && $visiophone === "") {
        echo "<div><b>Aucune fourniture sélectionnée</b></div>";
    } else {
        echo "<div><b>Fournitures : </b></div>";
        echo "<div class='list'>";
        if ($automatisme !== "") echo "<div class='delay'>" . htmlspecialchars($automatisme) . "</div>";
        if ($digicode !== "") echo "<div class='delay'>" . htmlspecialchars($digicode) . "</div>";
        if ($fournituresPose !== "") echo "<div class='delay'>" . htmlspecialchars($fournituresPose) . "</div>";
        if ($interphone !== "") echo "<div class='delay'>" . htmlspecialchars($interphone) . "</div>";
        if ($visiophone !== "") echo "<div class='delay'>" . htmlspecialchars($visiophone) . "</div>";
        echo "</div>";
    }
    return ob_get_clean();
}

function getCarportM($p) {
    ob_start();
    echo "<div class='dimension'>";
    echo "<div class='first'><b>Dimensions :</b></div>";
    echo "<div><b>Longueur :</b> " . htmlspecialchars($p["longueur"] ?? '') . " cm</div>";
    echo "<div><b>Largeur :</b> " . htmlspecialchars($p["largeur"] ?? '') . " cm</div>";
    echo "<div><b>Hauteur :</b> " . htmlspecialchars($p["hauteur"] ?? '') . " cm</div>";
    echo "</div>";

    return ob_get_clean();
}

function getPergolaM($p): string {
    ob_start();
    echo "<div class='dimension'>";
    echo "<div class='first'><b>Dimensions :</b></div>";
    echo "<div><b>Longueur :</b> " . htmlspecialchars($p["longueur"] ?? '') . " cm</div>";
    echo "<div><b>Largeur :</b> " . htmlspecialchars($p["largeur"] ?? '') . " cm</div>";
    echo "<div><b>Hauteur :</b> " . htmlspecialchars($p["hauteur"] ?? '') . " cm</div>";
    echo "</div>";
    echo "<div><b>Options : </b>" . htmlspecialchars($p["options"] ?? '') . "</div>";
    return ob_get_clean();
}

function getStoreM($p) {
    ob_start();
    echo "<div><b>Modèle : </b>" . htmlspecialchars($p["model"] ?? '') . "</div>";
    echo "<div><b>Couleur : </b>" . htmlspecialchars(manageColor($p["color"] ?? '')) . "</div>";
    echo "<div class='dimension'>";
    echo "<div class='first'><b>Dimensions :</b></div>";
    echo "<div><b>Largeur : </b>" . htmlspecialchars($p["largeur"] ?? '') . " m</div>";
    echo "<div><b>Projection : </b>" . htmlspecialchars($p["projection"] ?? '') . " m</div>";
    echo "<div><b>Toile verticale : </b>" . htmlspecialchars($p["toileVerticale"] ?? '') . "</div>";
    echo "</div>";
    return ob_get_clean();
}


function getPorteGarageM($p) {
    ob_start();
    echo "<div><b>Modèle :</b> " . htmlspecialchars($p["model"] ?? '') . "</div>";
    $finition = !empty($p["finition"]) ? " | " . htmlspecialchars($p["finition"]) : "";
    echo "<div><b>Couleur :</b> " . htmlspecialchars(manageColor($p["color"] ?? '')) . $finition . "</div>";
    return ob_get_clean();
}

function getClotureAluminiumM($p) {
    ob_start();
    echo "<div><b>Modèle :</b> " . htmlspecialchars($p["model"] ?? '') . "</div>";
    $finition = !empty($p["finition"]) ? " | " . htmlspecialchars($p["finition"]) : "";
    echo "<div><b>Couleur :</b> " . htmlspecialchars(manageColor($p["color"] ?? '')) . $finition . "</div>";
    echo "<div class='dimension'>";
    echo "<div class='first'><b>Dimensions :</b></div>";
    echo "<div><b>Hauteur :</b> " . htmlspecialchars($p["hauteur"] ?? '') . " m</div>";
    echo "<div><b>Longueur :</b> " . htmlspecialchars($p["longueur"] ?? '') . " cm</div>";
    echo "</div>";
    return ob_get_clean();
}


function getClotureBetonM($p) {
    ob_start();
    echo "<div><b>Modèle :</b> " . htmlspecialchars($p["model"] ?? '') . "</div>";
    echo "<div class='dimension'>";
    echo "<div class='first'><b>Dimensions :</b></div>";
    echo "<div><b>Hauteur :</b> " . htmlspecialchars($p["hauteur"] ?? '') . " cm</div>";
    echo "<div><b>Longueur :</b> " . htmlspecialchars($p["longueur"] ?? '') . " cm</div>";
    echo "</div>";
    return ob_get_clean();
}



function getClotureRigideM($p) {
    ob_start();
    echo "<div><b>Couleur :</b> " . htmlspecialchars(manageColor($p["color"] ?? '')) . "</div>";
    echo "<div class='dimension'>";
    echo "<div class='first'><b>Dimensions :</b></div>";
    echo "<div><b>Hauteur :</b> " . htmlspecialchars($p["hauteur"] ?? '') . " m</div>";
    echo "<div><b>Longueur :</b> " . htmlspecialchars($p["longueur"] ?? '') . " cm</div>";
    echo "</div>";
    $kitOccultant = $p["kitOccultant"] ?? "";
    $kitSoubassement = $p["kitSoubassement"] ?? "";
    if ($kitOccultant === "Oui" || $kitSoubassement === "Oui") {
        echo "<div><b>Options :</b></div>";
        if ($kitOccultant === "Oui") {
            echo "<div class='delay'>Kit occultant</div>";
        }
        if ($kitSoubassement === "Oui") {
            echo "<div class='delay'>Kit soubassement</div>";
        }
    }
    return ob_get_clean();
}




function getDevisPortillonM($p) {
    ob_start();
    echo "<div><b>Modèle : </b>" . htmlspecialchars($p["model"] ?? '') . "</div>";
    $finition = !empty($p["finition"]) ? " | " . htmlspecialchars($p["finition"]) : "";
    echo "<div><b>Couleur :</b> " . htmlspecialchars(manageColor($p["color"] ?? '')) . $finition . "</div>";
    echo "<div class='dimension'>
        <div class='first'><b>Dimensions :</b></div>
        <div><b>Hauteur : </b>" . htmlspecialchars($p["hauteur"] ?? '') . " cm</div>
        <div><b>Largeur :</b> " . htmlspecialchars($p["largeur"] ?? '') . " cm</div>
        </div>";
    return ob_get_clean();
}


function getDevisPortailM($p) {
    ob_start();
    echo '<div><b>Type de portail : </b>' . htmlspecialchars($p["typePortail"] ?? '') . '</div>';
    if (($p["typePortail"] ?? '') === "Coulissant") {
        echo "<div><b>Sens d'ouverture : </b>" . htmlspecialchars($p["sensOuverture"] ?? '') . "</div>";
    }
    echo "<div><b>Modèle : </b>" . htmlspecialchars($p["model"] ?? '') . "</div>";
    $finition = !empty($p["finition"]) ? " | " . htmlspecialchars($p["finition"]) : "";
    echo "<div><b>Couleur :</b> " . htmlspecialchars(manageColor($p["color"] ?? '')) . $finition . "</div>";
    echo "<div class='dimension'>
        <div class='first'><b>Dimensions :</b></div>
        <div><b>Hauteur : </b>" . htmlspecialchars($p["hauteur"] ?? '') . " cm</div>
        <div><b>Longueur : </b>" . htmlspecialchars($p["longueur"] ?? '') . " cm</div>
        </div>";
    echo "<div class='delay'>" . (($p["automatisme"] ?? '') === "oui" ? "Avec automatisme" : "Sans automatisme") . "</div>";
    return ob_get_clean();
}

function manageColorM($c) {
    // regex to detect if starts with a number
    if (preg_match('/^\d+/', $c)) {
        return "RAL " . $c;
    }
    return $c;
}


function style() {
    ob_start();
    ?>
    <style>
        .inputLineLast {
            display: flex;
            gap: 10px;
            padding: 15px;
            margin-left: 10px;
        }
        .inputLineNotLast {
            display: flex;
            gap: 10px;
            padding: 15px;
            margin-left: 10px;
            border-bottom: 1px solid #ddd;
        }
        h1, h2 {
            color: #002;
        }
        .infoPerso, .Devis {
            margin-bottom: 10px;
            border-bottom: 2px dotted black;
            padding-bottom: 15px;
        }
        .infoPerso div, .Devis div {
            margin-bottom: 5px;
        }
        .infoPerso {
            display: grid;
            grid-template-columns: auto auto;
            gap: 10px 20px;
        }
        .project {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 15px;
            background-color: #f9f9f9;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .dimension {
            margin-top: 10px;
            margin-bottom: 10px;
            display: flex;
            gap: 15px;
            flex-direction: column;
        }
        .dimension div {
            margin-left: 15px;
        }
        .dimension .first {
            margin-left: 0;
            margin-bottom: 5px;
        }
        .list {
            margin-left: 15px;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        .delay {
            margin-left: 15px;
        }
    </style>

    <?php
    return ob_get_clean();
}