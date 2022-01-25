<?php declare(strict_types=1);
define("PUBLIC", __DIR__);
define("ROOT", str_replace("/public", "", __DIR__));
require ROOT . "/vendor/autoload.php";

use App\App;

$dotenv = Dotenv\Dotenv::createImmutable(ROOT);
$dotenv->load();

App::run();