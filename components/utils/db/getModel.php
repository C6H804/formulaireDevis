<?php
function getModel($type) {
    include_once __DIR__ . '/../db/connect.php';
    $pdo = connectDb();

    // Debug : afficher la valeur recherchée
    // echo "Recherche pour type: " . $type . "<br>"; TEMP

    $stmt = $pdo->prepare("SELECT * FROM products_images WHERE product_type = :product_type");
    $stmt->bindParam(':product_type', $type);
    $stmt->execute();

    $models = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Debug : afficher le nombre de résultats
    // echo "Nombre de résultats trouvés: " . count($models) . "<br>";
    // var_dump($models);

    return $models;
}
?>