<?php
if (!isset($place)) {
    $place = null;
}

if (
    !isset($place['place_id']) ||
    !isset($place['place_name_en']) ||
    !isset($place['place_name_fr'])) {
    echo "<a href='Place'>Liste des emplacements</a> <br>";
    throw new Exception("Impossible d'éditer l'emplacement car les informations fourni sont incorrect.");
}

$this->title = "Ma petite entreprise - Edition des emplacements";
?>

<form action="Place/edit" method="post">
    <fieldset>
        <legend>Éditer un emplacement</legend>
        <div>
            <label for="placeNameEn">Place name in English</label>
            <input type="text" id="placeNameEn" name="placeNameEn" value="<?= $place['place_name_en'] ?>" required>
        </div>
        <div>
            <label for="placeNameFr">Nom de l'emplacement en français</label>
            <input type="text" id="placeNameFr" name="placeNameFr" value="<?= $place['place_name_fr'] ?>" required>
        </div>
        <input type="hidden" name="id" value="<?= $place['place_id'] ?>">
        <button type="submit">Éditer</button>
    </fieldset>
</form>
