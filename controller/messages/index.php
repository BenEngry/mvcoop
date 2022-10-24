<?php
$title = __('Chat List');
$messages = $mes->loadMessages($_GET["p"] ?: 1);

require_once("./model/Page.php");
require_once("./model/Admin.php");

use nmvcsite\model\Page;
use nmvcsite\model\Admin;

$admin = new Admin($connect, $pdo);

$pagination = $admin->pagination($admin->getNumPages("messages"), "");

$successText = false;
if (isset($_SESSION['is_message_added']) && $_SESSION['is_message_added']) {
    $successText = true;
    unset($_SESSION['is_message_added']);
}   

$fieldsNotCleaned = $_POST;
$neededFieldsArray = ['name', 'title', 'message', 'id'];

/** extract */
$fields = extractFields($_POST, $neededFieldsArray);

$validateErrors = $_POST?$mes->messagesValidate($fields):[];
$page = new Page();

$nav = $page->loadNavBar();

if(count($_POST)) {
    $result = $mes->changeMessage($fields);
    $_SESSION['is_message_added'] = $result;
    header('Location: ' . HOST . BASE_URL);
    exit;
}

if (isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && "XMLHttpRequest" === $_SERVER["HTTP_X_REQUESTED_WITH"]) {
    header("Content-type: application/json");
    if ($fields["type"] === "del") {
        echo json_encode($mes->delMessage($fields["id"]));
    }
    if ($fields["type"] === "edit") {
//        echo json_encode();
    }
    exit;
}

include('view/base/v_header.php');
include('view/base/v_content.php');
include('view/messages/v_index.php');
include('view/base/v_pre_footer.php');
include('view/script/jquery.php');
include('view/script/messages.php');
include('view/base/v_after_footer.php');
