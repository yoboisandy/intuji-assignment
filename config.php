<?php
require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

define('BASE_URL', $_ENV['BASE_URL']);
define('GOOGLE_CLIENT_ID', $_ENV['GOOGLE_CLIENT_ID']);
define('GOOGLE_CLIENT_SECRET', $_ENV['GOOGLE_CLIENT_SECRET']);
define('GOOGLE_OAUTH_SCOPE', $_ENV['GOOGLE_OAUTH_SCOPE']);
define('REDIRECT_URI', $_ENV['REDIRECT_URI']);

$googleOAuthUrl = "https://accounts.google.com/o/oauth2/auth?client_id=" . GOOGLE_CLIENT_ID . "&redirect_uri=" . REDIRECT_URI . "&scope=" . GOOGLE_OAUTH_SCOPE . "&response_type=code&access_type=online";
