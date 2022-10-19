<?php

require_once("./model/Admin.php");
require_once("./model/Page.php");

use nmvcsite\model\Admin;
use nmvcsite\model\Page;

if ($_SESSION['user_data']['opportunity']['promoteUser'] != 1) {
    header('Location: ' . HOST . BASE_URL);
    exit;
}

$title = __('Opportunity');

$fieldsNotCleaned = $_POST;
$neededFieldsArray = ['id', 'oppor', 'action'];

/** extract */
$fields = extractFields($_POST, $neededFieldsArray);
/**  validate */

$admin = new Admin($connect, $pdo);
$page = new Page();

$nav = $page->loadNavBar();

$table = $admin->getPageOpportunity(isset($_GET["p"]) ? $_GET["p"] : 1);
$paggination = $admin->pagination($admin->getNumPages("users"), "opportunity");

if (isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && "XMLHttpRequest" === $_SERVER["HTTP_X_REQUESTED_WITH"]) {
    header("Content-type: application/json");
    if ($fields["id"]) {
        echo json_encode($admin->changeOpportunity($fields["id"], $fields["action"], $fields["oppor"]));
    }
    exit;
}

include('view/base/v_header.php');
include('view/base/v_content.php');
include('view/opportunity/v_opportunity.php');
include('view/base/v_pre_footer.php');
include('view/script/jquery.php');
include('view/script/oppor.php');
include('view/base/v_after_footer.php');