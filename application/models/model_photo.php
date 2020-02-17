<?php
class Model_Photo extends Model
{
    public function get_photo_by_id($photo_id, $login)
    {
        include_once './config/database.php';
        $connect = new connectBD();
        $connect->connect();
        $query = $connect->DBH->prepare("SELECT path FROM cam_users.UserPhoto WHERE login = ? AND id = ?");
        $query->execute(array($login,$photo_id));
        $photo = $query->fetchAll();
        return $photo[0];
    }

}