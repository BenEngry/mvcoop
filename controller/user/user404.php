<?php

require_once("./model/Page.php");

use nmvcsite\model\Page;

$title = __('Error 404');
$page = new Page();

$nav = $page->loadNavBar();

include('view/base/v_header.php');
include('view/base/v_content.php');
include('view/user/v_user404.php');
include('view/base/v_footer.php');