<?php

namespace Application\Model\Hickeslist;

require_once('src/lib/database.php');

use Application\Lib\Database\DatabaseConnection;
//avoid error using native class PDO
use PDO;

class Hickeslist
{
    private int $id;
    private string $name;
    private float $distance;
    private string $duration;
    private int $elevation_gain;
    private string $description;
    private int $created_by;
    private string $created_at;
    private string $updated_at;

    private DatabaseConnection $connection;

    public function __construct(DatabaseConnection $connection)
    {
        $this->connection = $connection;
    }

    public function getConnection(): \PDO
    {
        return $this->connection->getConnection();
    }

    public function getListOfHickes()
    {
        $statement = $this->connection->getConnection()->prepare(
            "SELECT id, name, distance, duration FROM Hikes"
        );
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getHikesDetails($hikesId)
    {
        $statement = $this->connection->getConnection()->prepare(
            "SELECT id, name, distance, duration, elevation_gain, description, created_by, created_at, updated_at FROM Hikes WHERE id = :id"
        );
        $statement->bindParam(':id', $hikesId, PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}
