<?php
setlocale(LC_ALL, 'fr_FR.UTF-8', 'fr_FR@euro', 'fr_FR', 'fra', 'french');
date_default_timezone_set('Europe/paris');

const ROOT = __DIR__;
const DS = "/";
// Contrôleur frontal : instancie un routeur pour traiter la requête entrante
require ROOT . '/src/Router.php';

$routeur = new Router();
$routeur->routerRequest();
