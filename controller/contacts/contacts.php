<?php

$title = __('Contacts');

$fieldsNotCleaned = $_POST;
$neededFieldsArray = ['name', 'title', 'message'];

/** extract */
$fields = extractFields($_POST, $neededFieldsArray);
/**  validate */

include('view/base/v_header.php');
include('view/contacts/v_contacts.php');
include('view/contacts/v_contactscontent.php');
include('view/base/v_footer.php');

