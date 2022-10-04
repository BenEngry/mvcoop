<?php


require_once("./model/Admin.php");

use nmvcsite\model\Admin;
use nmvcsite\model\User;

$title = __('Promotions');

$fieldsNotCleaned = $_POST;
$neededFieldsArray = [];

/** extract */
$fields = extractFields($_POST, $neededFieldsArray);
/**  validate */

$admin = new Admin($connect);

if (isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && "XMLHttpRequest" === $_SERVER["HTTP_X_REQUESTED_WITH"]) {
    header("Content-type: application/json");
    exit;
}

include('view/base/v_header.php');
include('view/base/v_content.php');
include('view/promotion/v_promotions.php');
include('view/base/v_footer.php');