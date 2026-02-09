<?php
// Charger les variables d'environnement
require_once __DIR__ . '/../loadEnv.php';

function getColors()
{
    $url = getenv('API_URL');
    $token = getenv('API_TOKEN');

    $data = json_encode(['filter' => 'available']);


    $options = [
        'http' => [
            'header' => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $token
            ],
            'method' => 'POST',
            'content' => $data
        ]
    ];

    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);

    if ($response === false) {
        return false;
    }

    return json_decode($response, true);
}

function orderColors($colors = [name_fr => "Aucune couleur", color => "FF0000", value => ""])
{
    // return an array from colors ordered by value likse ral100 ral401 ral1000 etc...
    $orderedColors = [];
    foreach ($colors as $color) {
        $code = str_replace("RAL", "", $color['value']);
        // $code = str_replace("MARS", "", $code);
        // $code = str_replace("MDR", "", $code);
        // $code = str_replace("MDL", "", $code);
        $newColor = [
            'name_fr' => $color['name_fr'],
            'color' => $color['color'],
            'value' => $color['value'],
            "order" => $code
        ];
        if (count($orderedColors) == 0) {
            $orderedColors[] = $newColor;
        } else {
            for ($i = 0; $i < count($orderedColors); $i++) {
                if ($newColor['order'] < $orderedColors[$i]['order']) {
                    array_splice($orderedColors, $i, 0, [$newColor]);
                    break;
                } elseif ($i == count($orderedColors) - 1) {
                    $orderedColors[] = $newColor;
                    break;
                }
            }
        }
    }
    return $orderedColors;
}

