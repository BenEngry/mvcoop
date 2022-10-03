<?php

namespace nmvcsite\model;

class User
{
    public $connect;

    public function __construct($connect)
    {
        $this->connect = $connect;
    }

    public function checkPassword($login, $enteredPassword)
    {
        $query = "SELECT password FROM users WHERE login = '%s';";
        $queryString = sprintf($query, $login);
        $result = mysqli_query($this->connect, $queryString) or die(mysqli_error($connect));
        $customer = mysqli_fetch_assoc($result);

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
                    $query = "UPDATE `users` SET `password`= '%s' WHERE `login` = '%s';";
                    break;
                case "email":
                    $query = "UPDATE `users` SET `email`= '%s' WHERE `login` = '%s';";
                    break;
            }
            $queryString = sprintf($query, $newData, $login);
            mysqli_query($this->connect, $queryString) or die(mysqli_error($connect));
            return ["status" => true];
        }
        return ["status" => false];
    }

    public function checkForPromotion($id)
    {
        $query = "SELECT `status` FROM `promotions` WHERE `id_user` = '%s';";
        $queryString = sprintf($query, $id);
        $result = mysqli_query($this->connect, $queryString) or die(mysqli_error($this->connect));
        $customer = mysqli_fetch_assoc($result);

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

        $Validedesc = str_replace("'", "_", $desc);
        $query = "INSERT INTO `promotions` (`id_user`, `desc`, `status`) VALUES('%s', '%s', 'consider');";
        $queryString = sprintf($query, $id, $Validedesc);
        mysqli_query($this->connect, $queryString) or die(mysqli_error($this->connect));

        return ["status" => true];
    }

}