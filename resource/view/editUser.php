<?php
if (!isset($user)) {
    $user = null;
}
if (!isset($roles)) {
    $roles = null;
}

if (
    !isset($user['id']) ||
    !isset($user['username']) ||
    !isset($user['roleId'])
) {
    echo "<a href='User'>Liste des utilisateur</a> <br>";
    throw new Exception("Impossible d'éditer l'utilisateur car les informations fourni sont incorrect.");
}

$this->title = "Ma petite entreprise - Edition des utilisateurs";
?>


<form action="User/edit" method="post">
    <fieldset>
        <legend>Éditer un utilisateur</legend>
        <div>
            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="<?= $user['username'] ?>" required>
        </div>
        <div>
            <label for="password">Password</label>
            <input type="password" id="password" name="password">
        </div>
        <div>
            <label for="role">Role</label>
            <select name="roleId" id="role">
                <?php
                foreach ($roles as $role) {
                    echo "
                        <option value='{$role['role_id']}'" . ($user['roleId'] === $role['role_id'] ? "selected" : "") . ">
                        {$role['role_name_fr']}
                        </option>";
                }
                ?>
            </select>
        </div>
        <input type="hidden" name="id" value="<?= $user['id'] ?>">
        <button type="submit">Éditer</button>
    </fieldset>
</form>
