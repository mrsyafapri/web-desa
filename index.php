<?php
require_once __DIR__ . "/includes/configuration.php";
require_once __DIR__ . "/includes/class.php";
require_once __DIR__ . "/includes/function.php";

$app = new WebApplication($cfg);
$content = $app->loadController();

require_once __DIR__ . "/templates/public.page.php";
