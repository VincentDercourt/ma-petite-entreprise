<?php

if (!isset($_SESSION['auth']) && !isset($_SESSION['auth']['username'])) {
    exit("Vous devez vous connecter pour venir ici");
}
if (!isset($employees)) {
    $employees = null;
}
if (!isset($places)) {
    $places = null;
}
if (!isset($roles)) {
    $roles = null;
}
$this->title = "Ma petite entreprise - Administration" ?>
<h2>Administration</h2>
Bienvenue, <?= $_SESSION['auth']['username'] ?> !
<br><br>
<a href="Role">Liste des rôles</a> <br>
<a href="Place">Liste des emplacements</a> <br>
<a href="User">Liste des utilisateurs</a> <br><br>

<form action="Employees/add" method="post">
    <fieldset>
        <legend>Employé</legend>
        <div>
            <label for="firstName">Prénom</label><br>
            <input type="text" id="firstName" name="firstName" required>
        </div>
        <div>
            <label for="lastName">Nom de famille</label><br>
            <input type="text" id="lastName" name="lastName" required>
        </div>
        <div>
            <label for="place">Emplacement</label><br>
            <select name="placeId" id="place">
                <?php
                foreach ($places as $place) {
                    echo "<option value='{$place['place_id']}'>{$place['place_name_fr']}</option>";
                }
                ?>
            </select>
        </div>
        <div>
            <label for="role">Grade</label><br>
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

<?php
if (is_iterable($employees) and !empty($employees)) {
    ?>
    <table>
        <thead>
        <tr>
            <th>Id</th>
            <th>Prénom</th>
            <th>Nom de famille</th>
            <th>Emplacement</th>
            <th>Grade</th>
            <th>Date d'entré</th>
            <th>Date de mise à jour</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($employees as $employee) {
            ?>
            <tr>
                <td><?= isset($employee['employee_id']) ? $employee['employee_id'] : "NC" ?></td>
                <td><?= isset($employee['employee_firstname']) ? $employee['employee_firstname'] : "NC" ?></td>
                <td><?= isset($employee['employee_lastname']) ? $employee['employee_lastname'] : "NC" ?></td>
                <td>
                    <span>Fr : </span> <br>
                    <?= isset($employee['place_name_fr']) ? $employee['place_name_fr'] : "NC" ?>
                    <hr>
                    <span lang="en">En : </span>
                    <br>
                    <?= isset($employee['place_name_en']) ? $employee['place_name_en'] : "NC" ?>
                </td>
                <td>
                    <span>Fr : </span> <br>
                    <?= isset($employee['role_name_fr']) ? $employee['role_name_fr'] : "NC" ?>
                    <hr>
                    <span lang="en">En : </span>
                    <br>
                    <?= isset($employee['role_name_en']) ? $employee['role_name_en'] : "NC" ?>
                </td>
                <td>
                    <?=
                    strftime(
                        "%a %d %b %y",
                        strtotime(isset($employee['employee_create_date']) ? $employee['employee_create_date'] : "1970-01-01")
                    )
                    ?>
                </td>
                <td>
                    <?=
                    strftime(
                        "%a %d %b %y",
                        strtotime(isset($employee['employee_update_date']) ? $employee['employee_update_date'] : "1970-01-01")
                    )
                    ?>
                </td>
                <td>
                    <a href="Employees/editForm/<?= isset($employee['employee_id']) ? $employee['employee_id'] : 0 ?>"
                       class="button btnOrange">Éditer</a>
                    <a href="Employees/delete/<?= isset($employee['employee_id']) ? $employee['employee_id'] : 0 ?>"
                       class="button btnRed confirm"
                       data-message="Êtes-vous sûr de bien vouloir supprimer l'employé ?">supprimer</a>
                </td>
            </tr>
            <?php
        } ?>
        </tbody>
    </table>
    <?php
} else {
    echo "<p>J'ai pas d'employé (d'ami).</p>";
}
?>
