<?php

class Authorization
{
    public $connect;
    public $pdo;

    public function __construct($connect, $pdo)
    {
        $this->connect = $connect;
        $this->pdo = $pdo;
    }

    public function loginValidate(array &$fields) : array{
        $errors = [];
        return $errors;
    }

    private function setEnterLog($id) {
        $stmt = $this->pdo->prepare("INSERT INTO `logs` (`idUser`, `date`, `entered`, `sEntered`, `month` , `year`, `day`) VALUES(:id, CURRENT_DATE, CURRENT_TIME, :sEntered, :month, :year, :day)");
        $stmt->execute(["id" => $id, "sEntered" => time(), "day" => date("d"), "month" => date("m"), "year" => date("y")]);
    }

    private function setExitLog($id) {
        $stmt = $this->pdo->prepare("UPDATE `logs` SET `exit` = CURRENT_TIME, `sExit` = :sExit WHERE idUser = :id AND entered = :entered");
        $stmt->execute(["id" => $id, "entered" => $_SESSION['user_data']['start'], "sExit" => time()]);
    }

    public function destroySession() {
        $this->setExitLog($_SESSION['user_data']['id']);
        unset($_SESSION['is_user_logined']);
        unset($_SESSION['user_data']);
        unset($_SESSION["log"]);
        return ["status" => true];
    }
//  pizda crinje, login in check user function,
    public function checkUser($fields) : bool {
        $stmt = $this->pdo->prepare("SELECT * FROM `users` WHERE login = :log");
        $stmt->execute(["log" => $fields['name']]);
        $customer = $stmt->fetch($this->pdo::FETCH_LAZY);

        $stmtOppor = $this->pdo->prepare("SELECT * FROM `opportunity` WHERE idUser = :id");
        $stmtOppor->execute(["id" => $customer["id"]]);
        $actions = $stmtOppor->fetchAll();

        if (!$customer) {
            $_SESSION["log"] = "undefinded data";
            return false;
        } elseif (
            $fields['email'] == $customer['email'] and
            password_verify($fields['password'], $customer['password'])
        ) {
            $_SESSION["log"] = "logined";
            $_SESSION['user_data'] = [
                "name" => $fields['name'],
                "email" => $fields['email'],
                "role" => $customer['role'],
                "id" => $customer['id'],
                "opportunity" => $actions[0],
                "start" => date("G:i:s")
            ];

            $this->setEnterLog($customer["id"]);

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

    public function ifExistUser($login) {
        $stmt = $this->pdo->prepare("SELECT `id` FROM `users` WHERE login = :log");
        $stmt->execute(["log" => $login]);
        $customer = $stmt->fetch($this->pdo::FETCH_LAZY);

        if ($customer["id"]) {
            return $customer["id"];
        }
        return false;
    }

    public function getUserXML($role = "user")
    {
        $xml = simplexml_load_file("./assets/settings/user.xml");
//        $role = (string)$xml->init; ??? not working...
        $actions = [];
        foreach ($xml->setUser->{$role}->data as $row) {
            $attr = $row["type"];
            $actions["$attr"] = $row;
        }
        foreach ($xml->opporrtunity->{$role}->action as $row) {
            $attr = $row["type"];
            $actions["$attr"] = $row;
        }
        return $actions;
    }

    public function setUser($fields)  {
//          creating row for users table and
//          create new row for opportunity table with the same id
        $actions = $this->getUserXML();

        $stmtUsers = $this->pdo->prepare("INSERT INTO users (`id`, `email`, `login`, `password`, `role`, `promotion`) VALUES (null, :email, :login, :password, :role, :promotion)");
        $stmtUsers->execute([
            "email" => htmlspecialchars($fields['email']),
            "login" => htmlspecialchars($fields['name']),
            "password" => password_hash(htmlspecialchars($fields['password']), PASSWORD_BCRYPT),
            "role" => (integer)$actions["role"],
            "promotion" => (integer)$actions["promotion"]
        ]);

        $id = $this->ifExistUser($fields["name"]);

        $stmtOpportunity = $this->pdo->prepare("INSERT INTO `opportunity` (idUser, delUser, promoteUser, declineUser, passToLogData, delUsersMessages, reductionUsersMessages, delOtherAdmins, delOtherManagers, addComments, loginingToPage) VALUES (:id, :delUser, :promoteUser, :declineUser, :passToLogData, :delUsersMessages, :reductionUsersMessages, :delOtherAdmins, :delOtherManagers, :addComments, :loginingToPage)");
        $stmtOpportunity->execute([
            "id" => $id,
            "delUser" => $actions["delUser"],
            "promoteUser" => $actions["promoteUser"],
            "declineUser" => $actions["declineUser"],
            "passToLogData" => $actions["passToLogData"],
            "delUsersMessages" => $actions["delUsersMessages"],
            "reductionUsersMessages" => $actions["reductionUsersMessages"],
            "delOtherAdmins" => $actions["delOtherAdmins"],
            "delOtherManagers" => $actions["delOtherManagers"],
            "addComments" => $actions["addComments"],
            "loginingToPage" => $actions["loginingToPage"]
        ]);

        $_SESSION['user_data'] = [
            "id" => $id,
            "name" => $fields['name'],
            "email" => $fields['email'],
            "role" => (string)$actions["role"],
            "opportunity" => array_slice($actions, 2) // ХЗ ЧИ ПРАЦЮЄ ЯК МАЄ БУТИ
        ];
        return ["status" => true];
    }
}