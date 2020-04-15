<?php

namespace Occazou\Src\Model;

require_once '/home/mathieu/documents/oc-dwj-project5/config/prod.php';

abstract class Model
{
  protected $db;

  protected function dbConnect()
  {
    $this->db = new \PDO(DSN, USER, PASSWD);
  }
}