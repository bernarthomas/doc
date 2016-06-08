<?php
namespace bt;
class Pdo 
{
  private static $instance = null;

  public static function getPdo() {
    if(is_null(self::$instance)) {
      self::$instance = new \PDO(
        'mysql:dbname=' . \Params::DEFAULT_SQL_DTB.';host='.\Params::DEFAULT_SQL_HOST,
        \Params::DEFAULT_SQL_USER ,
        \Params::DEFAULT_SQL_PASS);
    }

    return self::$instance;
  }
}