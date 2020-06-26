<?php

/**
 * Classe modélisant la session.
 * Encapsule la super globale PHP $_SESSION.
 *
 * @author Baptiste Pesquet
 * @edit by Vincent DERCOURT
 */
class Session
{
    /**
     * Constructeur.
     * Démarre ou restaure la session
     */
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Détruit la session actuelle
     */
    public function destroy()
    {
        $_SESSION = [];
        session_destroy();
    }

    /**
     * Ajoute un attribut à la session
     *
     * @param string $name Nom de l'attribut
     * @param mixed $value Valeur de l'attribut
     */
    public function setAttribut(string $name, $value): void
    {
        $_SESSION[$name] = $value;
    }

    /**
     * Renvoie la valeur de l'attribut demandé
     *
     * @param string $name Nom de l'attribut
     * @return string Valeur de l'attribut
     * @throws Exception Si l'attribut n'existe pas dans la session
     */
    public function getAttribut(string $name): string
    {
        if ($this->issetAttribut($name)) {
            return $_SESSION[$name];
        } else {
            throw new Exception("Attribut '$name' absent de la session");
        }
    }

    /**
     * Renvoie vrai si l'attribut existe dans la session
     *
     * @param string $name Nom de l'attribut
     * @return bool Vrai si l'attribut existe et sa valeur n'est pas vide
     */
    public function issetAttribut(string $name): bool
    {
        return (isset($_SESSION[$name]) && $_SESSION[$name] != "");
    }
}
