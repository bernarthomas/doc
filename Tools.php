<?php
    class Tools
    {
        /**
         * Require les sous templates, les intègre dans le layout principal
         *
         * @param string $route nom de la route
         * @param $user
         * @param $message
         *
         * @return bool|string
         */
        public function render($route, $user, $message)
        {

            if (!class_exists('Params', false)) {
                require '../Params.php';
            }
            $params = new Params();
            $title =  $params->getTitle($route);
            $userInfos = null;
            if (!empty($_SESSION['courriel'])) {
                $userInfos = $params->getRequiredContents($params::APPLICATION_PATH . 'userInfos.phtml', ['title' => $title, 'user' => $user]);
            }
            $content = $params->getRequiredContents($params::APPLICATION_PATH . $route . '.phtml', ['title' => $title, 'userInfos' => $userInfos]);

            return $params->getRequiredContents($params::APPLICATION_PATH . 'layout.phtml', [
                'title' => $title,
                'userInfos' => $userInfos,
                'message' => $message,
                'content' => $content
            ]);
        }
        
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
                    }  else {
                        throw new Exception(Params::NOT_FOUND_USER_EXCEPTION_MESSAGE, Params::NOT_FOUND_USER_EXCEPTION_CODE);
                    }
                }
                if ($route === 'logout') {
                    $user = null;
                }
            } else {
                $user = $userRepo->getUser($_SESSION['courriel']);
            }
            
            return $user;
        }
        
        public function manageLogOut()
        {
            if (!empty($_POST['quitter'])) {
                $userRepo = new UserRepo();
                $userRepo->logOut();
                throw new Exception(Params::SUCCES_LOGOUT_EXCEPTION_MESSAGE, Params::SUCCES_LOGOUT_EXCEPTION_CODE);
            }
        }

        public function manage404($route)
        {
            if (empty($route)) {
                throw new Exception( Params::_404_EXCEPTION_MESSAGE, Params::_404_EXCEPTION_CODE);
            }
        }
    }