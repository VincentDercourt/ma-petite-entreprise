<?php
require_once 'Session.php';

/*
 * Classe modélisant une requête HTTP entrante
 *
 * @version 1.0
 * @author Baptiste Pesquet
 * @edit by Vincent DERCOURT
 */

class Request
{
    /** Tableau des paramètres de la requête */
    private array $parameters;

    /** Objet session associé à la requête */
    private Session $session;

    /**
     * Constructeur
     *
     * @param array $parameters Paramètres de la requête
     */
    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;
        $this->session = new Session();
    }

    /**
     * Renvoie la valeur du paramètre demandé
     * @param string $name Nom d paramètre
     * @param bool $obligatory Nom d paramètre
     * @return string|bool Valeur du paramètre
     * @throws Exception Si le paramètre n'existe pas dans la requête
     */
    public function getParameter(string $name, bool $obligatory = true): string
    {
        if ($this->issetParameter($name)) {
            return $this->parameters[$name];
        } else {
            if ($obligatory) {
                throw new Exception("Paramètre '$name' absent de la requête");
            }
        }
        return false;
    }

    /**
     * Renvoie vrai si le paramètre existe dans la requête
     * @param string $name Nom du paramètre
     * @return bool Vrai si le paramètre existe et sa valeur n'est pas vide
     */
    public function issetParameter(string $name): bool
    {
        return (isset($this->parameters[$name]) && $this->parameters[$name] != "");
    }

    /**
     * Renvoie l'objet session associé à la requête
     *
     * @return Session Objet session
     */
    public function getSession()
    {
        return $this->session;
    }

}
