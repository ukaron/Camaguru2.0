<?php
class Controller_Moder extends Controller
{
    function __construct()
    {
        $this->model = new Model_Moder();
        $this->view = new View();
    }

    function action_index()
    {
        session_start();
        if (isset($_SESSION['user']))
        {
            if ($this->model->check_moder($_SESSION['user']))
            {
                $data = $this->model->get_my_news();
                $this->view->generate('moder_view.php', 'template_view.php', $data);
            }
            else
                $this->action_change_pass();
        }
        else
            header('Location:/');
    }

    function action_handler()
    {
        $start_from = $_POST['start_from'];
        $this->model->handler($start_from);
    }

    function action_change_pass()
    {
        if (isset($_POST['pass']) && isset($_POST['pass_1']))
        {
            if (!strcmp($_POST['pass'], $_POST['pass_1']))
            {
                $this->model->login = $_SESSION['user'];
                $new_pass = $_POST['pass'];
                $data['message'] = $this->model->change_pass($new_pass);
                header('Location:/moder');
            }
            else
                $data['message'] = "Passwords do not match";
        }
        $this->view->generate('change_pass_view.php', 'template_view.php', $data['message']);
    }

    function action_new_tag()
    {
        if (isset($_POST['tag']))
        {

            $tag_name = $_POST['tag'];
            $data['message'] = $this->model->new_tag($tag_name);
            $this->view->generate('moder_view.php', 'template_view.php', $data['message']);
        }
    }

    function action_new_news()
    {
        if (isset($_POST['news_name']) && isset($_POST['info']))
        {
            $news_name = $_POST['news_name'];
            $news_info = $_POST['info'];
            $data = $this->model->new_news($news_name, $news_info);
            $this->view->generate('edit_news_view.php', 'template_view.php', $data);
        }
    }

    function action_edit_news()
    {
        if ($_GET['id'] != '')
        {
            $news_id = $_GET['id'];
            $data = $this->model->edit_news($news_id);
            if (isset($data))
                $this->view->generate('edit_news_view.php', 'template_view.php', $data);
        }
    }

    function action_delete_news()
    {
        if(isset($_POST['news_id']))
        {
            $news_id = $_POST['id'];
            $this->model->delete_news($news_id);
        }
        elseif ($_GET['id'] != '')
        {
            $news_id = $_GET['id'];
            $this->model->delete_news($news_id);
        }
    }

    function action_edit_subj()
    {
        if(isset($_POST['news_id']))
        {
            $news_id = $_POST['news_id'];
            $new_subj = $_POST['new_subj'];
            $this->model->edit_subj($news_id, $new_subj);
        }

    }
    function action_edit_info()
    {
        if(isset($_POST['news_id']))
        {
            $news_id = $_POST['news_id'];
            $new_info = $_POST['new_info'];
            $this->model->edit_info($news_id, $new_info);
        }
    }

    public function action_add_tag_for_news()
    {
        if (isset($_POST['news_id']) && isset($_POST['tag_name']))
        {
            $news_id = $_POST['news_id'];
            $tag_name = $_POST['tag_name'];
            $data = $this->model->add_tag_for_news($news_id, $tag_name);
            $this->view->generate('edit_news_view.php', 'template_view.php', $data);
        }
    }
}