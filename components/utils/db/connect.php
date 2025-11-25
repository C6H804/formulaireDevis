<?php
function connectDb() {
    // Format OVH : nom_base.mysql.db ou clusterXXX-YYY.hosting.ovh.net
    $host = getenv("DB_HOST");
    $dbname = getenv("DB_NAME");
    $username = getenv("DB_USER");
    $password = getenv("DB_PASSWORD");
    $port = getenv("DB_PORT");
    try {
        $pdo = new PDO(
            "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4",
            $username,
            $password,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]
        );
        return $pdo;
    } catch (PDOException $e) {
        echo "erreur de connexion : " . $e->getMessage();
        return null;
    }
}
?>