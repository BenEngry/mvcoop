<?php

require_once("./model/Page.php");

use nmvcsite\model\Page;

$title = __('Contacts');

$fieldsNotCleaned = $_POST;
$neededFieldsArray = ['name', 'title', 'message'];

$page = new Page();

$nav = $page->loadNavBar();

/** extract */
$fields = extractFields($_POST, $neededFieldsArray);
/**  validate */

include('view/base/v_header.php');
include('view/base/v_content.php');
include('view/contacts/v_contactscontent.php');
include('view/base/v_footer.php');

