<?php
class Controller_Profile extends Controller
{
    function __construct()
    {
        $this->model = new Model_Profile();
        $this->view = new View();
    }

    function action_index()
    {
        $data = $this->model->get_data();
        $this->view->generate('profile_view.php', 'template_view.php', $data);
    }

    function action_change_pass()
    {
        $this->view->generate('change_pass_view.php', 'template_view.php');
    }

    function action_new_pass()
    {
        if (isset($_POST['pass']) && isset($_POST['pass_1']))
        {
            $pass = $_POST['pass'];
            $pass1 = $_POST['pass_1'];
            if (strcmp($pass, $pass1) !== 0){

                $data = 'Passwords do not match';
                $this->view->generate('change_pass_view.php', 'template_view.php', $data);
            }
            else
                if (($this->model->change_pass($pass)) === true)
                    {
                        $data = "Passport changed!";
                        $this->view->generate('test_view.php', 'template_view.php', $data);
                    }
        }
    }

    function action_change_login()
    {
        if (isset($_POST['login']))
        {
            $login = $_POST['login'];
            $data = $this->model->get_data();
            if(($this->model->change_login($login)) === false)
                $data['mess_login'] = "login incorrect";
            $this->view->generate('profile_view.php', 'template_view.php', $data);
        }
    }

    function action_change_email()
    {
        if (isset($_POST['email']))
        {
            $email = $_POST['email'];
            $data = $this->model->get_data();
            if (($this->model->change_email($email)) === false)
                $data['mess_email'] ="email incorrect";
            else
                $data['mess_email'] ="email has been changed";
            $this->view->generate('profile_view.php', 'template_view.php', $data);
        }
    }

    function action_restore_password()
    {
        $this->view->generate( 'restore_view.php', 'template_view.php');
    }

    function action_restore_pw_with_login()
    {
        if (isset($_POST['login']))
        {
            $login = $_POST['login'];
            $data = $this->model->restore_password($login);
            if ($data === true)
            {
                $data = "To recover your password, check your mail";
                $this->view->generate('test_view.php', 'template_view.php', $data);
            }
            else
                {
                    $data = "Login not found";
                    $this->view->generate('test_view.php', 'template_view.php', $data);
                }
        }
    }

    function action_reset_pass()
    {
        if (isset($_GET['token']) && isset($_GET['login']))
        {
            $token = $_GET['token'];
            $login = $_GET['login'];
            $data = $this->model->reset_pass($token, $login);
            if ($data === true)
            {
                $this->view->generate( 'change_pass_view.php', 'template_view.php');
            }
        }
    }
}