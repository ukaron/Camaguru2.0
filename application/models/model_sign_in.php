<?php
class Model_Sign_In extends Model
{
    public $login;
    public $pass;

    public function sign_in($user)
    {
        session_start();
        if ($this->check_user($user))
        {
            $_SESSION['login'] = $this->login;
            $_SESSION['status'] = "user";
            header('Location:/index');
        }
        else
            return "Wrong login or password";
    }

    public function check_user($user)
    {
        $this->login = $user['login'];
        $this->pass = $user['pass'];
        $connect = new connectBD();
        $connect->connect();
        $query = $connect->DBH->prepare("SELECT * FROM cam_users.activeUsers WHERE login= ?
                                                                            AND pass = ?;");
        $query->execute(array($this->login, $this->pass));
        if (($row_1 = $query->fetch()) == true)
            return true;
        else
            return false;
    }

}