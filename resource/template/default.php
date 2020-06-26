<?php

if (!isset($webRoot)) {
    $webRoot = "/";
}
if (!isset($title)) {
    $title = "Titre";
}
if (!isset($content)) {
    $content = "";
}
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8"/>
    <base href="<?= $webRoot ?>">
    <link rel="stylesheet" href="assets/css/style.css"/>
    <title><?= $title ?></title>
</head>
<body>
<div id="global">
    <header>
        <a href=""><h1 id="titleBlog"><?= $title ?></h1></a>
        <?php
        // Gestion du nav Si connecté ou non et si dans l'acceuil ou non
        if (
            isset($_SESSION['auth']) && isset($_SESSION['auth']['id']) &&
            isset($_SESSION['auth']['username'])
        ) {
            echo "<p>Je vous souhaite la bienvenue {$_SESSION['auth']['username']} dans ma petite entreprise.</p>";
            if (isset($_SESSION['auth']['role_name_en']) && $_SESSION['auth']['role_name_en'] === "Master") {
                if (defined("CONTROLLER") and CONTROLLER === "Admin") {
                    echo '<a href="">Revenir a l\'accueil</a> <br>';
                } else {
                    echo '<a href="Admin">Accéder à la page admin</a> <br>';
                }
            }
            echo '<a href="Login/logout">Déconnexion</a>';
        } else {
            echo '
            <p>Je vous souhaite la bienvenue dans ma petite entreprise.</p>
            <a href="Login">Se connecter</a>';
        }
        ?>
    </header>
    <div id="content">
        <?= $content ?>
    </div> <!-- #contenu -->
    <footer id="footBlog">
        Site réalisé avec PHP, HTML5 et CSS.
    </footer>
</div> <!-- #global -->
<script src="assets/js/script.js"></script>
</body>
</html>