<?php


require_once("./model/Admin.php");
require_once("./model/Page.php");

use nmvcsite\model\Page;
use nmvcsite\model\Admin;
use nmvcsite\model\User;

if ($_SESSION['user_data']['opportunity']['promoteUser'] != 1) {
    header('Location: ' . HOST . BASE_URL);
    exit;
}

$title = __('Promotions');

$fieldsNotCleaned = $_POST;
$neededFieldsArray = [];

/** extract */
$fields = extractFields($_POST, $neededFieldsArray);
/**  validate */

$admin = new Admin($connect, $pdo);
$page = new Page();

$nav = $page->loadNavBar();
if (isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && "XMLHttpRequest" === $_SERVER["HTTP_X_REQUESTED_WITH"]) {
    header("Content-type: application/json");
    exit;
}

include('view/base/v_header.php');
include('view/base/v_content.php');
include('view/promotion/v_promotions.php');
include('view/base/v_footer.php');