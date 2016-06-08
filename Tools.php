<?php

class Tools
{
  /**
   * Require les sous templates, les intègre dans le layout principal
   *
   * @param string $route nom de la route
   * @param $user
   * @param $message
   * @param array $params
   *
   * @return bool|string
   */
  public function render($user, $message, $retourControlleur)
  {
    if (!class_exists('Params', false)) {
      require '../Params.php';
    }
    $params = new Params();
    $title = $params->getTitle($retourControlleur['templateName']);
    $userInfos = null;
    if (!empty($_SESSION['courriel'])) {
      $userInfos = $params->getRequiredContents($params::APPLICATION_PATH . 'userInfos.phtml', ['title' => $title, 'user' => $user]);
    }
    $contentArray = ['title' => $title, 'userInfos' => $userInfos];
    if (!empty($retourControlleur['retourControlleur'])) {
      $contentArray['retourControlleur'] = $retourControlleur['retourControlleur'];
    }
    $content = $params->getRequiredContents($params::APPLICATION_PATH . $retourControlleur['templateName'] . '.phtml', $contentArray);

    return $params->getRequiredContents($params::APPLICATION_PATH . 'layout.phtml', [
      'title' => $title,
      'userInfos' => $userInfos,
      'message' => $message,
      'content' => $content
    ]);
  }

  /**
   * Gère la connexion au site de l'utilisateur
   *
   * @param $route
   *
   * @return null|User
   * @throws Exception
   */
  public function manageLogIn($route)
  {
    session_start();
    $userRepo = new UserRepo();
    if (empty($_SESSION['courriel'])) {
      $params = new Params();
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require $params::APPLICATION_PATH . 'User.php';
        $user = new User($_POST['courriel'], $_POST['passe']);
        $isUser = $userRepo->isUser($user);
        if ($isUser === true) {
          $userRepo->logIn($user);
        } else {
          throw new Exception(Params::NOT_FOUND_USER_EXCEPTION_MESSAGE, Params::NOT_FOUND_USER_EXCEPTION_CODE);
        }
      } else {
        throw new Exception(Params::NOT_LOGGED_EXCEPTION_MESSAGE, Params::NOT_LOGGED_EXCEPTION_CODE);
      }
      if ($route === 'logout') {
        $user = null;
      }
    } else {
      $user = $userRepo->getUser($_SESSION['courriel']);
    }

    return $user;
  }

  /**
   * Déconnecte l'utilisateur courant
   *
   * @throws Exception
   */
  public function manageLogOut()
  {
    if (!empty($_POST['quitter'])) {
      $userRepo = new UserRepo();
      $userRepo->logOut();
      throw new Exception(Params::SUCCES_LOGOUT_EXCEPTION_MESSAGE, Params::SUCCES_LOGOUT_EXCEPTION_CODE);
    }
  }

  /**
   * Gère la page d'erreur page non trouvée
   *
   * @param $route
   * @throws Exception
   */
  public function manage404($route)
  {
    if (empty($route)) {
      throw new Exception(Params::_404_EXCEPTION_MESSAGE, Params::_404_EXCEPTION_CODE);
    }
  }

  /**
   * Appelle la méthode du controlleur si nécessaire et retour le template à afficher
   *
   * @param $route route appelée
   *
   * @return string nom du template à afficher
   */
  public function runController($route)
  {
    $routeExploded = explode('_', $route);
    $controller = $routeExploded[0];
    if (!empty($routeExploded[1])) {
      $action = $routeExploded[1];
    }
    $templateName = Params::getTemplate($route);
    $retour = ['templateName' => $templateName];
    $className = ucfirst($controller) . 'Controller';
    $fileName = Params::APPLICATION_PATH . $className . '.php';
    if (file_exists($fileName)) {
      require $fileName;
    }
    if (!empty($action)) {
      $actionName = $action . 'Action';
      $class = new $className();
      $retour['retourControlleur'] = $class->$actionName();
    }

    return $retour;
  }
}