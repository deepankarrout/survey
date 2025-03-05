<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
// used to get mysql database connection
class Database{
    // specify your own database credentials
    // private $host = 'localhost';
    // private $db_name = 'malayabg_survey';
    // private $username = 'malayabg_surveyu';
    // private $password = "VYkb8XEd3g6w";

    private $host = 'localhost';
    private $db_name = 'survey';
    private $username = 'root';
    private $password = "";
    public $conn;
    // get the database connection
    public function getConnection(){
        $this->conn = null;
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>