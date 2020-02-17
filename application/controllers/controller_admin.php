<?php

class Controller_Admin extends Controller
{
    function __construct()
    {
        $this->model = new Model_Admin();
        $this->view = new View();
    }

    function action_index()
    {
        session_start();
        if (isset($_SESSION['admin']))
        {
            if ($this->model->check_admin($_SESSION['admin'])) {
                $this->view->generate('admin_view.php', 'template_view.php');
            } else {
                $this->view->generate('change_pass_view.php', 'template_view.php');
            }
        }
        else
            header('Location:/');
    }
    function action_change_pass()
    {
        if (isset($_POST['pass']) && isset($_POST['pass_1']))
        {
            if (!strcmp($_POST['pass'], $_POST['pass_1']))
            {
                $this->model->login = $_SESSION['admin'];
                $new_pass = $_POST['pass'];
                $data = $this->model->change_pass($new_pass);
                header('Location:/admin');
            }
            else
                $data = "Passwords do not match";
        }
        $this->view->generate('change_pass_view.php', 'template_view.php', $data);
    }

    function action_new_admin()
    {
        if (isset($_POST['pass']) && isset($_POST['pass_1']))
        {
            if (!strcmp($_POST['pass'], $_POST['pass_1']))
            {
                $login = $_POST['login'];
                $new_pass = $_POST['pass'];
                $email = $_POST['email'];
                if (is_bool($data = $this->model->new_admin($login, $new_pass, $email)) == true)
                    $data = "A new administrator has been created";
            }
            else
                $data = "Passwords do not match";
        }
        $this->view->generate('admin_view.php', 'template_view.php', $data);
    }

    function action_new_moderator()
    {
        if (isset($_POST['pass']) && isset($_POST['pass_1']))
        {
            if (!strcmp($_POST['pass'], $_POST['pass_1']))
            {
                $login = $_POST['login'];
                $pass = $_POST['pass'];
                $email = $_POST['email'];
                if (is_bool($data =$this->model->new_moderator($login, $pass,$email)) == true)
                        $data = "A new moderator has been created";
            }
            else
                $data = "Passwords do not match";
        }
        $this->view->generate('admin_view.php', 'template_view.php', $data);
    }
}