<?php
class Controller_Photo extends Controller
{
    function __construct()
    {
        $this->model = new Model_Photo();
        $this->view = new View();

    }

    function action_index()
    {

            $this->view->generate('photo_view.php', 'template_view.php');

    }
    function action_show()
    {
        $login = $_GET['login'];
        $photo_id = $_GET['id'];
        $data['photo'] = $this->model->get_photo_by_id($photo_id, $login);
        $data['comments'] = 0; // add function get_comment_by_id;
        $this->view->generate('photo_view.php', 'template_view.php', $data);
    }

}

?>