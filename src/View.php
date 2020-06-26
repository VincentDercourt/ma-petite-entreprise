<?php
require_once ROOT . '/src/Configuration.php';

/**
 * Classe modélisant une vue
 *
 * @version 1.0
 * @author Baptiste Pesquet
 * @edit by Vincent DERCOURT
 */
class View
{

    /** Nom du fichier associé à la vue */
    private string $file;

    /** Titre de la vue (défini dans le fichier view) */
    private string $title = "";

    /**
     * Constructeur
     * @param string $view Action à laquelle la vue est associée
     * @param string $controller Nom du contrôleur auquel la vue est associée
     */
    public function __construct(string $view, string $controller = "")
    {
        // Détermination du nom du fichier vue à partir de l'action et du constructeur
        // La convention de nommage des fichiers vues est : View/<$controller>/<$action>.php
        $file = Configuration::get("viewPath", "resource/view");
//        if ($controller != "") {
//            $file =  $file . "/";
//        }
        $this->file = $file . DS . $view . ".php";
        if (!file_exists(ROOT . DS . $this->file)) {
//            $view = Configuration::get("viewDefault", "home");
//            $this->file = $file . DS . $view . ".php";
            throw new Exception("Attention ta vue est incorrect. " . ROOT . DS . $this->file);
        }
    }

    /**
     * Génère et affiche la vue
     * @param array $data Données nécessaires à la génération de la vue
     * @return void
     */
    public function generate(array $data): void
    {
        $webRoot = Configuration::get("webRoot", "/");
        $data['webRoot'] = $webRoot;
        // Génération de la partie spécifique de la vue
        try {
            $content = $this->generateFile($this->file, $data);
        } catch (Exception $e) {
            echo $e->getMessage();
            exit();
        }
        // On définit une variable locale accessible par la vue pour la racine Web
        // Il s'agit du chemin vers le site sur le serveur Web
        // Nécessaire pour les URI de type controller/action/id
        $templatePath = Configuration::get("templatePath", "resource/template");
        $templateDefault = Configuration::get("templateDefault", "default.php");
        // Génération du gabarit commun utilisant la partie spécifique
        try {
            $view = $this->generateFile(
                $templatePath . DS . $templateDefault,
                [
                    'title' => $this->title,
                    'content' => $content,
                    'webRoot' => $webRoot
                ]
            );
            // Renvoi de la vue générée au navigateur
            echo $view;
        } catch (Exception $e) {
            echo $e->getMessage();
            exit();
        }
    }

    /**
     * Génère un fichier vue et renvoie le résultat produit
     * @param string $file Chemin du fichier vue à générer
     * @param array $data Données nécessaires à la génération de la vue
     * @return string Résultat de la génération de la vue
     * @throws Exception Si le fichier vue est introuvable
     */
    private function generateFile(string $file, array $data): string
    {
        $file = ROOT . DS . $file;
        if (file_exists($file)) {
            // Rend les éléments du tableau $data accessibles dans la vue
            extract($data);
            // Démarrage de la temporisation de sortie
            ob_start();
            // Inclut le fichier vue
            // Son résultat est placé dans le tampon de sortie
            require $file;
            // Arrêt de la temporisation et renvoi du tampon de sortie
            return ob_get_clean();
        } else {
            throw new Exception("Fichier '$file' introuvable");
        }
    }

    /**
     * Nettoie une valeur insérée dans une page HTML
     * Permet d'éviter les problèmes d'exécution de code indésirable (XSS) dans les vues générées
     * @param string $value Valeur à nettoyer
     * @return string Valeur nettoyée
     */
    private function clear(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8', false);
    }

}
