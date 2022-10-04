<?php

namespace nmvcsite\model;

class Admin
{

    public $connect;

    public function __construct($connect)
    {
        $this->connect = $connect;
    }

    public function getAllUsers(): array
    {
        $queryString = 'SELECT * FROM users';

        $result = mysqli_query($this->connect, $queryString) or die(mysqli_error($connect));
        $customer = mysqli_fetch_all($result);

        return $customer;
    }

    public function getPageUsers($page): array
    {
        $offset = 10 * $page - 10;
//        SELECT `id`, `login`, `email`, `role`, `desc`, `sended_at`, `status` FROM `users` u LEFT JOIN `promotions` p ON u.id = p.id_user LIMIT 10 OFFSET 10;
        $queryString = 'SELECT `id`, `login`, `email`, `role`, `desc`, `sended_at`, `status` FROM `users` u LEFT JOIN `promotions` p ON u.id = p.id_user LIMIT 10 OFFSET ' . $offset . ';';   // offset limit
        $result = mysqli_query($this->connect, $queryString) or die(mysqli_error($connect));
        $customer = mysqli_fetch_all($result);

        return $customer;
    }

    public function  getNumPages(): int
    {
        $queryString = "SELECT count(*) as count FROM users";

        $result = mysqli_query($this->connect, $queryString) or die(mysqli_error($connect));
        $customer = mysqli_fetch_assoc($result);
        $pages = ceil($customer["count"] / 10);
        return $pages;
    }

    public function updateRole($type, $id)
    {
        $type = $type === "up" ? 1 : -1;
        $queryString = "SELECT role FROM users WHERE id = $id;";
        $result = mysqli_query($this->connect, $queryString) or die(mysqli_error($connect));
        $customer = mysqli_fetch_assoc($result);

        if((int)$customer["role"] + $type < 0 or (int)$customer["role"] + $type > 2) {
            return [ "status" => false ];
        }

        $queryString = "UPDATE `users` SET role = role + $type WHERE id = $id;";
        mysqli_query($this->connect, $queryString) or die(mysqli_error($connect));
        return [ "status" => true ];
    }

    public function delUser($type, $id)
    {
        if ($type === "del") {
            $queryString = "DELETE FROM users WHERE id = $id;";
            mysqli_query($this->connect, $queryString) or die(mysqli_error($connect));
            return [ "status" => true ];
        }
        return [ "status" => false ];

    }

    public function declainPromotion($id)
    {
        $query = "UPDATE `promotions` SET status = 'declain' WHERE id_user = '%s';";
        $queryString = sprintf($query, $id);
        mysqli_query($this->connect, $queryString) or die(mysqli_error($this->connect));
        return [ "status" => true ];
    }

    public function getAllPromotions()
    {
        $query = "SELECT `login`, `desc`, `sended_at`, `status` FROM `users` u JOIN `promotions` p ON u.id = p.id_user;";
        $result = mysqli_query($this->connect, $query) or die(mysqli_error($this->connect));
        $list = '';

        while ($data = mysqli_fetch_assoc($result)) {
            echo "<tr><td>" . $data["login"] . "</td>" . "<td>" . $data["desc"] . "</td>" . "<td>" . $data["sended_at"] . "<td>" . $data["status"] . "</td></tr>";
        }

        echo json_encode($list);
    }
}