<?php

namespace Application\Model;

// require_once('src/lib/database.php');

use Application\Lib\Database\DatabaseConnection;
//avoid error using native class PDO
use PDO;

class Tags
{
  private int $id;
  private string $name;

  private DatabaseConnection $connection;

  public function __construct(DatabaseConnection $connection)
  {
    $this->connection = $connection;
  }

  public function getConnection(): \PDO
  {
    return $this->connection->getConnection();
  }

  public function getTags()
  {
    $statement = $this->connection->getConnection()->prepare(
      "SELECT id, name FROM tags ORDER BY name ASC"
    );
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }
}
