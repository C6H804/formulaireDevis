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

function ralModal($id)
{
    ob_start();
    ?>

    <div class='modal modalDevis' id='modalRal<?php echo $id ?>'>
        <div class='modalContent'>
            <div class='modalHeader'>
                <div class='modal-title'>
                    <h2>Choisir une couleur</h2>
                </div>
                <span class='closeModal' onclick='closeModal()'>&times;</span>
            </div>
            <div class='modal-body'>
                <?php
                $colors = getColors();
                foreach ($colors['colors'] as $color) {
                    $ralCode = htmlspecialchars($color['value']);
                    $colorHex = htmlspecialchars($color['color']);
                    $colorName = htmlspecialchars($color['name_fr']);

                    echo "<div class='colorItem' onclick='selectRal($id, \"$ralCode\", \"#radioToClear$id\", \"$colorHex\", \"$colorName\")'>
                        <span class='colorSample' style='background-color: #$colorHex'></span>
                        <div class='colorName'>$colorName</div>
                        <div class='colorRal'>$ralCode</div>
                        </div>";
                }
                ?>
            </div>
            <div class='modal-footer'></div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
?>