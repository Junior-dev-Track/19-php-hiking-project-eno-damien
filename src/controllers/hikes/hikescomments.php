<?php

namespace Application\Controllers\Hikes;

require_once('src/model/hickescomments.php');

use Application\Lib\Database\DatabaseConnection;
use Application\Model\HikesComments as HikesCommentsModel;



class HikesComments
{

    public function AddComment($input, $hikeid, $userid, $env)
    {
        $databaseConnection = new DatabaseConnection($env);
        $newData = new HikesCommentsModel($databaseConnection);

        if (empty($input['hikesComment'])) {
            $error_com = 'Error. Please retry.';
            header('Location: ' . BASE_PATH . '/hikes/' . $hikeid);
        } elseif (!empty($input)) {
            $hikescomments = htmlspecialchars($input['hikesComment']);

            date_default_timezone_set('Europe/Paris');
            $date_comment = new \DateTime();
            $posted = $date_comment->format("Y-m-d H:i:s");

            $newData->addCommentHicke($hikescomments, $hikeid, $userid, $posted);
            header('Location: ' . BASE_PATH . '/hikes/' . $hikeid);
        } else {
            $error_com = 'Error. Please retry.';
        }
    }

    public function DeleteComment($hikeid, $commentid, $env)
    {
        $databaseConnection = new DatabaseConnection($env);
        $newData = new HikesCommentsModel($databaseConnection);

        //Check if comment exists and if the user is the author of the comment, if not, redirect to Page not found
        $comment = $newData->getCommentHicke($commentid);
        
        $user_id = isset($_SESSION['user']['sess_id']) ? $_SESSION['user']['sess_id'] : null;
        if (!$comment || $comment['id_user'] != $user_id) {
            header('Location: ' . BASE_PATH . '/hikes/' . $hikeid);
            exit();
        }

        $newData->delCommentHicke($commentid);
        header('Location: ' . BASE_PATH . '/hikes/' . $hikeid);
    }

    public function EditComment($hikeid, $commentid, $input, $action, $env)
    {
        $databaseConnection = new DatabaseConnection($env);
        $newData = new HikesCommentsModel($databaseConnection);

        if ($action === 'editCommentHicke') {
            $hikesComments = $newData->getCommentHicke($commentid);

            if (isset($hikesComments)) {
                $error_com = 'Error. No hike comment found, please retry.';
            }

            require(__DIR__ . '/../../view/hikes/edithikescomments.view.php');
        } elseif ($action === 'editCommentHickeV') {
            $commenthicke = htmlspecialchars($input['hikesComment']);

            $newData->editCommentHicke($commentid, $commenthicke);

            //Check if comment exists and if the user is the author of the comment, if not, redirect to Page not found
            $comment = $newData->getCommentHicke($commentid);
            if (!$comment || $comment['userid'] != $userid) {
                header('Location: ' . BASE_PATH . '/hikes/' . $hikeid);
                exit();
            }

            $success_com = 'Comment edited successfully';
            header('Location: ' . BASE_PATH . '/hikes/' . $hikeid);
           
        } else {
            $error_com = 'Error. data form incorrect, please retry.';
            header('Location: ' . BASE_PATH . '/hikes/' . $hikeid);
        }
    }
}
