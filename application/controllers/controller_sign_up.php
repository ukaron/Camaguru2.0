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
        if (isset($_POST))
        {
            if (!strcmp($_POST['pass'], $_POST['pass_1']))
            {
                $login = $_POST['login'];
                $pass = $_POST['pass'];
                $email = $_POST['email'];
                $this->model = new Model_Sign_Up();
                $data = $this->model->registr($login, $pass, $email);
                if (is_bool($data) && $data == true)
                {
                    $data = "You will immediately receive a confirmation email upon completion of this form with account
                activation URL and login instructions.";
                    $this->view->generate('sign_up_ok_view.php', 'template_view.php', $data);
                }
            }
            else
                {
                $data = "Passwords do not match";
                $this->view->generate('sign_up_view.php', 'template_view.php', $data);
                }
        }
        else
            $this->view->generate('sign_up_view.php', 'template_view.php');
    }

    function action_verification()
    {
        if (isset($_GET['login']) && isset($_GET['token']))
        {
            $this->model = new Model_Sign_Up();
            $tokenGet = $_GET['token'];
            $loginGet = $_GET['login'];
            $data = $this->model->verification($tokenGet, $loginGet);
            if (is_bool($data) && $data == true)
            {
                $data = "Registration completed successfully!";
                $this->view->generate('sign_up_ok_view.php', 'template_view.php', $data);
            }
        }
    }
}