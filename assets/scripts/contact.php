<?php

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    include "db.php";

    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        header("HTTP/1.0 403 Forbidden");
        exit;
    }

    $name = htmlspecialchars($_POST["name"]) ?? "API_NAME";
    $email = htmlspecialchars($_POST["email"]) ?? "API_EMAIL";
    $message = htmlspecialchars($_POST["message"]) ?? "API_TEXT";

    $stmt = $pdo->prepare('INSERT INTO contacts (name, email, message) VALUES (:name, :email, :message)');
    $stmt->execute([
        "name" => $name,
        "email" => $email,
        "message" => $message
    ]);

    header("HTTP/1.0 200 OK");
    exit;
?>