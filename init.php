<?php
declare(strict_types=1);
/**
 * @by ProfStep, inc. 28.12.2020
 * @website: https://profstep.com
 **/

const HOST = 'http://nmvc.site';
const BASE_URL = '/';

const DB_HOST = 'localhost';
const DB_DATABASE_NAME = 'mvc';
const DB_USER = 'root';
const DB_PASS = '';

include_once('core/bootstrap.php');
include_once('core/arr.php');
include_once('core/db.php');
include_once('core/system.php');

include_once('model/messages.php');
include_once('model/register.php');
include_once('model/login.php');