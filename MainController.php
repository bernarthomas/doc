<?php
    class MainController
    {
        /**
         * MainController constructor.
         */
        public function __construct()
        {
            try {
                require '../Params.php';
                $params = new Params();
                require $params::APPLICATION_PATH . 'Tools.php';
                $tools = new Tools();
                $route = $params->getRoute($_SERVER['REQUEST_URI']);
                require $params::APPLICATION_PATH . 'UserRepo.php';
                $message = null;
                $user = $tools->manageLogIn($route);
                $tools->manageLogOut();
                $tools->manage404($route);
            } catch (Exception $e) {
                $message = $e->getMessage();
                $code = $e->getCode();
                if ( $code === $params::INVALID_COURRIEL_EXCEPTION_CODE
                || $code === $params::EMPTY_COURRIEL_EXCEPTION_CODE
                || $code === $params::INVALID_PASSWORD_EXCEPTION_CODE
                || $code === $params::SUCCES_LOGOUT_EXCEPTION_CODE
                || $code === $params::NOT_FOUND_USER_EXCEPTION_CODE
                || $code === $params::NOT_LOGGED_EXCEPTION_CODE) {
                    $route = 'login';
                }
                if ( $code === $params::_404_EXCEPTION_CODE) {
                    $route = 'accueil';
                }
            } finally {
                if (empty($user))  {
                    $user = null;
                }
                $templateName = $tools->runController($route);
                echo $tools->render($templateName, $user, $message);
            }
        }
    }