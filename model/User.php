<?php

namespace nmvcsite\model;

class User
{
    public $connect;
    public $pdo;

    public function __construct($connect, $pdo)
    {
        $this->connect = $connect;
        $this->pdo = $pdo;
    }

    public function checkPassword($login, $enteredPassword)
    {
        $stmt = $this->pdo->prepare("SELECT password FROM users WHERE login = :login");
        $stmt->execute(["login" => $login]);
        $customer = $stmt->fetch($this->pdo::FETCH_LAZY);

        if ($customer["password"] === $enteredPassword) {
            return true;
        }
        
        return false;
    }

    public function changeUserData($type, $login, $enteredPassword, $newData)
    {
        if ($this->checkPassword($login, $enteredPassword)) {
            $query = "";
            switch ($type) {
                case "password":
                    $query = "UPDATE `users` SET `password`= :newData WHERE `login` = :login";
                    break;
                case "email":
                    $query = "UPDATE `users` SET `email`= :newData WHERE `login` = :login";
                    break;
            }
            $stmt = $this->pdo->prepare($query);
            $stmt->execute(["login" => $login, "newData" => $newData]);

            return ["status" => true];
        }
        return ["status" => false];
    }

    public function checkForPromotion($id)
    {

        $stmt = $this->pdo->prepare("SELECT `status` FROM `promotions` WHERE `id_user` = :id");
        $stmt->execute(["id" => $id]);
        $customer = $stmt->fetch($this->pdo::FETCH_LAZY);

        if ($customer["status"] == "consider") {
            return true;
        }

        return false;
    }

    public function getPromotion($id, $desc)
    {
        $status = $this->checkForPromotion($id);

        if ($status) {
            return ["status" => false];
        }

        $stmt = $this->pdo->prepare("INSERT INTO `promotions` (`id_user`, `desc`, `status`) VALUES(':id', ':desc', ':status')");
        $stmt->execute(["id" => $id, "desc" => str_replace("'", "_", $desc), "status" => "consider"]);

        return ["status" => true];
    }

}