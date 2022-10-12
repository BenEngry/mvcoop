<?php

class Authorization
{
    public $connect;
    public $pdo;

    public function __construct($connect, $pdo)
    {
        $this->connect = $connect;
        $this->pdo = $pdo;
    }

    public function loginValidate(array &$fields) : array{
        $errors = [];
        return $errors;
    }

    public function checkUser($fields) : bool {
        $stmt = $this->pdo->prepare("SELECT * FROM `users` WHERE login = :log");
        $stmt->execute(["log" => $fields['name']]);
        $customer = $stmt->fetch($this->pdo::FETCH_LAZY);

        if (!$customer) {
            $_SESSION["log"] = "undefinded data";
            return false;
        } elseif (
            $fields['email'] == $customer['email'] and
            $fields['password'] == $customer['password']
        ) {
            $_SESSION["log"] = "logined";
            $_SESSION['user_data'] = [
                "name" => $fields['name'],
                "email" => $fields['email'],
                "role" => $customer['role'],
                "id" => $customer['id']
            ];
            return true;
        } else {
            $_SESSION["log"] = "lod data invalid";
            return false;
        }
    }

    public function registerValidate(array &$fields) : array{
        $errors = [];
        return $errors;
    }

    public function ifExistUser($login) {
        $stmt = $this->pdo->prepare("SELECT `id` FROM `users` WHERE login = :log");
        $stmt->execute(["log" => $login]);
        $customer = $stmt->fetch($this->pdo::FETCH_LAZY);

        if ($customer["id"]) {
            return $customer["id"];
        }
        return false;
    }

    public function testXML()
    {
        $xml = simplexml_load_file("./assets/settings/user.xml");

//        foreach ($xml->opporrtunity->admin as $row) {
//            echo "<p>";
//            echo $row;
//            echo "</p>";
//        }
        var_dump($xml->opporrtunity->admin);
    }

    public function setUser($fields)  {

//          creating row for users table and
//          create new row for opportunity table with the same id
        $stmtUsers = $this->pdo->prepare("INSERT into users VALUES (null, :email, :login, :password, :role, :promotion)");
        $stmtUsers->execute([
            "email" => $fields['email'],
            "login" => $fields['name'],
            "password" => $fields['password'],
            "role" => 0,
            "promotion" => 0,
        ]);

        $stmtOpportunity = $this->pdo->prepare("INSERT INTO `opportunity` (idUser) VALUES (:id)");
        $stmtOpportunity->execute(["id" => $this->ifExistUser($fields["name"])]);

        $_SESSION['user_data'] = [
            "name" => $fields['name'],
            "email" => $fields['email'],
            "role" => "0" //TODO change role by db

        ];
        return ["status" => true];
    }
}