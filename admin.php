<?php
require_once __DIR__ . "/includes/configuration.php";
require_once __DIR__ . "/includes/class.php";
require_once __DIR__ . "/includes/function.php";

$app = new WebApplication($cfg);
if ($app->getUser()->id == 0) {
    header("Location:" . $app->siteUrl);
}
$content = $app->loadController();

require_once __DIR__ . "/templates/admin.page.php";
