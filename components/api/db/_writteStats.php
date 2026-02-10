<?php
function writteStats($data) {
    try {
        require_once __DIR__ . "/connect.php";
        $pdo = connectDb();
        if ($pdo === null) {
            return ["valid" => false, "message" => $devisStats["erreur de connexion à la base de données"]];
        }

        $devisStats = addDevisStats($data, $pdo);
        if ($devisStats["valid"] === false) return ["valid" => false, "message" => $devisStats["message"]];
        // $idDevisStats = $devisStats["id"];

        if (count($data["projects"]) > 0) {
            $projectStats = addProjectStats($data, $pdo, $devisStats["id"]);
            if ($projectStats["valid"] === false) return ["valid" => false, "message" => $projectStats["message"]];
        } else {
            $projectStats = addEmptyStat($devisStats["id"], $pdo, 0);
            if ($projectStats["valid"] === false) return ["valid" => false, "message" => $projectStats["message"]];
        }

        if (count($data["sondage"]) > 0) {
            $sondageStats = addSondageStats($data, $pdo, $devisStats["id"]);
            if ($sondageStats["valid"] === false) return ["valid" => false, "message" => $sondageStats["message"]];
        } else {
            $sondageStats = addEmptyStat($devisStats["id"], $pdo, 1);
            if ($sondageStats["valid"] === false) return ["valid" => false, "message" => $sondageStats["message"]];
        }
        return ["valid" => true];
    } catch (Exception $e) {
        return ["valid"=> false,"message"=> $e->getMessage()];
    }
}

function addEmptyStat($id, $pdo, $type) {
    $tableNames = ["projects", "sondage"];
    $foreignKeyNames = ["project_Type", "sondage_Type"];
    try {
        $stmt = "INSERT INTO stats_" .$tableNames[$type] . " (id_" . $foreignKeyNames[$type] . ", id_devis) VALUES (13, " . $id . ")";
        $pdo->prepare($stmt)->execute();
    } catch (PDOException $e) {
        return ["valid" => false, "message" => $e->getMessage()];
    }
    return ["valid"=> true];
}

function addSondageStats($data, $pdo, $idDevisStats) {
    $statsTypes = [
        "Google" => "1",
        "Facebook" => "2",
        "Instagram" => "3",
        "Pinterest" => "4",
        "Radio" => "5",
        "Bouche à oreille" => "6",
        "Publicité Grand Mail St Paul Lès Dax" => "7",
        "Publicité papier (Catalogue, prospectus, flyer)" => "8",
        "Publicité extérieure (Panneau publicitaire)" => "9",
        "Sur la route, en passant devant l'agence à Bégaar" => "10",
        "Sur la route, en passant devant l'agence à Lescar" => "11",
        "Autre" => "12",
        "Aucune réponse" =>"13"
    ];
    $stmt = "INSERT INTO stats_sondage (id_sondage_Type, id_devis) VALUES ";
    foreach ($data["sondage"] as $s) {
        $stmt .= "(" . $statsTypes[$s] . ", " . $idDevisStats . "),";
    }
    $stmt = rtrim($stmt, ",");
    try {
        $pdo->prepare($stmt)->execute();
    } catch (PDOException $e) {
        return ["valid" => false, "message" => "erreur lors de l'insertion des données du sondage : " . $stmt . " | " . $e->getMessage()];
    }
    return ["valid"=> true];
}

function addDevisStats($data, $pdo) {
    try {
        $stmt = "INSERT INTO stats_devis () VALUES ()";
        $pdo->prepare($stmt)->execute();
        return ["valid" => true, "id" => $pdo->lastInsertId()];
    } catch (PDOException $e) {
        return ["valid" => false, "message" => $e->getMessage()];
    }
}


function addProjectStats($data, $pdo, $idTarget) {
    $projectTypes = [
        "Portail" => "1",
        "Portillon" => "2",
        "Clôture rigide" => "3",
        "Clôture béton" => "4",
        "Clôture aluminium" => "5",
        "Porte de garage" => "6",
        "Store" => "7",
        "Pergola" => "8",
        "Carport" => "9",
        "Fournitures" => "10",
        "Maçonnerie" => "11",
        "Autre" => "12",
        "Aucune réponse" => "13"
    ];
    $stmt = "INSERT INTO stats_projects (id_project_Type, id_devis) VALUES ";
    foreach ($data["projects"] as $p) {
        $stmt .= "(" . $projectTypes[$p["type"]] . ", " . $idTarget . "),";
    }
    $stmt = rtrim($stmt, ",");
    try {
        $pdo->prepare($stmt)->execute();
    } catch (PDOException $e) {
        return ["valid" => false, "message" => "erreur lors de l'insertion des données des projets : " . $stmt . " " . $e->getMessage()];
    }
    return ["valid" => true];
}

?>