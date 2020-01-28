<?php
class connectBD
{
    private $DB_DSN = 'mysql:host=192.168.99.101;port=3307;dbname=cam_users;';
    private $DB_USER = "root";
    private $DB_PASSWORD = "root";
    private $opt = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ];

    public $DBH;
    public $res;

    public function connect()
    {
        $this->DBH = new PDO($this->DB_DSN, $this->DB_USER, $this->DB_PASSWORD, $this->opt);
    }

    public function closeConnect()
    {
        $this->DBH = null;
    }

}
