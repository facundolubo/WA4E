<?php
class DB extends PDO {
    #cambié el nombre a js_profiles porque me daba errores...
    private $dsn = 'mysql:host=localhost;dbname=js_profiles';
    private $username = 'fred';
    private $password = file_get_contents('/home/facundol/Documents/Computacion/mysql/mysql_dumb_passwords');
    #private $dbname = 'js_profiles';
    #private $host = 'localhost';
    private $options;
    private $conn;
    
    public function __construct()
    {
        try {
            $this->options = [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
            ];
            $this->conn = new \PDO($this->dsn, $this->username, $this->password, $this->options);
            echo "Connected successfully";
        } 
        catch (PDOException $e) {
            echo("password: " . $this->password);
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function __destruct() {
        $this->conn = null;
    }

    public function getPdo() {
        return $this->conn;
    }
}
?>