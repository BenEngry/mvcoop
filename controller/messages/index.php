<?php
$title = __('Chat List');
$messages = $mes->getMessages();

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

if(count($_POST)) {
    $result = $mes->changeMessage($fields);
    $_SESSION['is_message_added'] = $result;
    header('Location: ' . HOST . BASE_URL);
    exit;
}

include('view/base/v_header.php');
include('view/base/v_content.php');
include('view/messages/v_index.php');
include('view/base/v_footer.php');
