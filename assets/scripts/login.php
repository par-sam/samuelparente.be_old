<?php
    include "db.php";

    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        header("HTTP/1.1 404 Not Found");
        exit;
    }

    $username = htmlspecialchars($_POST["username"] ?? NULL);
    $password = htmlspecialchars($_POST["password"] ?? NULL);
    
    if (!$password || !$username) {
        echo "1 - Missing username or password";
        exit;
    }

    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = :username');
    $stmt->execute([
        ":username" => $username
    ]);
    $users = $stmt->fetchAll();

    if (count($users) == 0) {
        echo "2 - User not found";
        exit;
    }

    $user = $users[0];

    if (!password_verify($password, $user["password"])) {
        echo "3 - Wrong password";
        exit;
    }

    $url = "https://api.motdepasse.xyz/create/?include_lowercase&password_length=100&quantity=1&include_uppercase&include_digits&add_custom_characters=@%23%26%25";
    $token = json_decode(file_get_contents($url), true)["passwords"][0];

    $stmt = $pdo->prepare('UPDATE users SET token = :token WHERE username = :username');
    $stmt->execute([
        ":token" => $token,
        ":username" => $username
    ]);

    setcookie("token", $token, time() + (60 * 60 * 24), "/");

    echo "success";
    exit;

    echo "4 - Unknown error";
    
?>