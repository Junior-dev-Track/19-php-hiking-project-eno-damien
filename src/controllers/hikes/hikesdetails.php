<?php

namespace Application\Controllers\Hikes;

require_once('src/lib/database.php');
require_once('src/model/hickeslist.php');

use Application\Lib\Database\DatabaseConnection;
use Application\Model\Hickeslist\Hickeslist;

class HikesDetails
{
    //Give the Id information URL if we want to display the details of a product
    public function ShowHikes($hikesId, $env)
    {
        $error_com = '';
        $success_com = '';

        $databaseConnection = new DatabaseConnection($env);
        //we set the databaseConnection for the __construct method
        $HickesDetails = new Hickeslist($databaseConnection);

        $hike = $HickesDetails->getHikesDetails($hikesId);

        $hikesComments_array = $HickesDetails->getHikesComments($hikesId);
        
        //$productComments = $HickesDetails->getProductComments($codeProduct);
        require(__DIR__ . '/../../view/hikes/hikesdetails.view.php');
    }
}
