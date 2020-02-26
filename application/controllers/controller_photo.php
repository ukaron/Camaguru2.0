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
        $data['comments'] = $this->model->get_comments($photo_id);
        $this->view->generate('photo_view.php', 'template_view.php', $data);
    }

    function action_add_comment()
    {
        if (isset($_POST['comment']) && isset($_POST['photo_id']))
        {
            $comment = $_POST['comment'];
            $photo_id = $_POST['photo_id'];
            $res = $this->model->add_comment($comment, $photo_id);
            return true;
        }
    }
}