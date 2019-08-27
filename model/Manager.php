<?php
namespace Gaetan\P5_2\Model;
class Manager
{
    private $_db;

    public function __construct()
    {
        $this->setDb();
    }

    protected function db()
    {
        return $this->_db;
    }

    public function setDb()
    {
        $db = new \PDO('mysql:host=localhost;dbname=projet_5_2;charset=utf8', 'root', '');
        $this->_db = $db;
    }
}
