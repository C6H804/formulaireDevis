<?php
function writteMail($data)
{
    // retourne le body du mail à envoyer
    ob_start();
    ?>
    <h1 style="color:#002;">Demande de devis en ligne</h1>
    <div><i>Reçu le <?php echo date('d/m/Y \à H:i'); ?></i></div>
    <h2 style="color:#002;">Informations personnelles</h2>
    <?php echo getPersonalInfoM($data); ?>
    <?php echo getProjectsM($data); ?>
    <?php echo getDetailsSupplementairesM($data); ?>

    <?php
    return ob_get_clean();
}

function getClientMail($data) {
    // message envoyé au client pour accuser réception de sa demande de devis en ligne.
    // le mail doit contenir un message de remerciement et un récapitulatif de sa demande.
    // le message doit être simple et clair, sans trop de détails techniques.
    // le ton doit être chaleureux et professionnel.
    // le mail doit être responsive et s'adapter à tous les types d'écrans.
    ob_start();
    ?>
    <h1 style="color:#002;">Bonjour <?php echo htmlspecialchars($data["name"] ?? ''); ?></h1>
    <h2 style="color:#002;">Vôtre demande de devis en ligne à bien était enregistrée.</h2>
    <p>Notre équipe va étudier votre demande avec attention et vous recontactera dans les plus brefs délais pour vous fournir une réponse personnalisée.</p>
    <!-- phrase pour présenté le compte rendu du devis -->
    <h3>Voici le récapitulatif de votre demande :</h3>
    <?php echo getProjectsM($data); ?>
    <p>Nous vous remercions encore une fois pour votre confiance et nous espérons pouvoir vous accompagner dans la réalisation de votre projet.</p>
    <p>Cordialement,</p>
    <p>L'équipe d'ACPORTAIL</p>
    <?php
    return ob_get_clean();
}

function getDetailsSupplementairesM($data) {
    ob_start();
    if (isset($data['details'])) {
        echo "<h2 style='color:#002;'>Détails supplémentaires</h2>";
        echo "<div><b>Détails supplémentaires :</b>";
        echo "<div style='margin-left:15px;'>" . htmlspecialchars($data['details']) . "</div>";
    }
    echo getImageCodeM($data);
    echo getSondageTextM($data);
    echo getCodePromoTextM($data);
    return ob_get_clean();
}

function getCodePromoTextM($data) {
    ob_start();
    if (isset($data["codePromo"])) {
        echo "<div><b>Code promotionnel utilisé : </b><div style='margin-left:15px;'>" . htmlspecialchars($data["codePromo"]) . "</div></div>";
    }
    return ob_get_clean();
}

