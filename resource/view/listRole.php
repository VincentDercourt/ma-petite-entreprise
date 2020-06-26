<?php

if (!isset($roles)) {
    $roles = null;
}

$this->title = "Ma petite entreprise";
?>

<form action="Role/add" method="post">
    <fieldset>
        <legend>Role</legend>
        <div>
            <label for="roleNameEn">Role name in English</label>
            <input type="text" id="roleNameEn" name="roleNameEn" required>
        </div>
        <div>
            <label for="roleNameFr">Nom du role en français</label>
            <input type="text" id="roleNameFr" name="roleNameFr" required>
        </div>
        <button type="submit">Ajouter</button>
    </fieldset>
</form>

<table>
    <thead>
    <tr>
        <th>Id</th>
        <th>Nom de role</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($roles as $role) {
        ?>
        <tr>
            <td><?= isset($role['role_id']) ? $role['role_id'] : "id incorrect" ?></td>
            <td>
                EN : <?= isset($role['role_name_en']) ? $role['role_name_en'] : "NC" ?> <br>
                FR : <?= isset($role['role_name_fr']) ? $role['role_name_fr'] : "NC" ?>
            </td>
            <td class="action">
                <a href="Role/editForm/<?= isset($role['role_id']) ? $role['role_id'] : "id incorrect" ?>"
                   class="button btnOrange">Éditer</a>
                <a href="Role/delete/<?= isset($role['role_id']) ? $role['role_id'] : "id incorrect" ?>"
                   class="button btnRed confirm"
                   data-message="Êtes-vous sur de bien vouloir supprimer ce role.">Supprimer</a>
            </td>
        </tr>
        <?php
    }
    ?>
    </tbody>
</table>