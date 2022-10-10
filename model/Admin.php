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
                    "<td>" . __('Name') . ":<pre class='" . $roleclass . "'>" . $row['login'] . "</pre>" . "</td>" .
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

    public function  getNumPages(): int
    {
        $stmt = $this->pdo->prepare("SELECT count(*) as count FROM users");
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

    public function testPDO() {
        $stmt = $this->pdo->prepare("SELECT * FROM `users`;");
        $stmt->execute();
        while ($row = $stmt->fetch($this->pdo::FETCH_LAZY)) {
            echo $row[0];
            echo $row[1];
            echo $row[2];
            echo $row[3];
            echo $row[4];
        }
    }
}