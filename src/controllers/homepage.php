<?php

namespace Application\Controllers;

require_once('src/lib/database.php');
require_once('src/model/hickeslist.php');

use Application\Lib\Database\DatabaseConnection;
use Application\Model\Hickeslist\Hickeslist;

class Homepage
{
    public function execute($env)
    {
        $databaseConnection = new DatabaseConnection($env);
        //we set the databaseConnection for the __construct method
        $hicke = new Hickeslist($databaseConnection);

        $hike_array = $hicke->getListOfHickes();

        require(__DIR__ . '/../view/homepage.view.php');
    }
    public function ShowSelectedTags($tagsid, $env)
    {

        $databaseConnection = new DatabaseConnection($env);
        //we set the databaseConnection for the __construct method
        $hicke = new Hickeslist($databaseConnection);

        $hike_array = $hicke->GetHikesSelectedTags($tagsid);

        require(__DIR__ . '/../view/homepage_tags.view.php');
    }
}
