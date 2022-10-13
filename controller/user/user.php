<?php

require_once("./model/User.php");

use nmvcsite\model\User;

$title = __('User');

$fieldsNotCleaned = $_POST;
$neededFieldsArray = ['id'];
$viewRole = $_SESSION["user_data"]["role"];

/** extract */
$fields = extractFields($_POST, $neededFieldsArray);
/**  validate */

$user = new User($connect, $pdo);

if(isset($_GET["id"]) and $_GET["id"]) {
    $page = $user->loadUserPage($_GET["id"]);
    $actions = $viewRole ? $user->loadActions($_GET["id"]) : "";
    $stat = $viewRole > 0 ? $user->loadStat($_GET["id"]) : "";
}

if (isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && "XMLHttpRequest" === $_SERVER["HTTP_X_REQUESTED_WITH"]) {
    header("Content-type: application/json");
    exit;
}

include('view/base/v_header.php');
include('view/base/v_content.php');
include('view/user/v_userpage.php');
include('view/base/v_footer.php');