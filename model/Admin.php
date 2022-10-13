<?php

namespace nmvcsite\model;

class Admin
{

    public $connect;
    public $pdo;

    public function __construct($connect, $pdo)
    {
        $this->connect = $connect;
        $this->pdo = $pdo;
    }

    public function getPageUsers($page, $lim = 10)
    {
        $stmt = $this->pdo->prepare("CALL getUsersPage(:page, :limit)");
        $stmt->execute(["page" => $page, "limit" => $lim]);
        while ($row = $stmt->fetch($this->pdo::FETCH_LAZY)) {

            if($row['role'] == 1) {
                $roleclass = "admin";
            } elseif ($row['role'] == 2) {
                $roleclass = "manager";
            } else {
                $roleclass = "user";
            }

            if($row["status"] == "consider") {
                $desc = "<div>". $row["sended_at"] . "</div>" .
                        "<div>\"" . $row["desc"] . "\"</div>" .
                        "<div>" .
                            "<button data-id" . $row['id'] . " data-type='up' class='up btn'>Promote</button>" .
                            "<button data-id" . $row['id'] . " data-type='declain' class='disagree btn'>Declain</button>" .
                        "</div>";
            } else {
                $desc = "none";
            }

            if($_SESSION['user_data']["name"] !== $row["login"]) {
                $delBtn = "<button data-id=" . $row['id'] . "data-type='del' class='del btn'> X </button>";
            } else {
                $delBtn = "it's you :)";
            }

            echo "<tr>" .
                    "<td>" . __('Name') . ":<pre class='" . $roleclass . "'><a href='" . BASE_URL . "user?id=" . $row["id"] . "' class='userLink'>" . $row['login'] . "</a></pre>" . "</td>" .
                    "<td>" . __('Email') . ":" . $row["email"] . "</td>" .
                    "<td>" . __('Role') . ":" . $row["role"] . "</td>" .
                    "<td>" .
                        "<button data-id='" . $row["id"] . "' data-type='up' class='up btn'>up</button>" .
                        "<button data-id='" . $row["id"] . "' data-type='down' class='down btn'>down</button>" .
                    "</td>" .
                    "<td class='decs'>" . $desc . "</td>" .
                    "<td>" . $delBtn . "</td>" .
                 "</tr>";
        }
    }

    public function  getNumPages($table): int
    {
        $querry = "SELECT count(*) as count FROM `$table`";
        $stmt = $this->pdo->prepare($querry);
        $stmt->execute();
        $customer = $stmt->fetch($this->pdo::FETCH_LAZY);

        return ceil($customer["count"] / 10);
    }

    public function updateRole($type, $id)
    {
        $type = $type === "up" ? 1 : -1;

        $stmt = $this->pdo->prepare("SELECT role FROM users WHERE id = :id");
        $stmt->execute(["id" => $id]);
        $customer = $stmt->fetch($this->pdo::FETCH_LAZY);


        if((int)$customer["role"] + $type < 0 or (int)$customer["role"] + $type > 2) {
            return [ "status" => false ];
        }

        $stmt = $this->pdo->prepare("UPDATE `users` SET role = role + :type WHERE id = :id;");
        $stmt->execute(["type" => $type,"id" => $id]);

        return [ "status" => true ];
    }

    public function delUser($type, $id)
    {
        if ($type === "del") {
            $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = :id");
            $stmt->execute(["id" => $id]);
            return [ "status" => true ];
        }
        return [ "status" => false ];

    }

    public function declainPromotion($id)
    {
        $stmt = $this->pdo->prepare("UPDATE `promotions` SET status = 'declain' WHERE id_user = ?;");
        $stmt->execute([$id]);
        return [ "status" => true ];
    }

    public function  getNumPromotionsPages()
    {
        $stmt = $this->pdo->prepare("SELECT CEIL(COUNT(*)/ 10) as count FROM `promotions`");
        $stmt->execute();

        for($i = 1; $i <= $stmt; $i++) {
            echo '<a class="pageButton" href="/promotions?p='. $i .'">' . $i . '</a>';
        }
    }

