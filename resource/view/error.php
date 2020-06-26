<?php
if (!isset($msgError)) {
    $msgError = "Erreur inconnu !";
}
$this->title = "Mon Blog";
?>
<p>Erreur : <?= $this->clear($msgError) ?></p>

<a href="<?= $webRoot ?>">Retour Accueil</a>
