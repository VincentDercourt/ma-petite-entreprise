<?php
if (!isset($role)) {
    $role = null;
}

if (
    !isset($role['role_id']) ||
    !isset($role['role_name_en']) ||
    !isset($role['role_name_fr'])
) {
    echo "<a href='Role'>Liste des roles</a> <br>";
    throw new Exception("Impossible d'éditer le role car les informations fourni sont incorrect.");
}

$this->title = "Ma petite entreprise - Edition des roles";
?>

<form action="Role/edit" method="post">
    <fieldset>
        <legend>Éditer un role</legend>
        <div>
            <label for="roleNameEn">Role name in English</label>
            <input type="text" id="roleNameEn" name="roleNameEn" value="<?= $role['role_name_en'] ?>" required>
        </div>
        <div>
            <label for="roleNameFr">Nom du role en français</label>
            <input type="text" id="roleNameFr" name="roleNameFr" value="<?= $role['role_name_fr'] ?>" required>
        </div>
        <input type="hidden" name="id" value="<?= $role['role_id'] ?>">
        <button type="submit">Éditer</button>
    </fieldset>
</form>
