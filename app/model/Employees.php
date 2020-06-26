<?php
require_once ROOT . '/src/Model.php';

class Employees extends Model
{
    // Crud
    /**
     * @param string $firstName
     * @param string $lastName
     * @param int $roleId
     * @param int $placeId
     * @return PDOStatement|false
     */
    public function addEmployee(string $firstName, string $lastName, int $roleId, int $placeId)
    {
        return $this->executeRequest(
            "INSERT INTO employees 
                    (employee_firstname, employee_lastname, role_id, place_id) VALUES (?,?,?,?)",
            [
                $firstName,
                $lastName,
                $roleId,
                $placeId
            ]
        );
    }

    // cRud

    /**
     * @param int $id
     * @return PDOStatement|null
     */
    public function getEmployee(int $id)
    {
        return $this->executeRequest(
            "SELECT * FROM employees 
                INNER JOIN place p on employees.place_id = p.place_id
                INNER JOIN role r on employees.role_id = r.role_id
                WHERE employee_id=?",
            [
                $id
            ]
        )->fetch();
    }

    // cRud

    /**
     * @return array|null
     */
    public function getEmployees()
    {
        return $this->executeRequest(
            "SELECT * FROM employees
                INNER JOIN place p on employees.place_id = p.place_id
                INNER JOIN role r on employees.role_id = r.role_id"
        )->fetchAll();
    }

    /**
     * @param int $roleId
     * @return array|null
     */
    public function getEmployeesByRoleId(int $roleId)
    {
        return $this->executeRequest(
            "SELECT * FROM employees
                INNER JOIN place p on employees.place_id = p.place_id
                INNER JOIN role r on employees.role_id = r.role_id
                WHERE r.role_id = ?",
            [$roleId]
        )->fetchAll();
    }

    /**
     * @param int $placeId
     * @return array|null
     */
    public function getEmployeesByPlaceId(int $placeId)
    {
        return $this->executeRequest(
            "SELECT * FROM employees
                INNER JOIN place p on employees.place_id = p.place_id
                INNER JOIN role r on employees.role_id = r.role_id
                WHERE p.place_id = ?",
            [$placeId]
        )->fetchAll();
    }

    // crUd

    /**
     * @param int $id
     * @param string $firstName
     * @param string $lastName
     * @param int $roleId
     * @param int $placeId
     * @return PDOStatement|false
     */
    public function updateEmployee(int $id, string $firstName, string $lastName, int $roleId, int $placeId)
    {
        return $this->executeRequest(
            "UPDATE employees SET employee_firstname=?, employee_lastname=?, 
                     employee_update_date=NOW(), role_id=?, place_id=? WHERE employee_id=?",
            [
                $firstName,
                $lastName,
                $roleId,
                $placeId,
                $id
            ]
        );
    }

    // cruD
    public function deleteEmployee(int $id)
    {
        return $this->executeRequest("DELETE FROM employees WHERE employee_id=?", [$id]);
    }
}
