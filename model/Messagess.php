<?php

class Messagess {

    public $pdo;
    public $connect;

    public function __construct($connect, $pdo)
    {
        $this->pdo = $pdo;
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

    public function loadMessages()
    {
        $stmt = $this->pdo->prepare("");
        $stmt->execute();
        $customer = $stmt->fetch($this->pdo::FETCH_LAZY);

        return <<<HERE
                <li data-id="{$customer['id']}">
                    <label><strong> __('User Name') :</strong></label><em> {$customer['name']} </em><br>
                    <label><strong> __('Title') :</strong></label><em> {$customer['title']} </em><br>
                    <label><strong> __('Message') :</strong></label><em> {$customer['message']} </em><br>
                    <label><strong> __('Created At') :</strong></label><em> {$customer['created_at']} </em><br>
                    <?php if (isset({$_SESSION['user_data']}) and {$_SESSION['user_data']}['role'] == "1"):
                    <input type="submit" id="admin" value= {$customer['id']} >Edit A</input>
                    <?php elseif (isset({$_SESSION['user_data']}) and {$_SESSION['user_data']}['role'] == "2"):
                    <input type="submit" id="manager" value= {$customer['id']} >Edit M</input>
                    <?php endif
                    <hr>
                    <?php endforeach;
                </li>
                HERE;

    }

}
