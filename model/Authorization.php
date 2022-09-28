<?php

class Authorization
{
    public $connect;

    public function __construct($connect)
    {
        $this->connect = $connect;
    }

    public function loginValidate(array &$fields) : array{
        $errors = [];
        return $errors;
    }

    public function checkUser($fields) : bool {

        $querry = 'SELECT * FROM users WHERE login="%s";';
        $queryString = sprintf($querry, $fields['name']);

        $result = mysqli_query($this->connect, $queryString) or die(mysqli_error($connect));
        $customer = mysqli_fetch_assoc($result);

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
                "role" => $customer['role']
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

    public function setUser($fields) : bool {
        $querry = "INSERT into users VALUES (null, '%s', '%s', '%s', '0', '0');";
        $queryString = sprintf($querry, $fields['email'], $fields['name'], $fields['password']);
        $result = mysqli_query($this->connect, $queryString) or die(mysqli_error($this->connect));
        $_SESSION['user_data'] = [
            "name" => $fields['name'],
            "email" => $fields['email'],
            "password" => $fields['password'],
            "role" => "0" //TODO change role by db
        ];
        return is_bool($result)? $result : false;
    }
}