function getSondageTextM($data) {
    ob_start();
    if (isset($data["sondage"]) && count($data["sondage"]) > 0) {
        echo "<div><b>A entendu parlé de l'entreprise via :</b></div>";
        echo "<div style='margin-left:15px;'>";
        foreach($data["sondage"] as $response) {
            echo "<div style='margin-top:5px;'>" . htmlspecialchars($response) . "</div>";
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
    <table style="width:100%;border-collapse:collapse;margin-bottom:10px;border-bottom:2px dotted black;">
        <tr>
            <td style="padding:10px;border-bottom:1px solid #ddd;vertical-align:top;"><b>Nom : </b></td>
            <td style="padding:10px;border-bottom:1px solid #ddd;vertical-align:top;"><?php echo htmlspecialchars($nom); ?></td>
        </tr>
        <tr>
            <td style="padding:10px;border-bottom:1px solid #ddd;vertical-align:top;"><b>Prénom : </b></td>
            <td style="padding:10px;border-bottom:1px solid #ddd;vertical-align:top;"><?php echo htmlspecialchars($prenom); ?></td>
        </tr>
        <tr>
            <td style="padding:10px;border-bottom:1px solid #ddd;vertical-align:top;"><b>Email : </b></td>
            <td style="padding:10px;border-bottom:1px solid #ddd;vertical-align:top;"><?php echo htmlspecialchars($email); ?></td>
        </tr>
        <tr>
            <td style="padding:10px;border-bottom:1px solid #ddd;vertical-align:top;"><b>Téléphone : </b></td>
            <td style="padding:10px;border-bottom:1px solid #ddd;vertical-align:top;"><?php echo htmlspecialchars($telephone); ?></td>
        </tr>
        <tr>
            <td style="padding:10px;vertical-align:top;"><b>Adresse : </b></td>
            <td style="padding:10px;vertical-align:top;"><?php echo htmlspecialchars($adresse); ?></td>
        </tr>
    </table>
    <?php
    return ob_get_clean();
}

function getProjectsM($data, $client = false) {
    $nbrProjects = count($data['projects'] ?? []);
    
    
    ob_start();
    if ($client) {
        echo "<h2 style='color:#002;'>" . ($nbrProjects > 1 ? 'Vos projets' : 'Votre projet') . "</h2>";
    } else {
        echo "<h2 style='color:#002;'>Devis ( " . $nbrProjects . " projet" . ($nbrProjects > 1 ? 's' : '') . ")</h2>";
    }
    // <h2 style="color:#002;">Devis (<?php echo $nbrProjects; ?> projet<?php echo $nbrProjects > 1 ? 's' : ''; ?>)</h2>
    ?>
    <div style="margin-bottom:10px;padding-bottom:15px;">
        <?php
        foreach (($data["projects"] ?? []) as $projectId => $project) {
            echo "<div style='border:1px solid #ccc;padding:10px;margin-bottom:15px;background-color:#f9f9f9;'>";
            echo "<h3 style='margin:0 0 8px 0;'>" . htmlspecialchars($project['type'] ?? 'Non spécifié') . "</h3>";
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
    echo "<div style='margin-left:15px;'>" . htmlspecialchars($p['descriptionAutre'] ?? '') . "</div>";
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
        echo "<div style='margin-left:15px;'>";
        if ($piliers !== "") echo "<div style='margin-top:5px;'>" . htmlspecialchars($piliers) . "</div>";
        if ($piliersAluminium !== "") echo "<div style='margin-top:5px;'>" . htmlspecialchars($piliersAluminium) . "</div>";
        if ($refuite !== "") echo "<div style='margin-top:5px;'>" . htmlspecialchars($refuite) . "</div>";
        if ($seuil !== "") echo "<div style='margin-top:5px;'>" . htmlspecialchars($seuil) . "</div>";
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
        echo "<div style='margin-left:15px;'>";
        if ($automatisme !== "") echo "<div style='margin-top:5px;'>" . htmlspecialchars($automatisme) . "</div>";
        if ($digicode !== "") echo "<div style='margin-top:5px;'>" . htmlspecialchars($digicode) . "</div>";
        if ($fournituresPose !== "") echo "<div style='margin-top:5px;'>" . htmlspecialchars($fournituresPose) . "</div>";
        if ($interphone !== "") echo "<div style='margin-top:5px;'>" . htmlspecialchars($interphone) . "</div>";
        if ($visiophone !== "") echo "<div style='margin-top:5px;'>" . htmlspecialchars($visiophone) . "</div>";
        echo "</div>";
    }
    return ob_get_clean();
}

function getCarportM($p) {
    ob_start();
    echo "<div style='margin-top:10px;margin-bottom:10px;'>";
    echo "<div style='margin-bottom:5px;'><b>Dimensions :</b></div>";
    echo "<div style='margin-top:5px;'><b>Longueur :</b> " . htmlspecialchars($p["longueur"] ?? '') . " cm</div>";
    echo "<div style='margin-top:5px;'><b>Largeur :</b> " . htmlspecialchars($p["largeur"] ?? '') . " cm</div>";
    echo "<div style='margin-top:5px;'><b>Hauteur :</b> " . htmlspecialchars($p["hauteur"] ?? '') . " cm</div>";
    echo "</div>";

    return ob_get_clean();
}

function getPergolaM($p): string {
    ob_start();
    echo "<div style='margin-top:10px;margin-bottom:10px;'>";
    echo "<div style='margin-bottom:5px;'><b>Dimensions :</b></div>";
    echo "<div style='margin-top:5px;'><b>Longueur :</b> " . htmlspecialchars($p["longueur"] ?? '') . " cm</div>";
    echo "<div style='margin-top:5px;'><b>Largeur :</b> " . htmlspecialchars($p["largeur"] ?? '') . " cm</div>";
    echo "<div style='margin-top:5px;'><b>Hauteur :</b> " . htmlspecialchars($p["hauteur"] ?? '') . " cm</div>";
    echo "</div>";
    echo "<div><b>Options : </b>" . htmlspecialchars($p["options"] ?? '') . "</div>";
    return ob_get_clean();
}

function getStoreM($p) {
    ob_start();
    echo "<div><b>Modèle : </b>" . htmlspecialchars($p["model"] ?? '') . "</div>";
    echo "<div><b>Couleur : </b>" . htmlspecialchars(manageColor($p["color"] ?? '')) . "</div>";
    echo "<div style='margin-top:10px;margin-bottom:10px;'>";
    echo "<div style='margin-bottom:5px;'><b>Dimensions :</b></div>";
    echo "<div style='margin-top:5px;'><b>Largeur : </b>" . htmlspecialchars($p["largeur"] ?? '') . " m</div>";
    echo "<div style='margin-top:5px;'><b>Projection : </b>" . htmlspecialchars($p["projection"] ?? '') . " m</div>";
    echo "<div style='margin-top:5px;'><b>Toile verticale : </b>" . htmlspecialchars($p["toileVerticale"] ?? '') . "</div>";
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
    echo "<div style='margin-top:10px;margin-bottom:10px;'>";
    echo "<div style='margin-bottom:5px;'><b>Dimensions :</b></div>";
    echo "<div style='margin-top:5px;'><b>Hauteur :</b> " . htmlspecialchars($p["hauteur"] ?? '') . " m</div>";
    echo "<div style='margin-top:5px;'><b>Longueur :</b> " . htmlspecialchars($p["longueur"] ?? '') . " cm</div>";
    echo "</div>";
    return ob_get_clean();
}


function getClotureBetonM($p) {
    ob_start();
    echo "<div><b>Modèle :</b> " . htmlspecialchars($p["model"] ?? '') . "</div>";
    echo "<div style='margin-top:10px;margin-bottom:10px;'>";
    echo "<div style='margin-bottom:5px;'><b>Dimensions :</b></div>";
    echo "<div style='margin-top:5px;'><b>Hauteur :</b> " . htmlspecialchars($p["hauteur"] ?? '') . " cm</div>";
    echo "<div style='margin-top:5px;'><b>Longueur :</b> " . htmlspecialchars($p["longueur"] ?? '') . " cm</div>";
    echo "</div>";
    return ob_get_clean();
}


function getClotureRigideM($p) {
    ob_start();
    echo "<div><b>Couleur :</b> " . htmlspecialchars(manageColor($p["color"] ?? '')) . "</div>";
    echo "<div style='margin-top:10px;margin-bottom:10px;'>";
    echo "<div style='margin-bottom:5px;'><b>Dimensions :</b></div>";
    echo "<div style='margin-top:5px;'><b>Hauteur :</b> " . htmlspecialchars($p["hauteur"] ?? '') . " m</div>";
    echo "<div style='margin-top:5px;'><b>Longueur :</b> " . htmlspecialchars($p["longueur"] ?? '') . " cm</div>";
    echo "</div>";
    $kitOccultant = $p["kitOccultant"] ?? "";
    $kitSoubassement = $p["kitSoubassement"] ?? "";
    if ($kitOccultant === "Oui" || $kitSoubassement === "Oui") {
        echo "<div><b>Options :</b></div>";
        if ($kitOccultant === "Oui") {
            echo "<div style='margin-left:15px;'>Kit occultant</div>";
        }
        if ($kitSoubassement === "Oui") {
            echo "<div style='margin-left:15px;'>Kit soubassement</div>";
        }
    }
    return ob_get_clean();
}


function getDevisPortillonM($p) {
    ob_start();
    echo "<div><b>Modèle : </b>" . htmlspecialchars($p["model"] ?? '') . "</div>";
    $finition = !empty($p["finition"]) ? " | " . htmlspecialchars($p["finition"]) : "";
    echo "<div><b>Couleur :</b> " . htmlspecialchars(manageColor($p["color"] ?? '')) . $finition . "</div>";
    echo "<div style='margin-top:10px;margin-bottom:10px;'>
        <div style='margin-bottom:5px;'><b>Dimensions :</b></div>
        <div style='margin-top:5px;'><b>Hauteur : </b>" . htmlspecialchars($p["hauteur"] ?? '') . " cm</div>
        <div style='margin-top:5px;'><b>Largeur :</b> " . htmlspecialchars($p["largeur"] ?? '') . " cm</div>
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
    echo "<div style='margin-top:10px;margin-bottom:10px;'>
        <div style='margin-bottom:5px;'><b>Dimensions :</b></div>
        <div style='margin-top:5px;'><b>Hauteur : </b>" . htmlspecialchars($p["hauteur"] ?? '') . " cm</div>
        <div style='margin-top:5px;'><b>Longueur : </b>" . htmlspecialchars($p["longueur"] ?? '') . " cm</div>
        </div>";
    echo "<div style='margin-left:15px;'>" . (($p["automatisme"] ?? '') === "oui" ? "Avec automatisme" : "Sans automatisme") . "</div>";
    return ob_get_clean();
}

function manageColorM($c) {
    // regex to detect if starts with a number
    if (preg_match('/^\d+/', $c)) {
        return "RAL " . $c;
    }
    return $c;
}