<?php
class Controller_Gallery extends Controller
{
    function __construct()
    {

            $this->model = new Model_Gallery();
            $this->view = new View();

    }

    function action_index()
    {
            $data['photo'] = $this->model->get_photo();
            $data['link'] = $this->model->get_link();
            $this->view->generate('gallery_view.php', 'template_view.php',$data);
    }

    function action_photo()
    {
        $photo_id = $_GET['id'];
        $data['photo'] = $this->model->get_photo_by_id($photo_id);
        $data['comment'] = 0; // add function get_comment_by_id;
        $this->view->generate('gallery_view.php', 'template_view.php',$data);
    }
    function action_delete_photo()
    {
        $photo_id = $_GET['id'];
        $data = $this->model->delete_photo($photo_id);
        if ($data === true)
        {
            $data = "Photo deleted successfully";
            $this->view->generate('test_view.php', 'template_view.php',$data);
        }
        else
        {
            $data = "Photo cannot be deleted";
            $this->view->generate('test_view.php', 'template_view.php',$data);
        }
    }

}