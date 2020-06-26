<?php

if (!isset($users)) {
    $user = null;
}
if (!isset($roles)) {
    $roles = null;
}

$this->title = "Ma petite entreprise - Liste des utilisateurs";
?>

<form action="User/add" method="post">
    <fieldset>
        <legend>Ajouter utilisateur</legend>
        <div>
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div>
            <label for="role">Role</label>
            <select name="roleId" id="role">
                <?php
                foreach ($roles as $role) {
                    echo "<option value='{$role['role_id']}'>{$role['role_name_fr']}</option>";
                }
                ?>
            </select>
        </div>
        <button type="submit">Ajouter</button>
    </fieldset>
</form>

<table>
    <thead>
    <tr>
        <th>Id</th>
        <th>Username</th>
        <th>Role</th>
        <th>Créé le</th>
        <th>Date mise à jour</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($users as $user) {
        ?>
        <tr>
            <td><?= isset($user['id']) ? $user['id'] : "id incorrect" ?></td>
            <td><?= isset($user['username']) ? $user['username'] : "username incorrect" ?></td>
            <td>
                EN : <?= isset($user['role_name_en']) ? $user['role_name_en'] : "NC" ?> <br>
                FR : <?= isset($user['role_name_fr']) ? $user['role_name_fr'] : "NC" ?>
            </td>
            <td><?= isset($user['createdAt']) ? $user['createdAt'] : "createdAt incorrect" ?></td>
            <td><?= isset($user['updatedAt']) ? $user['updatedAt'] : "updatedAt incorrect" ?></td>
            <td class="action">
                <a href="User/editForm/<?= isset($user['id']) ? $user['id'] : "id incorrect" ?>"
                   class="button btnOrange">Éditer</a>
                <a href="User/delete/<?= isset($user['id']) ? $user['id'] : "id incorrect" ?>"
                   class="button btnRed confirm"
                   data-message="Êtes-vous sur de bien vouloir supprimer cette utilisateur.">Supprimer</a>
            </td>
        </tr>
        <?php
    }
    ?>
    </tbody>
</table>