<?php

require_once("./model/Page.php");

use nmvcsite\model\Page;

if ($_SESSION['user_data']['opportunity']['addComments'] != 1) {
    header('Location: ' . HOST . BASE_URL);
    exit;
}

$title = __('Add message');

$fieldsNotCleaned = $_POST;
$neededFieldsArray = ['name', 'title', 'message'];

/** extract */
$fields = extractFields($_POST, $neededFieldsArray);
/**  validate */

$page = new Page();

$nav = $page->loadNavBar();

$validateErrors = $_POST?$mes->messagesValidate($fields):[];
if(empty($validateErrors) and count($_POST)) {
    $result = $mes->setMessage($fields);
    $_SESSION['is_message_added'] = $result;
    header('Location: ' . HOST . BASE_URL);
    exit;
}

include('view/base/v_header.php');
include('view/base/v_content.php');
include('view/messages/v_add.php');
include('view/base/v_footer.php');





