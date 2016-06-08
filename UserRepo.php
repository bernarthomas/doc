<?php

    class UserRepo
    {
        /**
         * Liste des utilisateurs de l'application
         *
         * @return array d'utilisateurs
         */
        public function getUsers()
        {
            if (!class_exists('User', false)) {
                require Params::APPLICATION_PATH . 'User.php';
            }
            $user1 = new User('bernarthomas@free.fr', 'complice');
            $user2 = new User('anniebourdin@free.fr', 'aniber');

            return ['bernarthomas@free.fr' => $user1, 'anniebourdin@free.fr' => $user2];
        }

        /**
         * L'utilisateur est connu dans l'application
         *
         * @param User $user
         *
         * @return bool
         */
        public function isUser(User $user)
        {
            return in_array($user, $this->getUsers());
        }

        /**
         * Connecte l'utilisateur
         *
         * @param User $user
         */
        public function logIn(User $user)
        {

            $_SESSION['courriel'] = $user->getCourriel();
        }

        /**
         * Déconnecte l'utilisateur
         */
        public function logOut()
        {
            $_SESSION['courriel'] = null;
        }

        /**
         * Get user by courriel
         * 
         * @param $courriel
         * 
         * @return User
         */ 
        public function getUser($courriel)
        {
            return $this->getUsers()[$courriel];
        }
    }