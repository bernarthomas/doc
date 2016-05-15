<?php
    class User
    {
        /**
         * @var string Adresse email de l'utilisateur. Est utilisée pour le login
         */
        private $courriel;

        /**
         * @var string Mot de passe de l'utilisateur
         */
        private $passe;

        /**
         * User constructor.
         *
         * @param $courriel
         * @param $passe
         *
         * return User
         */
        public function __construct($courriel, $passe)
        {
            $this
                ->setCourriel($courriel)
                ->setPasse($passe)
                ;

            return $this;
        }

        /**
         * @return string
         */
        public function getCourriel()
        {
            return $this->courriel;
        }

        /**
         * Setter avec validation
         *
         * @param $courriel adresse e-mail
         *
         * @return User
         *
         * @throws Exception si l'adresse mail est vide ou n'est pas valide
         */
        public function setCourriel($courriel)
        {
            if (empty($courriel)) {
                throw new Exception(Params::EMPTY_COURRIEL_EXCEPTION_MESSAGE, Params::EMPTY_COURRIEL_EXCEPTION_CODE);
            }
            if (!filter_var($courriel, FILTER_VALIDATE_EMAIL)) {
                throw new Exception(Params::INVALID_COURRIEL_EXCEPTION_MESSAGE, Params::INVALID_COURRIEL_EXCEPTION_CODE);
            }
            $this->courriel = $courriel;

            return $this;
        }

        /**
         * @return string
         */
        public function getPasse()
        {
            return $this->passe;
        }

        /**
         * Setter avec validation
         *
         * @param $passe
         *
         * @return $this
         *
         * @throws Exception si lmot de passe est vide
         */
        public function setPasse($passe)
        {
            if (empty($passe)) {
                throw new Exception(Params::INVALID_PASSWORD_EXCEPTION_MESSAGE,  Params::INVALID_PASSWORD_EXCEPTION_CODE);
            }
            $this->passe = $passe;

            return $this;
        }
    }