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

    public function getUserXML($role = "admin")
    {
        $xml = simplexml_load_file("./assets/settings/user.xml");
//        $role = (string)$xml->init; ??? not working...
        $actions = [];
        foreach ($xml->setUser->{$role}->data as $row) {
            $attr = $row["type"];
            $actions["$attr"] = $row;
        }
        foreach ($xml->opporrtunity->{$role}->action as $row) {
            $attr = $row["type"];
            $actions["$attr"] = $row;
        }
        return $actions;
    }

    public function setUser($fields)  {
//          creating row for users table and
//          create new row for opportunity table with the same id
        $actions = $this->getUserXML();

        $stmtUsers = $this->pdo->prepare("INSERT into users VALUES (null, :email, :login, :password, :role, :promotion)");
        $stmtUsers->execute([
            "email" => $fields['email'],
            "login" => $fields['name'],
            "password" => $fields['password'],
            "role" => $actions["role"],
            "promotion" => $actions["promotion"]
        ]);

        $stmtOpportunity = $this->pdo->prepare("INSERT INTO `opportunity` (idUser, delUser, promoteUser, declineUser, passToLogData, delUsersMessages, reductionUsersMessages, delOtherAdmins, delOtherManagers, addComments, loginingToPage) VALUES (:id, :delUser, :promoteUser, :declineUser, :passToLogData, :delUsersMessages, :reductionUsersMessages, :delOtherAdmins, :delOtherManagers, :addComments, :loginingToPage)");
        $stmtOpportunity->execute([
            "id" => $this->ifExistUser($fields["name"]),
            "delUser" => $actions["delUser"],
            "promoteUser" => $actions["promoteUser"],
            "declineUser" => $actions["declineUser"],
            "passToLogData" => $actions["passToLogData"],
            "delUsersMessages" => $actions["delUsersMessages"],
            "reductionUsersMessages" => $actions["reductionUsersMessages"],
            "delOtherAdmins" => $actions["delOtherAdmins"],
            "delOtherManagers" => $actions["delOtherManagers"],
            "addComments" => $actions["addComments"],
            "loginingToPage" => $actions["loginingToPage"]
        ]);

        $_SESSION['user_data'] = [
            "name" => $fields['name'],
            "email" => $fields['email'],
            "role" => (string)$actions["role"]

        ];
        return ["status" => true];
    }
}