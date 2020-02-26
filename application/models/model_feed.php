<?php
class Model_Feed extends Model
{
    public function get_feed()
    {
        $connect = new connectBD();
        $connect->connect();
        $query = $connect->DBH->prepare("SELECT * FROM cam_users.UserPhoto order by id DESC;");
        $query->execute();
        $data = $query->fetchAll();
        return $data;
    }
}


