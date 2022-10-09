<?php

$connect = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE_NAME) or die('Mysql connection error: '.mysqli_error());

$dsnString = "mysql:host=%s;dbname=%s;";
$dsn = sprintf($dsnString, DB_HOST, DB_DATABASE_NAME);
$pdo = new PDO($dsn, DB_USER, DB_PASS, DB_OPTIONS);


//class DB
//{
//    private static $db;
//    private $host;
//    private $dbname;
//    private $charset;
//    private $username;
//    private $password;
//    private $dsn;
//    private $opt;
//
//    private function __construct($host, $dbname, $charset, $username, $password, $opt) {
//        $this->host = $host;
//        $this->dbname = $dbname;
//        $this->charset = $charset;
//        $this->username = $username;
//        $this->password = $password;
//        $this->opt = $opt;
//        $this->dsn = "mysql:host=" . $this->host . ";dbname=" . $this->dbname . ";charset=" . $this->charset . ";";
//        return new PDO($this->dsn, $this->username, $this->password, $this->opt);
//    }
//
//    static public function connect()
//    {
//        if (self::$db === Null) {
//            self::$db = new self();
//        }
//        return self::$db;
//    }
//}
//
//$db = DB::connect();


