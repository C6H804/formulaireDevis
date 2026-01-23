<?php
function getModel($type)
{
    // décide si on récupère la donnée depuis la base de donnée ou l'api de cyril
    switch ($type) {
        case "portails_battants":
            return apiModel("battant");
        case "portails_coulissants":
            return apiModel("coulissant");
        case "portillons":
            return apiModel("portillon");
        case "clotures_aluminium":
            return apiModel("cloture");
        case "portes_garage":
            return apiModel("porte_de_garage");
        case "clotures_beton":
            return apiModel("cloture_beton");
        default:
            return databaseModel($type);
    }

}



function apiModel($type)
{
    // recupère les modèles depuis l'api de cyril
    require_once(__DIR__ . '/../loadEnv.php');

    // call api get https://www.modeles.acportail.fr/api.php?type=$type

    $url = getenv('API_MODELURL') . "?type=" . $type;
    $response = file_get_contents($url);
    $response = json_decode($response, true);


    $result = [];

    if (isset($response["modeles"]) && count($response["modeles"]) > 0) {
        foreach ($response["modeles"] as $modele) {
            $result["Standard"][] = [
                "id" => $modele["id"],
                "nom" => $modele["nom"],
                "image_url" => $modele["image"]
            ];
        }
        return $result;
    }

    foreach ($response["styles"] as $style) {
        // $result[] = $style["style"][];
        if (count($style["modeles"]) == 0) {
            foreach ($style["sous_styles"] as $sous_style) {
                if (count($sous_style["modeles"]) > 0) {
                    foreach ($sous_style["modeles"] as $m) {
                        $result[$style["style"]][] = [
                            "id" => $m["id"],
                            "nom" => $m["nom"],
                            "image_url" => $m["image"]
                        ];
                    }
                }
            }
        } else {
            // $result[$style["style"]][] = getModelFromStyle($style);
            foreach ($style["modeles"] as $modele) {
                $result[$style["style"]][] = [
                    "id" => $modele["id"],
                    "nom" => $modele["nom"],
                    "image_url" => $modele["image"]
                ];
            }
        }

    }


    // return $response["styles"];
    return $result;
}


function databaseModel($type)
{
    // recupère les modèles depuis la base de donnée
    include_once __DIR__ . '/../db/connect.php';
    $pdo = connectDb();

    // Debug : afficher la valeur recherchée
    // echo "Recherche pour type: " . $type . "<br>"; TEMP

    $stmt = $pdo->prepare("SELECT * FROM products_images WHERE product_type = :product_type");
    $stmt->bindParam(':product_type', $type);
    $stmt->execute();

    $models = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $models;
}
?>