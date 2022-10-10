<?php

require_once ("./model/Admin.php");
require_once "./model/User.php";
use nmvcsite\model\Admin;
use nmvcsite\model\User;

$title = __('Profile');

$fieldsNotCleaned = $_POST;
$neededFieldsArray = ['id', 'type', 'login', 'repeatpassword', 'newpassword', 'enteredpassword', 'desc'];

/** extract */
$fields = extractFields($_POST, $neededFieldsArray);
/**  validate */

$admin = new Admin($connect, $pdo);
$user = new User($connect, $pdo);

if (isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && "XMLHttpRequest" === $_SERVER["HTTP_X_REQUESTED_WITH"]) {
    header("Content-type: application/json");
    if ($fields["type"] === "del") {
        echo json_encode($admin->delUser($fields["type"], $fields["id"]));
    }
    if ($fields["type"] === "up" or $fields["type"] === "down") {
        echo json_encode($admin->updateRole($fields["type"], $fields["id"]));
    }
    if ($fields["type"] === "declain") {
        echo json_encode($admin->declainPromotion($fields["id"]));
    }
    if ($fields["type"] === "password" or $fields["type"] === "email") {
        echo json_encode($user->changeUserData($fields["type"], $fields["login"], $fields["enteredpassword"], $fields["newpassword"]));
    }
    if ($fields["type"] === "promotion") {
        echo json_encode($user->getPromotion($_SESSION['user_data']["id"], $fields["desc"]));
    }
    exit;
}

include('view/base/v_header.php');
include('view/base/v_content.php');
include('view/profile/v_profile.php');
include('view/base/v_footer.php');