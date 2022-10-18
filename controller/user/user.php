<?php

require_once("./model/User.php");
require_once ("./model/Admin.php");

use nmvcsite\model\User;
use nmvcsite\model\Admin;

$title = __('User');

$fieldsNotCleaned = $_POST;
$neededFieldsArray = ['id', 'type'];

$viewRole = $_SESSION["user_data"]["role"];

/** extract */
$fields = extractFields($_POST, $neededFieldsArray);
/**  validate */

$user = new User($connect, $pdo);
$admin = new Admin($connect, $pdo);

$actions = "";
$stat = "";

if(isset($_GET["id"]) and strlen($_GET["id"]) > 0) {
    if ($viewRole > 0) {
        $actions = $user->loadActions($_GET["id"]);
        $stat = $user->loadStat($_GET["id"]);
        $btn = $admin->loadButtons($_GET["id"]);
    }

    $page = $user->loadUserPage($_GET["id"]);
    if (!$page) {
        header('Location: ' . HOST . BASE_URL . "user404");
        exit;
    }
}

if (isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && "XMLHttpRequest" === $_SERVER["HTTP_X_REQUESTED_WITH"]) {
    header("Content-type: application/json");
    if ($fields["type"] === "del") {
        echo json_encode($admin->delUser($fields["type"], $fields["id"]));
    }
    if ($fields["type"] === "up" or $fields["type"] === "down") {
        echo json_encode($admin->updateRole($fields["type"], $fields["id"]));
    }
    exit;
}

include('view/base/v_header.php');
include('view/base/v_content.php');
include('view/user/v_userpage.php');
include('view/base/v_pre_footer.php');
include('view/script/jquery.php');
include('view/script/user.php');
include('view/base/v_after_footer.php');