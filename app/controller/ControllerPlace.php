<?php
require_once ROOT . '/src/ControllerSecurity.php';
require_once ROOT . '/app/model/Places.php';
require_once ROOT . '/app/model/Employees.php';


class ControllerPlace extends ControllerSecurity
{
    private Places $place;
    private Employees $employee;

    public function __construct()
    {
        $this->place = new Places();
        $this->employee = new Employees();
    }

    public function index()
    {
        $this->generateView(
            [
                "view" => "listPlace",
                "places" => $this->place->getPlaces()
            ]
        );
    }

    public function add()
    {
        $placeNameEn = (string)$this->request->getParameter("placeNameEn");
        $placeNameFr = (string)$this->request->getParameter("placeNameFr");

        if (!preg_match("/[\w\d\W]{1,100}/", $placeNameEn)) {
            throw new Exception("Impossible d'éditer l'emplacement, placeNameEn incorrect. " . htmlspecialchars($placeNameEn));
        }
        if (!preg_match("/[\w\d\W]{1,100}/", $placeNameFr)) {
            throw new Exception("Impossible d'éditer l'emplacement, placeNameFr incorrect. " . htmlspecialchars($placeNameFr));
        }

        $this->place->addPlace($placeNameEn, $placeNameFr);
        $this->redirect($this->webroot . "Place");
    }

    public function editForm()
    {
        $id = (int)$this->request->getParameter("id");
        if (!($place = $this->place->getPlace($id))) {
            throw new Exception("L'emplacement {$id} n'existe pas");
        }

        $this->generateView(
            [
                "view" => "editPlace",
                "place" => $place
            ]
        );

    }

    public function edit()
    {
        $id = (int)$this->request->getParameter("id");
        $placeNameEn = (string)$this->request->getParameter("placeNameEn");
        $placeNameFr = (string)$this->request->getParameter("placeNameFr");

        if ($id < 0) {
            throw new Exception("Impossible d'éditer l'employé, identifiant incorrect");
        }
        if (!preg_match("/[\w\d\W]{1,100}/", $placeNameEn)) {
            throw new Exception("Impossible d'éditer l'emplacement, placeNameEn incorrect. " . htmlspecialchars($placeNameEn));
        }
        if (!preg_match("/[\w\d\W]{1,100}/", $placeNameFr)) {
            throw new Exception("Impossible d'éditer l'emplacement, placeNameFr incorrect. " . htmlspecialchars($placeNameFr));
        }

        $this->place->updatePlace($id, $placeNameEn, $placeNameFr);
        $this->redirect($this->webroot . "Place");
    }

    public function delete()
    {
        $id = (int)$this->request->getParameter("id");

        if ($employee = $this->employee->getEmployeesByPlaceId($id)) {
            $placeName = $id;
            if (isset($employee['place_name_en'])) {
                $placeName = $employee['place_name_en'];
            }

            throw new Exception("Veuillez supprimé tout les employés présent dans l'emplacement {$placeName}");
        }

        $this->place->deletePlace($id);
        $this->redirect($this->webroot . "Place");
    }
}
