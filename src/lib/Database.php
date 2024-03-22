<?php

namespace Fede\Backend\lib;

use PDO;
use PDOEXCEPTION;

class Database
{

    private string $host;
    private string $db;
    private string $user;
    private string $password;
    private string $charset;
    private string $port;

  public function __construct()
  {
    $this->host = 'mariadb';
    $this->db = 'prueba';
    $this->user = 'prueba_web';
    $this->password = 123456;
    $this->charset = 'utf8mb4';
    $this->port = '3306';
  }

  public function Connect(){
    try {

        $connection = "mysql:host={$this->host};dbname={$this->db};charset={$this->charset};port={$this->port}";
        //preparando las excepciones
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        $pdo = new PDO($connection, $this->user, $this->password, $options);
        return $pdo;
    } catch (PDOException $th) {
        echo $th->getMessage();
    }
  }

}