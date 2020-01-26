<?php
class Controller_Main extends Controller
{
    function action_index()
    {
        if (isset($_SESSION['login']))
            $this->view->generate('main_view.php', 'template_view.php');
        else
            header('Location:/');
    }
    function action_logout()
    {
        session_start();
        session_destroy();
        header('Location:/');
    }

    function action_camshoot()
    {
        include_once './config/database.php';
        date_default_timezone_set('UTC');
        $login = $_SESSION['login'];
        if (!file_exists('/resources'))
            mkdir('/resources');
        if ($_POST['action']) {
            $tmpPath = '/resources/tmp.png';
            $path = '/resources/' . $login . '/' . time() . hash(sha256, $login) . '.png';
            if (!file_exists('./resources/' . $login))
                mkdir('./resources/' . $login);
            $connect = new connectBD();
            $connect->connect();
            copy($tmpPath, $path);
            $connect->DBH->query("INSERT INTO UserPhoto (path, login) VALUES ('".$path ."', '". $login ."');");
            $connect->closeConnect();
        }
    }
}
