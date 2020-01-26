<?php
class Model_Profile extends Model
{
    public $login;
    public $fname;
    public $lname;
    public $userpic;
    public $bio;

    public function get_data()
    {
        $this->login = "ukaron";
        $connect = new connectBD();
        $connect->connect();
        $data = $connect->query("SELECT login, fname, lname, userpic, info FROM activeUsers WHERE login='".$this->login."';");
        $this->fname = $data['fname'];
        if ($this->fname == null)
            $this->fname = "First name";
        $this->lname = $data['lname'];;
        if ($this->lname == null)
            $this->lname = "Last name";
        $this->userpic = $data['userpic'];;
        if (!isset($this->userpic))
            $this->userpic = "/images/no_userpic.jpg";
        $this->bio = $data['info'];;
        if (!isset($this->bio))
            $this->bio = "BIO";
        return array
        (
            array
            (
            'login' => $this->login,
            'fname' => $this->fname,
            'lname' =>$this->lname,
            'userpic' => $this->userpic,
            'bio' => $this->bio
            )
        );
    }
}