<?php


class DB_Config
{
    protected $host = 'localhost';
    protected $user = 'u606326170_eventmanager';
    protected $password = '#QazEdcTgbUjm@15*';
    protected $db = 'u606326170_sucdecdo';
    protected $port = '3306';
    protected $charset = 'utf8mb4';
    protected $connString;

    public $conn = null;

    public function __construct()
    {
        $this->connString = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset;port=$this->port;";

        try {
            $this->conn = new PDO($this->connString, $this->user, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage());
        }
    }

    public function __destruct()
    {
        $this->closeConnection();
    }

    protected function closeConnection()
    {
        if($this->conn != null)
        {
            $this->conn = null;
        }
    }
}