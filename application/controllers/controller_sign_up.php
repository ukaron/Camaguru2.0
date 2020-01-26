<?php
class Controller_Sign_Up extends Controller
{
    function __construct()
    {
        $this->model = new Model_Sign_Up();
        $this->view = new View();
    }

    function action_index()
    {
        $data = $this->model->get_data();
        $this->view->generate('sign_up_view.php', 'template_view.php', $data);
    }
}