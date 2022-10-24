<?php
declare(strict_types=1);
/**
 * @by ProfStep, inc. 28.12.2020
 * @website: https://profstep.com
 **/

$xml = simplexml_load_file("./assets/settings/init.xml");

//$var = $xml->host;
//const HOST = $xml->host; ????

const HOST = 'http://nmvc.site';
const BASE_URL = '/';

const DB_HOST = 'localhost';
const DB_DATABASE_NAME = 'mvc';
const DB_USER = 'root';
const DB_PASS = '';
const DB_CHARSET = 'uft-8';
const DB_OPTIONS = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

include_once('core/bootstrap.php');
include_once('core/arr.php');
include_once('core/db.php');
include_once('core/system.php');

include_once('model/messages.php');
include_once('model/register.php');
include_once('model/login.php');