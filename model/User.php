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

    public function changeUserPassword($login, $enteredPassword, $newPassword)
    {
        echo $this->checkPassword($login, $enteredPassword);
        if ($this->checkPassword($login, $enteredPassword)) {
            $query = "UPDATE `users` SET `password`= '%s' WHERE `login` = '%s';";
            $queryString = sprintf($query, $newPassword, $login);
            mysqli_query($this->connect, $queryString) or die(mysqli_error($connect));
            return ["status" => true];
        }
        return ["status" => false];
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

    public function createChangingUserEmailString($login, $newUserDataRow)
    {
        $query = "UPDATE users SET 'email' = '%s'  WHERE login = '%s';";
        return sprintf($query, $newUserDataRow, $login);
        $_SESSION["change"] = "email";
    }

    public function changeUserDataSwitcher($type, $enteredPassword, $login, $newUserDataRow)
    {
        //TODO change mysql quaty from "mysql_query" to mysql PDO | https://www.php.net/manual/en/pdo.installation.php

        $query = "SELECT password FROM users WHERE login = '%s';";
        $queryString = sprintf($query, $login);
        $customer = mysqli_fetch_assoc(
            mysqli_query(
                $this->connect, $queryString) or die
            (mysqli_error($this->connect))
        );

        if (!$customer["password"] === $enteredPassword) {
            return ["status" => false];
        }

        switch ($type) {
            case "password":
                $this->createChangingUserPasswordString($login, $newUserDataRow);
                break;
            case "login":
                $this->createChangingUserEmailString($login, $newUserDataRow);
                break;
        }

        mysqli_query($this->connect, $queryString) or die(mysqli_error($this->connect));
        return ["status" => true];
    }

}