<?php
require_once ('./application/models/model_sign_up.php');
class Model_New_Admin extends Model_Sign_Up
{
    public function addAccountDB()
    {
        $connect = new connectBD();
        $connect->connect();
        $passHash = hash(sha256, $this->pass_c);
        $add = $connect->DBH->prepare("INSERT INTO news_db.admins (login_a, pass_a, email_a) VALUES (?,?,?);");
        $add->execute(array($this->login,$passHash,$this->email_c));
        if ($add == true)
            return true;
        else
            return false;
    }
    protected function checkEmailBD()
    {
        return true;
    }
}