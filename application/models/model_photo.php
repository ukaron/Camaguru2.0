<?php
include_once './config/database.php';
class Model_Photo extends Model
{
    public function get_photo_by_id($photo_id, $login)
    {
        $connect = new connectBD();
        $connect->connect();
        $query = $connect->DBH->prepare("SELECT path FROM cam_users.UserPhoto WHERE login = ? AND id = ?");
        $query->execute(array($login, $photo_id));
        $photo = $query->fetchAll();
        return $photo[0];
    }

    public function add_comment($comment, $photo_id)
    {
        session_start();
        $login = $_SESSION['login'];
        $connect = new connectBD();
        $connect->connect();
        $query = $connect->DBH->prepare("INSERT INTO cam_users.comments (comment, user_login, photo_id) VALUES (?, ?, ?);");
        if (($query->execute(array($comment, $login, $photo_id))) === true)
            return true;
        else
            return false;
    }

    public function get_comments($photo_id)
    {
        $connect = new connectBD();
        $connect->connect();
        $query = $connect->DBH->prepare("SELECT comment, user_login FROM cam_users.comments WHERE photo_id = ? ;");
        $query->execute(array($photo_id));
        $comments = $query->fetchAll();
        return $comments;
    }
}