<?php
class Controller_Sign_Up extends Controller
{
    function __construct()
    {
        $this->view = new View();
    }

    function action_index()
    {
            $this->view->generate('sign_up_view.php', 'template_view.php');
    }

    function action_registr()
    {
        $this->model = new Model_Sign_Up();
        echo $this->model->message;
        if (isset($_POST))
        {
            $login = $_POST['login'];
            $pass = $_POST['pass'];
            $email = $_POST['email'];
            $data_user = $login.$pass;
            $token = hash(sha256, $data_user);
            $data = $this->model->init($login, $pass, $email, $token);
            if ($data)
            {
                $host = 'http://'.$_SERVER['HTTP_HOST'].'/';
                mail($email, "Registration", "To complete the registration, follow the link ".$host."sign_up/verification/?token=".$token."&login=".$login);
                $this->view->generate('sign_up_ok_view.php', 'template_view.php', $this->model->message);
            }
        }
        else
            $this->view->generate('sign_up_view.php', 'template_view.php', $this->model->message);
        $_POST = array();
    }

    function action_verification()
    {
        $tokenGet = $_GET['token'];
        $loginGet = $_GET['login'];

        $connect = new connectBD();
        $connect->connect();
        $query = $connect->DBH->prepare("SELECT * FROM possibleUsers WHERE login = ? AND token = ?");
        $query->execute(array($loginGet, $tokenGet));
        $data = $query->fetch();
        $pass = $data['pass'];
        $email = $data ['email'];
        if ($pass != null)
        {
            $query_1 = $connect->DBH->prepare("SELECT * FROM activeUsers WHERE login = ?");
            $query_1->execute(array($loginGet));
            if ($query_1->fetch() != null)
                $this->view->generate('alreadyExists_view.php', 'template_view.php');
            else
                $query_3 = $connect->DBH->query("INSERT INTO activeUsers (login, pass, email) VALUES ('$loginGet','$pass', '$email');");
            $query_2 = $connect->DBH->query("DELETE FROM possibleUsers WHERE login='$loginGet';");
            $_SESSION['login'] = $loginGet;
            $this->view->generate('verif_ok.php', 'template_view.php');
        }
        else
        {
            $query_2 = $connect->DBH->query("DELETE FROM possibleUsers WHERE login='$loginGet';");
            $this->view->generate('alreadyExists_view.php', 'template_view.php');
        }
        $connect->closeConnect();
    }
}