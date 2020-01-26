<?php
class Controller_Sign_In extends Controller
{
    public $login;
    public $pass;
    function action_index()
    {
        if (isset($_POST['login']) && isset($_POST['pass'])) {
            $this->login = $_POST['login'];
            $this->pass = hash(sha256, $_POST['pass']);
            $connect = new connectBD();
            $connect->connect();
            $res = $connect->query("SELECT login FROM activeUsers WHERE login='" . $this->login . "'
                                                                            AND pass = '" . $this->pass . "';");
            if (!empty($res))
            {
                $_SESSION['login'] = $this->login;
                header("Location: ./main");
            }
            else
                $data["login_status"] = "access_denied";
        }
        else
            {
            $data["login_status"] = "";
        }
        $this->view->generate('sign_in_view.php', 'template_view.php', $data);
    }

    function action_logout()
    {
        session_start();
        session_destroy();
        header('Location:/');
    }
}
