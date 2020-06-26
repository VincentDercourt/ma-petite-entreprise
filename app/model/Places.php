<?php
require_once ROOT . '/src/Model.php';

class Places extends Model
{

    /**
     * @param string $nameEn
     * @param string $nameFr
     * @return PDOStatement|false
     */
    public function addPlace(string $nameEn, string $nameFr)
    {
        return $this->executeRequest(
            "INSERT INTO place SET place_name_en=?, place_name_fr=?",
            [$nameEn, $nameFr]
        );
    }

    /**
     * @param int $id
     * @return PDOStatement|false
     */
    public function getPlace(int $id)
    {
        return $this->executeRequest("SELECT * FROM place WHERE place_id=?", [$id])->fetch();
    }

    /**
     * @return array|false
     */
    public function getPlaces()
    {
        return $this->executeRequest("SELECT * FROM place")->fetchAll();
    }

    /**
     * @param int $id
     * @param string $placeNameEn
     * @param string $placeNameFr
     * @return PDOStatement|false
     */
    public function updatePlace(int $id, string $placeNameEn, string $placeNameFr)
    {
        return $this->executeRequest(
            "UPDATE place SET place_name_en=?, place_name_fr=? WHERE place_id=?",
            [
                $placeNameEn,
                $placeNameFr,
                $id
            ]
        );
    }

    /**
     * @param int $id
     * @return PDOStatement|false
     */
    public function deletePlace(int $id)
    {
        return $this->executeRequest("DELETE FROM place WHERE place_id=?", [$id]);
    }
}
