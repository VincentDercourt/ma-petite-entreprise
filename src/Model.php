<?php
require_once ROOT . '/src/Configuration.php';

/**
 * Classe abstraite Modèle.
 * Centralise les services d'accès à une base de données.
 * Utilise l'API PDO de PHP
 *
 * @version 1.0
 * @author Baptiste Pesquet
 */
abstract class Model
{

    /** Objet PDO d'accès à la sql
     * Statique donc partagé par toutes les instances des classes dérivées */
    /**
     * @var PDO $bdd
     */
    private static ?PDO $bdd = null;

    /**
     * Exécute une requête SQL
     * @param string $sql Requête SQL
     * @param array $params Paramètres de la requête
     * @return PDOStatement Résultats de la requête
     */
    protected function executeRequest(
        string $sql,
        array $params = null
    ): PDOStatement {
        if ($params == null) {
            $result = self::getBdd()->query($sql);   // exécution directe
        } else {
            $result = self::getBdd()->prepare($sql); // requête préparée
            $result->execute($params);
        }
        return $result;
    }

    /**
     * Renvoie un objet de connexion à la BDD en initialisant la connexion au besoin
     * @return PDO Objet PDO de connexion à la BDD
     */
    private static function getBdd(): PDO
    {
        if (self::$bdd === null) {
            // Récupération des paramètres de configuration sql
            $dsn = Configuration::get("dsn");
            $login = Configuration::get("login");
            $mdp = Configuration::get("mdp");
            
            // Création de la connexion
            self::$bdd = new PDO(
                $dsn,
                $login,
                $mdp,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        }
        return self::$bdd;
    }
}
