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
        $status = $this->checkForPromotion($id);

        if ($status) {
            return ["status" => false];
        }

        $stmt = $this->pdo->prepare("INSERT INTO `promotions` (`id_user`, `desc`, `status`) VALUES(:id, :desc, :status)");
        $stmt->execute(["id" => $id, "desc" => str_replace("'", "_", $desc), "status" => "consider"]);

        return ["status" => true];
    }

    //TODO create check id func, but in USER.php
    //TODO create check hidden account, but in USER.php

    public function loadActions($id)
    {
        $stmt = $this->pdo->prepare("SELECT idUser, delUser, promoteUser, declineUser, passToLogData, delUsersMessages, reductionUsersMessages, delOtherAdmins, delOtherManagers, addComments, loginingToPage FROM `opportunity` WHERE idUser = :id");
        $stmt->execute(["id" => 34]);
        $customer = $stmt->fetch($this->pdo::FETCH_LAZY);
        return <<<HERE
            <div class="act">Actions</div>
            <div>Del user: {$customer["delUser"]}</div>
            <div>Promote user: {$customer["promoteUser"]}</div>
            <div>Decline user: {$customer["declineUser"]}</div>
            <div>Pass to logData: {$customer["passToLogData"]}</div>
            <div>Del users messages: {$customer["delUsersMessages"]}</div>
            <div>Reduction users messages: {$customer["reductionUsersMessages"]}</div>
            <div>Del other admins: {$customer["delOtherAdmins"]}</div>
            <div>Del other managers: {$customer["delOtherManagers"]}</div>
            <div>Add comments: {$customer["addComments"]}</div>
            <div>Logining to page: {$customer["loginingToPage"]}</div>
            HERE;

    }

    public function loadUserPage($id)
    {
        $stmt = $this->pdo->prepare("SELECT `id`, `login`, `email`, `role` FROM `users` WHERE id = :id");
        $stmt->execute(["id" => $id]);
        $customer = $stmt->fetch($this->pdo::FETCH_LAZY);
        if($customer["login"] === 1) {
            $role = "admin";
        } elseif ($customer["login"] === 2) {
            $role = "manager";
        } else {
            $role = "user";
        }
        $viewRole = $_SESSION["user_data"]["role"];
        return <<<HERE
            <div class="profile">
                <div class="userInfo">
                    <h1> $role : {$customer["login"]}</h1>
                    <div>email : {$customer["email"]}</div>
                </div>
                <div class="actions">
                    {$this->loadActions($id)}
                </div>
            </div>
            HERE;

    }
}