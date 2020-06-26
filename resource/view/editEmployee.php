<?php
if (!isset($employee)) {
    $employee = null;
}

if (
    !isset($employee['employee_id']) ||
    !isset($employee['employee_firstname']) ||
    !isset($employee['employee_lastname']) ||
    !isset($employee['role_id']) ||
    !isset($employee['place_id'])
) {
    throw new Exception("Impossible d'éditer l'employé car les informations fourni sont incorrect.");
}

$this->title = "Ma petite entreprise - Edition des employés";
?>

<form action="Employees/edit" method="post">
    <fieldset>
        <legend>Employé</legend>
        <div>
            <label for="firstName">Prénom</label><br>
            <input type="text" id="firstName" name="firstName" value="<?= $employee['employee_firstname'] ?>" required>
        </div>
        <div>
            <label for="lastName">Nom de famille</label><br>
            <input type="text" id="lastName" name="lastName" value="<?= $employee['employee_lastname'] ?>" required>
        </div>
        <div>
            <label for="place">Emplacement</label><br>
            <select name="placeId" id="place">
                <?php
                foreach ($places as $place) {
                    echo "
                        <option value='{$place['place_id']}'" . ($employee['place_id'] === $place['place_id'] ? "selected" : "") . ">
                        {$place['place_name_fr']}
                        </option>";
                }
                ?>
            </select>
        </div>
        <div>
            <label for="role">Grade</label><br>
            <select name="roleId" id="role">
                <?php
                foreach ($roles as $role) {
                    echo "
                        <option value='{$role['role_id']}'" . ($employee['role_id'] === $role['role_id'] ? "selected" : "") . ">
                        {$role['role_name_fr']}
                        </option>";
                }
                ?>
            </select>
        </div>
        <input type="hidden" name="id" value="<?= $employee['employee_id'] ?>">
        <button type="submit">Éditer</button>
    </fieldset>
</form>
