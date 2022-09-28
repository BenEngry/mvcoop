<?php
function registerValidate(array &$fields) : array{
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

function setUser($connect, $fields) : bool {
    $querry = "INSERT into users VALUES (null, '%s', '%s', '%s', '0');";
    $queryString = sprintf($querry, $fields['email'], $fields['name'], $fields['password']);
    $result = mysqli_query($connect, $queryString) or die(mysqli_error($connect));
    $_SESSION['user_data'] = [
        "name" => $fields['name'],
        "email" => $fields['email'],
        "password" => $fields['password'],
        "role" => "0" //change role by db
    ];
    return is_bool($result)? $result : false;
}