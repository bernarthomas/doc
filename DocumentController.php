<?php
  class DocumentController
  {
    /**
     * 
     * 
     * @return array
     */
    public function listeAction()
    {
      require Params::APPLICATION_PATH . 'Pdo.php';

      $sql = 'SELECT doc_id Id, doc_title Titre, doc_filepath Fichier FROM document';
      $sth = \bt\Pdo::getPdo()->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
      $sth->execute([]);

      return ['liste' => $sth->fetchAll()];
    }
    
    public function categorieajouterAction()
    {
      require Params::APPLICATION_PATH . 'Pdo.php';

      $sql = 'SELECT doc_id Id, doc_title Titre, doc_filepath Fichier FROM document';
      $sth = \bt\Pdo::getPdo()->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
      $sth->execute([]);

      return ['liste' => $sth->fetchAll(), 'categorie_ajouter' => true];
    }

    public function categorieajouterformAction()
    {
      require Params::APPLICATION_PATH . 'Pdo.php';

      $nomCategorie = $_POST['nom_categorie'];
      $sql = "INSERT INTO _n_category (ncat_label) VALUES ($nomCategorie)";
      $sth = \bt\Pdo::getPdo()->exec($sql);
    }
  }