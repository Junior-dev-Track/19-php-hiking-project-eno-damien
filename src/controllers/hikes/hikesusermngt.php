<?php

namespace Application\Controllers\Hikes;

require_once('src/model/hickeslist.php');

use Application\Lib\Database\DatabaseConnection;
use Application\Model\Hickeslist\Hickeslist;

class Hikesusermngt
{
    public function ListHikesUser($userid, $env)
    {
        $databaseConnection = new DatabaseConnection($env);
        $newData = new Hickeslist($databaseConnection);

        $hikes = $newData->getHikesListUser($userid);
        require(__DIR__ . '/../../view/hikes/hikesusermngt.view.php');
    }

    public function EditHikesUser($hikeid, $env, $action)
    {
        $databaseConnection = new DatabaseConnection($env);
        $newData = new Hickeslist($databaseConnection);

        $hikes = $newData->EditHikes($hikeid);
        require(__DIR__ . '/../../view/hikes/hikesusermngtedit.view.php');
        
        //elseif ($action=='deletehike') {
        //$hikes = $newData->DeleteHikes($hikeid);
        //}


    }

    public function SaveHikesUser($hikeid, $env, $input, $userid, $action)
    {
        $databaseConnection = new DatabaseConnection($env);
        $newData = new Hickeslist($databaseConnection);

        $name = htmlspecialchars($input['name']);
        $distance = htmlspecialchars($input['distance']);
        $duration = htmlspecialchars($input['duration']);
        $elevation_gain = htmlspecialchars($input['elevation_gain']);
        $description = htmlspecialchars($input['description']);
        date_default_timezone_set('Europe/Paris');
        $date_update = new \DateTime();
        $updated_at = $date_update->format("Y-m-d H:i:s");
        $id_tag = htmlspecialchars($input['id_tags']);

        if ($action == 'edithike') {
            $hikes = $newData->SaveHikes($hikeid, $name, $distance, $duration, $elevation_gain, $description, $updated_at, $id_tag);
        }
        
        elseif ($action == 'saveaddhike') {

            $created_by = htmlspecialchars($userid);
            $created_at = $date_update->format("Y-m-d H:i:s");
            $hikes = $newData->SaveAddHikes($name, $distance, $duration, $elevation_gain, $description, $created_by, $created_at, $updated_at, $id_tag);
        }

        //header('Location: ' . BASE_PATH . '/user/hikesmngt/' . $userid);
        }
        //elseif ($action=='deletehike') {
        //$hikes = $newData->DeleteHikes($hikeid);
        //}

    public function AddHikesUser($userid)
    {
        require(__DIR__ . '/../../view/hikes/hikesusermngtadd.view.php');
    }
}
