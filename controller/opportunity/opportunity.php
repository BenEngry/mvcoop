<?php

require_once("./model/Admin.php");
require_once("./model/Page.php");

use nmvcsite\model\Admin;
use nmvcsite\model\Page;

$title = __('Opportunity');

$fieldsNotCleaned = $_POST;
$neededFieldsArray = ['id'];

/** extract */
$fields = extractFields($_POST, $neededFieldsArray);
/**  validate */

$admin = new Admin($connect, $pdo);
$page = new Page();

$fff = $page->loadNavBar();

$table = $admin->getPageOpportunity(isset($_GET["p"]) ? $_GET["p"] : 1);
$paggination = $admin->pagination($admin->getNumPages("users"), "opportunity");

if (isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && "XMLHttpRequest" === $_SERVER["HTTP_X_REQUESTED_WITH"]) {
    header("Content-type: application/json");

    exit;
}

include('view/base/v_header.php');
include('view/base/v_content.php');
include('view/opportunity/v_opportunity.php');
include('view/base/v_footer.php');