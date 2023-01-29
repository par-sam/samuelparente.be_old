<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    include "../assets/scripts/db.php";

    $token = $_COOKIE["token"] ?? NULL;
    $module = $_GET["module"] ?? "dashboard";
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <script src="https://cdn.tailwindcss.com"></script>
        <title>Samuel Parente - Dashboard</title>
        <script src="/assets/scripts/jquery.js"></script>
    </head>
    <body>

<?php

    $stmt = $pdo->prepare('SELECT * FROM users WHERE token = :token');
    $stmt->execute([
        "token" => $token
    ]);
    $users = $stmt->fetchAll();

    if (count($users) > 0) {

        $stmt = $pdo->prepare('SELECT * FROM contacts');
        $stmt->execute();
        $messages = $stmt->fetchAll();
?>

        <div class="flex">
            <nav style="background-color: #161616;" class="flex flex-col w-1/6 h-screen px-4 rounded-r-lg">
                <div class="flex flex-col mt-8 items-center">
                    <div class="flex">
                        <img src="/assets/img/users/<?= $users[0]["id"] ?>.png" class="mx-auto w-20 h-20 rounded-full"/>
                    </div>
                    <span class="font-semibold text-white uppercase mt-2"><?= $users[0]["username"] ?></span>
                    <div class="flex mt-2">
<?php
                        foreach(json_decode($users[0]["ranks"], true) as $rank) {
?>
                            <div class="ml-1 font-bold uppercase text-<?=$rank["color"]?>-500 px-2 rounded-full border-2 border-<?=$rank["color"]?>-500">
                                <?= $rank["name"] ?>
                            </div>
<?php
                        }
?>
                    </div>
                </div>
                <div class="mt-10 mb-4">
                    <ul class="ml-4">
                        <li class="mb-2 px-4 py-4 text-gray-100 flex flex-row  border-gray-300 hover:text-black   hover:bg-gray-300  hover:font-bold rounded rounded-lg">
                            <span>
                                <svg class="fill-current h-5 w-5 " viewBox="0 0 24 24">
                                    <path d="M16 20h4v-4h-4m0-2h4v-4h-4m-6-2h4V4h-4m6 4h4V4h-4m-6 10h4v-4h-4m-6 4h4v-4H4m0 10h4v-4H4m6 4h4v-4h-4M4 8h4V4H4v4z"></path>
                                </svg>
                            </span>
                            <a href="?module=dashboard">
                                <span class="ml-2">Dashboard</span>
                            </a>
                        </li>
                        <li class="mb-2 px-4 py-4 text-gray-100 flex flex-row  border-gray-300 hover:text-black   hover:bg-gray-300  hover:font-bold rounded rounded-lg">
                            <span>
                                <svg class="fill-current h-5 w-5 " viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M16 7C16 9.20914 14.2091 11 12 11C9.79086 11 8 9.20914 8 7C8 4.79086 9.79086 3 12 3C14.2091 3 16 4.79086 16 7ZM14 7C14 8.10457 13.1046 9 12 9C10.8954 9 10 8.10457 10 7C10 5.89543 10.8954 5 12 5C13.1046 5 14 5.89543 14 7Z" fill="currentColor" />
                                    <path d="M16 15C16 14.4477 15.5523 14 15 14H9C8.44772 14 8 14.4477 8 15V21H6V15C6 13.3431 7.34315 12 9 12H15C16.6569 12 18 13.3431 18 15V21H16V15Z" fill="currentColor" />
                                </svg>
                            </span>
                            <a href="?module=clients">
                                <span class="ml-2">Clients</span>
                            </a>
                        </li>
                        <li class="mb-2 px-4 py-4 text-gray-100 flex flex-row  border-gray-300 hover:text-black   hover:bg-gray-300  hover:font-bold rounded rounded-lg">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="fill-current h-5 w-5" fill="none" viewBox="0 0 24 24">
                                    <path d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                                    </path>

                                </svg>
                            </span>
                            <a href="?module=messages">
                                <span class="ml-2">Messages</span>
                            </a>
                        </li>
                        <li class="mb-2 px-4 py-4 text-gray-100 flex flex-row  border-gray-300 hover:text-black   hover:bg-gray-300  hover:font-bold rounded rounded-lg">
                            <span>
                            <svg class="fill-current h-5 w-5" viewBox="0 0 24 24">
                                <path d="M12 4a4 4 0 014 4 4 4 0 01-4 4 4 4 0 01-4-4 4 4 0 014-4m0 10c4.42 0 8 1.79 8 4v2H4v-2c0-2.21 3.58-4 8-4z"></path>
                            </svg>
                            </span>
                            <a href="?module=team">
                                <span class="ml-2">Team</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            <div class="flex justify-center w-5/6 p-2">
<?php
                if ($module == "dashboard") {
?>
                    <div class="bg-gray-900 rounded-lg sahdow-lg p-12 flex flex-col justify-center items-center">
                        <div class="flex bg-green-500 rounded-full w-20 h-20 mb-8 border-4 items-center justify-center">
                            <h2 class="text-center text-white text-5xl font-bold mb-1">10</h2>
                        </div>
                        <div class="text-center">
                            <p class="text-xl text-white font-bold mb-2">Clients actifs (5 archivés)</p>
                            <p class="text-base text-gray-400 font-normal">________________________________________</p>
                        </div>
                    </div>

                    <div class="bg-gray-900 rounded-lg sahdow-lg p-12 flex flex-col justify-center items-center mx-2">
                        <div class="flex bg-green-500 rounded-full w-20 h-20 mb-8 border-4 items-center justify-center">
                            <h2 class="text-center text-white text-5xl font-bold mb-1"><?= count($messages) ?></h2>
                        </div>
                        <div class="text-center">
                            <p class="text-xl text-white font-bold mb-2">Messages (<?= count($messages) ?> non-lus)</p>
                            <p class="text-base text-gray-400 font-normal">________________________________________</p>
                        </div>
                    </div>
                    <div class="bg-gray-900 rounded-lg sahdow-lg p-12 flex flex-col justify-center items-center">
                        <div class="flex bg-green-500 rounded-full w-20 h-20 mb-8 border-4 items-center justify-center">
                            <h2 class="text-center text-white text-5xl font-bold mb-1">2</h2>
                        </div>
                        <div class="text-center">
                            <p class="text-xl text-white font-bold mb-2">Utilisateurs</p>
                            <p class="text-base text-gray-400 font-normal">________________________________________</p>
                        </div>
                    </div>
                </div>
<?php
            } else if ($module == "clients") {
?>

<?php
            } else if ($module == "messages") {
?>
                <div class="flex flex-col w-full">
<?php
                    foreach ($messages as $message) {
?>
                        <div class="w-full bg-gray-900 rounded-lg h-56 mb-2 p-2">
                            <div class="flex">
                                <h2 class="text-white text-md"><?= $message["name"] ?></h2>
                            </div>
                        </div>
<?php
                    }
?>
                </div>
<?php
            }
?>
        </div>

<?php
    } else {
?>
        <div class="fixed flex items-center flex-col md:flex-row right-0 bottom-0 m-5 bg-white rounded-2xl p-5 hidden" id="notif">
            <img id="notif_icon" src="/assets/img/check.png" class="w-10 h-10">
            <div class="flex flex-col md:ml-5">
                <h2 class="text-gray-800 text-xl font-bold tracking-normal leading-tight mb-2" id="notif_title">NOTIFICATION_TITLE</h2>
                <p class="text-gray-800 text-sm font-normal tracking-normal leading-tight" id="notif_content">NOTIFICATION_CONTENT</p>
            </div>
        </div>

        <div class="w-full h-screen flex items-center justify-center bg-gray-900">
            <div class="w-full md:w-1/3 rounded-lg">
                <div class="flex font-bold justify-center mt-6">
                    <img class="h-20 w-20 mb-3" src="/assets/img/icon.png" />
                </div>
                <h2 class="text-2xl text-center text-gray-200 mb-8">Connexion au Dashboard</h2>
                <div class="px-12 pb-10">
                    <div class="w-full mb-2">
                        <div class="flex items-center">
                            <input id="username" type="text" placeholder="Nom d'utilisateur" class="w-full border rounded px-3 py-2 text-gray-700 focus:outline-none"/>
                        </div>
                    </div>
                    <div class="w-full mb-2">
                        <div class="flex items-center">
                            <input id="password" type="password" placeholder="Mot de passe" class="w-full border rounded px-3 py-2 text-gray-700 focus:outline-none"/>
                        </div>
                    </div>
                    <button id="login_btn" class="w-full py-2 mt-8 rounded-full bg-blue-400 text-gray-100 focus:outline-none">Login</button>
                </div>
            </div>
        </div>
<?php
    }
?>
        <script src="/assets/scripts/main.js"></script>

    </body>
</html>