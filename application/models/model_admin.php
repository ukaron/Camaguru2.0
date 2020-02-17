<?php
require_once ('./application/models/model_new_admin.php');
class Model_Admin extends Model
{
    private $pass;
    private $maxLenPass = 16;
    private $minLenPass = 8;


    public function check_admin($admin)
    {
        $connect = new connectBD();
        $connect->connect();
        $query = $connect->DBH->prepare("SELECT * FROM news_db.admins WHERE login_a = ? AND conf_a = ? AND login_a=?");
        $query->execute(array($admin, true, $admin));
        if (($row_1 = $query->fetch()) == true)
            return true;
        return false;
    }

    public function change_pass($new_pass)
    {
        $this->pass = $new_pass;
        if (($this->checkPassword()) == true)
        {
            $login = $_SESSION['user'];
            $connect = new connectBD();
            $connect->connect();
            $passHash = hash(sha256, $this->pass);
            $conf = $connect->DBH->prepare("UPDATE news_db.admins SET conf_a = ? WHERE login_a = ?");
            $conf->execute(array('1', $login));
            $add = $connect->DBH->prepare("UPDATE news_db.admins SET pass_a = ? WHERE login_a = ?");
            $add->execute(array($passHash, $login));
            if ($add == true)
                return true;
            else
                return false;
        }
        else
            return false;
    }

    public function checkPassword()
    {

        if (strlen($this->pass) >= $this->minLenPass && strlen($this->pass) <= $this->maxLenPass)
        {
            $incorrectSymbol = "!@\"#№;$%^:&?\*()-_+=/|\`.,";
            $reg = "/^[a-zA-Z0-9]+$/";
            $bool = false;
            for ($i = 0; $i < strlen($this->pass); $i++ )
            {
                for ($j = 0; $j < strlen($incorrectSymbol); $j++)
                    if ($this->pass[$i] == $incorrectSymbol[$j])
                        $bool = true;
            }
            if ($bool == false)
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

    public function new_admin($login, $pass, $email)
    {
        require_once ('./application/models/model_new_admin.php');
        $model = new Model_New_Admin($login,$pass, $email);
        return ($model->registr());
    }

    public function new_moderator($login, $pass, $email)
    {
        require_once ('./application/models/model_new_moderator.php');
        $model = new Model_New_Moderator($login,$pass, $email);
        return ($model->registr());
    }
}