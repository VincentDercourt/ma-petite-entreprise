<?php

if (!isset($places)) {
    $places = null;
}

$this->title = "Ma petite entreprise - Gestion des emplacements";
?>

<form action="Place/add" method="post">
    <fieldset>
        <legend>Ajouter un emplacement</legend>
        <div>
            <label for="placeNameEn">Place name in English</label>
            <input type="text" id="placeNameEn" name="placeNameEn" required>
        </div>
        <div>
            <label for="placeNameFr">Nom de l'emplacement en français</label>
            <input type="text" id="placeNameFr" name="placeNameFr" required>
        </div>
        <button type="submit">Ajouter</button>
    </fieldset>
</form>

<table>
    <thead>
    <tr>
        <th>Id</th>
        <th>Nom de place</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($places as $place) {
        ?>
        <tr>
            <td><?= isset($place['place_id']) ? $place['place_id'] : "id inconnu" ?></td>
            <td>
                EN : <?= isset($place['place_name_en']) ? $place['place_name_en'] : "NC" ?> <br>
                FR : <?= isset($place['place_name_fr']) ? $place['place_name_fr'] : "NC" ?>
            </td>
            <td class="action">
                <a href="Place/editForm/<?= isset($place['place_id']) ? $place['place_id'] : "id inconnu" ?>"
                   class="button btnOrange">Éditer</a>
                <a href="Place/delete/<?= isset($place['place_id']) ? $place['place_id'] : "id inconnu" ?>"
                   class="button btnRed confirm"
                   data-message="Êtes-vous sur de bien vouloir supprimer cette emplacement.">Supprimer</a>
            </td>
        </tr>
        <?php
    }
    ?>
    </tbody>
</table>