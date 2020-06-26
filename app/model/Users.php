<?php
require_once ROOT . '/src/Model.php';


class Users extends Model
{
    /**
     * @param string $username
     * @param string $password
     * @param int $roleId
     * @return PDOStatement|false
     */
    public function addUser(string $username, string $password, int $roleId)
    {
        return $this->executeRequest(
            "INSERT INTO users SET username=?, password=?, roleId=?",
            [
                $username,
                password_hash($password, PASSWORD_DEFAULT),
                $roleId
            ]
        );
    }

    /**
     * @param int $id
     * @return PDOStatement|false
     */
    public function getUserById(int $id)
    {
        return $this->executeRequest("SELECT * FROM users WHERE id=?", [$id])->fetch();
    }

    /**
     * @param string $username
     * @return PDOStatement|false
     */
    public function getUserByUsername(string $username)
    {
        return $this->executeRequest(
            "SELECT * FROM users 
                INNER JOIN role r on users.roleId = r.role_id
                WHERE username=?",
            [$username]
        )->fetch();
    }

    /**
     * @param int $roleId
     * @return PDOStatement|false
     */
    public function getUserByRole(int $roleId)
    {
        return $this->executeRequest(
            "SELECT * FROM users 
                INNER JOIN role r on users.roleId = r.role_id
                WHERE r.role_id=?",
            [$roleId]
        )->fetch();
    }

    /**
     * @return array|false
     */
    public function getUsers()
    {
        return $this->executeRequest(
            "SELECT * FROM users 
                INNER JOIN role r on users.roleId = r.role_id
                "
        )->fetchAll();
    }

    /**
     * @param int $id
     * @param string $username
     * @param string $password
     * @param int $roleId
     * @return PDOStatement|false
     */
    public function editUser(int $id, string $username, string $password, int $roleId)
    {
        if (!empty($password)) {
            $this->executeRequest(
                "UPDATE users SET password=? WHERE id=?",
                [
                    password_hash($password, PASSWORD_DEFAULT),
                    $id
                ]
            );
        }
        return $this->executeRequest(
            "UPDATE users SET username=?, roleId=?, updatedAt=NOW() WHERE id=?",
            [
                $username,
                $roleId,
                $id
            ]
        );
    }

    /**
     * @param int $id
     * @return PDOStatement
     */
    public function deleteUser(int $id)
    {
        return $this->executeRequest("DELETE FROM users WHERE id=?", [$id]);
    }
}
