<?php

/**
 * Classe de gestion des paramètres de configuration
 *
 * Inspirée du SimpleFramework de Frédéric Guillot
 * (https://github.com/fguillot/simpleFramework)
 *
 * @version 1.0
 * @author Baptiste Pesquet
 * @edit by Vincent DERCOURT
 */

class Configuration
{

    /** Tableau des paramètres de configuration */
    private static array $parameters = [];

    /**
     * Renvoie la valeur d'un paramètre de configuration
     *
     * @param string $name Nom du paramètre
     * @param null $defaultValue
     * @return string Valeur du paramètre
     */
    public static function get(string $name, $defaultValue = null): string
    {
        try {
            if (isset(self::getParameters()[$name])) {
                $valeur = self::getParameters()[$name];
            } else {
                $valeur = $defaultValue;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            exit();
        }
        return $valeur;
    }

    /**
     * Renvoie le tableau des paramètres en le chargeant au besoin depuis un fichier de configuration.
     * Les fichiers de configuration recherchés sont Config/dev.ini et Config/prod.ini (dans cet ordre)
     *
     * @return array|false Tableau des paramètres
     * @throws Exception Si aucun fichier de configuration n'est trouvé
     */
    private static function getParameters(): array
    {
        if (!self::$parameters) {
            $pathFile = ROOT . "/config/dev.ini";
            if (!file_exists($pathFile)) {
                $pathFile = ROOT . "/config/prod.ini";
            }
            if (!file_exists($pathFile)) {
                throw new Exception("Aucun fichier de configuration trouvé");
            } else {
                self::$parameters = parse_ini_file($pathFile);
            }
        }
        return self::$parameters;
    }

}

