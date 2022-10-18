<?php
/**
 * @by ProfStep, inc. 28.12.2020
 * @website: https://profstep.com
 **/

require_once("./model/Page.php");

use nmvcsite\model\Page;

$page = new Page();

$nav = $page->loadNavBar();

include('view/errors/v_404.php');