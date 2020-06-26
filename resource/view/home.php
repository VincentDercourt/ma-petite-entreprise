<?php

if (!isset($employees)) {
    $employees = null;
}

$this->title = "Ma petite entreprise";
?>

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
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($employees as $employee) {
            ?>
            <tr>
                <td><?= $employee['employee_id'] ?></td>
                <td><?= $employee['employee_firstname'] ?></td>
                <td><?= $employee['employee_lastname'] ?></td>
                <td>
                    <span>Français</span><?= $employee['place_name_fr'] ?> <br>
                    <span lang="en">Anglais</span><?= $employee['place_name_en'] ?>
                </td>
                <td>
                    <span>Français</span><?= $employee['role_name_fr'] ?> <br>
                    <span lang="en">Anglais</span><?= $employee['role_name_en'] ?>
                </td>
                <td>
                    <?=
                    strftime("%a %d %b %y", strtotime($employee['employee_create_date']))
                    ?>
                </td>
                <td>
                    <?=
                    strftime("%a %d %b %y", strtotime($employee['employee_update_date']))
                    ?>
                </td>
            </tr>
            <?php
        } ?>
        </tbody>
    </table>
    <?php
} else {
    ?>
    <p>J'ai pas d'employé (d'ami).</p>
    <?php
}
?>