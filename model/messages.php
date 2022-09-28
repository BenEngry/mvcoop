<?php
declare(strict_types=1);
/**
 * @by ProfStep, inc. 23.12.2020
 * @website: https://profstep.com
 **/


function getMessages($connect) : array {
    $queryString = "SELECT * FROM messages WHERE 1";
    $result_arr = mysqli_fetch_all(mysqli_query($connect, $queryString),MYSQLI_ASSOC);
    return $result_arr ?? [];
}

function getMessage($connect, $id) : array {
    $queryString = sprintf("SELECT * FROM messages WHERE id = %s", $id);
    $result_arr = mysqli_fetch_accos(mysqli_query($connect, $queryString));
    return $result_arr ?? [];
}

function setMessage($connect, $fields) : bool {
    $queryString = sprintf("INSERT into messages VALUES (null, '%s', '%s', '%s', now(), '0')", $fields['name'], $fields['title'], $fields['message']);
    $result = mysqli_query($connect, $queryString) or die(mysqli_error($connect));
    return is_bool($result)? $result : false;
}

function messagesValidate(array &$fields) : array{
    $errors = [];
    $nameLen = mb_strlen($fields['name'], 'UTF-8');
    $titleLen = mb_strlen($fields['title'], 'UTF-8');

    // if(mb_strlen($fields['message'], 'UTF-8') < 2){
    //     $errors[] = __('Message length must be not less then 2 characters!');
    // }

    // if($nameLen < 2 || $nameLen > 140){
    //     $errors[] = __('Name must be from 2 to 140 chars!');
    // }
    // if($titleLen < 10 || $titleLen > 140){
    //     $errors[] = __('Title must be from 10 to 140 chars!');
    // }

    $fields['name'] = htmlspecialchars($fields['name']);
    $fields['title'] = htmlspecialchars($fields['title']);
    $fields['message'] = htmlspecialchars($fields['message']);
    $fields['id'] = htmlspecialchars($fields['id']);

    return $errors;
}

function changeMessage($connect, $fields) : bool {
    $sql = "UPDATE messages SET name = '%s', title = '%s', message = '%s'  WHERE id = '%s';";
    $queryString = sprintf($sql, $fields['name'], $fields['title'], $fields['message'], $fields['id']);
    $result = mysqli_query($connect, $queryString) or die(mysqli_error($connect));
    return is_bool($result)? $result : false;
}