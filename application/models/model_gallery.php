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
        $query = $connect->DBH->prepare("SELECT path FROM cam_users.UserPhoto WHERE login = ? AND id = ?");
        $query->execute(array($login,$photo_id));
        $photo = $query->fetchAll();
        return $photo;
    }

    public function delete_photo($photo_id)
    {
        session_start();
        $login = $_SESSION['login'];
        $connect = new connectBD();
        $connect->connect();
        $query1 = $connect->DBH->prepare("SELECT * FROM cam_users.UserPhoto WHERE login = ? AND id =?");
        $query1->execute(array($login, $photo_id));
        $row = $query1->fetchAll();
        if (isset($row[0]['path']))
        {
            $query = $connect->DBH->prepare("DELETE FROM cam_users.UserPhoto WHERE login = ? AND id = ?;");
            $query->execute(array($login, $photo_id));
            if (unlink($row[0]['path']) === true)
                return true;
            else
                return false;
        }
        else
            return false;
    }
}