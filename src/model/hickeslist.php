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
            "SELECT h.id, h.name, h.distance, h.duration, t.category
            FROM Hikes h
            INNER JOIN tags t
            ON h.id_tags = t.ID
            "
        );
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getHikesDetails($hikesId)
    {
        $statement = $this->connection->getConnection()->prepare(
            "SELECT h.id, h.name, h.distance, h.duration, h.elevation_gain, h.description, h.created_by, h.created_at, h.updated_at, u.nickname, u.user_admin
            FROM Hikes h
            INNER JOIN users u
            ON h.created_by = u.id
            WHERE h.id = :id"
        );
        $statement->bindParam(':id', $hikesId, PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getHikesComments($hickesid)
    {
        $commentdb = $this->connection->getConnection()->prepare(
            "SELECT hc.id, hc.hikes_comments, hc.id_user, hc.posted_at, u.nickname, u.user_admin
            FROM hikescomments hc
            INNER JOIN users u
            ON hc.id_user = u.id
            WHERE hc.id_hikes = :id_hikes
            ORDER BY hc.id"
        );
        $commentdb->bindParam(":id_hikes", $hickesid, PDO::PARAM_INT);
        $commentdb->execute();
        $result = $commentdb->fetchAll(PDO::FETCH_ASSOC);
        
        return $result;
    }

    public function getHikesListUser()
    {
        $statement = $this->connection->getConnection()->prepare(
            "SELECT id, name, distance, duration, created_by FROM Hikes"
        );
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function EditHikes($hickeid)
    {
        $statement = $this->connection->getConnection()->prepare(
            "SELECt id, name, distance, duration, elevation_gain, description, created_by, updated_at, id_tags FROM Hikes WHERE id = :id"
        );
        $statement->bindParam(':id', $hickeid, PDO::PARAM_INT);
        $result = $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function SaveHikes($hikeid, $name, $distance, $duration, $elevation_gain, $description, $updated_at, $id_tag)
    {
        $statement = $this->connection->getConnection()->prepare(
            "UPDATE Hikes SET 
        name = :name,
        distance = :distance,
        duration = :duration,
        elevation_gain = :elevation_gain,
        description = :description,
        updated_at = :updated_at,
        id_tags = :id_tags
        WHERE id = :id"
        );
        $statement->bindParam(':id', $hikeid, PDO::PARAM_INT);
        $statement->bindParam(':name', $name, PDO::PARAM_STR);
        $statement->bindParam(':distance', $distance, PDO::PARAM_STR);
        $statement->bindParam(':duration', $duration, PDO::PARAM_STR);
        $statement->bindParam(':elevation_gain', $elevation_gain, PDO::PARAM_STR);
        $statement->bindParam(':description', $description, PDO::PARAM_STR);
        $statement->bindParam(':updated_at', $updated_at, PDO::PARAM_STR);
        $statement->bindParam(':id_tags', $id_tag, PDO::PARAM_INT);
        $result = $statement->execute();
        if ($result) {
            return "Hike edited successfully.";
        } else {
            return "Failed to edit hike.";
        }
    }

    public function SaveAddHikes($name, $distance, $duration, $elevation_gain, $description, $created_by, $created_at, $updated_at,  $id_tag)
    {
        $statement = $this->connection->getConnection()->prepare(
            "INSERT INTO Hikes (name, distance, duration, elevation_gain, description, created_by, created_at, updated_at, id_tags) VALUES (:name, :distance, :duration, :elevation_gain, :description, :created_by, :created_at, :updated_at, :id_tags)"
        );
        $statement->bindParam(':name', $name, PDO::PARAM_STR);
        $statement->bindParam(':distance', $distance, PDO::PARAM_STR);
        $statement->bindParam(':duration', $duration, PDO::PARAM_STR);
        $statement->bindParam(':elevation_gain', $elevation_gain, PDO::PARAM_STR);
        $statement->bindParam(':description', $description, PDO::PARAM_STR);
        $statement->bindParam(':created_at', $created_at, PDO::PARAM_STR);
        $statement->bindParam(':created_by', $created_by, PDO::PARAM_INT);
        $statement->bindParam(':updated_at', $updated_at, PDO::PARAM_STR);
        $statement->bindParam(':id_tags', $id_tag, PDO::PARAM_INT);
        $result = $statement->execute();
        
        if ($result) {
            return "Hike added successfully.";
        } else {
            return "Failed to add hike.";
        }
    }

    public function GetHikesSelectedTags($tagsid)
    {
        $statement = $this->connection->getConnection()->prepare(
            "SELECT id, name, distance, duration FROM Hikes WHERE id_tags = :id_tags"

        );
        $statement->bindParam(':id_tags', $tagsid, PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function deleteHike($hikesId)
    {
        $statement = $this->connection->getConnection()->prepare(
            "DELETE FROM Hikes WHERE id = :id"
        );
        $statement->bindParam(':id', $hikesId, PDO::PARAM_INT);
        $result = $statement->execute();
        
        if ($result) {
            return "Hike deleted successfully.";
        } else {
            return "Failed to delete hike.";
        }
    }
}
