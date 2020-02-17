<?php
require_once ('./application/models/model_sign_up.php');
class Model_New_Moderator extends Model_Sign_Up
{
    public function addAccountDB()
    {
        $connect = new connectBD();
        $connect->connect();
        $passHash = hash(sha256, $this->pass_c);
        $add = $connect->DBH->prepare("INSERT INTO moderators (login_m, pass_m, email_m) VALUES (?,?,?);");
        $add->execute(array($this->login_c,$passHash,$this->email_c));
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