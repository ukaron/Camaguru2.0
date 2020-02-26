<?php
class Controller_Feed extends Controller
{
    function __construct()
    {
        session_start();
        if (isset($_SESSION['status']))
        {
            $this->model = new Model_Feed();
            $this->view = new View();
        }
        else
            header('Location:/sign_in');
    }
    function action_index()
    {
        session_start();
        if (isset($_SESSION['status']))
        {
            $data = $this->model->get_feed();
            $this->view->generate('feed_view.php', 'template_view.php',$data);
        }
        else
            header('Location:/sign_in');
    }
}
?>