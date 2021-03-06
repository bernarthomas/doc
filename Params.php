<?php

class Params
{
  /**
   * Utilisateur sql
   */
  const DEFAULT_SQL_USER = 'doc';

  /**
   * Hôte sql
   */
  const DEFAULT_SQL_HOST = '127.0.0.1';

  /**
   * Mot de passe sql
   */
  const DEFAULT_SQL_PASS = 'AZEnbv78.';

  /**
   * Base sql
   */
  const DEFAULT_SQL_DTB = 'doc';

  /**
   * Chemin de l'application
   */
  const APPLICATION_PATH = '/var/www/doc/';

  /**
   * code exception pour la non saisie du courriel
   */
  const EMPTY_COURRIEL_EXCEPTION_CODE = 1;

  /**
   * code exception pour la saisie d'un courriel invalide
   */
  const INVALID_COURRIEL_EXCEPTION_CODE = 2;

  /**
   * code exception pour la non saisie du mot de passe
   */
  const INVALID_PASSWORD_EXCEPTION_CODE = 3;

  /**
   * code exception pour un coupe courriel/Mot de passe non existant
   */
  const NOT_FOUND_USER_EXCEPTION_CODE = 4;

  /**
   * code exception pour une déconnexion réussie
   */
  const SUCCES_LOGOUT_EXCEPTION_CODE = 5;

  /**
   * Message 404
   */
  const _404_EXCEPTION_CODE = 6;

  /**
   * Non connecté
   */
  const NOT_LOGGED_EXCEPTION_CODE = 7;

  /**
   * message pour la non saisie du courriel
   */
  const EMPTY_COURRIEL_EXCEPTION_MESSAGE = 'Veuillez saisir un courriel';

  /**
   * message pour la saisie d'un courriel invalide
   */
  const INVALID_COURRIEL_EXCEPTION_MESSAGE = 'Veuillez saisir un courriel valide';

  /**
   * message pour la non saisie du mot de passe
   */
  const INVALID_PASSWORD_EXCEPTION_MESSAGE = 'Veuillez saisir un mot de passe';

  /**
   * message pour un coupe courriel/Mot de passe non existant
   */
  const NOT_FOUND_USER_EXCEPTION_MESSAGE = 'Couple "courriel/mot de passe" non trouvé';

  /**
   * message Déconnection réussie
   */
  const SUCCES_LOGOUT_EXCEPTION_MESSAGE = 'Déconnexion réussie';

  /**
   * Message 404
   */
  const _404_EXCEPTION_MESSAGE = 'page non trouvée';

  /**
   * Message non connecté
   */
  const NOT_LOGGED_EXCEPTION_MESSAGE = 'Veuillez vous connecter';

  /**
   * Tableau de mapping uri => nom de route
   *
   * @return array
   */
  private function getRoutes()
  {
    return [
      '/' => 'home',
      '/index.php' => 'home',
      '/accueil' => 'home',
      '/login' => 'login',
      '/logout' => 'logout',
      '/document/liste' => 'document_liste',
      '/categorie/ajouter' => 'document_categorieajouter',
      '/categorie/ajouterform' => 'document_categorieajouterform'
    ];
  }

  private function getTemplates()
  {
    return [
      'home' => 'home',
      'login' => 'login',
      'logout' => 'logout',
      'document_liste' => 'document_liste',
      'document_categorieajouter' => 'document_liste',
      'document_categorieajouterform' => 'document_liste'
    ];
  }

  /**
   * Route correspondant à l'uri
   *
   * @param $uri
   *
   * @return string nom de la route
   */
  public function getRoute($uri)
  {

    return $this->getRoutes()[$uri];
  }

  public function getTemplate($route)
  {

    return self::getTemplates()[$route];
  }

  /**
   * Tablea de mapping route => title de la page
   *
   * @return array
   */
  private function getTitles()
  {
    return [
      'home' => 'Accueil',
      'login' => 'Connexion',
      'logout' => 'Déconnexion',
      'document_liste' => 'Liste des documents',
      'categorie_ajouter' => 'Liste des documents - Ajouter une catégorie',
      'categorie_ajouterform' => 'Liste des documents - Catégorie ajoutée'
    ];
  }

  /**
   * Title de la page
   *
   * @param $route
   *
   * @return string Titre de la page
   */
  public function getTitle($route)
  {
    return $this->getTitles()[$route];
  }

  /**
   * Inclut un fichier en lui passant les paramètres nécessaires
   *
   * @param string $filename chemin du fichier à inclure
   * @param array $vars paramet
   *
   * @return bool|string
   */
  public function getRequiredContents($filename, $vars)
  {
    if (is_file($filename)) {
      extract($vars);
      ob_start();
      require $filename;

      return ob_get_clean();
    }

    return false;
  }
}