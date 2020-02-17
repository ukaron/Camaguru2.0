<?php
class Model_Sign_Up extends Model
{
    protected $email_c;
    protected $login_c;
    protected $pass_c;
    protected $maxLenLogin;
    protected $maxLenPass;
    protected $minLenLogin;
    protected $minLenPass;

    function __construct()
    {
        $this->maxLenLogin = 16;
        $this->maxLenPass = 32;
        $this->minLenLogin = 6;
        $this->minLenPass = 8;
    }

    public function registr($login,$pass,$mail)
    {
        $this->email_c = htmlspecialchars($mail);
        $this->login_c = htmlspecialchars($login);
        $this->pass_c = htmlspecialchars($pass);
        if ($this->checkEmailBD() == false)
            return "E-mail already exists". PHP_EOL;
        else
        {
            if ($this->checkLoginBD() == false)
                return "Login already exists" . PHP_EOL;
            else
            {
                if ($this->checkLogin())
                {
                    if ($this->checkPassword())
                    {
                        if ($this->checkEmail())
                        {
                            if (($this->addAccountDB()) == true)
                                return true;
                            else
                                return false;
                        }
                        else
                            return "E-mail is incorrect". PHP_EOL;
                    }
                    else
                        return "Password is incorrect". PHP_EOL;
                }
                else
                    return "Login is incorrect". PHP_EOL;
            }
        }
    }

    public function addAccountDB()
    {
        $connect = new connectBD();
        $connect->connect();
        $passHash = hash(sha256, $this->pass_c);
        $data = $this->login_c.$this->email_c;
        $token = hash(sha256, $data);

        $add = $connect->DBH->prepare("INSERT INTO cam_users.possibleUsers (login, pass, email, token) VALUES (?,?,?,?);");
        $add->execute(array($this->login_c,$passHash, $this->email_c, $token));
        if ($add == true)
        {
            $host = 'http://'.$_SERVER['HTTP_HOST'].'/';
            $link = $host."sign_up/verification/?token=".$token."&login=".$this->login_c;
            mail($this->email_c, "Registration", "To complete the registration, follow the link ".$link);
            return true;
        }
        else
            return false;
    }

    public function checkLogin()
    {
        if (strlen($this->login_c) >= $this->minLenLogin && strlen($this->login_c) <= $this->maxLenLogin)
        {
            $incorrectSymbol = "!@\#№;$%^:&?\*()-_+=/|\`.,";
            $reg = "/^[a-zA-Z0-9]+$/";
            $bool = false;
            for ($i = 0; $i < strlen($this->login_c); $i++ )
            {
                for ($j = 0; $j < strlen($incorrectSymbol); $j++)
                    if ($this->login_c[$i] == $incorrectSymbol[$j])
                        $bool = true;
            }
            if ($bool != true) {
                if (preg_match($reg, $this->login_c))
                    return true;
                else
                    return false;
            }
        }
        else
                return false;
    }

    public function checkEmail()
    {
        if (filter_var($this->email_c, FILTER_VALIDATE_EMAIL))
            return true;
        else
            return false;
    }

    public function checkPassword()
    {

        if (strlen($this->pass_c) >= $this->minLenPass && strlen($this->pass_c) <= $this->maxLenPass)
        {
            $incorrectSymbol = "!@\#№;$%^:&?*()-_+=/|\`.,";
            $reg = "/[a-zA-Z0-9]/";
            $bool = false;
            for ($i = 0; $i < strlen($this->pass_c); $i++ )
            {
                for ($j = 0; $j < strlen($incorrectSymbol); $j++)
                    if ($this->pass_c[$i] == $incorrectSymbol[$j])
                        $bool = true;
            }
            if ($bool != true)
            {
                if (preg_match($reg, $this->pass_c))
                    return true;
                else
                    return false;
            }
        }
        else
            return false;
    }

    protected function checkLoginBD()
    {
        $connect = new connectBD();
        $connect->connect();
        $query = $connect->DBH->prepare("SELECT *
                                                FROM cam_users.admins, cam_users.moderators, cam_users.activeUsers
                                                WHERE admins.login_a = ? or activeUsers.login = ? or moderators.login_m = ? ;");
        $query->execute(array($this->login_c,$this->login_c,$this->login_c));
        if (($row_1 = $query->fetch()) == true)
            return false;
        $connect->closeConnect();
        return true;
    }
    protected function checkEmailBD()
    {

        $connect = new connectBD();
        $connect->connect();
        $query = $connect->DBH->prepare("SELECT * FROM cam_users.activeUsers, cam_users.possibleUsers
                                                    WHERE activeUsers.email = ? or possibleUsers.email = ?");
        $query->execute(array($this->email_c, $this->email_c));
        if (($row_1 = $query->fetch()) == true)
            return false;
        $connect->closeConnect();
        return true;
    }
    function verification($token, $login)
    {
        $connect = new connectBD();
        $connect->connect();
        $query = $connect->DBH->prepare("SELECT * FROM cam_users.possibleUsers WHERE login = ? AND token = ?");
        $query->execute(array($login, $token));
        $data = $query->fetch();
        $pass = $data['pass'];
        $email = $data ['email'];
        if ($pass != null)
        {
            $query_1 = $connect->DBH->prepare("SELECT * FROM cam_users.activeUsers WHERE login = ?");
            $query_1->execute(array($login));
            if ($query_1->fetch() != null)
                $this->view->generate('alreadyExists_view.php', 'template_view.php');
            else
                {
                    $query = $connect->DBH->prepare("INSERT INTO cam_users.activeUsers (login, pass, email) VALUES (?,?,?);");
                    $query->execute(array($login, $pass, $email));
                }
            $query = $connect->DBH->prepare("DELETE FROM cam_users.possibleUsers WHERE login=?;");
            $query->execute(array($login));
            $_SESSION['login'] = $login;
            return true;
        }
        else
        {
            $query = $connect->DBH->prepare("DELETE FROM possibleUsers WHERE login=?;");
            $query->execute(array($login));
            $connect->closeConnect();
            return false;
        }
    }
}
?>