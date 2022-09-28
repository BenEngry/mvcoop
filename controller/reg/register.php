<?php

$title = __('Register');
$content = __('Content');

$fieldsNotCleaned = $_POST;
$neededFieldsArray = ['name', 'email', 'password'];

/** extract */
$fields = extractFields($_POST, $neededFieldsArray);
/**  validate */

$validateErrors = $_POST?$auth->registerValidate($fields):[];

if(empty($validateErrors) and count($_POST)) {
    $result = $auth->setUser($fields);
    $_SESSION['is_user_logined'] = $result;
    header('Location: ' . HOST . BASE_URL);
    exit;
}

include('view/base/v_header.php');
include('view/reg/v_register.php');
include('view/reg/v_reglogfooter.php');