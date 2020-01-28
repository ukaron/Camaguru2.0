<?php
class Model_Sign_Up extends Model
{
    private $email_c;
    private $login_c;
    private $pass_c;
    private $token;
    private $maxLenLogin;
    private $maxLenPass;
    private $minLenLogin;
    private $minLenPass;
    public $message;

    function init($login,$pass,$mail,$token)
    {
        $this->email_c = htmlspecialchars($mail);
        $this->login_c = htmlspecialchars($login);
        $this->pass_c = htmlspecialchars($pass);
        $this->maxLenLogin = 12;
        $this->maxLenPass = 32;
        $this->minLenLogin = 3;
        $this->minLenPass = 6;
        $this->token = $token;
        $this->message = "";
        return $this->registr();
    }

    public function registr()
    {
        if ($this->checkEmailBD() == false)
        {
            $this->message = "E-mail already exists". PHP_EOL;
            return false;
        }
        else
        {

            if ($this->checkLoginBD() == false)
            {
                $this->message = "Login already exists" . PHP_EOL;
                return false;
            }
            else
            {

                if ($this->checkLogin())
                {

                    if ($this->checkPassword())
                    {

                        if ($this->checkEmail())
                        {

                            if ($this->addAccountDB())
                                return true;
                            else
                                return false;
                        }
                        else
                        {
                            $this->message = "E-mail is incorrect". PHP_EOL;
                            echo $this->message;

                            return false;
                        }
                    }
                    else
                    {

                        $this->message = "Password is incorrect". PHP_EOL;
                        echo $this->message;

                        return false;
                    }
                }
                else
                {

                    $this->message = "Login is incorrect". PHP_EOL;
                    echo $this->message;

                    return false;
                }
            }
        }
    }

    public function addAccountDB()
    {
        $connect = new connectBD();
        $connect->connect();
        $passHash = hash(sha256, $this->pass_c);

        $add = $connect->DBH->prepare("INSERT INTO possibleUsers (login, pass, email, token) VALUES ('$this->login_c','$passHash', '$this->email_c', '$this->token');");
        $add->execute();
        if ($add == true)
            return true;
        else
            return false;
    }

    public function checkLogin()
    {
        if (strlen($this->login_c) >= $this->minLenLogin && strlen($this->login_c <= $this->maxLenLogin))
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

        if (strlen($this->login_c) >= $this->minLenLogin && strlen($this->login_c <= $this->maxLenLogin))
        {
            $incorrectSymbol = "!@\#№;$%^:&?*()-_+=/|\`.,";
            $reg = "/[a-zA-Z0-9]/";
            $bool = false;
            for ($i = 0; $i < strlen($this->login_c); $i++ )
            {
                for ($j = 0; $j < strlen($incorrectSymbol); $j++)
                    if ($this->login_c[$i] == $incorrectSymbol[$j])
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

    private function checkLoginBD()
    {
        $connect = new connectBD();
        $connect->connect();
        $query = $connect->DBH->prepare("SELECT * FROM activeUsers WHERE login = ?");
        $query->execute(array($this->login_c));
        if (($row_1 = $query->fetch()) == true)
            return false;
        $query_1 = $connect->DBH->prepare("SELECT * FROM possibleUsers WHERE login = ?");
        $query_1->execute(array($this->login_c));
        if (($row_2 = $query_1->fetch()) == true)
            return false;
        $connect->closeConnect();
        return true;
    }
    private function checkEmailBD()
    {

        $connect = new connectBD();
        $connect->connect();
        $query = $connect->DBH->prepare("SELECT * FROM activeUsers WHERE email = ?");
        $query->execute(array($this->email_c));
        if (($row_1 = $query->fetch()) == true)
            return false;
        $query_1 = $connect->DBH->prepare("SELECT * FROM possibleUsers WHERE email = ?");
        $query_1->execute(array($this->email_c));
        if (($row_2 = $query_1->fetch()) == true)
            return false;
        $connect->closeConnect();
        return true;
    }
}
?>