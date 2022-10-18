<?php

require_once("./model/Page.php");
use nmvcsite\model\Page;

$title = __('Register');
$content = __('Content');

$fieldsNotCleaned = $_POST;
$neededFieldsArray = ['name', 'email', 'password'];

/** extract */
$fields = array_merge(extractFields($_POST, $neededFieldsArray), ["email", "password"]); //??
/**  validate */

$validateErrors = $_POST?$auth->loginValidate($fields):[];
$page = new Page();

$nav = $page->loadNavBar();

if(empty($validateErrors) and count($_POST)) {
    $result = $auth->checkUser($fields);
    $_SESSION['is_user_logined'] = $result;
    if ($result) {
        header('Location: ' . HOST . BASE_URL);
    } else {
        header('Location: /login');
    }
    exit;
}

include('view/base/v_header.php');
include('view/reg/v_login.php');
include('view/base/v_footer.php');