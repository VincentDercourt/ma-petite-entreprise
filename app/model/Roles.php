<?php
require_once ROOT . '/src/Model.php';


class Roles extends Model
{
    /**
     * @param string $nameEn
     * @param string $nameFr
     * @return PDOStatement|false
     */
    public function addRole(string $nameEn, string $nameFr)
    {
        return $this->executeRequest(
            "INSERT INTO role SET role_name_en=?, role_name_fr=?",
            [$nameEn, $nameFr]
        );
    }

    /**
     * @param int $id
     * @return PDOStatement|false
     */
    public function getRole(int $id)
    {
        return $this->executeRequest("SELECT * FROM role WHERE role_id=?", [$id])->fetch();
    }

    /**
     * @return array|false
     */
    public function getRoles()
    {
        return $this->executeRequest("SELECT * FROM role")->fetchAll();
    }

    /**
     * @param int $id
     * @param string $roleNameEn
     * @param string $roleNameFr
     * @return PDOStatement|false
     */
    public function updateRole(int $id, string $roleNameEn, string $roleNameFr)
    {
        return $this->executeRequest(
            "UPDATE role SET role_name_en=?, role_name_fr=? WHERE role_id=?",
            [
                $roleNameEn,
                $roleNameFr,
                $id
            ]
        );
    }

    /**
     * @param int $id
     * @return PDOStatement|false
     */
    public function deleteRole(int $id)
    {
        return $this->executeRequest("DELETE FROM role WHERE role_id=?", [$id]);
    }

}
