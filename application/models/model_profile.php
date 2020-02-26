<?php
class Model_Profile extends Model
{
    public $login;
    public $userpic;
    public $bio;
    public $email;
    public $pass;
    protected $maxLenPass;
    protected $minLenPass;
    protected $maxLenLogin;
    protected $minLenLogin;

    public function get_data()
    {
        session_start();
        $this->login = $_SESSION['login'];
        $connect = new connectBD();
        $connect->connect();
        $query = $connect->DBH->prepare("SELECT login, userpic, info, email FROM cam_users.activeUsers WHERE login = ?");
        $query->execute(array($this->login));
        $data = $query->fetchAll();
        $this->userpic = $data[0]['userpic'];;
        if (!isset($this->userpic))
            $this->userpic = "/images/no_userpic.jpg";
        $this->bio = $data[0]['info'];;
        if (!isset($this->bio))
            $this->bio = "BIO";
        $this->email = $data[0]['email'];;
        return array
        (
            'login' => $this->login,
            'userpic' => $this->userpic,
            'bio' => $this->bio,
            'email'=>$this->email
        );
    }

    public  function  change_pass($pass)
    {
        $this->pass = htmlspecialchars($pass);
        if ($this->checkPassword() === true)
        {
            session_start();
            $this->login = $_SESSION['login'];
            $passHash = hash(sha256, $this->pass);

            $connect = new connectBD();
            $connect->connect();
            $query = $connect->DBH->prepare("UPDATE cam_users.activeUsers SET pass = ? WHERE login = ? ");
            $res = $query->execute(array($passHash, $this->login));
            if ($res === true)
                return true;
        }
        return false;
    }

    public function checkPassword()
    {
        $this->maxLenPass = 6;
        $this->maxLenPass = 16;
        if (strlen($this->pass) >= $this->minLenPass && strlen($this->pass) <= $this->maxLenPass)
        {
            $incorrectSymbol = "!@\#№;$%^:&?*()-_+=/|\`.,";
            $reg = "/[a-zA-Z0-9]/";
            $bool = false;
            for ($i = 0; $i < strlen($this->pass); $i++ )
            {
                for ($j = 0; $j < strlen($incorrectSymbol); $j++)
                    if ($this->pass[$i] == $incorrectSymbol[$j])
                        $bool = true;
            }
            if ($bool != true)
            {
                if (preg_match($reg, $this->pass))
                    return true;
                else
                    return false;
            }
        }
        else
            return false;
    }

    public function change_login($login)
    {
        $this->login = htmlspecialchars($login);
        if ($this->check_login() === true)
        {
            session_start();
            $old_login = $_SESSION['login'];
            $connect = new connectBD();
            $connect->connect();
            $query = $connect->DBH->prepare("UPDATE cam_users.activeUsers SET login = ? WHERE login = ? ");
            $res = $query->execute(array($this->login, $old_login));
            if ($res === true)
            {

                $_SESSION['login'] = $this->login;
                return true;
            }
        }
        return false;
    }

    public function check_login()
    {
        $this->minLenLogin = 6;
        $this->maxLenLogin = 16;
        if (strlen($this->login) >= $this->minLenLogin && strlen($this->login) <= $this->maxLenLogin)
        {
            $incorrectSymbol = "!@\#№;$%^:&?*()-_+=/|\`.,";
            $reg = "/[a-zA-Z0-9]/";
            $bool = false;
            for ($i = 0; $i < strlen($this->login); $i++ )
            {
                for ($j = 0; $j < strlen($incorrectSymbol); $j++)
                    if ($this->login[$i] == $incorrectSymbol[$j])
                        $bool = true;
            }
            if ($bool != true)
                if (preg_match($reg, $this->login))
                    if ($this->check_login_DB() === true)
                        return true;
                else
                    return false;
        }
        else
            return false;
    }

    public function check_login_DB()
    {
        $connect = new connectBD();
        $connect->connect();
        $query = $connect->DBH->prepare("SELECT *
                                                FROM cam_users.activeUsers
                                                WHERE activeUsers.login = ? ;");
        $query->execute(array($this->login));
        $connect->closeConnect();
        if (($row_1 = $query->fetch()) == true)
            return false;

        return true;
    }

    public function change_email($email)
    {
        $this->email = htmlspecialchars($email);
        if ($this->check_email() === true)
        {
            session_start();
            $this->login = $_SESSION['login'];
            $connect = new connectBD();
            $connect->connect();
            $query = $connect->DBH->prepare("UPDATE cam_users.activeUsers SET email = ? WHERE login = ? ");
            $res = $query->execute(array($this->email, $this->login));
            if ($res === true)
                return true;
        }
        return false;
    }

    public function check_email()
    {
        if ($this->check_email_DB() === true)
        {
            if (filter_var($this->email, FILTER_VALIDATE_EMAIL))
                return true;
            else
                return false;
        }
        else
            return false;
    }

    public function check_email_DB()
    {
        $connect = new connectBD();
        $connect->connect();
        $query = $connect->DBH->prepare("SELECT *
                                                FROM cam_users.activeUsers, cam_users.possibleUsers
                                                WHERE cam_users.activeUsers.email = ? or cam_users.possibleUsers.email  = ? ;");
        $query->execute(array($this->email, $this->email));
        $connect->closeConnect();
        if (($row_1 = $query->fetch()) == true)
            return false;
        return true;
    }

    public function restore_password($login)
    {
        $connect = new connectBD();
        $connect->connect();
        $query = $connect->DBH->prepare("SELECT email FROM cam_users.activeUsers WHERE login = ?;");
        $query->execute(array($login));
        $email = $query->fetchAll();
        if (isset($email[0]['email'])) {
            $data = $login . $email[0]['email'];
            $token = hash(sha256, $data);
            $query1 = $connect->DBH->prepare("UPDATE cam_users.activeUsers SET token = ? WHERE login = ?");
            $query1->execute(array($token, $login));
            $host = 'http://' . $_SERVER['HTTP_HOST'] . '/';
            $link = $host . "profile/reset_pass/?token=" . $token . "&login=" . $login;
            mail($email[0]['email'], "New password", "For password recovery follow the link ".$link);
            return true;
        }
        else
            return false;
    }

    public function reset_pass($token, $login)
    {
        $connect = new connectBD();
        $connect->connect();
        $query = $connect->DBH->prepare("SELECT * FROM cam_users.activeUsers WHERE login = ? AND token = ?");
        $query->execute(array($login, $token));
        $user = $query->fetchAll();
        if (isset($user[0]['login']))
        {
            session_start();
            $_SESSION['login'] = $login;
            return true;
        }
        else
            return false;
    }
}