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
        if (!$this->checkId($id)) {
            header("Location: http://nmvc.site/");
            return false;
        }
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
        if (!$this->checkId($id)) {
            header("Location: http://nmvc.site/");
            return false;
        }

        $status = $this->checkForPromotion($id);

        if ($status) {
            return ["status" => false];
        }

        $stmt = $this->pdo->prepare("INSERT INTO `promotions` (`id_user`, `desc`, `status`) VALUES(:id, :desc, :status)");
        $stmt->execute(["id" => $id, "desc" => str_replace("'", "_", $desc), "status" => "consider"]);

        return ["status" => true];
    }

    public function loadActions($id)
    {
        if (!$this->checkId($id)) {
            header("Location: http://nmvc.site/");
            return false;
        }

        $stmt = $this->pdo->prepare("SELECT idUser, delUser, promoteUser, declineUser, passToLogData, delUsersMessages, reductionUsersMessages, delOtherAdmins, delOtherManagers, addComments, loginingToPage FROM `opportunity` WHERE idUser = :id");
        $stmt->execute(["id" => $id]);
        $customer = $stmt->fetch($this->pdo::FETCH_LAZY);
        return <<<HERE
            <div class="actions">
                <p class="act">Actions</p>
                <div><div>Del user :</div><div>{$customer["delUser"]}</div></div>
                <div><div>Promote user :</div><div>{$customer["promoteUser"]}</div></div>
                <div><div>Decline user :</div><div>{$customer["declineUser"]}</div></div>
                <div><div>Pass to logData :</div><div>{$customer["passToLogData"]}</div></div>
                <div><div>Del users messages :</div><div>{$customer["delUsersMessages"]}</div></div>
                <div><div>Reduction users messages :</div><div>{$customer["reductionUsersMessages"]}</div></div>
                <div><div>Del other admins :</div><div>{$customer["delOtherAdmins"]}</div></div>
                <div><div>Del other managers :</div><div>{$customer["delOtherManagers"]}</div></div>
                <div><div>Add comments :</div><div>{$customer["addComments"]}</div></div>
                <div><div>Logining to page :</div><div>{$customer["loginingToPage"]}</div></div>
            </div>
            HERE;
    }

    public function loadStat($id)
    {
//        pdo
//        execute
        return <<<HERE
                <div class="statistic">
                    
                </div>
            HERE;
    }

    public function checkId($id)
    {
        $stmt = $this->pdo->prepare("SELECT `login` FROM `users` WHERE id = :id");
        $stmt->execute(["id" => $id]);
        $customer = $stmt->fetch($this->pdo::FETCH_LAZY);
        return (bool)$customer["login"];
    }

    public function loadUserPage($id)
    {
        if (!$this->checkId($id)) {
            return false;
        }
        $stmt = $this->pdo->prepare("SELECT `id`, `login`, `email`, `role` FROM `users` WHERE id = :id");
        $stmt->execute(["id" => $id]);
        $customer = $stmt->fetch($this->pdo::FETCH_LAZY);
        if($customer["role"] === "1") {
            $role = "admin";
        } elseif ($customer["role"] === "2") {
            $role = "manager";
        } else {
            $role = "user";
        }
        return <<<HERE
            <div>
                <h1> $role : {$customer["login"]}</h1>
                <div>email : {$customer["email"]}</div>
            </div>
            HERE;
    }

    public function loadInfoUser()
    {
        if($_SESSION['user_data']["role"] == 1) {
            $role = "admin";
        } elseif ($_SESSION['user_data']["role"] == 2) {
            $role = "manager";
        } else {
            $role = "user";
        }
        $name = __("Name");
        $email = __("Email");
        $rl = __("Role");
        return <<<HERE
                <div class="infoUser" data-id=" {$_SESSION['user_data']["id"]} ">
                    <p id="login" data-login="{$_SESSION['user_data']["name"]}">
                        $name : {$_SESSION['user_data']["name"]}
                    </p>
                    <p>$email : {$_SESSION['user_data']["email"]}</p>
                    <p>
                        $rl : $role
                    </p>
                </div>
                HERE;

    }
}