<?php

class Messagess {

    public $connect;

    public function __construct($connect)
    {
        $this->connect = $connect;
    }

    public function messagesValidate(array &$fields)
    {
        $errors = [];
        return $errors;
    }

    public function setMessage($fields) : bool {
        $queryString = sprintf("INSERT into messages VALUES (null, '%s', '%s', '%s', now(), '0')", $fields['name'], $fields['title'], $fields['message']);
        $result = mysqli_query($this->connect, $queryString) or die(mysqli_error($this->connect));
        return is_bool($result)? $result : false;
    }

    public function changeMessage($fields) : bool {
        $sql = "UPDATE messages SET name = '%s', title = '%s', message = '%s'  WHERE id = '%s';";
        $queryString = sprintf($sql, $fields['name'], $fields['title'], $fields['message'], $fields['id']);
        $result = mysqli_query($this->connect, $queryString) or die(mysqli_error($this->connect));
        return is_bool($result)? $result : false;
    }

    public function getMessage($id) : array {
        $queryString = sprintf("SELECT * FROM messages WHERE id = %s", $id);
        $result_arr = mysqli_fetch_accos(mysqli_query($this->connect, $queryString));
        return $result_arr ?? [];
    }

    public function getMessages() : array {
        $queryString = "SELECT * FROM messages WHERE 1";
        $result_arr = mysqli_fetch_all(mysqli_query($this->connect, $queryString),MYSQLI_ASSOC);
        return $result_arr ?? [];
    }

}