    public function getAllPromotions($page)
    {
        $stmt = $this->pdo->prepare("CALL getPromotionPage(:page)");
        $stmt->execute(["page" => $page]);

        while ($row = $stmt->fetch($this->pdo::FETCH_LAZY)) {
            echo "<tr>" .
                    "<td>" . $row["id"] . "</td>" .
                    "<td>" . $row["login"] . "</td>" .
                    "<td>" . $row["desc"] . "</td>" .
                    "<td>" . $row["sended_at"] . "</td>" .
                    "<td>" . $row["status"] . "</td>" .
                "</tr>";
        }
    }

    public function pagination($pagesCount, $url)
    {
        foreach(range(1, $pagesCount) as $number) {
            echo "<a class='pageButton " . ($_GET["p"] == $number ? "pageButtonCurrent" : "") . "' href='/" . $url . "?p=" . $number . "'>" . $number . "</a>";
        }
    }

    public function getPageOpportunity($page, $lim = 10)
    {
        $stmt = $this->pdo->prepare("CALL getUsersOpportunity(:page, :limit)");
        $stmt->execute(["page" => $page, "limit" => $lim]);
        while ($row = $stmt->fetch($this->pdo::FETCH_LAZY)) {
            if ($row["role"] === "1") {
                $role = "admin";
            } elseif ($row["role"] === "2") {
                $role = "manager";
            } else {
                $role = "user";
            }
            echo "<tr>" .
                    "<td>" . $row['id'] . "</td>" .
                    "<td><a href='" . BASE_URL . "user?id=" . $row["id"] . "' class='userLink'>" . $row['login'] . "</a>" . "</td>" .
                    "<td>" . $row["email"] . "</td>" .
                    "<td>" . $role . "</td>" .
                    "<td class='" . ($row["delUser"] ? "opporTrue" : "opporFalse") . "'>" .
                        ($row["delUser"] ? "+" : "-") .
                    "</td>" .
                    "<td class='" . ($row["promoteUser"] ? "opporTrue" : "opporFalse") . "'>" .
                        ($row["promoteUser"] ? "+" : "-") .
                    "</td>" .
                    "<td class='" . ($row["declineUser"] ? "opporTrue" : "opporFalse") . "'>" .
                        ($row["declineUser"] ? "+" : "-") .
                    "</td>" .
                    "<td class='" . ($row["delUsersMessages"] ? "opporTrue" : "opporFalse") . "'>" .
                        ($row["delUsersMessages"] ? "+" : "-") .
                    "</td>" .
                    "<td class='" . ($row["passToLogData"] ? "opporTrue" : "opporFalse") . "'>" .
                        ($row["passToLogData"] ? "+" : "-") .
                    "</td>" .
                    "<td class='" . ($row["promoteUser"] ? "opporTrue" : "opporFalse") . "'>" .
                        ($row["promoteUser"] ? "+" : "-") .
                    "</td>" .
                    "<td class='" . ($row["delOtherAdmins"] ? "opporTrue" : "opporFalse") . "'>" .
                        ($row["delOtherAdmins"] ? "+" : "-") .
                    "</td>" .
                    "<td class='" . ($row["delOtherManagers"] ? "opporTrue" : "opporFalse") . "'>" .
                        ($row["delOtherManagers"] ? "+" : "-") .
                    "</td>" .
                    "<td class='" . ($row["addComments"] ? "opporTrue" : "opporFalse") . "'>" .
                        ($row["addComments"] ? "+" : "-") .
                    "</td>" .
                    "<td class='" . ($row["loginingToPage"] ? "opporTrue" : "opporFalse") . "'>" .
                        ($row["loginingToPage"] ? "+" : "-") .
                    "</td>" .
                    "<td>" .
                        "<input type='checkbox' name='user' value='" . $row['id'] . "'>" .
                    "</td>" .
                "</tr>";
        }
    }

    public function ifExistId($id) {
//        TODO CREATE FUNCTION FOR CHECK id
    }

    public function testXML()
    {
        $xml = simplexml_load_file("./assets/settings/user.xml");

        foreach ($xml->opporrtunity->user->action as $row) {
            echo "<p>";
            echo $row["type"] . " : " . $row;
            echo "</p>";
        }
    }
}