<?php
function loginValidate(array &$fields) : array{
    $errors = [];
    $nameLen = mb_strlen($fields['name'], 'UTF-8');
    $passLen = mb_strlen($fields['email'], 'UTF-8');
    $emailLen = mb_strlen($fields['password'], 'UTF-8');

    // if($nameLen < 8 || $nameLen > 40){
    //     $errors[] = __('Name must be from 2 to 140 chars!');
    // }

    // if($passLen < 8 || $passLen > 40){
    //     $errors[] = __('Password must be from 2 to 140 chars!');
    // }

    // if($emailLen < 8 || $emailLen > 40){
    //     $errors[] = __('Email must be from 2 to 140 chars!');
    // }

    $fields['name'] = htmlspecialchars($fields['name']);
    $fields['email'] = htmlspecialchars($fields['email']);
    $fields['password'] = htmlspecialchars($fields['password']);

    return $errors;
}

function getLogins($connect, $fields) : bool {
    $querryStringLogin = "SELECT * FROM users;";
    $result = mysqli_query($connect, $querryStringLogin) or die(mysqli_error($connect));
    return is_bool($result)? $result : false;
}

function checkUser($connect, $fields) : bool {

    $querry = 'SELECT * FROM users WHERE login="%s";';
    $queryString = sprintf($querry, $fields['name']);

    $result = mysqli_query($connect, $queryString) or die(mysqli_error($connect));
    $customer = mysqli_fetch_assoc($result);

    if (!$customer) {
        $_SESSION["log"] = "undefinded data";
        return false;
    } elseif ( 
        $fields['email'] == $customer['email'] and 
        $fields['password'] == $customer['password']
    ) {
        $_SESSION["log"] = "logined";
        $_SESSION['user_data'] = [
            "name" => $fields['name'],
            "email" => $fields['email'],
            "role" => 1 ,
        ];
        return true;
    } else {
        $_SESSION["log"] = "lod data invalid";
        return false;
    }
}
