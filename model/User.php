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

    public function getPromotion($id, $desc)
    {

//        TODO create switcher for type in profile for get promotion
//        TODO create promote function and change user table, u have other table;

        return [ "status" => false ];
    }

}