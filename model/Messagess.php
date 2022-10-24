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
        $queryString = sprintf("INSERT into messages VALUES (null, '%s', '%s', '%s', now(), '0', '%s')", $_SESSION['user_data']['name'], $fields['title'], $fields['message'], $_SESSION["user_data"]["id"]);
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

    public function delMessage($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM `messsages` WHERE id = :id");
        $stmt->execute(["id" => $id]);
        return ["status" => true];
    }

    public function loadMessages($page)
    {
        $stmt = $this->pdo->prepare("CALL getMessagesPage(:page)");
        $stmt->execute(["page" => $page]);

        $messages = "";


        while ($row = $stmt->fetch($this->pdo::FETCH_LAZY)) {
            $btns = "";

            if($_SESSION["user_data"]["opportunity"]["delUsersMessages"] == 1) {
                $btns = <<<HERE
                        <div>
                            <hr>
                            <button type="submit" data-type="edit" data-id="{$row['id']}" class="up edit btn" >Edit</button>
                            <button type="submit" data-type="del" data-id="{$row['id']}" class="del btn" >Delete</button>
                        </div>
                    HERE;

            }
            $messages .= <<<HERE
                    <li class="mesWrapper" data-li="{$row["id"]}">
                        <div class="infRow">
                            <div>
                                <h4 data-title="{$row["id"]}>{$row["title"]}</h4>
                                <span data-name="{$row["login"]}">
                                    by <a data-user="{$row["idUser"]}" href='/user?id={$row["idUser"]}' class='userLink'>"{$row["name"]}"</a>
                                </span>
                            </div>
                            <p>{$row["created_at"]}</p>
                        </div>
                        <hr>
                        <div data-message="{$row["id"]}">
                            {$row["message"]}
                        </div>
                        $btns
                    </li>
                    HERE;
        }
        return $messages;
    }

    public function loadCurrentMessages($id, $page)
    {
        $stmt = $this->pdo->prepare("CALL getCurrentMessagesPage(:id, :page)");
        $stmt->execute(["id" => $id, "page" => $page]);

        $messages = "";

        while ($row = $stmt->fetch($this->pdo::FETCH_LAZY)) {
            $btns = "";

            if($_SESSION["user_data"]["opportunity"]["delUsersMessages"] == 1) {
                $btns = <<<HERE
                        <div>
                            <hr>
                            <button type="submit" data-type="" data-id="{$row['id']}" class="up btn" >Edit</button>
                            <button type="submit" data-type="del" data-id="{$row['id']}" class="del btn" >Delete</button>
                        </div>
                    HERE;

            }
            $messages .= <<<HERE
                    <li class="mesWrapper" data-id="{$row["id"]}">
                        <div class="infRow">
                            <div>
                                <h4>{$row["title"]}</h4>
                                <span data-name="{$row["login"]}">
                                    by <a href='/user?id={$row["idUser"]}' class='userLink'>"{$row["name"]}"</a>
                                </span>
                            </div>
                            <p>{$row["created_at"]}</p>
                        </div>
                        <hr>
                        <div>
                            {$row["message"]}
                        </div>
                        $btns
                    </li>
                    HERE;

        }
        return $messages;
    }

}
