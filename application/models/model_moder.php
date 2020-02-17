<?php
require_once ('./application/models/model_new_admin.php');
class Model_Moder extends Model
{
    public $login;
    private $pass;
    private $maxLenPass = 16;
    private $minLenPass = 8;


    public function check_moder()
    {
        $this->login = $_SESSION['user'];
        $connect = new connectBD();
        $connect->connect();
        $query = $connect->DBH->prepare("SELECT * FROM news_db.moderators WHERE login_m = ? AND conf_m = ? AND login_m = ?");
        $query->execute(array($this->login, true, $this->login));
        if (($row_1 = $query->fetch()) == true)
            return true;
        $query = $connect->DBH->prepare("SELECT * FROM news_db.admins WHERE login_a = ? AND conf_a = ?  AND login_a = ?");
        $query->execute(array($this->login, true, $this->login));
        if (($row_1 = $query->fetch()) == true)
            return true;
        return false;
    }

    public function change_pass($new_pass)
    {
        $this->pass = $new_pass;
        if (($this->checkPassword()) == true)
        {
            $login = $_SESSION['user'];
            $connect = new connectBD();
            $connect->connect();
            $passHash = hash(sha256, $this->pass);
            $conf = $connect->DBH->prepare("UPDATE moderators SET conf_m = ? WHERE login_m = ?");
            $conf->execute(array('1', $this->login));
            $add = $connect->DBH->prepare("UPDATE moderators SET pass_m = ? WHERE login_m = ?");
            $add->execute(array($passHash, $login));
            if ($add == true)
                return true;
            else
                return false;
        }
        else
            return false;
    }

    public function checkPassword()
    {

        if (strlen($this->pass) >= $this->minLenPass && strlen($this->pass) <= $this->maxLenPass)
        {
            $incorrectSymbol = "!@\"#№;$%^:&?\*()-_+=/|\`.,";
            $reg = "/^[a-zA-Z0-9]+$/";
            $bool = false;
            for ($i = 0; $i < strlen($this->pass); $i++ )
            {
                for ($j = 0; $j < strlen($incorrectSymbol); $j++)
                    if ($this->pass[$i] == $incorrectSymbol[$j])
                        $bool = true;
            }
            if ($bool == false)
            {
                if (preg_match($reg, $this->pass))
                    return true;
                else
                    return false;
            }
        }
        else
            return false;
    }

    public function new_tag($tag_name)
    {
        $connect = new connectBD();
        $connect->connect();
        $find = $connect->DBH->prepare("SELECT * FROM news_db.tags WHERE tag_name = ? ;");
        $find->execute(array($tag_name));
        if (($row_1 = $find->fetch()) != true)
        {
            $add = $connect->DBH->prepare("INSERT IGNORE INTO tags (tag_name) VALUES ('$tag_name');");
            $add->execute();
            if ($add == true)
                return "New tag has been created";
        }
        return "Such a tag already exists";
    }

    public function new_news($news_name, $news_info)
    {
        $this->login = $_SESSION['user'];
        $connect = new connectBD();
        $connect->connect();
        $add = $connect->DBH->prepare("INSERT INTO news_db.news (subj, author_login, public_date, info ) VALUES (?, ?, NOW(), ?);");
        $add->execute(array($news_name, $this->login, $news_info));
        if ($add == true)
        {
            $find = $connect->DBH->prepare("SELECT * FROM news_db.news WHERE author_login = ? ORDER BY public_date DESC;");
            $find->execute(array($this->login));
            $row = $find->fetchAll();
            return $row[0];
        }
        return "Error";
    }

    public function edit_news($news_id)
    {
        if ($_GET['id'] != '')
        {
            $connect = new connectBD();
            $connect->connect();
            $find = $connect->DBH->prepare("SELECT * FROM news_db.news WHERE news_id = ? ;");
            $find->execute(array($news_id));
            $row = $find->fetchAll();
            $row[0]['tags'] = $this->get_tags_name_by_news_id($row[0]['news_id']);
        }
        return $row[0];
    }


    public function get_tags_name_by_news_id($news_id)
    {
        $connect = new connectBD();
        $connect->connect();
        $find = $connect->DBH->prepare("SELECT *  FROM news_db.news
                                        INNER JOIN link_news_tag lnt on news.news_id = lnt.news_id
                                        INNER JOIN tags t on lnt.tag_id = t.tag_id
                                        WHERE news.news_id = ? ORDER BY public_date DESC;");
        $find->execute(array($news_id));
        $tags = $find->fetchAll();
        $content[] = $tags;
        return $content;
    }



    public function handler($start_from)
    {
        $this->login = $_SESSION['user'];
        $connect = new connectBD();
        $connect->connect();
        $find = $connect->DBH->prepare("SELECT * FROM news_db.news WHERE author_login = ? AND status=1 ORDER BY public_date DESC LIMIT ?, 10 ; ");
        $find->execute(array($this->login, $start_from));
        $row = $find->fetchAll();
        $content[] = $row;
        echo json_encode($content[0]);
    }
    public function get_my_news()
    {
        $this->login = $_SESSION['user'];
        $connect = new connectBD();
        $connect->connect();
        $find = $connect->DBH->prepare("SELECT * FROM news_db.news WHERE author_login = ? AND status=1 ORDER BY public_date DESC LIMIT 10;");
        $find->execute(array($this->login));
        $row = $find->fetchAll();
        $content[] = $row;
        return $content;
    }

    public function add_tag_for_news($news_id, $tag_name)
    {
        $this->new_tag($tag_name);
        $tag_id = $this->get_tag_id_by_tag_name($tag_name);
        $connect = new connectBD();
        $connect->connect();
        $add = $connect->DBH->prepare("INSERT INTO news_db.link_news_tag (news_id, tag_id)
                                            VALUES (?, ?);");
        $add->execute(array($news_id, $tag_id));
        header('Location:/moder/edit_news/?id='.$news_id.'');
    }

    public function get_tag_id_by_tag_name($tag_name)
    {
        $connect = new connectBD();
        $connect->connect();
        $find = $connect->DBH->prepare("SELECT tag_id FROM news_db.tags WHERE tag_name = ? ;");
        $find->execute(array($tag_name));
        $tags_id = $find->fetchAll();
        return $tags_id[0];
    }

    public function edit_subj($news_id1, $new_subj)
    {
        $news_id = $news_id1;
        $connect = new connectBD();
        $connect->connect();
        $add = $connect->DBH->prepare("UPDATE news_db.news SET subj = ? WHERE news_id = ?");
        $add->execute(array($new_subj, $news_id));
        header('Location:/moder/edit_news/?id='.$news_id);
    }
    public function edit_info($news_id1, $new_info)
    {
        $news_id = $news_id1;
        $connect = new connectBD();
        $connect->connect();
        $add = $connect->DBH->prepare("UPDATE news_db.news SET info = ? WHERE news_id = ?");
        $add->execute(array($new_info, $news_id));
        header("Location:/moder/edit_news/?id=".$news_id);
    }

    public function delete_news($news_id)
    {
        $connect = new connectBD();
        $connect->connect();
        $add = $connect->DBH->prepare("UPDATE news_db.news SET status = ? WHERE news_id = ?");
        $add->execute(array(0, $news_id));
        header('Location:/moder');
    }
}
