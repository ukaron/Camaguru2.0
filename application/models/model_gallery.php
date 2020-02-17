<?php
class Model_Gallery extends Model
{
    public function get_photo()
    {
        session_start();
        include_once './config/database.php';
        $login = $_SESSION['login'];
        $connect = new connectBD();
        $connect->connect();
        $query = $connect->DBH->prepare("SELECT path FROM cam_users.UserPhoto WHERE login = ? ORDER BY id DESC");
        $query->execute(array($login));
        $photo = $query->fetchAll();
        return $photo;
    }

    public function get_link()
    {
        session_start();
        include_once './config/database.php';
        $login = $_SESSION['login'];
        $connect = new connectBD();
        $connect->connect();
        $query = $connect->DBH->prepare("SELECT id FROM cam_users.UserPhoto WHERE login = ? ORDER BY id DESC");
        $query->execute(array($login));
        $link = $query->fetchAll();
        return $link;
    }

    public function get_photo_by_id($photo_id)
    {
        session_start();
        include_once './config/database.php';
        $login = $_SESSION['login'];
        $connect = new connectBD();
        $connect->connect();
        $query = $connect->DBH->prepare("SELECT path FROM cam_users.UserPhoto WHERE login = ? AND = ?");
        $query->execute(array($login,$photo_id));
        $photo = $query->fetchAll();
        return $photo;
    }

}