function ralModal($id)
{
    ob_start();
    $colors = getColors();
    if ($colors === false) {
        $backup = [["name_fr" => "Noir", "color" => "37383A", "value" => "RAL100", "order" => "100"], ["name_fr" => "Gris", "color" => "9AA2A6", "value" => "RAL150", "order" => "150"], ["name_fr" => "Noir", "color" => "2B2F30", "value" => "RAL200", "order" => "200"], ["name_fr" => "Gris", "color" => "475255", "value" => "RAL400", "order" => "400"], ["name_fr" => "Bleu", "color" => "202544", "value" => "RAL600", "order" => "600"], ["name_fr" => "Brun", "color" => "403636", "value" => "RAL650", "order" => "650"], ["name_fr" => "Bleu", "color" => "44648E", "value" => "RAL700", "order" => "700"], ["name_fr" => "Noir", "color" => "161617", "value" => "RAL900", "order" => "900"], ["name_fr" => "Gris", "color" => "8A8985", "value" => "RAL900", "order" => "900"], ["name_fr" => "Beige brun", "color" => "8A6642", "value" => "RAL1011", "order" => "1011"], ["name_fr" => "Blanc perlé", "color" => "EAE6CA", "value" => "RAL1013", "order" => "1013"], ["name_fr" => "Ivoire", "color" => "E1CC4F", "value" => "RAL1014", "order" => "1014"], ["name_fr" => "Ivoire clair", "color" => "E6D690", "value" => "RAL1015", "order" => "1015"], ["name_fr" => "Beige gris", "color" => "9E9764", "value" => "RAL1019", "order" => "1019"], ["name_fr" => "Noir", "color" => "39393C", "value" => "RAL2100", "order" => "2100"], ["name_fr" => "Rouge", "color" => "904334", "value" => "RAL2100", "order" => "2100"], ["name_fr" => "Vert", "color" => "5A5B46", "value" => "RAL2100", "order" => "2100"], ["name_fr" => "Noir", "color" => "242B2F", "value" => "RAL2200", "order" => "2200"], ["name_fr" => "Brun", "color" => "3E2D1F", "value" => "RAL2650", "order" => "2650"], ["name_fr" => "Gris", "color" => "A19D94", "value" => "RAL2800", "order" => "2800"], ["name_fr" => "Gris", "color" => "575958", "value" => "RAL2900", "order" => "2900"], ["name_fr" => "Rouge feu", "color" => "AF2B1E", "value" => "RAL3000", "order" => "3000"], ["name_fr" => "Rouge rubis", "color" => "9B111E", "value" => "RAL3003", "order" => "3003"], ["name_fr" => "Rouge Basque", "color" => "75151E", "value" => "RAL3004", "order" => "3004"], ["name_fr" => "Rouge vin", "color" => "5E2129", "value" => "RAL3005", "order" => "3005"], ["name_fr" => "Rouge noir", "color" => "412227", "value" => "RAL3007", "order" => "3007"], ["name_fr" => "Rouge oxyde", "color" => "642424", "value" => "RAL3009", "order" => "3009"], ["name_fr" => "Rouge brun", "color" => "781F19", "value" => "RAL3011", "order" => "3011"], ["name_fr" => "Bleu violet", "color" => "354D73", "value" => "RAL5000", "order" => "5000"], ["name_fr" => "Bleu outremer", "color" => "20214F", "value" => "RAL5002", "order" => "5002"], ["name_fr" => "Bleu saphir", "color" => "1D1E33", "value" => "RAL5003", "order" => "5003"], ["name_fr" => "Bleu noir", "color" => "18171C", "value" => "RAL5004", "order" => "5004"], ["name_fr" => "Bleu de sécurité", "color" => "1E2460", "value" => "RAL5005", "order" => "5005"], ["name_fr" => "Bleu brillant", "color" => "3E5F8A", "value" => "RAL5007", "order" => "5007"], ["name_fr" => "Bleu azur", "color" => "256690", "value" => "RAL5009", "order" => "5009"], ["name_fr" => "Bleu gentiane", "color" => "0E294B", "value" => "RAL5010", "order" => "5010"], ["name_fr" => "Bleu cobalt", "color" => "1E213D", "value" => "RAL5013", "order" => "5013"], ["name_fr" => "Bleu pigeon", "color" => "606E8C", "value" => "RAL5014", "order" => "5014"], ["name_fr" => "Bleu signalisation", "color" => "063971", "value" => "RAL5017", "order" => "5017"], ["name_fr" => "Bleu turquoise", "color" => "3F888F", "value" => "RAL5018", "order" => "5018"], ["name_fr" => "Bleu capri", "color" => "1B5583", "value" => "RAL5019", "order" => "5019"], ["name_fr" => "Bleu d'eau", "color" => "256D7B", "value" => "RAL5021", "order" => "5021"], ["name_fr" => "Bleu pastel", "color" => "5D9B9B", "value" => "RAL5024", "order" => "5024"], ["name_fr" => "Vert feuillage", "color" => "2D572C", "value" => "RAL6002", "order" => "6002"], ["name_fr" => "Vert Basque", "color" => "2F4538", "value" => "RAL6005", "order" => "6005"], ["name_fr" => "Vert brun", "color" => "39352A", "value" => "RAL6008", "order" => "6008"], ["name_fr" => "Vert sapin", "color" => "31372B", "value" => "RAL6009", "order" => "6009"], ["name_fr" => "Vert herbe", "color" => "35682D", "value" => "RAL6010", "order" => "6010"], ["name_fr" => "Vert noir", "color" => "343E42", "value" => "RAL6012", "order" => "6012"], ["name_fr" => "Vert oxyde chromique", "color" => "2E3A23", "value" => "RAL6020", "order" => "6020"], ["name_fr" => "Vert pâle", "color" => "89AC76", "value" => "RAL6021", "order" => "6021"], ["name_fr" => "Vert menthe", "color" => "20603D", "value" => "RAL6029", "order" => "6029"], ["name_fr" => "Turquoise pastel", "color" => "7FB5B5", "value" => "RAL6034", "order" => "6034"], ["name_fr" => "Gris argent", "color" => "8A9597", "value" => "RAL7001", "order" => "7001"], ["name_fr" => "Gris de sécurité", "color" => "969992", "value" => "RAL7004", "order" => "7004"], ["name_fr" => "Gris beige", "color" => "6D6552", "value" => "RAL7006", "order" => "7006"], ["name_fr" => "Gris vert", "color" => "4D5645", "value" => "RAL7009", "order" => "7009"], ["name_fr" => "Gris fer", "color" => "434B4D", "value" => "RAL7011", "order" => "7011"], ["name_fr" => "Gris basalte", "color" => "4E5754", "value" => "RAL7012", "order" => "7012"], ["name_fr" => "Gris ardoise", "color" => "434750", "value" => "RAL7015", "order" => "7015"], ["name_fr" => "Gris anthracite", "color" => "293133", "value" => "RAL7016", "order" => "7016"], ["name_fr" => "Gris noir", "color" => "23282B", "value" => "RAL7021", "order" => "7021"], ["name_fr" => "Gris terre d'ombre", "color" => "332F2C", "value" => "RAL7022", "order" => "7022"], ["name_fr" => "Gris béton", "color" => "686C5E", "value" => "RAL7023", "order" => "7023"], ["name_fr" => "Gris graphite", "color" => "474A51", "value" => "RAL7024", "order" => "7024"], ["name_fr" => "Gris granit", "color" => "2F353B", "value" => "RAL7026", "order" => "7026"], ["name_fr" => "Gris pierre", "color" => "8B8C7A", "value" => "RAL7030", "order" => "7030"], ["name_fr" => "Gris bleu", "color" => "474B4E", "value" => "RAL7031", "order" => "7031"], ["name_fr" => "Gris ciment", "color" => "7D8471", "value" => "RAL7033", "order" => "7033"], ["name_fr" => "Gris clair", "color" => "D7D7D7", "value" => "RAL7035", "order" => "7035"], ["name_fr" => "Gris platine", "color" => "7F7679", "value" => "RAL7036", "order" => "7036"], ["name_fr" => "Gris poussière", "color" => "7D7F7D", "value" => "RAL7037", "order" => "7037"], ["name_fr" => "Gris quartz", "color" => "6C6960", "value" => "RAL7039", "order" => "7039"], ["name_fr" => "Gris fenêtre", "color" => "9DA1AA", "value" => "RAL7040", "order" => "7040"], ["name_fr" => "Gris signalisation A", "color" => "8D948D", "value" => "RAL7042", "order" => "7042"], ["name_fr" => "Gris signalisation B", "color" => "4E5452", "value" => "RAL7043", "order" => "7043"], ["name_fr" => "Telegris 1", "color" => "909090", "value" => "RAL7045", "order" => "7045"], ["name_fr" => "Telegris 2", "color" => "82898F", "value" => "RAL7046", "order" => "7046"], ["name_fr" => "Telegris 4", "color" => "D0D0D0", "value" => "RAL7047", "order" => "7047"], ["name_fr" => "Brun de sécurité", "color" => "6C3B2A", "value" => "RAL8002", "order" => "8002"], ["name_fr" => "Brun argile", "color" => "734222", "value" => "RAL8003", "order" => "8003"], ["name_fr" => "Brun cuivré", "color" => "8E402A", "value" => "RAL8004", "order" => "8004"], ["name_fr" => "Brun noisette", "color" => "5B3A29", "value" => "RAL8011", "order" => "8011"], ["name_fr" => "Brun sépia", "color" => "382C1E", "value" => "RAL8014", "order" => "8014"], ["name_fr" => "Brun chocolat", "color" => "45322E", "value" => "RAL8017", "order" => "8017"], ["name_fr" => "Brun gris", "color" => "403A3A", "value" => "RAL8019", "order" => "8019"], ["name_fr" => "Brun noir", "color" => "212121", "value" => "RAL8022", "order" => "8022"], ["name_fr" => "Brun beige", "color" => "79553D", "value" => "RAL8024", "order" => "8024"], ["name_fr" => "Brun pâle", "color" => "755C48", "value" => "RAL8025", "order" => "8025"], ["name_fr" => "Brun terre", "color" => "4E3B31", "value" => "RAL8028", "order" => "8028"], ["name_fr" => "Blanc crème", "color" => "FDF4E3", "value" => "RAL9001", "order" => "9001"], ["name_fr" => "Blanc gris", "color" => "E7EBDA", "value" => "RAL9002", "order" => "9002"], ["name_fr" => "Noir foncé", "color" => "0A0A0A", "value" => "RAL9005", "order" => "9005"], ["name_fr" => "Aluminium blanc", "color" => "A5A5A5", "value" => "RAL9006", "order" => "9006"], ["name_fr" => "Aluminium gris", "color" => "8F8F8F", "value" => "RAL9007", "order" => "9007"], ["name_fr" => "Blanc pur", "color" => "FFFFFF", "value" => "RAL9010", "order" => "9010"], ["name_fr" => "Blanc signalisation", "color" => "F6F6F6", "value" => "RAL9016", "order" => "9016"], ["name_fr" => "Blanc", "color" => "FFFFFF", "value" => "RAL9110", "order" => "9110"], ["name_fr" => "Rouille", "color" => "", "value" => "MARS 2525", "order" => "MARS 2525"], ["name_fr" => "", "color" => "", "value" => "MARS M80", "order" => "MARS M80"], ["name_fr" => "Aspect bois", "color" => "", "value" => "MDL001", "order" => "MDL001"], ["name_fr" => "Aspect bois", "color" => "", "value" => "MDL002", "order" => "MDL002"], ["name_fr" => "Aspect bois", "color" => "", "value" => "MDL003", "order" => "MDL003"], ["name_fr" => "Aspect bois", "color" => "", "value" => "MDR001", "order" => "MDR001"], ["name_fr" => "Aspect bois", "color" => "", "value" => "MDR002", "order" => "MDR002"], ["name_fr" => "Aspect bois", "color" => "", "value" => "MDR003", "order" => "MDR003"], ["name_fr" => "Aspect bois", "color" => "", "value" => "MDR004", "order" => "MDR004"], ["name_fr" => "Aspect bois", "color" => "", "value" => "MDR005", "order" => "MDR005"], ["name_fr" => "Aspect bois", "color" => "", "value" => "MDR006", "order" => "MDR006"], ["name_fr" => "Aspect bois", "color" => "", "value" => "MDR008", "order" => "MDR008"]];
        echo json_encode($backup, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    } else {
        $result = orderColors($colors["colors"]);
        echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }


    return ob_get_clean();
}




?>